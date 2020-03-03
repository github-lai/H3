<?php
namespace Lib;
/*
控制器基类
规则：大写字母开头的都是action否则是普通方法
原则：基类不直接处理http请求，仅辅助action处理http请求
*/
class CtrlBase
{
    public $tags = array();
    public $vals = array();
    public $vars = array();
    public $module = "";
    public $controller = "";
    public $tpl = "";

	function __construct(){

	}

	function __call($name,$args) {
		new Http(404,"Action '$name' not found");
	}

	function setModule($module)
	{
		$this->module = $module;
	}

	function setController($controller)
	{
		$this->controller = $controller;
	}

	function setTpl($tpl)
	{
		$this->tpl = $tpl.Config::get("tplext");
	}
	
	function set($key, $val)
	{
		//检查key是否存在
		if(in_array($key, array_keys($this->vars))){
			new Error($key."重复赋值(".$this->vars[$key].")(".$val.")");
		}else{
			$this->vars[$key] = $val;
		}
	}

	function redirect($path) 
	{
		header("location: $path");
		return;
	}

	function action($path) 
	{
		$path = Config::get("root")."/".$path;
		header("location: $path");
		return;
	}

	function tpltmp($module,$tpl)
	{
		$name = strtolower("4f2afc9c4099ee1f39c9f551123e54bd.$module.$tpl.php");//缓存文件名
		$file = ROOTDIR."tmp/$name";
		return $file;
	}

	function view($tpl,$layout) 
	{
		if($tpl == "")
		{
			$tpl = "Index";//默认摸板
		}

		$module = $this->module;
		if($module == "")
		{
			$module = "default";//摸板默认分组
		}

		$file = $this->tpltmp($module, $tpl);
		$setting = Config::get("cache");
		if($setting["tpl"] == "true"){
			if(!file_exists($file)){
				$this->build($module, $tpl, $layout);
			}else{
				if(filemtime($file) <= time()){
					$this->build($module, $tpl, $layout);
				}
			}
		}else{
			$this->build($module, $tpl, $layout);
		}
		//echo $file;exit;
		include $file;
	}

	function build($module,$tpl,$layout)
	{
		$ext = Config::get("tplext");
		$tplfull = $tpl.$ext;

		//判断view是否存在
		$viewfile = ROOTDIR.SPACE."/tpl/".strtolower($module)."/".$tplfull;
		if(!file_exists($viewfile)){
			return "找不到模板文件".$tplfull;
		}

		$content = file_get_contents($viewfile, "r");
		
		if($layout !== false){
			$layoutname = ($layout == null ? "_Layout" : $layout);
			$masterfile = ROOTDIR.SPACE."/tpl/".strtolower($module)."/".$layoutname.$ext;//在linux下大小写敏感，注意了
			//echo $masterfile;
			$tmp = file_get_contents($masterfile,"r");
			preg_match_all('|<container([^>]*?)/>|U',$tmp, $result, PREG_PATTERN_ORDER);
			//print_r($result);exit;
			foreach($result[1] as $item)
			{
				$id = str_replace(['id=','"',' '],['','',''],$item);
				preg_match("|<container(\s+id=\"\s*?$id\s*?\")>([\w\W]*)</container>|U",$content, $arr);
				if(isset($arr[0])){
					$tmp = str_replace("<container$item/>",$arr[2],$tmp);
					$content = str_replace($arr[0],"",$content);
				}else{
					$tmp = str_replace("<container$item/>","",$tmp);
				}
			}
			if(trim($content) != "")
			{
				//$content = htmlentities($content);
				//die("无法解析{$tpl}模板内容<font color='red'>'$content'</font>");
			}
			$final = $tmp;
		}else{
			$final = $content;
		}
		$eg = new Engine;

		$head = "<?php\r\n";
		foreach($this->vars as $key=>$val)
		{
			$head .= '$'."$key = ".'$this->vars'."[\"$key\"];\r\n";
		}
		$head .= "\r\n?>\r\n";

		$final = $eg->compile($final);
		$final = $head.$final;

		$file = $this->tpltmp($module, $tpl);
		file_put_contents($file, $final, LOCK_EX);
		$setting = Config::get("cache");
		$seconds = intval($setting["tplexpire"]);
		@touch($file, time() + $seconds);
	}

}

?>