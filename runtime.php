<?php
	function support($func)
	{
		echo function_exists($func) ? "<font color='green'>$func</font><br />":"<font color='red'>$func NOT SUPPORT</font><br />";
	}
	support('preg_match_all');
?>