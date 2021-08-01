<?php
session_start();ini_set('max_execution_time', 10000);
require("dbconn.php");
$title='';
$address='';
$tel='';
$q1s="select description from settings where type='system_title'";
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

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}





function process_data(){
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
       


          
            $strQry1cc = "SELECT limits FROM examresults WHERE  ExamDate='$year' and   Term='$term' and  form='$form' and  Examtype='$en' limit 1";
          
            $r1cc=mysqli_query($con,$strQry1cc);
		while($results1cc=mysqli_fetch_assoc($r1cc)){


                $lmt = $results1cc['limits'];
		}
      

             $s = "INSERT INTO $exm(Year,Form,Stream,Grade,TotalScore,TotalPercent,Adm,CODE,term,SUBJECT)  SELECT Year,$f2.Form,$f2.Stream,Grade,($f2.$exm ),((($f2.$exm )/$f2.Limit1))*100 AS percentage,$f2.Adm,$f2.Code,$f2.term,subjects.abbreviation FROM $f2 RIGHT JOIN subjects ON subjects.code=$f2.code  LEFT JOIN gradingscale ON (((($f2.$exm )/$f2.Limit1))*100>= gradingscale.Min AND (((($f2.$exm )/$f2.Limit1))*100) <= gradingscale.Max) WHERE $f2.Year='$year' and $f2.term='$term' AND etype='$en'  ORDER BY $exm DESC";

           
            if (mysqli_query($con,$s))
                                 {
                                  
								rank();
                                }
								else{
									
								}

            
       
}


function process_thread() {
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

        $processed =0;
        
            If ($Stream =="all") {

                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQryPT = "SELECT  count(*) as c FROM `".$f2."term` WHERE  Year='$year' and Term='$term'";
                        $c13=mysqli_query($con,$strQryPT);
		while($results_found13=mysqli_fetch_assoc($c13)){
			$processed=$results_found13['c'];
			
		}


				}         
                else {
                    If (2==8) {
						
					}
                        
                    else {
                        


                            $strQrytp1 = "SELECT  count(*) as c FROM `".$f2."$exm` WHERE Year='$year' and Term='$term'";
                            $c13aa=mysqli_query($con,$strQrytp1);
		while($results_found13aa=mysqli_fetch_assoc($c13aa)){
			$processed=$results_found13aa['c'];
			
		}

					}


                }
			}
            else {
                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQry20 = "SELECT  count(*) as c FROM `".$f2."term` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
                        $c20=mysqli_query($con,$strQry20);
		while($results_found20=mysqli_fetch_assoc($c20)){
			$processed=$results_found20['c'];
			
		}
                       
			}
                else{
                    If (2==8) {
                       $processed = 0;
                        
                      
					}
						else{
                       $Qry = "SELECT  count(*) as c FROM `".$f2."$exm` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
					   
                            $qr=mysqli_query($con,$Qry);
		while($qqr=mysqli_fetch_assoc($qr)){
			$processed=$qqr['c'];
			
		}
					}


				}
            }




          


            If ($processed > 0) {
				
				
			}
            else
			{

                //process_data();

                ///process_exam();
				//task();

			}

            If ($Stream =="all") {
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`  , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `".$f2."term`.`VALUE_ADDITION`  FROM `".$f2."term` INNER JOIN `sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   ORDER BY PosClass ASC ";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` , `".$f2."$exm`.`VALUE_ADDITION`  FROM `".$f2."$exm` INNER JOIN `sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' ORDER BY PosClass ASC;";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`  , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `".$f2."term`.`VALUE_ADDITION`  FROM `".$f2."term` INNER JOIN `sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   ORDER BY PosClass ASC and ".$f2."term.Stream='$Stream'";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` , `".$f2."$exm`.`VALUE_ADDITION`  FROM `".$f2."$exm` INNER JOIN `sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' ORDER BY PosClass ASC;";
			}
			}

            }
		
		require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
	global $form,$name,$adm,$Stream,$con,$term,$year,$en,$enn,$header;
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

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}
	 $this->Image('uploads/logo.png',5,6,20);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
	// Title
	$this->Cell(0,10,$title,0,0,'C');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,$address,0,0,'C');
	$this->Ln(5);
	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(10);
