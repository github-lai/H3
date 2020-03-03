<?php

namespace Auth;
use Lib;
use Lib\IBase as LI;


class AdminAuth implements LI\IAuth
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