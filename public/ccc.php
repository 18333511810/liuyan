<?php 


Class cname{
	public function cat($s1,$s2){
		// echo $s1;
		if($s1!==''&&$s2!=='')
		return $s1.$s2;
	}
}
$a = new cname();
$bb = $a->cat("我是","php程序员");
echo $bb;

 ?>