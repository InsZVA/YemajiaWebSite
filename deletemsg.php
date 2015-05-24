<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>删除消息</title>
</head>

<body>
<?php
require_once 'common.php';
global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$_GET[id]=mysqli_real_escape_string($con,$_GET[id]);
		$_GET[id]=htmlspecialchars($_GET[id]);
		$result=mysqli_query($con,"select * from announce where id=$_GET[id]");
		if(!$result)die("Param Error!");
		$row=mysqli_fetch_assoc($result);
		if(isancestor($row['uid'],$_SESSION['uid'])==false&&$row['uid']!=$_SESSION['uid'])die("您没有足够的权限！");
		$result=mysqli_query($con,"delete from announce where id=$_GET[id]");
		if(!$result)die("Delete Failed!");
		echo "<script>history.go(-1);</script>";
?>
</body>
</html>