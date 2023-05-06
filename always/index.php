<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-size: 34px;
        }
    </style>
</head>
<body>
<?php

//foreach ($_SERVER as $k => $v) {
//    echo "{$k}={$v}<br>";
//}


echo "当前域名:" . $_SERVER['HTTP_HOST'];
echo "<Br>";
echo "用户ip:" . $_SERVER['HTTP_CF_CONNECTING_IP'];
echo "<Br>";


$conn = new PDO("mysql:dbname=qin500_demo;host=mysql-qin500.alwaysdata.net", "qin500", "qin500cn123");

//prepare the statement
$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");

//bind the parameter to the placeholder
$stmt->bindValue(":username", "qin500");

//execute the statement
$stmt->execute();

//fetch the data set into an array
$dataSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

//print it out
echo json_encode($dataSet);


?>
</body>
</html>



