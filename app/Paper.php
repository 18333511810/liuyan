<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table = 'paper';
    public $timestamps = false;
    public $fillable = ['paper_name','paper_score','course_id'];
    //配置与课程的关系，一套试卷只能属于一个课程，关系是一对一的
    public function course(){
    	return $this->hasOne('App\Course','id','course_id');
    }

}
