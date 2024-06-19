<?php 

class A
{
	public $s = "A";
}

function seta($a)
{
	//$a->s = "function";
	$a = "BB";
}
$a = new A();
$a = "KK";
seta($a);
echo $a;
?>