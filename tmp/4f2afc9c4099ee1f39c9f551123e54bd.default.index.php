<?php
$_root = $this->vars["_root"];
$_cfgurl = $this->vars["_cfgurl"];
$say = $this->vars["say"];

?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<base href="<?php echo $_cfgurl; ?>"/>
		<link rel="shortcut icon" href="favicon.ico">
		
		<title>首页</title>
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
		
	<div class="row">
		<div class="col-sm-12" style="">
			<div class="panel panel-default">
			  <div class="panel-body text-center" style="background:#006699;color:white;padding:50px;">

				<h2><?php echo $say; ?> Helper</h2>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading" >高效开发</div>
			  <div class="panel-body text-center" style="padding:30px;font-size:18px;">
				网络应用高效率开发
			  </div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading" >易于维护</div>
			  <div class="panel-body text-center" style="padding:30px;font-size:18px;">
				代码简洁优雅 可读性强
			  </div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading" >性能</div>
			  <div class="panel-body text-center" style="padding:30px;font-size:18px;">
				接近原生PHP的执行性能
			  </div>
			</div>
		</div>


	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading" >Demo实例</div>
			  <div class="panel-body" style="">
			  请先配置好inc目录下的数据库连接信息，然后执行以下sql语句创建必要的实例数据表。
<div>
<br/>CREATE DATABASE `test` /*!40100 DEFAULT CHARACTER SET utf8 */;<br/>
use `test`;<br/>
CREATE TABLE `user` (<br/>
  `iid` int(11) NOT NULL AUTO_INCREMENT,<br/>
  `username` varchar(45) DEFAULT NULL,<br/>
  `userpass` varchar(45) DEFAULT NULL,<br/>
  PRIMARY KEY (`iid`)<br/>
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;<br/><br/>
</div>
			  </div>
			</div>
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
		$(document).ready(function(){
			setOn(0);
		});
	</script>

</body>
</html>

