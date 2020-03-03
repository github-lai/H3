<?php
namespace Lib\Cache;
use Lib;
use Lib\IBase;

class MemCache implements IBase\ICache{
	//研究memcache的过程中经历了被selinux阻止访问的痛苦，
	//原来一直在怀疑memcache，libmemcached，php-memcached的版本不对应导致的，经过一系列的监控和日志的查看等分析调试失败后
	//最终在2019.09.03找到selinux这个罪魁祸首
	private static $instance = null;
	private static $version = null;

	function __construct(){
		if(self::$instance == null){

			$memcfg = Lib\Config::get("memcache");
			if(class_exists('Memcached',false)){
				//这是09年出的php的拓展，一直有人维护，这是网友推荐的
				self::$instance = new \Memcached;//这个反斜杠很重要

				//这里可以做一些基础配置
				//self::$instance->setOption(\Memcached::OPT_REMOVE_FAILED_SERVERS, true);
				//self::$instance->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 10);
				//self::$instance->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
				//self::$instance->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, 4);//失败的次数超过了这个，该服务器就会被连接池移除
				//self::$instance->setOption(\Memcached::OPT_RETRY_TIMEOUT, 1);
				self::$instance->addServer($memcfg["host"], $memcfg["port"]);
			}else if(class_exists('Memcache',false)){
				//这是04年php出的扩展，好久没有人维护了
				self::$instance = new \Memcache;//这个反斜杠很重要
				self::$instance->addServer($memcfg["host"], $memcfg["port"]) or die("addserver失败");
				//之所以注释下面的语句是因为connect只能连接一台服务器和端口，
				//使用addserver可以允许分布式的多台服务器和端口，这是网友建议的
				//self::$instance->connect($memcfg["host"], $memcfg["port"]) or die("connect失败");
				//$status = self::$instance->getStats();
			}else{
				die("Memcache not found");
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