<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>删除申请</title>
</head>

<body>
<?php
require_once 'connect.php';
global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$_GET[uid]=mysqli_real_escape_string($con,$_GET[uid]);
		$_GET[uid]=htmlspecialchars($_GET[uid]);
		$result=mysqli_query($con,"select * from register where id=$_GET[uid]");
		if(!$result)die("Param Error!");
		$row=mysqli_fetch_assoc($result);
		if($row['super']!=$_SESSION['uid']&&$_SESSION['uid']!=3)die("您没有足够的权限！");
		$result=mysqli_query($con,"delete from register where id=$_GET[uid]");
		mysqli_close($con);
		if(!$result)die("Delete Failed!");
		echo "<script>history.go(-1);</script>";
?>
</body>
</html>