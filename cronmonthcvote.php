<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once __DIR__ . '/autoload.php';

use App\Models\Servers as ServersModel;

$server = new ServersModel();

$server->votes = 0;



$server->updateAllConst();




    //UPDATE `servers` SET `votes`=0