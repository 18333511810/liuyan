<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Cart;
use App\Course;
use DB;
class CartController extends Controller
{
    //添加课程到购物车；
    public function add(Request $request,Course $course){
    	//调用购物车类；
    	$cart  = new Cart();
    	//array('course_id'=>'商品id','course_name'=>'名称','course_price'=>'单价')
    	$data = [
	    	'course_id'=>$course->id,
	    	'course_name'=>$course->course_name,
	    	'course_price'=>$course->course_price
	    ];
    	$cart->add($data);
    	return view('home.cart.add',compact('course'));
    }

    //购物车列表
    public function index(){
    	$cart  = new Cart();
    	$total = $cart->getNumberPrice();
    	$data = $cart->getCartInfo();
    	/*echo '<pre>';
    	print_r($data);exit;*/
    	return view('home.cart.index',compact('total','data'));
    }
}
