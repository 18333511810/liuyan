<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Course;
use Validator;
use Storage;
class LessonController extends Controller
{
    //课时列表
    public function index(Request $request){
    	if($request->isMethod('get')){
    		$data = Lesson::all();
    		return view('admin.lesson.index',compact('data'));
    	}else if($request->isMethod('post')){
    		//接收传递的分页信息；
    		$offset = $request->input('start');
    		$limit = $request->input('length');
    		/*
				order[0][column]:2
				order[0][dir]:desc
				columns[2][data]:
    		*/
			//接收列的序号
			$columnid = $request->input('order.0.column');
			$orderway = $request->input('order.0.dir');
			//把列的序号转换成名称；
			$columnname = $request->input('columns.'.$columnid.'.data');
			//接收三个条件
			$title = $request->input('title');//接收课时名称
			$datemin = $request->input('datemin');//接收日期范围
			$datemax = $request->input('datemax');//接收日期范围

    		$data = Lesson::offset($offset)
		    		->limit($limit)
		    		->where('lesson_name','like',"%$title%")
		    		->where(function($query) use($datemin,$datemax){
		    			//条件判断
		    			if($datemin!=''){
		    				$query->where('created_at','>=',$datemin);
		    			}
		    			if($datemax!=''){
		    				$query->where('created_at','<=',$datemax.' 23:59:59');
		    			}
		    		})
		    		->with(['course'=>function($query){
		    			$query->with('profession');
		    		}])
		    		->orderBy($columnname,$orderway)
		    		->get();
    		$count = Lesson::count();
    		//计算满足条件的记录数
    		$countFiltered = Lesson::where('lesson_name','like',"%$title%")
    						->where(function($query) use($datemin,$datemax){
				    			//条件判断
				    			if($datemin!=''){
				    				$query->where('created_at','>=',$datemin);
				    			}
				    			if($datemax!=''){
				    				$query->where('created_at','<=',$datemax.' 23:59:59');
				    			}
		    				})->count();
    						
    		return [
    			'draw'=>$request->input('draw'),
    			'recordsTotal'=>$count,
    			'recordsFiltered'=>$countFiltered,
    			'data'=>$data,
    		];
    	}
    	
    }
    public function status(Request $request,Lesson $lesson){
    	$res = $lesson->update(['status'=>$request->input('status')]);
    	if($res){
    		return ['info'=>1];
    	}else {
    		return ['info'=>0];
    	}
    }
    //添加课时的
    public function add(Request $request){
    	if($request->isMethod('get')){
    		//取出课程的数据
    		$course = Course::all();
    		return view('admin.lesson.add',compact('course'));
    	}else if($request->isMethod('post')){
    		//数据验证功能 Validator
    		//定义验证规则
    		$rules = [
    			'lesson_name'=>'required|unique:lesson,lesson_name',
    			'course_id'=>'required|integer',
    			'teacher_name'=>'required',
    			'lesson_length'=>'required|integer',
    			'status'=>'required|boolean',
    			'lesson_desc'=>'required|min:5'
    		];
    		//定义错误提示
    		$msg = [
    			'lesson_name.required'=>'课时名称不能为空',
    			'lesson_name.unique'=>'课时名称已经存在',
    			'course_id.required'=>'课程数据不能为空',
    			'course_id.integer'=>'课时数据不合法',
    			'teacher_name.required'=>'讲师名称不能为空',
    			'lesson_length.required'=>'课时长度不能为空',
    			'status.required'=>'要选择课时状态',
    			'status.boolean'=>'状态数据不合法',
    			'lesson_desc.required'=>'描述不能为空',
    			'lesson_desc.min'=>'描述信息至少是5个字符'
    		];
    		$data = $request->all();
    		$validator = Validator::make($data,$rules,$msg);
    		if($validator->passes()){
    			//通过数据验证,入库
    			$res  = Lesson::create($data);
    			if($res){
    				return ['info'=>1];
    			}else {
    				return ['info'=>0,'error'=>'入库失败'];
    			}

    		}else {
    			//未通过数据验证，返回错误提示；
    			//获取错误提示；$validator->messages();
    			$error = collect($validator->messages())->implode('0', ',');
    			/*echo '<pre>';
    			print_r($validator->messages());*/
    			return ['info'=>0,'error'=>$error];

    		}
    	}
    }
    //完成图片文件上传的
    public function upimage(Request $request){
    	$file = $request->file('file');//接收上传的文件
    	//判断文件是否上传成功
    	if($file->isValid()){
    		//开始上传；
    		$filename = $file->store('image','upload');
    		return ['info'=>'/uploads/'.$filename];
    	}
    }
    //完成视频文件上传的
    public function upvideo(Request $request){
    	$file = $request->file('file');//接收上传的文件
    	//判断文件是否上传成功
    	if($file->isValid()){
    		//开始上传；
    		$filename = $file->store('video','upload');
    		return ['info'=>'/uploads/'.$filename];
    	}
    }
    //视频播放的方法；
    public function play(Request $request,Lesson $lesson){
    	//注意：$lesson名称要和web.php路由中定义的路由参数名称一致；
    	//$lesson = Lesson::find($id);
    	return view('admin.lesson.play',compact('lesson'));
    }
    //修改课时
    public function update(Request $request,Lesson $lesson){
    	if($request->isMethod('get')){
    		//取出课程数据
    		$course = Course::all();
    		//展示被修改的数据
    		return view('admin.lesson.update',compact('lesson','course'));
    	}else if($request->isMethod('post')){
    		//完成修改
    		$rules = [
    			'lesson_name'=>'required|unique:lesson,lesson_name,'.$lesson->id,
    			'course_id'=>'required|integer',
    			'teacher_name'=>'required',
    			'lesson_length'=>'required|integer',
    			'status'=>'required|boolean',
    			'lesson_desc'=>'required|min:5'
    		];
    		//定义错误提示
    		$msg = [
    			'lesson_name.required'=>'课时名称不能为空',
    			'lesson_name.unique'=>'课时名称已经存在',
    			'course_id.required'=>'课程数据不能为空',
    			'course_id.integer'=>'课时数据不合法',
    			'teacher_name.required'=>'讲师名称不能为空',
    			'lesson_length.required'=>'课时长度不能为空',
    			'status.required'=>'要选择课时状态',
    			'status.boolean'=>'状态数据不合法',
    			'lesson_desc.required'=>'描述不能为空',
    			'lesson_desc.min'=>'描述信息至少是5个字符'
    		];
    		$data = $request->all();
            //echo '<pre>';
           // var_dump($data);exit;//($data);exit;
    		$validator = Validator::make($data,$rules,$msg);
    		if($validator->passes()){
    			//判断是否删除旧的缩略图
    			$old_cover_img = $lesson->cover_img;
    			//取出新提交的缩略图
    			$new_cover_img = $request->input('cover_img');
                if($new_cover_img==''){
                    unset($data['cover_img']);
                }
    			if($old_cover_img!=$new_cover_img){
    				//缩略图被修改了
    				if($old_cover_img!=''){
    					//删除旧的缩略图
    					//uploads/image/V0UGZyySetiIz14HtftteqYkqbaABpwI7D3p18Fr.jpeg
    					
    					//Storage::disk('upload')//该存储位置，已经定位到uploads目录下面了，
    					//所以，要去掉我们自己拼接uploads目录，
    					$old_cover_img = str_replace('/uploads/', '', $old_cover_img);
    					Storage::disk('upload')->delete($old_cover_img);

    				}
    			}
    			//判断是否删除旧的视频
    			$old_video_address = $lesson->video_address;
    			//取出新提交的缩略图
    			$new_video_address = $request->input('video_address');
                if($new_video_address==''){
                    unset($data['video_address']);
                }
    			if($old_video_address!=$new_video_address){
    				//缩略图被修改了
    				if($old_video_address!=''){
    					//删除旧的缩略图
    					//uploads/image/V0UGZyySetiIz14HtftteqYkqbaABpwI7D3p18Fr.jpeg
    					
    					//Storage::disk('upload')//该存储位置，已经定位到uploads目录下面了，
    					//所以，要去掉我们自己拼接uploads目录，
    					$old_video_address = str_replace('/uploads/', '', $old_video_address);
    					Storage::disk('upload')->delete($old_video_address);

    				}
    			}
    			//通过验证了,完成修改啊；
    			$lesson->update($data);
    			return ['info'=>1];
    		}else {
    			//未同验证
    			$error = collect($validator->messages())->implode('0', ',');
    			return ['info'=>0,'error'=>$error];
    		}
    	}
    }
    //删除课时的操作
    public function del(Request $request,Lesson $lesson){
    	//删除旧的附件
    	$old_cover_img = $lesson->cover_img;
    	$old_video_address = $lesson->video_address;
    	$res = $lesson->delete();
    	if($res){
    		if($old_cover_img!=''){
    			$old_cover_img = str_replace('/uploads/', '', $old_cover_img);
    			Storage::disk('upload')->delete($old_cover_img);
    		}
    		if($old_video_address!=''){
    			$old_video_address = str_replace('/uploads/', '', $old_video_address);
    			Storage::disk('upload')->delete($old_video_address);
    		}
    		return ['info'=>1];
    	}else {
    		return ['info'=>0];
    	}
    }

    //批量删除
    public function datadel(Request $request){
    	//批量删除数据了
    	$ids = $request->input('ids');//接收传递的课时的id，此处是一个数组;
    	//Lesson::whereIn('id',$ids)->get();//返回的是一个集合
    	Lesson::whereIn('id',$ids)->get()->each(function($item){
    		//$item就是一行数据封装的对象；
    		//删除附件
    		$old_cover_img = $item->cover_img;
    		$old_video_address = $item->video_address;
    		if($old_cover_img!=''){
    			$old_cover_img = str_replace('/uploads/', '', $old_cover_img);
    			Storage::disk('upload')->delete($old_cover_img);
    		}
    		if($old_video_address!=''){
    			$old_video_address = str_replace('/uploads/', '', $old_video_address);
    			Storage::disk('upload')->delete($old_video_address);
    		}
    		$item->delete();
    	});

    	return ['info'=>1];
    }

}
