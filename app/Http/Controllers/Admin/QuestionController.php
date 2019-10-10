<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Paper;
use App\Question;
use Validator;
use Excel;
use DB;
class QuestionController extends Controller
{
    //试题列表
    public function index(Request $request,Paper $paper){
    	//取出试题
    	$data = Question::where('paper_id',$paper->id)->get();
    	return view('admin.question.index',compact('data','paper'));
    }
    //添加试题
    public function add(Request $request,Paper $paper){
    	if($request->isMethod('get')){
    		return view('admin.question.add',compact('paper'));
    	}else if($request->isMethod('post')){
    		//数据验证，开始入库；
    		$data = $request->all();
    		$rules = [
    			'question_name'=>'required',
    			'question_type'=>'required',
    			'question_score'=>'required',
    			'option_a'=>'required',
    			'option_b'=>'required',
    			'option_c'=>'required',
    			'option_d'=>'required',
    			'question_answer'=>'array'
    		];

    		$msg = [
    			'question_name.required'=>'试题名称不能为空',
    			'question_type.required'=>'试题类型不能为空',
    			'question_score.required'=>'试题分值不能为空',
    			'option_a.required'=>'选项A不能为空',
    			'option_b.required'=>'选项B不能为空',
    			'option_c.required'=>'选项C不能为空',
    			'option_d.required'=>'选项D不能为空',
    			'question_answer.array'=>'答案数据有误'
    		];
    		$validator = Validator::make($data,$rules,$msg);
    		if($validator->passes()){
    			$data['paper_id'] = $paper->id;
    			$data['question_answer'] = array_sum($request->input('question_answer'));
    			Question::create($data);
    			return ['info'=>1];
    		}else {
    			 $error = collect($validator->messages())->implode('0', ',');
    			 return ['info'=>0,'error'=>$error];
    		}
    	}
    }
    //导出试题的方法；
    public function export(Request $request,Paper $paper){
        //写代码，完成导出到excel文件中；
        //定义标头
        $cellData[]= ['试题名称','试题分值','试题类型','选项A','选项B','选项C','选项D','正确答案'];
        //取出试题数据
        $data = Question::where('paper_id',$paper->id)->get();
        $a = [1=>'单选',2=>'多选'];
        foreach($data as $v){
            $cellData[]= [$v->question_name,$v->question_score,$a[$v->question_type],$v->option_a,$v->option_b,$v->option_c,$v->option_d,Question::$question_answer[$v->question_answer]];
        }
        Excel::create('第一套试题',function($excel) use($cellData){
            $excel->sheet('sheet1',function($sheet) use($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }

    //导入Excel试题文件
    public function import(Request $request,Paper $paper){
        //先完成上传excel文件；
        $file = $request->file('file');
        if($file->isValid()){
            //表示上传成功后处理，
           $excelfile = './uploads/'.$file->store('excel','upload');
           $a = ['单选'=>1,'多选'=>2];
           $b = array_flip(Question::$question_answer);

           //读取文件；
           Excel::load($excelfile,function($excel) use($a,$b,$paper){
                $data = $excel->getSheet(0)->toArray();
                unset($data[0]);
                foreach($data as $v){
                    DB::table('question')->insert([
                        'question_name'=>$v[0],
                        'paper_id'=>$paper->id,
                        'question_score'=>$v[1],
                        'question_type'=>$a[$v[2]],
                        'option_a'=>$v[3],
                        'option_b'=>$v[4],
                        'option_c'=>$v[5],
                        'option_d'=>$v[6],
                        'question_answer'=>$b[$v[7]]

                    ]);
                }
           });
           return ['info'=>1];
        }
    }
}
