<?php
include("./src/PHPMailer.php");
include("./src/SMTP.php");
include("./src/phpmailer.lang-zh_cn.php");
include("./getUA.php");

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
$mail->setFrom('qin500cn@foxmail.com', '小白', false);
$mail->addAddress('qin500cn@qq.com', 'test');
$subject = "你有新的邮件 {$_SERVER['REMOTE_ADDR']}";
// 设置邮件主题和正文
$mail->Subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
$data = (new ClientDeviceInfo())->getAll();
$template = file_get_contents('template.html');
date_default_timezone_set("Asia/Shanghai");
$template = str_replace('{{ip}}', $_SERVER['REMOTE_ADDR'], $template);
$template = str_replace('{{time}}', date("Y-m-d H:i:s"), $template);
$template = str_replace('{{wh}}', $_POST['width'] . '*' . $_POST['height'], $template);
$template = str_replace('{{pixelRatio}}', $_POST['pixelRatio'], $template);
$template = str_replace('{{ua}}', $_SERVER['HTTP_USER_AGENT'], $template);
$template = str_replace('{{count}}', $_POST['count'], $template);
$template = str_replace('{{referrer}}', $_POST['referrer'], $template);
$template = str_replace('{{succ}}', $_POST['succ'], $template);
$template = str_replace('{{device_type}}', $data['device_type'], $template);


$mail->msgHTML($template);
$mail->CharSet = 'UTF-8';


// 发送邮件并在后台异步执行
$send = $mail->send();
$mail->smtpClose();

echo "test";

