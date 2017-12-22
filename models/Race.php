<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 09:59
 */

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $table = 'race';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'img',
        'href',
        'follow',
        'start_time',
        'inter_time',
        'apply_status',
        'address',
    ];

}