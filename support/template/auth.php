<?php

namespace Auth;
use Lib;

class [#name#] implements Lib\IBase\IAuth
{
	static function valid($act)
	{
		return true;
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