<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/25
 * Time: 22:38
 */
namespace Tools;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

trait Conn
{
    /**
     * 初始化
     */
    public static function init()
    {
        self::initEnv();
        self::initDb();
    }

    /**
     * 初始化env
     */
    public static function initEnv()
    {
        //加载env配置
        $dotEnv = new Dotenv(__DIR__.'/../');
        $dotEnv->load();
    }

    /**
     * 初始化db
     */
    public static function initDb()
    {
        $capsule = new Capsule();
        $db = [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_bin',
            'prefix' => '',
        ];

        $capsule->addConnection($db);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }

}
