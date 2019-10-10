<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stream;
use Validator;
class StreamController extends Controller
{
    //直播流列表
    public function index(){
    	$data = Stream::all();
    	return view('admin.stream.index',compact('data'));
    }
    //添加直播流
    public function add(Request $request){
    	if($request->isMethod('get')){
    		//显示表单页面
    		return view('admin.stream.add');
    	}else if($request->isMethod('post')){
    		//添加直播流（1）把直播流信息同步到七牛云里面，（2）把直播流信息入库
    		$rules = [
    			'stream_name'=>'required|unique:stream,stream_name',
    		];
    		$msg = [
    			'stream_name.required'=>'直播流名称不能为空',
    			'stream_name.unique'=>'直播流名称已经存在'
    		];
    		$data = $request->all();
    		$validator = Validator::make($data,$rules,$msg);
    		if($validator->passes()){
    			//验证通过
    			//(1)把直播流信息同步到七牛云里面
    			$method = 'POST';
    			$space = 'zibo0001';//直播空间名称
    			$path = '/v2/hubs/'.$space.'/streams';
    			$host = 'pili.qiniuapi.com';
    			$content_type = 'application/json';
    			$body  = json_encode([
    				'key'=>$request->input('stream_name')
    			]);
    			//拼接字符串用于完成加密的；
    			$token = "$method $path\nHost: $host\nContent-Type: $content_type\n\n$body";
    			//获取ak和sk
    			$ak = config('filesystems.disks.qiniu.access_key');
				$sk = config('filesystems.disks.qiniu.secret_key');
				//调用七牛的功能包
				$qiniu = new \Qiniu\Auth($ak,$sk);
				$quan = "Qiniu ".$qiniu->sign($token);
				//发送http的post请求
				$cli = new \GuzzleHttp\Client();
				$res = $cli->request($method,$host.$path,[
				    'headers'=>[
				        'Authorization'=>$quan,
				        'Content-Type'=>'application/json',
				        'Accept-Encoding'=>'gzip',
				        'Content-Length'=>strlen($body),
				        'User-Agent'=>'pili-sdk-go/v2 go1.6 darwin/amd64',
				    	],
			    	'body'=>$body,
				]);
				//（2）入库操作
				Stream::create($data);
				return ['info'=>1];
    		}else {
    			  $error = collect($validator->messages())->implode('0',',');
    			  return ['info'=>0,'error'=>$error];
    		}
    	}
    }
}
