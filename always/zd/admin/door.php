<?php
// 显示所有错误信息
use zd\DB;

error_reporting(E_ALL);
ini_set('display_errors', 'on');
date_default_timezone_set('Asia/Shanghai');
session_start();
include("../DB.php");
$db = new DB();
$now = date('Y-m-d H:i:s');
function isLogin()
{
    global $db;
    var_dump(isset($_SESSION['user_id']));
    //判断当前是否登录
    if (isset($_SESSION['user_id'])) {
        //        $result = $db->findID('users', $_SESSION['user_id']);
        //
        //
        //
        //
        //        if ($result['is_enabled'] == 0) {
        //            pt(105);
        //        } else if (($result['vip'] == 0) && ($result['points'] <= 0)) {
        //            //如果当前用户,不是vip,积分余额也不足
        //            pt(109);
        //        }
    } else {
        pt("100");
    }
    return false;
}

$type = trim($_POST['type']);
if ($type == "work") {
    //如何可行,我们就开始刷

    if (isset($_SESSION['user_id'])) {
        //说明已经登录了
        $res = $db->findID('users', $_SESSION['user_id']);
        if (count($res) > 0) {
            //如果不是vip,并且点数不够
            if ($res['vip'] == 0 && $res['points'] <= 0) {
                pt(119);
            }


            if (isset($_POST['yqm']) && isset($_POST['manner'])) {
                $code = $_POST['yqm'];
                $type = $_POST['manner'];

                if ($code == "") {
                    pt(120);
                }

                $phone_name = ["oppo-pedm00", "oppo-peem00", "oppo-peam00", "oppo-x907", "oppo-x909t",
                    "vivo-v2048a", "vivo-v2072a", "vivo-v2080a", "vivo-v2031ea", "vivo-v2055a",
                    "huawei-tet-an00", "huawei-ana-al00", "huawei-ang-an00", "huawei-brq-an00", "huawei-jsc-an00",
                    "xiaomi-mi 10s", "xiaomi-redmi k40 pro+", "xiaomi-mi 11", "xiaomi-mi 6", "xiaomi-redmi note 7",
                    "meizu-meizu 18", "meizu-meizu 18 pro", "meizu-mx2", "meizu-m355", "meizu-16th plus",
                    "samsung-sm-g9910", "samsung-sm-g9960", "samsung-sm-w2021", "samsung-sm-f7070", "samsung-sm-c7000",
                    "oneplus-le2120", "oneplus-le2110", "oneplus-kb2000", "oneplus-hd1910", "oneplus-oneplus a3010",
                    "sony-xq-as72", "sony-f8132", "sony-f5321", "sony-i4293", "sony-g8231",
                    "google-pixel", "google-pixel xl", "google-pixel 2", "google-pixel 2 xl", "google-pixel 3"];

//当前手机
                $model = time() . "C/" . $phone_name[array_rand($phone_name)];
//时间戳
                date_default_timezone_set('Asia/Shanghai');
                $time = time();
//设备id
                $device_id = "rk_" . substr(bin2hex(random_bytes(16)), 0, 32);
//邮箱,%40是转换成@符号
                $email = uniqid("qq") . "%40qc.com";
                $fotemail = str_replace("%40", "@", $email);//现在的qq
//邀请码
                $invite_code = strtoupper($code);
//密码
                $passwd = md5("123456");


                $data = [];
                $lastPrint = [];
                switch ($type) {
                    case  "bj":
                        $data['url'] = "https://wa01.googla.org/account/register?platform=2&api_version=14&app_version=1.44&lang=zh&_key=&market_id=1000&pkg=com.bjchuhai&" .
                            "device_id=$device_id" .
                            "&model=$model" .
                            "&sys_version=9" .
                            "&ts=$time&sub_pkg=com.bjchuhai&version_code=44";
                        $data['header'] = [
                            'User-Agent: okhttp/3.5.0',
                            'Host: wa01.googla.org',
                            'Content-Type: application/x-www-form-urlencoded',
                            'Accept: */*',
                            'Connection: keep-alive'];
                        $data['fields'] = "passwd=$passwd&invite_code=$invite_code&email=$email";
                        $result = send($data, $type);
                        if ($result['httpcode'] == 200) {
                            if ($result['header']['Content-Length'] == "320" || $result['header']['Content-Length'] == "336") {
                                $lastPrint = ["code" => 1, "email" => $fotemail];
                            } else {
                                $lastPrint = ["code" => 0, "msg" => $result['httpcode']];
                            }
                        } else {
                            $lastPrint = ["code" => 0, "msg" => $result['httpcode'] . "错误"];
                        }
                        break;
                    case "ay":
                        $data['url'] = "https://z1.goofficez.com/v1/user/register?platform=2&api_version=14&app_version=1.1&lang=zh&_key=&market_id=1000&pkg=com.giraffe&device_id={$device_id}&model={$model}&sys_version=7.1.2&ts={$time}&sub_pkg=com.giraffe&version_code=2";
                        $data['header'] = [
                            'Host: z1.goofficez.com',
                            'Connection: Keep-Alive',
                            'User-Agent: okhttp/3.5.0',
                            'Content-Type: application/x-www-form-urlencoded',
                            'Accept: */*'];
                        $data['fields'] = "passwd=e10adc3949ba59abbe56e057f20f883e&email={$email}&invite_code={$invite_code}";
                        $result = send($data, $type);
                        if (($result['httpcode'] == 200) && ((strlen($result['body']) == 400) || (strlen($result['body']) == 416))) {
                            $lastPrint = ["code" => 1, "email" => $fotemail];
                        } else {
                            $lastPrint = ["code" => 0, "msg" => strlen($result['body'])];
                        }

                        break;
                }

                if ($lastPrint['code'] == 1) {
                    //积分减一
                    $db->update('users', ['points' => $res['points'] - 1], 'id="' . $res['id'] . '"');
                    //刷入记录
                    $db->insert('rg_list', ['uid' => $res['id'], 'email' => $lastPrint['email'], 'rtime' => $now, 'type' => $type,'ua'=>$_SERVER['HTTP_USER_AGENT'],'ip'=>$_SERVER['REMOTE_ADDR']]);


                    if($res['vip'] == 0){
                        //如果用户不是vip
                        $lastPrint['yue'] = $res['points'] - 1;
                    }
                    pt(103, $lastPrint, $lastPrint['email']);
                } else{

                    pt(104, $lastPrint, $lastPrint['msg']);
                }


            }


//返回响应数据和响应头


        }
    } else {
        pt(100);
    }


} else if ($type == "register") {
    if (!isset($_SESSION['emcode'])) {
        unset($_SESSION['emcode']);
        pt("106", $_SESSION);
    }
    //判断用户名,邮箱
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $emcode = $_POST['emcode'];
    //判断验证码是否正确
    if ($emcode == "" || $emcode != $_SESSION['emcode']) {
        pt("117", $_SESSION);
    }
    //查询用户名邮箱是否被注册过了
    $res = $db->select('users', "username='{$username}'");
    if (count($res) > 0) {
        pt("112", $res);
    }
    $res = $db->select('users', "email='{$email}'");
    if (count($res) > 0) {
        pt("113", $res);
    }
    $uid = $db->insert('users', ['username' => $username,
        'password' => md5($password),
        'email' => $email,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'last_login_ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'points' => 10,
        'registration_time' => $now,
        'last_login_time' => $now,
    ]);
    if (isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', '', time() - 3600, '/');
    }
    session_destroy();
    pt(114);
} else if ($type == "login") {
    $ac = $_POST['account'];
    $pw = $_POST['password'];
    $res = $db->select('users', "(username='{$ac}' or email = '{$ac}' ) and password='" . md5($pw) . "'");
    if (count($res)) {
        //账户禁用
        if ($res[0]['is_enabled'] == 0) {
            pt(105);
            //账户被禁用
        }
        $_SESSION['user_id'] = $res[0]['id'];
        pt(116);
        //登录成功
    }
    pt(118);
    //账户或密码错误
} else if ($type == "sendCode") {
    $num = rand(100000, 999999);
    if (isset($_SESSION['sendTime'])) {
        $surplus = time() - $_SESSION['sendTime'];
        if (!($surplus > 10)) {
            //不可用
            $second = 10 - $surplus;
            //剩余多少秒
            pt("111", [], $second);
        }
    }
    $_SESSION['sendTime'] = time();
    $_SESSION['emcode'] = $num;
    //这里发送验证码
    pt("108", ['num', $num]);
}


