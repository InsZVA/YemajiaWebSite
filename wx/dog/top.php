<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>排行榜</title>
<style>
*{
	margin:0;
}
	#top{
		left:0;
		top:0;
		width:100%;
		height:15%;
		background-color:#C93;
		text-align:center;
		font-family:微软雅黑;
		font-size:36px;
		color:#FF0033;
		box-shadow:0px 5px 3px #333333;
	}
	body
	{
		background-color:#333333;
	}
	#list
	{
		width:80%;
		margin-left:10%;
		margin-top:5%;
		height:70%;
		border-radius:20px;
		background-color:#FF9900;
	}
	#list img
	{
		width:60px;
		height:60px;
		margin-left:5%;
		margin-top:2%;
		margin-bottom:2%;
	}
	#list td div
	{
		heght:60px;
		width:100%;
		margin-left:15%;
		font-size:24px;
		font-family:微软雅黑;
		color:white;
	}
	#me div.l
	{
		heght:60px;
		width:100%;
		margin-left:15%;
		font-size:24px;
		font-family:微软雅黑;
		color:white;
	}
	#list td
	{
		width:30%;
		text-align:center;
	}
	#me
	{
		width:80%;
		margin-left:10%;
		margin-top:5%;
		border-radius:20px;
		background-color:#FF9900;
	}
	#me table
	{
		width:80%;
	}
	#list table
	{
		width:80%;
	}
	#me img
	{
		width:60px;
		height:60px;
		margin-left:5%;
		margin-top:2%;
		margin-bottom:2%;
	}
</style>
</head>

<body>
<div id="top">查看排行榜</div>
<div id="box">
<div id="list">
<table>
<?php

	require_once "../request.php";
	require_once "../common.php";
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from wxgame order by score desc limit 0,10");
		$data=array();
		$row=mysqli_fetch_assoc($result);
		while($row)
		{
			$data=getusermsg($row['openid']);
			echo "<tr><td><img src='$row[imgurl]'/></td>";
			echo "<td><div>$row[nickname]</div></td><td><div>$row[score]</div></td></tr>";
			$row=mysqli_fetch_assoc($result);
		}
		
		
?>

</table>
</div>
<div id="me">
<table>
<?php
require_once "../request.php";
	require_once "../common.php";
	$_SESSION['openid']=$_GET['openid'];
	$_SESSION['score']=$_GET['score'];
	$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from wxgame where openid='$_SESSION[openid]'");
		if(!$result)die();
		$row=mysqli_fetch_assoc($result);
		
			echo "<tr><td><div class='l'><img src='$row[imgurl]'/></div></td>";
			echo "<td><div class='l'>$row[nickname]</div></td><td><div class='l'>$row[score]</div></td></tr>";
			$row=mysqli_fetch_assoc($result);
?>
<tr>
<td><div class="l">本次成绩:<?php echo $_SESSION['score']; ?></div></td>
<td><?php if(!isplayed2($_SESSION['openid'])) echo "<a href='addscore.php?openid=$_SESSION[openid]&score=$_SESSION[score]'><div class='l'>提交</div></a>"; ?></td>
<td><a href="javascript:history.go(-1);"><div class="l">重玩</div></a></td>
</tr>
</table>
</div>
</div>
</body>
</html>