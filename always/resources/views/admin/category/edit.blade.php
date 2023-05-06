@extends('admin.default')
@section('title','编辑分类')

@section('content')
    <div class="q5navt">
        <a href="{{ route('Admin::index') }}">后台首页</a>
        <a href="{{ route('Admin::category.index') }}">分类管理</a>
        <a href="#">编辑分类</a>
    </div>
    <div class="q5tit1">
        <span class="zt">编辑分类</span>
        <div class="q5fr">
        </div>
    </div>
    <div class="wcont">
        <form action="{{ route('Admin::category.update',[$category]) }}" method="post">
            @csrf
            @method('put')
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">上级分类<span>*</span></label>
                    <select class="form-control" name="pid">
                        <option value="0">顶级分类</option>
                        @foreach($cates as $k=>$v)
                            <option {{ $category->pid == $v->id ? 'selected':'' }} value="{{$v->id}}">{{($v->level==0)?"":"|"}}{{str_repeat("------",$v->level)}}{{$v->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="id" value="{{ $category->id }}">
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">分类名称</label>
                    <input class="form-control" maxlength="30" type="text" value="{{ $category->name }}" name="name" placeholder="请输入分类名称">
                </div>
            </div>
            <div class="q5row">
                <input type="submit" class="q5btn btn-lg q5bg-blue" value="更新分类">
            </div>
        </form>
    </div>
@endsection
