<?php
require("../connect.php");
$con=mysqli_connect($mysql_address,$mysql_username,$mysql_password);
if(!$con)die("Connect Error!");
mysqli_query($con,"set names 'utf8' ");
mysqli_query($con,"set character_set_client=utf8");  
mysqli_query($con,"set character_set_results=utf8");
mysqli_select_db($con,$mysql_db);
$result=mysqli_query($con,"select * from choujiang where `id`='$_GET[id]'");
if(!$result)exit("0");
$row=mysqli_fetch_array($result);
switch($_GET[act])
{
	case "6":
	$row[6]++;
	$reslut=mysqli_query($con,"update choujiang set `num`='$row[6]' where `id`='$_GET[id]'");
	if(!$result){$row[6]--;exit("$row[6]");}
	else exit("$row[6]");
	break;
	case "7":
	if($row[7]==0)exit("0");
	$row[7]--;
	$reslut=mysqli_query($con,"update choujiang set `gift1`='$row[7]' where `id`='$_GET[id]'");
	if(!$result){$row[7]++;exit("$row[7]");}
	else exit("$row[7]");
	break;
	case "8":
	if($row[8]==0)exit("0");
	$row[8]--;
	$reslut=mysqli_query($con,"update choujiang set `gift2`='$row[8]' where `id`='$_GET[id]'");
	if(!$result){$row[8]++;exit("$row[8]");}
	else exit("$row[8]");
	break;
	case "9":
	if($row[9]==0)exit("0");
	$row[9]--;
	$reslut=mysqli_query($con,"update choujiang set `gift3`='$row[9]' where `id`='$_GET[id]'");
	if(!$result){$row[9]++;exit("$row[9]");}
	else exit("$row[9]");
	break;
	case "10":
	if($row[10]==0)exit("0");
	$row[10]--;
	$reslut=mysqli_query($con,"update choujiang set `gift4`='$row[10]' where `id`='$_GET[id]'");
	if(!$result){$row[10]++;exit("$row[10]");}
	else exit("$row[10]");
	break;
	case "11":
	if($row[6]==0)exit("-1");
	$row[6]--;
	$reslut=mysqli_query($con,"update choujiang set `num`='$row[6]' where `id`='$_GET[id]'");
	if(!$result){$row[6]++;exit("$row[6]");}
	else exit($row[6]);
	case "2":
	
}
?>