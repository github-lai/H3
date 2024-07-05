<?php
namespace Ctrl\H3;
use Lib;
use Model;

class Base extends Lib\CtrlBase{
	public $helper = null;

	function __construct(){
		$this->set("_root",Lib\Config::get("root"));
		$this->set("_cfgurl", Lib\Config::get("url"));
	}

	function IsLogin()
	{
		$html = "";
		if(Lib\Auth::check("admin")){
			$arr = Lib\Auth::get("admin");
			$html  =  $arr["username"].' <a href="@admin/welcome" style="color:yellow;">用户中心</a> <a href="base/logout" style="color:yellow;">退出</a>';
		}else{
			$html  = '<a href="login" style="color:yellow;">登录</a>';
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
		Lib\Auth::remove("admin");
		return $this->redirect(Lib\Config::get("url")."home/index");
	}

}

?>