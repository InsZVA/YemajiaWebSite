<?php
	require_once 'connect.php';
	function gettoken()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from wxgame_token");
		if(!$result)return false;
		$row=mysqli_fetch_array($result);
		if(!$row)return false;
		if(time()-$row[1]>6000)return false;
		return $row[0];
	}
	function updatetoken($token)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=time();
		$result=mysqli_query($con,"update wxgame_token set access_token='$token',time=$time where id=1");
	}
	function getjsticket()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from wxgame_token");
		if(!$result)return false;
		$row=mysqli_fetch_array($result);
		if(!$row)return false;
		$row=mysqli_fetch_array($result);
		if(!$row)return false;
		if(time()-$row[1]>6000)return false;
		return $row[0];
	}
	function updatejsticket($ticket)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=time();
		$result=mysqli_query($con,"update wxgame_token set access_token='$ticket',time=$time where id=2");
	}
	function insert($openid,$super,$nickname,$imgurl,$qrcode)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600-24*3600);
		$result=mysqli_query($con,"select count(*) from wxgame where openid='$openid'");
		$row=mysqli_fetch_array($result);
		if($row[0]!=0)return false;
		$result=mysqli_query($con,"insert into wxgame(openid,lastdate,score,super,nickname,imgurl,qrcode,lastdate2) VALUES('$openid','$time','0','$super','$nickname','$imgurl','$qrcode','$time')");
		if(!result)return false;
		$result=mysqli_query($con,"insert into choujiang(`openid`,`num`) VALUES('$openid','1')");
		if(!result)return false;
		mysqli_close($con);
		return true;
	}
	function getnextid()
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"sELECT AUTO_INCREMENT from information_schema.`TABLES` WHERE TABLE_SCHEMA='qdm158444573_db' AND TABLE_NAME='wxgame';");
		if(!$result)return false;
		$row=mysqli_fetch_array($result);
		if(!row)return false;
		mysqli_close($con);
		return $row[0];
	}
	function addscore($openid,$score)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600);
		$result=mysqli_query($con,"select * from wxgame where openid='$openid'");
		if(!$result)
		{
			$result=mysqli_query($con,"insert into wxgame(`openid`,`lastdate`,`score`,`super`,`nickname`,`imgurl`,`qrcode`,`lastdate2`) VALUES('$openid','$time','$score','$super','$nickname','$imgurl','$qrcode','$time')");
			return true;
		}
		$row=mysqli_fetch_assoc($result);
		if($row['lastdate']==$time)return false;
		$row['score']+=$score;
		$result=mysqli_query($con,"update wxgame set score='$row[score]',lastdate='$time' where openid='$openid'");
		if(!$result)return false;
		mysqli_close($con);
		return true;
	}
	function addscore2($openid,$score)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600);
		$result=mysqli_query($con,"select * from wxgame where openid='$openid'");
		if(!$result)
		{
			$result=mysqli_query($con,"insert into wxgame(`openid`,`lastdate`,`score`,`super`,`nickname`,`imgurl`,`qrcode`,`lastdate2`) VALUES('$openid','$time','$score','$super','$nickname','$imgurl','$qrcode','$time')");
			return true;
		}
		$row=mysqli_fetch_assoc($result);
		if($row['lastdate2']==$time)return false;
		$row['score']+=$score;
		$result=mysqli_query($con,"update wxgame set score='$row[score]',lastdate2='$time' where openid='$openid'");
		if(!$result)return false;
		mysqli_close($con);
		return true;
	}
	function getscore($openid)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from wxgame where openid='$openid'");
		if(!$result)return 0;
		$row=mysqli_fetch_assoc($result);
		if(!$row)return 0;
		return $row['score'];
		
	}
	function isplayed($openid)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600);
		$result=mysqli_query($con,"select * from wxgame where openid='$openid'");
		if(!$result)return false;
		$row=mysqli_fetch_assoc($result);
		mysqli_close($con);
		return($row['lastdate']==$time);
	}
	function isplayed2($openid)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$time=gmdate("Y-m-d",time()+8*3600);
		$result=mysqli_query($con,"select * from wxgame where openid='$openid'");
		if(!$result)return false;
		$row=mysqli_fetch_assoc($result);
		mysqli_close($con);
		return($row['lastdate2']==$time);
	}
	function getid($openid)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from wxgame where openid='$openid'");
		if(!$result)return false;
		$row=mysqli_fetch_assoc($result);
		if(!row)return false;
		mysqli_close($con);
		return $row['id'];
	}
	function getidc($openid)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from choujiang where openid='$openid'");
		if(!$result)return false;
		$row=mysqli_fetch_assoc($result);
		if(!row)return false;
		mysqli_close($con);
		return $row['id'];
	}
	function remove($openid)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)return false;
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"delete from wxgame where openid='$openid'");
		if(!result)return false;
		mysqli_close($con);
		return true;
	}
?>