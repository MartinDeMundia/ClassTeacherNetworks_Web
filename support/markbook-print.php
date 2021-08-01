<?php
session_start();
if (isset($_SESSION['form'])){
require("dbconn.php");

function tcheckeData() {
global $subjectno, $con,$cat1,$cat2,$cat3,$title;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;	
global $subject;
global $total;
        $processed =0;
        $q1; 
		
		If ($exm =="all") {
		
If ($Stream =="all") {

              
                        


                            $strQrytp1 = "SELECT  count(*) as c FROM ".$f2."term WHERE Year='$year' and Term='$term' and subject='$subject'";
                            $c13aa=mysqli_query($con,$strQrytp1);
		while($results_found13aa=mysqli_fetch_assoc($c13aa)){
			$processed=$results_found13aa['c'];
			
		}
//echo  $strQrytp1;
					}


                
			
            else {
               
                       $Qry = "SELECT  count(*) as c FROM ".$f2."term where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
					   //echo $Qry;
                            $qr=mysqli_query($con,$Qry);
		while($qqr=mysqli_fetch_assoc($qr)){
			$processed=$qqr['c'];
			
		}
					}


				
           




          


            

              If ($Stream =="all") {
              
                   
                        $q1 = "SELECT ".$f2."term.`adm`, `sudtls`.`Name`, ".$f2."term.`Form` ,".$f2."term.`Stream`, ".$f2."term.`PosStream` , ".$f2."term.`PosClass`,subno, ".$f2."term.`TotalScore` , ".$f2."term.`TotalPercent`  , ".$f2."term.`Grade`  FROM `school_5`.".$f2."term INNER JOIN `school_5`.`sudtls` ON (".$f2."term.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."term.form='$form' ";
			
			


            } else{
               
                        $q1 = "SELECT ".$f2."term.`adm`, `sudtls`.`Name`, ".$f2."term.`Form` ,".$f2."term.`Stream`, ".$f2."term.`PosStream` , ".$f2."term.`PosClass`,subno,".$f2."term.`TotalScore`  , ".$f2."term.`Grade`  FROM `school_5`.".$f2."term INNER JOIN `school_5`.`sudtls` ON (".$f2."term.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."term.stream='$Stream' and ".$f2."term.form='$form' ";
			
			}
		
         
		

                   
require('fpdf/fpdf.php');

$name="";
$adm=0;

class PDF extends FPDF
{
	 function Header()
{
	global $form,$name,$adm,$Stream,$con,$year,$term,$en,$subject;
		// Logo
		$q1s="select description from settings where type='system_title'";
$title='';
$address='';
$tel='';
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}

$q1s="select description from settings where type='address'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}
	
	$this->SetFont('Arial','B',10);
	$this->Image('uploads/logo.png',250,6,30);
	// Title
	$this->Cell(0,7,$title,0,0,'C');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,7,$address,0,0,'C');
	$this->Ln(5);
	// Title
	$this->Cell(0,7,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(10);

	// Title
	$this->Cell(0,7,strtoupper($subject).' MARKBOOK '.   strtoupper($form." ". $Stream. " ($term - ". $year. ")"),0,0,'C');
	// Line break
	$this->Ln(15);
	
	$this->Cell(20	,7,'ADM',1,0,'C');
                                  $this->Cell(50	,7,'NAME',1,0,'C');
								  if (cat1=="True"){
								   $this->Cell(20	,7,'CAT 1',1,0,'C');    }
								  if (cat2=="True"){
								   $this->Cell(20	,7,'CAT 2',1,0,'C');   }
								    if (cat3=="True"){
								   $this->Cell(20	,7,'CAT 3',1,0,'C');    }
								 $this->Cell(20	,7,'END TERM',1,0,'C');
								    $this->Cell(20	,7,'TOTAL',1,0,'C');
									  $this->Cell(20	,7,'GRADE',1,1,'C');
								
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,7,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}     
		$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
 $pdf->SetFont('Arial','',8);			
                                  
								   
                             
						  
						
		echo $q1;	
 $qq=mysqli_query($con,$q1); $score="";
 $tt=0;
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
		while($rs=mysqli_fetch_assoc($qq)){
			$total=0;
			 
						    $pdf->Cell(20	,7,$rs['adm'],1,0,'C');
                              $pdf->Cell(50	,7,$rs['Name'],1,0,'C');
 if (cat1=="True"){
								   

$qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM cat1 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) where adm='".$rs['adm']."' and Year='$year' and Term='$term' and subject='$subject'";
$cat1=0;
								  $subsc1m=mysqli_query($con,$qscw1m);
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			
									
									$cat1=$srcvm['TotalScore'];
									
		}
		$total+=$cat1;
				$pdf->Cell(20	,7,$cat1,1,0,'C'); 					
									}
								  if (cat2=="True"){
								    $qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM cat2 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)  where adm='".$rs['adm']."' and Year='$year' and cat2.Term='$term' and subject='$subject'";
								   
								  $subsc1m=mysqli_query($con,$qscw1m);
								  $cat2=0;
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			
			$cat2=	$srcvm['TotalScore'];												
									 
									
		} 
		$pdf->Cell(20	,7,$cat2 ,1,0,'C');
		$total=$total+$cat2;
		}
								    if (cat3=="True"){
								   $qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM cat3 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) where adm='".$rs['adm']."' and Year='$year' and cat3.Term='$term' and subject='$subject'";
								  $subsc1m=mysqli_query($con,$qscw1m);
								  $cat3=0;
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			

									 
		$cat3=$srcvm['TotalScore'];							
		} 
		$total=$total+$cat3;
		$pdf->Cell(20	,7, $cat3,1,0,'C');
		}							  
							 
                              
							  
							   $qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM endterm left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) where adm='".$rs['adm']."' and Year='$year' and Term='$term' and subject='$subject'";
								  $subsc1m=mysqli_query($con,$qscw1m);
								  $endterm=0;
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			

		$endterm=	$srcvm['TotalScore'];						
									
		} 
		$total=$total+$endterm;
		$pdf->Cell(20	,7, $endterm,1,0,'C');
		$pdf->Cell(20	,7,	$total,1,0,'C');
							 $q134 = "SELECT Grade FROM gradingscale WHERE ".round($total,0)."<= MAX AND ".round($total,0).">=Min ";
  $gg="";
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	//VALUES/DATA
	$gg=	$rs34['Grade'];
		//
 }		

	$pdf->Cell(20	,7, $gg,1,1,'C');
	
	
						  }
						 
			
		