$v=strtoupper($enn)." BROAD SHEET ".strtoupper($form." ". $Stream. " ($term - ". $year. ")"); 
	// Title
	$this->Cell(0,10,$v,0,0,'C');
	// Line break
	
	$this->Ln(15);$this->SetX(2);
	$this->SetFont('Times','B',8);
                                $this->Cell(10	,10,'',0,0,'L');
								  $this->Cell(10	,10,'',0,0,'L'); 
                                  $this->Cell(30	,10,'',0,0,'L');   
								  $this->Cell(10	,10,'',0,0,'L');
								    $this->Cell(20	,10,'',0,0,'L');
								  $this->Cell(10	,10,'',0,0,'L'); 
                                  $this->Cell(10	,10,'',0,0,'L');   
								  $this->Cell(10	,10,'',0,0,'L');
								    $this->Cell(10	,10,'',0,0,'L');
								  $this->Cell(10	,10,'',0,0,'L'); 
                                  $this->Cell(10	,10,'',0,0,'L');
								   $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $this->Cell(10	,10,$sr['subs'] ,'RLT',0,'C');
						  
						  
						  }
						  $this->Cell(0	,10,'' ,0,1,'C');$this->SetX(2);
                                  $this->Cell(10	,10,'RNK',1,0,'C');
								  $this->Cell(10	,10,'ADM',1,0,'C'); 
                                  $this->Cell(30	,10,'NAME',1,0,'C');   
								  $this->Cell(10	,10,'FORM',1,0,'C');
								  $this->Cell(20	,10,'STREAM',1,0,'C');
								   $this->Cell(10	,10,'POS',1,0,'C');
								   $this->Cell(10	,10,'TOTAL',1,0,'C');
								  $this->Cell(10	,10,'MS',1,0,'C'); 
                                  $this->Cell(10	,10,'(%) ',1,0,'C');  
								  $this->Cell(10	,10,'MG',1,0,'C');
								  $this->Cell(10	,10,'V/A',1,0,'C');
								 
								  $qs="SELECT UPPER(code) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $this->Cell(10	,10,$sr['subs'] ,'RT',0,'C');
						 
						  
						  }
						 $this->Cell(0	,10,'' ,0,1,'C');$this->SetX(2);
	
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'frijotech softwares-Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$header=76;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetLeftMargin(2);

	 //$i+=1;
	
                            
					
 $qq=mysqli_query($con,$q1);
 //echo $q1;
 $score="";
		while($rs=mysqli_fetch_assoc($qq)){	
						  
						    $pdf->SetFont('Arial','',7);
                              $pdf->Cell(10	,10, $rs['PosClass'],1,0,'C');
							   $pdf->Cell(10	,10, $rs['adm'],1,0,'C');
                               $pdf->Cell(30	,10, $rs['Name'],1,0,'C');
							   $pdf->Cell(10	,10, $rs['Form'],1,0,'C');
                               $pdf->Cell(20	,10, $rs['Stream'],1,0,'C');
							   $pdf->Cell(10	,10, $rs['PosStream'],1,0,'C');
							  
                               $pdf->Cell(10	,10, round($rs['TotalMarks'],2),1,0,'C');
							   $pdf->Cell(10	,10, round($rs['TotalScore'],2),1,0,'C');
                               $pdf->Cell(10	,10, round($rs['TotalPercent'],2),1,0,'C');
							   $pdf->Cell(10	,10, $rs['Grade'],1,0,'C');
							   
							   if(($rs['POINTS']-$rs['kcpe'])<0) { $pm= "+"; $va= ($rs['POINTS']-$rs['kcpe'])*-1;} else{$pm= "-";$va= ($rs['POINTS']-$rs['kcpe']);} 
							   
                              $pdf->Cell(10	,10, $pm.' '.$va,1,0,'C');
                              $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			$qsc="SELECT CONCAT(((round(TotalScore,2))),' ',gradingscale.grade) as TotalScore,PosStream  FROM $exm left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) WHERE adm='".$rs['adm']."' AND SUBJECT='".$sr['subs']."' AND $exm.term='$term' AND year='$year'";
			$score="";
			$pos="";
			
								  $sc=mysqli_query($con,$qsc);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=($ss['TotalScore']);
						$pos="" ; 
		}
		$poss='';
		if($pos !=="") {$poss= " (".$pos.")";} else{$poss="";};
		if($score==""){
			
			 $pdf->Cell(10	,10,  '-'.$poss,1,0,'C');
		}
		else{
			 $pdf->Cell(10	,10,  $score.' '.$poss,1,0,'C');
		}
						  }
						  
                         $pdf->Cell(0	,10,'',0,1,'C');
                          
                         
						  
						  }
						  $header=0;
						  $pdf->AddPage('l');
						  $i=0;
						  $m=0;
						  $g=0;
						 $pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
