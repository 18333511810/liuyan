<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Auth;
class ManagerController extends Controller
{
    //显示登录的表单
    public function login(){

    	return view('admin.manager.login');
    }

    //完成登录验证
    public function loginok(Request $request){

    	//实现数据验证；
    	$rules = [
    		'username'=>'required|min:2|max:16|regex:/^[a-zA-Z1-9\x{2e80}-\x{9FFF}]*$/u',
    		'password'=>'required|size:6',
    		'captcha'=>'required|size:4|captcha'
    	];
    	$msg = [
    		'username.required'=>'管理员不能为空',
    		'username.min'=>'管理员名称要大于2个字符',
    		'username.regex'=>'管理员名称不符合规则',
    		'password.required'=>'密码不能为空',
    		'password.size'=>'密码长度必须是6位',
    		'captcha.required'=>'验证码不能为空',
    		'captcha.size'=>'验证码必须是4位',
    		'captcha.captcha'=>'验证码不正确'
    	];
    	$validator  = Validator::make($request->all(),$rules,$msg);


    	if($validator->passes()){

    		//通过验证，要验证输入的用户名和密码是否正确
    		//Auth::guard('新建的验证规则名称')
    		$res = Auth::guard('admin')->attempt($request->only(['username','password']),$request->has('online'));

    		//登录成功后，会自动把用户信息存储到session里面，
    		if($res){

    			return redirect('admin/index');
    		}else {
    			return back()->withErrors(['msg'=>'用户名或密码错误']);
    		}
    	}else {
    		//未通过验证，
    		return back()->withErrors($validator)->withInput();
    	}
    }

    //退出的操作
    public function logout(){
    	Auth::guard('admin')->logout();
    	return redirect('admin/login');
    }
}
