<?php


namespace App\Controllers;

use App\Models\ExceptionM;
use App\Models\Properties;
use App\Models\Users as UserModel;
use App\Models\Servers as ServersModel;
use App\Classes\View;
use App\Classes\ServerPing;
use App\Classes\ServerQuery;

class Users
{

    public function actionRegister()
    {
        if(isset($_POST['adduser'])){
            $user = new Usermodel();

            if(!empty($_POST['login'])){
               $user->login = $_POST['login'];
            }

            if(!empty($_POST['password'])){
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            if(!empty($_POST['email'])){
                $user->email = $_POST['email'];
            }

            $checkLogin = UserModel::findOneInColumn('login', $user->login);
            $checkMail = UserModel::findOneInColumn('email', $user->email);

            if(!empty($checkMail))
            {
                $error = 'Пользователь с таким email уже зарегистрирован на сайте.';
            }
            elseif(!empty($checkLogin))
            {
                $error = 'Неправильный логин либо пароль';
            }
            elseif(isset($user->login) && isset($user->password) && isset($user->email)){

                $user->access = 1;
                $user->regtime = date('Y:m:d H:i:s', time());
                $user->insert();

                header('Location: /users/login');
                exit;
            }
        }

        $view = new View();
        $view->error = $error;

        $view->display('users/register.php');
    }


    public function actionLogin()
    {

        if(isset($_POST['loginuser'])) {
            $user = new Usermodel();

            if(!empty($_POST['login'])){
                $user->login = $_POST['login'];
            }

            if(!empty($_POST['password'])){
                $user->password = $_POST['password'];
            }

            if(isset($user->login) && isset($user->password)){

                $userdata = $user->findOneInColumn('login', $user->login);

                if(password_verify($user->password, $userdata->password)){

                    $userdata->token = bin2hex(openssl_random_pseudo_bytes(64));
                    $userdata->update();

                    $_SESSION['uid'] = $userdata->id;
                    $_SESSION['login'] = $userdata->login;
                    $_SESSION['token'] = $userdata->token;

                    header('Location: /');
                    exit;
                }
            }
        }

        $view = new View();
        //$view->items = $userid;
        //$view->error = $error;
        $view->display('users/login.php');
    }


    public function actionLogout()
    {
        unset($_SESSION['uid']);
        unset($_SESSION['login']);
        unset($_SESSION['token']);

        header('Location: /');
        exit;
    }


    public function actionProfile(){

        $user = new UserModel();

        if(!isset($_SESSION['token']) || !($user->checkUserToken($_SESSION['uid'], $_SESSION['token']))) {

            unset($_SESSION['uid']);
            unset($_SESSION['login']);
            unset($_SESSION['token']);

            header('Location: /Users/Login');
            exit;
        }

        $item = $user->findOneInColumn('id', $_SESSION['uid']);

        if(isset($_POST['edituser'])) {

            $userupdate = new UserModel();
            $userupdate->id = $_SESSION['uid'];

            if(!empty($_POST['email'])) {

                $userupdate->email = $_POST['email'];
                $userupdate->update();
            }

            if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['reppassword'])){

                if($_POST['newpassword'] !== $_POST['reppassword']){
                    $error = 'Новый пароль указан не верно';
                }

                if(!$userupdate->checkUserPassword($userupdate->id, $_POST['oldpassword'])){
                    $error = 'Пароль указан не верно';
                }

                if(!isset($error)){
                    $userupdate->password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
                    $userupdate->update();
                }
            }

            if(!isset($error)){
                header('Location: /Users/Profile');
                exit;
            }
        }

