@extends("home.default")
@section('title',"程序与生活于一体的个人博客")

@section('content')
    <p class="big-title">
        最新文章
    </p>
    <ul class="article-lists">
        @foreach($list as $item)
        <li>
            <a target="_blank" href="{{ route('Home::article',[$item]) }}">
                <i>
                    <img src="{{ $item->masterpic }}"
                         alt="{{ $item->title }}">
                </i>
                <h2>{{ $item->title }}</h2>
            </a>
            <p>
                {!! mb_substr($item->pure,0,200) !!}
            </p>
            <div class="article-lists-detail">
                <span class="date"><i class="iconfont icon-date1"></i>{{ date('Y-m-d',strtotime($item->created_at)) }}</span>
                <span class="date"><i class="iconfont icon-eye"></i>{{ $item->views }}</span>
            </div>
            <a target="_blank" href="{{ route('Home::article',[$item]) }}" class="article-lists-view">
                阅读更多
            </a>
        </li>
        @endforeach
    </ul>



@endsection
