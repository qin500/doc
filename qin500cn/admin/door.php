<?php
// 显示所有错误信息
use zd\DB;

error_reporting(E_ALL);
ini_set('display_errors', 'on');


session_start();
include("../db.php");

$db = new DB();

switch ($_POST['type']) {
    case 'isLogin':
        if (isset($_SESSION['user_id'])) {


        }

        break;
}


function pt($code, $msg)
{
    header('Content-Type: application/json');
    echo json_encode(['code' => $code, 'msg' => $msg]);
    exit();
}

exit();
//注册与登录
if (isset($_POST['register'])) {

    $email = trim($_POST['email']);
    $regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (preg_match($regex, $email)) {
        //判断邮箱是否被注册
        $result = $db->select('user', "email={$email}");
        print_r($result);
    } else {
        pt(1, '请输入有效的邮箱名');
    }


} else if (isset($_POST['login'])) {


}
