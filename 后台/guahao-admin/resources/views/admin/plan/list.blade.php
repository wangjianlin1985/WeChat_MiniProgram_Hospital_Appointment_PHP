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
                table.reload("layuiTable", { url: "/admin/plan/getTable", method: "get", where: data.field });
                return false;
            });

            //添加按钮
            form.on('submit(add)', function () {
                layer.open({
                    type: 1,
                    title: "出诊信息管理",
                    content: $("#layui-dialog"),
                    success: function (index, layero) {
                        $("#layui-form")[0].reset();
                        layui.form.render();
                    },
                    btnAlign: 'c',
                    area: ["520px", "300px"],
                    btn: ["提交保存", "关闭"],
                    yes: function (index, layero) {
                        form.on('submit(dialogform)', function (data) {
                            jQuery.ajax({
                                url: "/admin/plan/save",
                                type: "post",
                                dataType: "json",
                                data: data.field,
                                success: function (data, textStatus, jqXHR) {
                                    if (data.code != "1") {
                                        layer.msg(data.msg, { icon: 2, time: 2000 });
                                        return;
                                    }
                                    layer.msg("保存成功!", { icon: 1, time: 1000 }, function () {
                                        layer.close(index);
                                        table.reload("layuiTable");
                                    });
                                },
                                error: function () { layer.msg("请求服务器异常", { icon: 2, time: 2000 }); }
                            });
                            return false;
                        });
                        $('.submit').trigger('click');
                    }
                });
                return false;
            });

            table.on('tool(opt)', function (obj) {
                //编辑数据
                if (obj.event === 'edit') {
                    layer.open({
                        type: 1,
                        area: ["520px", "300px"],
                        title: "出诊信息管理",
                        content: $("#layui-dialog"),
                        success: function (index, layero) {
                            form.val("value", obj.data);
                        },
                        btnAlign: 'c',
                        btn: ["提交保存", "关闭"],
                        yes: function (index, layero) {
                            form.on('submit(dialogform)', function (data) {
                                jQuery.ajax({
                                    url: "/admin/plan/update",
                                    type: "post",
                                    dataType: "json",
                                    data: data.field,
                                    success: function (data, textStatus, jqXHR) {
                                        if (data.code != "1") {
                                            layer.msg(data.msg, { icon: 2, time: 2000 });
                                            return;
                                        }
                                        layer.msg("保存成功!", { icon: 1, time: 1000 }, function () {
                                            layer.close(index);
                                            table.reload("layuiTable");
                                        });
                                    },
                                    error: function () { layer.msg("请求服务器异常", { icon: 2, time: 2000 }); }
                                });
                                return false;
                            });
                            $('.submit').trigger('click');
                        }
                    });

                }
                //删除数据
                if (obj.event === 'del') {
                    layer.confirm("是否确认删除?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/plan/delete",
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
    <div class="bar"><a href="">首页</a><a>出诊信息管理</a><span>出诊信息列表</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>日期：</span>
                        <input type="text" class="xx" name="date" autocomplete="off"/>
                        <input type="hidden" class="xx" name="doctor_id" value="{{ auth()->user()->id }}"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">
                    <button class="btn" lay-submit lay-filter="add" type="button">新增出诊</button>
                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table"
                       lay-data="{url:'/admin/plan/getTable',
                       where:{doctor_id:{{ $data }} },
                       method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers'}"></th>
                        <th lay-data="{field:'date'}">出诊日期</th>
                        <th lay-data="{field:'time'}">出诊时间</th>
                        <th lay-data="{field:'price'}">价格</th>
                        <th lay-data="{field:'status',templet:'#statusTpl'}">状态</th>
                        <th lay-data="{field:'created_at'}">添加时间</th>
                        <th lay-data="{field:'updated_at'}">更新时间</th>
                        <th lay-data="{field:'opt',width:100,toolbar:'#optbar'}">操作</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="layui-dialog" class="layui-dialog">
        <form class="layui-form" id="layui-form" lay-filter="value">
            @csrf
            <input id="id" name="id" value="0" type="hidden"/>
            <input id="status" name="status" value="0" type="hidden"/>
            <input id="doctor_id" name="doctor_id" value="{{ $data }}" type="hidden"/>
            <div class="form_container" style="border: 0px">
                <div class="layui-form-item">
                    <div class="layui-form-label">日期：</div>
                    <div class="layui-input-inline">
                        <input id="date" name="date" class="layui-input" type="text"
                               autocomplete="off" lay-verify="date" lay-reqText="请填写日期"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">时间：</div>
                    <div class="layui-input-inline">
                        <input id="time" name="time" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required" lay-reqText="时间不能为空"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">价格：</div>
                    <div class="layui-input-inline">
                        <input id="price" name="price" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required|number" lay-reqText="价格只能是数字"/>
                    </div>
                </div>
                <button class="submit" style="display: none;" lay-submit
                        lay-filter="dialogform">提交保存</button>
            </div>
        </form>
    </div>
    @verbatim
        <script type="text/html" id="statusTpl">
            {{ d.status==1 ? '<font color="red">已预约</font>' : '未预约' }}
        </script>
        <script type="text/html" id="optbar">
            <a href="javascript:;" lay-event="edit">编辑</a>
            <a href="javascript:;" lay-event="del">删除</a>
        </script>
    @endverbatim
@endsection
