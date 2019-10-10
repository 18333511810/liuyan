<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
class MemberController extends Controller
{
    //显示登录的表单
    public function login(){
    	return view('home.member.login');
    }
    //完成登录验证的
    public function login_check(Request $request){
       $rules = [
       		'username'=>'required',
       		'password'=>'required|size:6'
       ];
       $msg = [
       		'username.required'=>'用户名不能为空',
       		'password.required'=>'密码不能为空',
       		'password.size'=>'密码长度必须是6位'
       ];
       $validator = Validator::make($request->all(),$rules,$msg);
       if($validator->passes()){
       		$res = Auth::guard('home')->attempt($request->only(['username','password']));
       		if($res){
       			return redirect('/');
       		}else {
       			return back()->withErrors(['msg'=>'用户名或密码输入错误']);
       		}
       }else {
       		return back()->withErrors($validator)->withInput();
       }
    }
}
