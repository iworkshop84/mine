<?php


namespace App\Models;

use App\Classes\DB;

class AbstractM
{
    protected static $table;

    protected $data = [];

    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }


    public function __get($k)
    {
        return $this->data[$k];
    }


    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


    public static function findAll()
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table;
        $db = new DB;
        $db->setClassName($class);
        return $db->query($sql);
    }


    public static function findAllInColumn($column, $value)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table . ' WHERE '. $column .'=:val';
        $db = new DB;

        $db->setClassName($class);
        return $db->query($sql, [':val' => $value]);
    }


    public static function findOneInColumn($column, $value)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table . ' WHERE '. $column .'=:val';
        $db = new DB;

        $db->setClassName($class);
        $res = $db->query($sql, [':val' => $value])[0];

        return $res;
    }



}