<?php

namespace Ctrl;
use Lib;
use Model\Helper as MH;
use Model\Tb as MT;

class Article extends Base
{

	function Detail($iid)
	{
		$yy = array("学而时习之，不亦说乎");
		$cate = new MT\TbCategory();
		$art = new MT\TbArticle();
		$small = new MT\TbArt();
		$artcount = new MT\TbArtcount();
		$artps = new MT\TbArtps();
		$user = new MT\TbUser();
		$topic = new MT\TbTopic();

		$model = $art->get($iid);
		if($model == null){
			return "参数错误";
		}
				
		$result = $small->getPrevNext($iid);
		$prev = "上一篇：没有了";
		$next = "下一篇：没有了";

		if($result["prev"] != null){
			$item = $result["prev"];
			$prev = "上一篇：<a style='color:#006699;' href='".$this->helper->artHref($item->getIid())."'>".$item->getTitle()."</a>";
		}
		if($result["next"] != null){
			$item = $result["next"];
			$next = "下一篇：<a style='color:#006699;' href='".$this->helper->artHref($item->getIid())."'>".$item->getTitle()."</a>";
		}

		$this->set("prev",$prev);
		$this->set("next",$next);

		$count = $artcount->get($iid);
		$comment = intval($count->getComment());
		$read = intval($count->getRead());
		
		$this->set("comment",$comment);
		$this->set("read",$read);

		$authorname = "--";
		if($model->getAuthor()>0){
			$author = $user->get($model->getAuthor());
			$authorname = $author->getNickname();
		}
		
		$cname = "无分类";
		$cid = intval($model->getCid());
		if($cid > 0){
			$category = $cate->getByID($cid);
			$cname = $category->getCname();
		}
		$cid2 = intval($model->getCid2());
		$cid3 = intval($model->getCid3());
		
		$sn = sprintf("%d-%d-%d",$cid,$cid2,$cid3);
		
		$this->set("iid", $iid);
		$title = trim($model->getTitle());
		$this->set("title" ,$title);
		$keyword = trim($model->getKeyword());
		if(trim($keyword) == ""){
			$keyword = $title;
		}
		$this->set("keyword",$keyword);
		$desc = trim($model->getDesc());
		if(trim($desc) == ""){
			$desc = $title;
		}

		$cost = floatval($model->getCost());
		$costp = intval($model->getCostp());

		$arr = $artps->getcontents($iid);//分页内容
		
		$color = "";
		if($cost > 0){
			$color .= "#aa0000";
		}elseif($costp>0){
			$color .= "#006699";
		}

		$menus = "";
		if(count($arr) > 0){
			foreach($arr as $item){
				$str = "<div id='menu".$item->getIid()."' class='artpmenus'><a href='javascript:void(0);' onclick='showPage(".$item->getIid().")' style='color:$color'>".$item->getTitle()."</a> </div>";
				$menus .= $str;
			}
		}else{
			$menus = "<div id='noartp'>没有分页</div>";
		}

		$this->set("menus",$menus);
		
		$this->set("authorname",$authorname);
		$this->set("desc",$desc);
		$this->set("createtime", $model->getCreatetime());
		$this->set("cname", $cname);
		$mcontent = stripslashes(htmlspecialchars_decode($model->getMcontent()));
		$mcontent = str_replace('src="',' class="lazy" data-original="',$mcontent);
		$this->set("mcontent", $mcontent);

		//判断使用哪个模块显示
		if(count($arr) > 0){
			return $this->view("Detail2","_Layout2");
		}if($cname == "linux"){
			//linux手册区别对待，啥母版都不要
			return $this->view("Lcmd");
		}if($cname == "javascript"){
			//javascript效果区别对待，啥母版都不要
			return $this->view("Manual");
		}if($topic->isTopic($sn)){
			$curtopic = $topic->get($sn);			
			
			$topictitle = $curtopic->getTitle();

			$list = $art->getTopics($sn);
			$contents = "";
			$i = 1;
			foreach($list as $item){
				$cur = "";
				if($iid == $item->getIid()){
					$cur = "color:red;font-weight:bold;";
				}
				$contents .= '<div class="" ><a  style="'.$cur.'" href="'.$this->helper->artHref($item->getIid()).'">第'.$i.'章 '.$item->getTitle().'</a></div>';
				$i++;
			}
			$this->set("topictitle", $topictitle);
			$this->set("contents", $contents);
			return $this->view("TopicDetail");
		}else{
			return $this->view("Detail");
		}
	}

	//支付成功之后的跳转界面
	function Success()
	{
		//支付成功之后的跳转一定是已经登录的情况下
		$uid = 0;
		session_start();
		if(isset($_SESSION["user"])){
			$uid = $_SESSION["user"]["userid"];
		}
		$user = new MT\TbUser();
		$me = $user->get($uid);
		
		$msg = "<div class='' style='color:#006699;font-size:18px;'>恭喜，您已支付成功！</div>";
		$bak = $me->getBak();
		if($bak == "auto"){
			$user->where("`iid`='$uid'")->kv(array("bak"=>"auto-1"))->update();//修改auto备注
			//如果是自动注册的用户，在这里提示用户修改密码

			$msg .= "<div style='margin:15px 0;'>系统为您创建了新帐户<br/> 用户名：".$me->getUsername()." <br/>密码：123456 </div>";
			$msg .= "为了确保安全，请尽快到<a href='javascript:void(0)' onclick=\"window.parent.location='".Lib\Config::get("url")."user/welcome'\" style='color:#006699;'> 用户中心 </a>修改初始密码。";
		}
		
		$this->set("msg",$msg);

		return $this->view("Success");
	}

