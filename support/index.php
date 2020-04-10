<?php include('include/header.php');?>

<div class="row">
	<div class="col-sm-12"><h5>用web的方式解决web的问题</h5></div>
	<div class="col-sm-12"><h3>用php的方式解决php的问题</h3></div>
	<div class="col-sm-6">
		<form class="form-inline">
		   <div class="input-group">
			  <input type="text" name="area" id="area" class="form-control" placeholder="请输入名称">
			  <span class="input-group-btn">
				<button class="btn btn-success" type="button" onclick="addArea()">创建域</button>
			  </span>
			</div>
		   <div class="input-group" style="margin-top:15px;">
			  <input type="text" name="controller" id="controller" class="form-control" placeholder="请输入名称">
			  <span class="input-group-btn">
				<button class="btn btn-success" type="button" onclick="addController()">创建控制器</button>
			  </span>
			</div>
		   <div class="input-group" style="margin-top:15px;">
			  <input type="text" name="auth" id="auth" class="form-control" placeholder="请输入名称">
			  <span class="input-group-btn">
				<button class="btn btn-success" type="button" onclick="addAuth()">创建认证器</button>
			  </span>
			</div>
		   <div class="input-group" style="margin-top:15px;">
			  <input type="text" name="model" id="model" class="form-control" placeholder="请输入名称">
			  <span class="input-group-btn">
				<button class="btn btn-success" type="button" onclick="addModel()">创建Model</button>
			  </span>
			</div>
		</form>

		halo
	</div>
</div>

<script type="text/javascript">
		function addArea()
		{
			var name = $("#area").val();
			$.post("area.php",{act:'addnew', name:name},function(data){
				if(data == 'success'){
					layer.alert('创建成功');
				}else{
					layer.alert(data);
				}
			});
		}

		function addController()
		{
			var name = $("#controller").val();
			$.post("controller.php",{act:'addnew', name:name},function(data){
				if(data == 'success'){
					layer.alert('创建成功');
				}else{
					layer.alert(data);
				}
			});
		}

		function addAuth()
		{
			var name = $("#auth").val();
			$.post("auth.php",{act:'addnew', name:name},function(data){
				if(data == 'success'){
					layer.alert('创建成功');
				}else{
					layer.alert(data);
				}
			});
		}

		function addModel()
		{
			var name = $("#model").val();
			$.post("model.php",{act:'addnew', name:name},function(data){
				if(data == 'success'){
					layer.alert('创建成功');
				}else{
					layer.alert(data);
				}
			});
		}

		$(document).ready(function(){

		});
</script>
<?php include('include/footer.php');?>

