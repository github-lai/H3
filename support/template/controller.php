<?php

namespace Ctrl\[#areaname#];
use Lib;
use Model;

class [#ctrlname#] extends Base
{

	function Index()
	{
		$this->set("say","[#ctrlname#]!!");
		return $this->view('Index',false);
	}

}  

?>