<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="always" name="referrer">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta name="upurl" content="https://upload.qiniup.com/" />
    <meta name="qiniucdn" content="https://wpcdn.qin500.com/" />
    <meta name="qin500_authorized" content="{{ route('Admin::qin500_authorized') }}" />
    <title>@yield('title') - 年华流失后台管理系统</title>
    <link href="https://at.alicdn.com/t/font_2113112_j4q9l39nrm.css" type="text/css" rel="stylesheet"/>
    <link href="{{ config('mm.__ADMIN__') }}css/base.css?i=5" type="text/css" rel="stylesheet">
    <link href="{{ config('mm.__ADMIN__') }}lib/alert/style.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="/public/favicon.ico" />
    <link href="{{ config('mm.__ADMIN__') }}lib/float/css/float.css" type="text/css" rel="stylesheet">
    @if(request()->route()->getName() == "ADMIN::index")
        <link href="{{ config('mm.__ADMIN__') }}css/index.css" type="text/css" rel="stylesheet">
    @endif
</head>
<body class="">
<div class="header-top">
    <div class="header-top-inner">
        <a id="logo" href="{{ route('Admin::index') }}"><img src="{{ $data['peizi']['logo'] ?? '' }}" alt=""></a>
        <a class="menushort icon" href="#"><i class="fa fa-bars"></i></a>
        <div class="wid"></div>
        <div class="top-right">
            <div class="top-head-short">
                <div class="icon" onclick="fullScreen()"><i class="iconfont icon-expand"></i></div>
                <a target="_blank" href="{{ route('Home::index') }}" class="icon"><i class="iconfont icon-home"></i></a>
            </div>
            <div class="topphoto"><a class="q5center" href="#"><img
                        src="{{ $data['myinfo']->avatar ?? ''}}">
                    <span></span></a>
                <ul class="mytopmenu">
                    <li><a href="">我的信息</a></li>
                    <li><a href="#">我的消息</a></li>
                    <li><a href="">博客配置</a></li>
                    <li><a href="{{ route('Admin::quit')  }}">退出系统</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>
<div id="mobilemask" class="mobilemask"></div>
<div class="main">
    <div class="main-inner">
        <div class="aside q5mobile-aside">
            @include('admin.aside')
        </div>
        <div class="cont-wp">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="q5container ">
                        <div class="q5row ">
                            <div class="q5col-12 ">
                                <div class="q5alert alert-danger">
                                    <strong>错误!</strong>  {{ $error }}
                                    <span class="close">×</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if(session()->has("returnresult"))
                <div class="q5container ">
                    <div class="q5row ">
                        <div class="q5col-12 ">
                            <div class="q5alert alert-{{ session('returnresult')['status'] ?'success':'danger' }}">
                                <strong>{{ session('returnresult')['status']?'成功':'错误' }}!</strong> {{ session('returnresult')['msg'] . (session('returnresult')['status']? "成功" : "失败") }}
                                <span class="close">×</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @section('content')
            @show

            <p class="copyright_page">页面设计:年华流失</p>
        </div>

    </div>
</div>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="{{ config('mm.__ADMIN__') }}lib/qin500.js"></script>
<script src="{{ config('mm.__ADMIN__') }}js/base.js"></script>
@section('footer')
@show

<script>
    // var drag = new Drag("q5conupdatevvvv", "请拖动我", "<h3>这里是内容！</h3>");
    $('.aside-menu-warp .aside-menu li>a').each(function (e){
        let str=window.location.href
        let pos=str.indexOf('#')
        if(pos > 0){
            str.substr(0,pos)
        }
        if(str.substr(str.length - 1 ) == "/"){
            str=str.substr(0,str.length -1);
        }
        if($(this).attr('href') == str){
            $(this).addClass('active')
        }
    })


</script>

</body>

</html>
