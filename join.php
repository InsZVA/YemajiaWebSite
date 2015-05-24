<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>正在处理</title>
</head>

<body>
<?php
	require_once 'common.php';
	require_once 'sendemail.php';
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
	$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
	if(!$con)die("Connect Error!");
	mysqli_query($con,"set names 'utf8' ");
	mysqli_query($con,"set character_set_client=utf8");  
    mysqli_query($con,"set character_set_results=utf8");
	mysqli_select_db($con,$mysql_db);
	$_POST['t_name']=mysqli_real_escape_string($con,$_POST['t_name']);
	$_POST['t_weixin']=mysqli_real_escape_string($con,$_POST['t_weixin']);
	$_POST['t_youzan']=mysqli_real_escape_string($con,$_POST['t_youzan']);
	$_POST['t_password']=mysqli_real_escape_string($con,$_POST['t_password']);
	$_POST['t_zhifubao']=mysqli_real_escape_string($con,$_POST['t_zhifubao']);
	$_POST['t_email']=mysqli_real_escape_string($con,$_POST['t_email']);
	/*$_POST['t_name']=htmlspecialchars($_POST['t_name']);
	$_POST['t_weixin']=htmlspecialchars($_POST['t_weixin']);
	$_POST['t_youzan']=htmlspecialchars($_POST['t_youzan']);
	$_POST['t_password']=htmlspecialchars($_POST['t_password']);
	$_POST['t_email']=htmlspecialchars($_POST['t_email']);
	$_POST['t_zhifubao']=htmlspecialchars($_POST['t_zhifubao']);*/
	$time=gmdate("Y-m-d H:i:s",time()+8*3600);
	$result=mysqli_query($con,"select * from member where id=$_POST[t_super]");
	if(!$result)die("Request Failed!");
	$row=mysqli_fetch_assoc($result);
	$row['level']++;
	$result=mysqli_query($con,"INSERT INTO register (name,phone,qq,weixin,youzan,super,level,time,password,email,zhifubao,url) VALUES ('$_POST[t_name]','$_POST[t_phone]','$_POST[t_qq]','$_POST[t_weixin]','$_POST[t_youzan]',$_POST[t_super],$row[level],'$time','$_POST[t_password]','$_POST[t_email]','$_POST[t_zhifubao]','$_POST[t_url]')");
	if(!$result)die("Request Failed!");
	
	$result=mysqli_query($con,"select * from member where id=".$_POST['t_super']);
	$row=mysqli_fetch_assoc($result);
	echo "已通知您的上家：".$row['name']."审核您的加盟请求！";
	send($row['email'],"您有一条加盟信息需要审核，请尽快在官网审核 www.yemajia.cn");
?>
</body>
</html>