$t=1;
$points=0;
$q13 = "SELECT AVG(Totalscore) as m,COUNT(*) AS t FROM ve WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND subject='".$subject."' ";
	 //echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	
	if($rs3['m']>0){
	$m=$rs3['m'];
	}
	$t=$rs3['t'];
	
	//VALUES/DATA
	
		//
 }
 
 	 $q134 = "SELECT Grade FROM gradingscale WHERE ".$m."<= MAX AND ".$m.">=Min ";
	 //echo $q1;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){
$pdf->SetFont('Arial','',10);
	
	$g=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }
 //echo  $q134;
  $pdf->Ln(30);
		
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM ve WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND subject='".$subject."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
 while($rs=mysqli_fetch_assoc($qq)){
If($rgs['Grade']=="E"){
	$pdf->Cell(10	,10,$rgs['Grade'],1,1,'C');
	
}else{
	$pdf->Cell(10	,10,$rgs['Grade'],1,0,'C');
}
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20	,10,'No.',1,0,'L');
 $qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2,points FROM ve WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND subject='".$subject."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	$points+=$rs['points']*$rs['grade2'];
	$pdf->Cell(10	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
	
		}

$pdf->Ln(10);
		$pdf->SetFont('Arial','B',10);
	$pdf->Cell(100	,10,'		'.' MEAN POINTS '.round(($points/$t),2).'    ' . 'MEAN SCRORE-'.round($m,2).'    MEAN GRADE-'.$g.'',0,0,'C');
	 $pdf->Ln(5);
	 	$q1 = "SELECT Name FROM subjectallocationa WHERE Stream='$Stream' and   form='".$form."' AND SUBJECT='".$subject."' ";
	 echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','B',10);
	
	$pdf->Cell(100	,10,'SUBJECT TEACHER  '.strtoupper($rs['Name']),0,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
      $pdf->Output('f','PDFS/markbook2.pdf');   
}else{
            If ($Stream =="all") {

              
                        


                            $strQrytp1 = "SELECT  count(*) as c FROM `$exm` WHERE Year='$year' and Term='$term' and subject='$subject'";
                            $c13aa=mysqli_query($con,$strQrytp1);
		while($results_found13aa=mysqli_fetch_assoc($c13aa)){
			$processed=$results_found13aa['c'];
			
		}
//echo  $strQrytp1;
					}


                
			
            else {
               
                       $Qry = "SELECT  count(*) as c FROM $exm where Year='$year' and Term='$term' and stream='$Stream' and form='$form' and subject='$subject'";
					   //echo $Qry;
                            $qr=mysqli_query($con,$Qry);
		while($qqr=mysqli_fetch_assoc($qr)){
			$processed=$qqr['c'];
			
		}
					}


				
           




          


            

              If ($Stream =="all") {
              
                   
                        $q1 = "SELECT `$exm`.`adm`, `sudtls`.`Name`, `$exm`.`Form` ,`$exm`.`Stream`, `$exm`.`PosStream` , `$exm`.`PosClass`,subno, `$exm`.`TotalScore` , `$exm`.`TotalPercent`  , `$exm`.`Grade`  FROM `school_5`.`$exm` INNER JOIN `school_5`.`sudtls` ON (`$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and $exm.form='$form'  and subject='$subject'";
			
			


            } else{
               
                        $q1 = "SELECT `$exm`.`adm`, `sudtls`.`Name`, `$exm`.`Form` ,`$exm`.`Stream`, `$exm`.`PosStream` , `$exm`.`PosClass`,subno,`$exm`.`TotalScore`  , `$exm`.`Grade`  FROM `school_5`.`$exm` INNER JOIN `school_5`.`sudtls` ON (`$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and $exm.stream='$Stream' and $exm.form='$form'  and subject='$subject'";
			
			}
		
         
		

                   
require('fpdf/fpdf.php');

$name="";
$adm=0;

class PDF extends FPDF
{
	 function Header()
{
	global $form,$name,$adm,$Stream,$con,$year,$term,$en,$subject;
		// Logo
		$q1s="select description from settings where type='system_title'";
$title='';
$address='';
$tel='';
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}

$q1s="select description from settings where type='address'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}
	
	$this->SetFont('Arial','B',10);
	$this->Image('uploads/logo.png',250,6,30);
	// Title
	$this->Cell(0,7,$title,0,0,'C');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,7,$address,0,0,'C');
	$this->Ln(5);
	// Title
	$this->Cell(0,7,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(10);

	// Title
	$this->Cell(0,7,strtoupper($subject).' MARKBOOK '.   strtoupper($form." ". $Stream. " ($term - ". $year. ")"),0,0,'C');
	// Line break
	$this->Ln(15);
	
	$this->Cell(20	,7,'ADM',1,0,'C');
                                  $this->Cell(50	,7,'NAME',1,0,'C');
								  if (cat1=="True"){
								   $this->Cell(20	,7,'CAT 1',1,0,'C');    }
								  if (cat2=="True"){
								   $this->Cell(20	,7,'CAT 2',1,0,'C');   }
								    if (cat3=="True"){
								   $this->Cell(20	,7,'CAT 3',1,0,'C');    }
								 $this->Cell(20	,7,'END TERM',1,0,'C');
								    $this->Cell(20	,7,'TOTAL',1,0,'C');
									  $this->Cell(20	,7,'GRADE',1,1,'C');
								
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,7,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}     
		$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
 $pdf->SetFont('Arial','',8);			
                                  
								   
                             
						  
		echo $q1;				
			
 $qq=mysqli_query($con,$q1); $score="";
 $tt=0;
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
		while($rs=mysqli_fetch_assoc($qq)){
			$total=0;
			 
						    $pdf->Cell(20	,7,$rs['adm'],1,0,'C');
                              $pdf->Cell(50	,7,$rs['Name'],1,0,'C');
 if (cat1=="True"){
								   

$qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM cat1 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) where adm='".$rs['adm']."' and Year='$year' and Term='$term' and subject='$subject'";
$cat1=0;
								  $subsc1m=mysqli_query($con,$qscw1m);
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			
									
									$cat1=$srcvm['TotalScore'];
									
		}
		$total+=$cat1;
				$pdf->Cell(20	,7,$cat1,1,0,'C'); 					
									}
								  if (cat2=="True"){
								    $qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM cat2 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)  where adm='".$rs['adm']."' and Year='$year' and cat2.Term='$term' and subject='$subject'";
								   
								  $subsc1m=mysqli_query($con,$qscw1m);
								  $cat2=0;
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			
			$cat2=	$srcvm['TotalScore'];												
									 
									
		} 
		$pdf->Cell(20	,7,$cat2 ,1,0,'C');
		$total=$total+$cat2;
		}
								    if (cat3=="True"){
								   $qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM cat3 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) where adm='".$rs['adm']."' and Year='$year' and cat3.Term='$term' and subject='$subject'";
								  $subsc1m=mysqli_query($con,$qscw1m);
								  $cat3=0;
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			

									 
		$cat3=$srcvm['TotalScore'];							
		} 
		$total=$total+$cat3;
		$pdf->Cell(20	,7, $cat3,1,0,'C');
		}							  
							 
                              
							  
							   $qscw1m="SELECT CONCAT(round(TotalScore,2),' ',gradingscale.grade) as TotalScore,PosStream FROM endterm left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) where adm='".$rs['adm']."' and Year='$year' and Term='$term' and subject='$subject'";
								  $subsc1m=mysqli_query($con,$qscw1m);
								  $endterm=0;
		while($srcvm=mysqli_fetch_assoc($subsc1m)){
			

		$endterm=	$srcvm['TotalScore'];						
									
		} 
		$total=$total+$endterm;
		$pdf->Cell(20	,7, $endterm,1,0,'C');
		$pdf->Cell(20	,7,	$total,1,0,'C');
							 $q134 = "SELECT Grade FROM gradingscale WHERE ".round($total,0)."<= MAX AND ".round($total,0).">=Min ";
  $gg="";
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	//VALUES/DATA
	$gg=	$rs34['Grade'];
		//
 }		

	$pdf->Cell(20	,7, $gg,1,1,'C');
	
	
						  }
						 
			
