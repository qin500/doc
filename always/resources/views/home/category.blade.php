@extends("home.default")
@section('title',"分类列表")

@section('content')
    <div class="posdw">
        <p><i class="iconfont icon-location"></i>&nbsp;您当前的位置：<a href="{{ route('Home::index') }}">首页</a> &gt; <a href="{{ route('Home::category',['category'=>0]) }}">文章列表</a> </p>
    </div>
    <div class="postslist">
        <ul class="chunk">
            @foreach($list as $v)
            <li><span class="lc"><a  class="ltxt" href="{{ route('Home::article' , [$v]) }}">{{ $v->title }}</a></span><span class="date">{{ date('Y-m-d',strtotime($v->created_at)) }}</span>
            @endforeach
        </ul>
    </div>

{{$list->links()}}
@endsection

