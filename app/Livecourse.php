<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livecourse extends Model
{
    protected $table = 'live_course';
    protected $fillable = ['live_course','stream_id','cover_img','live_desc','start_time','end_time'];
    //配置与直播流的关系，一个直播课程要属于一个直播流，所以是一对一的关系；
    public function stream(){
    	return $this->hasOne('App\Stream','id','stream_id');
    }
    //添加一个方法，用于判断是否能够进入直播间
    public function is_by_play_time(){
    	$time = time();
        $start_time = $this->start_time;
        $end_time = $this->end_time;
        if($time>=$start_time && $time<$end_time){
        	return 1;
        }else {
        	return 0;
        }
    }
}
