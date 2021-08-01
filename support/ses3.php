<?php
session_start();
 include_once("dbconn.php");
	if((mysqli_real_escape_string($con,$_POST['exam']))=="END OF TERM"){
		$_SESSION['en']="all";
		$_SESSION['exm']="all";
	}else{
		$_SESSION['en']=mysqli_real_escape_string($con,$_POST['exam']);
		$_SESSION['exm']=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
	}
//$_SESSION['st']=mysqli_real_escape_string($con,$_POST['st']);
$_SESSION['form']="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$_SESSION['adm']=mysqli_real_escape_string($con,$_POST['adm']);
$_SESSION['f2']="form".mysqli_real_escape_string($con,$_POST['form']);
$_SESSION['Stream']=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$_SESSION['year']=mysqli_real_escape_string($con,$_POST['year']);
$_SESSION['examdate']=mysqli_real_escape_string($con,$_POST['year']);
$_SESSION['ff']=mysqli_real_escape_string($con,$_POST['form']);
$_SESSION['term']=mysqli_real_escape_string($con,$_POST['term']);

if(isset($_SESSION['exm'])){
	
	echo 1;
}

		
?>