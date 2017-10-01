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

        // очищаем версию сервера от разного мусора
        $pattern = '/([0-9]+\.[0-9]+\.[0-9]+)|([0-9]+\.[0-9]+)/';
        preg_match($pattern, $data['Version'], $matches);

        // закидываем в объект версию сервера
        $this->version = $matches[0];

        if(!isset($this->version)){
            $this->version = '1.12';
        }
    }

    public function serverUpdData($data)
    {

        $this->players = $data['Players'];
        $this->maxplayers = $data['MaxPlayers'];
        $this->online = 1;

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


    public static function findOneFromTwoColumn($column1,$column2, $value1, $value2)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM '. static::$table . ' WHERE '. $column1 .'=:val1 AND '. $column2 .'=:val2';
        $db = new DB;

        $db->setClassName($class);
        $res = $db->query($sql, [':val1' => $value1, ':val2' => $value2])[0];

        return $res;
    }



}