@extends('admin.template.admin')
@section('script')
    <script>
        layui.use(["element", "form","layer"], function () {
            var element = layui.element;
            var form = layui.form;
            var table = layui.table;

            @if($errors->any())
            @foreach($errors->all() as $error)
            layer.msg('{{ $error }}');
            @endforeach
            @endif

        });
    </script>
@endsection
@section('content')
    <div class="bar"><a href="">首页</a><a>系统管理</a><span>修改密码</span></div>
    <div class="form_container">
        <form id="form" action="/admin/vpass" method="post" class="layui-form layui-form-pane">
            @csrf
            <input id="id" name="id" value="0" type="hidden"/>
            <div class="layui-form-item">
                <div class="layui-form-label">原密码：</div>
                <div class="layui-input-inline">
                    <input id="oldpass" name="oldpass" class="layui-input" type="text"
                           autocomplete="off" lay-verify="required" lay-reqText="原密码不能为空"/>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">新密码：</div>
                <div class="layui-input-inline">
                    <input id="newpass" name="newpass" class="layui-input" type="text"
                           autocomplete="off" lay-verify="required" lay-reqText="原密码不能为空"/>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">确认密码：</div>
                <div class="layui-input-inline">
                    <input id="newpass_confirmation" name="newpass_confirmation" class="layui-input" type="text"
                           autocomplete="off" lay-verify="required" lay-reqText="原密码不能为空"/>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-form-label">&nbsp;</div>
                <div class="layui-input-inline">
                    <button lay-submit type="submit" class="btn">提交保存</button>
                </div>
            </div>
        </form>
    </div>
@endsection