function send($data, $type = "bj")
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $data['url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => 1,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data['fields'],
        CURLOPT_HTTPHEADER => $data['header'],
    ));

    $response = curl_exec($curl);
    $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $header = substr($response, 0, $headerSize);

    $headerArray = [];
    foreach (explode("\r\n", $header) as $i => $line) {
        if ($i === 0) {
            $headerArray['http_code'] = $line;
        } else {
            $arr = explode(': ', $line);
            if (count($arr) >= 2) {
                list ($key, $value) = $arr;
                $headerArray[$key] = $value;
            }
        }
    }
    return ["body" => substr($response, $headerSize), "header" => $headerArray, 'httpcode' => $httpCode];
}

function pt($code, $data = [], $append = "")
{
    header('Content-Type: application/json');
    $str = [
        "100" => "没有登录",
        "101" => "已经登录",
        "102" => "积分不够",
        "103" => "成功邀请: " . $append . "\n密码:123456 \n温馨提示:可以使用这个账号登录",
        "104" => "失败了: 请重试",
        "105" => "账户已禁用,请联系管理员解封...",
        "106" => "请先发送验证码",
        "107" => "验证码发送频繁,失败",
        "108" => "验证码发送成功",
        "109" => "您的账户余额不足,请开通vip",
        "110" => "请先发送邮箱验证码",
        "111" => "发送太频繁,请等待{$append}秒后在试",
        "112" => "用户名已存在",
        "113" => "邮箱已存在",
        "114" => "注册成功",
        "115" => "已退出登录",
        "116" => "登录成功",
        "117" => "验证码不正确,请重新输入",
        "118" => "登录失败,账户或密码错误",
        "119" => "余额不足,请打赏五元.免费用户仅可使用十次.打赏五元永久使用",
        "120" => "邀请码不能为空!!!",
    ];
    echo json_encode(['code' => $code, 'data' => $data, 'msg' => $str[$code] ?? $append]);
    exit();
}
