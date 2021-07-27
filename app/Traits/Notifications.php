<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;

trait Notifications
{
    function getCampaigns()
    {
        $campaigns = [];
        $extDb = DB::connection('tokencash_campanas');
        $result = $extDb->table('dat_campush')
        ->join('dat_notificacion', 'dat_notificacion.NOT_ID', '=', 'dat_campush.CAMP_NOT_ID')
        ->select(DB::raw('CAMP_NOMBRE, NOT_TIPO, CAMP_FALLIDAS, CAMP_EXITOSAS'))
        ->where('NOT_NODO_ID', '=', '242624')
        ->orderBy('NOT_TS')
        ->get()
        ->toArray();

    }

    function saveCampaign($campaign)
    {
        //Si viene archivo, subir por ftp y formar json para NOT_ACCION
        if($campaign['coupon'])
        {
            $json_accion = json_encode(['URL' => 'https://www.tokencash.mx', 'IMG' => '', 'CUPON' => $campaign['coupon']]);
        }
        elseif($campaign['file'])
        {
            $this->uploadFile($campaign['file']); //TO-DO
            $json_accion = json_encode(['URL' => 'https://www.tokencash.mx', 'IMG' => 'https://tokencash.mx/push/' . $campaign['file']['name'], 'CUPON' => '']);
        }
        else
        {
            $json_accion = json_encode(['URL' => 'https://www.tokencash.mx', 'IMG' => 'https://tokencash.mx/push/warning.jpg', 'CUPON' => '']);
        }

        //Guardar en la tabla de dat_notificacion y retornar el id del registro
        $idCampaign = $this->saveNotification($campaign);
        //Guardar en dat_campush
    }

    function saveNotification($campaign)
    {
        if($campaign['store'] == 'PRUEBA')
        {
            $consulta = 'PRUEBA';
        }
        else
        {
            //Obtener la bolsa del establecimiento
            $bolsa = fn_obtener_giftcards($campaign['store']);
            $consulta = "SELECT
                NOD_USU_ID,
                NOD_USU_CONFIGURACION

            FROM
                cat_dbm_nodos_usuarios
            INNER JOIN
                bal_tae_saldos
            ON
                NOD_USU_NODO = TAE_SAL_NODO
            WHERE
                TAE_SAL_BOLSA = \"$bolsa\"
            AND
                LENGTH(NOD_USU_CONFIGURACION) > (180)";
            //Formar Query que se guardara en la tabla de dat_campush, revisar si viene datos de sexo, inactividad
        }
    }

    function saveCampush()
    {

    }

    function uploadFile()
    {

    }
}
