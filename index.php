<?php
header("Content-type: text/html; charset=utf-8");
define("ROOTDIR",dirname(__FILE__)."/");
define("ENV","dev");
define("SPACE","usr");

if(ENV != "live"){
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}else{
	error_reporting(0);//不显示错误
}
ini_set("short_open_tag","On");

require_once "lib/Loader.php";
require_once "lib/Helper.php";

Loader::autoload();
Lib\Config::init(ROOTDIR."inc/config.ini");

Lib\Config::set("module",array("admin"));//注：模块名不能使用public这样的关键字
Lib\Config::set("tplext",".htm");//摸板的后缀设置
/*
认证器配置
优先级依次为 1=action,2=controller,3=module
*/
Lib\Config::set("authpath",array("Admin" => "AdminAuth"));

Lib\Router::dispatch();

?>
