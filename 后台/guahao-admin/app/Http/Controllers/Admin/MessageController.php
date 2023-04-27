<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Doctor;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //列表页面
    public function list()
    {
        $data = [];
        return view('admin.message.list',compact('data'));
    }
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Message::class);
        if(auth()->user()->role=='doctor'){
            $doctor = Doctor::query()->where('code','=',auth()->user()->username)->first();
            $doctor_id = $doctor->id;
            $query = $query
                ->orWhere(function ($query) use ($doctor_id){
                    $query->where('receive','=','doctor')->where('to_id','=',$doctor_id);
                })
                ->orWhere(function ($query) use ($doctor_id){
                    $query->where('receive','=','customer')->where('from_id','=',$doctor_id);
                })
                ->orderByDesc('id');
        }

        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        $data->map(function (Message $message){
            $receive = $message->receive;
            if($receive=='doctor'){//客户留言
                $doctor = Doctor::where('id','=',$message->to_id)->first();
                if($doctor){
                    $message->to = $doctor->name.'【医生】';
                }
                $customer = Customer::where('id','=',$message->from_id)->first();
                if($customer){
                    $message->from = $customer->username;
                }
            }
            if($receive=='customer'){//医生留言
                $doctor = Doctor::where('id','=',$message->from_id)->first();
                if($doctor){
                    $message->from = $doctor->name.'【医生】';
                }
                $customer = Customer::where('id','=',$message->to_id)->first();
                if($customer){
                    $message->to = $customer->username;
                }
            }
        });
        return $this->outTableData($data,$count);
    }
    //新增保存方法
    public function save(Request $request)
    {
        $flag = Message::create($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Message::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $int = Message::destroy($request->get('id'));
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }

    //列表页面
    public function doctor()
    {
        $data = [];
        return view('admin.message.doctor',compact('data'));
    }
}
