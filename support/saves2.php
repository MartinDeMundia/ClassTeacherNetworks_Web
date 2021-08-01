<?php
require("dbconn.php");
session_start();
$st=mysqli_real_escape_string($con,$_POST['stream']);
$fm="FORM ".mysqli_real_escape_string($con,$_POST['form']);

$code=mysqli_real_escape_string($con,$_POST['code']);
$empid=mysqli_real_escape_string($con,$_POST['empid']);
$f=0;
$sub='';
$initials='';
$q12="select  Name from sudtls where Adm='$empid' ";

$r12=$con->query($q12);
while($row12=$r12->fetch_assoc()){
	
	$name=$row12['Name'];
}

$q1="select Abbreviation  from subjects where Code='$code' ";

$r1=$con->query($q1);
while($row1=$r1->fetch_assoc()){
	
	$sub=$row1['Abbreviation'];
}
$q="select count(*) as c from subjectoptionsa where Code='$code' and Form='$fm' and Stream='$st' and Adm='$empid'";

$r=mysqli_query($con,$q);
while($row=mysqli_fetch_assoc($r)){
	
	$f=$row['c'];
}
if($f>=1){
	
	$qq="UPDATE subjectoptionsa  set Code=$code,Subject=$sub  where Code='$code' and Form='$fm' and Stream='$st' and Adm='$empid'";

	
	
}else{
	$qq= "INSERT INTO subjectoptionsa(Name,Code,Subject,Form,Stream,Adm) VALUES('$name','$code', '$sub', '$fm', '$st', '$empid')";
}
if ($con->query($qq)===TRUE){
	
	echo 1;
}
else{
	$con->error;
	
}
?>