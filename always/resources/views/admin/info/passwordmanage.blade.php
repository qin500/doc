@extends('admin.default')
@section('title','我的信息')

@section('content')

    <div class="q5navt">
        <a href="https://admin.qin500.com">后台首页</a>
        <a href="#">我的信息</a>
    </div>
    <div class="q5tit1">
        <span class="zt">我的信息</span>
    </div>
    <div class="wcont">
        <form action="{{ route('Admin::info.passwordManage') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="q5row q5col-6">
                <div class="q5input-group">
                    <label class="form-label" for="#">旧密码</label>
                    <input class="form-control" maxlength="60" type="password"
                           required="" name="oldpassword"
                           placeholder="请输入旧密码">
                </div>
                <div class="q5input-group ">
                    <label class="form-label" for="#">密码</label>
                    <input class="form-control" maxlength="60" type="password"
                           required="" name="password"
                           placeholder="请输入新密码">
                </div>
                <div class="q5input-group ">
                    <label class="form-label" for="#">重复新密码</label>
                    <input class="form-control" maxlength="60" type="password"
                           required="" name="password_confirmation"
                           placeholder="请重复输入新密码">
                </div>
            </div>



            <div class="q5row">
                <input type="submit" class="q5btn btn-lg q5bg-blue" value="保存设置">
            </div>
        </form>

    </div>

@endsection


