<?php
 include_once("dbconn.php");
 $status="";
 if(date("m")==12){
 $status="yes";
 }else{
 $status="no";
 }
$count=0;
$qq="SELECT * FROM sudtls where Form<=4";
$c=$con->query($qq);
$count=$c->num_rows;
	if($status=="yes"){
		
		$q="UPDATE sudtls SET Form=Form+1 WHERE Form<=4";
		if($con->query()){
		echo $count;
		}
		else{
		echo $con->error;
		}
	}else{
	echo "You can only promote students at end of the year. Please contact system super administrator";
	}



?>