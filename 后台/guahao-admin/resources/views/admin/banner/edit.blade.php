@extends('admin.template.admin')
@section('script')
    <script type="text/javascript" src="/static/jquery/jquery.upload.js"></script>
    <script>
        layui.use(["element", "form", "table", "layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var table = layui.table;
            var layer = layui.layer;

            //点击进行选择文件
            $("#btn").click(function () {
                $("#file").click();
            });

            form.on('submit(save)', function (data) {
                jQuery.ajax({
                    url: "/admin/banner/update",
                    type: "post",
                    dataType: "json",
                    data: data.field,
                    success: function (data, textStatus, jqXHR) {
                        if (data.code != "1") {
                            layer.msg(data.msg, {icon: 2, time: 2000});
                            return;
                        }
                        layer.msg("保存成功!", {icon: 1, time: 1000}, function () {
                            window.location.href = "/admin/banner/list";
                        });
                    },
                    error: function () {
                        layer.msg("请求服务器异常", {icon: 2, time: 2000});
                    }
                });
                return false;
            });

        });
        //上传视频
        function uploadFile() {
            var patn = /\.jpg$|\.jpeg$|\.png$|\.gif$/;
            if ($("#file").val() == 0) {
                layer.msg("请选择要上传的图片!");
                return false;
            }
            if (!patn.test($("#file").val().toLowerCase())) {
                layer.msg("只能上传jpg、png、gif格式的图片!");
                return;
            }
            $.ajaxFileUpload({
                url: '/admin/uploadFile',
                secureuri: false,                           //是否启用安全提交,默认为false
                fileElementId: "file",               //文件选择框的id属性
                dataType: 'json',                           //服务器返回的格式,可以是json或xml等
                success: function (data, status) {            //服务器响应成功时的处理函数
                    if (data.code == 1) {
                        layer.msg("上传成功!",{icon: 1, time: 1000});
                        $("#url").val(data.data);
                    } else {
                        layer.msg(data.msg);
                    }
                },
                error: function (data, status, e) { //服务器响应失败时的处理函数
                    layer.msg("视频上传失败!");
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="bar"><a href="">首页</a><a>轮播图信息管理</a><span>编辑轮播图信息</span></div>
    <form class="layui-form" id="form">
        @csrf
        <input id="id" name="id" value="{{ $data->id }}" type="hidden"/>
        <div class="form_container">
            <div class="layui-form-item">
                <div class="layui-form-label">标题：</div>
                <div class="layui-input-inline">
                    <input id="title" name="title" class="layui-input" type="text"
                           value="{{ $data->title }}"
                           autocomplete="off" lay-verify="required" lay-reqText="标题不能为空"/>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">图片：</div>
                <div class="layui-input-inline">
                    <input id="url" name="url" class="layui-input" value="{{ $data->url }}" type="text"/>
                    <button type="button" id="btn">上传图片</button>
                    <input type="file" id="file" name="file" onchange="uploadFile();" style="display: none;"/>
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
