@extends('admin.default')
@section('title','文章列表')
@section('content')
    <div class="q5navt">
        <a href="{{ route('Admin::index') }}">后台首页</a>
        <a href="#">文章列表</a>
    </div>
    @if(session()->has('publish-code'))
    <div class="wcont">
        <div class="publish-code">
            <h2>文章发布成功</h2>
            <p class="title">{{ session('publish-code')['title'] }}</p>
            <p><a class="link" href="{{ route('Home::article',['article'=>session('publish-code')['id']]) }}">查看</a><a class="link" href="{{ route('Admin::article.edit',['article'=>session('publish-code')['id']]) }}">编辑</a></p>
        </div>
    </div>
    @endif
    <div class="q5tit1">
        <span class="zt">文章列表</span>
        <div class="q5fr">
        </div>
    </div>
    <div class="wcont">
        <div class="q5card">
            <p class="card-head">文章筛选</p>
            <div class="card-body">
                <div class="q5stream-form q5clearfix">
                    <label>ID</label>
                    <select id="idseek">
                        <option value="-1">请选择</option>
                        @foreach($list  as $v)
                        <option {{ request()->input('id') !== null && request()->id == $v->id ? 'selected':'' }} value="{{ $v->id }}">{{ $v->id }}</option>
                        @endforeach
                    </select>
                    <label>分类</label>
                    <select>
                        <option value="-1">请选择</option>
                        <option value="-1">php基础教程</option>
                        <option value="-1">javascript教程</option>
                    </select>
                    <label>状态</label>
                    <select id="isshow">
                        <option {{ request()->input('isshow') !== null && request()->isshow == -1 ? 'selected':'' }} value="-1">全部</option>
                        <option {{ request()->input('isshow') !== null && request()->isshow == 1 ? 'selected':'' }} value="1">显示</option>
                        <option {{ request()->input('isshow') !== null && request()->isshow == 0 ? 'selected':'' }} value="0">隐藏</option>
                    </select>
                    <input type="text" placeholder="请输入文章标题关键字">
                    <a class="q5bg-success q5text-white q5border-success">立即搜索</a>
                </div>
            </div>
        </div>
    </div>

    <div class="wcont">
        <a class="q5btn q5bg-blue" href="{{ route('Admin::article.create') }}">新增文章</a>
        <a class="q5btn q5bg-blue" href="{{ route('Admin::article.tuisong') }}">全部推送</a>
        <div class="q5row">
            <div class="q5table">
                <table>
                    <tbody>
                    <tr>
                        <th>序号</th>
                        <th>分类</th>
                        <th>标题</th>
                        <th>时间</th>
                        <th>浏览</th>
                        <th>百度推送</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($article  as $key=>$v)
                    <tr data-id="{{  $v->id  }}">
                        <td>{{ $v->id  }}</td>
                        <td>{!! $v->category()->name  ?? '<p style="text-align:center;color:red"><b>未定义</b></p>'!!}</td>
                        <td class="title"><a target="_blank" href="{{ route('Home::article',[$v]) }}">{{ $v->title }} </a></td>
                        <td>{{ $v->created_at }}</td>
                        <td>{{ $v->views }}</td>
                        <td>{{ $v->bdts }}</td>
                        <td>
                            <input type="checkbox" {{ $v->isshow ? "checked":'' }} class="q5switch" id="switch{{ $v->id }}" data-switch="success">
                            <label for="switch{{ $v->id }}"><em data-on="显示" data-off="隐藏"></em></label>
                        </td>
                        <td class="handle">
                  <a href="{{ route('Admin::article.edit',['article'=>$v->id]) }}" class="q5text-info">编辑</a>
                            <a data-form="delete" href="{{ route('Admin::article.destroy',['article'=>$v->id]) }}" class="q5text-danger">删除</a>
                        </td>
                    </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{ $article->links()}}
@endsection

@section('footer')
    <script>
        q5formdelete(function (e, m) {
            if (e.status == "success") {
                for(var value of e.ids){
                    $('[data-id="' + value + '"').remove();
                }
            }
        })
        $('#idseek').change(function (e){
            document.location.href=document.location.origin + document.location.pathname + "?id=" + $(this).val()
        })
        $('#isshow').change(function (e){
            document.location.href=document.location.origin + document.location.pathname + "?isshow=" + $(this).val()
        })
        $('[class="q5switch"]').click(function (){
            let id=($(this).attr('id').replace("switch",""));
            $.get(document.location.href,{'type':'update','par':'hidden','id':id},function (e){});
        })
    </script>

@endsection