	function Pay($aid)
	{
		$art = new MT\TbArticle();
		$user = new MT\TbUser();
		$payment = new MT\TbPayment();
		$sys = new MT\TbSystem();

		$syscfg = $sys->get();
		$rate = number_format($syscfg->getRate(),1);
		
		if($rate <= 0 || $rate > 1){
			return "费率错误";
		}

		$model = $art->get($aid);
		if($model == null){
			return "参数错误";
		}

		$uid = 0;
		session_start();
		if(isset($_SESSION["user"])){
			$uid = $_SESSION["user"]["userid"];
		}
		
		if(!($uid > 0)){
			//购买的用户未注册成为本站用户，自动为其注册一个新账户
			$username = "U".(time()-1573000000);//得到6位数字
			$userpass = "123456";
			$uid = $user->doSubmit($username,$userpass,"auto");
			if(!($uid > 0)){
				return "注册失败，请稍后再尝试";
			}
			//自动登录
			$_SESSION["user"] = array("userid"=>$uid,"usertype"=>1,"username"=>$username);
		}

		$title = addslashes($model->getTitle());
		$author = $model->getAuthor();
		if($author == $uid){
			return "不能购买自己的文档";
		}

		$cost = floatval($model->getCost());
		//查看用户是否资金充足，如果账户余额充足则使用余额购买
		$me = $user->get($uid);
		$money = floatval($me->getMoney());
		if( $money > $cost && $_GET["pay"]!='balance' && $_GET["pay"]!='weixin'){
			//既不明确余额支付，又不明确微信支付，所有提供选择界面
			return "<div style='text-align:center;margin:20px;'>该文档需要支付$cost 元，您当前的账户资金充足($money 元)，是否使用账户余额支付？<br/><br/><a href='../pay/$aid?pay=balance' >使用余额支付</a>&nbsp;&nbsp;或者&nbsp;&nbsp;<a href='../pay/$aid?pay=weixin'>使用微信扫码支付</a></div>";
		}else if($money > $cost && $_GET["pay"]=='balance'){
			$bak = "余额支付";
			$sn = "H".$uid."B".date("YmdHis",time());
			$bool = $payment->balance($sn,$uid,$author,$aid,$cost,$rate,$title,$bak);
			if($bool){
				return $this->redirect(Lib\Config::get("url")."article/success");//测试成功跳转页面
			}else{
				MH\Helper::info("余额支付失败，订单信息：$sn,$uid,$author,$aid,$cost,$rate,$title,$bak");
				return "余额支付失败";
			}
		}else{
			$bak = "微信支付";
			$sn = "";
			$paymentid = 0;
			//查询是否支付过
			$pay = $payment->where("`uid`='$uid' and `aid`='$aid' and `cost`>0 and 'costp'=0")->select();
			if(count($pay) == 1){
				$paymentid = $pay[0]->getIid();
				$sn = $pay[0]->getSn();
			}else{
				$sn = "H".$uid."B".date("YmdHis",time());
				$paymentid = $payment->weixin($sn,$uid,$author,$aid,$cost,$rate,$title,$bak);
			}
			if($paymentid > 0 and strlen($sn) > 16 ){
				//跳转到扫码支付界面
				$title = urlencode($title);
				//return $this->redirect(Lib\Config::get("url")."article/success");//测试成功跳转页面
				return $this->redirect(Lib\Config::get("url")."/sdk/pay.php?sn=$sn&price=$cost&title=$title");
			}else{
				//发起扫码支付失败
				return "发起支付失败，请稍后再尝试 $paymentid $sn";
			}
		}

		return "发起支付失败";
	}


	function Payp($aid)
	{
		session_start();
		if(!isset($_SESSION["user"])){
			return "请先登录";
		}
		$uid = $_SESSION["user"]["userid"];

		$user = new MT\TbUser();
		$me = $user->get($uid);
		if($me == null){
			return "参数错误";
		}

		$mypoints = $me->getHp();

		$art = new MT\TbArticle();

		$model = $art->get($aid);
		if($model == null){
			return "参数错误";
		}

		$title = $model->getTitle();
		$author = $model->getAuthor();
		$costp = intval($model->getCostp());

		if($mypoints < $costp){
			//积分不足抵扣
			return "您的积分($mypoints)不足以支付该文档($costp)";
		}

		$bak = "积分消费";

		$bool = $user->spendHp($uid,$author,$costp,$aid,$title,$bak);

		return $bool == true ? "true":"false";
	}


