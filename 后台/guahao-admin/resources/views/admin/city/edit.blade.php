@extends('admin.template.admin')
@section('script')
    <script type="text/javascript" src="/static/jquery/jquery.upload.js"></script>
    <script>
        layui.use(["element", "form", "table", "layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var table = layui.table;
            var layer = layui.layer;

            form.on('submit(save)', function (data) {
                jQuery.ajax({
                    url: "/admin/city/update",
                    type: "post",
                    dataType: "json",
                    data: data.field,
                    success: function (data, textStatus, jqXHR) {
                        if (data.code != "1") {
                            layer.msg(data.msg, {icon: 2, time: 2000});
                            return;
                        }
                        layer.msg("保存成功!", {icon: 1, time: 1000}, function () {
                            window.location.href = "/admin/city/list";
                        });
                    },
                    error: function () {
                        layer.msg("请求服务器异常", {icon: 2, time: 2000});
                    }
                });
                return false;
            });

        });

    </script>
@endsection
@section('content')
    <div class="bar"><a href="">首页</a><a>城市信息管理</a><span>编辑城市信息</span></div>
    <form class="layui-form" id="form">
        @csrf
        <input id="id" name="id" value="{{ $data->id }}" type="hidden"/>
        <div class="form_container">
            <div class="layui-form-item">
                <div class="layui-form-label">名称：</div>
                <div class="layui-input-inline">
                    <input id="name" name="name" class="layui-input" type="text"
                           value="{{ $data->name }}"
                           autocomplete="off" lay-verify="required" lay-reqText="名称不能为空"/>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-form-label">&nbsp;</div>
                <div class="layui-input-inline">
                    <button lay-submit lay-filter="save" type="button" class="btn">提交保存</button>
                </div>
            </div>
        </div>
    </form>
@endsection
