@extends('admin.template.admin')
@section('script')
    <script>
        layui.use(["element", "form", "table", "layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var table = layui.table;
            var layer = layui.layer;

            //搜索
            form.on('submit(search)', function (data) {
                table.reload("layuiTable", { url: "/admin/department/getTable", method: "get", where: data.field });
                return false;
            });

            table.on('tool(opt)', function (obj) {
                //删除数据
                if (obj.event === 'del') {
                    layer.confirm("是否确认删除?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/department/delete",
                            type: "get",
                            dataType: "json",
                            data: { id: obj.data.id },
                            success: function (data, textStatus, jqXHR) {
                                if (data.code != "1") {
                                    layer.msg(data.msg, { icon: 2, time: 2000 });
                                    return;
                                }
                                layer.msg("删除成功!", { icon: 1, time: 1000 }, function () {
                                    layer.close(index);
                                    table.reload("layuiTable");
                                });
                            },
                            error: function () { layer.msg("请求服务器异常", { icon: 2, time: 2000 }); }
                        });
                    });
                }

            });
        });
    </script>
@endsection

@section('content')
    <div class="bar"><a href="">首页</a><a>科室信息管理</a><span>科室信息列表</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>医院：</span>
                        <select class="xx" name="hospital_id" lay-ignore>
                            <option value="">请选择</option>
                            @foreach($hospitals as $hos)
                                <option @if($hospital_id == $hos->id) selected @endif value="{{ $hos->id }}">{{ $hos->name }}</option>
                            @endforeach
                        </select>
                        <span>标题：</span>
                        <input type="text" class="xx" name="title" autocomplete="off"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">
                    <a class="btn" href="/admin/department/add">新增</a>
                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table"
                       lay-data="{url:'/admin/department/getTable',
                       where:{'hospital_id':'{{$hospital_id}}'},
                       method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers'}"></th>
                        <th lay-data="{field:'hospital'}">医院</th>
                        <th lay-data="{field:'name'}">名称</th>
                        <th lay-data="{field:'departments',templet:'#departmentsTpl'}">医生</th>
                        <th lay-data="{field:'tel'}">电话</th>
                        <th lay-data="{field:'created_at',width:160}">添加时间</th>
                        <th lay-data="{field:'updated_at',width:160}">更新时间</th>
                        <th lay-data="{field:'opt',width:100,toolbar:'#optbar'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @verbatim
        <script type="text/html" id="departmentsTpl">
            <a href="/admin/doctor/list?department_id={{d.id}}">{{ d.doctors }}</a>
        </script>

        <script type="text/html" id="optbar">
            <a href="/admin/department/edit/{{d.id}}">编辑</a>
            <a href="javascript:;" lay-event="del">删除</a>
        </script>
    @endverbatim
@endsection
