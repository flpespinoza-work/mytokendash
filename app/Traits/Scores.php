<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;

trait Scores
{
    function getScores()
    {
        $scores = [];
        $initialDate = '2021-07-01';
        $finalDate = '2021-07-06';
        if($finalDate < '2021-06-10')
        {
            $scores = $this->getOldScores();
        }
        elseif($initialDate > '2021-06-10')
        {
            $scores = $this->getNewScores();
        }
        else
        {

        }

        return $scores;
    }

    function getNewScores()
    {
        $extDb = DB::connection('tokencash');
        $commentsArr = [];
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-06 23:59:59';
        $bolsas = ['GIFTCARD_SUPRA'];
        $presupuestos = ['PRESUPUESTO_supra'];
        $reportId = md5(session()->getId());

        $commentsArr = cache()->remember('lista-comentarios-' . $reportId, 60*5, function() use($extDb, $initialDate, $finalDate, $bolsas, $presupuestos){
            $tmpRes = [];
            $totalComments = 0;
            $extDb->table('dat_comentarios')
            ->join('doc_dbm_ventas', 'doc_dbm_ventas.VEN_ID', '=', 'dat_comentarios.COM_VENTA_ID')
            ->join('cat_dbm_nodos_usuarios', 'dat_comentarios.COM_USUARIO_ID', '=', 'cat_dbm_nodos_usuarios.NOD_USU_ID')
            ->select(DB::raw('VEN_FECHA_HORA, COM_FECHA_HORA, NOD_USU_NODO, COM_ESTABLECIMIENTO_ID, COM_COMENTARIO, COM_CALIFICACION, COM_VENDEDOR, COM_TIPO, COM_ADICIONAL_ID'))
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereIn('VEN_BOLSA', $bolsas)
            ->orWhereIn('VEN_BOLSA', $presupuestos)
            ->whereBetween('VEN_FECHA_HORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->orderBy('VEN_FECHA_HORA')
            ->chunk(10, function($comments) use(&$tmpRes, &$totalComments) {
                foreach($comments as $comment)
                {
                    $totalComments += 1;
                    $tmpRes['COMMENTS'][] = [
                        'TIPO' => 'NUEVO',
                        'FECHA_COMENTARIO' => $comment->COM_FECHA_HORA,
                        'FECHA_VENTA' => $comment->VEN_FECHA_HORA,
                        'USUARIO' => $comment->NOD_USU_NODO,
                        'ESTABLECIMIENTO' => $comment->COM_ESTABLECIMIENTO_ID,
                        'TIPO_VENTA' => $comment->COM_TIPO,
                        'COMENTARIO' => $comment->COM_COMENTARIO,
                        'CALIFICACION' => $comment->COM_CALIFICACION,
                        'VENDEDOR' => $comment->COM_VENDEDOR,
                        'ADICIONAL' => $comment->COM_ADICIONAL_ID
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totalComments;
            return $tmpRes;
        });

        dd($commentsArr);

        return $commentsArr;
    }

    function getOldScores()
    {
        $extDb = DB::connection('tokencash');
        $usersArr = [];
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-05 23:59:59';
        $bolsas = ['GIFTCARD_SUPRA'];
        $reportId = md5(session()->getId());

        $usersArr = cache()->remember('reporte-usuarios-' . $reportId, 60*5, function() use($extDb, $initialDate, $finalDate, $bolsas){
            $tmpRes = [];
            $totalUsers = 0;
            $extDb->table('cat_dbm_nodos_usuarios')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('DATE_FORMAT(TAE_SAL_TS, "%Y/%m/%d") DIA, COUNT(NOD_USU_ID) USUARIOS'))
            ->whereIn('TAE_SAL_BOLSA', $bolsas)
            ->whereBetween('TAE_SAL_TS', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('DIA')
            ->groupBy('TAE_SAL_BOLSA')
            ->orderBy('DIA')
            ->chunk(10, function($users) use(&$tmpRes, &$totalUsers) {
                foreach($users as $user)
                {
                    $totalUsers += $user->USUARIOS;
                    $tmpRes['USUARIOS'][$user->DIA] = $user->USUARIOS;
                }
            });
            $tmpRes['TOTALS'] = $totalUsers;
            return $tmpRes;
        });
        return $usersArr;
    }

    function orderScores()
    {

    }
}
