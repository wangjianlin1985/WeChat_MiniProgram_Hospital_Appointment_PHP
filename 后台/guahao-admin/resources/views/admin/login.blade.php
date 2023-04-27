<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/static/css/style.css">
    <script src="/static/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="/static/msgbox/msgbox.css" />
    <script type="text/javascript" src="/static/msgbox/msgbox.js"></script>
    <title>{{ env('APP_TITLE') }}</title>
    <script>
        $(function (){
            @if($errors->any())
            @foreach($errors->all() as $error)
            lay.msgbox.show('{{ $error }}', 1 , 1000);
            @endforeach
            @endif
        });
    </script>
</head>
<body style="background:#f5f5f5;">
<div class="login_">
    <div class="h"></div>
    <form id="form" action="/admin/login" method="post">
        @csrf
        <div class="login_item">
            <span>账号：</span>
            <input type="text" id="username" name="username" value="" class="input" autocomplete="off"/>
        </div>
        <div class="login_item">
            <span>密码：</span>
            <input type="password" id=password name="password" value="" class="input" autocomplete="off"/>
        </div>
        <input type="hidden" id=role name="role" value="mgr" class="layui-input"/>
        <div class="login_item">
            <span>角色：</span>
            <input type="radio" id="role1" name="role" value="admin" checked="checked"/><label for="role1">管理员</label>
            <input type="radio" id="role2" name="role" value="doctor"/><label for="role2">医生</label>
        </div>
        <div class="form_btn">
            <button type="submit">登录系统</button>
        </div>
    </form>
</div>
</body>
</html>
