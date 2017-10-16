<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/26
 * Time: 11:07
 */

//自动加载
require 'vendor/autoload.php';
use Database\DbMysql;
use Database\MysqliMysql;
use QL\QueryList;

//加载env配置
$dotEnv = new Dotenv\Dotenv(__DIR__);
$dotEnv->load();

//获取mysql实例
$db = DbMysql::getInstance(new MysqliMysql());
//连接
$db->connect(env('DB_HOST'),env('DB_USERNAME'),env('DB_PASSWORD'),env('DB_DATABASE'));
//设置字符串
$db->query("set names 'utf8'");

//phpQuery方式
for ($prop = 0; $prop <= 225; $prop += 25) {
    $url = 'http://movie.douban.com/top250?start='.$prop;
    $html = QueryList::get($url);

    $data = $html->rules([
        'title' => ['.grid_view .info .title:nth-child(1)', 'text'], //标题
        'link' => ['.grid_view .pic a', 'href'], //链接
        'img' => ['.grid_view img', 'src'],//图片
        'desc' => ['.grid_view .info .bd p:nth-child(1)', 'text'],//描述
        'rate' => ['.grid_view .info .bd .star .rating_num', 'text'],//评分
        'number' => ['.grid_view .info .bd .star span:last-child', 'text'],//评分人数
        'quote' => ['.grid_view .info .bd .inq', 'text'],//点评
    ])->query();

    $listData = $data->getData(function ($datum){
        $datum['number'] = mb_substr($datum['number'],0,-3,'utf-8');
        return $datum;
    })->all();

    foreach ($listData as $key => $val) {
        $db->table('films_250')->data($val)->add();
        echo $val['title'] . ' -- ' . $val['rate'] . PHP_EOL;
    }
}


//simple-html-dom方式
//for ($prop = 0; $prop <= 225; $prop += 25) {
//    $url = 'http://movie.douban.com/top250?start='.$prop;
//    $html = file_get_contents($url);
//    $dom = new simple_html_dom($html);
//    $listData = $dom->find('#content .item');
//
//    foreach ($listData as $key => $val) {
//        $film = [
//            'title' => rtrim($val->find(".title", 0)->plaintext),
////            'subtitle' => str_replace(['&nbsp', ';/;'], '', $val->find(".title", 1)->plaintext),
//            'link' => $val->find("img", 0)->parent->attr['href'],
//            'img' => $val->find("img", 0)->src,
//            'rate' => $val->find('.star .rating_num', 0)->plaintext,
//            'quote' => $val->find(".quote .inq", 0)->plaintext,
//        ];
//        $db->table('films_250')->data($film)->add();
//        echo $film['title'] . ' -- ' . $film['rate'] . PHP_EOL;
//    }
//}

//关闭资源
$db->close();
