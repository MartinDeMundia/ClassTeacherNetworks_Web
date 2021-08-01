<?php
//session_start();
include("dbconn.php");
require '../vendor/autoload.php';
$tt=0;
$status="Sent";
$fld=0;
$response=1;
$dt=2015;
$ss='';
$rtm='';
$mess='';
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
		for($i=1;$i<=$tt;$i++){
			$ss.=",S".$i;
		}
		
			$q1s="select description from settings where type='clickatell_user'";
$key='';
$user='';
$sed='';
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$key=$row2s['description'];
	
}

$q1s="select description from settings where type='clickatell_api_id'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$sed=$row2s['description'];
	
}

$q1s="select description from settings where type='clickatell_password'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$user=$row2s['description'];
	
}

use AfricasTalking\SDK\AfricasTalking;

// Set your app credentials
$username   = $user;
$apikey     = $key;

// Initialize the SDK
$AT         = new AfricasTalking($username, $apiKey);

// Get the SMS service
$sms        = $AT->sms();

// Set the numbers you want to send to in international format


// Set your message


// Set your shortCode or senderId
$from       = $sed;

$type=mysqli_real_escape_string($con,$_POST['type']);
//$cat=mysqli_real_escape_string($con,$_POST['cat']);
if($type=="Fee"){
	$fee=mysqli_real_escape_string($con,$_POST['fee']);
	$form=mysqli_real_escape_string($con,$_POST['form']);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	$message=mysqli_real_escape_string($con,$_POST['message']);
	if($class=="All"){
	$sql="SELECT sAdm,studentsrecord.Name,balance,Phone from studentsrecord LEFT JOIN sudtls ON(studentsrecord.sAdm=sudtls.Adm) where studentsrecord.Form='".$form."'";
	}else{
		
		$sql="SELECT sAdm,studentsrecord.Name,balance,Phone from studentsrecord  LEFT JOIN sudtls ON(studentsrecord.sAdm=sudtls.Adm) where studentsrecord.Form='".$form."' and studentsrecord.Stream='".$class."'";
	}
	
	$res=$con->query($sql);
	while($rs=$res->fetch_assoc()){
		$m1=str_replace("#balance","KES ".number_format($rs['balance']),$message);
		$m2=str_replace("#name",$rs['Name'],$m1);
		$m3=str_replace("#adm",$rs['sAdm'],$m2);
	$mess=$m3;
	try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => $rs['Phone'],
        'message' => $mess,
        'from'    => $from
    ]);
$response+=1;
   $status="Sent";
} catch (Exception $e) {
	$status="Failed";
   $fld+=1;
}

$strQry="INSERT INTO messages(uniques,Name,Category,Phone,Message,Status,Date) VALUES('".$rs['sAdm']."','".$rs['Name']."','Parents','".$rs['Phone']."','".$mess."','$status','".Date("d/m/Y")."')";
	
	if ($con->query($strQry)){
						
	} else
	{
		echo $con->error;
	}

	}
}
elseif($type=="Exam"){
	
	$term=mysqli_real_escape_string($con,$_POST['term']);
	$exam=mysqli_real_escape_string($con,$_POST['exam']);
	$form=mysqli_real_escape_string($con,$_POST['form']);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	$message=mysqli_real_escape_string($con,$_POST['message']);
	
	if($exam=="All"){
	if($class=="All"){
	$ss="";
		
		$tb=strtolower(str_replace(" ","",$form))."term";
		for($i=1;$i<=$tt;$i++){
			$ss.=",S".$i;
		}
		
	$sql="SELECT subscores2.Adm,NAME,Phone,PosClass,PosStream,TotalPercent,Grade".$ss." FROM $tb LEFT JOIN subscores2 ON($tb.Adm=subscores2.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE subscores2.term='".$term."' and subscores2.Year='".$dt."'";
	}else{
		$ss="";
		
		$tb=strtolower(str_replace(" ","",$form))."term";
		for($i=1;$i<=$tt;$i++){
			$ss.=",S".$i;
		}
		
	$sql="SELECT subscores2.Adm,NAME,Phone,PosClass,PosStream,TotalPercent,Grade".$ss." FROM $tb LEFT JOIN subscores2 ON($tb.Adm=subscores2.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE $tb.Stream='".$class."' and subscores2.term='".$term."' and subscores2.Year='".$dt."'";
	}
		
	}else{
		$e=str_replace("-","",str_replace(" ","",$exam));
		$tb=strtolower(str_replace(" ","",$form)).$e;
		if($class=="All"){
	$sql="SELECT subscores.Adm,NAME,Phone,PosClass,PosStream,TotalPercent,Grade".$ss." FROM $tb LEFT JOIN subscores ON($tb.Adm=subscores.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE subscores.exam='".$e."' and subscores.term='".$term."' and subscores.Year='".$dt."'";
	}else{
		
		$sql="SELECT subscores.Adm,NAME,Phone,PosClass,PosStream,TotalPercent,Grade,S1,S1 FROM $tb LEFT JOIN subscores ON($tb.Adm=subscores.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE subscores.exam='".$e."' and $tb.Stream='".$class."' and subscores.term='".$term."' and subscores.Year='".$dt."'";
	}
	}
	
	//echo $sql;
	$res=$con->query($sql);
	
	
	
						 
	
	

	while($rs=$res->fetch_assoc()){
		
		$mess=$message.'
';				
	$mess.=' ADM NO- '.$rs['Adm'].'
					  NAME-'.$rs['NAME'].'
					  Position in class '.$rs['PosClass'].'	
					  Position in Stream '.$rs['PosStream'].'
					  Mean Score '.$rs['TotalPercent'].'
					  Grade '.$rs['Grade'].'
					  ';
							
			$i=1;
			
		$qs="SELECT code,concat(UPPER(Abbreviation),' (',code,')') AS subs FROM subjects order by code asc";
		$subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			$s="S".$i;
			$qs2="SELECT count(code) AS subsa2,Subject FROM  subjectoptionsa where Code='".$sr['code']."' and Adm='".$rs['Adm']."'order by Code asc";
		$subs2=mysqli_query($con,$qs2);
		while($sr2=mysqli_fetch_assoc($subs2)){
			
			if (($sr2['subsa2'])<1){
				 //$mess.='<td scope="col">'.$sr2['subsa2'].'';
			}else{
						  $mess.=$sr2['Subject'].'-'.$rs[$s].'
						';
						  
			}		  
				}		  
						  $i+=1;
						  
		}
		try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => $rs['Phone'],
        'message' => $mess,
        'from'    => $from
    ]);
