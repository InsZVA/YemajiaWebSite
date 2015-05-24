<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>正在登陆</title>
<?php
require_once 'connect.php';
global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
	$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
	if(!$con)die("Connect Error!");
	mysqli_query($con,"set names 'utf8' ");
	mysqli_query($con,"set character_set_client=utf8");  
    mysqli_query($con,"set character_set_results=utf8");
	mysqli_select_db($con,$mysql_db);
	$_POST['uname']=mysqli_real_escape_string($con,$_POST['uname']);
	$_POST['uname']=htmlspecialchars($_POST['uname']);
	$_POST['password']=mysqli_real_escape_string($con,$_POST['password']);
	$_POST['password']=htmlspecialchars($_POST['password']);
	$result=mysqli_query($con,"select count(*) from admin where uname='$_POST[uname]' and password='$_POST[password]'");
	$row=mysqli_fetch_array($result);
	if($row[0]==0)die("登陆失败！");
	echo "登陆成功！";$_SESSION['username']=$_POST['uname'];
	$_SESSION['uid']=3;
	echo "<script> window.location.href='manage.php';</script>";
?>
</head>

<body>
</body>
</html>