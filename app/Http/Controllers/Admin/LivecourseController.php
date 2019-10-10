<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Livecourse;
use App\Stream;
use Validator;
class LivecourseController extends Controller
{
    //直播课程列表；
    public function index(){
    	$data = Livecourse::with('stream')->get();
    	return view('admin.livecourse.index',compact('data'));
    }
    //添加直播课程
    public function add(Request $request){
    	if($request->isMethod('get')){
    		//展示出添加直播课程的表单
    		$stream = Stream::all();
    		return view('admin.livecourse.add',compact('stream'));
    	}else if($request->isMethod('post')){
    		//添加一个数据验证
    		$data  = $request->all();
    		$rules = [
    			'live_course'=>'required|min:3',
    			'stream_id'=>'required|integer',
    			'live_desc'=>'required|min:5',
    			'start_time'=>'required',
    			'end_time'=>'required'
    		];
    		$msg = [
    			'live_course.required'=>'直播课程名称不能为空',
    			'live_course.min'=>'直播课程名称必须至少3个字符',
    			'stream_id.required'=>'所属直播流名称不能为空',
    			'stream_id.integer'=>'所属直播流数据不合法',
    			'start_time.required'=>'开始时间不能为空',
    			'end_time.required'=>'结束时间不能为空',
    			'live_desc.required'=>'描述不能为空',
    			'live_desc.min'=>'描述至少是5个字符'
    		];

    		$validator = Validator::make($data,$rules,$msg);
    		if($validator->passes()){
    			//当不上传缩略图时，要去掉添加的cover_img;
    			if($request->input('cover_img')==''){
    				unset($data['cover_img']);
    			}
    			//开始入库
    			//把日期格式转换成时间戳类型；
    			$data['start_time'] = strtotime($request->input('start_time'));
    			$data['end_time'] = strtotime($request->input('end_time'));
    			Livecourse::create($data);
    			return ['info'=>1];
    		}else {
    			//不合法
    			$error = collect($validator->messages())->implode('0', ',');
    			return ['info'=>0,'error'=>$error];
    		}

    	}
    }

    //生成推流地址
    public function get_push(Request $request,Livecourse $livecourse,Stream $stream){
        //生成推流地址；
        /*
            rtmp://pili-publish.www.hanguophp.cn/zibo0001/110?e=1522292018&token=BItXyIvCVoNgi7yIa0CEy0iZlfUqBWnDmLTTmVtQ:yFp6YxGslIdEAfY8qHTVK7pkN3U=
        */
        $space = 'zibo0001';//直播空间名称
        $stream_name = $stream->stream_name;//直播流的名称
        $end_time = $livecourse->end_time;//直播的过期时间；
        //制作推流凭证token
        $path = "/".$space."/".$stream_name."?e=".$end_time;

        //获取ak和sk
        $ak = config('filesystems.disks.qiniu.access_key');
        $sk = config('filesystems.disks.qiniu.secret_key');
        //调用七牛的功能包
        $qiniu = new \Qiniu\Auth($ak,$sk);
        $token = $qiniu->sign($path);
        $url = "rtmp://pili-publish.www.hanguophp.cn".$path.'&token='.$token;
        echo $url;
        //return view('admin.livecourse.get_push',compact('url'));

    }
}
