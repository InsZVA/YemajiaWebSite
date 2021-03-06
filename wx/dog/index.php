<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<title>单身狗的逃亡</title>
<style>
*{margin:0;padding:0;}
#container
{
	width:100%;
	margin:0 auto;
	background-color:#D9FCF5;
	background-size:contain;
}
#con
{
	overflow:hidden;
	position:absolute;
}
#box
{
	left:31.25%;
	width:37.5%;
	position:absolute;
	background-image:url(images/map0.png);
	background-size:contain;
}
.square
{
	float:left;
	position:relative;
	z-index:0px;
	left:0px;
	top:0px;
}
.food
{
	position:relative;
	float:left;
}
#score
{
	color:black;
	font-family:Arial Black;
	font-size:20px;
	position:absolute;
}
#msg
{
	color:black;
	font-family:微软雅黑;
	font-size:20px;
	position:absolute;
}
#ready
{
	color:black;
	font-family:微软雅黑;
	position:absolute;
	font-size:20px;
}
#restart
{
	left:40%;
	top:80%;
	color:black;
	font-family:微软雅黑;
	font-size:20px;
	position:absolute;
}
#top
{
	left:40%;
	top:85%;
	color:black;
	font-family:微软雅黑;
	font-size:20px;
	position:absolute;
}
</style>
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
		if(!getid($_SESSION['openid']))die("请求参数错误！");
		
		
	?>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js"></script>
<script src="jquery.rotate.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<script>
 function loadStop(){
     $("html").removeClass("ui-loader");
     $(".ui-loader").remove();
 }

</script>

<script>

