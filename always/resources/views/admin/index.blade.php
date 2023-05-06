@extends('admin.default')
@section('title','后台首页')

@section('content')
    <div class="q5row">
        <div class="index-box">
            <div class="lbox">
                <a class="myphoto" href="#"><img class="my"
                                                 src="{{ $data['myinfo']->avatar ?? ''}}"
                                                 alt=""></a>
                <div class="mr">
                    <p class="nk">Hi,<span style="color:red"> {{  $data['myinfo']->nickname ?? '' }}</span></p>
                    <p class="ts">
                        <script>let bb = function () {
                                let data = new Date();
                                let myhour = data.getHours();
                                myhour = parseInt(myhour)
                                if (myhour >= 5 && myhour <= 10) {
                                    return "早上";
                                } else if (myhour >= 11 && myhour <= 13) {
                                    return "中午";
                                } else if (myhour >= 14 && myhour <= 17) {
                                    return "下午";
                                } else if (myhour >= 18 && myhour <= 23) {
                                    return "晚上";
                                } else {
                                    return "深夜"
                                }
                            }
                            document.write(bb());
                        </script>
                        好,为梦想加油!
                    </p>
                </div>
            </div>
            <div class="rbox">
                <a class="item" href="{{ route('Admin::article.index') }}">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="wa">
                        <p class="n">{{ $data['art_count'] ?? 0}}</p>
                        <p class="t">文章总数</p>
                    </div>
                </a>
                <a class="item">
                    <div class="icon">
                        <i class="fa fa-pencil"></i>
                    </div>
                    <div class="wa">
                        <p class="n">0</p>
                        <p class="t">评论总数</p>
                    </div>

                </a>
                <a class="item">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="wa">
                        <p class="n">0</p>
                        <p class="t">收藏总数</p>
                    </div>

                </a>
                <a class="item">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="wa">
                        <p class="n">0</p>
                        <p class="t">我的粉丝</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
    <div class="q5row">
        <div class="q5tabControl">
            <div class="tab-head">
                <a class="tab-item" href="#">所有文章</a>
                <a class="tab-item" href="#">待审核</a>
                <a class="tab-item active" href="#">审核通过</a>
            </div>
            <div class="tab-body">
                <div class="item">1</div>
                <div class="item">2</div>
                <div class="item">3</div>
            </div>
        </div>

    </div>
    <div class="q5row">
        <div class="q5col-6 q5col-sm-12">
            <div class="index-widget q5mgr-10 q5mgr-sm-0">
                <h4 class="title">最新文章</h4>
                <div class="index-news">
                    <p class="item"><a class="link" href="#">第一篇文章哈哈</a><span class="num">30</span></p>
                    <p class="item"><a class="link" href="#">第一篇文章哈哈</a><span class="num">30</span></p>
                    <p class="item"><a class="link" href="#">第一篇文章哈哈</a><span class="num">30</span></p>
                    <p class="item"><a class="link" href="#">第一篇文章哈哈</a><span class="num">30</span></p>
                </div>
            </div>
        </div>
        <div class="q5col-6 q5col-sm-12 ">
            <div class="index-widget  q5mgr-sm-0">
                <h4 class="title">最新留言</h4>
                <div class="index-coms">
                    <p class="item"><a class="link" href="#">效于飞</a>于2月15日14:30: <span class="txt"> 这个太赞了</span></p>
                    <p class="item"><a class="link" href="#">婉约</a>于2月15日14:30: <span class="txt"> 博客可以分享一下吗</span></p>
                    <p class="item"><a class="link" href="#">李俊</a>于2月15日14:30: <span class="txt"> 这个太赞了</span></p>
                    <p class="item"><a class="link" href="#">张国立</a>于2月15日14:30: <span class="txt"> 哇!挺好</span></p>
                    <p class="item"><a class="link" href="#">李雅婷</a>于2月15日14:30: <span class="txt"> 必须的!</span></p>
                    <p class="item"><a class="link" href="#">小明</a>于2月15日14:30: <span class="txt"> 这个太赞了</span></p>
                    <p class="item"><a class="link" href="#">张飞</a>于2月15日14:30: <span class="txt"> 哈哈,这个必须赞</span></p>
                </div>
            </div>
        </div>
    </div>
@endsection
