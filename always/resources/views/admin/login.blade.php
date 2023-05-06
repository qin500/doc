<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录系统</title>
    <link href="//at.alicdn.com/t/font_2113112_18vz4hgkkl3i.css" type="text/css" rel="stylesheet"/>
    <link href="{{ config('mm.__ADMIN__') }}login/css/style.css" type="text/css" rel="stylesheet"/>
</head>

<body>
<div class="app">
    <div class="photo">
        <img src="{{ config('mm.__ADMIN__') }}login/images/bg.jpg" alt="">
    </div>
    <div class="form">
        <div class="form-inner">
            <h1><a href="{{ route('Home::index') }}">Sign in to Account</a></h1>
            <form method="post" action="{{ route('Admin::login') }}">
                @csrf
                <div class="input-form">
                    <div class="input-box">
                        <label class="lab">Username</label>
                        <span class="ico">
                            <i class="iconfont icon-user"></i>
                        </span>
                        <input type="text" name="username" maxlength="20" class="form-control" placeholder="Username">
                    </div>
                    <div class="input-box">
                        <label class="lab">Password</label>
                        <input type="password" name="password" maxlength="20" class="form-control" placeholder="Password">
                        <span class="ico">
                            <i class="iconfont icon-password"></i>
                        </span>
                    </div>
                </div>
                <p><label class="remember"><input type="checkbox" name="remember">Remember me</label> <a class="forget"
                                                                                                         href="#">Forget
                        password?</a></p>
                <button type="submit" class="validate">Log In</button>
            </form>
            <p class="enroll">Don't have a account? <a href="#">Register Here</a></p>
        </div>
    </div>
</div>
<script src="{{ config('mm.__ADMIN__')  }}js/jquery-3.4.1.min.js" ></script>
<script src="{{ config('mm.__ADMIN__') }}login/js/m.js"></script>
</body>

</html>
