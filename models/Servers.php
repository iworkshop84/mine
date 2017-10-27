<?php


namespace App\Models;

use App\Classes\DB;

class Servers
    extends AbstractM
{
    protected static $table = 'servers';




    public function serverPrepData($data)
    {
        $this->name = $data['HostName'];
        $this->players = $data['Players'];
        $this->maxplayers = $data['MaxPlayers'];
        $this->online = 1;
        $this->regtime = date('Y:m:d H:i:s', time());

        if(!empty($_SESSION['uid']))
        {
            $this->uid = $_SESSION['uid'];
        }

        // очищаем версию сервера от разного мусора
        $pattern = '/([0-9]+\.[0-9]+\.[0-9]+)|([0-9]+\.[0-9]+)/';
        preg_match($pattern, $data['Version'], $matches);

        // закидываем в объект версию сервера
        $this->version = $matches[0];

        // если каким то макаром версии сервера всё же нет - ставил дефолтную
        if(!isset($this->version)){
            $this->version = '1.12';
        }
    }

    public function serverUpdData($data)
    {
        $this->players = $data['Players'];
        $this->maxplayers = $data['MaxPlayers'];
        $this->online = 1;
        $this->updtime = date('Y:m:d H:i:s', time());

    }


    public function serverPrepAdress($adress, $port)
    {
        $this->port = (int)$port;

        if(ip2long($adress))
        {
            $this->ip = $adress;
            $this->host = '';
        }else{
            $record = dns_get_record($adress, DNS_A );
            if(empty($record))
            {
                return false;
            }
            if(isset($record[0]['ip']))
            {
                $this->host = $adress;
                $this->ip = $record[0]['ip'];
            }
        }
    }

    public static function findServerList()
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM version';
        $db = new DB;
        $db->setClassName($class);
        return $db->query($sql);
    }

    public static function findMpropList()
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM mainprop';
        $db = new DB;
        $db->setClassName($class);
        return $db->query($sql);
    }



    public static function findAllOrdVotes()
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table .' ORDER BY votes DESC';
        $db = new DB;
        $db->setClassName($class);
        return $db->query($sql);
    }


    public static function findAllInColumnOrdVotes($column, $value)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table . ' WHERE '. $column .'=:val ORDER BY votes DESC';
        $db = new DB;

        $db->setClassName($class);
        return $db->query($sql, [':val' => $value]);
    }


    public static function findAllMPropOrdVotes($value)
    {
        $class = get_called_class();
        $sql = 'SELECT servers.* FROM `servers`, `mainprop`, `servermp`  
        WHERE mainprop.title =:val AND mainprop.id = servermp.mpropid AND servermp.servid = servers.id ORDER BY votes DESC';
        $db = new DB;

        $db->setClassName($class);
        return $db->query($sql, [':val' => $value]);
    }


    public static function findServerMProp($value)
    {
        $class = get_called_class();
        $sql = 'SELECT mainprop.* FROM `servers`, `servermp`, `mainprop`  
        WHERE servers.id =:val AND servers.id = servermp.servid AND servermp.mpropid = mainprop.id';
        $db = new DB;

        $db->setClassName($class);
        return $db->query($sql, [':val' => $value]);
    }



    public function updateAllConst()
    {
        $arr = $this->data;

        // делаем массив для подготовленного выражения
        $ins =[];
        $rools =[];
        foreach ($arr as $key=>$val){
            $ins[':' . $key] = $val;
            $rools[$key] = $key .' = :' . $key;
        }
        $sql = 'UPDATE '. static::$table .' 
        SET
        '. implode(', ', ($rools)) .'';

        $db = new DB();
        return $db->execute($sql, $ins);

    }

    public function serverDelete($id){

        $sql = 'DELETE FROM servers WHERE id =:val';

        $db = new DB();
        $db->execute($sql, [':val' => $id]);
    }

}