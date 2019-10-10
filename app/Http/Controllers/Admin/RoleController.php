<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Privilege;
use Validator;
use DB;
class RoleController extends Controller
{
    //角色列表
    public function index(){
    	$data = Role::all();
    	return view('admin.role.index',compact('data'));
    }
    //修改角色
    public function update(Request $request,Role $role){
    	if($request->isMethod('get')){
    		//取出权限数据，完成遍历
    		//取出顶级权限
    		$privA = Privilege::where('level_name',0)->get();
    		$privB = Privilege::where('level_name',1)->get();
    		$privC = Privilege::where('level_name',2)->get();
    		//取出原来的权限数据
    		$old_priv_ids = $role->priv_ids;
    		$priv_ids = explode(',', $old_priv_ids);
    		//展示出修改页面；
    		return view('admin.role.update',compact('privA','privB','privC','role','priv_ids'));
    	}else if($request->isMethod('post')){
    		//return ['info'=>1];
    		//完成修改
    		$rules = [
    			'role_name'=>'required|unique:role,role_name,'.$role->id,
    			'priv_ids'=>'required|array'
    		];

    		$msg = [
    			'role_name.required'=>'角色名称不能为空',
    			'role_name.unique'=>'角色名称已经存在',
    			'priv_ids.required'=>'必须选择权限',
    			'priv_ids.array'=>'权限数据不合法'
    		];
    		$data = $request->all();
    		$validator = Validator::make($data,$rules,$msg);
    		if($validator->passes()){
    			//拼接权限的id
    			$priv_ids = implode(',',$request->input('priv_ids'));
    			//$priv_ac 根据$request->input('priv_ids')数据从权限表里面取出来；
    			$info = Privilege::whereIn('id',$request->input('priv_ids'))
    						->where('level_name','>',0)
    						->select(DB::raw("concat(controller_name,'-',action_name) as priv_ac"))
    						->pluck('priv_ac')->toArray();
    			$priv_ac = implode(',',$info);
    			//echo $priv_ac;
    			$role->update([
    				'role_name'=>$request->input('role_name'),
    				'priv_ids'=>$priv_ids,
    				'priv_ac'=>$priv_ac
    			]);
    			return ['info'=>1];
    		}else {
    			$error = collect($validator->messages())->implode('0', ',');
    			return ['info'=>0,'error'=>$error];
    		}
    	}
    }
}
