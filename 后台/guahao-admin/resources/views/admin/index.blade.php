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
                table.reload("layuiTable", { url: "/admin/order/getTable", method: "get", where: data.field });
                return false;
            });

            table.on('tool(opt)', function (obj) {
                //接单
                if (obj.event === 'yes') {
                    layer.confirm("是否确认接单?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/order/update",
                            type: "get",
                            dataType: "json",
                            data: { id: obj.data.id,is_pay:1 },
                            success: function (data, textStatus, jqXHR) {
                                if (data.code != "1") {
                                    layer.msg(data.msg, { icon: 2, time: 2000 });
                                    return;
                                }
                                layer.msg("接单成功!", { icon: 1, time: 1000 }, function () {
                                    layer.close(index);
                                    table.reload("layuiTable");
                                });
                            },
                            error: function () { layer.msg("请求服务器异常", { icon: 2, time: 2000 }); }
                        });
                    });
                }

                if (obj.event === 'no') {
                    layer.confirm("是否确认取消接单?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/order/update",
                            type: "get",
                            dataType: "json",
                            data: { id: obj.data.id,is_pay:0 },
                            success: function (data, textStatus, jqXHR) {
                                if (data.code != "1") {
                                    layer.msg(data.msg, { icon: 2, time: 2000 });
                                    return;
                                }
                                layer.msg("取消成功!", { icon: 1, time: 1000 }, function () {
                                    layer.close(index);
                                    table.reload("layuiTable");
                                });
                            },
                            error: function () { layer.msg("请求服务器异常", { icon: 2, time: 2000 }); }
                        });
                    });
                }

                if (obj.event === 'del') {
                    layer.confirm("是否确认删除预约?", { icon: 3, title: "确认" }, function (index) {
                        jQuery.ajax({
                            url: "/admin/order/delete",
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
    <div class="bar"><a href="">首页</a><a>订单信息</a><span>今日订单查询</span></div>
    <div class="grid">
        <div class="grid_tools">
            <div class="flex-row">
                <div class="flex-col-6">
                    <form class="layui-form">
                        <span>订单号：</span>
                        <input type="text" class="xx" name="order_no" autocomplete="off"/>
                        <span>支付状态：</span>
                        <select type="text" class="xx" name="is_pay" lay-ignore>
                            <option value="">全部</option>
                            <option value="1">已支付</option>
                            <option value="0">未支付</option>
                        </select>
                        <input type="hidden" class="xx" name="today" value="{{ $day }}"/>
                        <button class="btn" lay-submit lay-filter="search" type="button">查询</button>
                    </form>
                </div>
                <div class="flex-col-6 txt-right">

                </div>
            </div>
        </div>
        <div class="gridTable">
            <div class="layui-tables">
                <table id="layuiTable" class="layui-table"
                       lay-data="{url:'/admin/order/getTable',
                       where:{ today:'{{ $day }}' },
                       method:'get',page:true}" lay-filter="opt">
                    <thead>
                    <tr>
                        <th lay-data="{field:'num',type:'numbers'}"></th>
                        <th lay-data="{field:'order_no'}">订单号</th>
                        <th lay-data="{field:'question'}">咨询问题</th>
                        <th lay-data="{field:'customer'}">预约人</th>
                        <th lay-data="{field:'doctor'}">预约医生</th>
                        <th lay-data="{field:'date'}">预约日期</th>
                        <th lay-data="{field:'time'}">预约时间</th>
                        <th lay-data="{field:'message'}">留言</th>
                        <th lay-data="{field:'is_pay',templet:'#isPayTpl'}">状态</th>
                        @if(auth()->user()->role=='doctor')
                            <th lay-data="{field:'opt',width:100,toolbar:'#optbar'}">操作</th>
                        @endif
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @verbatim
        <script type="text/html" id="isPayTpl">
            {{ d.is_pay==1?'<font color="green">已接单</font>':'<font color="red">未结单</font>'  }}
        </script>
        <script type="text/html" id="optbar">
            {{#  if(d.is_pay ==0 ){ }}
            <a href="javascript:;" lay-event="yes">接单</a>
            <a href="javascript:;" lay-event="del">删除</a>
            {{#  } else {  }}
            <a href="javascript:;" lay-event="no">取消</a>
            <a href="javascript:;" lay-event="del">删除</a>
            {{#  } }}
        </script>
    @endverbatim
@endsection
