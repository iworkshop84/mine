<?php

namespace App\Controllers;

use App\Models\ExceptionM;
use App\Models\Servers as ServersModel;
use App\Classes\View;

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

}