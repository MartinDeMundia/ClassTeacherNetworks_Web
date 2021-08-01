<?php
session_start();
if (isset($_SESSION['form'])){
$subjectno=0;
$lmt = 0; 
$form=$_SESSION['form'];
$f2=$_SESSION['f2'];
$Stream=strtoupper($_SESSION['Stream']);
$year=$_SESSION['year'];
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$term=$_SESSION['term'];

$st=$_SESSION['st'];
$adm=$_SESSION['adm'];
$exm='all';
$cat1 = $_SESSION['c1'];
$cat2 = $_SESSION['c2'];
$cat3 = $_SESSION['c3'];
}


require("dbconn.php");
If ($Stream =="ALL") {
                If ($exm =="all") {
                    $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent` , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, (`sudtls`.`kcpe`- `".$f2."term`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno'";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT `".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,(`sudtls`.`kcpe`- `".$f2."$exm`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' and subno>='$subjectno';";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `sudtls`.`kcpe`- `".$f2."term`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' and ".$f2."term.Stream='$Stream'";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT `".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,`sudtls`.`kcpe`- `".$f2."$exm`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' and subno>='$subjectno';";
			}
			}

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
	$pdf->Cell(0,10,$title,0,0,'R');
	// Line break
	$pdf->Ln(5);

	// Title
	$pdf->Cell(0,10,$address,0,0,'R');

	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(2);

	// Title
	$this->Cell(0,10,'ACADEMIC PROGRESS REPORT',0,0,'C');
	// Line break
	$this->Ln(5);
	
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
$pdf->AddPage();
	$pdf->SetFont('Arial','B',10);
	
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){
	
	 $pdf->Image('uploads/logo.png',10,6,20);
	// Arial bold 15
	$pdf->SetFont('Arial','B',10);
	
	// Title
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
	$pdf->Cell(0,10,'ACADEMIC PROGRESS REPORT',0,0,'C');
	// Line break
	$pdf->Ln(15);
	$pdf->Cell(27);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'NAME');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'      '.$rs['Name'].'       ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'ADM No.');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.$rs['adm'].'    ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'FORM');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.$form.'-'.strtoupper($rs['Stream']).'    ');
	$pdf->Ln(10);
	if (file_exists('uploads/student_image/'.$rs['adm'].'.jpg')) {
	$pdf->Image('uploads/student_image/'.$rs['adm'].'.jpg',170,6,30);
	$adm=$rs['adm'];
	}
	else{
		$pdf->Image('uploads/user.jpg',170,6,30);
		
	}
	$pdf->SetFont('Arial','B',10);
 $tt=0;
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
	$pdf->Cell(40	,10,'SUBJECTS',1,0);
	$pdf->Cell(20	,10,'CAT 1',1,0,'C');
	$pdf->Cell(20	,10,'CAT 2',1,0,'C');
	$pdf->Cell(20	,10,'CAT 3',1,0,'C');
	$pdf->Cell(20	,10,'EXAM',1,0,'C');
	$pdf->Cell(15	,10,'TOTAL',1,0,'C');
	$pdf->Cell(35	,10,'REMARKS',1,0,'C');
	$pdf->Cell(20	,10,'INITIALS',1,1,'C');
	
	
	//VALUES/DATA
	$count=0;
	$pdf->SetFont('Arial','',8);
	$qs="SELECT Abbreviation,CONCAT(UPPER(Abbreviation),' ',subjects.code) AS subs FROM  subjects  ORDER BY subjects.code asc";
								  $subs=mysqli_query($con,$qs);
				//echo $qs;				  
		while($sr=mysqli_fetch_assoc($subs)){		
		$count+=1;
	$pdf->Cell(40	,5,$sr['subs'],1,0);
	
	
$qsc11="SELECT concat(round(TotalScore),' ' ,gradingscale.grade) as TotalScore,PosClass  FROM cat1 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)  WHERE adm='".$rs['adm']."' AND cat1.term='$term' AND year='$year' and Subject='".$sr['Abbreviation']."'";
			$score="";
			$pos="";
			
		$sc1=mysqli_query($con,$qsc11);
		while($ss1=mysqli_fetch_assoc($sc1)){
			$score=$ss1['TotalScore'];
			$pos=$ss1['PosClass'];
	
		}
		if($pos !=="") {
	$pdf->Cell(20	,5,$score.'('.$pos.')',1,0,'C');
		}else{
			
			$pdf->Cell(20	,5,$score,1,0,'C');
		}
		
		$qsc12="SELECT concat(round(TotalScore),' ' ,gradingscale.grade) as TotalScore,PosClass  FROM cat2 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)  WHERE adm='".$rs['adm']."' AND cat2.term='$term' AND year='$year' and Subject='".$sr['Abbreviation']."'";
			$score="";
			$pos="";
			
		$sc2=mysqli_query($con,$qsc12);
		while($ss2=mysqli_fetch_assoc($sc2)){
			$score=$ss2['TotalScore'];
			$pos=$ss2['PosClass'];
	
		}
		if($pos !=="") {
	$pdf->Cell(20	,5,$score.'('.$pos.')',1,0,'C');
		}else{
			
			$pdf->Cell(20	,5,$score,1,0,'C');
		}
		
		$qsc13="SELECT concat(round(TotalScore),' ' ,gradingscale.grade) as TotalScore,PosClass  FROM cat3 left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)  WHERE adm='".$rs['adm']."' AND cat3.term='$term' AND year='$year' and Subject='".$sr['Abbreviation']."'";
			$score="";
			$pos="";
			
		$sc3=mysqli_query($con,$qsc13);
		while($ss3=mysqli_fetch_assoc($sc3)){
			$score=$ss3['TotalScore'];
			$pos=$ss3['PosClass'];
	
		}
		if($pos !=="") {
	$pdf->Cell(20	,5,$score.'('.$pos.')',1,0,'C');
		}else{
			
			$pdf->Cell(20	,5,$score,1,0,'C');
		}
		
		
	$qsc1="SELECT concat(round(TotalScore),' ' ,gradingscale.grade) as TotalScore,PosClass  FROM endterm left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)  WHERE adm='".$rs['adm']."' AND endterm.term='$term' AND year='$year' and Subject='".$sr['Abbreviation']."'";
			$score="";
			$pos="";
			
		$sc=mysqli_query($con,$qsc1);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
			$pos=$ss['PosClass'];
	
		}
		if($pos !=="") {
	$pdf->Cell(20	,5,$score.'('.$pos.')',1,0,'C');
		}else{
			
			$pdf->Cell(20	,5,$score,1,0,'C');
		}
	//TOTAL
	$qsc1v="SELECT concat(round(SUM(S".$count.")),' ' ,rgrade(SUM(S".$count."))) as TotalScore,round(SUM(S".$count.")) as c FROM subscores   WHERE adm='".$rs['adm']."' AND subscores.term='$term' AND year='$year'";
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
	$pdf->Cell(15	,5,$score,1,0,'C');
	$pdf->Cell(35	,5,$remarks,1,0,'C');
		$qsc1I="SELECT Initial  FROM subjectallocationa WHERE  form='$form' and stream='$Stream' and Subject='".$sr['Abbreviation']."'";
			$ini="";
		$scI=mysqli_query($con,$qsc1I);
		while($ssI=mysqli_fetch_assoc($scI)){
			$ini=strtoupper($ssI['Initial']);
		}
	$pdf->Cell(20	,5,$ini,1,1,'C');
	
	
		}
		
		$pdf->Ln(10);
		$grade=$rs['Grade'];
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'TOTAL MARKS');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'      '.$rs['TotalMarks'].'       ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'M/S.');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.$rs['TotalPercent'].'    ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'M/G');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.$rs['Grade']. '  ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'POINTS');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.$rs['POINTS']. '  ');
	$pdf->SetFont('Arial','',6);
	$pdf->Write(5,'                   X-ABSENT  Y-IRREGULARITY Z-NOT GRADED  (#)-Pos');
	$pdf->Ln(15);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'POSITION IN:  CLASS');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'      '.$rs['PosClass'].'       ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'STREAM.');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.$rs['PosStream'].'    ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'    VALUE ADDITION');
	$pdf->SetFont('Arial','U',10);
	$VA=0;
	if($rs['VALUE_ADDITION']<0) { 
	
	$VA ="+". ($rs['VALUE_ADDITION']*-1);
	
	} else{
		
		$VA= "-".$rs['VALUE_ADDITION'];
		
		
		}
	$pdf->Write(5,'    '.$VA. '  ');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$data1=0;
	$data2=0;
	$tb="";
	$t1="";
	$t2="";	
	$query1="";
	$query2="";
	$t="";
	$f="";
	
	if($form=='FORM 1'){
		
		if($term == "Term 1"){
		$t="Term2";
		$f="FORM 1";
	
		$query1="Select count(TotalPercent) as TotalPercent,term from ".$f2."term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select count(TotalPercent) as TotalPercent,term from ".$f2."term where term='Term 3' and adm='".$rs['adm']."'";
	}elseif($term=="Term 2"){
		$t="Term3";
		$f="FORM 1";
		$query1="Select count(TotalPercent) as TotalPercent from ".$f2."term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from ".$f2."term where term='Term 1' and adm='".$rs['adm']."'";
	}elseif($term=="Term 3"){
		$query1="Select TotalPercent,term from ".$f2."term where term='Term 3' and adm='".$rs['adm']."'";
		$t="Term1";
		$f="FORM 2";
		$query2="Select TotalPercent,term from ".$f2."term where term='Term 2' and adm='".$rs['adm']."'";
	}
		
	}elseif($form=="FORM 2"){
		////////////
		if($term=="Term 1"){
		$t="Term2";
		$f="FORM 2";			
		$query1="Select TotalPercent,term from ".$f2."term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from ".$f2."term where term='Term 2' and adm='".$rs['adm']."'";
	}elseif($term=="Term 2"){
		$query1="Select TotalPercent,term from ".$f2."term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form2term where term='Term 2' and adm='".$rs['adm']."'";
		$t="Term3";
		$f="FORM 2";
	}elseif($term=="Term 3"){
		$t="Term1";
		$f="FORM 3";
		$query1="Select TotalPercent,term from form2term where term='Term 1' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form2term where term='Term 2' and adm='".$rs['adm']."'";
	}
		/////////////////
	}
	
	elseif($form=="FORM 3"){
		////////////
		if($term=="Term 1"){

				$t="Term2";
				$f="FORM 3";
		$query1="Select TotalPercent,term from form2term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form2term where term='Term 2' and adm='".$rs['adm']."'";
	}elseif($term=="Term 2"){
		$query1="Select TotalPercent,term from form2term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form3term where term='Term 2' and adm='".$rs['adm']."'";
		$t="Term3";
		$f="FORM 3";
	}elseif($term=="Term 3"){
		$t="Term1";
		$f="FORM 4";
		$query1="Select TotalPercent,term from form3term where term='Term 1' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form3term where term='Term 2' and adm='".$rs['adm']."'";
	}
		/////////////////
	}
	elseif($form=="FORM 4"){
		////////////
		if($term=="Term 1"){
				$t="Term2";
		$f="FORM 4";
		$query1="Select TotalPercent,term from form3term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form3term where term='Term 2' and adm='".$rs['adm']."'";
	}elseif($term=="Term 2"){
		$query1="Select TotalPercent,term from form3term where term='Term 3' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form4term where term='Term 2' and adm='".$rs['adm']."'";
		$t="Term3";
		$f="FORM 4";
	}elseif($term=="Term 3"){
		
		$query1="Select TotalPercent,term from form4term where term='Term 1' and adm='".$rs['adm']."'";
		$query2="Select TotalPercent,term from form4term where term='Term 2' and adm='".$rs['adm']."'";
	}
		/////////////////	
	}
	
	$b=0;$tr=0;
		 $q1f="select Term1,Term2,Term3,Feepaid,Name,Form,Stream,Balance from studentsrecord where Sadm='".$rs['adm']."' limit 1";

