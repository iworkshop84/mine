<?php
namespace App\Classes;

use App\Models\ExceptionM;

class DB{

    private $dbh;
    private $className='stdClass';

    public function __construct()
    {
        try{
            $this->dbh = new \PDO('mysql:dbname=minefr;host=localhost', 'root', '');
            $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $exc){
            throw new ExceptionM ('Ошибка подключения к БД', 2) ;
        }
    }

    public function setClassName($className)
    {
        $this->className = $className;
    }

    public function query($sql, $params=[]){

        $sth = $this->dbh->prepare($sql);
        try{
            $sth->execute($params);
        } catch (\PDOException $exc){
            throw new ExceptionM('Ошибка запроса к БД', 2) ;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $this->className);
    }

    public function execute($sql, $params=[]){

        $sth = $this->dbh->prepare($sql);
        try{
            return $sth->execute($params);
        } catch (\PDOException $exc){
            throw new ExceptionM('Ошибка запроса к БД', 2) ;
        }

    }

    public function lastInsId()
    {
        return $this->dbh->lastInsertId();
    }

    public function truncateTable($table)
    {
        // пока пусть висит в воздухе
    }

}