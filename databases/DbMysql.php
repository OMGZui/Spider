<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 09:56
 */
namespace Database;

class DbMysql
{
    protected static $instance;

    //单例
    final private function __construct(){}
    final private function __clone(){}

    public static function getInstance(DbInterface $db)
    {
        if(self::$instance === null){
            self::$instance = $db;
        }
        return self::$instance;
    }
}
