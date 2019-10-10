<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Livecourse;
use App\Paper;
use App\Question;
use DB;
class PersonController extends Controller
{
    //展示直播课程的
    public function livecourse(){
    	//取出直播课程啊；
    	$data = Livecourse::all()->each(function($item){
    		$item->access = $item->is_by_play_time();
    	});
    	return view('home.person.livecourse',compact('data'));

    }
    //试卷列表
    public function paper(){
    	$data = Paper::all();
    	return view('home.person.paper',compact('data'));
    }

    //试题展示的方法；
    public function exam(Request $request,Paper $paper){
    	//取出试题，条件
    	//取出单选试题
    	$radiodata = Question::where('question_type',1)->where('paper_id',$paper->id)->get();
    	//多选试题
    	$checkboxdata = Question::where('question_type',2)->where('paper_id',$paper->id)->get();

    	return view('home.person.exam',compact('radiodata','checkboxdata','paper'));

    }

    //接收提交的表单（提交的试题答案）
    public function run(Request $request,Paper $paper){
		$data = $request->input('answer_');
		foreach($data as $k=>$v){
			$info = Question::find($k);
			$res = $info->answer_result(array_sum($v));
			DB::table('answer')->insert([
				'paper_id'=>$paper->id,
				'question_id'=>$k,
				'stu_id'=>100,
				'answer_result'=>array_sum($v),
				'answer_score'=>$res['answer_score'],
				'right_wrong'=>$res['right_wrong'],
			]);
		}

		return redirect('person/answer/'.$paper->id);

		
    }
    public function answer(Request $request,Paper $paper){
    	//取出试题和答案数据
    	//取出单选试题
    	$radiodata = Question::where('paper_id',$paper->id)
			    	->where('question_type',1)
			    	->with(['answer'=>function($item){
			    		$item->where('stu_id',100);
    				}])
    				->get();
    	//取出多选试题
    	$checkboxdata = Question::where('paper_id',$paper->id)
			    	->where('question_type',2)
			    	->with(['answer'=>function($item){
			    		$item->where('stu_id',100);
    				}])
    				->get();
       return view('home.person.answer',compact('radiodata','checkboxdata'));
    }
}
