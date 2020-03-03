<?php

namespace Ctrl;
use Lib;
use Model;
use Model\Helper as MH;

class Login extends Base
{

	function Index()
	{
		return $this->view("Login");
	}

	function Submit()
	{
		$msg = "";
		session_start();
		$username = $_POST["username"];
		$userpass = $_POST["userpass"];
		$vcode = $_POST["vcode"];
		if(strtolower($vcode) != strtolower($_SESSION["vcode"]))
		{
			$msg = "0-验证码不正确";
		}else{
			$user = new Model\User();

			$models =  $user->getuser($username,$userpass);

			if(count($models) > 0)
			{
				$m = $models[0];
				$_SESSION["admin"] = array(
					"userid"=>$m->iid(),
					"username"=>$m->username());
				$msg = "1";
			}else{
				$msg = "0-用户名或密码错误";
			}
		}

		return $msg;
	}
	
	function ResetPass()
	{
		$iid = $_POST["iid"];
		$pass =  $_POST["pass"];

		$user = new User();
		$user->save($iid,$pass);
		
		return $this->redirect("home/index");
	}
}  

?>