<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    public $timestamps = false;
    protected $fillable = ['question_name','paper_id','question_score','question_answer','option_a','option_b','option_c','option_d','question_type'];

    public static $question_answer = [
    	1=>'A',
    	2=>'B',
    	3=>'AB',
    	4=>'C',
    	5=>'AC',
    	6=>'BC',
    	7=>'ABC',
    	8=>'D',
    	9=>'AD',
    	10=>'BD',
    	11=>'ABD',
    	12=>'CD',
    	13=>'ACD',
    	14=>'BCD',
    	15=>'ABCD'
    ];

    //写一个方法，用于判断得分情况，参数是你的答案；
    public function answer_result($result){
        //取出正确答案；
        $answer = $this->question_answer;
        if( (($answer&$result) == $answer) &&  (($answer&$result) == $result)){
                //完全正确
                $data['answer_score'] = $this->question_score;
                $data['right_wrong'] = '正确';
        }else if(($answer&$result) == $result){
                $data['answer_score'] = 1;
                $data['right_wrong']='半对';
        }else {
                $data['answer_score'] = 0;
                $data['right_wrong']='错误';
        }
        return $data;
    }
    //指定与答案表的关系；
    public function answer(){
        return $this->hasOne('App\Answer','question_id','id');
    }
}
