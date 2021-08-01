<?php
session_start();
require("dbconn.php");
$form="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$f2="form".mysqli_real_escape_string($con,$_POST['form']);


$Stream=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$year=mysqli_real_escape_string($con,$_POST['year']);

$en=mysqli_real_escape_string($con,$_POST['exam']);
$exm='all';
$cat1 = "True";
$cat2 = "False";
$cat3 = "False";
$subjectno=0;
$lmt = 0; 
if(strtolower($Stream)=="all"){
	$str="";
}

else{
	$str="and ".$f2."term.Stream='$Stream'";
}


require('fpdf/diag.php');
$name="";
$adm=0;
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

 $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno,CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `sudtls`.`kcpe`- `".$f2."term`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='TERM 1'     $str";
 


class PDF extends FPDF
{
// Page header
function Header()
{
	global $form,$name,$adm,$stream;
		// Logo

	$this->Image('logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
	// Title
	$pdf->Cell(0,10,$title,0,0,0);
	// Line break
	$pdf->Ln(5);

	// Title
	$pdf->Cell(0,10,$address,0,0,0);

	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(10);

	// Title
	$this->Cell(0,10,'ACADEMIC TRANSCRIPT',0,0,'C');
	// Line break
	$this->Ln(15);
	
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	
}
}

// Instanciation of inherited class


$pdf = new PDF_Diag();
$pdf->AliasNbPages();
$pdf->AddPage('l');
	$pdf->SetFont('Arial','B',10);
 
	// Arial bold 15
	echo $q1;
	 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
	  $tavg=0;
	  $q2 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `sudtls`.`kcpe`- `".$f2."term`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE ".$f2."term.adm='".$rs['adm']."' AND Year='$year' and Term='TERM 2'    $str";
 /////echo $q2;
 $q3 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `sudtls`.`kcpe`- `".$f2."term`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE ".$f2."term.adm='".$rs['adm']."' AND Year='$year' and Term='TERM 3'    $str";
 $ts1=0;
 $ts2=0;
$tp1=0;
$tp2=0;
$mg1=0;
$mg2=0;
$sn=1;
 //echo $q3;
	  $qq1=mysqli_query($con,$q2);
 while($rs1=mysqli_fetch_assoc($qq1)){
	
$ts1=$rs1['TotalMarks'];
$tp1=$rs1['TotalPercent'];
$mg1=$rs1['Grade'];
	
 }
	
	  $qq2=mysqli_query($con,$q3);
 while($rs2=mysqli_fetch_assoc($qq2)){
	
$ts2=$rs2['TotalMarks'];
$tp2=$rs2['TotalPercent'];
$mg2=$rs2['Grade'];
	
 } 
	 $pdf->SetFont('Times','B',14);
	$pdf->Image('uploads/logo.png',10,6,20);
	
	$pdf->Image('uploads/stamp.png',220,150,50);
	$pdf->Cell(0,10,strtoupper($title),0,0,'C');
	// Line break
	$pdf->Ln(5);

	// Title
	$pdf->Cell(0,10,strtoupper($address),0,0,'C');
	// Line break
	// Line break
	$pdf->Ln(5);

	// Title
	$pdf->Cell(0,10,strtoupper($tel),0,0,'C');
	// Line break
	// Line break
	$pdf->Ln(7);

	// Title
	$pdf->Cell(0,10,'ACADEMIC TRANSCRIPT',0,0,'C');
	// Line break
	$pdf->Ln(10);
	$pdf->Cell(27);
 $pdf->Line(10,34,285,34);
//$this->Line(6,46,185,46);
$pdf->SetLineWidth(0.5);
$pdf->Line(10,35,285,35);


$pdf->Cell(27);
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,'NAME');
	$pdf->SetFont('Arial','',12);
	$pdf->Write(5,'      '.$rs['Name'].'                ');
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,'ADM No.');
	$pdf->SetFont('Arial','',12);
	$pdf->Write(5,'    '.$rs['adm'].'    ');
	$pdf->SetFont('Arial','B',12);
	$pdf->Write(5,'');
	$pdf->SetFont('Arial','',12);
	$pdf->Write(5,'    '.$form.'-'.strtoupper($rs['Stream']).'    ');
