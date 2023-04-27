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
                table.reload("layuiTable", { url: "/admin/banner/getTable", method: "get", where: data.field });
                return false;
            });

            table.on('tool(opt)', function (obj) {
                //删除数据
                if (obj.event === 'del') {
                    layer.confirm("是否确认删除?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/banner/delete",
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
    <div class="bar"><a href="">首页</a><a>轮播图信息管理</a><span>轮播图信息列表</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>标题：</span>
                        <input type="text" class="xx" name="title" autocomplete="off"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">

                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table" lay-data="{url:'/admin/banner/getTable',method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers'}"></th>
                        <th lay-data="{field:'title'}">标题</th>
                        <th lay-data="{field:'url',width:300,toolbar:'#urlTpl'}">轮播图</th>
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
        <script type="text/html" id="urlTpl">
            <a href="{{d.url}}" target="_blank" title="浏览">{{ d.url }}</a>
        </script>
        <script type="text/html" id="optbar">
            <a href="/admin/banner/edit/{{d.id}}">编辑</a>
            <a href="javascript:;" lay-event="del">删除</a>
        </script>
    @endverbatim
@endsection
