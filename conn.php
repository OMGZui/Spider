<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/25
 * Time: 22:38
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$db = [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST'),
    'database'  => env('DB_DATABASE'),
    'username'  => env('DB_USERNAME'),
    'password'  => env('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',

];

$capsule->addConnection($db);

$capsule->setAsGlobal();

$capsule->bootEloquent();