$pdf->Line(10,55,290,55);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(70	,10,'SUBJECTS',0,0);
	$pdf->Cell(60	,10,'TERM 1',0,0,'C');
	$pdf->Cell(50	,10,'TERM 2',0,0,'C');
	$pdf->Cell(50	,10,'TERM 3',0,0,'C');
	$pdf->Cell(50	,10,'AVG/YR',0,1,'C');
	
	
	$pdf->SetFont('Arial','',10);
	$qs="SELECT Abbreviation,CONCAT(UPPER(description),' (',subjects.code,')') AS subs FROM  subjectoptionsa LEFT JOIN subjects ON (subjects.code=subjectoptionsa.code)  where adm='".$rs['adm']."' ORDER BY subjects.code asc ";
					$count2=0;			  $subs=mysqli_query($con,$qs);
				$count=0;			  
		while($sr=mysqli_fetch_assoc($subs)){		
		
		$count+=1;
		$total=0;
		$qsc1v="SELECT concat(round((Totalscore)),' ' ,rgrade((Totalscore))) as TotalScore,round((Totalscore)) as c FROM ve   WHERE adm='".$rs['adm']."' AND ve.term='term 1' AND year='$year'";
			$score="";
			$score1="";
			$pos="";
			$remarks="";
			 //echo $qsc1v;
		$sc=mysqli_query($con,$qsc1v);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
			$score1=$ss['c'];
		} if ($score1>0){
		$q134 = "SELECT Remarks FROM gradingscale WHERE ".$score1."<= MAX AND ".$score1.">=Min ";

 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	
	$remarks=$rs34['Remarks'];
	
	
	//VALUES/DATA
	
		//
 }
		}
		
		//term 2
		
		$qsc1v="SELECT concat(round(Totalscore),' ' ,rgrade(Totalscore)) as TotalScore,round(Totalscore) as c FROM ve   WHERE adm='".$rs['adm']."' AND ve.term='term 2' AND year='$year'";
			$scoret2="";
			$score1t2="";
			$post2="";
			$remarkst2="";
			 //echo $qsc1v;
		$sc=mysqli_query($con,$qsc1v);
		while($ss=mysqli_fetch_assoc($sc)){
			$scoret2=$ss['TotalScore'];
			$score1t2=$ss['c'];
		} if ($score1t2>0){
		$q134 = "SELECT Remarks FROM gradingscale WHERE ".$score1."<= MAX AND ".$score1.">=Min ";

 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	
	$remarkst2=$rs34['Remarks'];
	
	
	//VALUES/DATA
	
		//
 }
		}
		
		$qsc1v="SELECT concat(round(Totalscore),' ' ,rgrade(Totalscore)) as TotalScore,round(Totalscore) as c FROM ve   WHERE adm='".$rs['adm']."' AND ve.term='term 3' AND year='$year'";
			$scoret3="";
			$score1t3="";
			$post3="";
			$remarkst3="";
			 //echo $qsc1v;
		$sc=mysqli_query($con,$qsc1v);
		while($ss=mysqli_fetch_assoc($sc)){
			$scoret3=$ss['TotalScore'];
			$score1t3=$ss['c'];
		} if ($score1t3>0){
		$q134 = "SELECT Remarks FROM gradingscale WHERE ".$score1."<= MAX AND ".$score1.">=Min ";

 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	
	$remarkst3=$rs34['Remarks'];
	
	
	//VALUES/DATA
	
		//
 }
		}
		$sn=1;
		$sn2=1;
	$query="SELECT count(distinct(code)) as subno from subjectoptionsa where adm='".$rs['adm']."' ";
	//echo $query ;
	$return=mysqli_query($con,$query);
	
	while($r=mysqli_fetch_assoc($return)){
		$sn=$r['subno'];
		$sn2=$r['subno'];
	}
	if($sn==0){
		$sn2=1;
	$sn=1;}
		$tavg+=round((($score1+$score1t2+$score1t3)/3),1);
	$pdf->Cell(70	,10,$sr['subs'],0,0);
	$pdf->Cell(60	,10,$score,0,0,'C');
	$pdf->Cell(50	,10,$scoret2,0,0,'C');
	$pdf->Cell(50	,10,$scoret3,0,0,'C');
	$pdf->Cell(50	,10,round((($score1+$score1t2+$score1t3)/3),1).' - '.g(round((($score1+$score1t2+$score1t3)/3),1)),0,1,'C');
	
		}
		
		$pdf->SetLineWidth(0.5);
$pdf->Line(10,($sn2*10)+55,290,($sn2*10)+55);

$pdf->SetLineWidth(0.2);
$pdf->Line(10,($sn2*10)+80,290,($sn2*10)+80);
$pdf->SetLineWidth(0.1);
$pdf->Line(10,($sn2*10)+67,290,($sn2*10)+67);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(70	,10,'TOTAL',0,0);
	$pdf->Cell(60	,10,round($rs['TotalMarks'],2).'  '.round($rs['TotalPercent'],2).'%   '.''.$rs['Grade'].'',0,0,'C');
	$pdf->Cell(50	,10,$ts1.'  '.$tp1.'%   '.''.$mg1.'',0,0,'C');
	$pdf->Cell(50	,10,$ts2.'  '.$tp2.'% '.''.$mg2.'',0,0,'C');
	$pdf->Cell(50	,10,round(($tavg/$sn),1),0,1,'C');
	$pdf->SetFont('Arial','B',13);
		$pdf->Cell(70	,10,'YEARLY: ',0,0);
	$pdf->Cell(60	,10,'TOTAL MARKS: '.round((($ts1+$ts2+$rs['TotalMarks'])/3),2).'/'.($sn*100),0,0);
	$pdf->Cell(50	,10,'MEAN SCORE: '.round(($tavg/$sn),1),0,0);
	$scoreg=round(($tavg/$sn),0);
	$gq = "SELECT points,grade FROM gradingscale WHERE ".$scoreg."<= MAX AND ".$scoreg.">=Min ";
$p=0;
$g="";
 $gg=mysqli_query($con,$gq);
 while($ggg=mysqli_fetch_assoc($gg)){

	
	$g=$ggg['grade'];
	$p=$ggg['points'];
	//VALUES/DATA
	
		//
 }
	$ps = "SELECT kcpe FROM sudtls WHERE adm='".$rs['adm']."'";
$p1=0;
//echo $ps;
 $pp=mysqli_query($con,$ps);
 while($ppp=mysqli_fetch_assoc($pp)){

	
	$p1=$ppp['kcpe'];
	
	
		//
 }
	$va="";
	if(($p-$p1)>0) {
		$va="+".($p1-$p);
	}else{
		$va=($p-$p1);
	}
	$pdf->Cell(50	,10,'MEAN GRADE: '.$g,0,0);
	$pdf->Cell(50	,10,'V/A: '.$va,0,0);
$pdf->AddPage('l');
 }
$pdf->Output('f','PDFS/transcript.pdf');


function g($grade){
	global $con;
	$gq = "SELECT points,grade FROM gradingscale WHERE ".$grade."<= MAX AND ".$grade.">=Min ";

$g="";
 $gg=mysqli_query($con,$gq);
 while($ggg=mysqli_fetch_assoc($gg)){

	
	$g=$ggg['grade'];
	
 }
 return $g;
}
?>
	