<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>查看所有人业绩</title>
<link href="style.css" type="text/css" rel="stylesheet">

<?php
require_once 'common.php';
require_once 'youzan.php';
require_once 'sendemail.php';
function refresh()
{
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from member where id<>3");
		$row=mysqli_fetch_assoc($result);
		while($row)
		{
			$sell=getsell($row['youzan']);
			$fee=0;
			$fee=getfee($row['id']);
			$result2=mysqli_query($con,"update account set sell=$sell where uid=$row[id]");
			$result2=mysqli_query($con,"update account set fee=$fee where uid=$row[id]");
			$row=mysqli_fetch_assoc($result);
		}
		mysqli_close($con);
		
}
	function listdata()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$GET[uid]==mysqli_real_escape_string($con,$_GET[uid]);
		$result=mysqli_query($con,"select * from member where id!=3");
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
			echo "<td>".$row[7]."</td>";
			$result2=mysqli_query($con,"select * from account where uid=$row[0]");
			$row2=mysqli_fetch_assoc($result2);
			echo "<td>".$row2['sell']."</td>";
			echo "<td>".$row2['fee']."</td>";
			echo "<td>".getsell3($row[5])."</td>";
			if($_SESSION['uid']==3)echo "<td><input  type='checkbox'/>".$row[10]."</td>";
			
			
			echo "</tr>";
			
			$row=mysqli_fetch_array($result);
		}
	}
	function tuandui()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$GET[uid]==mysqli_real_escape_string($con,$_GET[uid]);
		$result=mysqli_query($con,"select * from member where super=3");
		$row=mysqli_fetch_array($result);
		$i=0;
		$sells=array();
		$names=array();
		$uids=array();
		while($row){
			$names[$i]=$row[1];
			$sells[$i]=getallsell($row[0]);
			$uids[$i]=$row[0];
			$row=mysqli_fetch_array($result);
			$i++;
		}
		$max=$sells[0];
		$maxi=0;
		for($t=0;$t<$i;$t++)
		{
			if($sells[$t]>=$max)
			{
				$max=$sells[$t];
				$maxi=$t;
			}
		}
		for($t=0;$t<$i;$t++)
		{
			echo "<tr>";
			echo "<td>团队：".$names[$t]."</td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td>".$sells[$t]."</td>";
			if($t==$maxi)echo "<td>奖励翻倍</td>";
			else echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "</tr>";
			
		}
		fanbei($uids[$maxi]);
	}
	if($_SESSION[uid]==3)refresh();
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
<div id="box">
<div id="welcone">尊敬的<b style="color:red"><?php echo $_SESSION['username'];?></b>您好：请处理下列分销商奖金。</div>
<div><?php if($_SESSION['uid']==3) echo "<a href='refresh.php'>刷新月销量及奖金额</a>";?></div>
<div><?php if($_SESSION['uid']==3) echo "<a href='payall.php'>对所有分销商邮件提醒</a>";?></div>
<div id="scroll">
<table id="t_data">
<tr>
<td>名称</td>

<td>电话</td>
<td>QQ号</td>
<td>微信号</td>
<td>有赞账号</td>
<td>邮箱</td>
<td>代理商等级</td>
<td>月销量</td>
<td>奖励额</td>
<td>季度销量</td>
<?php if($_SESSION['uid']==3) echo "<td>支付宝</td>";?>
</tr>
<?php tuandui();listdata(); ?>
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