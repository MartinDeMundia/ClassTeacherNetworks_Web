
<?php
session_start();
require('fpdf/fpdf.php');
require("dbconn.php");
 
class PDF extends FPDF
{
// Page header
function Header()
{
	
}

// Page footer
function Footer()
{
	$this->SetFont('Arial','B',10);
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}



$i=0;
$m=0;
$g=0;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('l');
$data="";
 
	$data1="";
	$datab="";
 
	$data1b="";		

$data2="";
 
	$data12="";	

	$data2a="";
 
	$data12a="";	
	
$name="";
$adm=0;
$series="";
 $m2=0;

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
$cat1 = $_SESSION['c1'];
$cat2 = $_SESSION['c2'];
$cat3 = $_SESSION['c3'];
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
	$q13 = "SELECT AVG(s".$f.") as m FROM subscores WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' GROUP BY adm";
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
	 $q13 = "SELECT AVG(s".$f.") as m FROM subscores WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' GROUP BY adm";
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
 // echo $q134;
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
	 $q13 = "SELECT COUNT(s".$c.") as m FROM subscores WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' and exam='ENDTERM'";
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
  $pdf->Output('i','PDFS/broadsheet.pdf');
 ?>