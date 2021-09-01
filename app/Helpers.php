<?php

use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Group;
use Illuminate\Support\Facades\Date;

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
        $user = auth()->user();
        if($user->isSuperAdmin())
        {
            return Store::orderBy('name')->pluck('name', 'id')->toArray();
        }
        else if($user->hasRole('group admin'))
        {
            return $user->group->stores->pluck('name', 'id')->toArray();
        }
        else
        {
            return $user->stores->pluck('name', 'id')->toArray();
        }
    }
}

//Obtener usuarios segun el rol del usuario logueado

//Obtener presupuestos
if(!function_exists('fn_obtener_presupuestos'))
{
    function fn_obtener_presupuestos($establecimiento, $no_pre = false)
    {
        if(!$no_pre)
            return Store::where('id', $establecimiento)->get()->pluck('budget');
        else
            return Store::where('id', $establecimiento)->get()->pluck('full_presupuesto');
    }
}

//Obtener giftcards
if(!function_exists('fn_obtener_giftcards'))
{
    function fn_obtener_giftcards($establecimiento, $no_gift = false)
    {
        if(!$no_gift)
            return Store::where('id', $establecimiento)->get()->pluck('giftcard');
        else
            return Store::where('id', $establecimiento)->get()->pluck('full_name');
    }
}

//Obtener el nodo del establecimiento
if(!function_exists('fn_obtener_nodo_establecimiento'))
{
    function fn_obtener_nodo_establecimiento($establecimiento)
    {
        $nodo = Store::where('id', $establecimiento)->pluck('tokencash_node');
        return $nodo;
    }
}

// Obtener los vendedores del establecimiento
if(!function_exists('fn_obtener_vendedores_establecimiento'))
{
    function fn_obtener_vendedores_establecimiento($establecimiento)
    {
        $nodo = Store::where('id', $establecimiento)->pluck('tokencash_node');

        $extDb = DB::connection('tokencash');
        $vendedores = $extDb->table('cat_dbm_nodos_usuarios')
        ->select('NOD_USU_NUMERO', 'NOD_USU_NOMBRE')
        ->where('NOD_USU_NODO', $nodo)
        ->where('NOD_USU_ACTIVO', '=', '1')
        ->where('NOD_USU_SUSPENDIDO', '!=', '1')
        ->orderBy('NOD_USU_NOMBRE')
        ->get();
        dd($vendedores);
    }
}

if(!function_exists('fn_generar_listado'))
{
    function fn_generar_listado()
    {
        return false;
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

if(!function_exists('fn_upload_image'))
{
    function fn_upload_image()
    {
        return 'Subir archivo';
    }
}

//Generar la cantidad de minutos que un reporte estara en la cache
if(!function_exists('fn_recordar_reporte_tiempo'))
{
    function fn_recordar_reporte_tiempo($fecha)
    {
        if(date('Y-m-d') > date('Y-m-d', strtotime($fecha)))
        {
            return  Date::now()->addMinutes(10);
        }

        return Date::now()->addWeek();
    }
}
