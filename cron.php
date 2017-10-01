<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once __DIR__ . '/autoload.php';

use App\Models\Servers as ServersModel;
use App\Classes\ServerPing;
use App\Classes\ServerQuery;

$server = new ServersModel();

$items = ServersModel::findAll();
//var_dump($items);


foreach ($items as $item){

    $ping = new ServerPing($item->ip, $item->port);
    $query = new ServerQuery($item->ip, $item->port);


    if($res = $ping->pingMy())
        {
            $server->serverUpdData($res);
            $server->id = $item->id;

            $item = $server->update();
        if($ping)
        {
            $ping->close();
        }

    }elseif($res = $ping->pingOld17())
        {

            $server->serverUpdData($res);
            $server->id = $item->id;

            $item = $server->update();
        if($ping)
        {
            $ping->close();
        }

    }elseif($res = $query->GetInfo())
        {

            $server->serverUpdData($res);
            $server->id = $item->id;

            $item = $server->update();
        if($query)
        {
            $query->close();
        }

    }else{
        $server->id = $item->id;
        $server->players = 0;
        $server->online = 0;
        $server->maxplayers = 0;

        $item = $server->update();

        if($ping)
        {
            $ping->close();
        }
        if($query)
        {
            $query->close();
        }
    }



}