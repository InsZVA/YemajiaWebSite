<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>注册分销商</title>
<script>
function check1()
{
	var c=document.getElementById("t_name");var d=document.getElementById("d1");
	if(c.value==""){d.innerHTML="名称不能为空";}
	else d.innerHTML="√";
}
function check2()
{
	var c=document.getElementById("t_phone");
	var d=document.getElementById("d2");
	var str=c.value;
	var reg=/[0-9]{8,12}/;
	var result=reg.exec(str);
	if(result==null){d.innerHTML="电话号码输入错误";}
	else d.innerHTML="√";
}
function check3()
{
	var c=document.getElementById("t_qq");
	var d=document.getElementById("d3");
	var str=c.value;
	var reg=/[0-9]{5,10}/;
	var result=reg.exec(str);
	if(result==null){d.innerHTML="QQ号码输入错误";}
	else d.innerHTML="√";
}
function check4()
{
	var c=document.getElementById("t_weixin");var d=document.getElementById("d4");
	if(c.value==""){d.innerHTML="微信不能为空";}
	else d.innerHTML="√";
}
function checkp()
{
	var c=document.getElementById("t_password");var d=document.getElementById("dp");
	if(c.value==""){d.innerHTML="密码不能为空";}
	else d.innerHTML="√";
}
function checkp2()
{
	var c=document.getElementById("t_password");
	var c2=document.getElementById("t_password2");
	var d=document.getElementById("dp2");
	if(c.value!=c2.value){d.innerHTML="两次输入密码不相同";}
	else d.innerHTML="√";
}
function check5()
{
	var c=document.getElementById("t_youzan");var d=document.getElementById("d5");
	if(c.value==""){d.innerHTML="有赞店铺不能为空";}
	else d.innerHTML="√";
}
function focus5()
{
	var c=document.getElementById("t_youzan");var d=document.getElementById("d5");
	d.innerHTML='有赞店铺名是确认您有赞店铺销量获得奖励的唯一途径，请务必认真核对！';
}
function focus6()
{
	var d=document.getElementById("d6");
	d.innerHTML='常用邮箱用于月底向您汇报收入情况，以及可获得奖金额度，请务必认真核对！';
}
function focus7()
{
	var d=document.getElementById("d7");
	d.innerHTML='支付宝账号用于获得奖金，请务必认真核对！';
}
function check6()
{
	var c=document.getElementById("t_email");var d=document.getElementById("d6");
	if(c.value==""){d.innerHTML="常用邮箱不能为空";}
	else d.innerHTML="√";
}
function check7()
{
	var c=document.getElementById("t_zhifubao");var d=document.getElementById("d7");
	if(c.value==""){d.innerHTML="支付宝账号不能为空";}
	else d.innerHTML="√";
}
function check()
{
	check1();
	check2();
	check3();
	check4();
	check5();
	check6();
	checkp();
	checkp2();
	var d=document.getElementById("d1");
	if(d.innerHTML!="√")return false;
	d=document.getElementById("d2");
	if(d.innerHTML!="√")return false;
	d=document.getElementById("d3");
	if(d.innerHTML!="√")return false;
	d=document.getElementById("d4");
	if(d.innerHTML!="√")return false;
	d=document.getElementById("d5");
	if(d.innerHTML!="√")return false;
	d=document.getElementById("dp");
	if(d.innerHTML!="√")return false;
	d=document.getElementById("dp2");
	if(d.innerHTML!="√")return false;
	return true;
}
function listinfer(v)
{

}
</script>
<link href="register.css" type="text/css" rel="stylesheet">
</head>

<body>
<?php
require_once 'connect.php';
function listshop()
{
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
	$no=array();
	$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
	if(!$con)die("Connect Error!");
	mysqli_query($con,"set names ’utf8’ ");
	mysqli_query($con,"set character_set_client=utf8");  
    mysqli_query($con,"set character_set_results=utf8");
	mysqli_select_db($con,$mysql_db);
	$result=mysqli_query($con,"select * from member");
	$row=mysqli_fetch_assoc($result);
	$no=array();
	while($row){
		$no[$row['level']]++;
	echo "<option value='".$row['id']."'>$row[level]级代理商-".$no[$row[level]]."-".$row['youzan']."</option>";
	$row=mysqli_fetch_assoc($result);
	}
}

?>
<div id="container">

<div id="f">
<div id="logo" style="height:200px; background-color:#9F9;">
<div style="height:10px"></div>
<img src="logo2.png" height="180px"/>
</div>
<div style="height:20px"></div>
<form id="form1" name="form1" action="join.php" method="post" target="_self" onsubmit="return check()">
<div class="bx"><label>姓名：</label><input type="text" name="t_name" id="t_name" maxlength="40" onBlur="check1()"/><div id="d1" style="color:red"></div></div>
<div class="bx"><label>密码：</label><input type="password" name="t_password" id="t_password" maxlength="16" onBlur="checkp()"/><div id="dp" style="color:red"></div></div>
<div class="bx"><label>确认密码：</label><input type="password" name="t_password2" id="t_password2" maxlength="16" onBlur="checkp2()"/><div id="dp2" style="color:red"></div></div>
<div class="bx"><label>电话：</label><input type="tel" name="t_phone" id="t_phone" onBlur="check2()" maxlength="12"/><div id="d2" style="color:red"></div></div>
<div class="bx"><label>QQ号：</label><input type="tel" name="t_qq" id="t_qq" onBlur="check3()" maxlength="10"/><div id="d3" style="color:red"></div></div>
<div class="bx"><label>微信：</label><input type="text" name="t_weixin" id="t_weixin" onBlur="check4()" maxlength="50"/><div id="d4" style="color:red"></div></div>
<div class="bx"><label>常用邮箱：</label><input type="text" name="t_email" id="t_email" onBlur="check6()" onFocus="focus6()" maxlength="50"/><div id="d6" style="color:red"></div></div>
<div class="bx"><label>支付宝账号：</label><input type="text" name="t_zhifubao" id="t_zhifubao" onBlur="check7()" onFocus="focus7()" maxlength="30"/><div id="d7" style="color:red"></div></div>
<div class="bx"><label>有赞店铺：</label><input type="text" name="t_youzan" id="t_youzan" onBlur="check5()" onFocus="focus5()" maxlength="100"/><div id="d5" style="color:red"></div></div>
<div class="bx"><label>有赞店铺地址：</label><input type="text" name="t_url" id="t_url" maxlength="100"/><div id="d5" style="color:red"></div></div>
<div class="bx"><label>上级代理：</label><select name="t_super" id="t_super" onChange="listinfer(this.value)">
<?php 
listshop();
?>

</select>

<div id="s2"></div>
</div>
<iframe src="hetong.htm" width="600px" height="260px"></iframe>
<div id="bbox">
<div><a href="login.php">已加盟？请点击这里进入管理</a></div>
<div><a href="admin.php">管理员请在这里进入</a></div>
<div>点击加入即表示同意以上协议：</div>
</div>
<input type="submit" value="立即加入"/>
</form>
</div>

</div>
</body>
</html>