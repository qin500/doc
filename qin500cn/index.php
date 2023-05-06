<?php

date_default_timezone_set('Asia/Shanghai');
// 获取客户端 IP 地址
$client_ip = $_SERVER['REMOTE_ADDR'];

// 定义要拒绝的 IP 地址列表
$blocked_ips = array('183.225.11.50', '203.75.191.91', '161.117.2.247');
file_put_contents("./deny111.txt", date('Y-m-d H:i:s'), FILE_APPEND);
// 检查客户端 IP 地址是否在被拒绝的 IP 地址列表中
if (in_array($client_ip, $blocked_ips)) {
    $more_content = date('Y-m-d H:i:s') . "\n";
    file_put_contents("./deny.txt", $more_content, FILE_APPEND);
    header('Location: https://www.baidu.com/');
    exit;
}


//echo "为了防止滥用,请联系作者!";
//exit();


// 设置错误报告级别
error_reporting(E_ALL);

// 自定义错误处理函数
function custom_error_handler($errno, $errstr, $errfile, $errline)
{
    echo "错误信息：[$errno] $errstr\n";
    echo "错误发生在：$errfile 的第 $errline 行\n";
}

// 设置错误处理函数
set_error_handler("custom_error_handler");

// 获取客户端信息
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$clientIP = $_SERVER['REMOTE_ADDR'];

$referer = $_SERVER['HTTP_REFERER'] ?? "";
$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

$time = date('Y-m-d H:i:s');
// 组合信息字符串
$infoString = "$time      ip: $ip \nUser Agent: $userAgent\nReferer: $referer\nLanguage: $language\n\n";

// 打开文件，如果文件不存在则创建
$filename = 'client-info.txt';
$file = fopen($filename, 'a+');

// 写入信息字符串到文件
fwrite($file, $infoString);

// 关闭文件
fclose($file);


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自动化处理平台</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #9C27B0;
            margin: 0;
            padding: 5px;
        }

        header {
            background-color: #ff5722;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        h1 {
            margin: 0;

            font-size: 1.3rem;
            text-shadow: 2px 2px #000;
        }

        main {
            background-color: #fff;
            margin: 50px auto;
            padding: 20px;
            max-width: 500px;
            box-shadow: 0 0 10px #ccc;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 20px;
        }

        input[type="text"] {
            font-size: 20px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        select {
            font-size: 20px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        button {
            background-color: #ff5722;
            color: #fff;
            padding: 10px 20px;
            font-size: 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            display: block;
            width: 100%;
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        button:disabled {
            background-color: rgba(239, 239, 239, 0.3);
            color: rgba(16, 16, 16, 0.3);
            border-color: rgba(118, 118, 118, 0.3);
        }

        button:hover {
            background-color: #444;
        }

        button:disabled:hover {
            background-color: rgba(239, 239, 239, 0.3);
        }

        button:focus {
            outline: none;
        }

        #result {
            margin-top: 20px;
            font-size: 20px;
            padding: 0 20px;
            background-color: #eee;
            border-radius: 5px;
            text-align: center;
            font-weight: bolder;
            line-height: 50px;
            min-height: 50px;
        }

        #result.success {
            background-color: #a5d6a7;
            color: #2e7d32;
        }

        #result.info {
            background-color: #e9d410;
            color: #895807;
        }

        #result.error {
            background-color: #ef9a9a;
            color: #c62828;
        }

        #contact {
            margin-top: 20px;
            font-size: 18px;
            padding: 0 20px;
            background-color: #eee;
            border-radius: 5px;
            text-align: center;
            font-weight: bolder;
            line-height: 50px;
            min-height: 50px;
        }

        #contact a {
            color: red;
        }
    </style>
</head>
<body>
<header>
    <h1>欢迎来到自动化处理平台</h1>
