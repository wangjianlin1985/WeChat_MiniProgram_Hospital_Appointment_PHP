<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //黑名单
    protected $guarded = [];

    //查询字段
    const searchFields = [
        ['field'=>'openid','type'=>'='],
        ['field'=>'doctor_id','type'=>'='],
        ['field'=>'is_pay','type'=>'='],
        ['field'=>'status','type'=>'='],
        ['field'=>'order_no','type'=>'='],
        ['field'=>'created_at','type'=>'like'],
    ];

    //预约医生
    public function order_plan()
    {
        return $this->belongsTo(Plan::class,'plan_id','id');
    }

    //预约人
    public function order_customer()
    {
        return $this->belongsTo(Customer::class,'openid','openid');
    }

}
