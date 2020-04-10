<?php
$_root = $this->vars["_root"];
$_cfgurl = $this->vars["_cfgurl"];

?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<base href="<?php echo $_cfgurl; ?>"/>
		<link rel="shortcut icon" href="favicon.ico">
		

		<title>关于</title>
		<style type="text/css">

		</style>

		<link href="res/css/bootstrap.min.css" rel="stylesheet" />
		<style type="text/css">
			.menu{ display:inline-block;}
			.menu li{ list-style:none; display:inline-block;}
			.menu li a{ text-decoration:none;color:white; font-size:14px;display:block; height:45px; padding:0 15px;}
			.menu li a:hover{ text-decoration:none;color:green; background:#eee; font-weight:bold; }
			.menu li a.on{ text-decoration:none;color:green; background:#eee; font-weight:bold; }
		</style>
	</head>

	<body>
	<div class="top" style="background:#006699;height:45px;margin-bottom:15px;line-height:45px;color:white;">
		<div class="container" style="padding:0!important;">
			<font size='4'>Welcome H3 framework</font>
			<ul class="menu">
			<li><a href="<?php echo $_cfgurl; ?>">首页</a></li>
			<li><a href="<?php echo $_cfgurl; ?>home/users">列表</a></li>
			<li><a href="<?php echo $_cfgurl; ?>home/about">关于</a></li>
			</ul>
			<span class="htop" id="toplink" style="float:right;color:white;">
			</span>
		</div>
	</div>

	<div class="container" style="position:relative;">

	<section class="row mcontent">
		
	<div class="row">
		<div class="col-sm-12" style="">
			<div class="panel panel-default">
			  <div class="panel-body " style="background:#006699;color:white;padding:50px;">

		路由重写、请求分发、MVC分层设计、数据库类高效封装、命名空间、Autoload、PHP方法高效运用、N种缓存、权限认证、Linux和Windows系统兼容、开发部署多环境兼容布局、请求周期、数据类封装、单例模式、接口规范.....如果你也对这些技术感兴趣，欢迎加入Helper的有趣世界！

			  </div>
			</div>
		</div>
	</div>

	<hr/>
	CopyRight @ Helper 2019


	</section>

	</div>

	<script src='res/js/jquery-2.0.3.min.js'></script>
	<script src='res/js/bootstrap.min.js'></script>
	<script src='res/layer/layer.js'></script>
	

	<script type="text/javascript">
		function setOn(index)
		{
			$(".menu li a").removeClass("on");
			$(".menu li:eq("+index+") a").addClass("on");
		}
		$(document).ready(function(){
			$.get("base/islogin",function(data){
				$("#toplink").html(data);
			});
		});
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			setOn(2);
		});
	</script>

</body>
</html>

