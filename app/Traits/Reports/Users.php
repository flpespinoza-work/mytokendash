<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Users
{

    function getUsers($establecimiento, $initialDate, $finalDate)
    {
        $extDb = DB::connection('tokencash');
        $usersArr = [];
        $initialDate = date('Y-m-d', strtotime(str_replace("/", "-", $initialDate))) . ' 00:00:00';
        $finalDate = date('Y-m-d', strtotime(str_replace("/", "-", $finalDate))) . ' 23:59:59';
        $bolsas = fn_obtener_giftcards($establecimiento);
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);
        $reportId = fn_generar_reporte_id( $establecimiento . strtotime($initialDate) . strtotime($finalDate) );
        $usersArr = cache()->remember('reporte-usuarios-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $bolsas) {
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
                    $tmpRes['USUARIOS'][] = [
                        'DIA' => $user->DIA,
                        'USUARIOS' => $user->USUARIOS
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totalUsers;
            return $tmpRes;
        });
        return $usersArr;
    }

    function getUsersHistory($establecimiento)
    {
        $extDb = DB::connection('tokencash');
        $usersArr = [];
        $bolsas = fn_obtener_giftcards($establecimiento);
        $reportId = md5(session()->getId() . $establecimiento);

        $usersArr = cache()->remember('reporte-acumulado-usuarios-' . $reportId, 60*5, function() use($extDb, $bolsas){
            $tmpRes = [];
            $extDb->table('cat_dbm_nodos_usuarios')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('TAE_SAL_BOLSA BOLSA, SUM(TAE_SAL_MONTO) MONTO, COUNT(NOD_USU_ID) USUARIOS'))
            ->whereIn('TAE_SAL_BOLSA', $bolsas)
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('TAE_SAL_BOLSA')
            ->orderBy('TAE_SAL_BOLSA')
            ->chunk(10, function($users) use(&$tmpRes) {
                foreach($users as $user)
                {
                    $tmpRes['USUARIOS'][] = [
                        'USUARIOS' => $user->USUARIOS,
                        'MONTO' => $user->MONTO,
                        'PROMEDIO' => $user->MONTO / $user->USUARIOS
                    ];
                }
            });
            return $tmpRes;
        });

        return $usersArr;
    }
}

