<?php
session_start();
include("dbconn.php");

$tt=0;
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
/*
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

// Set your app credentials
$username   = "MyAppsUsername";
$apikey     = "MyAppAPIKey";

// Initialize the SDK
$AT         = new AfricasTalking($username, $apiKey);

// Get the SMS service
$sms        = $AT->sms();

// Set the numbers you want to send to in international format
$recipients = "+254711XXXYYY,+254733YYYZZZ";

// Set your message
$message    = "I'm a lumberjack and its ok, I sleep all night and I work all day";

// Set your shortCode or senderId
$from       = "myShortCode or mySenderId";
*/
$type=mysqli_real_escape_string($con,$_POST['type']);

if($type=="Fee"){
	$fee=mysqli_real_escape_string($con,$_POST['fee']);
	$frm=mysqli_real_escape_string($con,$_POST['form']);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	$message=mysqli_real_escape_string($con,$_POST['message']);
	if($class="All"){
	$sql="SELECT Name,balance from studentsrecord where Form='".$form."'";
	}else{
		
		$sql="SELECT Name,balance from studentsrecord where Form='".$form."' and Stream='".$class."'";
	}
}
elseif($type=="Exam"){
	$term=mysqli_real_escape_string($con,$_POST['term']);
	$exam=mysqli_real_escape_string($con,$_POST['exam']);
	$frm=mysqli_real_escape_string($con,$_POST['form']);
	$class=mysqli_real_escape_string($con,$_POST['class']);
	$message=mysqli_real_escape_string($con,$_POST['message']);
	if($exam="ALL"){
	if($class="All"){
	$ss="";
		
		$tb=strtolower(str_replace(" ","",$form))."term";
		for($i=1;$i<=$tt;$i++){
			$ss.=",S".$i;
		}
		
	$sql="SELECT subscores2.Adm,NAME,PosClass,PosStream,TotalPercent,Grade".$ss."FROM $tb LEFT JOIN subscores2 ON($tb.Adm=subscores2.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE subscores2.term='".$term."' and subscores2.Year='".Date("Y")."'";
	}else{
		$ss="";
		
		$tb=strtolower(str_replace(" ","",$form))."term";
		for($i=1;$i<=$tt;$i++){
			$ss.=",S".$i;
		}
		
	$sql="SELECT subscores2.Adm,NAME,PosClass,PosStream,TotalPercent,Grade".$ss."FROM $tb LEFT JOIN subscores2 ON($tb.Adm=subscores2.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE $tb.Stream='".$class."' and subscores2.term='".$term."' and subscores2.Year='".Date("Y")."'";
	}
		
	}else{
		$e=str_replace("-","",str_replace(" ","",$exam));
		$tb=strtolower(str_replace(" ","",$form)).$e;
		if($class="All"){
	$sql="SELECT subscores.Adm,NAME,PosClass,PosStream,TotalPercent,Grade,avg(S1) FROM $tb LEFT JOIN subscores ON($tb.Adm=subscores.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE subscores.exam='".$e."' and subscores.term='".$term."' and subscores.Year='".Date("Y")."'";
	}else{
		
		$sql="SELECT subscores.Adm,NAME,PosClass,PosStream,TotalPercent,Grade,S1,S1 FROM $tb LEFT JOIN subscores ON($tb.Adm=subscores.Adm) LEFT JOIN sudtls ON($tb.Adm=sudtls.Adm) WHERE subscores.exam='".$e."' and $tb.Stream='".$class."' and subscores.term='".$term."' and subscores.Year='".Date("Y")."'";
	}
	}
	
	
	$res=$con->query($sql);
	
	$rtm.='<table class="table">
	<thead>
	<th>Adm</th>
	<th>NAME</th>
	<th>PosC</th>
	<th>PosS</th>
	<th>TT</th>
	<th>Grade</th>';
	  
	  $qs="SELECT concat(UPPER(Abbreviation),' (',code,')') AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						
						 $rtm.=' <th scope="col">'.$sr['subs'].'</th>';
						  
						  
						  }
						 
	
	$rtm.='</thead>
	
	<tbody>';

	while($rs=$res->fetch_assoc()){
		
						$rtm.='<tr>
					  <td>'.$rs['Adm'].'</td>
					  <td>'.$rs['Name'].'</td>
					  <td>'.$rs['PosClass'].'</td>	
					  <td>'.$rs['PosStream'].'</td>
					  <td>'.$rs['TotalPercent'].'</td>
					  <td>'.$rs['Grade'].'</td>';
							
			$i=1;				  
		$qs="SELECT code,concat(UPPER(Abbreviation),' (',code,')') AS subs FROM subjects order by code asc";
		$subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			$qs2="SELECT concat(UPPER(Subject),' (',Code,')') AS subs2 FROM  subjectoptionsa where Code='".$sr['code']."' order by Code asc";
		$subs2=mysqli_query($con,$qs2);
		while($sr2=mysqli_fetch_assoc($subs2)){
						  $rtm.='<td scope="col">'.$sr['subs2'].'</td>';
						  
						  
						  }
						  $i+=1;
						  
		}
		
		$rtm.='</tr>';
	}
	
	$rtm.='</tbody>
	</table>';
	
	
	
	
	
	
	
	
	
}else{
	
	$cat=mysqli_real_escape_string($con,$_POST['cat']);
	
	$message=mysqli_real_escape_string($con,$_POST['message']);
	
}

echo $rtm;
							
							echo $type;
/*
try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => $recipients,
        'message' => $message,
        'from'    => $from
    ]);

    print_r($result);
} catch (Exception $e) {
    echo "Error: ".$e->getMessage();
} */
?>