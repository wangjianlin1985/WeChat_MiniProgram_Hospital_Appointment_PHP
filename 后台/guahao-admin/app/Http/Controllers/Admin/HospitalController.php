<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    //列表页面
    public function list(Request $request)
    {
        $city_id = $request->get('city_id');
        $city = City::query()->get();
        return view('admin.hospital.list',compact('city',['city_id']));
    }
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Hospital::class);
        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        $data->map(function(Hospital $hospital){
            $departments = Department::query()->where('hospital_id',$hospital->id)->count();
            $hospital->departments = $departments;
            $city = City::find($hospital->city_id);
            if($city){
                $hospital->city = $city->name;
            }
        });
        return $this->outTableData($data,$count);
    }
    //新增页面
    public function add()
    {
        $city = City::query()->get();
        return view('admin.hospital.add',compact('city'));
    }
    //新增保存方法
    public function save(Request $request)
    {
        $flag = Hospital::create($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //编辑跳转页面
    public function edit(Request $request, $id)
    {
        $city = City::query()->get();
        $data = Hospital::where('id',$id)->first();
        return view('admin.hospital.edit',compact('data',['city']));
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Hospital::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $int = Hospital::destroy($request->get('id'));
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }

    //查询select
    public function select(Request $request)
    {
        $city_id = $request->get('city_id',-1);
        $lists = Hospital::query()
            ->where('city_id','=',$city_id) ->get();
        return $this->successJson($lists);
    }
}
