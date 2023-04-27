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
                table.reload("layuiTable", { url: "/admin/question/getTable", method: "get", where: data.field });
                return false;
            });

            //添加按钮
            form.on('submit(add)', function () {
                layer.open({
                    type: 1,
                    title: "问卷调查题目管理",
                    content: $("#layui-dialog"),
                    success: function (index, layero) {
                        $("#layui-form")[0].reset();
                        layui.form.render();
                    },
                    btnAlign: 'c',
                    area: ["600px", "480px"],
                    btn: ["提交保存", "关闭"],
                    yes: function (index, layero) {
                        form.on('submit(dialogform)', function (data) {
                            jQuery.ajax({
                                url: "/admin/question/save",
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
                        area: ["600px", "480px"],
                        title: "问卷调查题目管理",
                        content: $("#layui-dialog"),
                        success: function (index, layero) {
                            form.val("value", obj.data);
                        },
                        btnAlign: 'c',
                        btn: ["提交保存", "关闭"],
                        yes: function (index, layero) {
                            form.on('submit(dialogform)', function (data) {
                                jQuery.ajax({
                                    url: "/admin/question/update",
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
                            url: "/admin/question/delete",
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
    <div class="bar"><a href="">首页</a><a>问卷调查管理</a><a>问卷调查题目</a><span>{{ $data->title }}</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>题目：</span>
                        <input type="text" class="xx" name="question" autocomplete="off"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">
                    <button class="btn" lay-submit lay-filter="add" type="button">新增题目</button>
                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table"
                       lay-data="{url:'/admin/question/getTable',
                       where:{questionnaire_id:{{ $data->id }}},
                       method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'no',width:40}"></th>
                        <th lay-data="{field:'question'}">题目</th>
                        <th lay-data="{field:'optiona',templet:'#optionaTpl'}">选项A</th>
                        <th lay-data="{field:'optionb',templet:'#optionbTpl'}">选项B</th>
                        <th lay-data="{field:'optionc',templet:'#optioncTpl'}">选项C</th>
                        <th lay-data="{field:'optiond',templet:'#optiondTpl'}">选项D</th>
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
            <input id="counta" name="counta" value="0" type="hidden"/>
            <input id="countb" name="countb" value="0" type="hidden"/>
            <input id="countc" name="countc" value="0" type="hidden"/>
            <input id="countd" name="countd" value="0" type="hidden"/>
            <input id="questionnaire_id" name="questionnaire_id" value="{{ $data->id }}" type="hidden"/>
            <div class="form_container" style="border: 0px">
                <div class="layui-form-item">
                    <div class="layui-form-label">序号：</div>
                    <div class="layui-input-inline">
                        <input id="no" name="no" class="layui-input" type="text"
                               autocomplete="off" lay-verify="number" lay-reqText="请填写序号"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">题目：</div>
                    <div class="layui-input-inline">
                        <input id="question" name="question" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required" lay-reqText="标题不能为空"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">选项A：</div>
                    <div class="layui-input-inline">
                        <input id="optiona" name="optiona" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required" lay-reqText="选项A不能为空"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">选项B：</div>
                    <div class="layui-input-inline">
                        <input id="optionb" name="optionb" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required" lay-reqText="选项B不能为空"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">选项C：</div>
                    <div class="layui-input-inline">
                        <input id="optionc" name="optionc" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required" lay-reqText="选项C不能为空"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-form-label">选项D：</div>
                    <div class="layui-input-inline">
                        <input id="optiond" name="optiond" class="layui-input" type="text"
                               autocomplete="off" lay-verify="required" lay-reqText="选项D不能为空"/>
                    </div>
                </div>
                <button class="submit" style="display: none;" lay-submit
                        lay-filter="dialogform">提交保存</button>
            </div>
        </form>
    </div>
    @verbatim
        <script type="text/html" id="optionaTpl">
            {{ d.optiona + '('+ d.counta + '人)' }}
        </script>
        <script type="text/html" id="optionbTpl">
            {{ d.optionb + '('+ d.countb + '人)' }}
        </script>
        <script type="text/html" id="optioncTpl">
            {{ d.optionc + '('+ d.countc + '人)' }}
        </script>
        <script type="text/html" id="optiondTpl">
            {{ d.optiond + '('+ d.countd + '人)' }}
        </script>
        <script type="text/html" id="optbar">
            <a href="javascript:;" lay-event="edit">编辑</a>
            <a href="javascript:;" lay-event="del">删除</a>
        </script>
    @endverbatim
@endsection
