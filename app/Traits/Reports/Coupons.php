<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Coupons
{

    function getRedemedCouponsDetail()
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-05 23:59:59';
        $reportId = md5(session()->getId() . $initialDate . $finalDate);

        $couponsArr = cache()->remember('reporte-cupones-canjeados-detallado-' . $reportId, 60*2, function() use($extDb, $initialDate, $finalDate){
            $tmpRes = [];
            $totales = [ 'redeemed_coupons' => 0, 'redeemed_ammount' => 0];

            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('NOD_USU_NODO USUARIO_NODO, NOD_USU_NOMBRE USUARIO_NOMBRE, NOD_USU_NUMERO USUARIO_NUMERO, CUP_CAN_FECHAHORA CANJE_FECHA_HORA, CUP_CAN_MONTO CANJE_MONTO, CUP_GIFTCARD GIFTCARD_CUPON, TAE_SAL_MONTO SALDO_USUARIO, CUP_CODIGO CODIGO_CUPON, CUP_TS CUPON_FECHA_HORA, CUP_CAN_ID ID_CUPON'))
            ->whereIn('CUP_PRESUPUESTO', ['supra'])
            ->whereIn('TAE_SAL_BOLSA', ['GIFTCARD_SUPRA'])
            ->whereBetween('CUP_CAN_FECHAHORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->orderBy('CUPON_FECHA_HORA')
            ->orderBy('USUARIO_NUMERO')
            ->orderBy('CANJE_FECHA_HORA', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['redeemed_coupons'] += 1;
                    $totales['redeemed_ammount'] += $coupon->CANJE_MONTO;

                    $tmpRes['REGISTROS'][] = [
                        'USUARIO_NODO' => $coupon->USUARIO_NODO,
                        'USUARIO_NOMBRE' => $coupon->USUARIO_NOMBRE,
                        'USUARIO_NUMERO' => $coupon->USUARIO_NUMERO,
                        'CANJE_FECHA_HORA' => $coupon->CANJE_FECHA_HORA,
                        'CANJE_MONTO' => $coupon->CANJE_MONTO,
                        'GIFTCARD_CUPON' => $coupon->GIFTCARD_CUPON,
                        'SALDO_USUARIO' => $coupon->SALDO_USUARIO,
                        'CODIGO_CUPON' => $coupon->CODIGO_CUPON,
                        'CUPON_FECHA_HORA' => $coupon->CUPON_FECHA_HORA,
                        'ID_CUPON' => $coupon->ID_CUPON
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totales;
            return $tmpRes;
        });

        return $couponsArr;
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
        dd($couponsArr);
        return $couponsArr;
    }

    function getPrintedRedeemedCoupons()
    {
        $couponsArr = cache()->remember('reporte-cupones-impresos-canjeados', 60*5, function() {
            $printed = $this->getPrintedCoupons();
            $redeemed = $this->getRedeemedCoupons();
            $result = array_merge_recursive($printed, $redeemed);
            //Convertir en un array unico por dia con impresos y canjeados
            return $result;
        });


        return $couponsArr;
    }

    function getPrintedRedeemedCouponsHistory()
    {
        $couponsArr = cache()->remember('reporte-cumulado-cupones-impresos-canjeados', 60*5, function() {
            $printed = $this->getPrintedCouponsHistory();
            $redeemed = $this->getRedemedCouponsHistory();
            $result = array_merge_recursive($printed, $redeemed);
            //Convertir en un array unico por dia con impresos y canjeados
            return $result;
        });

        return $couponsArr;
    }

    function getRedemedCouponsHistory()
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];
        $reportId = md5(session()->getId());

        $couponsArr = cache()->remember('reporte-cupones-canjeados-historico-' . $reportId, 60*5, function() use($extDb){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('COUNT(CUP_ID) CUPONES, SUM(CUP_CAN_MONTO) MONTO'))
            ->whereIn('CUP_GIFTCARD', ['SUPRA'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('MONTO', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'CUPONES_CANJEADOS' => $coupon->CUPONES,
                        'MONTO_CANJEADO' => $coupon->MONTO
                    ];
                }
            });

            return $tmpRes;
        });

        return $couponsArr;
    }

    function getPrintedCouponsHistory()
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];
        $reportId = md5(session()->getId());

        $couponsArr = cache()->remember('reporte-cupones-acumulados-impresos-' . $reportId, 60*5, function() use($extDb){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
            ->select(DB::raw('COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
            ->whereIn('CUP_PRESUPUESTO', ['supra'])
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('MONTO', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'CUPONES_IMPRESOS' => $coupon->CUPONES,
                        'MONTO_IMPRESO' => $coupon->MONTO
                    ];
                }
            });

            return $tmpRes;
        });
        return $couponsArr;
    }

    function getRedeemedCoupons()
    {
        $extDb = DB::connection('tokencash');
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-05 23:59:59';
        $reportId = md5(session()->getId() . $initialDate . $finalDate);
        $giftcards = ['SUPRA'];
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-canjeados-' . $reportId, 60*5, function() use($extDb, $initialDate, $finalDate, $giftcards){
            $tmpRes = [];
            $totales = [ 'redeemed_coupons' => 0, 'redeemed_ammount' => 0];

            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(CUP_CAN_FECHAHORA, "%Y/%m/%d") DIA, COUNT(CUP_ID) CANJES, SUM(CUP_CAN_MONTO) MONTO'))
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
                        'CANJES' => $coupon->CANJES,
                        'MONTO_CANJE' => $coupon->MONTO
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totales;
            return $tmpRes;
        });
        return $couponsArr;
    }

    function getPrintedCoupons()
    {
        $extDb = DB::connection('tokencash');
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-07 23:59:59';
        $presupuestos = ['supra'];
        $reportId = md5(session()->getId() . $initialDate . $finalDate);
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-impresos' . $reportId, 60*1, function() use($extDb, $initialDate, $finalDate, $presupuestos){
            $tmpRes = [];
            $totales = [ 'printed_coupons' => 0, 'printed_ammount' => 0];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
            ->select(DB::raw('DATE_FORMAT(CUP_TS, "%Y/%m/%d") DIA, COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
            ->whereIn('CUP_PRESUPUESTO', $presupuestos)
            ->whereBetween('CUP_TS', [$initialDate, $finalDate])
            ->groupBy('DIA', 'CUP_PRESUPUESTO')
            ->orderBy('CUP_PRESUPUESTO')
            ->orderBy('DIA')
            ->chunk(10, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['printed_coupons'] += $coupon->CUPONES;
                    $totales['printed_ammount'] += $coupon->MONTO;
                    $tmpRes['REGISTROS'][$coupon->DIA] = [
                        'CUPONES' => $coupon->CUPONES,
                        'MONTO_IMPRESO' => $coupon->MONTO
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totales;
            return $tmpRes;
        });

        return $couponsArr;
    }
}