$r11=mysqli_query($con,$q1f);
while($row21=mysqli_fetch_assoc($r11)){
	 $b=$row21['Balance'];
	
 
}
		 $q1f="select ".$t." as term from feestructure where Form='".$f."' limit 1";
//echo $q1f;
$r11=mysqli_query($con,$q1f);
while($row21=mysqli_fetch_assoc($r11)){
	 $tr=$row21['term'];
	
 
} //echo $query1 .'     '. $term;
	$sq=mysqli_query($con,$query1);
		while($rowgr=mysqli_fetch_assoc($sq)){
			$data1=$rowgr['TotalPercent'];
			$t1=$rowgr['term'];
			
		}
		
		$sq1=mysqli_query($con,$query2);
		while($rowgr1=mysqli_fetch_assoc($sq1)){
			$data2=$rowgr1['TotalPercent'];
			$t2=$rowgr1['term'];
		}
if($data1==0){
	$data1=0;
}

if($data2==0){
	$data2=0;
}
	//Bar diagram
	$data = array($term => $rs['TotalPercent'], $t1 => $data1, $t2 => $data2);
	$pdf->SetFont('Arial', '', 10);
$valX = $pdf->GetX();
$valY = $pdf->GetY();



$col1=array(100,100,255);
$col2=array(255,100,100);
$col3=array(255,255,100);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
$pdf->BarDiagram(20, 30, $data, '%l : %v (%p)', array(220,20,60));
$pdf->SetXY($valX, $valY + 5);

	////////
	$pdf->Cell(70);
	$pdf->Cell(40	,5,'FEE ARREARS',1,0,'C');
	$pdf->Cell(40	,5,'NEXT TERM',1,0,'C');
	$pdf->Cell(40	,5,'TOTAL',1,1,'C');
	$pdf->Cell(70);
	$pdf->Cell(40	,20,'KES '.number_format($b,2),1,0,'C');
	$pdf->Cell(40	,20,'KES '.number_format($tr,2),1,0,'C');
	$pdf->Cell(40	,20,'KES '.number_format($b+$tr,2),1,1,'C');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','BU',10);
	$pdf->Write(5,'CLASS TEACHER`S REMARKS');
	// Line break
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'                                                                 ');
	$pdf->SetFont('Arial','BU',10);
	$pdf->Write(5,'PRINCIPAL`S REMARKS');
	$pdf->SetFont('Arial','U',7);
	
	
	$remark2="";
	$strQ="SELECT t from remarks where grade='$grade'";
	$data=mysqli_query($con,$strQ);
		while($rdata=mysqli_fetch_assoc($data)){
			$remark2=$rdata['t'];
			
		}
	$pdf->Ln(5);
