<div class="aside-menu-warp q5scroll">
    <ul class="aside-menu">
        <li class="item open">
            <a href="{{ route('Admin::index') }}" class="active"><span class="ifont"><i class="iconfont icon-home"></i></span>
                <span class="ititle">后台首页</span>
            </a>
            <ul class="ex">
            </ul>
        </li>
        <li class="item open">
            <a href="javascript:void(0)"><span class="ifont"><i class="iconfont icon-ccedit"></i></span>
                <span class="ititle">文章管理</span>
                <span class="menu-arrow"><i class="iconfont icon-up"></i></span></a>
            <ul class="ex">
                <li>
                    <a href="{{ route('Admin::article.create') }}"><span class="ititle">创建文章</span></a></li>
                <li>
                    <a href="{{ route('Admin::article.index') }}"><span class="ititle">文章列表</span></a></li>
                <li>
                    <a href="{{ route('Admin::category.index') }}"><span class="ititle">分类管理</span></a></li>
            </ul>
        </li>
        <li class="item open">
            <a href="javascript:void(0)"><span class="ifont"><i class="iconfont icon-setting"></i></span>
                <span class="ititle">信息设置</span>
                <span class="menu-arrow"><i class="iconfont icon-up"></i></span></a>
            <ul class="ex">
                <li>
                    <a href="{{ route('Admin::info.myinfo') }}"><span class="ititle">基本信息</span></a></li>
                <li>
                    <a href="{{ route('Admin::info.setting') }}"><span class="ititle">系统信息</span></a></li>  <li>
                    <a href="{{ route('Admin::info.passwordManage') }}"><span class="ititle">密码修改</span></a></li>
            </ul>
        </li>

    </ul>
</div>

