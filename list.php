<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>操作直接下级</title>
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
<script>
function dia(a,b)
{
	if(confirm("删除操作不可恢复，确定要删除："+b+"吗？"))
	{
		window.location.href='delete.php?uid='+a;
	}
}
</script>
<?php
require_once 'connect.php';
require_once 'common.php';
require_once 'youzan.php';
if(!$_GET[uid])die();
	function listdata()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$GET[uid]=mysqli_real_escape_string($con,$_GET[uid]);
		$GET[uid]=htmlspecialchars($_GET[uid]);
		$result=mysqli_query($con,"select * from member where super=".$_GET['uid']);
		$row=mysqli_fetch_array($result);
		$i=0;
		while($row){
			echo "<tr>";
			for($i=1;$i<6;$i++)
			{
				
				if($i==1)echo "<td><a id='delete' href='list.php?uid=".$row[0]."'>$row[$i]</a></td>";
				else if($i==5) echo "<td><a id='delete' href='$row[11]'>$row[5]</a></td>";
				else echo "<td>$row[$i]</td>";
			}
			echo "<td>".$row[9]."</td>";
			$result2=mysqli_query($con,"select * from account where uid=$row[0]");
			$row2=mysqli_fetch_assoc($result2);
			echo "<td>".$row2['sell']."</td>";
			echo "<td>".$row2['fee']."</td>";
			echo "<td onClick='dia(\"".$row[0]."\",\"".$row[1]."\")'>删除</td>";
			echo "</tr>";
			$row=mysqli_fetch_array($result);
		}
		mysqli_close($con);
	}
	
?>
</head>

<body>
<?php
if(!$_SESSION['uid'])
	echo "<script> window.location.href='login.php';</script>";

?>
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
<div id="welcone">尊敬的<b style="color:red"><?php echo $_SESSION['username'];?></b>您好：请处理下列<b style="color:red"><?php echo getname($_GET['uid']);?></b>的直接下级分销商。</div>
<div id="scroll">
<table id="t_data">
<tr>
<td>名称</td>
<td>电话</td>
<td>QQ号</td>
<td>微信号</td>
<td>有赞账号</td>
<td>邮箱</td>
<td>月销量</td>
<td>奖励额</td>
<td>操作</td>
</tr>
<?php listdata(); ?>
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