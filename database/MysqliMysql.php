<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 10:53
 */
namespace Database;
class MysqliMysql implements DbInterface
{
    use Builder;
    public $db;
    function connect($host, $user, $password, $dbName)
    {
        $conn = new \mysqli($host, $user, $password, $dbName);
        $this->db = $conn;
    }

    function query($sql)
    {
        return $this->db->query($sql);
    }

    public function execute($sql)
    {
        $this->lastSql = $sql;
//        dd($sql);
        return $this->query($sql);
    }

    function close()
    {
        mysqli_close($this->db);
    }



}