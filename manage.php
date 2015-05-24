<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>管理后台</title>
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
            <div id="welcome">尊敬的<b style="color:red"><?php echo $_SESSION['username']; ?></b>您好！</div>
            <?php if($_SESSION['uid']==3)
            echo "<a href='pay.php'>一键结账 </a> ";
            ?>
            <a href="exit.php">退出</a>
         </div>
   </div>
   <div id="bottom">
   <br>
        <b style="color:white">网页制作：前端 LowesYang 后端 InsZVA CopyRight@2015</b><br>
    </div>
</div>

</body>
</html>