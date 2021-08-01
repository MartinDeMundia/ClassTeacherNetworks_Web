<?php
session_start();
require("dbconn.php");
$subjectno=0;
$lmt = 0; 
$form=$_SESSION['form'];
$f2=$_SESSION['f2'];
$Stream=$_SESSION['Stream'];
$year=$_SESSION['year'];
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$enn=$_SESSION['enn'];
$term=$_SESSION['term'];
$exm=$_SESSION['exm'];
$cat1 = $_SESSION['cat1'];
$cat2 = $_SESSION['cat2'];
$cat3 = $_SESSION['cat3'];
if(1==1){
		$title=$_SESSION['progress_text'];
		$value=$_SESSION['progress'];
		$divider=$_SESSION['out'];
			
			if ($title=="Loading"){
				
				 If ($Stream =="all") {
				 If ($exm =="all") {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."term` where Year='$year' and Term='$term'and form='$form'";
				 } else {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."$exm` where Year='$year' and Term='$term'and form='$form' ";
 }
				 }else{
					 
					  If ($exm =="all") {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."term` where Year='$year' and Term='$term'and form='$form' and stream='$Stream'";
				 } else {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."$exm` where Year='$year' and Term='$term'and form='$form' and stream='$Stream' ";
 }
				 }
               
            $r1cc=mysqli_query($con,$strQry);
		while($results1cc=mysqli_fetch_assoc($r1cc)){


                $zero = $results1cc['results'];
		}
				If ($zero <= 0) {
					//$value=0;
					$divider=1;
				}
				else{
					$divider=$zero;
					
				}
				
			} else if($title=="Processing"){
				
				$subq3 = "Select count(*) as c  from $f2  where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";


          

           $c3a=mysqli_query($con,$subq3);
		while($results_found3a=mysqli_fetch_assoc($c3a)){
			
                $count2 = $results_found3a['c'];

		}
		
		If ($count2 <= 0) {
					$value=0;
					$divider=1;
				}
				else{
					$divider=$zero;
					
				}
		
			} else if($divider==0){
				
				$divider=1;
			}
	
	
	
	$return=round(($value/$divider)*100,0);
	
	$json='{"title":"'.$title.'","value":"'.$return.'"}';
	echo ($json);
}
//echo  $strQry ;

?>
