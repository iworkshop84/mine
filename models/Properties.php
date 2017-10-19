<?php


namespace App\Models;

use App\Classes\DB;


class Properties
    extends AbstractM
{


    public function insertMlist($id)
    {
        $arr = $this->data;

        $sql = 'INSERT INTO servermp (servid, mpropid) 
        VALUES 
        (:servid, :mpropid)';

        foreach ($arr as $key=>$val) {
            $ins = [':servid' => $id, ':mpropid' => $val];
            $db = new DB();
            $db->execute($sql, $ins);
        }
    }

    public function deleteMlist($id)
    {
        $sql = 'DELETE FROM servermp 
        WHERE 
        (servid = :id)';

        $db = new DB();
        $db->execute($sql, [':id' => $id]);
    }

    public static function findAllServmp()
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM mainprop';
        $db = new DB;
        $db->setClassName($class);
        return $db->query($sql);
    }

    public static function findAllInServmp($id)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM servermp WHERE servid=:val';
        $db = new DB;

        $db->setClassName($class);
        return $db->query($sql, [':val' => $id]);
    }

}