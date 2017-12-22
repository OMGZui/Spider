<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/22
 * Time: 11:08
 */

namespace App\Iranshao;

require __DIR__ . '/../../index.php';

use Models\Race;
use QL\QueryList;
use Tools\Conn;

const URL = 'http://iranshao.com/bundled_races';

Conn::init();

$t1 = microtime(true);

$ql = QueryList::getInstance();

//利用登录后的cookie
//$cookie = 'bid=pSXjiHIrNCg; gr_user_id=c9f47b14-3754-45e9-bc90-f229ac8eb902; ue="862275679@qq.com"; __utmz=223695111.1508384353.12.9.utmcsr=douban.com|utmccn=(referral)|utmcmd=referral|utmcct=/people/omgzui/; viewed="25768396_26836700_26829016_6559267_10561367_26425651_2073378_1032501_1221479_1024279"; _ga=GA1.2.1005654760.1508292648; ap=1; push_noty_num=0; push_doumail_num=0; ll="118172"; _vwo_uuid_v2=3824A27A13DC91C4B37F3E9DF5F08B6D|77e066790e7e9a81b5ee141e3a5d9ba6; __utmz=30149280.1513324541.16.9.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __utmv=30149280.7052; __utmc=30149280; __utmc=223695111; ps=y; dbcl2="70524655:8mprPxrEaR4"; ck=1A5R; _pk_ref.100001.4cf6=%5B%22%22%2C%22%22%2C1513841520%2C%22https%3A%2F%2Fwww.douban.com%2Fpeople%2Fomgzui%2F%22%5D; _pk_ses.100001.4cf6=*; __utma=30149280.1005654760.1508292648.1513837922.1513841520.19; __utmb=30149280.0.10.1513841520; __utma=223695111.1148825139.1507965819.1513837922.1513841520.19; __utmb=223695111.0.10.1513841520; _pk_id.100001.4cf6=cbdfa770543ec2d5.1507965819.17.1513841544.1513839181.
//
//';

$i = 1;

//循环执行
while ($i < 158) {

//    //拿到页数
//    $ql = $ql->get(URL . $page_url, null, [
//        'headers' => [
//            'Cookie' => $cookie
//        ]
//    ]);
//
//    //下一页
//    $page_url = $ql->find('#paginator .next ')->attr('href');

    $ql = $ql->get(URL . '?page=' . $i);

    //规则
    $data = $ql->rules([
        'name' => ['.raceitems .itemname a', 'text'],
        'href' => ['.raceitems .itemname a', 'href'],
        'img' => ['.raceitems .col-lg-7 a img', 'src'],
        'address' => ['.raceitems .col-lg-7 div:nth-child(3)', 'text'],
        'follow' => ['.raceitems .col-lg-7 div:nth-child(4) span:nth-child(2)', 'text'],
        'start_time' => ['.raceitems .col-md-2 .itemtime', 'text'],
        'inter_time' => ['.raceitems .col-md-3 .inter-time', 'text'],
        'apply_status' => ['.raceitems .col-md-3 a', 'text'],
    ])->query();

    //数据
    $listData = $data->getData(function ($datum) {

        if (!array_key_exists("follow", $datum)) {
            $datum['follow'] = 0;
        } else {
            $datum['follow'] = mb_substr($datum['follow'], 0, -4, 'utf-8');
        }

        if (!array_key_exists("href", $datum)) {
            $datum['href'] = 0;
        } else {
            $datum['href'] = URL . $datum['href'];
        }

//        if (mb_strlen($datum['img'],'utf-8') > 500){
//            $datum['img'] = 0;
//        }

        return $datum;
    })->all();

    //存入数据库
    foreach ($listData as $listDatum) {
        Race::query()->create($listDatum);
        echo $listDatum['name'] . '--' . $listDatum['start_time'] . PHP_EOL;
    }
    echo "--------------------- $i ------------------------ \n";

    $i++;

    //老实本分
    if ($i % 8 == 0) {
        sleep(1);
    }

}
$t2 = microtime(true);

echo '总共耗时' . ($t2 - $t1) . '秒' . PHP_EOL;