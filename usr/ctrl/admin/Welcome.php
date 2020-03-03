<?php

namespace Ctrl\Admin;
use Lib;
use Model\Helper as MH;
use Model\Tb as MT;

class Welcome extends Base
{

	function Index()
	{
		return $this->view("Welcome");
	}


}  

?>