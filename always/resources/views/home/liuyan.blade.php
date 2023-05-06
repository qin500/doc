@extends("home.default")
@section('title', "留言" )

@section('content')

    <div class="liuyan-warp">
       <div class="liuyan-post">
           <div class="zy">
               <input class="item" type="text" placeholder="昵称">
               <input class="item" type="text" placeholder="邮箱(非公开)">
               <input class="item" type="text" placeholder="您的网址(非必填)">
           </div>
           <textarea class="content" spellcheck="false" name="" id="" cols="30" rows="10"></textarea>
       </div>
        <div class="liuyan-show">

        </div>
    </div>

@endsection
