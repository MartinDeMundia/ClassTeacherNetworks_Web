<?php
session_start();
require("dbconn.php");
require('fpdf/diag.php');
$title='';
$address='';
$tel='';
$q1s="select description from settings where type='system_title'";
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}
$subject=mysqli_real_escape_string($con,$_POST['subject']);
$form=mysqli_real_escape_string($con,$_POST['form']);
//$f2=str_replace("form";mysqli_real_escape_string($con,$_POST['form']);
$stream=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$term=mysqli_real_escape_string($con,$_POST['term']);
   
$best=mysqli_real_escape_string($con,$_POST['best']);
$sub=mysqli_real_escape_string($con,$_POST['sub']);
$lmt=mysqli_real_escape_string($con,$_POST['lmt']);

if(strtolower($en=="END OF TERM")){
$exm='form'.$form.'term';
}else{	
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
}
 if(strtolower($stream)=="all"){
							$str=""; 
						 }else{
						  $str=" and Stream ='".$stream."' ";
						 }


		if(file_exists('PDFS/uu.pdf')){
rename('PDFS/markbook.pdf','PDFS/'.date('dmyh:i:sa').'pdf');
		}
$q1s="select description from settings where type='address'";
  $qs="SELECT code from subjects where Abbreviation='".$subject."'";
 // echo $qs;
								  $rs1=mysqli_query($con,$qs);
								  while($rows1=mysqli_fetch_assoc($rs1)){
									$code=$rows1['code'];
								  }
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}

class PDF extends FPDF
{
protected $col = 0; // Current column
protected $y0;      // Ordinate of column start

function Header()
{
	// Page header
	global $title,$tel,$address,$con,$form,$term,$en,$stream,$year,$subject,$best,$lmt,$sub;

	$this->Image('uploads/logo.png',170,6,20);
	// Arial bold 15
	$this->SetFont('Arial','B',9);
	
	// Title
	$this->Cell(0,10,$title,0,0,'l');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,$address,0,0,'l');
$this->Ln(5);
	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'l');
	// Line break
	// Line break
	$this->Ln(5);
	if($best=="Yes"){
		$t="top";
		$order="DESC";
	}else{
		$t="Bottom";
		$order="ASC";
	}
	if($sub=="Yes"){
	 $this->Cell(0	,10,strtoupper($en.' '.$subject.' '.$t.' '.$lmt.' students   - form '.$form. ' '.$stream. ' '.$year) ,0,0,'C');
	}else{
		
		 $this->Cell(0	,10,strtoupper($en.' '.$t.' '.$lmt.' students   - form '.$form. ' '.$stream. ' '.$year) ,0,0,'C');
	}
	
$this->Line(10,32,200,32);
//$this->Line(6,46,185,46);
$this->SetLineWidth(0.5);
$this->Line(10,33,200,33);
$this->Ln(5);

$this->Cell(15	,10,'',0,0,'L');
								  $this->Cell(10	,10,'',0,0,'L'); 
                                  $this->Cell(20	,10,'',0,0,'L');   
								  $this->Cell(50	,10,'',0,0,'L');
								  
						  $this->Cell(0	,10,'' ,0,1,'C');
						   
						  $this->Cell(15	,7,'#','B',0,'L');
								  $this->Cell(10	,7,'ST','B',0,'L'); 
                                  $this->Cell(20	,7,'ADM','B',0,'L');   
								  $this->Cell(60	,7,'NAME ','B',0,'L');
								   $this->Cell(20	,7,'SCORE','B',0,'L');
								      $this->Cell(20	,7,'%','B',0,'L');
								    $this->Cell(20	,7,'GRADE','B',0,'L');
						  $this->Cell(0	,10,'' ,0,1,'C');
}

function Footer()
{
	// Page footer
	$this->SetY(-15);
	$this->SetFont('Arial','I',8);
	$this->SetTextColor(128);
	$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}
}

