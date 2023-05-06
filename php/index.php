<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>测试</title>
</head>
<body>

<?php
if ($_GET['name'] == 1) {
    $filename = 'client-info.txt';
    echo nl2br(file_get_contents($filename));
    exit();
}

// 获取客户端信息
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$clientIP = $_SERVER['REMOTE_ADDR'];
$referer = $_SERVER['HTTP_REFERER'];
$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
date_default_timezone_set('Asia/Shanghai');
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

echo "客户端信息已记录";


?>
</body>
</html>