<?php
header("Content-type: text/html; charset=utf-8");

define("ROOTDIR",dirname(__FILE__)."/");
define("ENV","dev");

require 'vendor/autoload.php';

Lib\Loader::init();
Lib\Router::dispatch();

?>
