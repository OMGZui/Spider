<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 10:28
 */
namespace Database;

interface DbInterface
{
    function connect($host, $user, $password, $dbName);
    function query($sql);
    function execute($sql);
    function close();
}