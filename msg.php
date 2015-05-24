<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>查看上级通知</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
	div#cc
	{
		margin:0 auto;
		width:1366px;
	}
	#box{
		margin:5px;
	}
	#delete:link,#delete:visited{
		color:#C4BB91;
	}
	#delete:hover,#delete:active{
		color:#5A5A5A;
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
		$result=mysqli_query($con,"select * from announce");
		$row=mysqli_fetch_assoc($result);
		$i=0;
		while($row){
			if(isancestor($_SESSION['uid'],$row['uid']))
			{
				echo "<tr>";
					echo "<td>".getname($row['uid'])."</td>";
					echo "<td>$row[content]</td>";
					echo "<td>$row[time]</td>";
				echo "</tr>";
			}
			$row=mysqli_fetch_assoc($result);
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
<div id="welcome">尊敬的<b style="color:red"><?php echo $_SESSION['username'];?></b>您好，您所有上级的通知都在此处：</div>
</div>
<div id="scroll">
<table>
<tr>
<td>发布者</td>
<td>内容</td>
<td>时间</td>
</tr>
<?php listdata();?>
</table>
</div>
</div>
<div id="bottom">
   <br>
        <b style="color:white">网页制作：前端 LowesYang 后端 InsZVA CopyRight@2015</b><br>
    </div>
</div>
</body>
</html>