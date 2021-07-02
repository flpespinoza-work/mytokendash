<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Coupons
{

    function getRedemedCouponsHistory()
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-canjeados-historico', 60*1, function() use($extDb){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->select(DB::raw('COUNT(CUP_ID) CUPONES, SUM(CUP_CAN_MONTO) MONTO'))
            ->whereIn('CUP_GIFTCARD', ['SUPRA'])
            ->groupBy('CUP_GIFTCARD')
            ->orderBy('MONTO', 'desc')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'COUNT' => $coupon->CUPONES,
                        'MONTO' => $coupon->MONTO
                    ];
                }
            });

            return $tmpRes;
        });

        dd($couponsArr);

        return $couponsArr;
    }


    function getRedemedCoupons()
    {
        $extDb = DB::connection('tokencash');
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-01 23:59:59';
        $reportId = md5($initialDate.$finalDate);
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-canjeados-' . $reportId, 60*1, function() use($extDb, $initialDate, $finalDate){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_canjeados', 'dat_cupones.CUP_ID', '=', 'dat_cupones_canjeados.CUP_CAN_CUPON')
            ->join('cat_dbm_nodos_usuarios', 'dat_cupones_canjeados.CUP_CAN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(CUP_CAN_FECHAHORA, "%Y/%m/%d") DIA, COUNT(CUP_ID) CUPONES, SUM(CUP_CAN_MONTO) MONTO, CUP_GIFTCARD GIFTCARD'))
            ->whereIn('CUP_GIFTCARD', ['SUPRA'])
            ->whereBetween('CUP_CAN_FECHAHORA', [$initialDate, $finalDate])
            ->whereRaw("BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]'")
            ->orWhere('NOD_USU_CERTIFICADO', '=', '')
            ->groupBy('DIA', 'GIFTCARD')
            ->orderBy('GIFTCARD')
            ->orderBy('DIA')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'GIFTCARD' => $coupon->GIFTCARD,
                        'DIA' => $coupon->DIA,
                        'CUPONES' => $coupon->CUPONES,
                        'MONTO' => $coupon->MONTO
                    ];
                }
            });

            return $tmpRes;
        });
        dd($couponsArr);
        return $couponsArr;
    }

    function getPrintedCouponsHistory()
    {
        $extDb = DB::connection('tokencash');
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-acumulados-impresos', 60*1, function() use($extDb){
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
                        'COUNT' => $coupon->CUPONES,
                        'MONTO' => $coupon->MONTO
                    ];
                }
            });

            return $tmpRes;
        });
        return $couponsArr;
    }

    function getPrintedCoupons()
    {
        $extDb = DB::connection('tokencash');
        $initialDate = '2021-06-01 00:00:00';
        $finalDate = '2021-06-16 23:59:59';
        $reportId = md5($initialDate.$finalDate);
        $couponsArr = [];

        $couponsArr = cache()->remember('reporte-cupones-impresos' . $reportId, 60*1, function() use($extDb, $initialDate, $finalDate){
            $tmpRes = [];
            $extDb->table('dat_cupones')
            ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
            ->select(DB::raw('DATE_FORMAT(CUP_TS, "%Y/%m/%d") DIA, COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
            ->whereIn('CUP_PRESUPUESTO', ['supra', 'isspx'])
            ->whereBetween('CUP_TS', [$initialDate, $finalDate])
            ->groupBy('DIA', 'CUP_PRESUPUESTO')
            ->orderBy('CUP_PRESUPUESTO')
            ->orderBy('DIA')
            ->chunk(10, function($coupons) use(&$tmpRes) {
                foreach($coupons as $coupon)
                {
                    $tmpRes[] = [
                        'DIA' => $coupon->DIA,
                        'CUPONES' => $coupon->CUPONES,
                        'MONTO' => $coupon->MONTO
                    ];
                }
            });

            return $tmpRes;
        });

        return $couponsArr;
    }
}

