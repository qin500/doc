@extends("home.default")
@section('title',"标签")
@section('keywords', request()->get('name'))
@section('description', request()->get('name'))

@section('content')
    <div class="posdw">
        <p><i class="iconfont icon-location"></i>&nbsp;您当前的位置：<a href="{{ route('Home::index') }}">首页</a> &gt; <a href="{{ route('Home::tagname') }}">【标签列表】</a> &gt; <a href="#">{{ \Illuminate\Support\Facades\Request::input('name') }}</a> </p>
    </div>
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
                {!! mb_substr(strip_tags($item->text),0,200) !!}
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

{{ $list->links() }}
@endsection