$response+=1;
   $status="Sent";
} catch (Exception $e) {
	$status="Failed";
   $fld+=1;
}

		
		$strQry="INSERT INTO messages(uniques,Name,Category,Phone,Message,Status,Date) VALUES('".$rs['Adm']."','".$rs['NAME']."','Parents','".$rs['Phone']."','".$mess."','$status','".Date("d/m/Y")."')";
	
	if ($con->query($strQry)){
							
	}else
	{
		echo $strQry.$con->error;
	}	
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
}else{
	
	$cat=mysqli_real_escape_string($con,$_POST['cat']);
	
	$message=mysqli_real_escape_string($con,$_POST['message']);
	$form=mysqli_real_escape_string($con,$_POST['form']);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	if($cat=="Parents"){
	
	
	if($class=="All"){
	$sql="SELECT Adm,Name,Phone from sudtls where Form='".$form."'";
	}else{
		
		$sql="SELECT Adm,Name,Phone from sudtls where Form='".$form."' and Stream='".$class."'";
	}
	
	$res=$con->query($sql);
	while($rs=$res->fetch_assoc()){
		
		$m2=str_replace("#name",$rs['Name'],$message);
		$m3=str_replace("#adm",$rs['Adm'],$m2);
	$mess=$m3;
	try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => $rs['Phone'],
        'message' => $mess,
        'from'    => $from
    ]);
$response+=1;
   $status="Sent";
} catch (Exception $e) {
	$status="Failed";
   $fld+=1;
}

$strQry="INSERT INTO messages(uniques,Name,Category,Phone,Message,Status,Date) VALUES('".$rs['Adm']."','".$rs['Name']."','".$cat."','".$rs['Phone']."','".$mess."','$status','".Date("d/m/Y")."')";
	
	if ($con->query($strQry)){
							
	}else
	{
		echo $con->error;
	}
	}
}

else{
	
	
		
		$sql="SELECT Empno,Names,Phone from staffs where Category='".$cat."'";
	
	
	$res=$con->query($sql);
	while($rs=$res->fetch_assoc()){
		
		$m2=str_replace("#name",$rs['Names'],$message);
		$m3=str_replace("#EmpNo",$rs['Empno'],$m2);
	$mess=$m3;
	
try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => $rs['Phone'],
        'message' => $mess,
        'from'    => $from
    ]);
$response+=1;
   $status="Sent";
} catch (Exception $e) {
	$status="Failed";
   $fld+=1;
}

	$strQry="INSERT INTO messages(uniques,Name,Category,Phone,Message,Status,Date) VALUES('".$rs['Empno']."','".$rs['Names']."','".$cat."','".$rs['Phone']."','".$mess."','$status','".Date("d/m/Y")."')";
	
	if ($con->query($strQry)){
							
	}else
	{
		echo $strQry.$con->error;
	}
	}
}

}
	
echo $response;							

 
?>