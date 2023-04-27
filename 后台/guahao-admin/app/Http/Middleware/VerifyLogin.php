<?php

namespace App\Http\Middleware;

use Closure;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检查用户登录
        if(!auth()->check()){
            //清空缓存
            session()->flush();
            //跳转登录页面
            return redirect()->route('admin.login')->withErrors(['errors'=>'请先登录!']);
        }
        return $next($request);
    }
}
