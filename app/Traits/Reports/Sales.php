<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Sales
{

    function getSales($establecimiento, $initialDate, $finalDate, $period = false)
    {
        $extDb = DB::connection('tokencash');
        $salesArr = [];

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

        $nodos = fn_obtener_nodo_establecimiento($establecimiento);
        $reportId = fn_generar_reporte_id( $establecimiento . strtotime($initialDate) . strtotime($finalDate) );
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);

        $salesArr = cache()->remember('reporte-ventas-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $nodos){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'ammount' => 0];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('NOD_USU_NODO, VEN_ID, VEN_FECHA_HORA, VEN_MONTO MONTO_VENTA'))
            ->whereIn('VEN_DESTINO', $nodos)
            ->where('VEN_ESTADO', '=', 'VIGENTE')
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
                        'FECHA_VENTA' => $sale->VEN_FECHA_HORA,
                        'USUARIO' => $sale->NOD_USU_NODO,
                        'MONTO' => $sale->MONTO_VENTA
                    ];
                }
            });

            if(count($tmpRes))
            {
                $tmpRes['TOTALS'] = $totalSales;
                $tmpRes['TOTALS']['average_sale'] = $totalSales['ammount'] / $totalSales['sales'];
            }


            return $tmpRes;
        });

        return $salesArr;
    }

    function getSalesHistory($establecimiento)
    {
        $extDb = DB::connection('tokencash');
        $salesArr = [];
        $nodos = fn_obtener_nodo_establecimiento($establecimiento);
        $reportId = fn_generar_reporte_id( $establecimiento );

        $salesArr = cache()->remember('reporte-historico-ventas-' . $reportId, 60*5, function() use($extDb, $nodos){
            $tmpRes = [];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA, VEN_DESTINO ESTABLECIMIENTO'))
            ->whereIn('VEN_DESTINO', $nodos)
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('VEN_DESTINO')
            ->orderBy('VEN_DESTINO')
            ->chunk(10, function($sales) use(&$tmpRes) {
                foreach($sales as $sale)
                {
                    $tmpRes['VENTAS'][$sale->ESTABLECIMIENTO] = [
                        'VENTAS' => $sale->VENTAS,
                        'MONTO' => $sale->MONTO_VENTA,
                        'PROMEDIO_VENTA' => $sale->MONTO_VENTA / $sale->VENTAS
                    ];
                }
            });

            return $tmpRes;
        });

        return $salesArr;
    }

    function getSalesDetail($establecimiento, $initialDate, $finalDate, $period = false)
    {
        $extDb = DB::connection('tokencash');
        $salesArr = [];
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

        $nodos = fn_obtener_nodo_establecimiento($establecimiento);
        $reportId = fn_generar_reporte_id( $establecimiento . strtotime($initialDate) . strtotime($finalDate) );
        $rememberReport = fn_recordar_reporte_tiempo($finalDate);

        $salesArr = cache()->remember('reporte-detalle-ventas-' . $reportId, $rememberReport, function() use($extDb, $initialDate, $finalDate, $nodos){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'ammount' => 0];
            $extDb->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(VEN_FECHA_HORA, "%d/%m/%Y") DIA, COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA'))
            ->whereIn('VEN_DESTINO', $nodos)
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereBetween('VEN_FECHA_HORA', [$initialDate, $finalDate])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('DIA')
            ->orderBy('DIA')
            ->chunk(10, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += $sale->VENTAS;
                    $totalSales['ammount'] += $sale->MONTO_VENTA;
                    $tmpRes['VENTAS'][$sale->DIA] = [
                        'DIA' => $sale->DIA,
                        'VENTAS' => $sale->VENTAS,
                        'MONTO' => $sale->MONTO_VENTA
                    ];
                }
            });
            $tmpRes['TOTALS'] = $totalSales;
            $tmpRes['TOTALS']['average_sale'] = $totalSales['ammount'] / $totalSales['sales'];
            return $tmpRes;
        });
        return $salesArr;
    }
}

