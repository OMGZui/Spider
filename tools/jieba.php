<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/19
 * Time: 16:29
 */

ini_set('memory_limit', '1024M');

require __DIR__.'/../index.php';

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;

//Jieba::init();
//Finalseg::init();
//
//$seg_list = Jieba::cut("首映礼看的。太恐怖了这个电影，不讲道理的，完全就是吴京在实现他这个小粉红的英雄梦。各种装备轮番上场，视物理逻辑于不顾，不得不说有钱真好，随意胡闹");
//dump($seg_list);



Jieba::init();
Finalseg::init();
JiebaAnalyse::init();

$top_k = 10;
$content = file_get_contents("vendor/fukuball/jieba-php/src/dict/lyric.txt", "r");

$tags = JiebaAnalyse::extractTags($content, $top_k);

dump($tags);