$pdf = new PDF();
$pdf->SetLeftMargin(20);
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetFont('Times','B',8);
							
						  
						 //where Form='$form' and Stream='$stream'
						 if($best=="Yes"){
		$t="top";
		$order="DESC";
	}else{
		$t="Bottom";
		$order="ASC";
	}
						 if($sub=="Yes"){
		if($en=="END OF TERM"){
						 $qs1="SELECT totalscore AS count,Adm,Grade FROM ve where  code='$code' and  term='$term' and year='$year'  $str ORDER BY totalscore $order LIMIT $lmt ";
						
					}else {
		 $qs1="SELECT $exm AS count,limit1,Adm FROM form".$form." where  code='$code' and  term='$term' and year='$year' and etype='$en' $str ORDER BY $exm $order LIMIT $lmt ";
					}
	}else{
			 $qs1="SELECT TotalPercent  AS count,Adm,Grade FROM form".$form."".$exm." where   term='$term' and year='$year' $str ORDER BY TotalPercent $order LIMIT $lmt";
	}
		$subs1=mysqli_query($con,$qs1);
		$res=0;
		$lmt=0;
		$p=0;
		echo $qs1;
		 $NUM=0;
		while($sr2=mysqli_fetch_assoc($subs1)){
						 
						$query="SELECT * from sudtls where adm='".$sr2['Adm']."'";
						  $results=mysqli_query($con,$query);
						echo $query;
						 $NUM+=1;
						 while($row=mysqli_fetch_assoc($results)){
							  
							 
								 
								  $pdf->Cell(15	,5,$NUM,'B',0,'L');
								  $pdf->Cell(10	,5, substr($row['Stream'],0,1),'B',0,'L'); 
                                  $pdf->Cell(20	,5, $row['Adm'],'B',0,'L');   
								  $pdf->Cell(60	,5,$row['Name'],'B',0,'L');
	 }
			/////////// }
						  $res=$sr2['count'];
						 if($sub=="Yes") {
							 if($en=="END OF TERM"){
							 }else{
							 $lmt1=$sr2['limit1'];
							 }
							 }
						 
						 $p=$res;
						  if($res>=1){
							  if($sub=="Yes") {
								  if($en=="END OF TERM"){
							 }else{
								  $p=($res/$lmt1)*100;
							 }
								  }
						  $pdf->Cell(20	,5,round($res,2) ,'B',0,'C');
						   $pdf->Cell(20	,5,round($p,2) ,'B',0,'L');
						   
						   $qs1U="SELECT grade   AS count FROM gradingscale where min>=$p and max<=$p";
		$subs1U=mysqli_query($con,$qs1U);
		$res1=0;
		//echo $qs1U;
		while($sr2U=mysqli_fetch_assoc($subs1U)){
						   $res1=$sr2U['count'];
		}
						  $pdf->Cell(20	,5,$sr2['Grade'] ,'B',0,'L');
						  }else{
							   $pdf->Cell(20	,5,'-' ,'B',0,'C');
							  $pdf->Cell(20	,5,'-' ,'B',0,'L');
							  $pdf->Cell(20	,5,'-' ,'B',0,'L');
						  }
						  
						 $pdf->Cell(0	,5,'' ,0,1,'L'); }
						 $pdf->SetFont('Arial','B',8);
						  $pdf->Ln(5);
						  if($sub=="Yes"){
							  $ct="SUBJECT";
							   $qs="SELECT Name from subjectallocationa where Code='".$code."' and Form='form $form' and Stream='$stream'";
 // echo $qs;
								  $rs1=mysqli_query($con,$qs);
								  while($rows1=mysqli_fetch_assoc($rs1)){
									$ctt=$rows1['Name'];
								  }
						  }
						  else{
							  
							  $ct="CLASS";
							   $qs="SELECT teacher from classes where  form='form $form' and stream='$stream'";
 // echo $qs;$
 $c1="";
								  $rs1=mysqli_query($con,$qs);
								  while($rows1=mysqli_fetch_assoc($rs1)){
									$c1=$rows1['teacher'];
								  }
								  
								  $qs="SELECT Names,Initial from staffs where  Empno='$c1' ";
 // echo $qs;$
 $c2="";
								  $rs1=mysqli_query($con,$qs);
								  while($rows1=mysqli_fetch_assoc($rs1)){
									$ctt=$rows1['Names'];
									$c2=$rows1['Initial'];
								  }
								  
						  }
						 
						 $pdf->Write(5,$ct.' TEACHER   '.$ctt.'                           ');
						 
						 $pdf->Write(5,'SIGNATURE    '.$c2.'           DATE     '.date("D M Y").'');
						 
$pdf->Output('f','PDFS/topbottom.pdf');

	?>
	