$points=0;
if(strtolower($Stream)=="all"){
							$str=""; 
						 }else{
						  $str=" and Stream ='".$Stream."' ";
						 }
$pdf->Cell(20	,10,'SUBJECT',1,0,'C');
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	  $pdf->Cell(15	,10, $rs22['sub1'],1,0,'C');
 }
 $pdf->Cell(0	,10,'',0,1,'C');
 $pdf->Cell(20	,10,'AVERAGE',1,0,'C');
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM $exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	  $pdf->Cell(15	,10, round($rs3['m'],1),1,0,'C');
	if($rs3['m']>0){
		
	$m=$rs3['m'];
	
	}
 }
 
 }
	 $pdf->Cell(0	,10,'',0,1,'C');
	 $pdf->Cell(20	,10,'GRADE',1,0,'C');
	 $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM $exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
	 $m=0;
	 if($rs3['m']>0){
		
	$m=$rs3['m'];
	
	}
   $q134 = "SELECT Grade FROM gradingscale WHERE ".$m."<= MAX AND ".$m.">=Min ";
 // echo $q134;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	 if($rs3['m']>0){
		
	$g=$rs34['Grade'];
	
	}else{
		$g="";
	}
	
	
	$pdf->SetFont('Arial','B',10);
	  $pdf->Cell(15	,10,$g,1,0,'C');
	//VALUES/DATA
	
		//
 }		



		
 //echo $data2a;
	//echo $data12a;
 }

	
 }
 
 
 $pdf->Cell(0	,10,'',0,1,'C');
	 $pdf->Cell(20	,10,'ENTRY',1,0,'C');
	 $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	 $q13 = "SELECT COUNT(*) as m FROM $exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
	 $m=0;
	 if($rs3['m']>0){
		
	$m=$rs3['m'];
	
	}
	else{
		
		$m="";
		
	}
   	
$pdf->SetFont('Arial','B',10);
	  $pdf->Cell(15	,10,$m,1,0,'C');


		
 //echo $data2a;
	//echo $data12a;
 }

	
 }
 $t=0;
 $m2=0;
 $g2=0;
 $tms=0;
 $pdf->SetFont('Arial','BU',15);
	 ///$pdf->Cell(0,10,'SUMMARY',0,0,'C');
	 $pdf->Ln(30);

	 $q13 = "SELECT AVG(TotalPercent) as m,COUNT(*) AS t,AVG(TotalMarks) as tm FROM ".$f2."$exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' ";
	 //echo $q1;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	if($rs3['m']>0){
	$m2=$rs3['m'];
	}
	$t=$rs3['t'];
	$tms=$rs3['tm'];
	//VALUES/DATA
	
		//
 } 
  $q134 = "SELECT Grade FROM gradingscale WHERE ".$m2."<= MAX AND ".$m2.">=Min ";
  //echo $q1;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){
