<?php
session_start();
require_once 'common.php';
require_once 'youzan.php';
function refresh()
{
	global $mysql_address,$mysql_username,$mysql_password,$mysql_db;
		$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
		if(!$con)die("Connect Error!");
		mysqli_query($con,"set names 'utf8' ");
		mysqli_query($con,"set character_set_client=utf8");  
		mysqli_query($con,"set character_set_results=utf8");
		mysqli_select_db($con,$mysql_db);
		$result=mysqli_query($con,"select * from member where id<>3");
		$row=mysqli_fetch_assoc($result);
		while($row)
		{
			$sell=0;
			$sell=getsell($row['youzan']);
			$fee=0;
			$fee=getfee($row['id']);
			$result2=mysqli_query($con,"update account set sell=$sell where uid=$row[id]");
			//echo "update account set sell=$sell where uid=$row[id]";
			$result2=mysqli_query($con,"update account set fee=$fee where uid=$row[id]");
			//echo "update account set fee=$fee where uid=$row[id]";
			$row=mysqli_fetch_assoc($result);
		}
		mysqli_close($con);
		
}
if($_SESSION['uid']==3)refresh();
echo "<script>history.go(-1);</script>";
?>