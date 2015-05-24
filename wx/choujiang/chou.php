<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抽奖</title>
<?php

		require_once '../request.php';
		require_once '../common.php';
		if((!isset($_SESSION['openid']))&&(!isset($_GET['openid']))){
		$output=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$_GET[code]&grant_type=authorization_code");
		$json=json_decode($output,true);
		$_SESSION['openid']=$json['openid'];}
		if((!isset($_SESSION['openid']))&&(isset($_GET['openid']))){
		$_SESSION['openid']=$_GET['openid'];}
		if(!isset($_SESSION['openid']))die("请从微信中玩此游戏");
		if(!getidc($_SESSION['openid']))die("请求参数错误！");
		
		
	
?>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<style>
*{margin:0;padding:0;}
#machine
{
	margin:0 auto;
	background-image:url(machine.png);
	background-size:contain;
}
.bbox
{
	position:absolute;
	overflow:hidden;
}
.show
{
	position:relative;
	background-size:contain;
	background-repeat:no-repeat;
	background-position:center;
}
#button
{
	position:absolute;
	background-image:url(normal.png);
	background-size:cover;
}
#cong
{
	background-size:contain;
	background-repeat:no-repeat;
	background-position:center;
	background-image:url(cong.jpg);
	float:left;
	z-index:100;
	position:absolute;
}
#msg
{
	font-size:24px;
	font-family:黑体;
	float:left;
	z-index:1000;
	position:absolute;
	text-align:center;
}
#code
{
	font-family:黑体;
	font-size:24px;
	float:left;
	z-index:1000;
	position:absolute;
	text-align:center;
}
#dui
{
	font-family:黑体;
	font-size:26px;
	float:left;
	z-index:1000;
	position:absolute;
	text-align:center;
}
#kuai
{
	font-family:黑体;
	font-size:24px;
	float:left;
	z-index:1000;
	position:absolute;
	text-align:center;
}
</style>
<script>
function getid()
{
	<?php echo "return ".getidc($_SESSION[openid]).";"; ?>
}
</script>
<script>
var w;
window.onload=function()
{
	w=document.body.clientWidth;
	$("#machine").css({width:w,height:w/425*294});
	$("#d1").css({left:w/425*77});
	$("#d2").css({left:w/425*167});
	$("#d3").css({left:w/425*257});
	$("#d1").css("top",(w/425*51)+"px");
	$("#d2").css("top",(w/425*51)+"px");
	$("#d3").css("top",(w/425*51)+"px");
	$("#cong").css("width",w);
	$("#cong").css("height",w/6*9);
	$("#cong").hide();
	$("#msg").css({width:w,top:w-160});
	$("#code").css({width:w,top:w-120});
	$("#kuai").css({width:w,top:w-80});
	$("#dui").css({width:w,top:w/376*455});
	$(".bbox").css({width:w/425*66,
	height:w/425*117});
	$("#button").css({left:(w/425*136),
	top:(w/425*229),
	width:(w/425*146),
	height:(w/425*34)});
	$(".show").css({width:w/425*66,
	height:w/425*117});
	for(var i=1;i<=3;i++){
	$("#show"+i+"1").css("backgroundImage","url("+((i+1)%4+1)+".jpg)");
	$("#show"+i+"2").css("backgroundImage","url("+((i+2)%4+1)+".jpg)");
	$("#show"+i+"3").css("backgroundImage","url("+((i+3)%4+1)+".jpg)");
	$("#show"+i+"4").css("backgroundImage","url("+((i+4)%4+1)+".jpg)");}
}
function down(v)
{
	v.style.backgroundImage="url(down.png)";
}
function d1circle(t,r,times,a)
{
	for(var i=0;i<times;i++)
	$(".show").each(function(){
		if($(this).attr('id').substr(0,5)!="show"+t)return;
		if($(this).attr('id')!=("show"+t)+r)
		$(this).animate({top:-w/425*117*(r-1)},
		{duration:300,
		 complete:function(){
			 
				$(this).css({top:w/425*117});
				$(this).animate({top:0},100);
			},queue:true
		});
		else
		$(this).animate({top:-w/425*117*(r)},
		{duration:400,
		 complete:function(){
			 
				$(this).css({top:w/425*117});
				$(this).animate({top:0},100);
			},queue:true
		});
	});
	var p;
	if(a>0.01)
	{
		p=Math.floor((10*a+t)%4+1);
	}
	else if(a>0.004)
	{
		p=1;
	}
	else if(a>0.00133333333)
	{
		p=2;
	}
	else if(a>0.00066666666)
	{
		p=3;
	}
	else p=4;
	$(".show").each(function(){
		if($(this).attr('id').substr(0,5)!="show"+t)return;
		if($(this).attr('id')!=("show"+t)+r)
		$(this).animate({top:-w/425*117*(r-1)},
		{duration:300,
		 complete:function(){
			 
				$(this).css({top:w/425*117});
				$(this).animate({top:0},100,null,function()
				{$(this).css({backgroundImage:"url("+p+".jpg)"});});
			},queue:true
		});
		else
		$(this).animate({top:-w/425*117*(r)},
		{duration:400,
		 complete:function(){
			 
				$(this).css({top:w/425*117});
				$(this).animate({top:0},100,null,function()
				{$(this).css({backgroundImage:"url("+p+".jpg)"});});
			},queue:true
		});
	});
}
function up(v)
{
	$.get("action.php",{id:getid(),act:"11"},function(response){
		if(response=="-1"){alert("您没有抽奖次数可用！收集野马家卡牌，玩小游戏等均可获得抽奖机会！");window.locatin.href="http://www.baidu.com"}
	})
	v.style.backgroundImage="url(normal.png)";
	var a=Math.random();
	d1circle(1,4,6,a);
	d1circle(2,4,8,a);
	d1circle(3,4,10,a);
	setTimeout(function(){
		var code=getid();
		$("#cong").show();
	if(a>0.01)
	{
		$("#msg").html("参与奖");
		$("#code").html("优惠码："+code);
	}
	else if(a>0.004)
	{
		$("#msg").html("三等奖");
		$("#code").html("优惠码："+code);
	}
	else if(a>0.00133333333)
	{
		$("#msg").html("二等奖");
		$("#code").html("优惠码："+code);
	}
	else if(a>0.00066666666)
	{
		$("#msg").html("一等奖");
		$("#code").html("优惠码："+code);
	}
	else p=4;
	},5000);
}
</script>
</head>

<body>
<div id="cong">
<div id="msg">
三等奖
</div>
<div id="code">
优惠码：123
</div>
<div id="kuai">
快去野马家的有赞商铺凭此优惠码兑换奖品！！
</div>
<div id="dui" onClick="javascript:window.location.href='http://kdt.im/29wVuV1jZ';">
领取奖品
</div>
</div>
<div id="machine">
<div id="d1" class="bbox">
<div id="show11" class="show">

</div>
<div id="show12" class="show">

</div>
<div id="show13" class="show">

</div>
<div id="show14" class="show">

</div>
</div>
<div id="d2" class="bbox">
<div id="show21" class="show">

</div>
<div id="show22" class="show">

</div>
<div id="show23" class="show">

</div>
<div id="show24" class="show">

</div>
</div>
<div id="d3" class="bbox">
<div id="show31" class="show">

</div>
<div id="show32" class="show">

</div>
<div id="show33" class="show">

</div>
<div id="show34" class="show">

</div>
</div>
<div id="button"  onMouseDown="down(this)" onMouseUp="up(this)">
</div>
</div>
</body>
</html>