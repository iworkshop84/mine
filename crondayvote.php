<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once __DIR__ . '/autoload.php';

use App\Models\Votes;
use App\Models\Servers as ServersModel;

$clean = Votes::cleanDayVotes();

$items = ServersModel::findAllCheckedNoOrdVotes();

foreach ($items as $item){
    $regtime = strtotime($item->regtime);
    $updtime = strtotime($item->updtime);

    if(($updtime - $regtime)> 259200){

        if($item->uptime >= 80){
           $item->checked = 'yes';
           $item->update();
        }elseif($item->uptime <= 50){
            $item->serverDelete($item->id);
        }
    }
}