<?php


namespace App\Classes;




class MinecraftQuery
{
    /*
     * Class written by xPaw
     *
     * Website: http://xpaw.ru
     * GitHub: https://github.com/xPaw/PHP-Minecraft-Query
     */

    const STATISTIC = 0x00;
    const HANDSHAKE = 0x09;

    private $Socket;
    private $Players;
    private $Info;

    public function Connect($ip, $Port = 25565, $Timeout = 2)
    {
        if(!is_int($Timeout) || $Timeout < 0)
        {
            throw new \Exception( 'Timeout must be an integer.' );
        }

        $this->Socket = @FSockOpen('udp://' . self::ResolveSRV($ip), (int)$Port, $ErrNo, $ErrStr, $Timeout);

        if($ErrNo || $this->Socket === false)
        {
            return false;
            //throw new \Exception( 'Could not create socket: ' . $ErrStr );
        }

        Stream_Set_Timeout($this->Socket, $Timeout);
        Stream_Set_Blocking($this->Socket, true);

        try
        {
            $Challenge = $this->GetChallenge();

            $this->GetStatus($Challenge);
        }
            // We catch this because we want to close the socket, not very elegant
        catch( \Exception $e )
        {
            FClose($this->Socket);

            throw new \Exception($e->getMessage());
        }

        fclose($this->Socket);
    }


    public function GetInfo()
    {
        return isset($this->Info) ? $this->Info : false;
    }

    public function GetPlayers()
    {
        return isset($this->Players) ? $this->Players : false;
    }

    private function GetChallenge()
    {
        $Data = $this->WriteData(self :: HANDSHAKE);


        if($Data === false)
        {
           return false;
            //throw new \Exception( "Ебучий случай!!Failed to receive challenge." );
        }

        return Pack('N', $Data);
    }

    private function GetStatus($Challenge)
    {
        $Data = $this->WriteData(self :: STATISTIC, $Challenge . Pack( 'c*', 0x00, 0x00, 0x00, 0x00));

        if( !$Data )
        {
            return false;
            //throw new \Exception( "Failed to receive status." );
        }

        $Last = "";
        $Info = Array();

        $Data    = SubStr( $Data, 11 ); // splitnum + 2 int
        $Data    = Explode( "\x00\x00\x01player_\x00\x00", $Data );
        $Players = SubStr( $Data[ 1 ], 0, -2 );
        $Data    = Explode( "\x00", $Data[ 0 ] );

        // Array with known keys in order to validate the result
        // It can happen that server sends custom strings containing bad things (who can know!)
        $Keys = Array(
            'hostname'   => 'HostName',
            'gametype'   => 'GameType',
            'version'    => 'Version',
            'plugins'    => 'Plugins',
            'map'        => 'Map',
            'numplayers' => 'Players',
            'maxplayers' => 'MaxPlayers',
            'hostport'   => 'HostPort',
            'hostip'     => 'HostIp'
        );

        foreach($Data as $Key => $Value)
        {
            if( ~$Key & 1 )
            {
                if( !Array_Key_Exists($Value, $Keys))
                {
                    $Last = false;
                    continue;
                }

                $Last = $Keys[$Value];
                $Info[$Last] = "";
            }
            else if($Last != false )
            {
                $Info[$Last] = $Value;
            }
        }

        // Ints
        $Info['Players']    = IntVal($Info['Players']);
        $Info['MaxPlayers'] = IntVal($Info['MaxPlayers']);
        $Info['HostPort']   = IntVal($Info['HostPort']);

        // Parse "plugins", if any
        if( $Info['Plugins'] )
        {
            $Data = Explode(": ", $Info['Plugins'], 2);

            $Info['RawPlugins'] = $Info['Plugins'];
            $Info['Software']   = $Data[0];

            if( Count($Data) == 2)
            {
                $Info['Plugins'] = Explode("; ", $Data[1]);
            }
        }
        else
        {
            $Info['Software'] = 'Vanilla';
        }

        $this->Info = $Info;

        if( $Players )
        {
            $this->Players = Explode("\x00", $Players);
        }
    }

    private function WriteData($Command, $Append = "")
    {
        $Command = Pack('c*', 0xFE, 0xFD, $Command, 0x01, 0x02, 0x03, 0x04) . $Append;
        $Length  = StrLen($Command);

        if( $Length !== FWrite($this->Socket, $Command, $Length))
        {
            return false;
            //throw new \Exception( "Failed to write on socket." );
        }

        $Data = FRead($this->Socket, 2048);

        if( $Data === false )
        {
            return false;
            //throw new \Exception( "Failed to read from socket." );
        }

        if(StrLen($Data) < 5 || $Data[0] != $Command[2])
        {
            return false;
        }

        return SubStr($Data, 5);
    }

    private function ResolveSRV($ip)
    {
        if(ip2long($ip) !== false)
        {
            return $ip;
        }
        $Record = dns_get_record($ip, DNS_A);
        if(empty($Record))
        {
            return false;
        }
        if(isset($Record[0]['ip']))
        {
            return $ip = $Record[0]['ip'];
        }

    }

}