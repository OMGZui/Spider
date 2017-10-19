<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 20:56
 */

require 'vendor/autoload.php';
require 'conn.php';

use QL\QueryList;
use Films250\Wolf;

$ql = QueryList::getInstance();

//电影信息
//$movie = $ql->rules([
//    'all' => ['.article .is-active', 'text'],//评论总数
//    'img' => ['.aside .movie-pic img', 'src'], //图片
//    'link' => ['.aside .movie-pic a', 'href'], //链接
//    'name' => ['.aside .attrs p:nth-child(1) a', 'text'], //导演
//])->query();
//
//$movieData = $movie->getData(function ($data){
//    preg_match('/\d+/',$data['all'],$match);
//    $data['all'] = $match[0];
//    return $data;
//})->all();


$t1 = microtime(true);
//初始化
$login_url = 'https://accounts.douban.com/login';
$movie_url = 'https://movie.douban.com/subject/26363254/comments';
$page_url= '?start=156361&limit=20&sort=new_score&status=P';
$prop = 0;

//登录
//$ql = QueryList::post($login_url, [
//    'form_email' => '18667026376',
//    'form_password' => 'zui862275679'
//]);

//利用登录后的cookie
$cookie = 'bid=pSXjiHIrNCg; gr_user_id=c9f47b14-3754-45e9-bc90-f229ac8eb902; ue="862275679@qq.com"; viewed="26836700_26829016_6559267_10561367_26425651_2073378_1032501_1221479_1024279_4706208"; ps=y; ll="118172"; _vwo_uuid_v2=3824A27A13DC91C4B37F3E9DF5F08B6D|77e066790e7e9a81b5ee141e3a5d9ba6; ap=1; dbcl2="70524655:Q5dtjKQJubc"; ck=PtFJ; _pk_ref.100001.4cf6=%5B%22%22%2C%22%22%2C1508393017%2C%22https%3A%2F%2Fwww.douban.com%2Fpeople%2Fomgzui%2F%22%5D; __utmt=1; __utma=30149280.1005654760.1508292648.1508384344.1508393017.5; __utmb=30149280.2.10.1508393017; __utmc=30149280; __utmz=30149280.1508309473.3.3.utmcsr=accounts.douban.com|utmccn=(referral)|utmcmd=referral|utmcct=/login; __utmv=30149280.7052; __utma=223695111.1148825139.1507965819.1508384353.1508393017.13; __utmb=223695111.0.10.1508393017; __utmc=223695111; __utmz=223695111.1508384353.12.9.utmcsr=douban.com|utmccn=(referral)|utmcmd=referral|utmcct=/people/omgzui/; _pk_id.100001.4cf6=cbdfa770543ec2d5.1507965819.11.1508393041.1508384529.; _pk_ses.100001.4cf6=*; push_noty_num=0; push_doumail_num=0

';

//循环执行
while ($prop < 10000) {

    //拿到页数
    $ql = $ql->get($movie_url.$page_url,null,[
        'headers' => [
            'Cookie' => $cookie
        ]
    ]);

//    dump($ql);

    //下一页
    $page_url = $ql->find('#paginator .next ')->attr('href');

//    dd($page_url);

    //规则
    $data = $ql->rules([
        'name' => ['.comment .comment-info a', 'text'],//评论人名字
        'content' => ['.comment p', 'text'], //内容
        'votes' => ['.comment .comment-vote .votes', 'text'], //投票
        'time' => ['.comment .comment-time', 'text'], //评论时间
    ])->query();

    //数据
    $listData = $data->getData()->all();


    //输出
    foreach ($listData as $listDatum) {
        $listDatum['name'] = json_encode(trim($listDatum['name']));
        $listDatum['content'] = json_encode(trim($listDatum['content']));
        Wolf::query()->create($listDatum);
        echo $listDatum['name'] . '--' . $listDatum['content'] . PHP_EOL;
    }
    echo "--------------------------------------------- $prop.$page_url\n";

    $prop++;
    if ($prop%8 == 0){
        sleep(1);
    }

}
$t2 = microtime(true);
echo (($t2 - $t1)/60) . 'm' . PHP_EOL;
