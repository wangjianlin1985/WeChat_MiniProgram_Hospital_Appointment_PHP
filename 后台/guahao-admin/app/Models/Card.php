<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //黑名单
    protected $guarded = [];

    //查询字段
    const searchFields = [
        ['field'=>'customer_id','type'=>'='],
        ['field'=>'name','type'=>'like'],
        ['field'=>'idcard','type'=>'like'],
        ['field'=>'phone','type'=>'like'],
    ];
}
