<?php


namespace App\Classes;


class Servers
{



    public function ResolveSRV($address)
    {
        if(ip2long($address) !== false)
        {
            return $address;
        }
        $record = dns_get_record($address, DNS_A );
        if(empty($record))
        {
            return false;
        }
        if(isset($record[0]['ip']))
        {
           return $address = $record[0]['ip'];
        }
    }






}