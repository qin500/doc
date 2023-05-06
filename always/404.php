<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404页面</title>
    <style>
        h1 {
            font-size: 2em;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>404页面没有找到</h1>


<?php
$current_url = ($_SERVER['HTTPS'] ? "https://" : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo "<a target='_blank' href='{$current_url}'>{$current_url}</a>";
?>
</body>
</html>