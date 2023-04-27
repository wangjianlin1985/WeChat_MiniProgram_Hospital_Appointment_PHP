@extends('admin.template.admin')
@section('script')
    <script>
        layui.use(["element", "form", "table", "layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var table = layui.table;
            var layer = layui.layer;

            form.on('submit(save)', function (data) {
                jQuery.ajax({
                    url: "/admin/questionnaire/update",
                    type: "post",
                    dataType: "json",
                    data: data.field,
                    success: function (data, textStatus, jqXHR) {
                        if (data.code != "1") {
                            layer.msg(data.msg, {icon: 2, time: 2000});
                            return;
                        }
                        layer.msg("保存成功!", {icon: 1, time: 1000}, function () {
                            window.location.href = "/admin/questionnaire/list";
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
    <div class="bar"><a href="">首页</a><a>问卷调查管理</a><span>编辑问卷调查</span></div>
    <form class="layui-form" id="form">
        @csrf
        <input id="id" name="id" value="{{ $data->id }}" type="hidden"/>
        <div class="form_container">
            <div class="layui-form-item">
                <div class="layui-form-label">标题：</div>
                <div class="layui-input-inline">
                    <input id="title" name="title" class="layui-input" type="text"
                           value="{{ $data->title }}}"
                           autocomplete="off" lay-verify="required" lay-reqText="标题不能为空"/>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">参与人数：</div>
                <div class="layui-input-inline">
                    <input id="counts" name="counts" class="layui-input" type="text"
                           value="{{ $data->counts }}"
                           autocomplete="off" readonly="readonly"/>
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
