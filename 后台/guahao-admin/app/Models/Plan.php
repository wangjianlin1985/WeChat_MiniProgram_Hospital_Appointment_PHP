<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //黑名单
    protected $guarded = ['doctor'];

    //查询字段
    const searchFields = [
        ['field'=>'doctor_id','type'=>'='],
        ['field'=>'date','type'=>'like'],
    ];

    //预约医生
    public function plan_doctor()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }

}
