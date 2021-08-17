<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;

trait Scores
{
    function getScores($establecimiento, $initialDate, $finalDate, $period = false)
    {
        $scores = [];

        if($period)
        {
            $initialDate = date('Y-m-d', strtotime("-{$period} days")) . ' 00:00:00';
            $finalDate = date('Y-m-d H:i:s');
        }
        else
        {
            $initialDate = date('Y-m-d', strtotime(str_replace("/", "-", $initialDate))) . ' 00:00:00';
            $finalDate = date('Y-m-d', strtotime(str_replace("/", "-", $finalDate))) . ' 23:59:59';
        }

        $bolsas = fn_obtener_giftcards($establecimiento);
        $presupuestos = fn_obtener_presupuestos($establecimiento);

        if($finalDate < '2021-06-10')
        {
            $scores = $this->getOldScores($bolsas, $presupuestos, $initialDate, $finalDate);
        }
        elseif($initialDate > '2021-06-10')
        {
            $scores = $this->getNewScores($bolsas, $presupuestos, $initialDate, $finalDate);
        }
        else
        {
			$initial_a = $initialDate;
			$final_a = '2021-06-10 11:23:04';
			$initial_b = '2021-06-10 11:23:05';
			$final_b = $finalDate;
			$scores_a = $this->getOldScores($bolsas, $presupuestos, $initial_a, $final_a);
			$scores_b = $this->getNewScores($bolsas, $presupuestos, $initial_b, $final_b);

			//Unir los dos resultados
			$scores = array_merge($scores_a, $scores_b);
        }
        if(!empty($scores))
            $scores = $this->orderScores($scores, $finalDate);
        return $scores;
    }

    function getNewScores($bolsas, $presupuestos, $initialDate, $finalDate)
    {
        $extDb = DB::connection('tokencash');
        $commentsArr = [];
        $reportId = fn_generar_reporte_id( implode("",$bolsas) . implode("",$presupuestos) . strtotime($initialDate) . strtotime($finalDate) );
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);

