<?php
namespace Lib;

class Cache{  
		
	private static $instance = null;

	static function one(){
		if(self::$instance == null){
			$cfg = Config::get("cache");
			switch($cfg["type"])
			{
				case "memcache":
					self::$instance = new Cache\MemCache();
					break;
				case "redis":
					self::$instance = null;
					break;
				case "filecache":
					self::$instance = new Cache\FileCache();
					break;
				case "nocache":
					self::$instance = new Cache\NoCache();
					break;
			}
		}
		return self::$instance;
	}
		
}  

?>