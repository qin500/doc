<?php
if (isset($_POST['code']) && isset($_POST['type'])) {
    $code = $_POST['code'];
    $type = $_POST['type'];

    if ($code == "") {
        echo "邀请码不能为空!!!";
        exit();
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
        case  "baijing":
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
            $result = send($type, $data);
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
        case "anyi":
            $data['url'] = "https://z1.goofficez.com/v1/user/register?platform=2&api_version=14&app_version=1.1&lang=zh&_key=&market_id=1000&pkg=com.giraffe&device_id={$device_id}&model={$model}&sys_version=7.1.2&ts={$time}&sub_pkg=com.giraffe&version_code=2";
            $data['header'] = [
                'Host: z1.goofficez.com',
                'Connection: Keep-Alive',
                'User-Agent: okhttp/3.5.0',
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: */*'];
            $data['fields'] = "passwd=e10adc3949ba59abbe56e057f20f883e&email={$email}&invite_code={$invite_code}";
            $result = send($type, $data);
            if (($result['httpcode'] == 200) && ((strlen($result['body']) == 400) || (strlen($result['body']) == 416))) {
                $lastPrint = ["code" => 1, "email" => $fotemail];
            } else {
                $lastPrint = ["code" => 0, "msg" => strlen($result['body'])];
            }

            break;
    }

    echo json_encode($lastPrint);
    exit();
}


//返回响应数据和响应头
function send($type = "baijing", $data)
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
            $arr=explode(': ', $line);
            if(count($arr) >=2){
                list ($key, $value) = $arr;
                $headerArray[$key] = $value;
            }


        }
    }
    return ["body" => substr($response, $headerSize), "header" => $headerArray, 'httpcode' => $httpCode];
}


?>