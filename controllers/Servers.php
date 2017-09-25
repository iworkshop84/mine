<?php

namespace App\Controllers;

use App\Models\ExceptionM;
use App\Models\Servers as ServersModel;
use App\Classes\View;
use App\Classes\MinecraftPing;
use App\Classes\MinecraftQuery;

class Servers
{
    public function actionAll()
    {

        $items = ServersModel::findAll();
        $view = new View();
        $view->items = $items;

        $view->display('servers/all.php');
    }


    public function actionOne($id = null)
    {

        $item = ServersModel::findOneInColumn('id', $id);

        if(empty($item))
        {
            throw new ExceptionM ('Запись не найдена', 1);
        }

        $view = new View();
        $view->items = $item;
        $view->display('servers/one.php');

    }

    public function actionAdd()
    {
        if(isset($_POST['addserver'])){

            if(!empty($_POST['server']))
            {
                // удаляем лишние пробелы из начала и конца и лишние символы из адреса
                // заменить потом этот блок на preg_replace
                $adress = trim($_POST['server']);
                $adress = str_ireplace('http://', '', $adress);
                $adress = str_ireplace('https://', '', $adress);
                $adress = str_ireplace('/', '', $adress);
                $adress = str_ireplace(' ', '', $adress);

                $adress = explode(':', $adress);
                if (!$adress[1]) {
                    $adress[1] = 25565;
                }


                $query = new MinecraftPing($adress[0], $adress[1]);
                var_dump($query);
                if($res = $query->QueryLast())
                {
                    if($query)
                    {
                        $query->Close();
                    }
                    var_dump($res);
                    var_dump($query);


                $server = new ServersModel();
                $server->name = $res['HostName'];
                $server->players = $res['Players'];
                $server->maxplayers = $res['MaxPlayers'];

                // очищаем версию сервера от разного мусора
                $pattern = '/([0-9]+\.[0-9]+\.[0-9]+)|([0-9]+\.[0-9]+)/';
                preg_match($pattern, $res['serverVersion'], $matches);

                // закидываем в объект версию сервера
                $server->version = $matches[0];
                $server->port = (int)$adress[1];

                //$server->getIpHost($adress[0]);
                // не получилось сделать это в классе, присвоение айпишника и хоста
                    if(ip2long($adress[0]))
                    {
                        $server->ip = $adress[0];
                        $server->host = null;
                    }else{
                        $record = dns_get_record($adress[0], DNS_A );
                        if(empty($record))
                        {
                            return false;
                        }
                        if(isset($record[0]['ip']))
                        {
                            $server->host = $adress[0];
                            $server->ip = $record[0]['ip'];
                        }
                    }
                $item = $server->insert();




                    var_dump($server);

                    var_dump($adress[0]);
                    var_dump($item);



                }elseif(0>1)
                {
                    echo 1;
                }
                elseif(1==1)
                {
                    echo 2;
                }



                if($query)
                {
                    $query->Close();
                }






            }





        }


        $view = new View();
        $view->items = $item;
        $view->display('servers/add.php');

    }





}