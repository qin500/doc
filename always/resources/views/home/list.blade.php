@extends("home.default")
@section('title',"文章列表")
@section('keywords',"文章列表,最新文章,php,vue,cmd,laravel,javascript,webpack")
@section('description',$data['peizi']['description'])

@section('content')
    <div class="posdw">
        <p><i class="iconfont icon-location"></i>&nbsp;您当前的位置：<a href="{{ route('Home::index') }}">首页</a> &gt; <a href="#">文章列表</a> </p>
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

