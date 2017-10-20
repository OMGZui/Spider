<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/20
 * Time: 11:55
 */


require 'vendor/autoload.php';
require 'conn.php';


use Films250\Wolf;


$client = new Predis\Client(['host' => env('REDIS_HOST')]);
$t1 = microtime(true);

$e = Wolf::query()->limit(200000)->get();
$t2 = microtime(true);
echo (($t2 - $t1)) . 's' . PHP_EOL; // 20w => 1.1464049816132s


$t1 = microtime(true);
$r = collect($e)->map(function ($part) use($client){
    $part['name'] = json_decode($part['name']);
    $part['content'] = json_decode($part['content']);
    //用list存储电影id
    $client->rpush('film:id',$part['id']);
    //用hash存储电影内容
    $client->hmset("film:{$part['id']}", [
            'id' => $part['id'],
            'name' => $part['name'],
            'content' => $part['content'],
            'votes' => $part['votes'],
            'time' => $part['time']
        ]
    );
    //用set存储对应的name
    $client->sadd("film:{$part['id']}:name",$part['name']);
    //冗余用set存储人对应id
    $client->sadd("film:{$part['name']}:id",$part['id']);
    return $part;
});
$t2 = microtime(true);
echo (($t2 - $t1)) . 's' . PHP_EOL; // 20w => 57.461776018143s

$t1 = microtime(true);
$ids = $client->lrange('film:id',0,-1);

$films = [];
foreach ($ids as $item) {
    $films[] = $client->hmget("film:{$item}",['id','name','content','votes','time']);
}

$t2 = microtime(true);
echo (($t2 - $t1)) . 's' . PHP_EOL;  // 20w => 32.214903831482s

//dump($r->toArray());
//dump($films);
