<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
class IndexController extends Controller
{
    public function index(){
    	//取出课程数据，
    	$coursedata = Course::with('lesson')->get();
    	return view('home.index.index',compact('coursedata'));
    }
}
