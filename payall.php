<?php
session_start();
if($_SESSION[uid]!=3)die();
require_once 'common.php';
payall();
	function payall()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$GET[uid]==mysqli_real_escape_string($con,$_GET[uid]);
		$result=mysqli_query($con,"select * from member where id<>3");
		$row=mysqli_fetch_array($result);
		$i=0;
		while($row){
			send($row['email'],"您好，您在本月获得"._getsell($row[0])."的月销量，得到"._getfee($row[0])."的奖励，已经打到支付宝。请确认。如有疑问请及时联系总供应商。 -野马家分销团队");
			$row=mysqli_fetch_array($result);
		}
	}
?>