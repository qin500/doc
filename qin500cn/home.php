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
            /*display: none;*/
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
    </style>
</head>
<body>
<div class="panel">
    <div class="form">
        <h2>自动化处理平台</h2>
        <select>
            <option value="bj">白鲸加速器</option>
            <option value="ay">安易加速器</option>
        </select>
        <input type="text" placeholder="邀请码">
        <button id="submit-btn" onclick="showLogin()">提交</button>
    </div>
</div>

<div class="overlay" id="login-overlay">

    <div class="login-form">
        <a class="close" href="#">&times;</a>

        <h2>登录</h2>
        <input type="email" placeholder="邮箱">
        <input type="password" placeholder="密码">
        <button onclick="login()">登录</button>
        <a href="#" onclick="toggleLogin()">还没有账号？点此注册</a>
    </div>
    <div class="login-form" id="register-form" style="display:none">
        <h2>注册</h2>
        <input type="email" placeholder="邮箱">
        <input type="password" placeholder="密码">
        <input type="password" placeholder="确认密码">
        <button onclick="register()">注册</button>
        <a href="#" onclick="toggleLogin()">已有账号？点此登录</a>
    </div>
</div>

<script>
    var loginForm = document.querySelector("#login-overlay .login-form");
    var registerForm = document.querySelector("#register-form");

    function showLogin() {
        loggedIn()


        return;


        // if (1) {
        //     // 如果已经登录，则直接提交表单
        //     submitForm();
        // } else {
        //     // 如果未登录，则显示登录层
        //     loginForm.style.display = "flex";
        //     document.getElementById("login-overlay").style.display = "flex";
        // }
    }

    function hideLogin() {
        document.getElementById("login-overlay").style.display = "none";
    }

    function toggleLogin() {
        loginForm.style.display = loginForm.style.display === "none" ? "flex" : "none";
        registerForm.style.display = registerForm.style.display === "none" ? "flex" : "none";
    }

    function login() {
        // TODO: 处理登录逻辑
        submitForm();
    }

    function register() {
        // TODO: 处理注册逻辑
        submitForm();
    }

    function loggedIn() {
        // TODO: 判断当前用户是否已登录
        xhr("admin/door.php", {'type': "isLogin"}, function (e) {
            console.log(e)
        })

        return false;
    }

    function submitForm() {
        // TODO: 处理表单提交逻辑
    }


    function xhr(url, data, result, type = "POST") {
        let xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let text = JSON.parse(xhr.responseText)
                result(text);
            }
        }
        let queryString = Object.keys(data).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join('&');
        xhr.open(type, location.origin + "/" + url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(queryString);
    }


</script>
</body>
</html>