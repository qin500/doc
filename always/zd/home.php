<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录/注册</title>
    <style>
        .panel {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            min-width: 320px;
        }

        .form input {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 100%;
            font-size: 16px;
            color: #333;
            background-color: #f8f8f8;
            padding: 0;
            height: 45px;
            text-indent: 1rem;

        }

        .form select {
            margin-bottom: 10px;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 100%;
            font-size: 16px;
            color: #333;
            background-color: #f8f8f8;
        }

        .form button {
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease-in-out;
        }

        .form button:hover {
            background-color: #0069d9;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            display: none;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            width: 300px;
        }

        .login-form .close {
            font-size: 3rem;
            width: 30px;
            height: 30px;
            margin-left: auto;
            margin-top: -30px;
            transform: translateY(30px);
        }

        .login-form input {
            margin-bottom: 10px;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: calc(100% - 30px);
            font-size: 16px;
            color: #333;
            background-color: #f8f8f8;
        }

        .login-form button {
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease-in-out;
        }

        .login-form button:hover {
            background-color: #0069d9;
        }

        .login-form a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        .login-form .codeyz {
            position: relative;
            width: 100%;
        }

        .login-form .codeyz .sendcode {
            position: absolute;
            right: 0;
            float: right;
            width: 110px;
            font-size: 15px;
            white-space: nowrap;
            background: purple;
        }

        .login-form .codeyz .emcode {
            float: left;
        }

        #notification-container {
            position: fixed;
            top: 120px;
            z-index: 1000;
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            min-width: 300px;
            max-width: 450px;
            font-size: 30px;
            user-select: none;
        }

        .notification {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 4px;
            font-size: 18px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .notification .notification-icon {
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
        }

        .notification.show {
            opacity: 1;
        }

        .notification-icon {
            margin-right: 10px;
        }

        .success {
            background-color: #abeb94;
            color: #267909;
        }

        .info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        p {
            width: 100%;
            margin: 5px;
        }

        .bigscreen {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div id="notification-container"></div>
<div class="panel">
    <div class="form" id="brush">
        <h2>自动化处理平台</h2>
        <select q-data="manner">
            <option value="bj">白鲸加速器</option>
            <option value="ay">安易加速器</option>
        </select>
        <p>白鲸邀请码5个字符,安易6个字符</p>
        <input q-data="yqm" type="text" placeholder="邀请码">


        <button id="submit-btn" onclick="startWork()">提交</button>
        <div class="bigscreen"></div>
    </div>
</div>

<div class="overlay" id="login-overlay">

    <div class="login-form">
        <a class="close" onclick="closePlane()">&times;</a>

        <h2>登录</h2>
        <input type="text" q-data="account" placeholder="用户名/邮箱">
        <input type="password" q-data="password" placeholder="密码">
        <button onclick="login()">登录</button>
        <a href="#" onclick="togglePlane('register')">还没有账号？点此注册</a>
    </div>
    <div class="login-form" id="register-form">
        <a class="close" onclick="closePlane()">&times;</a>
        <h2>注册</h2>
        <input type="username" minlength="5" maxlength="18" q-data="username" value="qin50022"
               placeholder="请输入用户名">
        <input type="email" q-data="email" value="www@qq.com" placeholder="请输入邮箱">
        <div class="codeyz">
            <input type="number" q-data="emcode" maxlength="6" class="emcode" placeholder="请输入邮箱验证码">
            <button class="sendcode" type="button" onclick="sendcode(this)">发送验证码</button>
        </div>

        <input type="password" minlength="5" maxlength="20" value="12345" q-data="password" placeholder="密码">
        <input type="password" q-data="confirmpassword" value="12345" placeholder="确认密码">

        <button onclick="register()">注册</button>
        <a href="#" onclick="togglePlane('login')">已有账号？点此登录</a>
    </div>
</div>

<script>
    var loginForm = document.querySelector("#login-overlay .login-form");
    var registerForm = document.querySelector("#register-form");

    function startWork() {
        let brush = document.getElementById('brush');
        let manner = brush.querySelector('[q-data="manner"]');
        let yqm = brush.querySelector('[q-data="yqm"]')

        // if (yqm.value == "") {
        //     createNotification("info", '请输入邀请码');
        //     return false;
        // }
        //
        // if ((manner.value == "bj" && yqm.length !== 5) || (manner.value == "ay" && yqm.length !== 6)) {
        //     createNotification('error', '邀请码长度不符合要求！')
        //     return false;
        // }

        xhr({'type': "work", manner: manner.value, yqm: yqm.value}, function (e) {

            let bigscreen = document.querySelector('.bigscreen');
            let outstr = e.msg;
            if (e.data.yue) {
                outstr = `<p><b>非永久会员</b> 余额: <span style="color:red;font-weight:bold;"> ${e.data.yue} </span> </p><p><b>开通会员只需一个面包钱,5块钱</b></p><p>${e.msg}</p>`;
            }
            bigscreen.innerHTML = outstr
        })

    }


    function login() {
        let form = document.querySelector('#login-overlay');
        let account = form.querySelector('[q-data="account"]')
        let password = form.querySelector('[q-data="password"]')

        if (account.value == "") {
            createNotification('info', '请输入账户')
            return false;
        }
        if (password.value == "") {
            createNotification('info', '请输入密码')
            return false;
        }

        xhr({'type': "login", account: account.value, password: password.value}, function (e) {
            console.log(e)
        })


    }

    function register() {
        // TODO: 处理注册逻辑
        let regForm = document.querySelector("#register-form");
        let username = regForm.querySelector('[q-data="username"]')
        let email = regForm.querySelector('[q-data="email"]')
        let emcode = regForm.querySelector('[q-data="emcode"]')
        let password = regForm.querySelector('[q-data="password"]')
        let confirmpassword = regForm.querySelector('[q-data="confirmpassword"]')


        if (username.value.trim() == "") {
            createNotification('info', "用户名不能为空")
            return false;
        }

        if (!validUsername(username.value)) {
            createNotification('info', "用户名不符合规则,用户名以字母开头5-18位,字母与数字组合")
            return false
        }
        if (email.value.trim() == "") {
            createNotification('info', "邮箱不能为空")
            return false
        }

        if (!validEmail(email.value)) {
            createNotification('info', "邮箱格式不正确")
            return false
        }


        if (password.value.trim() == "") {
            createNotification('info', "密码不能为空")
            return false
        }

        if (password.value.length < 5) {
            createNotification('info', "密码长度至少为5个字符")
            return false
        }

        if (password.value.trim() !== confirmpassword.value.trim()) {
            createNotification('info', "两次密码不一样,请重新输入")
            return false
        }


        if (emcode.value.trim() == "") {
            createNotification('info', "验证码不能为空")
            return false
        }

        xhr({
            'type': "register",
            username: username.value,
            email: email.value,
            password: password.value,
            emcode: emcode.value
        }, function (e) {
            setTimeout(() => {
                location.reload();
            }, 5000)
            if (e.code == 114) {
                username.value = ""
                email.value = ""
                emcode.value = ""
                password.value = ""
                confirmpassword.value = ""
            }
        })

    }


    function validEmail(email) {
        const re = /\S+@\S+\.\S+/;
        return re.test(email)
    }

    function validUsername(username) {
        const re = /^[a-zA-Z][a-zA-Z0-9]{4,9}$/;
        return re.test(username);
    }


    qin500 = {}

    //发送验证码
    function sendcode(e) {
        if (qin500.start == undefined) {
            qin500.start = Date.now();
            xhr({'type': 'sendCode'})
            let i = 10;

            let c = setInterval(() => {

                i--;
                e.innerText = `请等待 ${i} 秒`;
                if (i <= 0) {
                    clearInterval(c)
                    e.innerText = "发送验证码"
                    qin500.start = undefined
                }
            }, 1000)
        } else {
            createNotification('error', "验证码,发送过于频繁,请等待")

        }
    }


    function submitForm() {
        // TODO: 处理表单提交逻辑
    }

    function closePlane() {
        document.querySelector('#login-overlay').style.display = "none"
    }

    function xhr(data, result, type = "POST", url = "admin/door.php") {
        let xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let text = JSON.parse(xhr.responseText);
                if (text.code == 100) {
                    //如果没有登录,就弹出登录框

                    togglePlane('login')
                }

                if (text.code == 112 || text.code == 113 || text.code == 100) {
                    createNotification('info', text.msg)
                }
                if (text.code == 117 || text.code == 104 || text.code == 119) {
                    createNotification('error', text.msg)
                }
                if (text.code == 108 || text.code == 114 || text.code == 116 || text.code == 103) {
                    createNotification('success', text.msg)
                }

                //如果注册成功
                if (text.code == 114) {
                    //清理注册信息
                    togglePlane()
                }
                //如果登录成功
                if (text.code == 116) {
                    //清理注册信息
                    togglePlane()
                }


                if (typeof result == "function") {
                    result(text);
                }

            }
        }
        let queryString = Object.keys(data).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join('&');
        xhr.open(type, location.href.substring(0, location.href.lastIndexOf("/") + 1) + url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(queryString);
    }


    function togglePlane(type = "home") {
        let t = document.querySelector('#login-overlay');
        var loginForm = document.querySelector("#login-overlay .login-form");
        var registerForm = document.querySelector("#register-form");
        if (type == "home") {
            t.style.display = "none"
            loginForm.style.display = "none"
            registerForm.style.display = "none"
        } else if (type == "login") {
            t.style.display = "flex"
            loginForm.style.display = "flex"
            registerForm.style.display = "none"
        } else if (type == "register") {
            t.style.display = "flex"
            loginForm.style.display = "none"
            registerForm.style.display = "flex"
        }
    }

    function createNotification(type, message, duration = 5000) {
        const notificationContainer = document.getElementById("notification-container");
        const notification = document.createElement("div");
        const notificationIcon = document.createElement("span");
        const notificationMessage = document.createTextNode(message);

        // 根据不同的类型设置图标
        switch (type) {
            case 'success':
                notificationIcon.innerHTML = '&#10004;'; // 成功符号
                break;
            case 'info':
                notificationIcon.innerHTML = '&#8505;'; // 信息符号
                break;
            case 'error':
                notificationIcon.innerHTML = '&#10060;'; // 错误符号
                break;
            default:
                break;
        }

        notification.classList.add("notification", type);
        notificationIcon.classList.add("notification-icon");

        notification.appendChild(notificationIcon);
        notification.appendChild(notificationMessage);
        notificationContainer.appendChild(notification);

        // 显示弹出提示浮动框
        setTimeout(() => {
            notification.classList.add("show");
        }, 10);

        // 在指定的持续时间后自动关闭
        setTimeout(() => {
            notification.classList.remove("show");
            setTimeout(() => {
                notificationContainer.removeChild(notification);
            }, 300);
        }, duration);
    }
</script>
</body>
</html>
