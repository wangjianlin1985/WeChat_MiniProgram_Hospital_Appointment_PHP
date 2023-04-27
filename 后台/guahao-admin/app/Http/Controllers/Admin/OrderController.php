<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\Plan;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //列表页面
    public function list()
    {
        $data = [];
        return view('admin.order.list',compact('data'));
    }

    //今日订单
    public function day()
    {
        date_default_timezone_set('Asia/Shanghai');//设置中国上海时区，要不获取时间有时差
        $day = date('Y-m-d');
        return view('admin.order.day',compact('day'));
    }

    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Order::class);
        if(auth()->user()->role=='doctor'){
            $doctor = Doctor::query()->where('code','=',auth()->user()->username)->first();
            $doctor_id = $doctor->id;
            $query = $query->where('doctor_id','=',$doctor_id);
        }
        $today = $request->get('today');
        if($today){
            $planIds = Plan::query()
                ->where('date','=',$today)
                ->get('id');
            //$ids = $planIds->implode('id',','); //转化字符串
            $query = $query->whereIn('plan_id',$planIds);
        }

        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        $data->map(function(Order $order){
            if($order->order_plan){
                $order->date = $order->order_plan->date;
                $order->time = $order->order_plan->time;
                if($order->order_plan->plan_doctor){
                    $order->doctor = $order->order_plan->plan_doctor->name;
                }
            }
            if($order->order_customer){
                $order->customer = $order->order_customer->username.' / '.$order->order_customer->phone;
            }
        });
        return $this->outTableData($data,$count);
    }

    //修改保存方法
    public function update(Request $request)
    {
        $flag = Order::query()->where('id',$request->get('id'))->first()
            ->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('操作失败，请检查数据后重试...');
        return $json;
    }

    //删除
    public function delete(Request $request)
    {
        $order = Order::query()->where('id','=',$request->get('id'))->first();
        $int = Order::destroy($request->get('id'));
        $plan = Plan::query()->where('id',$order->plan_id)->first();
        $plan->status = 0;
        $plan->save();
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }
}
