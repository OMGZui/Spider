<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 11:07
 */

namespace App\DouBan\Top250;

//自动加载
require __DIR__.'/../index.php';

use Database\DbMysql;
use Database\Pdo;
use QL\QueryList;
use Tools\Conn;

const URL = 'http://movie.douban.com/top250';

//加载env配置
Conn::initEnv();

//获取mysql实例
$db = DbMysql::getInstance(new Pdo());
//连接
$db->connect(env('DB_HOST'),env('DB_USERNAME'),env('DB_PASSWORD'),env('DB_DATABASE'));
//设置字符串
$db->query("set names 'utf8'");

//phpQuery方式
$t1 = microtime(true);
for ($i = 0; $i <= 225; $i += 25) {
    $html = QueryList::get(URL.'?start='.$i);

    $data = $html->rules([
        'title' => ['.grid_view .info .title:nth-child(1)', 'text'], //标题
        'sub_title' => ['.grid_view .info .title:nth-child(2)', 'text'], //副标题
        'link' => ['.grid_view .pic a', 'href'], //链接
        'img' => ['.grid_view img', 'src'],//图片
        'desc' => ['.grid_view .info .bd p:nth-child(1)', 'text'],//描述
        'rate' => ['.grid_view .info .bd .star .rating_num', 'text'],//评分
        'num' => ['.grid_view .info .bd .star span:last-child', 'text'],//评分人数
        'quote' => ['.grid_view .info .bd .inq', 'text'],//点评
    ])->query();

    $listData = $data->getData(function ($datum) {
        $datum['sub_title'] = !empty($datum['sub_title']) ? mb_substr($datum['sub_title'], 3, 50, 'utf-8') : '';
        $datum['num'] = mb_substr($datum['num'], 0, -3, 'utf-8');
        return $datum;
    })->all();

    foreach ($listData as $key => $val) {
        $db->table('films_250')->data($val)->add();
        echo $val['title'] . ' -- ' . $val['num'] . PHP_EOL;
    }
}

//关闭资源
$db->close();
$t2 = microtime(true);

echo '总共耗时'.($t2-$t1).'秒'.PHP_EOL; //总共耗时6.5155351161957秒
