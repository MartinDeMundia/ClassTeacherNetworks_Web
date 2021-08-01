
<?php
error_reporting(0);
$class_id = $form;
$section_id = $stream;
$exam_id = $exam_name  = $exam  ;
$running_year = $this->db->get_where('settings' , array('type' => 'running_year' ))->row()->description;




$subject=$subject1;
$class = $class_id=$form;
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);
$stream=$section_id=strtolower($stream);
$year=$year;
$examdate=$year;
$en=$exam;
$term=$term;      
$exm=strtolower(str_replace("-","",str_replace(" ","",$exam)));


$classname = $qryfilter = $qrySubjfilter = $sreamname = "";
if($class > 0 ) {
$qryfilter .= ' AND e.class_id =  "'.$class .'" ';
$qrySubjfilter .= ' AND class_id =  "'.$class .'" ';
$classname = $this->db->get_where('class' , array('class_id' =>$class))->row()->name;

}
if($stream > 0 ){
$qryfilter .= ' AND e.section_id =  "'.$stream .'" ';
$qrySubjfilter .= ' AND section_id =  "'.$stream .'" ';
$sreamname = $this->db->get_where('section' , array('section_id' =>$stream))->row()->name;
}

$examname = $this->db->get_where('exams' , array('ID' =>$exam_id))->row()->Term1; 
?>

<br>

<script src="http://apps.classteacher.school/assets/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="http://apps.classteacher.school/assets/js/select2/select2-bootstrap.css">
<script src="http://apps.classteacher.school/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="http://apps.classteacher.school/assets/js/bootstrap.js"></script>
<style type="text/css">
    td {
        padding: 5px;
    }
</style>
<!-- <center>
    <img style="width:10px;height:10px;" src="<?php echo base_url(); ?>uploads/logo.png" style="max-height :10px;"><br>
</center> -->

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
		    <!-- <img width="90" height="40" style="width:10px;height:10px;" src="<?php echo base_url(); ?>uploads/logo.png" style="max-height :10px;"> -->
		    <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
			<h3 style="color: #696969;">
				<?php					
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$subject_name = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;
					//echo get_phrase('score_sheet_for');
					print('SUBJECT ANALYSIS REPORT');
				?>
			</h3>			
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> : <?php echo $class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('section');?> : <?php echo $section_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('Exam'); ?>: <?php echo $examname;?> 
			</h4>			
		</div>
	</div>
	<div class="col-md-4"></div>
</div>

<hr />
<div class="row">
	<div class="col-md-12">

