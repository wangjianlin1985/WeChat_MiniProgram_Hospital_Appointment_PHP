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
                table.reload("layuiTable", { url: "/admin/message/getTable", method: "get", where: data.field });
                return false;
            });

            table.on('tool(opt)', function (obj) {
                //回复
                if (obj.event === 'reply') {
                    layer.open({
                        type: 1,
                        area: ["620px", "400px"],
                        title: "回复留言",
                        content: $("#layui-dialog"),
                        success: function (index, layero) {
                            $("#from_id").val(obj.data.to_id);
                            $("#to_id").val(obj.data.from_id);
                            $().val();
                        },
                        btnAlign: 'c',
                        btn: ["提交保存", "关闭"],
                        yes: function (index, layero) {
                            form.on('submit(dialogform)', function (data) {
                                jQuery.ajax({
                                    url: "/admin/message/save",
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
                            url: "/admin/message/delete",
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
    <div class="bar"><a href="">首页</a><a>我的留言信息</a><span>我的留言信息</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>留言：</span>
                        <input type="text" class="xx" name="content" autocomplete="off"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">

                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table" lay-data="{url:'/admin/message/getTable',method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers'}"></th>
                        <th lay-data="{field:'from',width:150}">留言人</th>
                        <th lay-data="{field:'to',width:150}">接收人</th>
                        <th lay-data="{field:'content'}">内容</th>
                        <th lay-data="{field:'updated_at',width:160}">更新时间</th>
                        <th lay-data="{field:'opt',width:60,toolbar:'#optbar'}">操作</th>
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
            <input id="from_id" name="from_id" value="0" type="hidden"/>
            <input id="to_id" name="to_id" value="0" type="hidden"/>
            <input id="receive" name="receive" value="customer" type="hidden"/>
            <div class="form_container" style="border: 0px;padding-top: 20px;">
                <div class="layui-form-item">
                    <div class="layui-form-label">内容：</div>
                    <div class="layui-input-inline">
                        <textarea id="content" name="content" class="layui-input" type="text"
                                  autocomplete="off" style="width:370px;height: 225px;"
                                  lay-verify="required" lay-reqText="内容不能为空"></textarea>
                    </div>
                </div>
                <button class="submit" style="display: none;" lay-submit
                        lay-filter="dialogform">提交保存</button>
            </div>
        </form>
    </div>
    @verbatim
        <script type="text/html" id="optbar">
            {{#  if(d.receive=='customer'){ }}
            <a href="javascript:;" lay-event="del">删除</a>
            {{#  } }}
            {{#  if(d.receive=='doctor'){ }}
            <a href="javascript:;" lay-event="reply">回复</a>
            {{#  } }}
        </script>
    @endverbatim
@endsection
