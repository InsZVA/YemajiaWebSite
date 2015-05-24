<?php
//require_once("smtp.php"); 
require_once "email.class.php";
	function send($smtpemailto,$mailbody){
	//if($_SESSION['uid']!=3)die();
	//引入发送邮件类
	
	//使用yemajia邮箱服务器
	$smtpserver = "smtp.126.com";
	//yemajia邮箱服务器端口 
	$smtpserverport = 25;
	//你的yemajia服务器邮箱账号
	$smtpusermail = "inszva@126.com";
	//收件人邮箱
	//$smtpemailto = "inszva@126.com";
	//你的邮箱账号(如果163去掉@163.com)
	$smtpuser = "inszva";//SMTP服务器的用户帐号 
	//你的邮箱密码
	$smtppass = "thefirstgeek"; //SMTP服务器的用户密码 
	
	//邮件主题 
	$mailsubject = "野马家澳洲代购自动邮件";
	//邮件内容 
	//$mailbody = "PHP+MySQL";
	//邮件格式（HTML/TXT）,TXT为文本邮件 
	$mailtype = "TXT";
	//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
	//是否显示发送的调试信息 
	//$smtp->debug = TRUE;
	//发送邮件
	$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
	}
?>