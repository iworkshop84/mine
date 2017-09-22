<?php


namespace App\Classes;



class MinecraftPing
{
    /*
     * Queries Minecraft server
     * Returns array on success, false on failure.
     *
     * WARNING: This method was added in snapshot 13w41a (Minecraft 1.7)
     *
     * Written by xPaw
     *
     * Website: http://xpaw.me
     * GitHub: https://github.com/xPaw/PHP-Minecraft-Query
     *
     * ---------
     *
     * This method can be used to get server-icon.png too.
     * Something like this:
     *
     * $Server = new MinecraftPing( 'localhost' );
     * $Info = $Server->Query();
     * echo '<img width="64" height="64" src="' . Str_Replace( "\n", "", $Info[ 'favicon' ] ) . '">';
     *
     */
    private $Socket;
    private $ServerAddress;
    private $ServerPort;
    private $Timeout;
    public function __construct($Address, $Port = 25565, $Timeout = 2, $ResolveSRV = true)
    {
        $this->ServerAddress = $Address;
        $this->ServerPort = (int)$Port;
        $this->Timeout = (int)$Timeout;
        if($ResolveSRV)
        {
            $this->ResolveSRV();
        }
        $this->Connect();
    }
    public function __destruct()
    {
        $this->Close();
    }
    public function Close()
    {
        if($this->Socket !== null)
        {
            fclose($this->Socket);
            $this->Socket = null;
        }
    }
    public function Connect()
    {
        //$connectTimeout = $this->Timeout;
        $this->Socket = @fsockopen('tcp://' . $this->ServerAddress, $this->ServerPort, $errno, $errstr, $this->Timeout);

        if(!$this->Socket)
        {
            return false;
            //throw new \Exception( "Failed to connect or create a socket: $errno ($errstr)" );
        }
        // Set Read/Write timeout
        stream_set_timeout( $this->Socket, $this->Timeout );
    }


    public function Query()
    {
        $TimeStart = microtime(true); // for read timeout purposes
        // See http://wiki.vg/Protocol (Status Ping)
        $Data = "\x00"; // packet ID = 0 (varint)
        $Data .= "\x04"; // Protocol version (varint)
        $Data .= Pack( 'c', StrLen( $this->ServerAddress ) ) . $this->ServerAddress; // Server (varint len + UTF-8 addr)
        $Data .= Pack( 'n', $this->ServerPort ); // Server port (unsigned short)
        $Data .= "\x01"; // Next state: status (varint)
        $Data = Pack( 'c', StrLen( $Data ) ) . $Data; // prepend length of packet ID + data
        fwrite( $this->Socket, $Data ); // handshake
        fwrite( $this->Socket, "\x01\x00" ); // status ping
        $Length = $this->ReadVarInt( ); // full packet length
        if( $Length < 10 )
        {
            return FALSE;
        }
        fgetc( $this->Socket ); // packet type, in server ping it's 0
        $Length = $this->ReadVarInt( ); // string length
        $Data = "";
        do
        {
            if (microtime(true) - $TimeStart > $this->Timeout)
            {
                return false;
                //throw new \Exception( 'Server read timed out' );
            }
            $Remainder = $Length - StrLen( $Data );
            $block = fread( $this->Socket, $Remainder ); // and finally the json string
            // abort if there is no progress
            if (!$block)
            {
                return false;
                //throw new \Exception( 'Server returned too few data' );
            }
            $Data .= $block;
        } while( StrLen($Data) < $Length );
        if( $Data === FALSE )
        {
            return false;
            //throw new \Exception( 'Server didn\'t return any data' );
        }

        $Data = JSON_Decode( $Data, true );
        if( JSON_Last_Error( ) !== JSON_ERROR_NONE )
        {
            if( Function_Exists( 'json_last_error_msg' ) )
            {
                return false;
                //throw new \Exception( JSON_Last_Error_Msg( ) );
            }
            else
            {
                return false;
                //throw new \Exception( 'JSON parsing failed' );
            }
            return false;
        }
        return $Data;
    }


