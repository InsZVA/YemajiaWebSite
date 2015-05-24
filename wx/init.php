<?php

$appid='wx7b37373c2de18633';
$appsecret='5f65b1da4c9bdb6084948fb6f2560fbf';
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
//file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN");
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
			$output=file_get_contents($url);
			$jsoninfo=array();
			$jsoninfo = json_decode($output, true);
			$access_token = $jsoninfo["access_token"];
			$url= "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
			$jsoninfo2='{
     "button":[
	   {
		   "name":"抽大奖",
           "sub_button":[
           {	
               "type":"view",
               "name":"抽奖",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='."http://www.yemajia.cn/wx/choujiang/chou.php".'&response_type=code&scope=snsapi_base&state=0#wechat_redirect"
            },
           {	
               "type":"view",
               "name":"兑换奖品",
               "url":"http://kdt.im/29wVuV1jZ"
            },
			]
	   },{ "name":"玩游戏",
           "sub_button":[
           {	
               "type":"view",
               "name":"求是鹰的历险",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='."http://www.yemajia.cn/wx/flappybird/index.php".'&response_type=code&scope=snsapi_base&state=0#wechat_redirect"
            },
           {	
               "type":"view",
               "name":"单身狗的逃亡",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='."http://www.yemajia.cn/wx/dog/index.php".'&response_type=code&scope=snsapi_base&state=0#wechat_redirect"
            },
			]
       }
	   ]
 }';
 $a=json_encode($jsoninfo2,true);
 var_dump($a);
 $output=https_post($url,$jsoninfo2);
 echo $output;
?>