<?php


namespace App\Models;
use App\Classes\DB;

class Votes
    extends AbstractM
{
    protected static $table = 'votes';


    public static function findVotepList($value)
    {
        $class = get_called_class();
        $sql = 'SELECT * FROM votes WHERE ip=:val';
        $db = new DB;

        $db->setClassName($class);
        $res = $db->query($sql, [':val' => $value])[0];
        return $res;
    }

    public static function cleanDayVotes()
    {
        $sql = 'TRUNCATE TABLE votes';

        $db = new DB();
        $db->execute($sql);
    }


}