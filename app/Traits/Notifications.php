<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;

use App\Events\SendNewNotification;

trait Notifications
{
    function sendNewNotification($idNot, $tipo, $usuarios)
    {
        if($tipo == 'INFORMATIVA')
        {
            return $this->sendInfoNotification($idNot, $usuarios);
        }

        return $this->sendCouponNotification($idNot, $usuarios);
    }

    function sendInfoNotification($idNot, $usuarios)
    {
        //Guardar registros en la tabla de dat_notificacion_usuario
        $this->saveUsers($idNot, array_keys($usuarios));
    }

    function sendCouponNotification($idNot, $usuarios)
    {

    }

    function saveUsers($idNot, $usuarios)
    {
        $extDb = DB::connection('tokencash_campanas');
        foreach($usuarios as $usuario)
        {
            $extDb->table('dat_notificacion_usuario')
            ->insertOrIgnore([
                'NOT_USU_TS' => date('Y-m-d H:i:s'),
                'NOT_USU_UTS' => date('Y-m-d H:i:s'),
                'NOT_USU_NOTIFICACION_ID' => $idNot,
                'NOT_USU_USUARIO_ID' => $usuario,
                'NOT_USU_ESTADO' => '0',
            ]);
        }
    }

    function getCampaigns()
    {
        $extDb = DB::connection('tokencash_campanas');
        $result = $extDb->table('dat_campush')
        ->join('dat_notificacion', 'dat_notificacion.NOT_ID', '=', 'dat_campush.CAMP_NOT_ID')
        ->select(DB::raw('CAMP_NOMBRE, NOT_TIPO, CAMP_FALLIDAS, CAMP_EXITOSAS'))
        ->where('NOT_NODO_ID', '=', '242624')
        ->orderBy('NOT_TS')
        ->get()
        ->toArray();

        return $result;

    }

    function getNotificationTipo($idNot)
    {
        $extDb = DB::connection('tokencash');
        $result = $extDb->table('dat_notificacion')
        ->select('NOT_TIPO')
        ->where('NOT_ID', $idNot)
        ->first();

        return $result->NOT_TIPO;
    }

    function getNewNotificationUsers()
    {
        $extDb = DB::connection('tokencash_campanas');
        $result = $extDb->table('cat_dbm_nodos_usuarios')
        ->select(DB::raw('NOD_USU_ID, NOD_USU_CONFIGURACION'))
        ->whereIn('NOD_USU_NUMERO', ['3315745279'])
        ->pluck('NOD_USU_CONFIGURACION', 'NOD_USU_ID');

        return $result->toArray();
    }

    function saveCampaign($campaign)
    {
        $campaign['date'] = date('Y-m-d H:i:s');
        $campaign['date_liberar'] = date('Y-m-d H:i:s', strtotime('+2 minutes'));

        //Si viene archivo, subir por ftp y formar json para NOT_ACCION
        if($campaign['coupon'])
        {
            $campaign['json'] = json_encode(['URL' => 'https://www.tokencash.mx', 'IMG' => '', 'CUPON' => $campaign['coupon']]);
        }
        elseif($campaign['file'])
        {
            $this->uploadFile($campaign['file']); //TO-DO
            $campaign['json'] = json_encode(['URL' => 'https://www.tokencash.mx', 'IMG' => 'https://tokencash.mx/push/' . $campaign['file']['name'], 'CUPON' => '']);
        }
        else
        {
            $campaign['json'] = json_encode(['URL' => 'https://www.tokencash.mx', 'IMG' => 'https://tokencash.mx/push/warning.jpg', 'CUPON' => '']);
        }

        //Guardar en la tabla de dat_notificacion y retornar el id del registro
        $idCampaign = $this->saveNotification($campaign);
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
            //Obtener el nodo del establecimiento
            $campaign['node'] = fn_obtener_nodo_establecimiento($campaign['store'])[0];
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
                TAE_SAL_BOLSA = '{$bolsa[0]}'
            AND
                LENGTH(NOD_USU_CONFIGURACION) > (180)";
            //Revisar si viene datos de sexo
            if($campaign['gender'])
            {
                switch($campaign['gender'])
                {
                    case 'masculino':
                        $consulta .= " AND ((JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"H\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"h\")";
                        break;
                    case 'femenino':
                        $consulta .= " AND ((JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"M\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"m\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"f\")";
                        break;
                    case 'otro':
                        $consulta .= " AND ((JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"LGBT\" OR (JSON_EXTRACT(NOD_USU_CONFIGURACION, \"$.SEXO\")) = \"lgtb\")";
                        break;
                }
            }
            //Revisar si tiene datos de  inactividad
            if($campaign['inactive'])
            {
                $consulta .= " AND TIMESTAMPDIFF(DAY, TAE_SAL_UTS, NOW()) > {$campaign['inactive']}";
            }
            //Guardar en la tabla de dat_notificacion
            $extDb = DB::connection('tokencash_campanas');
            $notiId = $extDb->table('dat_notificacion')
            ->insertGetId([
                'NOT_TS' => $campaign['date'],
                'NOT_UTS' => $campaign['date'],
                'NOT_NODO_ID' => $campaign['node'],
                'NOT_TIPO' => $campaign['type'],
                'NOT_ESTADO' => '1',
                'NOT_VALIDACION' => '1',
                'NOT_TITULO' => $campaign['title'],
                'NOT_CUERPO' => $campaign['body'],
                'NOT_ACCION' => $campaign['json'],
            ]);

            // Guardar en la tabla dat_campush
            $pushId = $extDb->table('dat_campush')
            ->insertGetId([
                'CAMP_TS' => $campaign['date'],
                'CAMP_UTS' => $campaign['date'],
                'CAMP_NOMBRE' => $campaign['name'],
                'CAMP_NOT_ID' => $notiId,
                'CAMP_AUTORIZACION' => '2',
                'CAMP_CONSULTA' => $consulta,
                'CAMP_ESTABLECIMIENTO' => $campaign['node'],
                'CAMP_LIBERACION' => $campaign['date_liberar'],
                'CAMP_AUTOR' => auth()->user()->email,
            ]);

            //Enviar aviso de que se creo una nueva campaña
            event(new SendNewNotification(197));

        }
    }

    function saveCampush()
    {

    }

    function uploadFile()
    {

    }
}
