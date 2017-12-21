<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/21
 * Time: 15:34
 */

namespace App\DouBan\Wolf;

require __DIR__ . '/../index.php';

use Models\Wolf;
use QL\QueryList;
use Tools\Conn;

const MOVIE_URL = 'https://movie.douban.com/subject/26363254/comments';

Conn::init();

$t1 = microtime(true);

$ql = QueryList::getInstance();

//利用登录后的cookie
$cookie = 'bid=pSXjiHIrNCg; gr_user_id=c9f47b14-3754-45e9-bc90-f229ac8eb902; ue="862275679@qq.com"; __utmz=223695111.1508384353.12.9.utmcsr=douban.com|utmccn=(referral)|utmcmd=referral|utmcct=/people/omgzui/; viewed="25768396_26836700_26829016_6559267_10561367_26425651_2073378_1032501_1221479_1024279"; _ga=GA1.2.1005654760.1508292648; ap=1; push_noty_num=0; push_doumail_num=0; ll="118172"; _vwo_uuid_v2=3824A27A13DC91C4B37F3E9DF5F08B6D|77e066790e7e9a81b5ee141e3a5d9ba6; __utmz=30149280.1513324541.16.9.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __utmv=30149280.7052; __utmc=30149280; __utmc=223695111; ps=y; dbcl2="70524655:8mprPxrEaR4"; ck=1A5R; _pk_ref.100001.4cf6=%5B%22%22%2C%22%22%2C1513841520%2C%22https%3A%2F%2Fwww.douban.com%2Fpeople%2Fomgzui%2F%22%5D; _pk_ses.100001.4cf6=*; __utma=30149280.1005654760.1508292648.1513837922.1513841520.19; __utmb=30149280.0.10.1513841520; __utma=223695111.1148825139.1507965819.1513837922.1513841520.19; __utmb=223695111.0.10.1513841520; _pk_id.100001.4cf6=cbdfa770543ec2d5.1507965819.17.1513841544.1513839181.

';

$page_url = '?start=0&limit=20&sort=new_score&status=P&percent_type=';
$i = 0;

//循环执行
while ($i < 100) {
    //拿到页数
    $ql = $ql->get(MOVIE_URL . $page_url, null, [
        'headers' => [
            'Cookie' => $cookie
        ]
    ]);

    //下一页
    $page_url = $ql->find('#paginator .next ')->attr('href');

    //规则
    $data = $ql->rules([
        'avatar' => ['.avatar a img', 'src'],//评论人头像
        'user_link' => ['.avatar a', 'href'],//评论人链接
        'name' => ['.comment .comment-info a', 'text'],//评论人名字
        'rate' => ['.comment .comment-info .rating', 'title'],//评论人评分
        'star' => ['.comment .comment-info .rating', 'class'],//评论人星级
        'content' => ['.comment p', 'text'], //内容
        'vote' => ['.comment .comment-vote .votes', 'text'], //投票
        'time' => ['.comment .comment-time', 'title'], //评论时间
    ])->query();

    //数据
    $listData = $data->getData(function ($datum) {
        if (! array_key_exists("rate",$datum)){
            $datum['rate'] = 0;
        }

        if (! array_key_exists("star",$datum)) {
            $datum['star'] = 0;
        }else{
            $datum['star'] = mb_substr($datum['star'], 7, 1, 'utf-8');
        }

        return $datum;
    })->all();


    //存入数据库
    foreach ($listData as $listDatum) {
        Wolf::query()->create($listDatum);
        echo $listDatum['name'] . '--' . $listDatum['rate'] . PHP_EOL;
    }
    echo "--------------------- $i.$page_url ------------------------ \n";

    $i++;

    //老实本分
    if ($i % 8 == 0) {
        sleep(1);
    }

}
$t2 = microtime(true);

echo '总共耗时' . ($t2 - $t1) . '秒' . PHP_EOL;
