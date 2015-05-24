<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>抽奖系统管理</title>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js">
</script>
<script>
function Action(_id,_act,dom)
{
	$.get("action.php",{id:_id,act:_act},function(response){
		dom.innerHTML=response;
	})
}
</script>
<?php require('../connect.php'); ?>
<style>
*{margin:0;padding:0;}
#scroll
{
	height:600px;
	overflow-y:scroll;
}
td
{
	background-color:#9F9;
	margin-right:10px;
}
.action:hover
{
	background:#0CF;
}
</style>
</head>

<body>
<div id="container">
<div class="btext">
用户列表：
</div>
<div id="scroll">
<table>
<tr>
<td>昵称</td>
<td>邮箱</td>
<td>电话</td>
<td>短号</td>
<td>抽奖次数</td>
<td>羊奶皂</td>
<td>护手霜</td>
<td>防晒霜</td>
<td>大礼包</td>
<td>
</tr>
<?php
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from choujiang");
		if(!$result)echo "<tr><td>没有数据</td></tr>";
		else{
		$row=mysqli_fetch_array($result);
		
		while($row)
		{
			echo "<tr>";
			for($i=2;$i<11;$i++)
			if($i>3)echo "<td class='action' onClick='Action($row[0],$i,this)'>$row[$i]</td>";
			else echo "<td>$row[$i]</td>";
			echo "<tr>";
			$row=mysqli_fetch_array($result);
		}
		}
		mysqli_close($con);
?>
</table>
</div>
</div>
</body>
</html>