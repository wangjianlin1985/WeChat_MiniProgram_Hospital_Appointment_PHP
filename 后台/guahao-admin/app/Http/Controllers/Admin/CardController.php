<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    //列表页面
    public function list()
    {
        $data = [];
        return view('admin.card.list',compact('data'));
    }
    //获取分类表格数据
    public function getTable(Request $request)
    {
        $query = $this->getQuery($request,Card::class);
        $count = $query->count();
        $data = $this->getPaginate($request,$query);
        return $this->outTableData($data,$count);
    }
    //新增页面
    public function add()
    {
        $data = [];
        return view('admin.card.add',compact('data'));
    }
    //新增保存方法
    public function save(Request $request)
    {
        $flag = Card::create($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('保存失败，请检查数据后重试...');
        return $json;
    }
    //编辑跳转页面
    public function edit(Request $request, $id)
    {
        $data = Card::where('id',$id)->first();
        return view('admin.card.edit',compact('data'));
    }
    //修改保存方法
    public function update(Request $request)
    {
        $flag = Card::where('id',$request->get('id'))->first()->update($request->all());
        $json = $flag ? $this->successJson([]) : $this->failJson('修改失败，请检查数据后重试...');
        return $json;
    }
    //删除
    public function delete(Request $request)
    {
        $int = Card::destroy($request->get('id'));
        $json = $int == 1 ? $this->successJson([]) : $this->failJson('删除失败，请检查数据后重试...');
        return $json;
    }
}