        $view = new View();
        $view->items = $item;
        $view->error = $error;
        $view->display('users/profile.php');
    }





    public function actionServers(){

        $user = new UserModel();

        if(!isset($_SESSION['token']) || !($user->checkUserToken($_SESSION['uid'], $_SESSION['token']))) {

            unset($_SESSION['uid']);
            unset($_SESSION['login']);
            unset($_SESSION['token']);

            header('Location: /users/login');
            exit;
        }

        $serverlist = ServersModel::findAllInColumn('uid', $_SESSION['uid']);


        //var_dump($serverlist);


        if(isset($_POST['checkserver'])) {

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


                $ping = new ServerPing($adress[0], $adress[1]);
                $query = new ServerQuery($adress[0], $adress[1]);


                $server = new ServersModel();
                $server->serverPrepAdress($adress[0], $adress[1]);

                $check = ServersModel::findOneFromTwoColumn('ip', 'port',
                    $server->ip, $server->port);


             if(!$check)
             {
                $error = 'Сервер не найден в рейтинге или указан не верный айпи:порт.';
             }
             elseif ($res = $ping->pingMy())
             {
                 $pattern = '/uid'. $_SESSION['uid'] .'/';
                 preg_match($pattern, $res['HostName'], $matches);

                 if(!empty($matches))
                 {
                     $check->uid = $_SESSION['uid'];
                     $check->update();
                     header('Location: /users/servers');
                     exit;
                 }
                 if($ping)
                 {
                     $ping->close();
                 }
             }
             elseif ($res = $ping->pingOld17())
             {

                 $pattern = '/uid'. $_SESSION['uid'] .'/';
                 preg_match($pattern, $res['HostName'], $matches);

                 if(!empty($matches))
                 {
                     $check->uid = $_SESSION['uid'];
                     $check->update();
                     header('Location: /users/servers');
                     exit;
                 }
                 if($ping)
                 {
                     $ping->close();
                 }
             }
             elseif($res = $query->GetInfo())
             {
                 $pattern = '/uid'. $_SESSION['uid'] .'/';
                 preg_match($pattern, $res['HostName'], $matches);

                 if(!empty($matches))
                 {
                     $check->uid = $_SESSION['uid'];
                     $check->update();
                     header('Location: /users/servers');
                     exit;
                 }
                 if($query)
                 {
                     $query->close();
                 }
             }else{
                 $error = 'Сервер не доступен или офлайн.';
             }
            }
        }


        $view = new View();
        $view->items = $serverlist;
        $view->error = $error;
        $view->display('users/serverlist.php');
    }




    public function actionSedit($id = null)
    {
        $user = new UserModel();

        if(!isset($_SESSION['token']) || !($user->checkUserToken($_SESSION['uid'], $_SESSION['token']))) {

            unset($_SESSION['uid']);
            unset($_SESSION['login']);
            unset($_SESSION['token']);

            header('Location: /users/login');
            exit;
        }

        $server = ServersModel::findOneInColumn('id', $id);
        $serverlist = ServersModel::findServerList();
        $mainproplistall = ServersModel::findMpropList();

        $mplistexist = Properties::findAllInServmp($server->id);

        $mplistarr = [];
        foreach ($mplistexist as $k=>$v)
        {
            $mplistarr[] = ($v->data['mpropid']);
        }


        if($_SESSION['uid'] != $server->uid)
        {
            header('Location: /users/servers');
            exit;
        }


        if(isset($_POST['editserver'])) {

            if(!empty($_POST['name']))
            {
            $server->name = $_POST['name'];
            }

            if(isset($_POST['slogan']))
            {
                $server->slogan = $_POST['slogan'];
            }

            if(isset($_POST['host']))
            {
                $server->host = $_POST['host'];
            }

            if(isset($_POST['description']))
            {
                $server->description = $_POST['description'];
            }

            if(isset($_POST['site']))
            {
                $server->site = $_POST['site'];
            }

            if(isset($_POST['vk']))
            {
                $server->vk = $_POST['vk'];
            }

            if(isset($_POST['youtube']))
            {
                $server->youtube = $_POST['youtube'];
            }

            if(isset($_POST['version']))
            {
                $server->version = $_POST['version'];
            }

            if(!empty($_FILES['banner']['name']))
            {
                if(($_FILES['banner']['type'] == 'image/jpeg')
                    || ($_FILES['banner']['type'] == 'image/png')
                    || ($_FILES['banner']['type'] == 'image/gif'))
                {
                    if($_FILES['banner']['error'] == 0)
                    {
                        if($_FILES['banner']['size'] < 2000000)
                        {
                            if(is_uploaded_file($_FILES['banner']['tmp_name']))
                            {
                                $extension = explode('/', $_FILES['banner']['type']);
                                $bannername = 'serverbanner' . time() . '.' . $extension[1];

                                $uploadfile = move_uploaded_file($_FILES['banner']['tmp_name'],
                                    __DIR__ . '/../upload/banners/' . $bannername);
                                    if($uploadfile)
                                    {
                                        $server->banner = $bannername;
                                    }
                            }
                        }
                    }
                }
            }


            if(isset($_POST['mainprop']))
            {
               $mplist = new Properties();
               $mplist->data = $_POST['mainprop'];

               $mplist->deleteMlist($server->id);
               $mplist->insertMlist($server->id);


            }

            $server->update();

            header('Location: /users/sedit/'. $server->id);
            exit;

        }
        $view = new View();
        $view->items = $server;
        $view->serverlist = $serverlist;
        $view->mainproplistall = $mainproplistall;
        $view->mplistarr = $mplistarr;
        //$view->error = $error;
        $view->display('users/serveredit.php');

    }



    public function actionSdelete($id = null){

        $user = new UserModel();

        if(!isset($_SESSION['token']) || !($user->checkUserToken($_SESSION['uid'], $_SESSION['token']))) {

            unset($_SESSION['uid']);
            unset($_SESSION['login']);
            unset($_SESSION['token']);

            header('Location: /Users/Login');
            exit;
        }

        $serverlist = ServersModel::findOneInColumn('id', $id);

        if(empty($id) || empty($serverlist))
        {
            throw new ExceptionM ('Запись не найдена', 1);
        }

        if($serverlist->uid != $_SESSION['uid'])
        {
            throw new ExceptionM ('За121212пись не найдена', 1);
        }

        $serverlist->serverDelete($id);
        header('Location: /users/servers/');
        exit;



    }

}