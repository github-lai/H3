<?php
header("Content-type: text/html; charset=utf-8");
ini_set("short_open_tag","On");
date_default_timezone_set('Asia/ShangHai');
define("ROOTDIR",dirname(__FILE__)."/");
define("ENV","dev");
define("SPACE","usr");

if(ENV != "live"){
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}else{
	error_reporting(0);//display nothing online
}

require_once "lib/Loader.php";
Lib\Loader::init();
Lib\Router::dispatch();

?>
