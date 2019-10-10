<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="{{asset('admins')}}/lib/html5shiv.js"></script>
<script type="text/javascript" src="{{asset('admins')}}/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{{asset('admins')}}/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="{{asset('admins')}}/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="{{asset('admins')}}/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="{{asset('admins')}}/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link href="{{asset('admins')}}/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{asset('admins')}}/jedate/skin/jedate.css">
<link rel="stylesheet" type="text/css" href="{{asset('admins')}}/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="{{asset('admins')}}/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>添加管理员 - 管理员管理 - H-ui.admin v3.1</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin-add">
	{{csrf_field()}}
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>直播课程名称：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input type="text" class="input-text" value="{{old('live_course')}}" placeholder="" id="live_course" name="live_course">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">所属直播流：</label>
		<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="stream_id" size="1">
				<option value="0">选择直播流</option>
				@foreach($stream as $v)
				<option value="{{$v->id}}">{{$v->stream_name}}</option>
				@endforeach
			</select>
			</span> </div>
	</div>	
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开始时间：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input name="start_time" class="datainp wicon" id="date01" type="text" placeholder="YYYY-MM-DD hh:mm:ss" value=""  readonly>
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>结束时间：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<input name="end_time" class="datainp wicon" id="date02" type="text" placeholder="YYYY-MM-DD hh:mm" value=""  readonly>
		</div>
	</div>

	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>封面图：</label>
		<div class="formControls col-xs-8 col-sm-9">
					<!--用于上传成功后显示图片的-->
			        <div id="fileList" class="uploader-list"></div>
			        <input type="text" readonly="readonly" class="input-text" value="" placeholder="" id="cover_img"  name="cover_img">
			        <div id="a">
			        	<div class="b" style="width: 700px;">
			        		<span class="sr-only" style="width: 0%"></span>
			        	</div>
			        </div>
			        <!--上传按钮-->
					<div id="filePicker">选择图片</div>
		</div>
	</div>
	
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">描述：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="live_desc" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="$.Huitextarealength(this,100)"></textarea>
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
	</form>
</article>

<!--_footer 作为公共模版分离出去--> 
<script type="text/javascript" src="{{asset('admins')}}/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="{{asset('admins')}}/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="{{asset('admins')}}/static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="{{asset('admins')}}/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('admins')}}/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="{{asset('admins')}}/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="{{asset('admins')}}/lib/jquery.validation/1.14.0/messages_zh.js"></script> 
<script type="text/javascript" src="{{asset('admins')}}/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="{{asset('admins')}}/jedate/jquery.jedate.js"></script>
<script type="text/javascript">
$(function(){
		$("#date01").jeDate({
		    isinitVal:true,
		    //festival:true,
		    ishmsVal:false,
		    minDate: '2018-01-01 23:59:59',
		    maxDate: '2019-06-16 23:59:59',
		    format:"YYYY-MM-DD hh:mm:ss",
		    zIndex:3000,
		})
		$("#date02").jeDate({
		    isinitVal:true,
		    //festival:true,
		    ishmsVal:false,
		    minDate: '2018-01-01 23:59:59',
		    maxDate:'2019-06-16 23:59:59',
		    format:"YYYY-MM-DD hh:mm:ss",
		    zIndex:3000,
		})





		var uploader = WebUploader.create({
		//选择图片按钮后，就立即上传
		auto: true,
		//加载一个小资源文件
		swf: '{{asset("admins")}}/lib/webuploader/0.1.5/Uploader.swf',
	
		//用于指定处理上传文件的页面（此处就写路由）
		server: '{{url("admin/lesson/upimage")}}',
	
		// 选择文件的按钮。可选。
		// 表示把id=filePicker的元素当成上传按钮
		pick: '#filePicker',
	
		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false,
		// 只允许选择图片文件。
		accept: {
			title: '图片上传',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		},
		formData:{
			'_token':'{{csrf_token()}}'
		}
	});
	//文件上传成功后的处理
	uploader.on( 'uploadSuccess', function( file,data) {
		//data就是处理上传的文件中，返回的json格式的数据，
		$("#cover_img").val(data.info);
		//在div里面，显示上传图片
		$("#fileList").html("<img width='150' src='"+data.info+"'/>");
		$("#a .sr-only").hide();

	});
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
		
		$("#a .sr-only").css( 'width', percentage * 100 + '%' );
	});

	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	$("#form-admin-add").submit(function(e){
		//阻止表单的默认提交
		e.preventDefault();
		//准备提交的数据
		var data = $(this).serialize();//获取表单里面的数据，
		//ajax的提交
		$.ajax({
			type:'post',
			url:"{{url('admin/livecourse/add')}}",
			data:data,
			dataType:'json',
			success:function(msg){
				//判断是否入库成功
				if(msg.info==1){
					layer.alert('添加成功',function(){
						//添加成功，（1）列表页面重新请求（2）关闭添加课时的窗口
						//parent.mytable.api().ajax.reload();
						parent.window.location.href = parent.window.location.href;
						layer_close();
					});
				}else {
					//添加失败
					layer.msg('添加失败:'+msg.error,{icon: 5,time:5000});
				}
			}
		});

	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>