<?php

use Illuminate\Support\Facades\DB;
use App\Models\Store;

//Obtener establecimientos desde dbm tokencash
if(!function_exists('fn_obtener_establecimientos_tokencash'))
{
    function fn_obtener_establecimientos_tokencash($filter = '')
    {
        $extDb = DB::connection('tokencash');
        $query = $extDb->table('cat_dbm_nodos')
        ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos.NOD_ID', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
        ->select('NOD_ID', 'NOD_USU_NOMBRE', 'NOD_USU_NODO');

        if(!empty($filter))
        {
            $query->where(function($query) use($filter){
                return $query->where('NOD_ID', 'LIKE', '%' . $filter . '%')
                ->orWhere('NOD_USU_NOMBRE', 'LIKE', '%' . $filter . '%');
            });
        }

        $query->where('NOD_RAIZ', '=', '2')
        ->where('NOD_ACTIVO', '=', '1')
        ->where('NOD_SUSPENDIDO', '!=', '1')
        ->where('NOD_USU_ACTIVO', '=', '1')
        ->where('NOD_USU_SUSPENDIDO', '!=', '1')
        ->orderBy('NOD_ID');

        return $query->get();
    }
}

//Obtener establecimientos registrados en el dashboard
if(!function_exists('fn_obtener_establecimientos'))
{
    function fn_obtener_establecimientos()
    {

    }
}
//Obtener usuarios segun el rol del usuario logueado

//Obtener presupuestos

//Obtener giftcards

//Generar identificador para los reportes

//Generar la cantidad de minutos que un reporte estara en la cache

