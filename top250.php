<?php

require 'conn.php';

use Illuminate\Database\Capsule\Manager as Capsule;

for ($prop = 0; $prop <= 225; $prop += 25) {
	$url = 'http://movie.douban.com/top250?start='.$prop;
    $html = file_get_contents($url);
    $dom = new simple_html_dom($html);
    $listData = $dom->find('#content .item');

    foreach ($listData as $key => $val) {
        $film = [
            'title' => rtrim($val->find(".title", 0)->plaintext),
            'subtitle' => str_replace(['&nbsp', ';/;'], '', $val->find(".title", 1)->plaintext),
            'link' => $val->find("img", 0)->parent->attr['href'],
            'img' => $val->find("img", 0)->src,
            'rate' => $val->find('.star .rating_num', 0)->plaintext,
            'quote' => $val->find(".quote .inq", 0)->plaintext,
        ];
        Capsule::table('films')->insert($film);
        echo $film['title'] . ' -- ' . $film['rate'] . PHP_EOL;
    }
}
