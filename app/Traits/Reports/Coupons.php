<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Coupons
{

    function getRedemedCouponsDetail($establecimiento, $initialDate, $finalDate, $period = false)
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];

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

        $presupuestos = fn_obtener_presupuestos($establecimiento);
        $bolsas = fn_obtener_giftcards($establecimiento);
        $reportId = fn_generar_reporte_id( $establecimiento . strtotime($initialDate) . strtotime($finalDate) );
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);

        $couponsArr = cache()->remember('reporte-cupones-canjeados-detallado-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $presupuestos, $bolsas){
            $tmpRes = [];
            $totales = [ 'redeemed_coupons' => 0, 'redeemed_ammount' => 0];

            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('NOD_USU_NODO USUARIO_NODO, CUP_CAN_FECHAHORA CANJE_FECHA_HORA, CUP_CAN_MONTO CANJE_MONTO, CUP_GIFTCARD GIFTCARD_CUPON, TAE_SAL_MONTO SALDO_USUARIO, CUP_CODIGO CODIGO_CUPON, CUP_TS CUPON_FECHA_HORA, CUP_CAN_ID ID_CUPON'))
            ->whereIn('CUP_PRESUPUESTO', $presupuestos)
            ->whereIn('TAE_SAL_BOLSA', $bolsas)
            ->whereBetween('CUP_CAN_FECHAHORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->orderBy('CUPON_FECHA_HORA')
            ->orderBy('USUARIO_NODO')
            ->orderBy('CANJE_FECHA_HORA', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['redeemed_coupons'] += 1;
                    $totales['redeemed_ammount'] += $coupon->CANJE_MONTO;

                    $tmpRes['REGISTROS'][] = [
                        'USUARIO_NODO' => $coupon->USUARIO_NODO,
                        'CODIGO_CUPON' => $coupon->CODIGO_CUPON,
                        'CUPON_FECHA_HORA' => $coupon->CUPON_FECHA_HORA,
                        'CANJE_FECHA_HORA' => $coupon->CANJE_FECHA_HORA,
                        'CANJE_MONTO' => $coupon->CANJE_MONTO,
                        'SALDO_USUARIO' => $coupon->SALDO_USUARIO,
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totales;
            $tmpRes['TOTALS']['average_ammount'] = $totales['redeemed_ammount'] / $totales['redeemed_coupons'];
            return $tmpRes;
        });

        return mb_convert_encoding($couponsArr, 'UTF-8', 'UTF-8');
    }

    function getLastPrintedCoupon()
    {
        $extDb = DB::connection('tokencash');
        $presupuestos = ['supra', 'SEND', 'isspx', 'smm', 'sasientos', 'recompensaRPSABALO', 'SETZPRE', '256826', 'REDPETROILFORESTA', 'rpetrohero', '264305', '264307', '266157',
        '268342', '270572', '273324', '277293', '278054', '278055', '278056', '278057', '279277', '282070', '282797', '284236', '286528', '290484', '290486', '290950', '292740', '292742',
        '293819', '296011'];
        $reportId = md5(session()->getId());
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-ultimo-cupon-' . $reportId, 60*5, function() use($extDb, $presupuestos){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->select(DB::raw('MAX(DATE_FORMAT(CUP_TS, "%Y/%m/%d %H:%i:%s")) DIA, CUP_GIFTCARD, CUP_PRESUPUESTO'))
            ->whereIn('CUP_PRESUPUESTO', $presupuestos)
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('DIA', 'DESC')
            ->chunk(5, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes['REGISTROS'][] = [
                        'DIA' => $coupon->DIA,
                        'GIFTCARD' => $coupon->CUP_GIFTCARD,
                        'PRESUPUESTO' => $coupon->CUP_PRESUPUESTO
                    ];
                }
            });
            return $tmpRes;
        });
        return $couponsArr;
    }

    function getPrintedRedeemedCoupons($establecimiento, $initialDate, $finalDate, $period)
    {
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

        $reportId = fn_generar_reporte_id($finalDate);
        $couponsArr = cache()->remember('reporte-cupones-impresos-canjeados', $reportId, function() use($establecimiento, $initialDate, $finalDate) {
            $printed = $this->getPrintedCoupons($establecimiento, $initialDate, $finalDate);
            $redeemed = $this->getRedeemedCoupons($establecimiento, $initialDate, $finalDate);
            $tmpResult = array_merge_recursive($printed, $redeemed);
            //Convertir en un array unico por dia con impresos y canjeados
            foreach($tmpResult['REGISTROS'] as $dia => $registro )
            {
                $result['REGISTROS'][$dia] = [
                    'DIA' => $dia,
                    'CUPONES' => $registro['CUPONES'],
                    'MONTO_IMPRESO' => $registro['MONTO_IMPRESO'],
                    'CANJES' => $registro['CANJES'],
                    'MONTO_CANJE' => $registro['MONTO_CANJE'],
                ];
            }

            $result['TOTALS'] = [
                'printed_coupons' => $tmpResult['TOTALS']['printed_coupons'],
                'printed_ammount' => $tmpResult['TOTALS']['printed_ammount'],
                'redeemed_coupons' => $tmpResult['TOTALS']['redeemed_coupons'],
                'redeemed_ammount' => $tmpResult['TOTALS']['redeemed_ammount'],
                'average_printed_ammount' => $tmpResult['TOTALS']['average_ammount'][0],
                'average_redeemed_ammount' => $tmpResult['TOTALS']['average_ammount'][1],
            ];
            return $result;
        });

        return $couponsArr;
    }

    function getPrintedRedeemedCouponsHistory($establecimiento)
    {
        $couponsArr = cache()->remember('reporte-cumulado-cupones-impresos-canjeados', 60*5, function() use($establecimiento) {
            $printed = $this->getPrintedCouponsHistory($establecimiento);
            $redeemed = $this->getRedemedCouponsHistory($establecimiento);
            $result = array_merge_recursive($printed, $redeemed);
            //Convertir en un array unico por dia con impresos y canjeados
            return $result;
        });

        return $couponsArr;
    }

    function getRedemedCouponsHistory($establecimiento)
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];
        $reportId = md5(session()->getId());
        $giftcards = fn_obtener_giftcards($establecimiento, true);

        $couponsArr = cache()->remember('reporte-cupones-canjeados-historico-' . $reportId, 60*5, function() use($extDb, $giftcards){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('COUNT(CUP_ID) CUPONES, SUM(CUP_CAN_MONTO) MONTO'))
            ->whereIn('CUP_GIFTCARD', $giftcards)
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('MONTO', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'CUPONES_CANJEADOS' => $coupon->CUPONES,
                        'MONTO_CANJEADO' => $coupon->MONTO,
                        'PROMEDIO_CANJE' => $coupon->MONTO / $coupon->CUPONES
                    ];
                }
            });

            return $tmpRes;
        });

        return $couponsArr;
    }

    function getPrintedCouponsHistory($establecimiento)
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];
        $presupuestos = fn_obtener_presupuestos($establecimiento);
        $reportId = md5(session()->getId());

        $couponsArr = cache()->remember('reporte-cupones-acumulados-impresos-' . $reportId, 60*5, function() use($extDb, $presupuestos){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
            ->select(DB::raw('COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
            ->whereIn('CUP_PRESUPUESTO', $presupuestos)
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('MONTO', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'CUPONES_IMPRESOS' => $coupon->CUPONES,
                        'MONTO_IMPRESO' => $coupon->MONTO,
                        'PROMEDIO_IMPRESO' => $coupon->MONTO / $coupon->CUPONES
                    ];
                }
            });

            return $tmpRes;
        });
        return $couponsArr;
    }

    function getTodayRedeemedCoupons()
    {
        $extDb = DB::connection('tokencash');
        $initialDate = date('Y-m-d 00:00:00');
        $finalDate = date('Y-m-d H:i:s');
        $giftcards = ['SUPRA'];
        $couponsArr = [];

        $couponsArr = $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('CUP_GIFTCARD GIFTCARD, COUNT(CUP_ID) CANJES, SUM(CUP_CAN_MONTO) MONTO'))
            ->whereIn('CUP_GIFTCARD', $giftcards)
            ->whereBetween('CUP_CAN_FECHAHORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('GIFTCARD')
            ->get();
        return $couponsArr;
    }

    function getRedeemedCoupons($establecimiento, $initialDate, $finalDate, $period = false)
    {
        $extDb = DB::connection('tokencash');
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

        $reportId = fn_generar_reporte_id($finalDate);
        $giftcards = fn_obtener_giftcards($establecimiento, true); //SUPRA, sin GIFTCARD_
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);
        $couponsArr = [];
        $couponsArr = cache()->remember('reporte-cupones-canjeados-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $giftcards){
            $tmpRes = [];
            $totales = [ 'redeemed_coupons' => 0, 'redeemed_ammount' => 0];

            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(CUP_CAN_FECHAHORA, "%d/%m/%Y") DIA, COUNT(CUP_ID) CANJES, SUM(CUP_CAN_MONTO) MONTO'))
            ->whereIn('CUP_GIFTCARD', $giftcards)
            ->whereBetween('CUP_CAN_FECHAHORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('DIA', 'CUP_GIFTCARD')
            ->orderBy('DIA')
            ->chunk(10, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['redeemed_coupons'] += $coupon->CANJES;
                    $totales['redeemed_ammount'] += $coupon->MONTO;

                    $tmpRes['REGISTROS'][$coupon->DIA] = [
                        'DIA' => $coupon->DIA,
                        'CANJES' => $coupon->CANJES,
                        'MONTO_CANJE' => $coupon->MONTO
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totales;
            $tmpRes['TOTALS']['average_ammount'] = $totales['redeemed_ammount'] / $totales['redeemed_coupons'];
            return $tmpRes;
        });

        return $couponsArr;
    }

    function getTodayPrintedDetailCoupons($presupuestos)
    {
        $extDb = DB::connection('tokencash');
        $presupuestos = ['supra'];
        $couponsArr = [];

        $couponsArr = $extDb->table('dat_cupones')
        ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
        ->select(DB::raw('DATE_FORMAT(CUP_TS, "%H") TIEMPO_CUPON, CUP_PRESUPUESTO PRESUPUESTO, COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
        ->whereIn('CUP_PRESUPUESTO', $presupuestos)
        ->whereRaw('CUP_TS BETWEEN CONCAT(CURRENT_DATE(), " 00:00:00") AND NOW()')
        ->groupBy('CUP_PRESUPUESTO')
        ->groupBy('TIEMPO_CUPON')
        ->orderBy('TIEMPO_CUPON')
        ->get();

        return $couponsArr;
    }

    function getTodayPrintedCoupons($presupuestos)
    {
        $extDb = DB::connection('tokencash');
        $initialDate = date('Y-m-d 00:00:00');
        $finalDate = date('Y-m-d H:i:s');
        $presupuestos = ['supra'];
        $couponsArr = [];

        $couponsArr = $extDb->table('dat_cupones')
        ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
        ->select(DB::raw('CUP_PRESUPUESTO PRESUPUESTO, COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
        ->whereIn('CUP_PRESUPUESTO', $presupuestos)
        ->whereBetween('CUP_TS', [$initialDate, $finalDate])
        ->groupBy('CUP_PRESUPUESTO')
        ->orderBy('CUP_PRESUPUESTO')
        ->get();

        return $couponsArr;
    }

    function getPrintedCoupons($establecimiento, $initialDate, $finalDate, $period = false)
    {
        $extDb = DB::connection('tokencash');
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

        $presupuestos = fn_obtener_presupuestos($establecimiento); //['supra']
        $reportId = fn_generar_reporte_id( $establecimiento . strtotime($initialDate) . strtotime($finalDate) );
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-impresos' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $presupuestos){
            $tmpRes = [];
            $totales = [ 'printed_coupons' => 0, 'printed_ammount' => 0];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
            ->select(DB::raw('DATE_FORMAT(CUP_TS, "%d/%m/%Y") DIA, COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
            ->whereIn('CUP_PRESUPUESTO', $presupuestos)
            ->whereBetween('CUP_TS', [$initialDate, $finalDate])
            ->groupBy('DIA', 'CUP_PRESUPUESTO')
            ->orderBy('DIA')
            ->orderBy('CUP_PRESUPUESTO')
            ->chunk(10, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['printed_coupons'] += $coupon->CUPONES;
                    $totales['printed_ammount'] += $coupon->MONTO;
                    $tmpRes['REGISTROS'][$coupon->DIA] = [
                        'DIA' => $coupon->DIA,
                        'CUPONES' => $coupon->CUPONES,
                        'MONTO_IMPRESO' => $coupon->MONTO
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totales;
            $tmpRes['TOTALS']['average_ammount'] = $totales['printed_ammount'] / $totales['printed_coupons'];
            return $tmpRes;
        });
        return $couponsArr;
    }
}

