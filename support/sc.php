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
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));

$f="";
$qs="SELECT Name  FROM form where Id='$form'";
$results=mysqli_query($con,$qs);
while($rs=mysqli_fetch_assoc($results)){
	
	$f=$rs['Name'];
}



$divv='';
if($en=="END OF TERM")
{
	
	
	
	$exm="ve";
}else{
	
	$equery = "SELECT openexam.limit FROM openexam WHERE  form='".$f."' and term='$term' and year='$year' and exam='$en' limit 1";
	//echo $equery;
	$r=$con->query($equery);
	$ro=$r->fetch_assoc();
	
	$divv=' / '.$ro['limit'];
	
	
}





		if(file_exists('PDFS/uu.pdf')){
rename('PDFS/markbook.pdf','PDFS/'.date('dmyh:i:sa').'pdf');
		}
$q1s="select description from settings where type='address'";
  $qs="SELECT code from subjects where Abbreviation='".$subject."'";
								  $rs=mysqli_query($con,$qs);
								  while($rows=mysqli_fetch_assoc($rs)){
									$code=$rows['code'];
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
	global $title,$tel,$address,$con,$f,$term,$en,$stream,$year,$subject,$divv;

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
	 $this->Cell(0	,10,strtoupper($en.' '.$subject.' score sheet   -  '.$f. ' '.$stream. ' '.$year) ,0,0,'C');
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
								   $this->Cell(20	,7,'SCORE'.$divv,'B',0,'L');
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
							
						  $pdf->SetFont('Times','',8);
						 //where Form='$form' and Stream='$stream'
						 if(strtolower($stream)=="all"){
							 $query="SELECT * from sudtls where Form='$form'";
						 }else{
						  $query="SELECT * from sudtls where Form='$form' and Stream='$stream'";
						 }
						  $results=mysqli_query($con,$query);
						  $NUM=0;
						 while($row=mysqli_fetch_assoc($results)){
							  $NUM+=1;
							  $qs="SELECT Code AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
								  $pdf->Cell(15	,5,$NUM,'B',0,'L');
								  $pdf->Cell(10	,5, substr($row['Stream'],0,1),'B',0,'L'); 
                                  $pdf->Cell(20	,5, $row['Adm'],'B',0,'L');   
								  $pdf->Cell(60	,5,$row['Name'],'B',0,'L');
					if($en=="END OF TERM"){
						 $qs1="SELECT totalscore  AS count FROM ".$exm." where Adm='".$row['Adm']."' and code='$code' and  term='$term' and year='$year' and form='$f' order by totalscore desc";
						
					}else {
			 $qs1="SELECT $exm  AS count,limit1 FROM scores where Adm='".$row['Adm']."' and code='$code' and  term='$term' and year='$year' and etype='$en' order by $exm desc";
					}
		$subs1=mysqli_query($con,$qs1);
		$res=0;
		$lmt=0;
		$p=0;
		$div='';
		$mult=1;
		while($sr2=mysqli_fetch_assoc($subs1)){
			
						  $res=$sr2['count'];
						  if($en=="END OF TERM"){
							  $lmt=1;
						  }else{
						  $lmt=$sr2['limit1'];
						  $div='/'.$lmt.'';
						  $mult=100;
						  }
						 
						  }
						  if($res>=1){
							  $p=($res/$lmt)*$mult;
						  $pdf->Cell(20	,5,round($res,0) ,'B',0,'C');
						   $pdf->Cell(20	,5,round($p,0) ,'B',0,'L');
						   
						   $qs1U="SELECT grade   AS count FROM gradingscale where min>=$res and max<=$p";
		$subs1U=mysqli_query($con,$qs1U);
		$res1=0;
		//echo $qs1U;
		while($sr2U=mysqli_fetch_assoc($subs1U)){
						   $res1=$sr2U['count'];
		}
						  $pdf->Cell(20	,5,$res1 ,'B',0,'L');
						  }else{
							   $pdf->Cell(20	,5,'-' ,'B',0,'C');
							  $pdf->Cell(20	,5,'-' ,'B',0,'L');
							  $pdf->Cell(20	,5,'-' ,'B',0,'L');
						  }
						  
						 $pdf->Cell(0	,5,'' ,0,1,'L'); }
						 $pdf->SetFont('Arial','B',8);
						  $pdf->Ln(5);
						 $pdf->Write(5,'SUBJECT TEACHER..................................................................                            ');
						 
						 $pdf->Write(5,'SIGNATURE.................DATE........................');
						 
$pdf->Output('f','PDFS/score.pdf');

	?>
	