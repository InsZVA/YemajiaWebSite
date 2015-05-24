<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>发布对下通知</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
	
	#box{
		margin:5px;
	}
	#delete:link,#delete:visited{
		color:#C4BB91;
	}
	#delete:hover,#delete:active{
		color:#5A5A5A;
	}
	#submit{
		margin:5px;
		border:2px;
		cursor:pointer;
		width:50px;
		height:20px;
		background-color:#F5F5F5;
	}
	#submit:hover{
		color:#CCC;
		background-color:#333;
	}
</style>
<?php
require_once 'connect.php';
require_once 'common.php';

function listdata()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from announce where uid=".$_SESSION['uid']);
		$row=mysqli_fetch_array($result);
		$i=0;
		while($row){
			echo "<tr>";
			for($i=2;$i<4;$i++)
			{
				echo "<td>$row[$i]</td>";
			}
			echo "<td><a href='deletemsg.php?id=$row[0]' id='delete'>删除消息</a>";
			echo "</tr>";
			$row=mysqli_fetch_array($result);
		}
	}
if($_POST[content])
{
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$_POST['content']=mysqli_real_escape_string($con,$_POST['content']);
		$_POST['content']=htmlspecialchars($_POST['content']);
		$time=gmdate("Y-m-d H:i:s",time()+8*3600);
		$result=mysqli_query($con,"insert into announce(uid,content,time) VALUES($_SESSION[uid],'$_POST[content]','$time')");
		if(!$result)die("Announce Failed!");

		if($_POST['cemail'])
		{
			$str=$_SESSION['username']."发布了新通知：".$_POST['content'];
			enumemail($_SESSION['uid'],$str);
		}
}
?>
</head>

<body>
<div id="cc">
<div id="d_header">

<img src="1.jpg"/>
<div id="h_header">
<a href="manage.php"><h1>后台管理</h1></a>
</div>
</div>

<div id="d_left">
<ul>
<li><a href="examine.php">审核分销申请</a></li>
<li><a href="list.php?uid=<?php echo $_SESSION['uid']?>">操作各级分销商</a></li>
<li><a href="msg.php">查看上级通知</a></li>
<li><a href="announce.php">发布对下通知</a></li>
<li><a href="pay.php">查看所有人业绩</a></li>
</ul>
</div>
<div id="container">
<div id="box">
<div id="welcome">尊敬的<b style="color:red"><?php echo $_SESSION['username'];?></b>您好，您可以对您的直属以及间接下级发布通知！</div>
<form action="announce.php" method="post">
<p>发布通知：<input type="text" name="content" id="content"/></p>
<p>邮件提醒:<input name="cemail" type="checkbox" value="cemail"></p>
<input type="submit" value="发布" id="submit"/>
</form>
<div id="scroll">
<table>
<tr>
<td>内容</td>
<td>时间</td>
<td>操作</td>
</tr>
<?php listdata();?>
</table>
</div>
</div>
</div>
<div id="bottom">
   <br>
        <b style="color:white">网页制作：前端 LowesYang 后端 InsZVA CopyRight@2015</b><br>
    </div>
</div>
</body>
</html>