<?php
namespace Lib;

class Engine
{
	public $tagl = '{$';
	public $tagr = '}';
	
	function __construct(){
	}

	function compile(&$str)
	{
		//Helper::runtime(0);
		$final = $this->tran_preg($str);
		//$final = $this->tran_char($str);
		//echo Helper::runtime(1);exit;
		return $final;
	}

	function tran_preg(&$str)
	{
		preg_match_all('/{[^ ][^\n][\s\S]*?}/',$str, $arr, PREG_PATTERN_ORDER);
		
		$replace = array();
		foreach($arr[0] as $item)
		{
			$replace[] = $this->convert($item);
		}
		$str = str_replace($arr[0],$replace,$str);

		return $str;
	}
	
	//在windows测试发现该方法比tran_preg慢了30倍
	function tran_char(&$str)
	{
		$result = "";
		$var = "";

		$sig = array('{'=>0,'$'=>0,'}'=>0);
		for($i=0; $i<strlen($str); $i++)
		{
			$c = $str[$i];
			switch($c)
			{
				case '{':
					if($sig['{'] == 1){
						//echo $var;exit;
						$result .= $var;
						$var = '{';
					}else{
						$sig['{'] = 1;
						$var .= '{';
					}
					break;
				case '$':
					if($sig['{'] = 1){
						$var .= '$';
					}else{
						$result .= "$";
					}
					break;
				case '}':
					$var .= '}';
					$sig['{'] = 0;
					$result .= $this->convert($var);
					$var = "";

					break;
				default:
					if($sig['{'] == 1){
						$var .= $c;
					}else{
						$result .= $c;
					}
					break;
			}
		}

		return $result;
	}

	function convert($var)
	{
		$arr = array(
			'{$'=>'do_var',
			'{if'=>'do_if',
			'{else}'=>'do_else',
			'{elseif'=>'do_elseif',
			'{for('=>'do_for',
			'{foreach'=>'do_foreach',
			'{org.'=>'do_org',
			'{helper.'=>'do_helper',
			'{end}'=>'do_end');

		$key = "";
		$keys = array_keys($arr);
		for($i=0; $i<10; $i++)
		{
			$key .= $var[$i];
			if($i > 0){
				if(in_array($key,$keys))
				{
					return $this->{$arr[$key]}($var);
				}
			}
		}
		return "{$var}";
	}

	function do_var($var)
	{
		$var = ltrim($var,"{");
		$var = rtrim($var,"}");
		return '<?php echo '.$var.'; ?>';
	}

	function do_if($var)
	{
		$var = ltrim($var,"{if");
		$var = rtrim($var,"}");
		return '<?php if '.$var.' { ?>';
	}

	function do_else($var)
	{
		return "<?php }else{ ?>";
	}

	function do_elseif($var)
	{
		$var = ltrim($var,"{elseif");
		$var = rtrim($var,"}");
		return '<?php }elseif '.$var.' { ?>';
	}

	function do_for($var)
	{
		$var = ltrim($var,"{");
		$var = rtrim($var,"}");
		return '<?php '.$var.' { ?>';
	}
	
	function do_foreach($var)
	{
		$var = ltrim($var,"{");
		$var = rtrim($var,"}");
		return '<?php '.$var.'{ ?>';
	}

	function do_org($var)
	{
		$var = ltrim($var,"{org.");
		$var = rtrim($var,"}");
		return '<?php echo '.$var.' ?>';
	}

	function do_helper($var)
	{
		$var = ltrim($var,"{helper.");
		$var = rtrim($var,"}");
		return '<?php echo Lib\Helper::'.$var.' ?>';
	}

	function do_end($var)
	{
		return "<?php } ?>";
	}

}

?>