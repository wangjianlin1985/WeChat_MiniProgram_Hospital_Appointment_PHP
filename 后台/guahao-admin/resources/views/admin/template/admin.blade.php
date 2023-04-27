<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/static/css/style.css">
    <script src="/static/jquery/jquery.min.js"></script>
    <script src="/static/layui/layui.js"></script>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <title>{{ env('APP_TITLE') }}</title>
    @yield('script')
</head>
<body>
<div class="header">
    <div class="flex-row">
        <div class="flex-col-10">
            <div class="nav">
                @if(auth()->user()->role=='admin')
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">订单管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/order/day" class="nblist">今日订单查询</a>
                            <a href="/admin/order/list" class="nblist">所有订单查询</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">医生管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/doctor/list" class="nblist">医生信息管理</a>
                            <a href="/admin/doctor/plan" class="nblist">医生出诊管理</a>
                            <a href="/admin/doctor/add" class="nblist">新增医生管理</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">城市医院</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/city/list" class="nblist">城市信息管理</a>
                            <a href="/admin/hospital/list" class="nblist">医院信息管理</a>
                            <a href="/admin/department/list" class="nblist">科室信息管理</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">会员管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/customer/list" class="nblist">会员信息管理</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">留言管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/message/list" class="nblist">留言信息管理</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">新闻公告</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/article/list" class="nblist">新闻公告管理</a>
                            <a href="/admin/article/add" class="nblist">发布新闻公告</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">轮播图管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/banner/list" class="nblist">轮播图信息管理</a>
                            <a href="/admin/banner/add" class="nblist">新增轮播图信息</a>
                        </div>
                    </div>
                </div>
                @endif
                @if(auth()->user()->role=='doctor')
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">订单信息</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/order/day" class="nblist">今日订单查询</a>
                            <a href="/admin/order/list" class="nblist">所有订单查询</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">出诊管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/plan/list" class="nblist">出诊信息管理</a>
                        </div>
                    </div>
                </div>
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">我的留言</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            <a href="/admin/message/doctor" class="nblist">我的留言信息</a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="nav-div">
                    <a class="nav-a nav-head" href="">系统管理</a>
                    <div class="nav-body">
                        <div class="nav-body-list">
                            @if(auth()->user()->role=='doctor')
                            <a href="/admin/person" class="nblist">个人信息</a>
                            @endif
                            <a href="/admin/pass" class="nblist">修改密码</a>
                            <a href="/admin/login" class="nblist">退出登录</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-col-2">
            <div class="user">
                <span id="datetime"></span>
                <a class="admin" href="/admin/index">{{ auth()->user()->username }}【{{ auth()->user()->role=='admin'?'管理员':'医生' }}】</a>
                <a class="quit" href="/admin/logout">退出</a>
            </div>
        </div>
    </div>
    <div class="header_"></div>
</div>
<div class="content">
    @yield('content')
</div>
</body>
</html>
