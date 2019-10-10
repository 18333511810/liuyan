<?php 


Class cname{
	public function cat($s1,$s2){
		if($s1=''&&$s2!='')
			echo $s1.$s2;
	}
}
$a = new cname();
$bb = $a->cat("我是php","程序员");

 ?>