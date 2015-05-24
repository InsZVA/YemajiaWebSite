<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>同意申请</title>
</head>

<body>
<div>
<?php
require_once 'connect.php';
require_once 'common.php';
global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		$_GET['uid']=mysqli_real_escape_string($con,$_GET['uid']);
		$_GET['uid']=htmlspecialchars($_GET['uid']);
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from register where id=$_GET[uid]");
		if(!$result)die("Param Error!");
		$row=mysqli_fetch_assoc($result);
		if($row['super']!=$_SESSION['uid']&&$_SESSION['uid']!=3)die("您没有足够的权限！");
		$result=mysqli_query($con,"SELECT count(*) FROM member WHERE super=$_SESSION[uid]");
		$row=mysqli_fetch_array($result);
		if($row[0]>=4&&$_SESSION[uid]!=3)
		{
		echo "<script>alert('您的代理商数额已达到上限！');history.go(-1);</script>";
		exit(0);
		}
		$result=mysqli_query($con,"select * from register where id=$_GET[uid]");
		if(!$result)die("Query Error!");
		$row=mysqli_fetch_array($result);
		$result=mysqli_query($con,"INSERT INTO member (`name`,`phone`,`qq`,`weixin`,`youzan`,`super`,`level`,`password`,`email`,`zhifubao`,`url`) VALUES ('$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[9]','$row[10]','$row[11]','$row[12]')");
		echo "INSERT INTO member (`name`,`phone`,`qq`,`weixin`,`youzan`,`super`,`level`,`password`,`email`,`zhifubao`,`url`) VALUES ('$row[1]',$row[2],$row[3],'$row[4]','$row[5]','$row[6]','$row[7]','$row[9]','$row[10]','$row[11]','$row[12]')";
		if(!$result)die("Update Error!");
		$uid=getid($row[1]);
	$result=mysqli_query($con,"INSERT INTO account (`uid`,`sell`,`fee`) VALUES ('$uid','0','0')");
	if(!$result)die("Request Failed!");
		$result=mysqli_query($con,"DELETE FROM register WHERE id=$_GET[uid]");
		if(!$result)die("Update Error!");
		$nn= "$row[1]";
		$result=mysqli_query($con,"SELECT count(*) FROM member WHERE super=$_SESSION[uid]");
		$row=mysqli_fetch_array($result);
		
		echo "<script>alert('$nn已成为您的下级代理商，您现在的直接代理商总数为:$row[0]);</script>";
		echo "<script>history.go(-1);</script>";
?>
</div>
</body>
</html>