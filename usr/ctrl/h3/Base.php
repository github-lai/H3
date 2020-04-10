<?php
namespace Ctrl\H3;
use Lib;
use Model;
use Model\Helper as MH;

class Base extends Lib\CtrlBase{
	public $helper = null;

	function __construct(){
		$this->set("_root",Lib\Config::get("root"));
		$this->set("_cfgurl", Lib\Config::get("url"));
	}

	function IsLogin()
	{
		$html = "";
		session_start();
		if(!isset($_SESSION["admin"])){
			$html  = '<a href="login" style="color:yellow;">登录</a>';
		}else{
			$html  =  $_SESSION["admin"]["username"].' <a href="@admin/welcome" style="color:yellow;">进入用户中心</a>'.' <a href="base/logout" style="color:yellow;">退出</a>';
		}
		return $html;
	}

	//验证码
	function Vcode()
	{
		$an = new Lib\Captcha(); 
		$an->create("vcode");
		return;
	}

	function Logout()
	{
		session_start();
		session_destroy();
		return $this->redirect(Lib\Config::get("url")."home/index");
	}

}

?>