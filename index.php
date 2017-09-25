<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once __DIR__ . '/autoload.php';

use App\Models\ExceptionM;
use App\Classes\View;
use App\Classes\MinecraftQuery;
use App\Classes\MinecraftPing;




/*
 * mcmwc.ru:25565
 *  'serverVersion' => string 'Waterfall 1.8.x, 1.9.x, 1.10.x, 1.11.x, 1.12.x'
 * 'name' => string 'Waterfall 1.8.x, 1.9.x, 1.10.x, 1.11.x, 1.12.x'
 *  'Version' => string 'Waterfall 1.8.x, 1.9.x, 1.10.x, 1.11.x, 1.12.x'
 * query - false
 *
 * playdard.ru:25565
 *  'serverVersion' => string 'Waterfall 1.8.x, 1.9.x, 1.10.x, 1.11.x, 1.12.x'
 *  'name' => string 'Waterfall 1.8.x, 1.9.x, 1.10.x, 1.11.x, 1.12.x'
 * 'Version' => string 'Waterfall 1.8.x, 1.9.x, 1.10.x, 1.11.x, 1.12.x'
 * query - false
 *
 * tmsv.ru
 * 'serverVersion' => string 'BotFilter 1.8-1.12.1 by vk.com Leymooo_s'
 *  'name' => string 'BotFilter 1.8-1.12.1 by vk.com Leymooo_s'
 * 'Version' => string 'BotFilter 1.8-1.12.1 by vk.com Leymooo_s'
 * 'Version' => string 'BotFilter 1.8-1.12.1 by vk.com Leymooo_s'
 *  'Software' => string 'Vanilla'
 *
 * mc.thewd.ru
 *  'serverVersion' => string '1.8.8'
 * 'version' => 'name' => string 'Spigot 1.8.8'
 * 'Version' => string '1.8.8'
 * 'Version' => string '1.11.2'
 * 'Software' => string 'CraftBukkit on Bukkit 1.11.2-R0.1-SNAPSHOT'
 *
 *  mc.mineland.net
 *  'serverVersion' => string 'BungeeCord 1.8.x-1.12.x'
 * 'version' =>  'name' => string 'BungeeCord 1.8.x-1.12.x'
 *  'Version' => string 'BungeeCord 1.8.x-1.12.x'
 *  query - false
 *
 * mc.randomcraft.ru - 51.254.103.123:25565
 * 'serverVersion' => string 'Use 1.12, Luke'
 * 'version' => 'name' => string 'Use 1.12, Luke'
 * 'Version' => string 'Use 1.12, Luke'
 * query - false
 *
 *
 * 87.98.173.96:25565
 * 'serverVersion' => string '1.5.2'
 *  ping - false
 * 'Version' => string '1.5.2'
 *  query - false
 *
 * play.crazylife.su
 * 'serverVersion' => string 'BungeeCord 1.7.x, 1.8.x, 1.9.x, 1.10.x, 1.11.x'
 * 'version' =>  'name' => string 'BungeeCord 1.7.x, 1.8.x, 1.9.x, 1.10.x, 1.11.x'
 * 'Version' => string 'BungeeCord 1.7.x, 1.8.x, 1.9.x, 1.10.x, 1.11.x'
 * 'Version' => string 'BungeeCord 1.7.x, 1.8.x, 1.9.x, 1.10.x, 1.11.x'
 * 'Software' => string 'Vanilla'
 *
 * 91.121.35.3:25565
 * 'serverVersion' => string 'BungeeCord 1.8'
 * 'version' => 'name' => string 'BungeeCord 1.8'
 *  'Version' => string 'BungeeCord 1.8'
 *  'Version' => string '1.8'
 *  'Software' => string 'Vanilla'
 *
 *
 */



/*

$ip = '87.98.173.96';
$port = 25565;




















// этот блок я буду использовать для пинга сервера
    $Query = new MinecraftPing($ip, $port);

    $res = $Query->QueryLast();

    var_dump($res);
    if($Query)
    {
        $Query->Close();
    }

echo '+++++++++++++++++++++++++++++++++++++++++++++++<br/>';
/*

    $Query = new MinecraftPing($ip, $port);

    $res = $Query->Query();
    var_dump($res);

    if($Query)
    {
        $Query->Close();
    }


echo '+++++++++++++++++++++++++++++++++++++++++++++++<br/>';


    $Query = new MinecraftPing($ip, $port);

    $res2 = $Query->QueryOldPre17();
    var_dump($res2);

    if($Query)
    {
        $Query->Close();
    }
/
echo '+++++++++++++++++++++++++++++++++++++++++++++++<br/>';

// этот блок у меня будет использоваться при добавлении сервера и обновлении информации

    $Query = new MinecraftQuery();
    $Query->Connect($ip, $port);

    var_dump($Query->GetInfo());
    //var_dump($Query->GetPlayers());




die;

*/







$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);



$ctrl = !empty($pathParts[1]) ? $pathParts[1] : 'Servers';
$act = !empty($pathParts[2]) ? $pathParts[2] : 'All';
$id = !empty($pathParts[3]) ? $pathParts[3] : null;

$controllerClassName = 'App\\Controllers\\' . $ctrl;


try
{
    $controller = new $controllerClassName;
    $method = 'action' . $act;

    if(!empty($id))
    {
        $controller->$method($id);
    }else{
        $controller->$method();
    }
}
catch (ExceptionM $err)
{
    $view = new View();
    $view->error = $err->getMessage();
    $view->code = $err->getCode();
    switch($view->code){
        case 1:
            header('HTTP/1.1 404 Not Found');
            break;
        case 2:
            header('HTTP/1.1 403 Not Found');
            break;
    }
    $view->display('servers/error.php');
}
