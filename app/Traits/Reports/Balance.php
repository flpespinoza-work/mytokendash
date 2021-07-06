<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Balance
{

    function getBalance()
    {
        $extDb = DB::connection('tokencash');
        $balanceArr = [];
        $establecimientos = [242624, 245928, 245929, 235130, 252364, 256695, 259951, 254437, 282666, 261241, 249553, 284105, 264174, 264176, 266026, 268211, 273193, 242948, 270441, 277923, 277924, 277925, 277926, 279146, 277162, 281939, 286397, 286397, 290353, 290355, 290819, 292609, 292611, 293687, 295878];
        $presupuestos = ["PRESUPUESTO_supra", "PRESUPUESTO_isspx", "PRESUPUESTO_smm", "PRESUPUESTO_SENZACAFFE", "PRESUPUESTO_recompensaRPSABALO", "PRESUPUESTO_256826", "PRESUPUESTO_REDPETROILFORESTA", "PRESUPUESTO_SETZPRE", "PRESUPUESTO_282797", "PRESUPUESTO_rpetrohero", "PRESUPUESTO_sasientos", "PRESUPUESTO_284236", "PRESUPUESTO_264305", "PRESUPUESTO_264307", "PRESUPUESTO_266157", "PRESUPUESTO_268342", "PRESUPUESTO_273324", "PRESUPUESTO_SEND", "PRESUPUESTO_270572", "PRESUPUESTO_278054", "PRESUPUESTO_278055", "PRESUPUESTO_278056", "PRESUPUESTO_278057", "PRESUPUESTO_279277", "PRESUPUESTO_277293", "PRESUPUESTO_282070", "PRESUPUESTO_286528", "PRESUPUESTO_286528", "PRESUPUESTO_290484", "PRESUPUESTO_290486", "PRESUPUESTO_290950", "PRESUPUESTO_292740", "PRESUPUESTO_292742", "PRESUPUESTO_293819", "PRESUPUESTO_296011"];
        $reportId = md5(session()->getId());

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

            return $tmpRes;
        });


        return $balanceArr;
    }

}

