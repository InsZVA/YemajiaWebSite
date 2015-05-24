<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>管理员登陆</title>
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
</head>

<body>
<?php
if($_SESSION['uid']==3)
echo "<script> window.location.href='manage.php';</script>";
?>
<div id="container">
<p style="text-align:center">管理员登陆</p>
<form action="adminlogin.php" method="post" name="form1">
<p>账号:<input type="text" name="uname" id="uname" maxlength="12"/></p>
<p>密码:<input type="password" name="password" id="password" maxlength="16"/></p>
<p><input type="submit" value="登陆"/></p>
</form>
</body>
</html>