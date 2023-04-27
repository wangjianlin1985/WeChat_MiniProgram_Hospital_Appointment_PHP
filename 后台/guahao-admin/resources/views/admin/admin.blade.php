@extends('admin.template.admin')
@section('script')
<script>
    layui.use(["element", "form", "table", "layer"], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var layer = layui.layer;

    });
</script>
@endsection
@section('content')
    <div class="bar"><a href="">首页</a><a>订单管理</a><span>今日订单</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <span>订单号：</span>
                    <input type="text" class="xx" id="orderno" autocomplete="off"/>
                    <button class="btn" onclick="sch();" type="button">查询</button>
                </div>
                <div class="flex-col-6 txt-right">
                    <button class="btn" onclick="add();" type="button">新增</button>
                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table" lay-data="{method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers',fixed:'left'}"></th>
                        <th lay-data="{field:'title',width:160,fixed:'left'}">名称</th>
                        <th lay-data="{field:'cover',width:60,templet:'#coverTpl'}">封面</th>
                        <th lay-data="{field:'title',width:120,templet:'#cgTpl'}">分类</th>
                        <th lay-data="{field:'author',width:120}">作者</th>
                        <th lay-data="{field:'reads',width:100}">人气</th>
                        <th lay-data="{field:'vip',width:120,templet:'#vipTpl'}">收费</th>
                        <th lay-data="{field:'over',width:80,templet:'#overTpl'}">完结</th>
                        <th lay-data="{field:'status',width:80,templet:'#statusTpl'}">状态</th>
                        <th lay-data="{field:'tags',width:200}">标签</th>
                        <th lay-data="{field:'last_chapter',width:200}">更新至</th>
                        <th lay-data="{field:'intro',width:300}">简介</th>
                        <th lay-data="{field:'created_at',width:180}">添加时间</th>
                        <th lay-data="{field:'updated_at',width:180}">更新时间</th>
                        <th lay-data="{field:'opt',width:130,toolbar:'#optbar',fixed:'right'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
