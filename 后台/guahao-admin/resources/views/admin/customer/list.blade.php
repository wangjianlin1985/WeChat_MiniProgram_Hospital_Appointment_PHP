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
                table.reload("layuiTable", { url: "/admin/customer/getTable", method: "get", where: data.field });
                return false;
            });

            table.on('tool(opt)', function (obj) {
                //删除数据
                if (obj.event === 'del') {
                    layer.confirm("是否确认删除?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/customer/delete",
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
                //拉黑
                if(obj.event==="status0"){
                    layer.confirm("是否确认拉黑用户?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/customer/update",
                            type: "get",
                            dataType: "json",
                            data: { id: obj.data.id,status:0 },
                            success: function (data, textStatus, jqXHR) {
                                if (data.code != "1") {
                                    layer.msg(data.msg, { icon: 2, time: 2000 });
                                    return;
                                }
                                layer.msg("拉黑成功!", { icon: 1, time: 1000 }, function () {
                                    layer.close(index);
                                    table.reload("layuiTable");
                                });
                            },
                            error: function () { layer.msg("请求服务器异常", { icon: 2, time: 2000 }); }
                        });
                    });
                }
                //启用
                if(obj.event==="status1"){
                    layer.confirm("是否确认启用用户?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/customer/update",
                            type: "get",
                            dataType: "json",
                            data: { id: obj.data.id,status:1 },
                            success: function (data, textStatus, jqXHR) {
                                if (data.code != "1") {
                                    layer.msg(data.msg, { icon: 2, time: 2000 });
                                    return;
                                }
                                layer.msg("启用成功!", { icon: 1, time: 1000 }, function () {
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
    <div class="bar"><a href="">首页</a><a>会员信息管理</a><span>会员信息列表</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>手机号：</span>
                        <input type="text" class="xx" name="phone" autocomplete="off"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">

                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table" lay-data="{url:'/admin/customer/getTable',method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers'}"></th>
                        <th lay-data="{field:'username',width:150}">昵称</th>
                        <th lay-data="{field:'status',width:80,templet:'#statusTpl'}">状态</th>
                        <th lay-data="{field:'phone',width:150}">手机号</th>
                        <th lay-data="{field:'sex',width:60}">性别</th>
                        <th lay-data="{field:'idcard',width:180}">身份证号</th>
                        <th lay-data="{field:'address'}">地址</th>
                        <th lay-data="{field:'created_at',width:160}">注册时间</th>
                        <th lay-data="{field:'updated_at',width:160}">更新时间</th>
                        <th lay-data="{field:'opt',width:100,toolbar:'#optbar'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @verbatim
        <script type="text/html" id="statusTpl">
            {{ d.status==1?"正常":""  }}
            {{ d.status==0?"拉黑":""  }}
        </script>
        <script type="text/html" id="optbar">
            <a href="javascript:;" lay-event="del">删除</a>
            {{#  if(d.status==1){ }}
            <a href="javascript:;" lay-event="status0">拉黑</a>
            {{#  } }}
            {{#  if(d.status==0){ }}
            <a href="javascript:;" lay-event="status1">启用</a>
            {{#  } }}
        </script>
    @endverbatim
@endsection
