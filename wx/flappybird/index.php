<?php session_start();?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>求是鹰的历险</title>

    <meta name="viewport" content="user-scalable=no"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="x5-fullscreen" content="true"/>
    <style>
        body, canvas, div {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -khtml-user-select: none;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
    </style>
    <?php
		require_once '../request.php';
		require_once '../common.php';
		$output=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$_GET[code]&grant_type=authorization_code");
		$json=json_decode($output,true);
		if(!isset($_SESSION['openid']))$_SESSION['openid']=$json['openid'];
		if(!isset($_SESSION['openid']))die("请从微信中玩此游戏");
		
		if(!getid($_SESSION['openid']))die("请求参数错误！");
		
		
	?>
</head>

<body style="padding:0; margin: 0;text-align: center;background: #f2f6f8;">
    <canvas id="gameCanvas" width="720" height="1280"></canvas>

<script src="cocos2d.js"></script>
</body>
</html>