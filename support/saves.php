<?php
require("dbconn.php");

$st=mysqli_real_escape_string($con,$_POST['stream']);
$fm="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$code=mysqli_real_escape_string($con,$_POST['code']);
$empid=mysqli_real_escape_string($con,$_POST['empid']);
$f=0;
$sub='';
$initials='';
$q12="select Initial , Names from staffs where Empno='$empid' ";

$r12=$con->query($q12);
while($row12=$r12->fetch_assoc()){
	
	$initials=$row12['Initial'];
	$name=$row12['Names'];
}

$q1="select Abbreviation  from subjects where Code='$code' ";

$r1=$con->query($q1);
while($row1=$r1->fetch_assoc()){
	
	$sub=$row1['Abbreviation'];
}
$q="select count(*) as c from subjectallocationa where Code='$code' and Form='$fm' and Stream='$st' and Empno='$empid'";

$r=mysqli_query($con,$q);
while($row=mysqli_fetch_assoc($r)){
	
	$f=$row['c'];
}
if($f>=1){
	
	$qq="UPDATE subjectallocationa  set Code=$code,Subject=$sub  where Code='$code' and Form='$fm' and Stream='$st' and Empno='$empid'";

	
	
}else{
	$qq= "INSERT INTO subjectallocationa(Name,Initial,Code,Subject,Form,Stream,Empno) VALUES('$name','$initials','$code', '$sub', '$fm', '$st', '$empid')";
}
if ($con->query($qq)===TRUE){
	
	echo 1;
}
else{
	
	
}
?>