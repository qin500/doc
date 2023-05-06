<?php

namespace App\Lib;
use Qiniu\Auth as QN_Auth;
use Qiniu\Config as QN_Config;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use Illuminate\Support\Facades\Redis;

class Sto
{
    //七牛云云存储
    public static function CreateUPToken($prefix="",$expires=3600,$policy=[]){
        $auth=new QN_Auth(env('QINIU_AK'),env('QINIU_SK'));
        $bucket=env("QINNIU_BUCKET");
        return $auth->uploadToken($bucket,env('QINNIU_PREFIX') .$prefix,$expires,array_merge($policy,['isPrefixalScope'=>1]));
//        return $auth->uploadToken($bucket,"qin500",$expires,array_merge($policy,['isPrefixalScope'=>1]));
    }

    public static function BaiduTS($urls){
        if(gettype($urls) == "array"){
            $urls=implode("\n", $urls);
        }
        $api = 'http://data.zz.baidu.com/urls?site=https://www.qin500.com&token=' . env('BAIDUTS');
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $urls,
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),

        );
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        return json_decode($result,true);
    }

    //收录查询
    public static function SLTotal(){
        if(Redis::exists('baidu_shoulu')){
//            return Redis::get('baidu_shoulu');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://www.baidu.com/s?wd=site:www.qin500.com',
            CURLOPT_URL => 'https://www.baidu.com/s?wd=site:www.csdn.net',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36 Edg/92.0.902.73',
                'Cookie: 11; BAIDUID=093AFB5A8EAC2B5CCBFF663162CEDDAE:FG=1; BIDUPSID=093AFB5A8EAC2B5C3DA485B9B053AA6F; H_PS_PSSID=34438_34145_34004_34073_34092_34106_26350_34390; PSINO=3; PSTM=1629459115; delPer=0; BDSVRTM=141; BD_CK_SAM=1'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        preg_match('/找到相关结果数约(.*?)个/',$response,$match);
        $num=0;
        if(count($match)){
            $num= $match[1];
        }
        Redis::setex("baidu_shoulu",24*60*60,$num);
        return  $num;

    }




    }
