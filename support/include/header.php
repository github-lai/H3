<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<style type="text/css">
			.menu{ display:inline-block;}
			.menu li{ list-style:none; display:inline-block;}
			.menu li a{ text-decoration:none;color:white; font-size:14px;display:block; height:45px; padding:0 15px;}
			.menu li a:hover{ text-decoration:none;color:green; background:#eee; font-weight:bold; }
			.menu li a.on{ text-decoration:none;color:green; background:#eee; font-weight:bold; }
		</style>
		<script src='js/jquery-2.0.3.min.js'></script>
		<script src='js/bootstrap.min.js'></script>
		<script src='js/layer/layer.js'></script>
	</head>

	<body>
	<div class="top" style="background:#006699;height:45px;margin-bottom:15px;line-height:45px;color:white;">
		<div class="container" style="padding:0!important;">
			<font size='4'>H3开发助手</font>
			<ul class="menu">
			<li><a href="index.php">关于</a></li>
			<li><a href="{$_cfgurl}">控制器管理</a></li>
			<li><a href="{$_cfgurl}home/users">认证器管理</a></li>
			</ul>
		</div>
	</div>

	<div class="container" style="position:relative;">

	<section class="row mcontent">