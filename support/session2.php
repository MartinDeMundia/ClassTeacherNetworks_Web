<?php
session_start();
ini_set('max_execution_time', 1000);
 include_once("dbconn.php");
 if (mysqli_real_escape_string($con,$_POST['para'])=="search"){
	 $s=mysqli_real_escape_string($con,$_POST['stream']);
	$f=mysqli_real_escape_string($con,$_POST['form']);
	$q="UPDATE cur_class SET frm='$f',cls='$s' WHERE id=1";
	if($con->query($q)){
	echo "index.php?admin/options/".$_SESSION['ff']."";
 }else{
	 echo $con->error;
 }
 } elseif(mysqli_real_escape_string($con,$_POST['para'])=="search2"){
	$s=mysqli_real_escape_string($con,$_POST['stream']);
	$f=mysqli_real_escape_string($con,$_POST['form']);
	$q="UPDATE cur_class SET frm='$f',cls='$s' WHERE id=1";
	if($con->query($q)){
	echo "index.php?admin/allocation";
 }else{
	 echo $con->error;
 }
	
 }
 else{
	 
	 if((mysqli_real_escape_string($con,$_POST['exam']))=="END OF TERM"){
		$_SESSION['en']="all";
		$_SESSION['exm']="all";
	}else{
		$_SESSION['en']=mysqli_real_escape_string($con,$_POST['exam']);
		$_SESSION['exm']=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
	}
	$_SESSION['enn']=mysqli_real_escape_string($con,$_POST['exam']); 
$_SESSION['form']="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$_SESSION['f2']="form".mysqli_real_escape_string($con,$_POST['form']);
$_SESSION['Stream']=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$_SESSION['year']=mysqli_real_escape_string($con,$_POST['year']);
$_SESSION['examdate']=mysqli_real_escape_string($con,$_POST['year']);
///$_SESSION['en']=mysqli_real_escape_string($con,$_POST['exam']);
$_SESSION['term']=mysqli_real_escape_string($con,$_POST['term']);
//$_SESSION['exm']=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
$_SESSION['cat1']=mysqli_real_escape_string($con,$_POST['c1']);
$_SESSION['cat2']=mysqli_real_escape_string($con,$_POST['c2']);
$_SESSION['cat3']=mysqli_real_escape_string($con,$_POST['c3']);
$_SESSION['subjects']=mysqli_real_escape_string($con,$_POST['subjects']);
if (isset($_SESSION['en'])){echo 1;}
else{echo 0;}
 }


?>