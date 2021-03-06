<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 09:59
 */

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Films250 extends Model
{
    protected $table = 'films_250';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'sub_title',
        'link',
        'img',
        'desc',
        'rate',
        'num',
        'quote'
    ];

}