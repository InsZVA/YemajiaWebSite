<?php

	require_once 'connect.php';
	require_once 'youzan.php';
	require_once 'sendemail.php';
	
	function getname($i)
	{
		
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where id=$i");
		$row=mysqli_fetch_array($result);
		mysqli_close($con);
		return $row[1];
	}
	function getyouzan($i)
	{
		
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where id=$i");
		$row=mysqli_fetch_assoc($result);
		mysqli_close($con);
		return $row['youzan'];
	}
	function getid($s)
	{
		
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where name='$s'");
		if(!$result)die("GetID Error!");
		$row=mysqli_fetch_array($result);
		mysqli_close($con);
		return $row[0];
	}
	function isancestor($i,$a)
	{
		return enumchild($i,$a);
	}
	function enumchild($i,$a)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where super='$a'");
		if(!$result){mysqli_close($con);return false;}
		$row=mysqli_fetch_array($result);
		if(!$row){mysqli_close($con);return false;}
		while($row)
		{
			if($row[0]==$i){mysqli_close($con);return true;}
			else if(enumchild($i,$row[0])){mysqli_close($con);return true;}
			$row=mysqli_fetch_array($result);
		}
		{mysqli_close($con);return false;}
		
	}
	function getfee($i)
	{
		$fee=0;
		enumfee($i,$fee,0.05);
		return $fee;
	}
	function enumfee($i,&$fee,$k)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where super='$i'");
		if(!$result){mysqli_close($con);return;}
		$row=mysqli_fetch_array($result);
		if(!$row){mysqli_close($con);return;}
		while($row)
		{
			$fee+=$k*_getsell($row[0]);
			$row=mysqli_fetch_array($result);
		}
		$result=mysqli_query($con,"select * from member where super='$i'");
		if(!$result){mysqli_close($con);return;}
		$row=mysqli_fetch_array($result);
		if(!$row){mysqli_close($con);return;}
		while($row)
		{
			enumfee($row[0],$fee,$k*0.2);
			$row=mysqli_fetch_array($result);
		}
		mysqli_close($con);
	}
	function getallsell($i)
	{
		$fee=_getsell($i);
		enumsell($i,$fee);
		return $fee;
	}
	function fanbei($i)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
			$result2=mysqli_query($con,"select * from account where uid='$i'");
			$row2=mysqli_fetch_assoc($result2);
			$num=$row2['fee']*2;
			$result2=mysqli_query($con,"update account set fee=$num where uid='$i'");
		mysqli_close($con);
		enumfanbei($i);
	}
	function enumsell($i,&$fee)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where super='$i'");
		if(!$result){mysqli_close($con);return;}
		$row=mysqli_fetch_array($result);
		if(!$row){mysqli_close($con);return;}
		while($row)
		{
			$fee+=_getsell($row[0]);
			$row=mysqli_fetch_array($result);
		}
		$result=mysqli_query($con,"select * from member where super='$i'");
		if(!$result){mysqli_close($con);return;}
		$row=mysqli_fetch_array($result);
		if(!$row){mysqli_close($con);return;}
		while($row)
		{
			enumsell($row[0],$fee);
			$row=mysqli_fetch_array($result);
		}
		mysqli_close($con);
	}
	function enumemail($i,$str)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where super='$i'");
		if(!$result){mysqli_close($con);return;}
		$row=mysqli_fetch_assoc($result);
		if(!$row){mysqli_close($con);return;}
		while($row)
		{
			
			send($row['email'],$str);
			enumemail($row['id'],$str);
			$row=mysqli_fetch_assoc($result);
		}
		mysqli_close($con);
	}
	function enumfanbei($i)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from member where super='$i'");
		if(!$result){mysqli_close($con);return;}
		$row=mysqli_fetch_assoc($result);
		if(!$row){mysqli_close($con);return;}
		while($row)
		{
			$result2=mysqli_query($con,"select * from account where uid='$row[0]'");
			$row2=mysqli_fetch_assoc($result2);
			$num=$row2['fee']*2;
			$result2=mysqli_query($con,"update account set fee=$num where uid='$row[0]'");
			$row=mysqli_fetch_assoc($result);
		}
		mysqli_close($con);
	}
	function _getsell($i)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from account where uid='$i'");
		$row=mysqli_fetch_assoc($result);
		mysqli_close($con);
		return $row['sell'];
	}
	function _getfee($i)
	{
		global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$i=mysqli_real_escape_string($con,$i);
		$result=mysqli_query($con,"select * from account where uid='$i'");
		$row=mysqli_fetch_assoc($result);
		mysqli_close($con);
		return $row['fee'];
	}
?>