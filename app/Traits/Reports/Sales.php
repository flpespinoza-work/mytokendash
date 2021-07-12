<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Sales
{

    function getSales()
    {
        $extDb = DB::connection('tokencash');
        $salesArr = [];
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-12 23:59:59';
        $establecimientos = ['242624'];
        $reportId = md5(session()->getId());

        $salesArr = cache()->remember('reporte-detalle-ventas-' . $reportId, 60*5, function() use($extDb, $initialDate, $finalDate, $establecimientos){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'ammount' => 0];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('NOD_USU_NODO, VEN_ID, VEN_FECHA_HORA, VEN_MONTO MONTO_VENTA'))
            ->whereIn('VEN_DESTINO', $establecimientos)
            ->where('VEN_ESTADO', '!=', 'CANCELADO')
            ->where('VEN_BOLSA', 'LIKE', 'GIFTCARD_%')
            ->whereBetween('VEN_FECHA_HORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('VEN_ID')
            ->orderBy('VEN_FECHA_HORA', 'desc')
            ->orderBy('NOD_USU_NODO')
            ->chunk(10, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += 1;
                    $totalSales['ammount'] += $sale->MONTO_VENTA;
                    $tmpRes['VENTAS'][] = [
                        'USUARIO' => $sale->NOD_USU_NODO,
                        'FECHA_VENTA' => $sale->VEN_FECHA_HORA,
                        'MONTO' => $sale->MONTO_VENTA
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totalSales;
            return $tmpRes;
        });

        return $salesArr;
    }

    function getSalesHistory()
    {
        $extDb = DB::connection('tokencash');
        $salesArr = [];
        $establecimientos = ['242624'];
        $reportId = md5(session()->getId());

        $salesArr = cache()->remember('reporte-historico-ventas-' . $reportId, 60*5, function() use($extDb, $establecimientos){
            $tmpRes = [];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA, VEN_DESTINO ESTABLECIMIENTO'))
            ->whereIn('VEN_DESTINO', $establecimientos)
            ->where('VEN_ESTADO', '!=', 'CANCELADO')
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('VEN_DESTINO')
            ->orderBy('VEN_DESTINO')
            ->chunk(10, function($sales) use(&$tmpRes) {
                foreach($sales as $sale)
                {
                    $tmpRes['VENTAS'][$sale->ESTABLECIMIENTO] = ['VENTAS' => $sale->VENTAS, 'MONTO' => $sale->MONTO_VENTA];
                }
            });

            return $tmpRes;
        });

        return $salesArr;
    }

    function getSalesDetail()
    {
        $extDb = DB::connection('tokencash');
        $salesArr = [];
        $initialDate = '2021-07-01 00:00:00';
        $finalDate = '2021-07-12 23:59:59';
        $establecimientos = ['242624'];
        $reportId = md5(session()->getId());

        $salesArr = cache()->remember('reporte-detalle-ventas-' . $reportId, 60*5, function() use($extDb, $initialDate, $finalDate, $establecimientos){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'ammount' => 0];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(VEN_FECHA_HORA, "%Y/%m/%d") DIA, COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA'))
            ->whereIn('VEN_DESTINO', $establecimientos)
            ->where('VEN_ESTADO', '!=', 'CANCELADO')
            ->whereBetween('VEN_FECHA_HORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('DIA')
            ->orderBy('DIA')
            ->chunk(10, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += $sale->VENTAS;
                    $totalSales['ammount'] += $sale->MONTO_VENTA;
                    $tmpRes['VENTAS'][$sale->DIA] = ['VENTAS' => $sale->VENTAS, 'MONTO' => $sale->MONTO_VENTA];
                }
            });
            $tmpRes['TOTALS'] = $totalSales;
            return $tmpRes;
        });

        return $salesArr;
    }
}

