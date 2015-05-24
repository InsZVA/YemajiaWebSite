<meta charset="utf-8">
<?php 
require_once 'KdtApiClient.php';
require_once 'connect.php';

function _getid($s)
{
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
	$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
	if(!$con)die("Connect Error!");
	mysqli_query($con,"set names 'utf8' ");
	mysqli_query($con,"set character_set_client=utf8");  
	mysqli_query($con,"set character_set_results=utf8");
	mysqli_select_db($con,$mysql_db);
	$i=mysqli_real_escape_string($con,$i);
	$result=mysqli_query($con,"select * from member where name='$s'");
	if(!$result)die("GetID Error!");
	$row=mysqli_fetch_array($result);
	return $row[0];
}

function getsell($s)
{
	//$debug=true;
	//if($debug)return _getid($s);
	$appId = 'd1255c5a22f780133e';
	$appSecret = '5601ffa6013819e14d2caffe32f27737';
	$client = new KdtApiClient($appId, $appSecret);
	
	$params=array(
		'fields'=>'buyer_nick,payment',
		'page_size'=>'10000',
		'status'=>'TRADE_BUYER_SIGNED',
		'start_created'=>'2015-05-01 00:00:00',
		'end_created'=>'2015-05-31 00:00:00',
		
	);
	$method = 'kdt.trades.sold.get';
$num=0;
	$str=array();
	$str[0]=array();
	$str[0][0]=array();
	$str[0][0][0]=array();
	$str= $client->post($method,$params);
	$num=$str['response']['total_results'];
	
	$sum=0;
	$i=0;
	for($i=0;$i<$num;$i++)
	{
		if($str['response']['trades'][$i]['buyer_nick']==$s)
			$sum+=$str['response']['trades'][$i]['payment'];
	}
	$params=array(
		'fields'=>'buyer_nick,payment',
		'page_size'=>'10000',
		'status'=>'WAIT_BUYER_CONFIRM_GOODS',
		'start_created'=>'2015-05-01 00:00:00',
		'end_created'=>'2015-05-31 00:00:00',
		
	);
	
	$method = 'kdt.trades.sold.get';
	$num=0;
	$str=array();
	$str[0]=array();
	$str[0][0]=array();
	$str[0][0][0]=array();

	$str= $client->post($method,$params);
	$num=$str['response']['total_results'];
	
	for($i=0;$i<$num;$i++)
	{
		if($str['response']['trades'][$i]['buyer_nick']==$s)
			$sum+=$str['response']['trades'][$i]['payment'];
	}
	
	$params=array(
		'fields'=>'buyer_nick,payment',
		'page_size'=>'10000',
		'status'=>'WAIT_SELLER_SEND_GOODS',
		'start_created'=>'2015-05-01 00:00:00',
		'end_created'=>'2015-05-31 00:00:00',
		
	);
	$method = 'kdt.trades.sold.get';
	$num=0;
	$str=array();
	$str[0]=array();
	$str[0][0]=array();
	$str[0][0][0]=array();

	$str= $client->post($method,$params);
	$num=$str['response']['total_results'];
	
	for($i=0;$i<$num;$i++)
	{
		if($str['response']['trades'][$i]['buyer_nick']==$s)
			$sum+=$str['response']['trades'][$i]['payment'];
	}
	
	return $sum;
	
	
}


function getsell3($s)
{
	//$debug=true;
	//if($debug)return _getid($s);
	$appId = 'd1255c5a22f780133e';
	$appSecret = '5601ffa6013819e14d2caffe32f27737';
	$client = new KdtApiClient($appId, $appSecret);
	
	$params=array(
		'fields'=>'buyer_nick,payment',
		'page_size'=>'10000',
		'status'=>'TRADE_BUYER_SIGNED',
		'start_created'=>'2015-04-01 00:00:00',
		'end_created'=>'2015-06-30 00:00:00',
		
	);
	$method = 'kdt.trades.sold.get';
$num=0;
	$str=array();
	$str[0]=array();
	$str[0][0]=array();
	$str[0][0][0]=array();
	$str= $client->post($method,$params);
	$num=$str['response']['total_results'];
	
	$sum=0;
	$i=0;
	for($i=0;$i<$num;$i++)
	{
		if($str['response']['trades'][$i]['buyer_nick']==$s)
			$sum+=$str['response']['trades'][$i]['payment'];
	}
	$params=array(
		'fields'=>'buyer_nick,payment',
		'page_size'=>'10000',
		'status'=>'WAIT_BUYER_CONFIRM_GOODS',
		'start_created'=>'2015-04-01 00:00:00',
		'end_created'=>'2015-06-30 00:00:00',
		
	);
	
	$method = 'kdt.trades.sold.get';
	$num=0;
	$str=array();
	$str[0]=array();
	$str[0][0]=array();
	$str[0][0][0]=array();

	$str= $client->post($method,$params);
	$num=$str['response']['total_results'];
	
	for($i=0;$i<$num;$i++)
	{
		if($str['response']['trades'][$i]['buyer_nick']==$s)
			$sum+=$str['response']['trades'][$i]['payment'];
	}
	
	$params=array(
		'fields'=>'buyer_nick,payment',
		'page_size'=>'10000',
		'status'=>'WAIT_SELLER_SEND_GOODS',
		'start_created'=>'2015-04-01 00:00:00',
		'end_created'=>'2015-06-30 00:00:00',
		
	);
	$method = 'kdt.trades.sold.get';
	$num=0;
	$str=array();
	$str[0]=array();
	$str[0][0]=array();
	$str[0][0][0]=array();

	$str= $client->post($method,$params);
	$num=$str['response']['total_results'];
	
	for($i=0;$i<$num;$i++)
	{
		if($str['response']['trades'][$i]['buyer_nick']==$s)
			$sum+=$str['response']['trades'][$i]['payment'];
	}
	
	return $sum;
	
	
}
?>