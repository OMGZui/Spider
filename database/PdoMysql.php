<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 10:29
 */
namespace Database;

class PdoMysql implements DbInterface
{
    use Builder;
    public $db;

    function connect($host, $user, $password, $dbName)
    {
        $conn = new \PDO("mysql:host=$host;dbname=$dbName",$user,$password);
        $this->db = $conn;
    }

    function query($sql)
    {
        return $this->db->query($sql);
    }

    function execute($sql)
    {
        $this->lastSql = $sql;
        return $this->query($sql);
    }

    function close()
    {
        unset($this->db);
    }

}