$m=1;	
$t=1;
$points=1;
$q13 = "SELECT AVG(TotalPercent) as m,COUNT(*) AS t FROM $exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$subject."' ";
	 //echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	
	if($rs3['m']>0){
	$m=$rs3['m'];
	}
	$t=$rs3['t'];
	
	//VALUES/DATA
	
		//
 }
 
 	 $q134 = "SELECT Grade FROM gradingscale WHERE ".$m."<= MAX AND ".$m.">=Min ";
	 //echo $q1;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){
$pdf->SetFont('Arial','',10);
	
	$g=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }
 //echo  $q134;
  $pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFont('Arial','B',10);	
$pdf->Cell(100	,10,'  '.strtoupper($en),0,1,'C');
		
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,5,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM $exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$subject."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
 while($rs=mysqli_fetch_assoc($qq)){
If($rgs['Grade']=="E"){
	$pdf->Cell(10	,5,$rgs['Grade'],1,1,'C');
	
}else{
	$pdf->Cell(10	,5,$rgs['Grade'],1,0,'C');
}
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20	,5,'No.',1,0,'L');
 $qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $q1 = "SELECT COUNT($exm.Grade) as grade2,points FROM $exm left join gradingscale on(gradingscale.Grade=$exm.Grade) WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND $exm.form='".$form."' AND SUBJECT='".$subject."' AND $exm.grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	$points+=$rs['points']*$rs['grade2'];
	$pdf->Cell(10	,5,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}

