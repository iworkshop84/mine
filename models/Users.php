<?php
/**
 * Created by PhpStorm.
 * User: iworkshop
 * Date: 01.10.2017
 * Time: 8:42
 */

namespace App\Models;

use App\Classes\DB;

class Users
    extends AbstractM
{
    protected static $table = 'users';


    public function checkUserToken($userid, $usertoken)
    {
        $data = $this::findOneInColumn('id', $userid);

        if($data->token != $usertoken){
            return false;
        }
        return true;
    }

    public function checkUserPassword($userid, $userpassword)
    {
        $data = $this::findOneInColumn('id', $userid);

        if(!password_verify($userpassword, $data->password)){
            //$data->token != $userpassword){
            return false;
        }
        return true;
    }




}