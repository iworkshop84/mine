<?php

namespace App\Controllers;

use App\Models\ExceptionM;
use App\Models\Servers as ServersModel;
use App\Classes\View;
use App\Classes\ServerPing;
use App\Classes\ServerQuery;
use App\Models\Properties;
use App\Models\Votes;

class Servers
{
    public function actionAll($version = null)
    {

        $versionList = ServersModel::findServerList();
        $mainpropList = Properties::findAllServmp();

        if(empty($version)){
        $items = ServersModel::findAllOrdVotes();
        }else{
        $items = ServersModel::findAllInColumnOrdVotes('version', $version);
        }

        $view = new View();
        $view->items = $items;
        $view->versionList = $versionList;
        $view->mainpropList = $mainpropList;

        $view->display('servers/all.php');
    }



    public function actionNew($version = null)
    {

        $versionList = ServersModel::findServerList();
        //$mainpropList = Properties::findAllServmp();

        if(empty($version)){
            $items = ServersModel::findAllCheckedNoOrdVotes();
        }else{
            $items = ServersModel::findAllInColumnCheckedNoOrdVotes('version', $version);

        }

        $view = new View();
        $view->items = $items;
        $view->versionList = $versionList;
        //$view->mainpropList = $mainpropList;

        $view->display('servers/new.php');
    }



    public function actionProperties($mprop = null)
    {
        $versionList = ServersModel::findServerList();
        $mainpropList = Properties::findAllServmp();

        if(empty($mprop)){
            $items = ServersModel::findAllOrdVotes();
        }else{
            $items = ServersModel::findAllMPropOrdVotes($mprop);
        }

        $view = new View();

        $view->items = $items;
        $view->versionList = $versionList;
        $view->mainpropList = $mainpropList;

        $view->display('servers/all.php');
    }



    public function actionOne($id = null)
    {
        // Заплатка для отсечения урлов в которых есть что-то кроме цифр
        if(preg_match('#[^0-9]+#', $id))
        {
            throw new ExceptionM ('Запись не найдена', 1);
        }



        $item = ServersModel::findOneInColumn('id', $id);

        if(empty($item))
        {
            throw new ExceptionM ('Запись не найдена', 1);
        }

        $mainprop = ServersModel::findServerMProp($id);


        $view = new View();
        $view->items = $item;
        $view->mainprops = $mainprop;
        $view->display('servers/one.php');

    }


    public function actionVote($id = null){

        $item = ServersModel::findOneInColumn('id', $id);


        if(empty($item))
        {
            throw new ExceptionM ('Запись не найдена', 1);
        }


        if(isset($_POST['uservote'])){
            $result = Votes::findVotepList($_SERVER['REMOTE_ADDR']);


            if(empty($result)){
                $item->votes++;
                $item->update();

                $vote = new Votes();
                $vote->ip = $_SERVER['REMOTE_ADDR'];
                $vote->insert();


            }
        }

        $view = new View();
        $view->items = $item;
        $view->display('servers/vote.php');

    }

    public function actionAdd()
    {
        if(isset($_POST['addserver'])){

            if(!empty($_POST['server'])) {
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


                $server = new ServersModel();
                $server->serverPrepAdress($adress[0], $adress[1]);


                $check = ServersModel::findOneFromTwoColumn('ip', 'port',
                    $server->data['ip'], $server->data['port']);


                if(!empty($check))
                {
                    $item = $check->data['id'];

                }elseif($res = $ping->pingMy())
                {

                    //$server = new ServersModel();
                    $server->serverPrepData($res);
                    //$server->serverPrepAdress($adress[0], $adress[1]);

                $item = $server->insert();
                    if($ping)
                    {
                        $ping->close();
                    }
                }elseif($res = $ping->pingOld17())
                {
                    //$server = new ServersModel();
                    $server->serverPrepData($res);
                    //$server->serverPrepAdress($adress[0], $adress[1]);

                    $item = $server->insert();
                    if($ping)
                    {
                        $ping->close();
                    }

                }elseif($res = $query->GetInfo())
                {
                    //$server = new ServersModel();
                    $server->serverPrepData($res);
                    //$server->serverPrepAdress($adress[0], $adress[1]);

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