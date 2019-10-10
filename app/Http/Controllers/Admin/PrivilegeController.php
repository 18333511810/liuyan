<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Privilege;
use Validator;
class PrivilegeController extends Controller
{
    //权限列表的
    public function index(){
    	//取出权限数据
    	$data = Privilege::all()->toArray();
    	$data = getFormat($data);
    	/*echo '<pre>';
    	print_r($data);exit;*/
    	return view('admin.privilege.index',compact('data'));
    }
    //添加权限
    public function add(Request $request){
    	if($request->isMethod('get')){
    		//取出能作为父级权限的权限数据；
    		$privilegedata =  Privilege::where('level_name','<',2)->get();
    		$privilegedata = getFormat($privilegedata);//对权限数据进行格式化；
    		return view('admin.privilege.add',compact('privilegedata'));
    	}else if($request->isMethod('post')){
    		//return ['info'=>1];

            $data = $request->all();
            //echo '<pre>';
            //print_r($data);exit;
            $rules = [
                'priv_name'=>'required',
                'parent_id'=>'required',
                'level_name'=>'required'
            ];
            $msg = [
                'priv_name.required'=>'权限名称不能为空',
                'parent_id.required'=>'父级权限不能为空',
                'level_name.required'=>'权限级别不能为空'
            ];
            $validator = Validator::make($request->all(),$rules,$msg);
            if($validator->passes()){
                if(empty($request->input('controller_name'))){
                    unset($data['controller_name']);
                }
                if(empty($request->input('action_name'))){
                    unset($data['action_name']);
                }
                if(empty($request->input('address'))){
                    unset($data['address']);
                }
                //通过验证
                Privilege::create($data);
                return ['info'=>1];
            }else {
               $error =  collect($validator->messages())->implode('0', ',');
               return ['info'=>0,'error'=>$error];
            }
    	}
    }
}