$pdf->SetFont('Arial','',10);
	
	$g2=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }
 
 
 	
	
 //echo  $q134;
 
		
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	 echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
If($rgs['Grade']=="E"){
	$pdf->Cell(20	,10,$rgs['Grade'],1,1,'C');
	
}else{
	$pdf->Cell(20	,10,$rgs['Grade'],1,0,'C');
}
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20	,10,'No.',1,0,'L');
 $qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2,points FROM ".$f2."$exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	$points+=$rs['points']*$rs['grade2'];
	$pdf->Cell(20	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->Ln(20);
 $pdf->SetFont('Times','B',15);
 $pdf->Write(5,strtoupper( '		'.'Mean Scrore-'.round($m2,2).'    Mean point-'.round(($points/$t),2).''.'    Mean Grade-'.$g2.''.'    total avg-'.round($tms,2).''));
 $pdf->Ln(10); 
						  
                   $pdf->Output('D','PDFS/broadsheet.pdf');   
                        
}
function tcheckeData() {
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

        $processed =0;
        
            If ($Stream =="all") {

                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQryPT = "SELECT  count(*) as c FROM `".$f2."term` WHERE  Year='$year' and Term='$term'";
                        $c13=mysqli_query($con,$strQryPT);
		while($results_found13=mysqli_fetch_assoc($c13)){
			$processed=$results_found13['c'];
			
		}


				}         
                else {
                    If (2==8) {
						
					}
                        
                    else {
                        


                            $strQrytp1 = "SELECT  count(*) as c FROM `".$f2."$exm` WHERE Year='$year' and Term='$term'";
                            $c13aa=mysqli_query($con,$strQrytp1);
		while($results_found13aa=mysqli_fetch_assoc($c13aa)){
			$processed=$results_found13aa['c'];
			
		}

					}


                }
			}
            else {
                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQry20 = "SELECT  count(*) as c FROM `".$f2."term` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
                        $c20=mysqli_query($con,$strQry20);
		while($results_found20=mysqli_fetch_assoc($c20)){
			$processed=$results_found20['c'];
			
		}
                       
			}
                else{
                    If (2==8) {
                       $processed = 0;
                        
                      
					}
						else{
                       $Qry = "SELECT  count(*) as c FROM `".$f2."$exm` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
					   
                            $qr=mysqli_query($con,$Qry);
		while($qqr=mysqli_fetch_assoc($qr)){
			$processed=$qqr['c'];
			
		}
					}


				}
            }




          


            If ($processed > 0) {
			}
            else
			{

               
				

			}

              If ($Stream =="all") {
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent` , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, (`sudtls`.`kcpe` -`".$f2."term`.POINTS) as `VALUE_ADDITION`  FROM `".$f2."term` INNER JOIN `sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   ORDER BY PosClass ASC";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,(`sudtls`.`kcpe` -`".$f2."$exm`.POINTS) as `VALUE_ADDITION`  FROM `".$f2."$exm` INNER JOIN `sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' ORDER BY PosClass ASC;";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `sudtls`.`kcpe`- `".$f2."term`.POINTS as `VALUE_ADDITION`  FROM `".$f2."term` INNER JOIN `sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   and ".$f2."term.Stream='$Stream' ORDER BY PosClass ASC ";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,`sudtls`.`kcpe`- `".$f2."$exm`.POINTS as `VALUE_ADDITION`  FROM `".$f2."$exm` INNER JOIN `sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' ORDER BY PosClass ASC;";
			}
			}

            }
		
		require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
	global $form,$name,$adm,$Stream,$con,$term,$year,$enn;
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

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}
	 $this->Image('uploads/logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
	// Title
	$this->Cell(0,10,$title,0,0,'C');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,$address,0,0,'C');
	$this->Ln(5);
	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(10);
$v=strtoupper($enn)." BROAD SHEET ".strtoupper($form." ". $Stream. " ($term - ". $year. ")"); 
	// Title
	$this->Cell(0,10,$v,0,0,'C');
	// Line break
	$this->Ln(15);
	
	$this->SetX(2);
	$this->SetFont('Times','B',7);
                                $this->Cell(10	,5,'',0,0,'L');
								  $this->Cell(10	,5,'',0,0,'L'); 
                                  $this->Cell(30	,5,'',0,0,'L');   
								  $this->Cell(10	,5,'',0,0,'L');
								    $this->Cell(5	,5,'',0,0,'L');
								  $this->Cell(7	,5,'',0,0,'L'); 
								   if ($_SESSION['c1']=="True"){
								   $this->Cell(7	,5,'',0,0,'C');    }
								if ($_SESSION['c2']=="True"){
								   $this->Cell(7	,5,'',0,0,'C');   }
								    if($_SESSION['c3']=="True"){
								   $this->Cell(7	,5,'',0,0,'C');   }
                                  $this->Cell(8	,5,'',0,0,'L');   
								  $this->Cell(10	,5,'',0,0,'L');
								    $this->Cell(10	,5,'',0,0,'L');
								  $this->Cell(7	,5,'',0,0,'L'); 
                                  $this->Cell(10	,5,'',0,0,'L');
								   $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $this->Cell(10	,5,$sr['subs'] ,'RLT',0,'C');
						  
						  
						  }
						  $this->Cell(0	,5,'' ,0,1,'C');$this->SetX(2);
                                 $this->Cell(10	,5,'RNK',1,0,'C');
								  $this->Cell(10	,5,'ADM',1,0,'C'); 
                                  $this->Cell(30	,5,'NAME',1,0,'C');   
								  $this->Cell(10	,5,'FORM',1,0,'C');
								  $this->Cell(5	,5,'ST',1,0,'C');
								   $this->Cell(7	,5,'POS',1,0,'C');
								   if ($_SESSION['c1']=="True"){
								   $this->Cell(7	,5,'CAT 1',1,0,'C');    }
								if ($_SESSION['c2']=="True"){
								   $this->Cell(7	,5,'CAT 2 ',1,0,'C');   }
								    if($_SESSION['c3']=="True"){
								   $this->Cell(7	,5,'CAT 3 ',1,0,'C');   }
								  $this->Cell(8	,5,'E/M',1,0,'C');
								   $this->Cell(10	,5,'TOTAL',1,0,'C');
								  $this->Cell(10	,5,'MS%',1,0,'C');    
								  $this->Cell(7	,5,'MG',1,0,'C');
								  $this->Cell(10	,5,'V/A',1,0,'C');
								 
								  $qs="SELECT UPPER(code) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $this->Cell(10	,5,$sr['subs'] ,'RT',0,'C');
						 
						  
						  }
						 $this->Cell(0	,5,'' ,0,1,'C');$this->SetX(2);

}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('l');

	 //$i+=1;
	$pdf->SetFont('Arial','B',7);		
