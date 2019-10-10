<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Cart;
use App\Order;
use DB;
class OrderController extends Controller
{
    //添加订单
    public function add(){
    	$cart = new Cart();
    	$total = $cart->getNumberPrice();
    	//入库id_order表和it_course_order表；
    	$order_sn = uniqid().time();
    	$stu_id = 100;
    	$total_price = $total['price'];
    	$order = Order::create([
    		'order_sn'=>$order_sn,
    		'stu_id'=>$stu_id,
    		'total_price'=>$total_price
    	]);
    	//取出购物车里面的数据
    	$cartdata = $cart->getCartInfo();
    	//入库it_order_course表
    	foreach($cartdata as $v){
    		DB::table('order_course')->insertGetId([
    			'order_id'=>$order->id,
    			'course_id'=>$v['course_id'],
    			'course_price'=>$v['course_price']
    		]);
    	}

    	//入库成功后，要清空购物车数据；
    	$cart->delall();
    	//进行到下一步，进行支付，

    	return view('home.order.add');

    }
}