	function Ifcomment()
	{
		$ifcomment = "";
		session_start();
		if(!isset($_SESSION["user"])){
			$ifcomment = '<div class="col-sm-12" style="margin-top:15px;text-align:center;"><a href="login">登录</a> 评论文章</div>';
		}else{
			$ifcomment = '<div class="col-sm-12" style="margin-top:15px;">
			<div style="margin:20px 0;font-size:16px;">我要评论：</div>
			<div style="">
			<div class="input-group">
			  <textarea type="text" name="mcontent" id="mcontent" style="height:80px;padding:10px!important;"  class="form-control" placeholder="请输入内容"></textarea>
			  <span class="input-group-btn">
				<button class="btn btn-primary" style="height:80px;" onclick="submitComment()">提交评论</button>
			  </span>
			</div>
			<div class="" style="margin-top:15px;">
			<table style="width:100%">
			<tr><td><input type="text" name="vcode" id="vcode" placeholder="请输入验证码" style="width:100px;height:34px;padding:3px 5px;border:solid 1px #ccc;"  value="" size="6">
				<img src="base/vcode" align="middle" style="" onclick="this.src=\'base/vcode?a=\'+new Date().getTime()">
				看不清？单击换另外一组</td>
			</tr>
			<tr>
			</table>
			</div>
			</div>
	</div>';
		}

		return $ifcomment;
	}

	function Ifdown($iid)
	{
		$art = new MT\TbArticle();
		$model = $art->get($iid);
		if($model == null){
			return "参数错误";
		}
		$ifdown = "";
		if($model->getHref()){
			$ifdown = '<div class="" style="text-align:center;"><img src="res/images/down.jpg" onclick="location.href=\''.$model->getHref().'\'" class="img-responsive" style="max-width:200px;cursor:pointer;margin:20px auto;"/></div>';
		}
		return $ifdown;
	}

	function Relative($iid)
	{
		$art = new MT\TbArt();
		$model = $art->get($iid);
		if($model == null){
			return "参数错误$iid";
		}
		$models = array();
		if(trim($model->getTag()) != ""){
			$models = $art->where("cid>0 and `cid`!=51 and `cid`!=29 and title like '%".$model->getTag()."%' and iid!=".$iid)->desc("iid")->limit(0,4)->select();
		}
		if(count($models) == 0)
		{
			return "暂无相关文章";
		}

		//相关文章
		$relative = "";
		$i = 1;
		foreach($models as $item){
			$relative .= '<div class="" style=""><a href="'.$this->helper->artHref($item->getIid()).'">'.$i.'.'.$item->getTitle().'</a></div>';
			$i++;
		}

		return $relative;
	}

	function Ajax()
	{
		$art = new MT\TbArticle();
		$artps = new MT\TbArtps();
		$action = $_GET["action"];
		switch($action)
		{
			case "read":
				$iid = $_POST["iid"];
				$artcount = new MT\TbArtcount();
				$artcount->addRead($iid);
				return "ok";
				break;
			case "payinfo":
				$uid = 0;
				session_start();
				if(isset($_SESSION["user"])){
					$uid = $_SESSION["user"]["userid"];
				}
				$aid = $_POST["aid"];
				$model = $art->get($aid);
				if($model == null){
					return json_encode(array("status"=>false));//参数错误
				}
				$cost = floatval($model->getCost());
				$costp = intval($model->getCostp());
				
				$hp = 0;
				$ispay = false;
				if($uid > 0){
					//已经登录的用户检查是否已购买过该文档(使用积分或微信购买2种情况都算)
					$payment = new MT\TbPayment();
					$ispay = $payment->isPay($uid,$aid);
					
					$user = new MT\TbUser();
					$me = $user->get($uid);
					$hp = $me->getHp();
				}

				return json_encode(array(
					"status"=>true,
					"cost"=>$cost,
					"costp"=>$costp,
					"hp"=>$hp,
					"ispay"=>$ispay
					));
				break;
			case "get":
				$iid = $_POST["iid"];
				$aid = $_POST["aid"];

				$model = $art->get($aid);
				if($model == null){
					return "参数错误";
				}

				$uid = 0;
				session_start();
				if(isset($_SESSION["user"])){
					$uid = $_SESSION["user"]["userid"];
				}

				$cost = $model->getCost();
				$costp = $model->getCostp();
				
				if(($cost > 0 || $costp > 0) && $model->getAuthor()!=$uid)
				{
					if($uid == 0){
						//未登录用户不允许查看该收费文档
						return "请先购买该文档";
					}else{
						//这是付费文档或积分查看文档，检查用户是否支付过该文档
						$payment = new MT\TbPayment();
						$ispay = $payment->isPay($uid,$aid);
						if($ispay === false)
						{
							return "请先购买该文档";
						}
					}
				}

				$userid = $model->getAuthor();
				
				if($userid > 0){
					$arr = $artps->get($userid,$aid,$iid);
					if(count($arr) != 1){
						return "error".$userid;
					}
				}else{
					$arr = $artps->getfree($aid,$iid);
					if(count($arr) != 1){
						return "error";
					}
				}

				$mcontent = base64_decode($arr[0]->getMcontent());
				return $mcontent;
				break;

		}

		return "error";
	}


}  

?>