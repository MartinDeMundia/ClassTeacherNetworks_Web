<?php
session_start();
	include("dbconn.php");
$date=Date("d/m/Y");
$cat="";
$type="";$mess='';
		if(isset($_SESSION['date'])){
         $date=$_SESSION['date'];
		 $cat=$_SESSION['cat'];
		 $type=$_SESSION['type'];
         
        }
$sql="SELECT ID,uniques,Phone,Name,Message FROM messages where Category='".$cat."' and Date='".$date."'  and Status='".$type."'";

	
	$res=$con->query($sql);
	while($rs=$res->fetch_assoc()){
		
		$num=$rs['Phone'];
	$mess.=$rs['Message'];
	
$strQry="UPDATE messages SET Status='Sent' where ID='".$rs['ID']."'";
	
	if ($con->query($strQry)){
		echo 1;						
	}else
	{
		echo $con->error;
	}
	}
	//echo $strQry;
	
	?>