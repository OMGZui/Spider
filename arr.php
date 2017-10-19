<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/19
 * Time: 10:12
 */

require 'vendor/autoload.php';

$arr = [[1, 2, 3, [5, 9]], [7, [10, [21, 22]]]];

dump($arr);


$t1 = microtime(true);

$result = [];
array_walk_recursive($arr, function($value) use (&$result) {
    array_push($result, $value);
});



function change_multi_to_one($arr)
{
    $rs = [];
    foreach ($arr as $item) {
        if (is_array($item)){
            $rs = array_merge($rs,change_multi_to_one($item));
        }else{
            array_push($rs,$item);
        }
    }

    return $rs;
}

$d = change_multi_to_one($arr);

$t2 = microtime(true);

dump($result);
dump($d);

echo ($t2 - $t1)*1000 . 'ms';

