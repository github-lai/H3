<?php
namespace Lib;

class Config{
	
	private static $config = null;
	
	static function init($file)
	{
		if(self::$config == null){
			self::$config = parse_ini_file($file,true);//linux正常
		}
	}

	static function get($key)
	{
		return self::$config[ENV][$key];
	}
	
	static function set($key,$val)
	{
		self::$config[ENV][$key] = $val;
	}
	
}

?>