<?php
session_start();
$q=$_GET['q'];
$d=$_GET['d'];
$m=$_GET['m'];
$y=$_GET['y'];
$mm="";
		switch($m){
			case "01":
			$mm='JAN';
			break;
			
			case "02":
			$mm='FEB';
			break;
			
			case "03":
			$mm='MAR';
			break;
			
			case "04":
			$mm='APR';
			break;
			
			case "05":
			$mm='MAY';
			break;
			
			case "06":
			$mm='JUN';
			break;
			
			case "07":
			$mm='JUL';
			break;
			
			case "08":
			$mm='AUG';
			break;
			
			case "09":
			$mm='SEP';
			break;
			
			case "10":
			$mm='OCT';
			break;
			
			case "11":
			$mm='NOV';
			break;
			
			default:
			$mm='DEC';
			break;
			
			
			
			
		}
		include("dbconn.php");
$_SESSION['cat']=$_GET['q'];
$_SESSION['type']=$_GET['type'];
$_SESSION['date']=$_GET['d'].'/'.$_GET['m'].'/'.$_GET['y'];
$_SESSION['success']="DATE $d  $mm  $y";
$date=$_SESSION['date'];
		 $cat=$_SESSION['cat'];
		 $type=$_SESSION['type'];
$query="SELECT count(*) as c  FROM messages where Category='".$cat."' and Date='".$date."'  and Status='".$type."'";
	$da=$con->query($query);
	while($row=$da->fetch_assoc()){
		echo $row['c'];
	}
?>