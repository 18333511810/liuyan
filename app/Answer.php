<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answer';
    public $timestamps = false;
    protected $fillable = ['paper_id','question_id','answer_result','stu_id','answer_score','right_wrong'];
}
