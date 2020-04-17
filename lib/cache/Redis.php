<?php
namespace Lib\Cache;
use Lib;
use Lib\IBase;

//说明(centos)：
//1，关闭selinux
//2，注意防火墙，别档了6379端口
//3，redis.conf注释掉 bind 127.0.0.1（如果需要让其他机器可以连接的话）
//4，redis.conf设置protected-mode no

class Redis implements IBase\ICache{

	private static $instance = null;
	private static $version = null;

	function __construct(){
		if(self::$instance == null){

			$rediscfg = Lib\Config::get("redis");
			if(class_exists('Redis',false)){
				self::$instance = new \Redis();
				self::$instance->connect($rediscfg["host"], $rediscfg["port"]);
			}else{
				die("Redis not found");
			}
		}

		if(self::$version == null){
			$cc = Lib\Config::get("cache");
			$ver = $cc["version"];
			self::$version = $ver;
		}
	}

	public function prefix($key)
	{
		$key = "h3_".self::$version."_".md5($key);
		return $key;
	}

	//设置
	public function set($key,$val,$seconds)
	{
		return self::$instance->set($this->prefix($key),$val,$seconds);
	}
	
	//删除
	public function del($key)
	{
		return self::$instance->delete($this->prefix($key)); 
	}

	//判断
	public function haskey($key)
	{
		return false;//暂时没有该方法
	}

	//读取
	public function get($key)
	{
		return self::$instance->get($this->prefix($key));
	}

	public function clear()
	{
		self::$instance->flush();
	}
}