function restart()
{
	<?php echo 'window.location.href="index.php?openid='.$_SESSION[openid].'";'; ?>
}
function subscore()
{
	<?php echo 'window.location.href="top.php?openid='.$_SESSION[openid].'&score="+score;'; ?>
}
function addscore(s)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("POST","setscore.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("score="+s);
}
var width,height,boxWidth,boxHeight;
var scrolly;
var score=-1;
var stage=0;
var serial=0;
var over=false;
var food=false;
var begin=false;
var cd=true;
var table=["#DCDCDC","#D9FCF5","#dbecfc","#fde9fd","#fafdea"];
$(document).ready(function(){
	loadStop();
	var timer;
	width=document.body.clientWidth;
	height=document.documentElement.clientHeight;
	boxWidth=width/8;
	boxHeight=boxWidth;
	$("#con").width(width);
	$("#con").height(height);
	$(".square").css({width:boxWidth,height:boxHeight});
	$(".food").css({width:boxWidth,height:boxHeight});
	$("#box").css({width:boxWidth*3,height:boxHeight*3,top:(height-3*boxWidth)/2});
	$("#score").css({left:boxWidth/3,
	top:boxHeight/3});
	$("#msg").css({left:boxWidth*3,
	top:(height-3*boxWidth)/2+boxHeight*3.5});
	$("#msg").hide();
	$("#ready").css({top:boxHeight*3,left:(width-parseFloat($("#ready").css("width")) )/2});
	$("#ready").animate({fontSize:"28px"},{
		duration:500
	});
	$("#ready").animate({fontSize:"20px"},{
		duration:500,
		complete:
		function()
		{
			$("#ready").html("Bingo!");
			$("#ready").css({top:boxHeight*3,left:(width-parseFloat($("#ready").css("width")) )/2},1000);
			$("#ready").animate({fontSize:"36px"},{
				duration:1000
			});
			$("#ready").animate({fontSize:"20px"},{
				duration:1000,
				complete:function()
				{
					$("#ready").hide(1000,null,function(){
					fire();
					begin=true;
					});
				}
			});
		}
	});
	
	var x=1,y=1;
	var gameOver=function(){clearInterval(timer);
		$("#score").text("GameOver: Score"+score);
		$("#score").animate({left:2*boxWidth,top:2*boxWidth,fontSize:"40px"},{duration:1000});
		over=true;
		addscore(score);
		$("img").stop();
		$("img").remove();
		$("div.square").remove();
		if(score<=20)
	  	{
		  $("#msg").hide(300,null,function(){
		  $("#msg").html("这么弱活该单身狗！");
		  $("#msg").show(300);});
	  	}
		else if(score<50)
	  	{
		  $("#msg").hide(300,null,function(){
		  $("#msg").html("争取达到50分！");
		  $("#msg").show(300);});
	  	}
		$("#box").rotate({
		  angle:0, 
		  animateTo:150, 
		  queue:false,
		  callback: function(){
			  $("#con").append("<a id='restart' onclick='restart()'>重新开始</a>");
			  $("#con").append("<a id='top' onclick='subscore()'>提交分数</a>");
			  
			  },
		  easing: function (x,t,b,c,d){        // t: current time, b: begInnIng value, c: change In value, d: duration
          	return c*(t/d)+b;
      		}
   		});
		
	};
	var updateDog=function(){
		if(!cd)return;
		cd=false;
		$(".square").animate({left:x*boxWidth,top:y*boxHeight},{duration:100,complete:
			function()
			{
				cd=true;
			}
		}
		);
	};
	var rotation = function (a){
   a.rotate({
      angle:0, 
      animateTo:360, 
	  queue:false,
      callback: function(){rotation(a);},
      easing: function (x,t,b,c,d){        // t: current time, b: begInnIng value, c: change In value, d: duration
          return c*(t/d)+b;
      }
   });
	}
	var destroyp=function(e)
	{
		e.remove();
		fire();
	};
	var nextleft=function(py){
		$("#con").append("<img id='pleft"+serial+"' class='bomb' src='images/bomb"+parseInt(Math.random()*1+1)+".png' style='position:absolute;width:"+boxWidth+"px;height:"+boxHeight+";top:"+((height-3*boxWidth)/2+py*boxHeight)+"px;left:0px;'>");
		var a=$("#pleft"+serial);
		serial++;
		//rotation(a);
		a.animate({left:width-boxWidth},{duration:5000-stage*200,queue:false,complete:function(){destroyp(a);}});
	};
	var nextright=function(py){
		$("#con").append("<img id='pleft"+serial+"' class='bomb' src='images/bomb"+parseInt(Math.random()*1+1)+".png' style='position:absolute;width:"+boxWidth+"px;height:"+boxHeight+";top:"+((height-3*boxHeight)/2+py*boxHeight)+"px;left:"+(width-boxWidth)+"px;'>");
		var a=$("#pleft"+serial);
		serial++;
		//rotation(a);
		a.animate({left:0},{duration:5000-stage*200,queue:false,complete:function(){destroyp(a);}});
	};
	var nexttop=function(px){
		$("#con").append("<img id='pleft"+serial+"' class='bomb' src='images/bomb"+parseInt(Math.random()*1+1)+".png' style='position:absolute;width:"+boxWidth+"px;height:"+boxHeight+";left:"+((width-3*boxWidth)/2+px*boxWidth)+"px;top:0px;'>");
		var a=$("#pleft"+serial);
		serial++;
		//rotation(a);
		a.animate({top:height-boxHeight},{duration:5000-stage*200,queue:false,complete:function(){destroyp(a);}});
	};
	var nextbottom=function(px){
		$("#con").append("<img id='pleft"+serial+"' class='bomb' src='images/bomb"+parseInt(Math.random()*1+1)+".png' style='position:absolute;width:"+boxWidth+"px;height:"+boxHeight+";left:"+((width-3*boxWidth)/2+px*boxWidth)+"px;top:"+(height-boxHeight)+"px;'>");
		var a=$("#pleft"+serial);
		serial++;
		//rotation(a);
		a.animate({top:0},{duration:5000-stage*200,queue:false,complete:function(){destroyp(a);}});
	};
	var fire=function()
	{
		var temp=parseInt(Math.random()*4);
		switch(temp)
		{
			case 0:
			nextleft(parseInt(Math.random()*3));
			break;
			case 1:
			nextright(parseInt(Math.random()*3));
			break;
			case 2:
			nexttop(parseInt(Math.random()*3));
			break;
			case 3:
			nextbottom(parseInt(Math.random()*3));
			break;
			
		}
	};
	//fire();
	
	updateDog();
  $(document).on("tap",function(e){
	  if(!begin)return;
	  if(over)return;
	  if(!cd)return;
	 var offsetx=e.clientX-((width-3*boxWidth)/2+x*boxWidth+0.5*boxWidth);
	 var offsety=e.clientY-((height-3*boxWidth)/2+y*boxWidth+0.5*boxWidth);
	 if(offsetx>0&&x<2&&Math.abs(offsetx)>Math.abs(offsety))x++;
	 if(offsetx<2&&x>0&&Math.abs(offsetx)>Math.abs(offsety))x--;
	 if(offsety>0&&y<2&&Math.abs(offsetx)<Math.abs(offsety))y++;
	 if(offsety<2&&y>0&&Math.abs(offsetx)<Math.abs(offsety))y--;
	 updateDog();
  });
 var nextfood=function(px,py)
	{
		$(".food").css({left:((width-3*boxWidth)/2+px*boxWidth),
		top:((height-3*boxHeight)/2+py*boxHeight),width:0,height:0});
		$(".food").animate({width:boxWidth,height:boxHeight},{duration:200,complete:function(){food=true;}});
	};
	//nextfood(parseInt(Math.random()*3),parseInt(Math.random()*3));
  var addScore=function()
  {
	  score++;
	  $("#score").text("Score:"+score);
	  $("#socre").stop();
	  $("#score").animate({fontSize:"32px"},{duration:500,queue:true});
	  $("#score").animate({fontSize:"24px"},{duration:500,queue:true});
	  
	  food=false;
	  $(".food").animate({width:0,height:0},{duration:200,complete:function(){nextfood(parseInt(Math.random()*3),parseInt(Math.random()*3));}});
	  if(score%10==0){stage++;$("#container").css({backgroundColor:table[stage-1]});}
	  if(score%10==9)fire();
	  if(stage==2)$("#box").css({backgroundImage:"url(images/map.png)"});
	  if(score==10)
	  {
		  $("#msg").html("单身狗加油哦！");
		  $("#msg").show(300);
	  }
	  if(score==20)
	  {
		  $("#msg").hide(300,null,function(){
		  $("#msg").html("单身狗你好厉害哦！");
		  $("#msg").show(300);});
	  }
	  if(score==30)
	  {
		  $("#msg").hide(300,null,function(){
		  $("#msg").html("不愧为单身狗哦！");
		  $("#msg").show(300);});
	  }
	  if(score==40)
	  {
		  $("#msg").hide(300,null,function(){
		  $("#msg").html("活该单身狗！");
		  $("#msg").show(300);});
	  }
	  if(score==50)
	  {
		  $("#msg").hide(300,null,function(){
		  $("#msg").html("天下第一狗！");
		  $("#msg").show(300);});
	  }
  }; 
  addScore();
  timer=setInterval(function(){
		$(".bomb").each(function(){
			var bx=parseFloat($(this).css("left"));
			
			var by=parseFloat($(this).css("top"));
			bx=(bx-(width-3*boxWidth)/2)
			/boxWidth;
			by=(by-(height-3*boxHeight)/2)
			/boxHeight;
			if(Math.abs(bx-x)<1&&Math.abs(by-y)<1)gameOver();
		})
		if(!food)return;
		var fx=parseFloat($(".food").css("left"));
		var fy=parseFloat($(".food").css("top"));
		fx=(fx-(width-3*boxWidth)/2)
			/boxWidth;
		fy=(fy-(height-3*boxHeight)/2)
			/boxHeight;
		if(Math.abs(fx-x)<1&&Math.abs(fy-y)<1)addScore();
	},100);                       
});
</script>
</head>

<body>
<div id="container" data-role="page">
<div data-role="header">
</div>
<div data-role="content" id="con">
<div id="score">Score:23</div>
<div id="ready">
Are You Ready?
</div>
<div id="box">
<img class="square" src="images/dog.png">

</div>
<div id="msg">
Message Here
</div>
<img class="food" src="images/food.png">
</div>
<div data-role="footer">
</div>
</div>
</body>
</html>