$pdf->Ln(10);
		$pdf->SetFont('Arial','B',10);
	$pdf->Cell(100	,10,'		'.' MEAN POINTS '.round(($points/$t),2).'    ' . 'MEAN SCRORE-'.round($m,2).'    MEAN GRADE-'.$g.'',0,0,'C');
	 $pdf->Ln(5);
	 	$q1 = "SELECT Name FROM subjectallocationa WHERE Stream='$Stream' and   form='".$form."' AND SUBJECT='".$subject."' ";
	// echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','B',10);
	
	$pdf->Cell(100	,10,'SUBJECT TEACHER  '.strtoupper($rs['Name']),0,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
	 	
      $pdf->Output('f','PDFS/markbook2.pdf');   
} 
}
function main() {
$zero = 0;
global $subjectno, $con,$cat1,$cat2,$cat3;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;
  If ($exm =="all") {
                    $strQry = "SELECT  count(*) as results FROM $f2 where Year='$year' and Term='$term'and form='$form'";
				 } else {
                    $strQry = "SELECT  count(*) as results FROM $f2 where Year='$year' and Term='$term'and form='$form' and etype='$en' ";
 }
               
            $r1cc=mysqli_query($con,$strQry);
		while($results1cc=mysqli_fetch_assoc($r1cc)){


                $zero = $results1cc['results'];
		}

            If ($zero <= 0) {
              // echo "No results found $exm";
            } else {

                
					
                    tcheckeData();

                
			}
    }
if (isset($_SESSION['en'])){
	$subject=$_SESSION['subjects'];
$subjectno=0;
$lmt = 0; 
$form=$_SESSION['form'];
$f2=$_SESSION['f2'];
$Stream=$_SESSION['Stream'];
$year=$_SESSION['year'];
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$term=$_SESSION['term'];
$exm=$_SESSION['exm'];
define("cat1","True");
define("cat2","True");
define("cat3","True");
$total=0;
main();
}

	
}


