<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>审核分销申请</title>
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
if(!$_SESSION['uid'])die();
	function listdata()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		if($_SESSION['uid']!=3)$result=mysqli_query($con,"select * from register where super=".$_SESSION['uid']);
		else
		$result=mysqli_query($con,"select * from register where id!=".$_SESSION['uid']);
		$row=mysqli_fetch_array($result);
		$i=0;
		while($row){
			echo "<tr>";
			for($i=1;$i<9;$i++)
			{
				if($i!=6)echo "<td>$row[$i]</td>";
				else echo "<td><a href='list.php?uid=$row[6]'>".getname($row[6])."</td>";
			}
			echo "<td>$row[10]</td>";
			echo "<td><a href='admit.php?uid=".$row[0]."'>同意</a> <a href='disadmit.php?uid=".$row[0]."'>删除</a>";
			echo "</tr>";
			$row=mysqli_fetch_array($result);
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
<div id="welcome">尊敬的<b style="color:red"><?php echo $_SESSION['username'];?></b>您好：请审核下列向您申请分销的数据。</div>
<div id="scroll">
<table id="t_data">
<tr>
<td>名称</td>
<td>电话</td>
<td>QQ号</td>
<td>微信号</td>
<td>有赞账号</td>
<td>申请上级</td>
<td>申请等级</td>
<td>申请时间</td>
<td>常用邮箱</td>
<td>审核</td>
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