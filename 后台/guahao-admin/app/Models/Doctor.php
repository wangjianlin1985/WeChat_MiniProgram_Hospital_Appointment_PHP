<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    //黑名单
    protected $guarded = ['file','_token'];

    //查询字段
    const searchFields = [
        ['field'=>'department_id','type'=>'='],
        ['field'=>'name','type'=>'like'],
        ['field'=>'phone','type'=>'='],
        ['field'=>'sex','type'=>'='],
        ['field'=>'intro','type'=>'like'],
    ];

}
