<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Doctor;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    //列表页面
    public function list()
    {
        $doctor = Doctor::query()->where('code','=',auth()->user()->username)->first();
        $doctor_id = 0;
        if($doctor){
            $doctor_id = $doctor->id;
        }
        $data = $doctor_id;
        return view('admin.plan.list',compact('data'));
    }
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Plan::class);
        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        $data->map(function(Plan $plan){
            $doctor = Doctor::query()->where('id','=',$plan->doctor_id)->first();
            if($doctor){
                $plan->doctor = $doctor->name;
            }
        });
        return $this->outTableData($data,$count);
    }
    //新增保存方法
    public function save(Request $request)
    {
        $flag = Plan::create($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Plan::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $int = Plan::destroy($request->get('id'));
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }
}
