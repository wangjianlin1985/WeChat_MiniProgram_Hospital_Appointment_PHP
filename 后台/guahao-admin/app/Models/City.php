<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //黑名单
    protected $guarded = [];

    //查询字段
    const searchFields = [
        ['field'=>'name','type'=>'like'],
    ];
}
