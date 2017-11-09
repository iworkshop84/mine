<?php

namespace App\Models;
use App\Classes\DB;

class Images
    extends AbstractM
{
    protected static $table = 'serverimages';


    public function deleteimg($imgname)
    {
        $sql = 'DELETE FROM '. static::$table . ' 
        WHERE 
        (imgname = :name)';

        $db = new DB();
        $db->execute($sql, [':name' => $imgname]);
    }

}