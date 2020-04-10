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
Lib\Loader::init();
Lib\Router::dispatch();

?>
