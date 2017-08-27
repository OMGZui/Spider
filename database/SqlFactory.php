<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 10:51
 */
namespace Database;
class SqlFactory extends Factory
{
    function createPDO()
    {
        return new PdoMysql();
    }

    function createMysqli()
    {
        return new MysqliMysql();
    }
}