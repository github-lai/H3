<?php
namespace Lib;

class Http
{
	public 	$status = array(
		200 => 'OK',
		301 => 'Moved Permanently',
		302 => 'Moved Temporarily ',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		403 => 'Forbidden',
		404 => 'Not Found',
		500 => 'Internal Server Error',
		503 => 'Service Unavailable',
	);

	function __construct($code, $msg){
		header("HTTP/1.1 $code");
		trigger_error($msg , E_USER_ERROR);
	}

}

?>