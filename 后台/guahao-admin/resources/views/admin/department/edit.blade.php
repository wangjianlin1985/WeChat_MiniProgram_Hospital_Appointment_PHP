@extends('admin.template.admin')
@section('script')
    <script type="text/javascript" src="/static/jquery/jquery.upload.js"></script>
    <script>
        layui.use(["element", "form", "upload", "layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var upload = layui.upload;
            var layer = layui.layer;

            form.on('submit(save)', function (data) {
                jQuery.ajax({
                    url: "/admin/department/update",
                    type: "post",
                    dataType: "json",
                    data: data.field,
                    success: function (data, textStatus, jqXHR) {
                        if (data.code != "1") {
                            layer.msg(data.msg, {icon: 2, time: 2000});
                            return;
                        }
                        layer.msg("保存成功!", {icon: 1, time: 1000}, function () {
                            window.location.href = "/admin/department/list";
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
    <div class="bar"><a href="">首页</a><a>科室信息管理</a><span>编辑科室信息</span></div>
    <form class="layui-form" id="form">
        @csrf
        <input id="id" name="id" value="{{ $data->id }}" type="hidden"/>
        <div class="form_container">
            <div class="layui-form-item">
                <div class="layui-form-label">医院：</div>
                <div class="layui-input-inline">
                    <select id="city_id" name="city_id" class="layui-input"
                            lay-ignore lay-verify="required">
                        @foreach($hospitals as $hos)
                            <option @if($data->$hospital_id==$hos->id) selected="selected" @endif value="{{ $$hos->id }}">{{ $hos->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">医院名称：</div>
                <div class="layui-input-inline">
                    <input id="name" name="name" class="layui-input" type="text" value="{{ $data->name }}"
                           autocomplete="off" lay-verify="required"/>
                </div>

            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">联系电话：</div>
                <div class="layui-input-inline">
                    <input id="tel" name="tel" class="layui-input" type="text" value="{{ $data->tel }}"
                           autocomplete="off" lay-verify="required"/>
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
