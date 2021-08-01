<?php
include_once("dbconn.php");

$marks=mysqli_real_escape_string($con,$_POST['marks']);
$outof=mysqli_real_escape_string($con,$_POST['outof']);
$limit=mysqli_real_escape_string($con,$_POST['limit']);
$single=mysqli_real_escape_string($con,$_POST['single']);
$subject=mysqli_real_escape_string($con,$_POST['subject']);
$paper=mysqli_real_escape_string($con,$_POST['paper']);
$admno=mysqli_real_escape_string($con,$_POST['admno']);
$form=mysqli_real_escape_string($con,$_POST['form']);
$Stream=mysqli_real_escape_string($con,$_POST['stream']);
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$exam=mysqli_real_escape_string($con,$_POST['exam']);
$exam2= str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam'])));
$code="";
$score1=0;
$score2=0;
$limit1=0;
$limit2=0;
$update=0;
$b_updates=0;
$subtr="";
$tb="scores";
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
$overal=($marks/$outof)*$limit;
$avgoveral=0.0;
if($marks>0){
if ($subject=="GEO" or $subject=="geo" or $subject=="BIO" or $subject=="bio"){
	$subtr=substr($subject,0,1)."O";
}else{
	$subtr=substr($subject,0,2)."O";
}

//FETCH SUBJECT CODE
$qs="SELECT code  FROM subjects where Abbreviation='$subject'";
$results=mysqli_query($con,$qs);
while($rs=mysqli_fetch_assoc($results)){
	
	$code=$rs['code'];
}
//END 



//CHECK UPDATES 
//"SELECT count(*) as count FROM examresults WHERE  ExamDate Like('%$year%') and   Adm='$admno' and form='$form' and Term='$term' and ExamType='$exam' AND paper='$paper'";

$query_data_update="SELECT COUNT(*) AS found FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
//echo $query_data_update;
$dataRetrive=mysqli_query($con,$query_data_update);
		while($results_found=mysqli_fetch_assoc($dataRetrive)){
			$update=$results_found['found'];
			
		}
		
		

//CHECK SINGLE/MULTIPLE PAPERS
if($single=="true"){
	$query_updates="SELECT count(*) as found FROM examresults WHERE  ExamDate Like('%$year%') and   Adm='$admno' and form='$form' and Term='$term' and ExamType='$exam'";
	
	
	if ($update<1){
		$q2="INSERT INTO $tb (form,limit1,Adm,Term,Stream,Etype,Year,code,$exm,SinglePaper) VALUES('$form','$limit','$admno','$term','$Stream','$exam','$year','$code','$overal','$paper')";
		
	}else{
		$q2="UPDATE  $tb SET limit1='$limit', $exm='$overal' WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		
	}
	
}
else{
	$query_updates="SELECT COUNT(*) AS found FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
	$dataRetrive=mysqli_query($con,$query_updates);
		while($results_found=mysqli_fetch_assoc($dataRetrive)){
			$found=$results_found['found'];
			
		}
	if($paper==1){
		$query_data="SELECT score3,limit3,score2,limit2 FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		$data=mysqli_query($con,$query_data);
		while($r=mysqli_fetch_assoc($data)){
			$score1=$r['score3'];
			$score2=$r['score2'];
			$limit1=$r['limit2'];
			$limit2=$r['limit3'];
			
		}
		
		$avg1 = $score1 + $score2 + $overal;
         $avg2 = $limit1 + $limit2 + ($limit);
         $avgovarol = ($avg1 / $avg2) * ($limit);
		 
		 
		if ($found<1){
		$q2="INSERT INTO $tb (form,Score,limit1,Avg,Adm,Term,Stream,Etype,Year,code,$exm,SinglePaper) VALUES('$form','$overal','$limit','$avgovarol','$admno','$term','$Stream','$exam','$year','$code','$avgovarol','$paper')";
		
	}else{
		$q2="UPDATE  $tb SET Score='$overal',limit1='$limit', $exm='$avgovarol', Avg='$avgovarol' WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		
	}
		
		
	}elseif($paper==2){
		
		$query_data="SELECT score3,limit3,score,limit1 FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		$data=mysqli_query($con,$query_data);
		while($r=mysqli_fetch_assoc($data)){
			$score1=$r['score3'];
			$score2=$r['score'];
			$limit1=$r['limit1'];
			$limit2=$r['limit3'];
			
		}
		
		$avg1 = $score1 + $score2 + $overal;
         $avg2 = $limit1 + $limit2 + ($limit);
         $avgovarol = ($avg1 / $avg2) * ($limit);
		 if ($found<1){
		$q2="INSERT INTO $tb (Form,score2,limit2,Avg,Adm,Term,Stream,Etype,Year,code,$exm,SinglePaper) VALUES('$form','$overal','$limit','$avgovarol','$admno','$term','$Stream','$examtype','$year','$code','$avgovarol','1')";
		
	}else{
		$q2="UPDATE  $tb SET score2='$overal',limit2='$limit', $exm='$avgovarol', Avg='$avgovarol' WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		
	}
		 
	}elseif($paper==3){
		
		$query_data="SELECT score,limit1,score2,limit2 FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		$data=mysqli_query($con,$query_data);
		while($r=mysqli_fetch_assoc($data)){
			$score1=$r['score'];
			$score2=$r['score2'];
			$limit1=$r['limit2'];
			$limit2=$r['limit1'];
			
		}
		
		 $avg1 = $score1 + $score2 + $overal;
         $avg2 = $limit1 + $limit2 + ($limit);
         $avgovarol = ($avg1 / $avg2) * ($limit);
		if ($found<1){
		$q2="INSERT INTO $tb (form,score3,limit3,Avg,Adm,Term,Stream,Etype,Year,code,$exm,SinglePaper) VALUES('$form','$overal','$limit','$avgovarol','$admno','$term','$Stream','$exam','$year','$code','$avgovarol','1')";
		
	}else{
		$q2="UPDATE  $tb SET score3='$overal',limit3='$limit', $exm='$avgovarol', Avg='$avgovarol' WHERE Year='$year'  and   Etype='$exam'  and Adm='$admno' and Term='$term' AND code='$code'";
		
	}
		
	}else{
		
		
	}
	
	
	
	
	
}  
//END OF PAPERS CHECK


// CHECK UPDATES BATCH ENTRY


$dataRetrive_b=mysqli_query($con,$query_updates);
		while($results_found_b=mysqli_fetch_assoc($dataRetrive_b)){
			$b_update=$results_found_b['found'];
			
		}

if ($b_update<1){
	
	
	if ($single=="false"){
		
		$exams_insert="INSERT INTO examresults(Adm,Form,Term,Stream,ExamType,ExamDate, $subject,Singlepaper,Paper,outof,limits,$subtr) VALUES('$admno','$form','$term','$Stream','$exam','$examdate','$marks','$single','$paper','$outof','$limit','outof')";
		
	}else{
		
		$exams_insert="INSERT INTO examresults(Adm,Form,Term,Stream,ExamType,ExamDate, $subject,Singlepaper,Paper,outof,limits,$subtr) VALUES('$admno','$form','$term','$Stream','$exam','$examdate','$marks','$single','$paper','$outof','$limit','outof')";
		
	}
	
	
}else{
	
	if ($single=="false"){
		
		$exams_insert="UPDATE examresults SET    $subtr='$outof' ,$subject='$overal' Where Paper='$paper'  AND Adm='$admno' and form='$form' and Term='$term' and Examtype='$exam'";
		
	}else{
		
		$exams_insert="UPDATE examresults SET    $subtr='$outof' ,$subject='$overal' Where Paper='$paper'  AND Adm='$admno' and form='$form' and Term='$term' and Examtype='$exam'";
		
		
	}
	
}


//QUERY EXECUTION

	//QUERY 1
	//echo $q2;
	if ((mysqli_query($con,$q2))){
		if ((mysqli_query($con,$exams_insert))){
			
			//echo 1;
		
	}
		else{
			
			
			
		}
		echo 1;
	}
		else{
			
			echo $con->error;
			
		}
}	
	
// and (mysqli_query($con,$exams_insert))







?>