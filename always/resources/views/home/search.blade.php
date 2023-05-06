@extends("home.default")
@section('title',"搜索")

@section('content')
    <div class="posdw">
        <p><i class="iconfont icon-location"></i>&nbsp;您当前的位置：<a href="#">首页</a> &gt; <a href="#">内容搜索</a> </p>
    </div>
    <div class="search-warp">
        <p class="result">{{ $data['peizi']->title ?? '' }}为你找到相关结果<span class="count">{{ $list->total() ?? 0 }}</span>条</p>
        <ul class="c-cont">
            @foreach($list as $item)
            <li class="item">
                <h2 class="title"><a target="_blank" href="{{ route('Home::article',[$item]) }}">{!!  preg_replace("/(" . str_replace('/','\/',quotemeta($word)) .")/i","<span class='word'>\$1</span>",$item->title) !!}</a></h2>
                <p class="desc"><?php
                    $cross=stristr($item->pure, quotemeta($word));
                   echo  preg_replace("/(" .  str_replace('/','\/',preg_quote($word)) .")/i","<span class='word'>\$1</span>",mb_substr($cross ,0,90));
//                   echo  preg_replace("/(" . str_replace('/','\/',$word) .")/i","<span class='word'>\$1</span>",mb_substr($cross ,0,90));
                    ?></p>

                <p class="c-link">
                    {{ route('Home::article',[$item]) . " - " . date('Y-m-d',strtotime($item->created_at)) }}
                </p>
            </li>
            @endforeach
        </ul>

        {{ $list->appends(['word'=>$word])->links() }}
    </div>


@endsection