    public function QueryOldPre17()
    {
        fwrite( $this->Socket, "\xFE\x01" );
        $Data = fread( $this->Socket, 512 );
        $Len = StrLen( $Data );
        if( $Len < 4 || $Data[ 0 ] !== "\xFF" )
        {
            return FALSE;
        }
        $Data = SubStr( $Data, 3 ); // Strip packet header (kick message packet and short length)
        $Data = iconv( 'UTF-16BE', 'UTF-8', $Data );
        // Are we dealing with Minecraft 1.4+ server?
        if( $Data[ 1 ] === "\xA7" && $Data[ 2 ] === "\x31" )
        {
            $Data = Explode( "\x00", $Data );
            return Array(
                'HostName'   => $Data[ 3 ],
                'Players'    => IntVal( $Data[ 4 ] ),
                'MaxPlayers' => IntVal( $Data[ 5 ] ),
                'Protocol'   => IntVal( $Data[ 1 ] ),
                'Version'    => $Data[ 2 ]
            );
        }
        $Data = Explode( "\xA7", $Data );
        return Array(
            'HostName'   => SubStr( $Data[ 0 ], 0, -1 ),
            'Players'    => isset( $Data[ 1 ] ) ? IntVal( $Data[ 1 ] ) : 0,
            'MaxPlayers' => isset( $Data[ 2 ] ) ? IntVal( $Data[ 2 ] ) : 0,
            'Protocol'   => 0,
            'Version'    => '1.3'
        );
    }


    public function QueryLast()
    {
        //$this->Socket = fsockopen("tcp://" . $this->ServerAddress, $this->ServerPort, $errno, $errstr, 3);
        if (!$this->Socket) {
            return false; }
        socket_set_timeout($this->Socket, 5);
        fwrite($this->Socket, "\xFE\x01"); //Send the server list ping request (two bytes)
        @$data = fread($this->Socket, 1024); //Get the info and store it in $data

        if ($data != false && substr($data, 0, 1) == "\xFF") //Ensure we're getting a kick message as expected
        {
            $data = substr($data, 9); //Remove packet, length and starting characters
            $data = explode("\x00\x00", $data); //0000 separated info
            $protocolVersion = $data[0]; //Get it all into separate variables
            @$serverVersion = mb_convert_encoding($data[1], 'UTF-8', 'UCS-2');;
            @$motd = $data[2];
            $motd = mb_convert_encoding($motd, 'UTF-8', 'UCS-2');
            @$players = mb_convert_encoding($data[3], 'UTF-8', 'UCS-2');
            @$max_players = mb_convert_encoding($data[4], 'UTF-8', 'UCS-2');
            sleep(0.2);
            return array('status' => 1,
                'HostName' => $motd,
                'Players' => $players,
                'MaxPlayers' => $max_players,
                'serverVersion' => $serverVersion);

        }
        else
        {
            return false;
        }
    }


    private function ReadVarInt( )
    {
        $i = 0;
        $j = 0;
        while( true )
        {
            $k = @fgetc( $this->Socket );
            if( $k === FALSE )
            {
                return 0;
            }
            $k = Ord( $k );
            $i |= ( $k & 0x7F ) << $j++ * 7;
            if( $j > 5 )
            {
                return false;
                //throw new Exception( 'VarInt too big' );
            }
            if( ( $k & 0x80 ) != 128 )
            {
                break;
            }
        }
        return $i;
    }


    private function ResolveSRV()
    {
        if(ip2long($this->ServerAddress) !== false)
        {
            return;
        }
        $Record = dns_get_record($this->ServerAddress, DNS_A);
        if(empty($Record))
        {
            return;
        }
        if(isset($Record[0]['ip']))
        {
            $this->ServerAddress = $Record[0]['ip'];
        }

    }
}