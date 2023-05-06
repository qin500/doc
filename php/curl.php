<?php


$curl = curl_init();

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
$time = time();
//设备id
$device_id = "rk_" . substr(bin2hex(random_bytes(16)), 0, 32);
//邮箱,%40是转换成@符号
$email = uniqid("qq") . "%40qc.com";
//邀请码
$invite_code = "";
//密码
$passwd = md5("123456");

$url = "https://wa01.googla.org/account/register?platform=2&api_version=14&app_version=1.44&lang=zh&_key=&market_id=1000&pkg=com.bjchuhai&" .
    "device_id=$device_id" .
    "&model=$model" .
    "&sys_version=9" .
    "&ts=$time&sub_pkg=com.bjchuhai&version_code=44";

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HEADER => 1,//这行必须加上,否则不会返回响应头
    CURLOPT_POSTFIELDS => "passwd=$passwd&invite_code=$invite_code&email=$email",
    CURLOPT_HTTPHEADER => array(
        'User-Agent: okhttp/3.5.0',
        'Host: wa01.googla.org',
        'Content-Type: application/x-www-form-urlencoded',
        'Accept: */*',
        'Connection: keep-alive'
    ),
));


// 执行curl请求
$response = curl_exec($curl);

// 获取响应头的大小
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

// 获取响应头
$header = substr($response, 0, $header_size);
echo $header . "<br>";
//$headerArray = http_parse_headers($header);//将响应头处理成数组

$headerArray = [];
foreach (explode("\r\n", $header) as $i => $line) {
    if ($i === 0) {
        $headerArray['http_code'] = $line;
    } else {
        list ($key, $value) = explode(': ', $line);
        $headerArray[$key] = $value;
    }
}


echo substr($response, $header_size);
// 关闭curl会话
curl_close($curl);
echo "<br>";
// 输出响应头
print_r($headerArray);

echo $response;


