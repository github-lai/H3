<?php
header("Content-type: text/html; charset=utf-8");
ini_set("short_open_tag","On");
date_default_timezone_set('Asia/Shanghai');
define("ROOTDIR",dirname(__FILE__)."/");
define("ENV","dev");

if(ENV != "live"){
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}else{
	error_reporting(0);//display nothing online
}

require 'vendor/autoload.php';

Lib\Loader::init();
Lib\Router::dispatch();

?>
