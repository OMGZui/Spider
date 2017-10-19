<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/19
 * Time: 20:44
 */

require 'vendor/autoload.php';


use QL\QueryList;
use QL\Ext\CurlMulti;

$t1 = microtime(true);

$ql = QueryList::getInstance();
$ql->use(CurlMulti::class);

$ql->rules([
    'title' => ['h3 a','text'],
    'link' => ['h3 a','href']
])->curlMulti([
    'https://github.com/trending/php',
    'https://github.com/trending/go'
])->success(function (QueryList $ql,CurlMulti $curl,$r){
    echo "Current url:{$r['info']['url']} \r\n";
    $data = $ql->query()->getData();
    dump($data->all());
})->start();

$t2 = microtime(true);
echo (($t2 - $t1)*1000) . 'ms' . PHP_EOL;

//dump($ql);