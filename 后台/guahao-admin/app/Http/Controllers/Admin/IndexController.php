<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    //首页
    public function index()
    {
        date_default_timezone_set('Asia/Shanghai');//设置中国上海时区，要不获取时间有时差
        $day = date('Y-m-d');
        return view('admin.index',compact('day'));
    }

    //登录页
    public function login()
    {
        return view('admin.login');
    }

    //登录方法
    public function vlogin(Request $request)
    {
        $request->validate([
            'username'=>'bail|required',
            'password'=>'required',
        ],[
            'username.required'=>'账号不能为空',
            'password.required'=>'密码不能为空',
        ]);
        if(auth()->attempt($request->only(['username','password','role']))){
            return redirect()->route('admin.index')->with('msg','登录成功');
        }
        return redirect()->back()->withErrors(['errors'=>'登录不合法']);
    }

    //修改密码
    public function pass()
    {
        return view('admin.pass');
    }

    //登录方法
    public function vpass(Request $request)
    {
        $request->validate([
            'oldpass'=>'bail|required',
            'newpass'=>'required|confirmed',
        ],[
            'oldpass.required'=>'原密码不能为空',
            'newpass.required'=>'新密码不能为空',
            'newpass.confirmed'=>'新密码与确认密码不一致！',
        ]);
        $oldpass = $request->get('oldpass');
        $user = auth()->user();
        if(Hash::check($oldpass,$user->password)){
            $user->password = bcrypt($request->get('newpass'));
            $user->save();
            return redirect()->route('admin.index')->with('msg','修改成功');
        }
        return redirect()->back()->withErrors(['errors'=>'原密码输入不正确']);
    }

    //个人信息
    public function person()
    {
        $data = Doctor::query()->where('code','=',auth()->user()->username)->first();
        return view('admin.person',compact('data'));
    }

    //退出登录
    public function logout()
    {
        session()->flush();
        return redirect(route('admin.login'));
    }
}
