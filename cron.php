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
            $server->id = $item->id;
            $server->serverUpdData($res);

            $fulluptime = (time() - strtotime($item->regtime));
            $uptime = $item->downtime * 100 / $fulluptime;
            $uptime = 100 - $uptime;
            $server->uptime = number_format($uptime, 2);


            $item = $server->update();
        if($ping)
        {
            $ping->close();
        }

    }elseif($res = $ping->pingOld17())
        {
            $server->id = $item->id;
            $server->serverUpdData($res);

            $fulluptime = (time() - strtotime($item->regtime));
            $uptime = $item->downtime * 100 / $fulluptime;
            $uptime = 100 - $uptime;
            $server->uptime = number_format($uptime, 2);

            $item = $server->update();
        if($ping)
        {
            $ping->close();
        }

    }elseif($res = $query->GetInfo())
        {
            $server->id = $item->id;
            $server->serverUpdData($res);

            $fulluptime = (time() - strtotime($item->regtime));
            $uptime = $item->downtime * 100 / $fulluptime;
            $uptime = 100 - $uptime;
            $server->uptime = number_format($uptime, 2);


            $item = $server->update();
        if($query)
        {
            $query->close();
        }

    }else{
        $server->id = $item->id;
        $server->players = 0;
        $server->online = 0;
        $server->updtime = date('Y:m:d H:i:s', time());

        $fulluptime = (time() - strtotime($item->regtime));
        $downtime = $item->downtime + 600;
        $uptime = $downtime * 100 / $fulluptime;
        $uptime = 100 - $uptime;

        $server->uptime = number_format($uptime, 2);
        $server->downtime = $downtime;


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