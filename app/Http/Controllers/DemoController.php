<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Lesson;
use Auth;
use App\Privilege;
use App\Role;
class DemoController extends Controller
{
    public function demo(){
        echo 5&7;

        /*$action = \Route::current()->getActionName();
        /*echo __METHOD__;
        echo '<hr>';*/
        //echo  $action;
        //list($controller_name,$action_name) =  explode('@', $action);
       //echo ltrim(str_replace('Controller','',strrchr($controller_name,'\\')),'\\');
//
        //echo '<hr>';
        //echo $action_name;
       /*$info =  Role::find(2);
       $res = $info->update(['role_name'=>'员工']);
       var_dump($res);*/

      /* $data =  Privilege::pluck('controller_name','id')->toArray();
       echo '<pre>';
       print_r($data);*/
       /*$res =  password_hash('123456',PASSWORD_BCRYPT,['cost'=>12,'salt'=>'1234567887654321123456']);
       echo $res;
       
       $res =  password_verify('123456','$2y$10$/6NIB4tr0CQnrE.isGV.DeL6/SreAKVROmSwiljg9LmtWLMFBwHjW');
       var_dump($res);*/
        //$info = Auth::guard('admin')->check();
        //var_dump($info);

        /*echo '<pre>';
        $info = Auth::guard('admin')->user();
        print_r($info);*/
        /*$faker = \Faker\Factory::create('zh_CN');
        echo $faker->name;
        echo '<hr>';
        echo $faker->address;
        echo '<hr>';
        echo $faker->phoneNumber;
        echo '<hr>';
        echo $faker->imageUrl;*/

        //echo time();
        /*$method = 'POST';
                $space = 'zibo0001';//直播空间名称
                $path = '/v2/hubs/'.$space.'/streams';
                $host = 'pili.qiniuapi.com';
                $content_type = 'application/json';
                $body  = json_encode([
                    'key'=>'php4'
                ]);
                //拼接字符串用于完成加密的；
                $token = "$method $path\nHost: $host\nContent-Type: $content_type\n\n$body";
                //获取ak和sk
                $ak = config('filesystems.disks.qiniu.access_key');
                $sk = config('filesystems.disks.qiniu.secret_key');
                //调用七牛的功能包
                $qiniu = new \Qiniu\Auth($ak,$sk);
            echo     $quan = "Qiniu ".$qiniu->sign($token);*/
        //echo config('filesystems.disks.qiniu.secret_key');
    	/*$info = Lesson::find(1);
    	$info->forceDelete();*/
    	/*$data = Lesson::withTrashed()->restore();
    	echo '<pre>';
    	print_r($data);*/



    	/*$names  = [
    		['李白',12],
    		['宋江',22],
    		['杜甫',1],
    	];
    	echo collect($names)->implode('0','-');*/


    	/*$names = [
    		'one'=>['name'=>'宋江','age'=>12],
    		'two'=>['name'=>'李逵','age'=>32],
    		       ['name'=>'李白','age'=>52],
    	];

    	$info = collect($names)->implode('name','-');
    	echo $info;*/
    	/*echo '<pre>';
    	print_r($info);*/


    	/*$collection = collect([
		    ['account_id' => 1, 'product' => 'Desk'],
		    ['account_id' => 2, 'product' => 'Chair'],
		]);

		echo $collection->implode('product', ', ');*/
    	/*DB::connection()->enableQueryLog();//开启sql语句的日志功能；
    	Lesson::where(function($w){
    		$w->where('id','>',5);
    		$w->orWhere('course_id',3);
    	})->where('lesson_name','php')->get();
		$query = DB::getQueryLog();//获取sql语句的日志
		echo '<pre>';
		print_r($query);*/

    }
}
