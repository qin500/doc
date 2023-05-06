<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //后台必须登录
        if (!auth()->check()){
            //如果设置了请求头
//            if($request->method() == "POST"){
//                return response()->json(['code' => 9000]);
//            }
            return redirect(route('Admin::login'));
        }
        return $next($request);
    }
}
