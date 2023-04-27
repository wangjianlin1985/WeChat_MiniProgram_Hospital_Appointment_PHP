<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    //黑名单
    protected $guarded = ['imageFile','_token'];

    //查询字段
    const searchFields = [
        ['field'=>'city_id','type'=>'='],
        ['field'=>'name','type'=>'like'],
        ['field'=>'tel','type'=>'like'],
    ];
}
