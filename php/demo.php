<?php


// 设置错误报告级别
error_reporting(E_ALL);

// 自定义错误处理函数
function custom_error_handler($errno, $errstr, $errfile, $errline)
{
    echo "邮件发送失败：[$errno] $errstr\n";
    echo "错误发生在：$errfile 的第 $errline 行\n";
}

// 设置错误处理函数
set_error_handler("custom_error_handler");

include("./src/PHPMailer.php");
include("./src/SMTP.php");
include("./src/phpmailer.lang-zh_cn.php");

use PHPMailer\PHPMailer\PHPMailer;

// 创建一个新的PHPMailer对象
$mail = new PHPMailer;

// 设置SMTP服务器和端口
$mail->isSMTP();
$mail->Host = 'smtp.qq.com';
$mail->Port = 587;

// 设置SMTP身份验证信息（如果需要）
$mail->SMTPAuth = true;
$mail->Username = 'qin500cn@foxmail.com';
$mail->Password = 'clnksmwzrzblegdd';

// 设置发件人和收件人
$mail->setFrom('qin500cn@foxmail.com', '小白');
$mail->addAddress('qin500cn@qq.com', 'test');

// 设置邮件主题和正文
$mail->Subject = '有新的访客';
$mail->Body = '这是一封测试邮件';

// 发送邮件并在后台异步执行
$send = $mail->send();
$mail->smtpClose();


echo "shuc";