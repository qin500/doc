<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="always" name="referrer">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="renderer" content="webkit"/>
    @if(Route::currentRouteName()  == "Home::index")
        <meta name="keywords" content="{{ $data['peizi']['keywords'] }}" />
        <meta name="description" content="{{ $data['peizi']['description'] }}" />
    @else
        <meta name="keywords" content="@yield('keywords','')"/>
        <meta name="description" content="@yield('description','')" />
    @endif
    <title>@if(Route::currentRouteName()  == "Home::index"){{ $data['peizi']['title'] . "_" ?? '年华流失_' }}@yield('title')@else @yield('title'){{ "_" . $data['peizi']['title'] ?? '_年华流失' }}@endif</title>
    <link href="https://at.alicdn.com/t/font_2113112_ayjnxksui3a.css" type="text/css" rel="stylesheet"/>
    <link href="{{ config('mm.__HOME__') }}css/style.css?i=121" type="text/css" rel="stylesheet"/>
    <link href="{{ config('mm.__HOME__') }}css/m.css?i=22231" type="text/css" rel="stylesheet"/>
    <link href="{{ config('mm.__LIB__') }}prism/prism.css?i=2" type="text/css" rel="stylesheet"/>
</head>

<body>
<div class="app">
    <header class="header">
        <div class="tophead">
            <div class="wp clx">
                <div class="logo">
                    <a href="{{ route('Home::index') }}">
                        <img src="{{ $data['peizi']['logo'] ?? '' }}" width="120" title="{{ $data['peizi']['title']}}">
                    </a>
                </div>
                <ul class="menu-list clx">
                    <li class="item {{ Route::currentRouteName()  == "Home::index" ? "active" : ''}}">
                        <a href="{{ route('Home::index') }}">首页</a>
                    </li>
                    <li class="item {{ Route::currentRouteName()  == "Home::list" ? "active" : ''}}">
                        <a href="{{ route('Home::list') }}">文章列表</a>
                    </li>


                    <li class="item {{ Route::currentRouteName()  == "Home::about" ? "active" : ''}}">
                        <a href="{{ route('Home::about') }}">关于我</a>
                    </li>
                    <li class="item {{ Route::currentRouteName()  == "Home::liuyan" ? "active" : ''}}">
                        <a href="{{ route('Home::liuyan') }}">在线留言</a>
                    </li>
                </ul>
                <button id="menushort" class="menushort"><span></span></button>
                <div class="usercenter">
                    <a href="{{ route('Admin::index') }}"><i class="iconfont icon-user"></i></a>
                </div>
            </div>
        </div>
        <div class="search-wrap">
            <form name="searchform" class="searchform" action="{{ route('Home::search') }}" method="get">
                <input type="text" name="word" value="{{ request()->input('word') ?? '' }}" maxlength="20" class="search-input" placeholder="请输入要查询的关键字">
                <button type="submit" class="search-verify">搜索</button>
            </form>
        </div>
    </header>
    <main class="main">
        <div class="wp">
            <div class="main-inner">
                <div class="content-left">
                    @section('content')
                    @show
                </div>
                @if(! in_array(Route::currentRouteName(),["Home::search",'Home::about'] ))
                    <div class="content-right">
                        <div class="site-author">
                            <div class="author-photo">
                                <a href="#"><img
                                        src="{{ $data['myinfo']->avatar ?? config('mm.__HOME__') ."images/i2.jpg" }}"
                                        alt=""></a>
                            </div>
                            <p class="author-name">{{ $data['myinfo']->nickname  ?? ''}}</p>
                            <p class="author-desc">{{ $data['myinfo']->detail ?? ''  }}</p>
                            <div class="author-more">
                                <dl class="data-count">
                                    <dt>
                                        文章
                                    </dt>
                                    <dd>{{ $data['art_count'] ?? 0}}</dd>
                                </dl>
                                <dl class="data-count">
                                    <dt>
                                        标签
                                    </dt>
                                    <dd>{{ $data['tag']->count() ?? 0}}</dd>
                                </dl>
                                <dl class="data-count">
                                    <dt>
                                        分类
                                    </dt>
                                    <dd>{{ $data['cat_count'] ?? 0}}</dd>
                                </dl>

                            </div>
                        </div>
                        <div class="widget">
                            <h3 class="title">
                                最新文章
                            </h3>
                            <div class="cont">
                                <ul class="newarts">
                                    @foreach($data['nowart'] as $v)
                                        <li>
                                            <a href="{{ route('Home::article',['article'=>$v->id]) }}">{{ $v->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="widget">
                            <h3 class="title">
                                标签云
                            </h3>
                            <div class="cont">
                                <div class="tagcloud clx">
                                    @foreach($data['tag'] as $v)
                                        <a href="{{ route('Home::tagname',['name'=>$v->name]) }}">{{ $v->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
    <footer class="footer">
        <p class="flist">
            <a href="{{ route('Home::sitemap') }}">网站地图</a>
            <a href="{{ route('Home::list') }}">所有文章</a>
            <a href="#">标签集合</a>
            <script type="text/javascript" src="https://s4.cnzz.com/z_stat.php?id=1279445264&web_id=1279445264"></script>
        </p>
        <p class="cr">{{ $data['peizi']['title'] ?? '年华流失' }}个人博客网站 版权所有</p>
        <p class="cr">程序设计:刘崇胡</p>
        <p class="cr">Copyright © {{ $_SERVER['HTTP_HOST'] }} All Rights Reserved.</p>
        @if(isset($data['peizi']['copyright']) && $data['peizi']['copyright'] !=="")<p class="cr">备案号: <a target="_blank" href="https://beian.miit.gov.cn/">{{ $data['peizi']['copyright'] }}</a></p>@endif
        <p class="cr">服务器计算耗时: <span style="color: red">{{  number_format(microtime(true)-$data['start_time'],10,'.',',') }}</span> (s)</p>
    </footer>
    <div class="fixicons">
        <span class="qrcode">

                <a href="javascript:void(0)"><i class="iconfont icon-code2"></i></a>
                <span class="qrcode-c" id="qrcode">
                </span>
        </span>
        @if(auth()->check() && Route::currentRouteName() == "Home::article")

            <span>
                <a href="{{ route('Admin::article.edit',[$article]) }}"><i class="iconfont icon-edit"></i></a>
            </span>
        @endif
        <span>
                <a href="#"><i class="iconfont icon-zhiding"></i></a>
            </span>
    </div>
</div>
{!!  $data['peizi']['tongji'] ?? ''!!}

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="{{ config('mm.__HOME__') }}js/m.js"></script>
{{--<script src="https://cdn.bootcdn.net/ajax/libs/prism/1.24.1/prism.js"></script>--}}
<script src="{{ config('mm.__LIB__' ) }}prism/prism.js"></script>

<script src="https://cdn.bootcdn.net/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    var qrcode = new QRCode("qrcode", {
        text: window.location.href,
        width: 100,
        height: 100,
        colorDark: "#ffffff",
        colorLight: "#050505",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

</body>

</html>
