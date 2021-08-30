<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Balance
{

    function getBalance($establecimiento)
    {
        $extDb = DB::connection('tokencash');
        $balanceArr = [];
        $establecimientos = fn_obtener_nodo_establecimiento($establecimiento);
        $presupuestos = fn_obtener_presupuestos($establecimiento, true);
        $reportId = fn_generar_reporte_id($establecimiento);

        $balanceArr = cache()->remember('reporte-balance' . $reportId, 60*5, function() use($extDb, $establecimientos, $presupuestos){
            $tmpRes = [];
            $extDb->table('cat_dbm_nodos')
            ->join('bal_tae_saldos', 'cat_dbm_nodos.NOD_ID', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('NOD_ID, NOD_CODIGO, TAE_SAL_MONTO, TAE_SAL_NODO, TAE_SAL_BOLSA'))
            ->whereIn('TAE_SAL_NODO', $establecimientos)
            ->whereIn('TAE_SAL_BOLSA', $presupuestos)
            ->orderBy('TAE_SAL_NODO')
            ->chunk(10, function($balances) use(&$tmpRes) {
                foreach($balances as $balance)
                {
                    $tmpRes['BALANCES'][] = [
                        'NOD_ID' => $balance->NOD_ID,
                        'NOD_CODIGO' => $balance->NOD_CODIGO,
                        'TAE_SAL_MONTO' => $balance->TAE_SAL_MONTO,
                        'TAE_SAL_NODO' => $balance->TAE_SAL_NODO,
                        'TAE_SAL_BOLSA' => $balance->TAE_SAL_BOLSA
                    ];
                }
            });
            //dd($tmpRes);
            return $tmpRes;
        });


        return $balanceArr;
    }

}

