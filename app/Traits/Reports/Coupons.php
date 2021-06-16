<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Coupons
{
    function getPrintedCoupons()
    {
        $extDb = DB::connection('tokencash');
        $coupons = $extDb->table('dat_cupones')
                    ->join('dat_cupones_adicional', 'dat_cupones.CUP_ID', '=', 'dat_cupones_adicional.CUP_ADI_CUPON')
                    ->select(DB::raw('DATE_FORMAT(CUP_TS, "%Y/%m/%d") DIA, COUNT(CUP_ID) CUPONES, SUM(CUP_ADI_AMOUNT) MONTO'))
                    ->where('CUP_PRESUPUESTO', '=', 'supra')
                    ->whereBetween('CUP_TS', ['2021-06-01', '2021-06-16'])
                    ->groupBy('DIA', 'CUP_PRESUPUESTO')
                    ->orderBy('DIA')
                    ->get()
                    ->toArray();
        return $coupons;
    }
}

