<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 20:56
 */

require 'vendor/autoload.php';

use QL\QueryList;

$ql = QueryList::getInstance();

//电影信息
$movie = $ql->rules([
    'all' => ['.article .is-active', 'text'],//评论总数
    'img' => ['.aside .movie-pic img', 'src'], //图片
    'link' => ['.aside .movie-pic a', 'href'], //链接
    'name' => ['.aside .attrs p:nth-child(1) a', 'text'], //导演
])->query();

$movieData = $movie->getData(function ($data){
    preg_match('/\d+/',$data['all'],$match);
    $data['all'] = $match[0];
    return $data;
})->all();


$t1 = microtime(true);
//初始化
$login_url = 'https://accounts.douban.com/login';
$movie_url = 'https://movie.douban.com/subject/26363254/comments';
$page_url= '';
$prop = 0;

//登录
//$ql = QueryList::post($login_url, [
//    'form_email' => '18667026376',
//    'form_password' => 'zui862275679'
//]);

//利用登录后的cookie
$cookie = 'bid=pSXjiHIrNCg; gr_user_id=c9f47b14-3754-45e9-bc90-f229ac8eb902; ue="862275679@qq.com"; viewed="26836700_26829016_6559267_10561367_26425651_2073378_1032501_1221479_1024279_4706208"; ps=y; ll="118172"; _vwo_uuid_v2=3824A27A13DC91C4B37F3E9DF5F08B6D|77e066790e7e9a81b5ee141e3a5d9ba6; _pk_ref.100001.4cf6=%5B%22%22%2C%22%22%2C1508309473%2C%22https%3A%2F%2Faccounts.douban.com%2Flogin%3Falias%3D18667026376%26redir%3Dhttps%253A%252F%252Fmovie.douban.com%252Fsubject%252F26363254%252Fcomments%253Fstart%253D0%2526limit%253D20%2526sort%253Dnew_score%2526status%253DP%26source%3Dmovie%26error%3D1011%22%5D; ap=1; dbcl2="70524655:CYeYV9nVNx8"; ck=Vrdk; _pk_id.100001.4cf6=cbdfa770543ec2d5.1507965819.9.1508312995.1508299054.; _pk_ses.100001.4cf6=*; __utma=30149280.1005654760.1508292648.1508297091.1508309473.3; __utmb=30149280.0.10.1508309473; __utmc=30149280; __utmz=30149280.1508309473.3.3.utmcsr=accounts.douban.com|utmccn=(referral)|utmcmd=referral|utmcct=/login; __utma=223695111.1148825139.1507965819.1508299055.1508309473.11; __utmb=223695111.0.10.1508309473; __utmc=223695111; __utmz=223695111.1508309473.11.8.utmcsr=accounts.douban.com|utmccn=(referral)|utmcmd=referral|utmcct=/login; push_noty_num=0; push_doumail_num=0

';

//循环执行
while ($prop < 10) {

    //拿到页数
    $ql = $ql->get($movie_url.$page_url,null,[
        'headers' => [
            'Cookie' => $cookie
        ]
    ]);

    //下一页
    $page_url = $ql->find('#paginator .next ')->attr('href');

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
        echo $listDatum['name'] . '--' . $listDatum['votes'] . PHP_EOL;
    }
    echo "--------------------------------------------- $page_url\n";

    $prop++;

}
$t2 = microtime(true);
echo (($t2 - $t1)/60) . 'm' . PHP_EOL;
