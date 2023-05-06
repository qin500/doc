@extends('admin.default')
@section('title','网站配置')

@section('content')
    <div class="q5navt">
        <a href="{{ route('Admin::index') }}">后台首页</a>
        <a href="#">我的设置</a>
    </div>
    <div class="q5tit1">
        <span class="zt">我的设置</span>
    </div>
    <div class="wcont">
        <form action="{{ route('Admin::info.setting') }}" method="post">
            @csrf
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">博客标题</label>
                    <input class="form-control" maxlength="60" type="text" value="{{ $peizi['title'] ?? '' }}" required="" name="title"
                           placeholder="请输入博客标题">
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">子标题</label>
                    <input class="form-control" maxlength="60" type="text" value="{{ $peizi['entitle'] ?? '' }}" required="" name="entitle"
                           placeholder="请输入博客子标题">
                </div>
            </div>
            <div class="q5input-group">
                <label class="form-label" for="#">LOGO</label>
                <div class="file-control">
                    <input readonly class="form-control form-text" name="logo" value="{{ $peizi['logo'] ?? '' }}" type="text"
                           placeholder="请上传博客LOGO">
                    <button data-id="file" type="button"  class="btnupload">
                        选择文件
                    </button>
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">关键字</label>
                    <input class="form-control" maxlength="60" type="text" value="{{ $peizi['keywords'] ?? '' }}" required="" name="keywords"
                           placeholder="请输入网站关键性">
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">备案号</label>
                    <input class="form-control" maxlength="60" type="text" value="{{ $peizi['copyright'] ?? '' }}" name="copyright"
                           placeholder="请输入备案号">
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">博客描述</label>
                    <textarea class="form-textarea" rows="4" maxlength="500" placeholder="请输入网站描述"
                              name="description">{{ $peizi['description'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">统计代码</label>
                    <textarea class="form-textarea" rows="10" maxlength="500" placeholder="请输入统计代码"
                              name="tongji">{{ $peizi['tongji'] ?? '' }}</textarea>
                </div>
            </div>

            <div class="q5row">
                <input type="submit" class="q5btn btn-lg q5bg-blue" value="保存设置">
            </div>
        </form>

    </div>

@endsection