$pdf->SetFont('Arial','BU',9);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'ACADEMIC');
	$pdf->SetFont('Arial','',7);
	$remark2="";
	$strQ="SELECT t from remarks where grade='$grade'";
	$data=mysqli_query($con,$strQ);
		while($rdata=mysqli_fetch_assoc($data)){
			$remark2=$rdata['t'];
			
		}
	$pdf->Write(5,$remark2.'   ');$pdf->MultiCell(70	,5,$remark2,0,0,'L',true);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'ACTIVITIES');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'_______________________________________');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'CONDUCT');
	$pdf->Write(5,'_______________________________________');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'NAME');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'         ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'SIGN');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'              ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'DATE');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'    '.date("d/m/Y").'    ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'                                       ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'NAME');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'         ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'SIGN');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,'              ');
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'DATE');
	$pdf->SetFont('Arial','U',10);
	$pdf->Write(5,''.date("d/m/Y").'');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20	,5,'SCORE',1,0);
	$CO=0;
	$CO2=0;
	$qsc1I="SELECT count(*) AS S FROM gradingscale ORDER BY MIN desc";
			$ini="";
		$scI=mysqli_query($con,$qsc1I);
		while($ssI=mysqli_fetch_assoc($scI)){
			$CO=$ssI['S'];
			
		}
	$qsc1I="SELECT CONCAT(MIN,'-',MAX) AS S FROM gradingscale ORDER BY MIN desc";
			$ini="";
		$scI=mysqli_query($con,$qsc1I);
		while($ssI=mysqli_fetch_assoc($scI)){
			$CO2+=1;
			if ($CO2==$CO){
				
				$pdf->Cell(10	,5,$ssI['S'],1,1,'C');
			}
			else{
				
				$pdf->Cell(10	,5,$ssI['S'],1,0,'C');
			}
			
		}
	$pdf->Cell(20	,5,'GRADE',1,0);
	$qsc1I="SELECT count(*) AS S FROM gradingscale ORDER BY MIN desc";
			$ini="";
		$scI=mysqli_query($con,$qsc1I);
		while($ssI=mysqli_fetch_assoc($scI)){
			$CO=$ssI['S'];
			
		}
		$CO2=0;
	$qsc1I="SELECT grade AS S FROM gradingscale ORDER BY MIN desc";
			$ini="";
		$scI=mysqli_query($con,$qsc1I);
		while($ssI=mysqli_fetch_assoc($scI)){
			$CO2+=1;
			if ($CO2==$CO){
				
				$pdf->Cell(10	,5,$ssI['S'],1,1,'C');
			}
			else{
				
				$pdf->Cell(10	,5,$ssI['S'],1,0,'C');
			}
			
		}
		$CO2=0;
	$pdf->Cell(20	,5,'POINTS',1,0);
	$qsc1I="SELECT points AS S FROM gradingscale ORDER BY MIN desc";
			$ini="";
		$scI=mysqli_query($con,$qsc1I);
		while($ssI=mysqli_fetch_assoc($scI)){
			$CO2+=1;
			if ($CO2==$CO){
				
				$pdf->Cell(10	,5,$ssI['S'],1,1,'C');
			}
			else{
				
				$pdf->Cell(10	,5,$ssI['S'],1,0,'C');
			}
			
		}
		
	// Arial italic 8
	$pdf->SetFont('Arial','I',8);
	$pdf->SetTitle(strtoupper($form.' '. $year.' REPORT FORMS'));
	$pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
 $pdf->AddPage();
 
 }if ($adm=0) {$pdf->Cell(0,10,'0 RESULTS FOR STREAM - '.$Stream,0,1,'C');
 $pdf->Cell(0,10,'GENERATE A BROADSHEET AND TRY AGAIN ',0,1,'C');}
$pdf->Output('',$form.' '. $year.' REPORT FORMS.pdf');
?>
	