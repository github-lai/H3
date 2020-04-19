<?php

namespace Auth;
use Lib;

class AdminAuth implements Lib\IBase\IAuth
{
	static function valid($act)
	{
		return Lib\Auth::check("admin");
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