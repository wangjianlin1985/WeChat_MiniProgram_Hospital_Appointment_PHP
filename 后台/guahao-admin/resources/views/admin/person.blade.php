@extends('admin.template.admin')
@section('script')
    <link rel="stylesheet" type="text/css" href="/static/yyuiTab/yyui.css">
    <script type="text/javascript" src="/static/yyuiTab/yyui.js"></script>
    <script>
        layui.use(["element", "form", "table", "layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var table = layui.table;
            var layer = layui.layer;

            //点击图片进行选择文件
            $("#pic").click(function () {
                $("#file").click();
            });

            form.on('submit(save)', function (data) {
                if (!data.field.avatar) {
                    layer.msg('请上传医生照片', {icon: 2, time: 2000});
                    return;
                }
                jQuery.ajax({
                    url: "/admin/doctor/update",
                    type: "post",
                    dataType: "json",
                    data: data.field,
                    success: function (data, textStatus, jqXHR) {
                        if (data.code != "1") {
                            layer.msg(data.msg, {icon: 2, time: 2000});
                            return;
                        }
                        layer.msg("保存成功!", {icon: 1, time: 1000}, function () {

                        });
                    },
                    error: function () {
                        layer.msg("请求服务器异常", {icon: 2, time: 2000});
                    }
                });
                return false;
            });

        });

        //上传图片
        function uploadImg() {
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
                        $("#avatar").val(data.data);
                        $("#pic").attr("src", data.data);
                    } else {
                        layer.msg(data.msg);
                    }
                },
                error: function (data, status, e) { //服务器响应失败时的处理函数
                    layer.msg("图片上传失败!");
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="bar"><a href="">首页</a><a>系统管理</a><span>个人资料</span></div>
    <form class="layui-form" id="form">
        @csrf
        <input id="id" name="id" value="{{ $data->id }}" type="hidden"/>
        <input id="password" name="password" value="{{ $data->password }}" type="hidden"/>
        <div class="form_container">
            <div class="yyui_tab">
                <ul>
                    <li class="yyui_tab_title_this" style="border-left:1px solid #fff;">基本信息</li>
                    <li class="yyui_tab_title">个人照片</li>
                    <li class="yyui_tab_title">擅长领域</li>
                </ul>
                <div class="yyui_tab_content_this">
                    <div class="layui-form-item">
                        <div class="layui-form-label">姓名：</div>
                        <div class="layui-input-inline">
                            <input id="name" name="name" class="layui-input" type="text"
                                   value="{{ $data->name }}"
                                   autocomplete="off" lay-verify="required" lay-reqText="姓名不能为空"/>
                        </div>
                        <div class="layui-form-label">手机号：</div>
                        <div class="layui-input-inline">
                            <input id="phone" name="phone" class="layui-input" type="text"
                                   value="{{ $data->phone }}"
                                   autocomplete="off"/>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-form-label">账号：</div>
                        <div class="layui-input-inline">
                            <input id="code" name="code" class="layui-input" type="text"
                                   value="{{ $data->code }}"
                                   autocomplete="off" readonly="readonly"/>
                        </div>
                        <div class="form_item_span" style="color: #cccccc">账号不可修改</div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-form-label">身份证号：</div>
                        <div class="layui-input-inline">
                            <input id="idcard" name="idcard" class="layui-input" type="text"
                                   value="{{ $data->idcard }}"
                                   autocomplete="off"/>
                        </div>
                        <div class="layui-form-label">性别：</div>
                        <div class="layui-input-inline">
                            <input type="radio" value="男" id="male" name="sex" @if($data->sex=='男') checked @endif/>
                            <label for="male">男</label>
                            <input type="radio" value="女" id="fmale" name="sex" @if($data->sex=='女') checked @endif/>
                            <label for="fmale">女</label>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-form-label">地址：</div>
                        <div class="layui-input-inline">
                            <input id="address" name="address" class="layui-input" type="text"
                                   value="{{ $data->address }}"
                                   autocomplete="off"/>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-form-label">&nbsp;</div>
                        <div class="layui-input-inline">
                            <button lay-submit lay-filter="save" type="button" class="btn">提交保存</button>
                        </div>
                    </div>
                </div>
                <div class="yyui_tab_content">
                    <div
                        style="margin:20px 0px 100px 15px;border:1px solid #DDDDDD;width:202px;height:162px;float: left;">
                        <input id="avatar" name="avatar" value="{{ $data->avatar }}"type="hidden" />
                        <img id="pic" src="{{ $data->avatar }}" width="200px" height="160px;"
                             style="cursor: pointer;"/>
                        <input type="file" id="file" name="file" onchange="uploadImg();" style="display: none;"/>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                <div class="yyui_tab_content">
                    <div style="padding:20px 0px 0px 20px;">
                        <textarea id="intro" name="intro" placeholder="请填写擅长领域"
                                  style="width:1080px;height:400px;" class="layui-input" autocomplete="off">{{ $data->intro }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
