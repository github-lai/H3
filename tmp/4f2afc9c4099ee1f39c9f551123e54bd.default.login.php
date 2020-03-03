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
		
	<title>登录</title>
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
			<img src="res/images/h3.png" style="">
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
		


	<div class="row" style="">
		<div class="col-sm-8"><img src="res/images/8.jpg" style="width:100%;"></div>
		<div class="col-sm-4" style="padding:30px;background:#fff;line-height:30px;border:solid 1px #ccc;">

		<form onsubmit="return false">
			<table class="logtab" cellpadding="0" cellspacing="15" align="center" style="">
				<tr>
					<td>用户名：<br/><input type="text" class="form-control" id="username" value="admin" size="20"></td>
				</tr>
				<tr>
					<td>密 码：<br/><input type="text"  class="form-control"  id="userpass" value="admin" size="20"></td>
				</tr>
				<tr>
					<td>验证码：<br/>
					<input type="text" id="vcode"  class="form-control" style="width:80px;float:left;" value="" size="6">
					<img src="base/vcode" align="middle" style="float:left;margin-left:10px;" onclick="this.src='base/vcode?a='+new Date().getTime()">
					</td>
				</tr>
				<tr>
					<td><a href="javascript:void(0)" onclick="return submit()" class="btn btn-primary" style="margin-top:25px;">登录</a></td>
				</tr>
			</table>
		</form>

		</div>
	</div>

	<hr/>
	CopyRight @ Helper 2019


	</section>

	</div>

	<script src='res/script/jquery-2.0.3.min.js'></script>
	<script src='res/script/bootstrap.min.js'></script>
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
		function submit()
		{
			var username = $("#username").val();
			var userpass = $("#userpass").val();
			var vcode = $("#vcode").val();
			$.post("login/submit",{username:username,userpass:userpass,vcode:vcode},function(data){
				if(data == "1"){
					layer.alert("登录成功，即将跳转");

					setTimeout(function(){
						location.href = "admin/welcome";
						},2000);
				}else{
					layer.alert("登录失败，"+data);
				}
			});
			return false;
		}
		$(document).ready(function(){

		});
	</script>


</body>
</html>

