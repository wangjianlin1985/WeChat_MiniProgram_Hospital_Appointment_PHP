<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //黑名单
    protected $guarded = ['file'];

    //查询字段
    const searchFields = [
        ['field'=>'title','type'=>'like'],
    ];
}
