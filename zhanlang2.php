<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 15:02
 */

require 'vendor/autoload.php';

use QL\QueryList;

$url = 'https://movie.douban.com/subject/26363254/comments?start=0&limit=20&sort=new_score&status=P';
$html = QueryList::get($url);


//电影信息
$movie = $html->rules([
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

dd($movieData);

$data = $html->rules([
    'name' => ['.comment .comment-info a', 'text'],//评论人名字
    'content' => ['.comment p', 'text'], //内容
    'votes' => ['.comment .comment-vote .votes', 'text'], //投票
    'time' => ['.comment .comment-time', 'text'], //评论时间
])->query();

$listData = $data->getData(function ($data){
    return $data;
})->all();


dd($listData);
