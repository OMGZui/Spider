<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/10/16
 * Time: 09:59
 */

namespace Films250;

use Illuminate\Database\Eloquent\Model;

class Wolf extends Model
{
    protected $table = 'wolf';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['name','content','votes','time'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

}