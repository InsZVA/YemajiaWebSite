<?php
session_start();

require_once 'connect.php';
require_once 'common.php';
global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
if(!isancestor($_GET['uid'],$_SESSION['uid']))die();
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$_GET['uid']=mysqli_real_escape_string($con,$_GET['uid']);
		$_GET['uid']=htmlspecialchars($_GET['uid']);
		$result=mysqli_query($con,"delete from member where id=$_GET[uid]");
		if(!$result)die('Delete Failed!');
		$result=mysqli_query($con,"delete from account where uid=$_GET[uid]");
		if(!$result)die('Delete Failed!');
		mysqli_close($con);
		echo "<script>history.go(-1);</script>";
?>