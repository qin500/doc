@extends('admin.default')
@section('title','我的信息')

@section('content')

    <div class="q5navt">
        <a href="{{ route('Admin::index') }}">后台首页</a>
        <a href="#">我的信息</a>
    </div>
    <div class="q5tit1">
        <span class="zt">我的信息</span>
    </div>
    <div class="wcont">
        <form action="{{ route('Admin::info.myinfo') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">昵称</label>
                    <input class="form-control" maxlength="60" type="text" value="{{ $other['nickname'] ?? ''}}"
                           required="" name="nickname"
                           placeholder="请输入博客标题">
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">头像</label>
                    <div class="file-control">
                        <input readonly  class="form-control form-text" name="avatar" value="{{ $other['avatar'] ?? '' }}"
                               type="text" placeholder="请上传你的头像">
                        <button data-id="file" data-url="" type="button" class="btnupload">选择文件</button>
                    </div>
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">微信二维码</label>
                    <div class="file-control">
                        <input readonly  class="form-control form-text"
                               value="{{ $other['wxcode'] ?? '' }}" type="text" name="wxcode"
                               placeholder="请上传个人微信二维码">
                        <button data-id="file" data-url="" type="button" class="btnupload">选择文件</button>
                    </div>
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">说明</label>
                    <textarea class="form-textarea" rows="10" maxlength="500" placeholder="输入你想说的话"
                              name="detail">{{ $other['detail'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="q5row">
                <input type="submit" class="q5btn btn-lg q5bg-blue" value="保存设置">
            </div>
        </form>

    </div>

@endsection

