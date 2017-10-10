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

}