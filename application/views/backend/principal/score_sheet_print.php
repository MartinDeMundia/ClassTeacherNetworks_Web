
<?php
error_reporting(0);
$class_id = $form1;
$section_id = $stream1;
$exam_id = $exam_name  = $exam1  ;
$subject_id = $subject1;
$running_year = $this->db->get_where('settings' , array('type' => 'running_year' ))->row()->description;




$subject=$subject1;
$class=$form1;
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);
$stream=strtolower($stream1);
$year=$year1;
$examdate=$year1;
$en=$exam1;
$term=$term1;      
$exm=strtolower(str_replace("-","",str_replace(" ","",$exam1)));


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


?>
<?php if ($class_id != '' && $section_id != '' && $exam_id != '' && $subject_id != ''):?>
<br>

<script src="assets/js/jquery-1.11.0.min.js"></script>
<style type="text/css">
    td {
        padding: 5px;
    }

table, th, td {
  border: 0.1px solid black;
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
		  <!--   <img width="80" height="40" style="width:10px;height:10px;" src="<?php echo base_url(); ?>uploads/logo.png" style="max-height :10px;"> -->
		   <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
			<h3 style="color: #696969;">
				<?php
					$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                    foreach($classes as $row4):			
					endforeach;		
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$subject_name = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;					
					print('SCORE SHEET PER SUBJECT DETAILS');
				?>
			</h3>			
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> : <?php echo $class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('section');?> : <?php echo $section_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('Exam'); ?>: <?php echo $exam_name;?> 
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('Subject_name'); ?>: <?php echo $subject_name;?> 
			</h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>

<hr />
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" style="">
			<thead>
				<!-- <tr style="text-align: left;background-color:grey;color:white;font-weight:900;padding:10px;">
				<td style="text-align: left;background:grey;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subject');?> <i class="entypo-right-thin"></i>
				</td>				
					<td style="text-align: center;"><?php echo $subject_name;?></td>							
				</tr> -->			
			  <tr style="text-align: left;background-color:grey;color:white;font-weight:900;padding:10px;">
			    <th>#</th>
				<th>ST</th> 
				<th>ADM</th>   
				<th>NAME </th>				
				<th>POSITION </th>
				<th>SCORE</th>					
				<th>GRADE</th>
			  </tr>

			</thead>
			<tbody>
			<?php
			$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                    foreach($classes as $row23):					
					endforeach;



				$qry = "
					SELECT
					now() as generateddate, epm.current_exam_mark marks, 
					s.student_id,s.name,s.sex,s.date_of_admission,sch.school_id,sch.school_name, sch.logo,s.student_code,
					sch.website,sch.email,sch.address,sch.telephone,now() as tdate, e.class_id,c.name classname, 
					epf.subject,mark,(
					SELECT name FROM grade g WHERE mark >= g.mark_from AND mark <=  g.mark_upto AND g.school_id = sch.school_id
					) grade,
					(
					SELECT comment FROM grade g WHERE mark >= g.mark_from AND mark <=  g.mark_upto AND g.school_id = sch.school_id
					) gradecomment,
					rank
					FROM student s 
					JOIN school sch ON sch.school_id = s.school_id 
					JOIN enroll e ON e.student_id = s.student_id 
					JOIN class c ON c. class_id = e.class_id 
					LEFT JOIN exam_processing_final epf ON epf.student_id = s.student_id  AND LOWER(epf.exam) = '".strtolower( $en ) ."' and epf.year='".$year."'
					AND epf.subject = '".$subject_name."' AND term='".$term."'
					LEFT JOIN exam_processing_marks epm ON epm.id = epf.parent_id 

					WHERE s.school_id = '".$this->session->userdata('school_id')."'
	            ";

				$qry =  $qry." ".$qryfilter; 

				$qry .= ' GROUP BY s.student_id ORDER BY rank ASC ';

											

				$students   = $this->db->query($qry)->result_array();

					foreach($students as $rowStud){
?>

  <tr style="border: 10px solid red">
<?php

						//  echo '<tr  style="border:1px solid red; width:100%; border-collapse:collapse;" >';
                          echo '<td>'.(int)$rowStud['rank'].'</td>';	
                          echo '<td>'.$sreamname.'</td>';						
						  echo '<td>'.$rowStud['student_code'].'</td>';
						  echo '<td>'.$rowStud['name'].'</td>';
                          echo '<td>'.(int)$rowStud['rank'].'</td>';
                          echo '<td>'.(int)$rowStud['marks'].'</td>';										 		
					      echo '<td>'.$rowStud['grade'].'</td>';					    
					      echo '</tr>';
					    //  echo '<hr style="">';
					     $rnk++;
				      }

				?>
			</tbody>
		</table>	
	</div>
</div>
<?php endif;?>



<?php

	$content = ob_get_contents();
	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('SCORE SHEET PER SUBJECT DETAILS ');  
    $pdf->SetHeaderData('SCORE SHEET PER SUBJECT DETAILS', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
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
    $pdf->writeHTML($content); //echo $content ; exit();
    ob_clean();
    $filename = "ClassTeacher-Report.pdf";
    $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/reports/".$filename;	
    $pdf->Output($file, 'F'); 
    $externallink = base_url()."assets/reports/".$filename;
    echo json_encode(array("pdfpath"=>$externallink));	  
			
	