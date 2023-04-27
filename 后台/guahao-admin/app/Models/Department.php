<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //黑名单
    protected $guarded = [];

    //查询字段
    const searchFields = [
        ['field'=>'hospital_id','type'=>'='],
        ['field'=>'name','type'=>'like'],
        ['field'=>'tel','type'=>'like'],
    ];
}
