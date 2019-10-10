<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class IndexController extends Controller
{
    public function index(){
    	//获取管理员的id
    	$id = Auth::guard('admin')->user()->id;
    	//使用DB类来完成链表查询；
    	$priv_ids = DB::table('manager as m')->join('role as r','m.role_id','=','r.id')->where('m.id',$id)->value('priv_ids');
    	//
    	if(empty($priv_ids)){
    		//（1）是超级管理员（2）没有分配角色的管理员
    		if($id==1){
    			//超级管理员
    			$privA =  DB::table('privilege')->where('level_name',0)->get();
	    		//取出顶级的子权限；
	    		$privB =  DB::table('privilege')->where('level_name',1)->get();
    		}else {
    			$privA = [];
    			$privB = [];
    		}
    	}else {
    		//正常取出权限；
    		//取出顶级权限；
    		$priv_ids = explode(',', $priv_ids);
    		$privA =  DB::table('privilege')->whereIn('id',$priv_ids)->where('level_name',0)->get();
    		//取出顶级的子权限；
    		$privB =  DB::table('privilege')->whereIn('id',$priv_ids)->where('level_name',1)->get();
    	}
    	//print_r($privA);exit;
    	return view('admin.index.index',compact('privB','privA'));//resources/views/admin/index/index.blade.php
    }
    public function welcome(){
    	return view('admin.index.welcome');//resources/views/admin/index/welcome.blade.php
    }
}
