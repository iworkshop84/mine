<?php

namespace App\Controllers;

use App\Models\ExceptionM;
use App\Models\Servers as ServersModel;
use App\Classes\View;
use App\Classes\ServerPing;
use App\Classes\ServerQuery;

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
                $adress = str_ireplace(' ', '', $_POST['server']);
                $adress = str_ireplace('http://', '', $adress);
                $adress = str_ireplace('https://', '', $adress);
                $adress = str_ireplace('tcp://', '', $adress);
                $adress = str_ireplace('udp://', '', $adress);
                $adress = str_ireplace('/', '', $adress);

                $adress = explode(':', $adress);
                if (!$adress[1]) {
                    $adress[1] = 25565;
                }


                // Создаём объект СерверПинг через который у нас и будет проходить весь пинга
                $ping = new ServerPing($adress[0], $adress[1]);
                $query = new ServerQuery($adress[0], $adress[1]);

                if($res = $ping->pingMy())
                {

                $server = new ServersModel();
                $server->serverPrepData($res);
                $server->serverPrepAdress($adress[0], $adress[1]);

                $item = $server->insert();
                    if($ping)
                    {
                        $ping->close();
                    }

                }elseif($res = $ping->pingOld17())
                {
                    $server = new ServersModel();
                    $server->serverPrepData($res);
                    $server->serverPrepAdress($adress[0], $adress[1]);

                    $item = $server->insert();
                    if($ping)
                    {
                        $ping->close();
                    }

                }elseif($res = $query->GetInfo())
                {
                    $server = new ServersModel();
                    $server->serverPrepData($res);
                    $server->serverPrepAdress($adress[0], $adress[1]);

                    $item = $server->insert();
                    if($query)
                    {
                        $query->close();
                    }

                }else{
                    $error = 'Добавление сервера не удалось, проверьте правильность айпи и порта';
                }
            }
        }

        $view = new View();
        $view->items = $item;
        $view->error = $error;
        $view->display('servers/add.php');
    }
}