<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        if (auth()->check()) {
            return redirect()->route('Admin::index');
        }
        if($request->method() == "POST"){
            $user=MyUser::where(['username'=>$request->username])->first();
            $remember=$request->remember ? true : false;
            //如果没有查找到该用户
            if(empty($user)){
                return ['code'=>0,'msg'=>'账号不存在,请重新输入账号!'];
            }else{
                $check=Hash::check($request->password,$user->password);
                //如果密码正确
                if($check){
                        //执行登录操作
                        auth()->loginUsingId($user->id,$remember);
                        setcookie('qin500',"qin500" . base64_encode(sha1(uniqid(microtime(true)))),0,'/','.qin500.com');//过期时间设置为0,即会话过期
                        return ['code' => 1, 'msg' => "登录成功"];
                }else{
                    return ['code' => 0, 'msg' => "登录失败,密码错误"];
                }
            }
        }

        return view('admin.login');
    }


//    退出系统
    public function quit(){
        setcookie('qin500',null,time()-1,'/','.qin500.com');//过期时间设置为0,即会话过期
        auth()->logout();
        return redirect(route('Admin::login'));

    }


    //用于检测是否登录
    public function qin500_authorized(Request $request)
    {
        if (($request->method() == "POST") && $request->headers->get("QIN500-AUTHORIZED") && $request->headers->get("QIN500-AUTHORIZED") === "qin500") {
            if (auth()->check()) {
                setcookie('qin500',"qin500" .base64_encode(sha1(uniqid(microtime(true)))),0,'/','.qin500.com');//过期时间设置为0,即会话过期
                return response()->json(['code' => 9001]);//代表已经登录
            } else {
                return response()->json(['code' => 9000]);//代表没有登录
            }
        }
    }

}