        $commentsArr = cache()->remember('lista-comentarios-nuevos-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $bolsas, $presupuestos){
            $tmpRes = [];
            $extDb->table('dat_comentarios')
            ->join('doc_dbm_ventas', 'doc_dbm_ventas.VEN_ID', '=', 'dat_comentarios.COM_VENTA_ID')
            ->join('cat_dbm_nodos_usuarios', 'dat_comentarios.COM_USUARIO_ID', '=', 'cat_dbm_nodos_usuarios.NOD_USU_ID')
            ->select(DB::raw('VEN_FECHA_HORA, COM_FECHA_HORA, NOD_USU_NODO, COM_ESTABLECIMIENTO_ID, COM_COMENTARIO, COM_CALIFICACION, COM_VENDEDOR, COM_TIPO, COM_ADICIONAL_ID'))
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->where(function($query) use($bolsas, $presupuestos){
                $query->where('VEN_BOLSA', 'GIFTCARD_' . $bolsas[0])
                      ->orWhere('VEN_BOLSA', 'PRESUPUESTO_' . $presupuestos[0]);

            })
            ->whereBetween('VEN_FECHA_HORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->orderBy('VEN_FECHA_HORA', 'desc')
            ->chunk(10, function($comments) use(&$tmpRes) {
                foreach($comments as $comment)
                {
                    $tmpRes['COMMENTS'][] = [
                        'TIPO' => 'NUEVO',
                        'FECHA_COMENTARIO' => $comment->COM_FECHA_HORA,
                        'FECHA_VENTA' => $comment->VEN_FECHA_HORA,
                        'USUARIO' => $comment->NOD_USU_NODO,
                        'ESTABLECIMIENTO' => $comment->COM_ESTABLECIMIENTO_ID,
                        'TIPO_VENTA' => $comment->COM_TIPO,
                        'COMENTARIO' => trim($comment->COM_COMENTARIO),
                        'CALIFICACION' => $comment->COM_CALIFICACION,
                        'VENDEDOR' => $comment->COM_VENDEDOR,
                        'ADICIONAL' => $comment->COM_ADICIONAL_ID
                    ];
                }
            });

            return $tmpRes;

        });
        return mb_convert_encoding($commentsArr, 'UTF-8', 'UTF-8');
    }

    function getOldScores($bolsas, $presupuestos, $initialDate, $finalDate)
    {
        $extDb = DB::connection('tokencash');
        $commentsArr = [];
        $reportId = fn_generar_reporte_id( implode("",$bolsas) . implode("",$presupuestos) . strtotime($initialDate) . strtotime($finalDate) );
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);

        $commentsArr = cache()->remember('lista-comentarios-anterior-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $bolsas, $presupuestos){
            $tmpRes = [];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_DESTINO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('VEN_FECHA_HORA, VEN_TS, NOD_USU_NODO, VEN_DESTINO, VEN_ADICIONAL'))
            ->where(function($query) use($bolsas, $presupuestos){
                $query->whereIn('VEN_BOLSA', $bolsas)
                      ->orWhereIn('VEN_BOLSA', $presupuestos);
            })
            ->where(function($query){
                $query->where('VEN_ADICIONAL', 'like', '%CALIFICACION%')
                      ->orWhere('VEN_ADICIONAL', 'like', '%COMENTARIOS%');
            })
            ->whereBetween('VEN_FECHA_HORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->orderBy('VEN_FECHA_HORA', 'desc')
            ->chunk(10, function($comments) use($extDb, &$tmpRes) {
                foreach($comments as $comment)
                {
                    $tipoVta = '';
                    $vendedor = '';

                    //Tratar JSON si esta mal estructurado
                    $comment->VEN_ADICIONAL = str_replace('REFERENCIA":"', 'REFERENCIA": [', $comment->VEN_ADICIONAL);
                    $comment->VEN_ADICIONAL = str_replace('","RECOMPENSA_PERMANENTE', '],"RECOMPENSA_PERMANENTE', $comment->VEN_ADICIONAL);
                    $comment->VEN_ADICIONAL = str_replace('\\', '', $comment->VEN_ADICIONAL);
                    $comment->VEN_ADICIONAL = utf8_encode($comment->VEN_ADICIONAL);

                    //Convertir el adicional a array y obtener el tipo
                    $m_adicional = json_decode($comment->VEN_ADICIONAL, true);

                    if(isset($m_adicional['CUPON_ID']))
                    {
                        $tipoVta = 'CANJE';
                        $q = $extDb->table('dat_cupones_adicional')->select('CUP_ADI_NAME')->where('CUP_ADI_CUPON', $m_adicional['CUPON_ID'])->first();
                        $vendedor = $q->CUP_ADI_NAME;
                    }
                    elseif(isset($m_adicional['TOKEN']))
                    {
                        $tipoVta = 'PAGO';
                        $q = $extDb->table('dat_token_adicional')->select('TOK_ADI_NAME')->join('doc_tokens', 'dat_token_adicional.TOK_ADI_TOKEN', '=', 'doc_tokens.TOK_ID')->where('TOK_TOKEN', $m_adicional['TOKEN'])->first();
                        $vendedor = $q->TOK_ADI_NAME;
                    }

                    $tmpRes['COMMENTS'][] = [
                        'TIPO' => 'ANTERIOR',
                        'FECHA_VENTA' => $comment->VEN_FECHA_HORA,
                        'FECHA_COMENTARIO' => $comment->VEN_FECHA_HORA,
                        'USUARIO' =>$comment-> NOD_USU_NODO,
                        'ESTABLECIMIENTO' => $comment->VEN_DESTINO,
                        'TIPO_VENTA' => $tipoVta,
                        'COMENTARIO' => (isset($m_adicional['COMENTARIOS']))? trim($m_adicional['COMENTARIOS']) : '',
                        'CALIFICACION' => (isset($m_adicional['CALIFICACION']))? $m_adicional['CALIFICACION'] : '',
                        'VENDEDOR' => $vendedor,
                        'ADICIONAL' => $comment->VEN_ADICIONAL
                    ];
                }
            });
            return $tmpRes;

        });

        return mb_convert_encoding($commentsArr, 'UTF-8', 'UTF-8');
    }

    function orderScores($scoresArr, $finalDate)
    {
        //Ordenar por calificacion
        usort($scoresArr['COMMENTS'], function($a, $b){
            return $a['CALIFICACION'] <=> $b['CALIFICACION'];
        });

        //Ordernar comentarios por fecha
        usort($scoresArr['COMMENTS'], function($a, $b){
            return $a['FECHA_COMENTARIO'] < $b['FECHA_COMENTARIO'];
        });

        //Puntuacion para calificaciones
        $a_calificacionValor =
        [
            "score_5" => 5,
            "score_4" => ($finalDate <= '2019-10-08') ? 2.5 : 3,
            "score_3" => 1,
            "score_2" => 0.5,
            "score_1" => -8
        ];

        $commentRow = 0;
        $commentsMax = 10000;
        $stars = array
        (
			"stars_1" => 0,
			"stars_2" => 0,
			"stars_3" => 0,
			"stars_4" => 0,
			"stars_5" => 0,
			"stars_N" => 0,
			"totalScores" => 0,
			"totalStars" => 0,
			"count5" => 0,
			"count4" => 0,
			"count3" => 0,
			"count2" => 0,
			"count1" => 0,
			"count0" => 0,
			"countX" => 0
		);

        //Recorrer comentarios y obtener totales
        foreach($scoresArr['COMMENTS'] as $comment)
        {
            $commentRow++;
            if($comment['CALIFICACION'] >= 1)
            {
                $stars['totalScores']++;
                $stars['totalStars'] += $a_calificacionValor["score_{$comment['CALIFICACION']}"];
                $stars['stars_' . $comment['CALIFICACION']]++;

                if(isset($comment['COMENTARIO']) && !empty($comment['COMENTARIO']))
                {
                    $stars['count' . $comment['CALIFICACION']]++;
                    if(!str_contains('Escribe tus comentarios aquí', $comment['COMENTARIO']))
                        $stars['comments'][$comment['CALIFICACION']][] = $comment;
                }
            }
            elseif((isset($comment['COMENTARIO']) && !empty($comment['COMENTARIO'])) && $commentRow < $commentsMax)
            {
                $stars['stars_N']++;
                $stars['count0']++;
                if(!str_contains('Escribe tus comentarios aquí', $comment['COMENTARIO']))
                    $stars['comments']['0'][] = $comment;
            }

        }

        if($stars['totalStars'] > 0)
        {
            $stars['maxScore'] = $stars['totalScores'] * 5;
            $scorePromedio = ($stars['totalStars'] / $stars['maxScore']) * 100;
            $stars['scorePromedio'] = number_format($scorePromedio, 2);
        }

        //Ordenar comantarios en stars
        uksort($stars['comments'], function($a, $b){
            return $a < $b;
        });

        return $stars;
    }
}
