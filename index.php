<?php
require_once __DIR__ . '/autoload.php';

use App\Models\ExceptionM;
use App\Classes\View;
use App\Classes\MinecraftQuery;
use App\Classes\MinecraftQueryException;
use App\Classes\MinecraftPing;
use App\Classes\MinecraftPingException;
use App\Classes\Servers;

/*
// Edit this ->
define( 'MQ_SERVER_ADDR', 'sv4.ex-server.ru' );
define( 'MQ_SERVER_PORT', 25681);
define( 'MQ_TIMEOUT', 1 );
// Edit this <-



try
{
    $Query = new MinecraftPing( 'play.bullmc.ru', 25565 );

    var_dump( $Query->Query() );
}
catch( MinecraftPingException $e )
{
    echo $e->getMessage();
}
finally
{
    if( $Query )
    {
        $Query->Close();
    }
}


$Query = new MinecraftQuery( );

try
{
    $Query->Connect( 'play.bullmc.ru', 25565 );

    print_r( $res = $Query->GetInfo());

    print_r( $Query->GetPlayers());
}
catch( MinecraftQueryException $e )
{
    echo $e->getMessage( );
}



$Address = 'play.bullmc.ru';






$Record = dns_get_record( 'mc.mythicalworld.su', DNS_A );

if( empty( $Record ) )
{
    return;
}
if( isset( $Record[ 0 ][ 'ip' ] ) )
{
    $Address = $Record[ 0 ][ 'ip' ];
}

var_dump($Address);


*/
/*
$Port = 25571;
$Timeout = 3;

$res = new Servers();
// Не забыть сделать очистку урла от http:// и www
$ip = $res->ResolveSRV('mc.mythicalworld.su');

var_dump($ip);


$res->Socket = fsockopen( 'udp://' . $ip, (int)$Port, $ErrNo, $ErrStr, $Timeout );

var_dump($res);
var_dump($res->Socket);

FClose( $res->Socket );


function formatMOTD($motd){
    $search  = array('§0', '§1', '§2', '§3', '§4', '§5', '§6', '§7', '§8', '§9', '§a', '§b', '§c', '§d', '§e', '§f', '§l', '§m', '§n', '§o', '§k', '§r');
    $replace = array('<font color="#000000">', '<font color="#0000AA">', '<font color="#00AA00">', '<font color="#00AAAA">', '<font color="#aa00aa">', '<font color="#ffaa00">', '<font color="#aaaaaa">', '<font color="#555555">', '<font color="#5555ff">', '<font color="#55ff55">', '<font color="#55ffff">', '<font color="#ff5555">', '<font color="#ff55ff">', '<font color="#ffff55">', '<font color="#ffffff">', '<font color="#000000">', '<b>', '<u>', '<i>', '<font color="#000000">', '<font color="#000000">');
    $motd  = str_replace($search, $replace, $motd);

    return $motd;
}

function QueryMinecraft($ip, $port = 25565) {
//made by Fabian

    @$socket = fsockopen("tcp://" . $ip, $port, $errno, $errstr, 3);
    if (!$socket) { return array('status' => 0); }
    socket_set_timeout($socket, 5);
    fwrite($socket, "\xFE\x01"); //Send the server list ping request (two bytes)
    @$data = fread($socket, 1024); //Get the info and store it in $data

    if ($data != false && substr($data, 0, 1) == "\xFF") //Ensure we're getting a kick message as expected
    {
        $data = substr($data, 9); //Remove packet, length and starting characters
        $data = explode("\x00\x00", $data); //0000 separated info
        $protocolVersion = $data[0]; //Get it all into separate variables
        @$serverVersion = mb_convert_encoding($data[1], 'UTF-8', 'UCS-2');;
        @$motd = $data[2];
        $motd = mb_convert_encoding($motd, 'UTF-8', 'UCS-2');
        @$players = mb_convert_encoding($data[3], 'UTF-8', 'UCS-2');
        @$max_players = mb_convert_encoding($data[4], 'UTF-8', 'UCS-2');


        sleep(0.2);
        return array('status' => 1,'HostName' => formatMOTD($motd), 'Players' => $players, 'MaxPlayers' => $max_players, 'serverVersion' => $serverVersion);
    } else { return array('status' => 0); }
}



$res = QueryMinecraft('join.mc-chronos.net');
var_dump($res);





try
{
    $Query = new MinecraftPing( 'join.mc-chronos.net' );

    var_dump( $Query->Query() );
}
catch( MinecraftPingException $e )
{
    echo $e->getMessage();
}
finally
{
    if( $Query )
    {
        $Query->Close();
    }
}




$Query = new MinecraftQuery( );

try
{
    $Query->Connect( 'join.mc-chronos.net', 25565 );

    print_r( $Query->GetInfo( ) );
    print_r( $Query->GetPlayers( ) );
}
catch( MinecraftQueryException $e )
{
    echo $e->getMessage( );
}


$socket = stream_socket_client(sprintf('tcp://%s:%u', 'join.mc-chronos.net', '25565'), $errno, $errstr, 1);
    fwrite($socket, "\xfe\x01");
        $data = fread($socket, 1024);
    fclose($socket);
        $stats = new \stdClass;
    // Is this a disconnect with the ping?
    if ($data == false AND substr($data, 0, 1) != "\xFF") {
        $stats->is_online = false;
        return $stats;
    }
    $data = substr($data, 9);
    $data = mb_convert_encoding($data, 'auto', 'UCS-2');
    $data = explode("\x00", $data);
        $stats->is_online = true;
    list($stats->protocol_version, $stats->game_version, $stats->motd, $stats->online_players, $stats->max_players) = $data;
    var_dump($stats) ;

*/




















die;









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
