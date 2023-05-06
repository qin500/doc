@extends("home.default")
@section('title', "关于我" )
@section('keywords', "关于我" )

@section('content')

    <div class="about-warp">
        <div class="mp">
            <img src="{{ $data['myinfo']->avatar }}"
                 alt="">
        </div>
        <p class="txt">
            欢迎您，来到我的个人博客。让我们一起感受生命中的点点滴滴。人生与故事一样：重点不在它有多长，在于它有多精彩。我希望活得深刻，并汲取生命中所有的精华。然后从中学习，以免让我在生命终结时，却发现自己从来没有活过。不要只因一次失败，就放弃你原来决心想达到的目的。
        </p>
        <h3 class="tit">关于我</h3>
        <p class="txt">
            名刘崇胡 喜欢折腾和新事物。</p>
        <p class="txt">
            建站非专业，纯属个人爱好。</p>
        <h3 class="tit">[Contact]</h3>
        <p class="txt">
            work@qin500.com</p>
        <p class="txt">
            为什么要建立这个博客网站</p>
        <p class="txt"> 我用它做些什么</p>
        <p class="txt">记录过去的岁月、分享有趣和学习的东西；</p>
        <h3 class="tit">关于本站</h3>
        <p class="txt">本站结构：</p>
        <p class="txt">系统环境:Centos8.0 + Nginx + MySql8 </p>
        <p class="txt">前 端 ：HTML + CSS3 + JQuery </p>
        <p class="txt">后 端 ：Laravel + MYSQL </p>
        <p class="txt">本站采用阿里云提供的服务器ESC和存储对象OSS。</p>
        <p class="txt">程序由本人编写</p>
    </div>
    <audio src="/upload/00001/20210707124403_e0b34fd1170ac44fdf5c3ef371df05d32267288e.mp3" autoplay ></audio>
@endsection
