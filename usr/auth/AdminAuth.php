<?php

namespace Auth;
use Lib;

class AdminAuth implements Lib\IBase\IAuth
{
	static function valid($act)
	{
		session_start();
		return isset($_SESSION["admin"]);
	}
	
	static function allow()
	{
		return;
	}

	static function deny()
	{
		$path = Lib\Config::get("url")."login";
		header("location: $path");
	}


}

?>