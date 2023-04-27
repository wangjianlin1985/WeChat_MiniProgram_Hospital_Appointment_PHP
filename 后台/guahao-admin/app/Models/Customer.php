<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //黑名单
    protected $guarded = [];

    //查询字段
    const searchFields = [
        ['field'=>'phone','type'=>'like'],
    ];
}
