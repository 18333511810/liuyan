<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;
	protected $dates = ['deleted_at'];

    protected $table = 'lesson';
    protected $fillable = ['lesson_name','course_id','lesson_desc','lesson_length','teacher_name','cover_img','status','video_address'];

    //配置与课程的关系，一个课时只能属于一个课程，所以是一对一的关系；
    public function course(){
    	return $this->hasOne('App\Course','id','course_id');
    }
}
