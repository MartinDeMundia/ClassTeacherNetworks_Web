<?php
session_start();

require("dbconn.php");
$form="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$f2="form".mysqli_real_escape_string($con,$_POST['form']);
$Stream=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$term=mysqli_real_escape_string($con,$_POST['term']);

if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='form'.$form.'term';
}else{	

$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
}
$i=0;
$m=0;
$g=0;


 
			

require('fpdf/fpdf.php');

$name="";
$adm=0;

class PDF extends FPDF
{
	 function Header()
{
	global $form,$name,$adm,$Stream,$con,$year,$term,$en;
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
	$this->Image('logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	$this->Image('uploads/logo.png',250,6,30);
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

	// Title
	$this->Cell(0,10,$year.' '.$form.' - '. $Stream.' '. $en.' EXAM ANALYSIS ',0,0,'C');
	// Line break
	$this->Ln(15);
	
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
 If ($exm =="all") {	$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
 $pdf->SetFont('Arial','BU',15);$pdf->Cell(0,10,'PLEASE SELECT EXAM',0,0,'C');}else{

 If ($Stream !="all") {
	 
	

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
 $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(0,10,'SUBJECT ANALYSIS',0,0,'C');
	 
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 $pdf->Ln(10);
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM $exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	 //echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	
	if($rs3['m']>0){
	$m=$rs3['m'];
	}
	
	
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
 
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,$i.' '.strtoupper($rs22['sub1']).'		'.'       (Mean Scrore-'.round($m,2).'    Mean Grade-'.$g.')');
	 $pdf->Ln();	
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM $exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
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
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM $exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(20	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->Ln(10);
//echo $q1;
 }
 $pdf->AddPage('L');
 //total
  $pdf->Ln(10);
 $i=0;
$m=0;
$g=0;
 $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(0,10,'SUMMARY',0,0,'C');
	 $pdf->Ln(10);

	 $q13 = "SELECT AVG(TotalPercent) as m FROM ".$f2."$exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' ";
	 //echo $q1;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	if($rs3['m']>0){
	$m=$rs3['m'];
	}
	
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
 
 $pdf->SetFont('Arial','B',15);
 $pdf->Write(5,' '.strtoupper($form).'		'.'(Mean Scrore-'.round($m,2).'    Mean Grade-'.$g.')');
 $pdf->Ln(10);
 	
	
 //echo  $q134;
 
		
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
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
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(20	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->Ln(10);
//echo $q1;

 
 
 
 
$pdf->SetTitle(strtoupper('SUBJECTS ALLOCATION LIST'));
$pdf->Output('','SUBJECTS ALLOCATION LIST.pdf');
	 
	 
 } else{
	 
	 
	 
	

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
 $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(0,10,'SUBJECT ANALYSIS',0,0,'C');
	 
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 $pdf->Ln(10);
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM $exm WHERE Year='$year' and term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	 //echo $q1;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	
	if($rs3['m']>0){
	$m=$rs3['m'];
	}
	
	
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
 
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,$i.'  '.strtoupper($rs22['sub1']).'		'.'       (Mean Scrore-'.round($m,2).'    Mean Grade-'.$g.')');
	 $pdf->Ln();	
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM $exm WHERE Year='$year' and term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
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
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM $exm WHERE Year='$year' and term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(20	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->Ln(10);
//echo $q1;
 }
 $pdf->AddPage('L');
 //total
  $pdf->Ln(10);
 $i=0;
$m=0;
$g=0;
 $pdf->SetFont('Arial','BU',15);
	 $pdf->Cell(0,10,'SUMMARY',0,0,'C');
	 $pdf->Ln(10);

	 $q13 = "SELECT AVG(TotalPercent) as m FROM ".$f2."$exm WHERE Year='$year' and term='".$term."' AND form='".$form."' ";
	 //echo $q1;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$pdf->SetFont('Arial','',10);
	if($rs3['m']>0){
	$m=$rs3['m'];
	}
	
	//VALUES/DATA
	
		//
 } 
 
  //echo $q1;
  $q134 = "SELECT Grade FROM gradingscale WHERE ".$m."<= MAX AND ".$m.">=Min ";
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){
$pdf->SetFont('Arial','',10);
	
	$g=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }
 
 $pdf->SetFont('Arial','B',15);
 $pdf->Write(5,' '.strtoupper($form).'		'.'(Mean Scrore-'.round($m,2).'    Mean Grade-'.$g.')');
 $pdf->Ln(10);
 	 
	
 //echo  $q134;
 
		
	$pdf->SetFont('Arial','B',10); 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	$pdf->Cell(20	,10,'GRADE',1,0,'L');
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	$pdf->SetFont('Arial','',10);
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year' and term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	 //echo $q1;
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
	
	
	
	 $q1 = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year' and term='".$term."' AND form='".$form."'  AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(20	,10,$rs['grade2'],1,0,'C');
	
	
	//VALUES/DATA
	
		//
 }
		
	
		}
		$pdf->Ln(10);
//echo $q1;

 
 
 
 
$pdf->SetTitle(strtoupper('SUBJECTS ALLOCATION LIST'));
$pdf->Output('f','PDFS/analyze.pdf'); 
	 
	 
	 
 }
 }

?>
	