strtoupper($form." ". $Stream. " ($term - ". $year. ")"); 
                           
                                
                                  
								 
								  
								  
                             
				$pdf->SetFont('Arial','',7);	
 $qq=mysqli_query($con,$q1);
 
 //echo $q1;
 $score="";
 $tt=0;
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
		while($rs=mysqli_fetch_assoc($qq)){
			  
						    $pdf->SetX(2);
                              $pdf->Cell(10	,5, $rs['PosClass'],1,0,'C');
							   $pdf->Cell(10	,5, $rs['adm'],1,0,'C');
                               $pdf->Cell(30	,5, $rs['Name'],1,0,'l');
							   $pdf->Cell(10	,5, $_SESSION['form'],1,0,'C');
                               $pdf->Cell(5	,5, substr($rs['Stream'],0,1),1,0,'C');
							   $pdf->Cell(7	,5, $rs['PosStream'],1,0,'C');		
								if ($_SESSION['c1']=="True"){
								 $pdf->Cell(7	,5, round($rs['CAT1'],2),1,0,'C');    }
								 if ($_SESSION['c2']=="True"){
								  $pdf->Cell(7	,5, round($rs['CAT2'],2),1,0,'C');    }
								  if ($_SESSION['c3']=="True"){
								  $pdf->Cell(7	,5, round($rs['CAT3'],2),1,0,'C');    }							  
							 
                              
							  $pm="";
							  $va=0;
							   $pdf->Cell(8	,5, round($rs['ENDTERM'],2),1,0,'C');
                               $pdf->Cell(10	,5, round($rs['TotalMarks'],2),1,0,'C');
							   $pdf->Cell(10	,5, round($rs['TotalPercent'],2),1,0,'C');
							   $pdf->Cell(7	,5, $rs['Grade'],1,0,'C');
                              if(($rs['POINTS']-$rs['kcpe'])<0) { $pm= "+"; $va= ($rs['POINTS']-$rs['kcpe'])*-1;} else{$pm= "-";$va= ($rs['POINTS']-$rs['kcpe']);}  
							   $pdf->Cell(10	,5, $pm.' '.$va,1,0,'C');
							  
                             for($i=1;$i<=$tt;$i++){
			$qsc1="SELECT CONCAT(round(SUM(S".$i."),2),' ' ,rgrade(SUM(S".$i."))) AS TotalScore FROM subscores  WHERE adm='".$rs['adm']."' AND subscores.term='$term' AND year='$year'";
			$score="";
			$pos="";
			
								  $sc=mysqli_query($con,$qsc1);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
		}
		
				$poss='';
		if($pos !=="") {$poss= " (".$pos.")";} else{$poss="";}
			 $pdf->Cell(10	,5,  $score.' '.$poss,1,0,'C');
						  }
						  
                         $pdf->Cell(0	,5,'',0,1,'C');
						  
						  }
						   $header=0;
						$pdf->AddPage('l');  
						  $i=0;
						  $m=0;
						  $g=0;
						 $pdf->Ln(20);
						 
						 
						 
						 



$pdf->SetFont('Arial','B',10);
$points=0;
if(strtolower($Stream)=="all"){
							$str=""; 
						 }else{
						  $str=" and Stream ='".$Stream."' ";
						 }
