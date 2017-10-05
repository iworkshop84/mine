<?php


namespace App\Models;

use App\Classes\DB;

class AbstractM
{
    protected static $table;

    // поменял свойство на паблик!
    public $data = [];

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

    public function insert()
    {
        $arr = $this->data;

        $ins =[];
        foreach ($arr as $key=>$val){
            $ins[':' . $key] = $val;
        }

        $sql = 'INSERT INTO '. static::$table .' ('. implode(', ', array_keys($arr)) .') 
        VALUES 
        ('. implode(', ', array_keys($ins)) .')';

        $db = new DB();
        $db->execute($sql, $ins);
        return $db->lastInsId();
    }

    public function update()
    {
        $arr = $this->data;

        // делаем массив для подготовленного выражения
        $ins =[];
        $rools =[];
        foreach ($arr as $key=>$val){
            $ins[':' . $key] = $val;
            $rools[$key] = $key .' = :' . $key;
        }

        // Удаляем из массива условий ключ id(он у нас всегда будет идти в свойствах первый)
        $where = array_shift($rools);


        $sql = 'UPDATE '. static::$table .' 
        SET
        '. implode(', ', ($rools)) .'
        WHERE 
        ('. $where .')';


        $db = new DB();
        return $db->execute($sql, $ins);

    }

    public static function findOneFromTwoColumn($column1, $column2, $value1, $value2)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table . ' WHERE '. $column1 .'=:val1 AND '. $column2 .'=:val2';
        $db = new DB;

        $db->setClassName($class);
        $res = $db->query($sql, [':val1' => $value1, ':val2' => $value2])[0];

        return $res;
    }


}