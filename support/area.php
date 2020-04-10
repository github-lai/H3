<?php include('include/common.php');?>

<?php

$name = $_POST['name'];
$act = $_POST['act'];

if($name == ''){
	die('域名称不能为空');
}
if($act == ''){
	die('您要执行什么操作?');
}

switch($act)
{
	case 'addnew':
		addnew($name);
		break;
}


function addnew($name)
{

	$ctrl = ROOTDIR.SPACE.'/ctrl/'.strtolower($name);
	if(is_dir($ctrl)){
		die("ctrl域文件夹 $ctrl 已经存在了");
	}
	mkdir($ctrl);

	$tpl = ROOTDIR.SPACE.'/tpl/'.strtolower($name);
	if(is_dir($tpl)){
		die('tpl域文件夹 $tpl 已经存在了');
	}

	mkdir($tpl);

	echo 'success';
}

function remove($name)
{

	$ctrl = ROOTDIR.SPACE.'/ctrl/'.strtolower($name);
	if(is_dir($ctrl)){
		die("ctrl域文件夹 $ctrl 已经存在了");
	}
	mkdir($ctrl);

	$tpl = ROOTDIR.SPACE.'/tpl/'.strtolower($name);
	if(is_dir($tpl)){
		die('tpl域文件夹 $tpl 已经存在了');
	}

	mkdir($tpl);

	echo 'success';
}


?>