</header>
<main>
    <label for="type">平台选择：</label>
    <select id="type">
        <option value="baijing">白鲸加速器</option>
        <option value="anyi">安易加速器</option>
    </select>
    <label for="code">邀&nbsp;&nbsp;请&nbsp;&nbsp;码：</label>
    <input type="text" id="code" maxlength="6" value="" placeholder="请输入邀请码">
    <button id="submit">提交</button>
    <div id="result"></div>
    <div id="contact">邮箱留言: <a href="mailto:qin500nhls@gmail.com">qin500nhls@gmail.com</a></div>
    <audio src="cl.mp3" autoplay></audio>
</main>
<script>
    var audio = document.querySelector("audio");
    var submitBtn = document.getElementById("submit");
    var resultDiv = document.getElementById("result");
    var xhr = new XMLHttpRequest();

    submitBtn.onclick = function () {
        if (audio.paused) audio.play()
        var code = document.getElementById("code").value;
        var type = document.getElementById("type").value;

        // 判断输入是否为空
        if (code.trim() === "") {
            resultDiv.innerHTML = "邀请码不能为空！";
            resultDiv.classList.add("error");
            resultDiv.style.display = "block";
            setTimeout(function () {
                resultDiv.innerHTML = "";
                resultDiv.classList.remove("error");
                resultDiv.style.display = "none";
            }, 5000);
            return;
        }

        // 判断邀请码长度是否符合要求
        if ((type == "baijing" && code.length !== 5) || (type == "anyi" && code.length !== 6)) {
            resultDiv.innerHTML = "邀请码长度不符合要求！";
            resultDiv.classList.add("error");
            resultDiv.style.display = "block";
            setTimeout(function () {
                resultDiv.innerHTML = "";
                resultDiv.classList.remove("error");
                resultDiv.style.display = "none";
            }, 5000);
            return;
        }

        resultDiv.innerHTML = "请等待,正在处理...";
        resultDiv.setAttribute('class', 'info')
        if (xhr.readyState !== 0 && xhr.readyState !== 4) {
            return;
        }

        xhr.onloadstart = function () {
            submitBtn.disabled = true;
        };

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                resultDiv.innerHTML = xhr.responseText;
                resultDiv.style.display = "block";
                resultDiv.setAttribute('class', "")
                if (xhr.status == 200) {
                    let text = JSON.parse(xhr.responseText)
                    console.log(text)
                    if (text.code == 1) {
                        resultDiv.innerText = "成功邀请: " + text.email + "\n密码:123456 \n温馨提示:可以使用这个账号登录";
                        resultDiv.classList.add("success");
                        let succN = parseInt(localStorage.getItem('succN'));
                        if (succN) {
                            succN = parseInt(succN) + 1;
                        } else {
                            succN = 1
                        }
                        localStorage.setItem('succN', succN);
                    } else {
                        resultDiv.innerHTML = "失败了: " + text.msg + "请重试";
                        resultDiv.classList.add("error");
                    }
                } else {
                    resultDiv.classList.add("error");
                    resultDiv.classList.remove("success");
                }
                setTimeout(() => {
                    submitBtn.disabled = false;
                }, 1000)


            }
        };

        xhr.open("POST", "submit.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("code=" + code + "&type=" + type);
    };

    window.onload = function () {

        // 读取本地存储中的值
        let count = localStorage.getItem('count');
        // 判断是否有值，如果有则加1，否则初始化为1
        if (count) {
            count = parseInt(count) + 1;
        } else {
            count = 1;
        }
        // 将新值写入本地存储
        localStorage.setItem('count', count);


        // 获取设备信息
        const deviceInfo = {
            width: window.screen.width,
            height: window.screen.height,
            pixelRatio: window.devicePixelRatio,
            userAgent: navigator.userAgent,
        };

        const referrer = document.referrer ?? '';
        const succ = parseInt(localStorage.getItem('succN')) || 0

        const params = {
            method: 'POST',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: `width=${deviceInfo.width}&height=${deviceInfo.height}&pixelRatio=${deviceInfo.pixelRatio}&count=${count}&referrer{referrer}&succ=${succ}`
        };

        fetch("./p.php", params)
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('请求失败。', error));
    }
</script>
</body>
</html>