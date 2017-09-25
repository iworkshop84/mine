<?php


namespace App\Models;


class Servers
    extends AbstractM
{
    protected static $table = 'servers';



/*
    public function getIpHost($adress)
    {
        // не работает, не знаю как вернуть два присвоения ретурном
        // основной вывод в контроллере сервера при определении хоста и имени
        if(ip2long($adress[0]))
        {
            $this->ip = $adress[0];
            $this->host = null;
        }else{
            $record = dns_get_record($adress[0], DNS_A );
            if(empty($record))
            {
                return false;
            }
            if(isset($record[0]['ip']))
            {
                $this->host = $adress[0];
                $this->ip = $record[0]['ip'];
            }
        }
    }
*/



}