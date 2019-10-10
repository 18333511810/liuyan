<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//前台的路由
Route::group(['namespace'=>'Home'],function(){
	//展示直播课程的
	Route::get('person/livecourse','PersonController@livecourse');
	//进入直播间的路由
	Route::get('person/livecourse/play/{stream}','VideoController@play');
	Route::get('login','MemberController@login');
	Route::post('login_check','MemberController@login_check');
	Route::get('/','IndexController@index');
	Route::get('course/detail/{course}','CourseController@detail');
	Route::get('cart/add/{course}','CartController@add');
	Route::get('cart/index','CartController@index');
	//添加订单
	Route::get('order/add','OrderController@add');
	//试卷列表
	Route::get('person/paper','PersonController@paper');
	//展示试题
	Route::get('person/exam/{paper}','PersonController@exam');
	//提交试题
	Route::post('person/run/{paper}','PersonController@run');
	//展示试题答案的路由
	Route::get('person/answer/{paper}',"PersonController@answer");
});
//后台的路由
Route::get('demo','DemoController@demo');
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
	Route::group(['middleware'=>'login'],function(){
		Route::get('index','IndexController@index');
		Route::get('welcome','IndexController@welcome');
		// 课时列表的路由
		Route::match(['get','post'],'lesson/index','LessonController@index');
		//修改状态；
		Route::post('lesson/status/{lesson}','LessonController@status');
		//添加课时
		Route::match(['get','post'],'lesson/add','LessonController@add');
		//定义上传图片文件的路由
		Route::post('lesson/upimage','LessonController@upimage');
		Route::post('lesson/upvideo','LessonController@upvideo');
		//视频播放的路由
		Route::get('lesson/play/{lesson}','LessonController@play');
		//修改课时
		Route::match(['get','post'],'lesson/update/{lesson}','LessonController@update');
		//删除的路由
		Route::post('lesson/del/{lesson}','LessonController@del');
		//批量删除的路由
		Route::post('lesson/datadel','LessonController@datadel');
		//直播流管理
		Route::get('stream/index','StreamController@index');
		Route::match(['get','post'],'stream/add','StreamController@add');
		//直播课程管理
		Route::get('livecourse/index','LivecourseController@index');
		Route::match(['get','post'],'livecourse/add','LivecourseController@add');
		//生成推流地址
		Route::get('livecourse/get_push/{livecourse}/{stream}','LivecourseController@get_push');
		//退出登录的
		Route::get('logout','ManagerController@logout');
		//角色列表
		Route::get('role/index','RoleController@index');
		//角色修改
		Route::match(['post','get'],'role/update/{role}','RoleController@update');
		//权限列表
		Route::get('privilege/index','PrivilegeController@index');
		//权限添加
		Route::match(['get','post'],'privilege/add','PrivilegeController@add');
		//试卷列表
		Route::get('paper/index',"PaperController@index");
		//试题列表
		Route::get('question/index/{paper}','QuestionController@index');
		Route::match(['post','get'],'question/add/{paper}','QuestionController@add');
		//导出试题
		Route::get('question/export/{paper}','QuestionController@export');

		Route::post('question/import/{paper}','QuestionController@import');
	});
	//后台登录验证
	Route::get('login','ManagerController@login');
	//完整登录验证的
	Route::post('loginok','ManagerController@loginok');
	
});

