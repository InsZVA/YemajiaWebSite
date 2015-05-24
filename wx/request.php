<?php
require_once 'common.php';
$appid='wx7b37373c2de18633';
$appsecret='5f65b1da4c9bdb6084948fb6f2560fbf';

function checkSignature()
{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
	$token = "yemajia";
	$tmpArr = array($token, $timestamp, $nonce);
	sort($tmpArr, SORT_STRING);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );
	
	if( $tmpStr == $signature ){
		if(isset($_GET['echostr']))echo ($_GET['echostr']);
		else translateMsg();
		return true;
	}else{
		return false;
	}
}

function getAccessToken()
{
		global $appid,$appsecret;
	$access_token=gettoken();
	if(!$access_token){
		$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
		$output=file_get_contents($url);
		$jsoninfo=array();
		$jsoninfo = json_decode($output, true);
		$access_token = $jsoninfo["access_token"];
		updatetoken($access_token);
	}
	return $access_token;
}
function _getJsTicket()
{
	$ticket=getjsticket();
	if(!$ticket){
	$access_token=getAccessToken();
	$output=file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi");
	echo($output);
	$json=array();
	$json=json_decode($output,true);
	$ticket=$json[ticket];
	updatejsticket($ticket);
	}
	return $ticket;
}
function translateMsg()
{
	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

	if (!empty($postStr)){
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$msgType=$postObj->MsgType;
		$content = trim($postObj->Content);
		$time=time();
		switch($msgType)
		{
			case 'text':
				responseTXTMsg($fromUsername,$toUsername,$time,$content);
				break;
			case 'image':
				sendTXTMsg($fromUsername,$toUsername,$time,"你发了一条图像消息");
				break;
			case 'voice':
				sendTXTMsg($fromUsername,$toUsername,$time,"你发了一条声音消息");
				break;
			case 'video':
				sendTXTMsg($fromUsername,$toUsername,$time,"你发了一条视频消息");
				break;
			case 'shortvideo':
				sendTXTMsg($fromUsername,$toUsername,$time,"你发了一条小视频消息");
				break;
			case 'location':
				sendTXTMsg($fromUsername,$toUsername,$time,"你发了一条位置消息");
				break;
			case 'link':
				sendTXTMsg($fromUsername,$toUsername,$time,"你发了一条链接消息");
				break;
			case 'event':
				$event=$postObj->Event;
				$eventKey=$postObj->EventKey;
				responseEventMsg($fromUsername,$toUsername,$time,$event,$eventKey);
				break;
		}
	}else{
		echo "";
		exit;
	}
}

function sendTXTMsg($toUserName,$fromUserName,$CreateTime,$Content)
{
	$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
	$strecho=sprintf($textTpl,$toUserName,$fromUserName,$CreateTime,'text',$Content);
	echo $strecho;
}

function curl_post($url, $post) {  
    $options = array(  
        CURLOPT_RETURNTRANSFER => true,  
        CURLOPT_HEADER         => false,  
        CURLOPT_POST           => true,  
        CURLOPT_POSTFIELDS     => $post,  
    );  
  
    $ch = curl_init($url);  
    curl_setopt_array($ch, $options);  
    $result = curl_exec($ch);  
    curl_close($ch);  
    return $result;  
} 

function getusermsg($openid)
{
	global $appid,$appsecret;
		
			$access_token = getAccessToken();
			$response=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN");
			$jsoninfo2=array();
			$jsoninfo2=json_decode($response,true);
			return $jsoninfo2;
			
}

function responseTXTMsg($fromUserName,$toUserName,$CreateTime,$Content)
{
	global $appid,$appsecret;
		/*$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
			//$output=file_get_contents($url);
			$jsoninfo=array();
			$jsoninfo = json_decode($output, true);
			$access_token = getAccessToken();
			$qrcode="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
			$jsoninfo2='{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "9000'.$Content.'"}}}';
			$output=https_post($qrcode,$jsoninfo2);
			$jsoninfo=json_decode($output,true);
			$jsoninfo['ticket']=urlencode($jsoninfo['ticket']);
			$qrcode="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$jsoninfo[ticket]";
			sendTXTMsg($fromUserName,$toUserName,$time,$qrcode);
			return;*/
	switch($Content)
	{
		case '推广二维码':
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600-24*3600);
		$result=mysqli_query($con,"select * from wxgame where openid='$fromUserName'");
		$row=mysqli_fetch_assoc($result);


			sendTXTMsg($fromUserName,$toUserName,$time,$row[qrcode]);
			break;
		case '查积分':
			sendTXTMsg($fromUserName,$toUserName,$time,getscore($fromUserName));
			break;
		case 'JDK':
			sendTXTMsg($fromUserName,$toUserName,$time,_getJsTicket());
			break;
		case '有赞':
			sendTXTMsg($fromUserName,$toUserName,$time,'你好，这是我们的有赞商城地址~
			http://detail.koudaitong.com/show/goods/newest?alias=7pw6ayh3');
			break;
		case '微店':
			sendTXTMsg($fromUserName,$toUserName,$time,'你好，这是我们微店地址~
			http://weidian.com/s/317336316?wfr=qfriend');
			break;
		default:
			sendTXTMsg($fromUserName,$toUserName,$time,"你好~我是野马~mo-亲亲mo-亲亲mo-亲亲很开心你来到了野马家作客~
愿你被这个世界温柔相待~
回复“微店”可访问微店
回复“有赞”可访问有赞商城
回复“玩游戏”可玩小游戏拿积分换奖品");
	}
}
function https_post($url,$data=null)
{
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
	if(!empty($data))
	{
		curl_setopt($curl,CURLOPT_POST,1);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
	}
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$output=curl_exec($curl);
	curl_close($curl);
	return $output;
}
function responseEventMsg($fromUsername,$toUsername,$time,$event,$eventKey)
{
	global $appid,$appsecret;
	switch($event)
	{
		case 'subscribe':
			$sid=0;
			if($eventKey)
			{
				sscanf($eventKey,"qrscene_%d",$sid);
				
			}
			$data=getusermsg($fromUsername);
			$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
			//$output=file_get_contents($url);
			$jsoninfo=array();
			$jsoninfo = json_decode($output, true);
			$access_token = getAccessToken();
			$qrcode="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
			$id=getnextid();
			$jsoninfo2='{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$id.'"}}}';
			$output=https_post($qrcode,$jsoninfo2);
			$jsoninfo=json_decode($output,true);
			$jsoninfo['ticket']=urlencode($jsoninfo['ticket']);
			$qrcode="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$jsoninfo[ticket]";
			$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
			$output=file_get_contents($url);
			$jsoninfo=array();
			$jsoninfo = json_decode($output, true);
			insert($fromUsername,$sid,$data['nickname'],$data['headimgurl'],$qrcode);
			sendTXTMsg($fromUsername,$toUsername,$time,"你好~我是野马~mo-亲亲mo-亲亲mo-亲亲很开心你来到了野马家作客~
愿你被这个世界温柔相待~
回复“微店”可访问微店
回复“有赞”可访问有赞商城");
		break;
		case 'SCAN':
			sendTXTMsg($fromUsername,$toUsername,$time,"感谢您关注我的公众号");
		break;
		case 'unsubscribe':
			remove($fromUsername);
		break;
		
	}
}
checkSignature();

?>