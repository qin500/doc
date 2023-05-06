@extends("home.default")
@section('keywords' ,"$keywords")
@section('description', str_replace(PHP_EOL,",",mb_strimwidth(ltrim($article->pure),0,400,"",'utf-8' ) ))
@section('title', $article->title )

@section('content')
        <div class="posdw">
            <p><i class="iconfont icon-location"></i>&nbsp;您当前的位置：<a href="{{ route('Home::index') }}">首页</a> &gt;
                @foreach($top_cates as $item)
                <a href="{{ route('Home::category',[$item]) }}">{{ $item->name }}</a> &gt;
                @endforeach
                <a href="javascript:void(0)">{{ $article->title }}</a>
            </p>
        </div>
        <div class="post-warp">
            <h1>{{ $article->title }}</h1>
            <p class="info">日期：{{ $article->created_at }}  &nbsp;&nbsp;&nbsp;浏览：{{ $article->views }}</p>
            <div class="post-cont">
                @if((!$article->isshow) && (!auth()->check()))
                    <p style="font-size: 28px;line-height: 35px;text-align: center;color:red;text-shadow: 2px 2px 5px #ffb6bd">对不起,您没有权限查看该文章!</p>
                @else
                    {!!  $article->text !!}
                @endif
            </div>
            <button class="praise">很赞哦({{ $article->zan }})</button>
            @if(count($tags))
            <p class="tags">Tags:
                @foreach($tags as $item)
                <a href="{{ route('Home::tagname',['name'=>$item->name]) }}" class="item">{{ $item->name }}</a>
                @endforeach
            </p>
            @endif
            <div class="siblings">
                <p>上一篇: <a href="{{ $article_prev !== null ? route('Home::article',[$article_prev]) : '' }}">{{ $article_prev->title ?? '没有了' }}</a></p>
                <p>下一篇: <a href="{{ $article_next !== null ? route('Home::article',[$article_next]) : '' }}">{{ $article_next->title ?? '没有了' }}</a></p>
            </div>
        </div>
        <div class="post-my">
            <div class="wp">
                <div class="post-my-wp">
                    <div class="photo">
                        <a href="#"><img src="{{ $data['myinfo']->avatar  }}" alt=""></a>
                    </div>
                    <div class="dt">
                        <h3>{{ $data['myinfo']->nickname  }}</h3>
                        <p class="xd">{{ $data['myinfo']->detail ?? ''  }}</p>
                    </div>
                    <div class="qr">
                        <img src="{{ $data['myinfo']->wxcode  }}" alt="">
                    </div>
                </div>
            </div>
        </div>

@endsection
