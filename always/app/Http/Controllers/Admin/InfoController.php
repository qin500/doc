<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\Sto;
use App\Models\MyUser;
use App\Models\SysOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\DocBlock\Tags\Example;
use Qiniu\Auth;
use Ramsey\Collection\Tool\ValueToStringTrait;
use Illuminate\Support\Facades\Hash;

class InfoController extends Controller
{

    //文件上传操作
//    public function upload(Request $request){
//        $file=$request->file('file');
//        if($file->isValid()){
//            //获取扩展名
////            $filename = $file->getClientOriginalName();//原文件名
////            $type = $file->getClientMimeType();//文件类型
//            $path = $file->getRealPath();//绝对路径
//            $ext = $file->getClientOriginalExtension();//文件扩展名
//            $filenames=str_pad(auth()->id(),5,"0",STR_PAD_LEFT) . DIRECTORY_SEPARATOR . date('YmdHis',time()) . "_". sha1(time() . uniqid()) . '.' . $ext;//保存的文件名称
//            $res = Storage::put($filenames, file_get_contents($path));
//            if($res){
//                $save_filenames='/upload/' . $filenames;
//                return  ['code'=>200,'url'=>$save_filenames];
//            }
//        }
//        return  ['code'=>0];
//    }
    public function uploadToken(Request $request) {
        if(\auth()->check() && isset($request->type) && $request->type == "qiniu"){
            $token=Sto::CreateUPToken(\auth()->id(),1800);//30分后失效
            return ['code'=>'success','msg'=>"","verify"=>['token'=>$token,'prefix'=>env('QINNIU_PREFIX') . \auth()->id() . "/"]];
        }else{
            return response()->json(['code'=>'error','msg'=>'未登录']);
        }
    }

    //我的信息
    public function myinfo(Request $request)
    {
        $user=MyUser::find(auth()->id());
        if ($request->getMethod() == "POST") {
            $data=$request->except("_token");
            $user->other=json_encode($data);
            $user->save();
            return redirect(route('Admin::info.myinfo'))->with(['returnresult'=>['msg'=>"信息更新",'status'=>true]]);
        }
        $other=json_decode($user->other,true);

        return view('admin.info.myinfo', compact('other'));
    }

    //系统设置
    public function setting(Request $request)
    {
        if($request->method() == "POST"){

            $data=$request->except(["_token"]);
            foreach ($data as $k=>$v){
                SysOption::updateOrInsert(['key'=>$k], ['val'=>$v]);
            }
            return  redirect()->back();
        }
        $all_set=SysOption::select(["key","val"])->get()->toArray();
        $peizi=[];
        if(count($all_set)){
            $peizi=array_reduce($all_set,function ($cal,$item){
                $tmp[$item['key']]= $item['val'];
                if($cal == null){
                    return $tmp;
                }
                return array_merge($cal ,$tmp) ?? $tmp;
            });
        }


        return view('admin.info.setting',compact("peizi"));
    }

    public function passwordManage(Request $request){
        if($request->isMethod('post')){
            $this->validate($request,
                ['oldpassword'=>'required',
                    'password'=>'required|between:6,18',
                    'password_confirmation'=>['required','same:password']],
                [
                    'oldpassword.required'=>'旧密码不能为空',
                    'password.required'=>'新密码不能为空',
                    'password.between'=>'密码有效长度为6-18位',
                    'password_confirmation.same'=>'两次输入密码不匹配.',
                ],
                [
                    'password_confirmation'=>'确认密码'
                ]);
            $oldpw=auth()->user()->password;
            $result= Hash::check($request->oldpassword,$oldpw);//验证旧密码
            if($result){
                $myuserModel=MyUser::find(auth()->id());
                $myuserModel->password=bcrypt($request->password);
                return redirect()->back()->with(["returnresult"=>['status'=>$myuserModel->save(),'msg'=>'密码修改成功']]);
            }else{
                return redirect()->back()->withErrors('当前密码验证失败,密码修改失败');
            }
        }
        return view('admin.info.passwordmanage');
    }
}
