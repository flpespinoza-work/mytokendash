<?php

use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Group;


//Obtener establecimientos desde dbm tokencash
if(!function_exists('fn_obtener_establecimientos_tokencash'))
{
    function fn_obtener_establecimientos_tokencash($filter = '')
    {
        $extDb = DB::connection('tokencash');
        $query = $extDb->table('cat_dbm_nodos')
        ->select('NOD_ID', 'NOD_NOMBRE', 'NOD_CODIGO');

        if(!empty($filter))
        {
            $query->where(function($query) use($filter){
                return $query->where('NOD_ID', 'LIKE', '%' . $filter . '%')
                ->orWhere('NOD_CODIGO', 'LIKE', '%' . $filter . '%')
                ->orWhere('NOD_NOMBRE', 'LIKE', '%' . $filter . '%');
            });
        }

        $query->where('NOD_RAIZ', '=', '2')
        ->where('NOD_ACTIVO', '=', '1')
        ->where('NOD_SUSPENDIDO', '!=', '1')
        ->orderBy('NOD_ID');

        return $query->get();
    }
}

//Obtener establecimientos registrados en el dashboard
if(!function_exists('fn_obtener_establecimientos'))
{
    function fn_obtener_establecimientos()
    {
        $user = session()->user;
        if($user->is_superadmin())
        {

        }
       $group = session()->user()->group;
    }
}

//Obtener usuarios segun el rol del usuario logueado

//Obtener presupuestos
if(!function_exists('fn_obtener_presupuestos'))
{
    function fn_obtener_presupuestos($establecimiento)
    {
        $presupuestos = Store::where('id', $establecimiento)->pluck('budget')->toArray();
        return $presupuestos;
    }
}

//Obtener giftcards
if(!function_exists('fn_obtener_giftcards'))
{
    function fn_obtener_giftcards($establecimiento)
    {
        $giftcards = Store::where('id', $establecimiento)->pluck('giftcard')->toArray();
        return $giftcards;
    }
}


//Generar identificador para los reportes
if(!function_exists('fn_generar_reporte_id'))
{
    function fn_generar_reporte_id($str)
    {
        return md5($str);
    }
}

//Generar la cantidad de minutos que un reporte estara en la cache
if(!function_exists('fn_recordar_reporte_tiempo'))
{
    function fn_recordar_reporte_tiempo($fecha)
    {
        if(date('Y-m-d') > date('Y-m-d', strtotime($fecha)))
        {
            return 60*10; //10 minutos para reportes de hoy
        }

        return 60*60*24*7; // 7 dias para reportes anteriores
    }
}
