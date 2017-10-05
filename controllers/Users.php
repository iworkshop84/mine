<?php
/**
 * Created by PhpStorm.
 * User: iworkshop
 * Date: 01.10.2017
 * Time: 12:16
 */

namespace App\Controllers;

use App\Models\ExceptionM;
use App\Models\Users as UserModel;
use App\Classes\View;

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
                $userid = $user->insert();
            }
        }

        $view = new View();
        $view->items = $userid;
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


}