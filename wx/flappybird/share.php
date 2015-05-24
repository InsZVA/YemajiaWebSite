<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>快来玩疯狂的小鸟</title>
</head>

<body>
<div>我关注了XXX微信平台，可以玩疯狂的小鸟小游戏，积分换礼品，扫描下方二维码即可参与！</div>
<?php require_once '../common.php'; require_once '../request.php'; 
function getimg()
{
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600-24*3600);
		$result=mysqli_query($con,"select * from wxgame where openid='$_SESSION[openid]'");
		$row=mysqli_fetch_assoc($result);
			echo $row['qrcode'];

}
?>
<img src="<?php getimg()?>"/>
</body>
</html>