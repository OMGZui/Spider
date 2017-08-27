<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 10:37
 */
namespace Database;
abstract class Factory
{
    abstract function createPDO();
    abstract function createMysqli();
}