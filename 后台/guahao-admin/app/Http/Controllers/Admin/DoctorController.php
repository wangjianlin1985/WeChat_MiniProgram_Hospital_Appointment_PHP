<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    //列表页面
    public function list(Request $request)
    {
        $city = City::query()->get();
        $department_id = $request->get('department_id');
        return view('admin.doctor.list',compact('city',['department_id']));
    }
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Doctor::class);
        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        $data->map(function(Doctor $doctor){
            $city = City::find($doctor->city_id);
            if($city){
                $doctor->city = $city->name;
            }
            $hospital = Hospital::find($doctor->hospital_id);
            if($hospital){
                $doctor->hospital = $hospital->name;
            }
            $department = Department::find($doctor->department_id);
            if($department){
                $doctor->department = $department->name;
            }
        });
        return $this->outTableData($data,$count);
    }
    //新增页面
    public function add()
    {
        $city = City::query()->get();
        return view('admin.doctor.add',compact('city'));
    }
    //新增保存方法
    public function save(Request $request)
    {
        $doctor = Doctor::query()->where('code','=',$request->get('code'))->first();
        if($doctor){
            return [
                'code' => 0,
                'msg' => '账号已存在',
                'data' => []
            ];
        }
        $flag = Doctor::create($request->all());
        if($flag){
            User::create([
                'username'=>$request->get('code'),
                'password'=>bcrypt($request->get('password')),
                'role'=>'doctor'
            ]);
        }
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //编辑跳转页面
    public function edit(Request $request, $id)
    {
        $data = Doctor::where('id',$id)->first();
        $city = City::query()->get();
        $hospital = Hospital::find($data->hospital_id);
        $department = Department::find($data->department_id);
        return view('admin.doctor.edit',compact('data',['city','hospital','department']));
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Doctor::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $doctor = Doctor::query()->where('id','',$request->get('id'))->first();
        $int = Doctor::destroy($request->get('id'));
        if($int==1){
            Doctor::query()->where('username','',$doctor->code)->delete();
        }
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }
    //出诊页面
    public function plan()
    {
        $data = Doctor::query()->get();
        return view('admin.doctor.plan',compact('data'));
    }
}
