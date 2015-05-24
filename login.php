<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登陆分销管理系统</title>
<style>
	body>p
	{
		text-align:center;
		text-shadow:#0CF 2px;
	}
	form>p{
		margin-right:12px;
		left:40%;
		position:relative;
	}
	form>input
	{
		border-radius:4px;
	}
</style>
<?php
require_once 'common.php';
	?>
</head>

<body>
<?php
if($_SESSION['uid'])
echo "<script> window.location.href='manage.php';</script>";
?>
<?php
require_once 'connect.php';
global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
if($_POST[uname]){
	$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
	if(!$con)die("Connect Error!");
	mysqli_query($con,"set names 'utf8' ");
	mysqli_query($con,"set character_set_client=utf8");  
    mysqli_query($con,"set character_set_results=utf8");
	mysqli_select_db($con,$mysql_db);
	$_POST['uname']=mysqli_real_escape_string($con,$_POST['uname']);
	$_POST['password']=mysqli_real_escape_string($con,$_POST['password']);
	$result=mysqli_query($con,"select * from member where `name`='$_POST[uname]'");
	$row=mysqli_fetch_assoc($result);
	echo $row['password'];
	if($row['password']!=$_POST['password'])die("登陆失败！");
	echo "登陆成功！";$_SESSION['username']=$_POST['uname'];
	$_SESSION['uid']=getid($_POST['uname']);
	echo "<script> window.location.href='manage.php';</script>";
    }
?>
<div id="container">
<p style="text-align:center">登陆</p>
<form action="login.php" method="post" name="form1">
<p>姓名:<input type="text" name="uname" id="uname" maxlength="12"/></p>
<p>密码:<input type="password" name="password" id="password" maxlength="16"/></p>
<p><input type="submit" value="登陆"/></p>
</form>
</body>
</html>