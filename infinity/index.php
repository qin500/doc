<?php
date_default_timezone_set('Asia/Shanghai');
$time = date('Y-m-d H:i:s') ." " . $_SERVER['SERVER_ADDR'];

// 打开文件，如果文件不存在则创建
$filename = 'client-info.txt';
$file = fopen($filename, 'a+');

// 写入信息字符串到文件
fwrite($file, $time . "\n");

// 关闭文件
fclose($file);