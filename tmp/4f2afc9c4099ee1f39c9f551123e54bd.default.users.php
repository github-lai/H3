<?php
$_root = $this->vars["_root"];
$_cfgurl = $this->vars["_cfgurl"];
$list = $this->vars["list"];
$pager = $this->vars["pager"];

?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<base href="<?php echo $_cfgurl; ?>"/>
		<link rel="shortcut icon" href="favicon.ico">
		

		<title>用户列表</title>
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
			  <div class="panel-heading">用户列表 <a href="javascript:void(0)" onclick="addnew()">添加</a></div>
			  <div class="panel-body " style="">

			  <table class='table'>
			  <tr>
				  <th>编号</th>
				  <th>用户名</th>
				  <th>用户名长度</th>
				  <th>用户名截取</th>
				  <th>用户密码</th>
				  <th>操作</th>
			  </tr>
			  <?php foreach($list as $item){ ?>
			  <tr>
				<td><?php echo $item->iid(); ?></td>
				<td><?php echo $item->username(); ?> </td>
				<td><?php echo strlen($item->username()) ?> </td>
				<td><?php echo Lib\Helper::cubstr($item->username(),0,3) ?> </td>
				<td><input type='text' id='up<?php echo $item->iid(); ?>' value='<?php echo $item->userpass(); ?>'></td>
				<td>
				<a href='javascript:void(0)' onclick='modify(<?php echo $item->iid(); ?>)'>修改</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='javascript:void(0)' onclick='remove(<?php echo $item->iid(); ?>)'>删除</a></td>
			  </tr>
			  <?php } ?>
			  </table>

			  <ul class="pagination">
				<li><a href="home/users?page=1">首页</a></li>
				<li><a href="home/users?page=<?php echo $pager->prev; ?>">上一页</a></li>
				<li><a href="home/users?page=<?php echo $pager->next; ?>">下一页</a></li>
				<li><a href="home/users?page=<?php echo $pager->totalpages; ?>">尾页</a></li>
				<li>
					<select class="form-control" style="width:80px;float:left;border-left:none;border-radius:0;" onchange="location.href='home/users?page='+this.value">
						<?php for($i=1;$i <=$pager->totalpages;$i++) { ?>
						<option value="<?php echo $i; ?>" <?php echo $i==$pager->cur?'selected':''; ?>>第<?php echo $i; ?>页</a>
						<?php } ?>
					</select>
				</li>
				<li><span> 共 <?php echo $pager->totalpages; ?> 页 / <?php echo $pager->total; ?>条记录 </span></li>
			  </ul>
				
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
		function addnew()
		{
			$.post("home/adduser/",null,function(data){
				if(data > 0)
				{
					location.reload();
				}else{
					layer.alert("添加失败");
				}
			});
		}
		function modify(id)
		{
			var pass = $("#up"+id).val();
			$.post("home/modify/"+id,{ pass:pass},function(data){
				if(data == "1")
				{
					layer.alert("修改成功");
				}else{
					layer.alert("修改失败");
				}
			});
		}

		function remove(id)
		{
			layer.confirm('确定要删除该记录吗？', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				location.href = "home/remove/"+id;
			}, function(){
			  layer.close();
			});
		}

		$(document).ready(function(){
			setOn(1);
		});
	</script>

</body>
</html>

