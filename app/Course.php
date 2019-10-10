<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table ='course';
    protected $fillable = ['course_name','profession_id','course_desc','course_price','cover_img'];
    //配置与专业的关系，一个课程属于一个专业，关系就是一对一的关系；
    public function profession(){
    	return $this->hasOne('App\Profession','id','profession_id');
    }
    //配置与课时的关系，一个课程里面有多个课时
    public function lesson(){
    	return $this->hasMany('App\Lesson','course_id','id');
    }
}
