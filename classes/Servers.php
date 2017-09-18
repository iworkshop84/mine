<?php


namespace App\Classes;


class Servers
{

    public $Socket;
    public $Players;
    public $Info;

    public function ResolveSRV( $Address, $Port=25565 )
    {
        if(ip2long($Address) !== false)
        {
            return false;
        }
        $Record = dns_get_record($Address, DNS_A );
        if(empty($Record))
        {
            return false;
        }
        if(isset($Record[0]['ip']))
        {
           return $Address = $Record[0]['ip'];
        }
    }






}