<?php


namespace App\Models;


class Servers
    extends AbstractM
{
    protected static $table = 'servers';




    public function serverPrepData($data)
    {
        $this->name = $data['HostName'];
        $this->players = $data['Players'];
        $this->maxplayers = $data['MaxPlayers'];

        // очищаем версию сервера от разного мусора
        $pattern = '/([0-9]+\.[0-9]+\.[0-9]+)|([0-9]+\.[0-9]+)/';
        preg_match($pattern, $data['Version'], $matches);

        // закидываем в объект версию сервера
        $this->version = $matches[0];

        if(!isset($this->version)){
            $this->version = '1.12';
        }
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



}