$pdf->Cell(20	,10,'SUBJECT',1,0,'C');
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	  $pdf->Cell(15	,10, $rs22['sub1'],1,0,'C');
 }
 $pdf->Cell(0	,10,'',0,1,'C');
 $pdf->Cell(20	,10,'AVERAGE',1,0,'C');
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 $f=0;
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $f+=1;
	$q13 = "SELECT AVG(TotalScore) as m FROM ve WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' and subject='".$rs22['sub1']."'";
	$m=0;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
	 
	
		if($rs3['m']>0){
	$m+=$rs3['m'];
	
	
		}
 }
 $pdf->SetFont('Arial','B',10);
 if($m>0){
	  $pdf->Cell(15	,10,round($m,2),1,0,'C');
 }else{
	 $pdf->Cell(15	,10,'',1,0,'C'); 
 }
 }
 $f=0;
	 $pdf->Cell(0	,10,'',0,1,'C');
	 $pdf->Cell(20	,10,'GRADE',1,0,'C');
	 $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $f+=1;
	 $q13 = "SELECT AVG(TotalScore) as m FROM ve WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' and subject='".$rs22['sub1']."'";
	$m=0;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
	 
	
		if($rs3['m']>0){
	$m+=$rs3['m'];
	
	
		}
   	



		
 //echo $data2a;
	//echo $data12a;
 }
 //echo $m.'  ';
 
$q134 = "SELECT Grade FROM gradingscale WHERE ".round($m,0)."<= MAX AND ".round($m,0).">=Min ";
 echo $q134;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	 if($m>0){
		
	$g=$rs34['Grade'];
	
	}else{
		$g="";
	}
	
	
	$pdf->SetFont('Arial','B',10);
	  $pdf->Cell(15	,10,$g,1,0,'C');
	//VALUES/DATA
	
		//
 }	

 }
 
 $c=0;
 $pdf->Cell(0	,10,'',0,1,'C');
	 $pdf->Cell(20	,10,'ENTRY',1,0,'C');
	 $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 $c+=1;
	$data12a="";
	 $i+=1;
	 $q13 = "SELECT COUNT(distinct(Adm)) as m FROM ve WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' ";
	echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
	 $m=0;
	 if($rs3['m']>0){
		
	$m=$rs3['m'];
	
	}
	else{
		
		$m="";
		
	}
   	
$pdf->SetFont('Arial','B',10);
	  $pdf->Cell(15	,10,$m,1,0,'C');


		
 //echo $data2a;
	//echo $data12a;
 }

	
 }
 $t=0;
 $m2=0;
 $g2=0;
 $tms=0;
 $pdf->SetFont('Arial','BU',15);
	 ///$pdf->Cell(0,10,'SUMMARY',0,0,'C');
	 $pdf->Ln(30);

	 $q13 = "SELECT AVG(TotalPercent) as m,COUNT(*) AS t,AVG(TotalMarks) as tm FROM ".$f2."term WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' ";
	// echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	if($rs3['m']>0){
	$m2=$rs3['m'];
	}
	$t=$rs3['t'];
	$tms=$rs3['tm'];
	//VALUES/DATA
	
		//
 } 
  $q134 = "SELECT Grade FROM gradingscale WHERE ".round($m2,0)."<= MAX AND ".round($m2,0).">=Min ";
  //echo $q134;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){
$pdf->SetFont('Arial','',10);
	
	$g2=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }
 
 
 	
	
 //echo  $q134;
 
		
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM ".$f2."term WHERE Year='$year' $str and  term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	// echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
If($rgs['Grade']=="E"){
	$pdf->Cell(20	,10,$rgs['Grade'],1,1,'C');
	
}else{
	$pdf->Cell(20	,10,$rgs['Grade'],1,0,'C');
}
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->SetFont('Arial','B',10);
	$pdf->Cell(20	,10,'No.',1,0,'L');
 $qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2,points FROM ".$f2."term WHERE Year='$year' $str and  term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	$points+=$rs['points']*$rs['grade2'];
	$pdf->Cell(20	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->Ln(20);
 $pdf->SetFont('Times','B',15);
 $pdf->Write(5,strtoupper( '		'.'Mean Scrore-'.round($m2,2).'    Mean point-'.round(($points/$t),2).''.'    Mean Grade-'.$g2.''.'    total avg-'.$tms.''));
 $pdf->Ln(10);
						  
						  
						  
						  
						  
						  
						  
						  
						  
                     $pdf->Output('f','PDFS/broadsheet.pdf');
         
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
                echo "ERROR";
            } else {

                If ($exm =="all") {
					//grading();
                      tcheckeData();
				}
                else {
					//task();
                    process_thread();

                }
			}
    }
if (isset($_SESSION['en'])){
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
$cat1 = $_SESSION['c1'];
$cat2 = $_SESSION['c2'];
$cat3 = $_SESSION['c3'];
main();
}
else{}
	
	