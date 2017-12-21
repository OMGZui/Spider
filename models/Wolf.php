<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 09:59
 */

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Wolf extends Model
{
    protected $table = 'wolf';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'avatar',
        'user_link',
        'name',
        'rate',
        'star',
        'content',
        'vote',
        'time'
    ];

}