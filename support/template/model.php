<?php
namespace Model;
use Lib;

class User extends Lib\DbBase{
	function __construct(){
		$this->setName('[#tbname#]'); 
	}

	function get($iid)
	{
		return $this->where("`iid`=$iid")->select();
	}

	function getlist($start,$ps)
	{
		return $this->where("`iid`>0")->desc("iid")->limit($start,$ps)->page();
	}

    function save()
	{
		$arr = array("userpass"=>$pass);

		return $this->where("`iid`=$iid")->kv($arr)->update();
	}


	function add()
	{
		$arr = array();

		$iid = $this->kv($arr)->add();
		return $iid;
	}

	function remove($ids)
	{
		if($this->where("`iid` in('".$ids."')")->remove()){
			return "1";
		}else{
			return "0";
		}
	}

} 

?>