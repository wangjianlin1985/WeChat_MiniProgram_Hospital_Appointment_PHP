<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //黑名单
    protected $guarded = [];

    //查询字段
    const searchFields = [
        ['field'=>'question','type'=>'like'],
        ['field'=>'questionnaire_id','type'=>'='],
    ];

}
