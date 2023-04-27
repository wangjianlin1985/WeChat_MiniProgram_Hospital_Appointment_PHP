<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //列表页面
    public function list(Request $request)
    {
        $hospital_id = $request->get('hospital_id');
        $hospitals = Hospital::query()->get();
        return view('admin.department.list',compact(['hospitals','hospital_id']));
    }
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Department::class);
        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        $data->map(function(Department $department){
            $doctors = Doctor::query()->where('department_id',$department->id)->count();
            $department->doctors = $doctors;
            $hospital = Hospital::find($department->hospital_id);
            if($hospital){
                $department->hospital = $hospital->name;
            }
        });
        return $this->outTableData($data,$count);
    }
    //新增页面
    public function add()
    {
        $hospitals = Hospital::query()->get();
        return view('admin.department.add',compact('hospitals'));
    }
    //新增保存方法
    public function save(Request $request)
    {
        $flag = Department::create($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //编辑跳转页面
    public function edit(Request $request, $id)
    {
        $hospitals = Hospital::query()->get();
        $data = Department::where('id',$id)->first();
        return view('admin.department.edit',compact('data',['hospitals']));
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Department::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $int = Department::destroy($request->get('id'));
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }

    //查询select
    public function select(Request $request)
    {
        $hospital_id = $request->get('hospital_id',-1);
        $lists = Department::query()
            ->where('hospital_id','=',$hospital_id) ->get();
        return $this->successJson($lists);
    }
}
