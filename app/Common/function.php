<?php
function demo(){
	echo 'I am demo';
}
function demo2(){
	echo 'I am demo2';
}

//格式化数据的一个函数；
function getFormat($data,$parent_id=0){
	static $list = [];
	foreach($data as $v){
		if($v['parent_id']==$parent_id){
			$list[] = $v;
			getFormat($data,$v['id']);
		}
	}
	return $list;
}
//获取当前的地址
function getAddress(){
	 $action = \Route::current()->getActionName();
	 list($controller_name,$action_name) =  explode('@', $action);
	 $data['controller_name'] = ltrim(str_replace('Controller','',strrchr($controller_name,'\\')),'\\');
     $data['action_name'] = $action_name;
     return $data;
}
//直接返回控制器的名称；
function getController_name(){
	$data = getAddress();
	return $data['controller_name'];
}
//直接返回方法名称
function getAction_name(){
	$data = getAddress();
	return $data['action_name'];
}
?>