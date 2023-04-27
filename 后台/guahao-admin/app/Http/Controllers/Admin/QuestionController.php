<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Question::class);
        $count = $query->orderby('no')->count();
        $data = $this->getPaginate($request,$query);
        return $this->outTableData($data,$count);
    }
    //新增保存方法
    public function save(Request $request)
    {
        $flag = Question::create($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Question::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $int = Question::destroy($request->get('id'));
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }
}