<style>
/*table{
    width: 100%;
    border-collapse:collapse;
}

td{
    width: 2%;
    text-align: left;
    border: 1px solid black;
}
table{
    width: 100%;
    table-layout: fixed;
}*/
table, th, td {
  border: 0.1px solid black;
  padding-top:5px;
  padding-bottom:5px;
}
</style>


			<table class="table" style="width:100%" width="100%">
				<thead>
					<tr>
					<?php
					$total_points=0;
					$total_num=0;
					?>
						<th style="width:8%;background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo strtoupper(get_phrase('subject'));?></th>
						<th style="background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo get_phrase('code');?></th>
						<?php
						//$this->db->order_by("Points","desc");
						//$grades=$this->db->get("gradingscale")->result_array();
						
						$this->db->order_by("GRADE","ASC");				
						$grades=$this->db->get_where("gradingscale",array("school_id"=>$this->session->userdata('school_id')))->result_array();
						foreach ($grades as $row):
						
						?>
							<th style="width:3%;background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo $row['Grade'];?></th>
						<?php
						endforeach;
						?>
						<th style="background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo get_phrase('entry');?></th>
						<th style="background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo get_phrase('mean');?></th>
						<th style="background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo get_phrase('grade');?></th>
						<th style="background-color:grey;color:white;font-weight:900;padding:10px;"><?php echo get_phrase('pos');?></th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
					$mark_array ='';

					$examname = $this->db->get_where('exams' , array('ID' => $exam_id) )->row()->Term1;

			        $user_id = $this->session->userdata('login_user_id');
			        $role = $this->session->userdata('login_type');


				   $subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'section_id' => $section_id , 'subject_id' => $subject_id, 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
				   print_r($this->db->last_query());


						$qrySubjR = "SELECT sum(epf.mark) Mark,subject
						FROM exam_processing_final epf WHERE 
						 term ='".urldecode($term)."' AND exam = '".$examname."' AND class_id='".$class_id."' AND section_id = '".$section_id."' AND school_id='".$this->session->userdata('school_id')."'
						GROUP BY subject ORDER BY  sum(epf.mark)  DESC ";

						

			            $querySubjR = $this->db->query($qrySubjR)->result_array(); 
			            $arraySubjRankings = array();
			            $cnt=1;
			            foreach($querySubjR as $rowSubjR){			            
			                $arraySubjRankings[$cnt] = $rowSubjR['subject'];
			                $cnt++;			              
			            }
						
					foreach($subjects as $row):
						$total_points=0;
					   $total_num=0;
						?>
						<tr>
						<td style="width:8%;background-color: gray;color: white;" ><?php echo $row['name'];?></td>
						<td><?php echo $row['subject_id'];?></td>


						<?php $year = 0;?>
						<?php $year1 = date("Y", strtotime("-1 year"));?>
						<?php $year2 = $year1+1;?>
						<?php
						//$this->db->order_by("Points","desc");
						//$grades=$this->db->get("gradingscale")->result_array();	
						$this->db->order_by("GRADE","ASC");				
						$grades=$this->db->get_where("gradingscale",array("school_id"=>$this->session->userdata('school_id')))->result_array();						
						$entry = count($num = $this->db->get_where("exam_processing_final",array("class_id"=>$class_id,"section_id"=>$section_id,"term"=>urldecode($term),"subject"=>$row['name'],"exam"=>$examname,"school_id"=>$this->session->userdata('school_id')))->result_array());
						foreach ($grades as $row1):
						
						$num = $this->db->get_where("cat1",array("Code"=>$row['Code'],"Grade"=>$row1['Grade'],"form"=>'GRADE 1',"school_id"=>$this->session->userdata('school_id')))->result_array();
						$count= count($num);
						$total_num+=$count;
						$total_points+=($count* $row1['Points']);
						?>
						<?php					

			            $qryGradecount = "            
								SELECT
								 sum(epf.mark) Mark,epf.rank , 
								( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id ) grade,
								count(( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id )) gradecount
								FROM exam_processing_final epf
								WHERE subject='".$row['name']."'
								AND term ='".urldecode($term)."' 
								AND exam = '".$examname."' 
								AND ( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id ) = '".$row1['Grade']."' 
			            ";
			           
			            $queryGrdCount = $this->db->query($qryGradecount);
			            $rowGCount =   $queryGrdCount->row(); 
			            $gradecount = $rowGCount->gradecount; 			        
						?>
						<td style="width:3%;"><?php echo $gradecount ;?></td>
						<?php
						endforeach;
						?>
						<td><?php echo $entry;?></td>
						<?php
			            $qryGradeMean = "            
								SELECT
								 sum(epf.mark) Mark,epf.rank , 
								( SELECT name FROM grade g WHERE sum(epf.mark)/".$entry." >= g.mark_from AND sum(epf.mark)/".$entry." <= g.mark_upto AND g.school_id = epf.school_id ) grade					
								FROM exam_processing_final epf
								WHERE subject='".$row['name']."'
								AND term ='".urldecode($term)."' 
								AND exam = '".$examname."' 
								AND class_id='".$class_id."' AND section_id = '".$section_id."' 
			            ";
			            $queryGrdMean= $this->db->query($qryGradeMean);
			            $rowGMean =   $queryGrdMean->row(); 			   
			            $totalattained = $rowGMean->Mark;
			            $gradeattacinedsubj = $rowGMean->grade;
						?>
						<td><?php if($entry>0) {echo (int)round($totalattained/$entry,2);}else{ echo 0;}?></td>
                        <td><?php if($entry>0) {echo $gradeattacinedsubj;}?></td>

						<td><?php
						 if(array_search($row['name'], $arraySubjRankings)){
						 	 $arrSear = array_search($row['name'], $arraySubjRankings); 
                             echo  $arrSear;
						 }else{
						 	echo "0";
						 }

						 ?></td>
					</tr>
					<?php endforeach;?>						
						
				</tbody>
			</table>








	</div>
</div>
<?php
//echo $content ; exit();
	$content = ob_get_contents();
	$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('SUBJECT ANALYSIS REPORT');  
    $pdf->SetHeaderData('SUBJECT ANALYSIS REPORT', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(5, '5', 5);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 7);  
    $pdf->AddPage();
    ob_end_clean();
    $pdf->writeHTML($content);
    ob_clean();
    $filename = "ClassTeacher-SubjAnalysisReport.pdf";
    $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/reports/".$filename;	
    $pdf->Output($file, 'F');
    $externallink = "http://apps.classteacher.school/assets/reports/".$filename;
    echo json_encode(array("pdfpath"=>$externallink));	  
			
	