
<?php
//error_reporting(0);
$class_id = $form1;
$section_id = $stream1;
$exam_id = $exam_name  = $exam1  ;
$subject_id = $subject1;
$running_year = $this->db->get_where('settings' , array('type' => 'running_year' ))->row()->description;	
?>
<?php if ($class_id != '' && $section_id != '' && $exam_id != '' && $subject_id != ''):?>
<br>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
			<h3 style="color: #696969;">
				<?php
					$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                    foreach($classes as $row4):			
					endforeach;		
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$subject_name = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;
					echo get_phrase('score_sheet_for');
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
		<table class="table table-bordered">
			<thead>
				<tr>
				<td style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subject');?> <i class="entypo-right-thin"></i>
				</td>				
					<td style="text-align: center;"><?php echo $subject_name;?></td>							
				</tr>
			</thead>
			<tbody>
			<?php
			$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                    foreach($classes as $row23):					
					endforeach;
			$students   = $this->db->query('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.section_id = "'.$section_id .'" AND e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"')->result_array();				
				foreach($students as $row22):				
			?>
				<tr>
					<td style="text-align: center;">
						<?php echo $this->db->get_where('student' , array('student_id' => $row22['student_id']))->row()->name;?>
					</td>
				
				<?php
					$total_marks = 0;
					$total_grade_point = 0;	
					$new_exam_id = $this->db->get_where('exams' , array('Term1' => $exam_name))->row()->ID;
				?>
					<td style="text-align: center;">
						<?php 
						$obtained_marks = 0;
							$obtained_mark_query = 	$this->db->get_where('mark' , array(
													'class_id' => $class_id,
														'exam_id' => $new_exam_id , 
															'subject_id' => $subject_id , 
																'student_id' => $row22['student_id'],
																	'year' => $running_year
												));
							        $resRow = $obtained_mark_query->row();
							        if($resRow)	$obtained_marks = $resRow->mark_obtained;
									echo $obtained_marks;
						?>
					</td>				
				
				</tr>
			<?php endforeach;?>	
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
    $pdf->SetTitle('SCORE SHEET  '.strtoupper($form." ". $stream. " ".$en." ". $subject." ($term - ". $year. ")"));  
    $pdf->SetHeaderData('SCORE SHEET  '.strtoupper($form." ". $stream. " ".$en." ". $subject." ($term - ". $year. ")").date('M/d/Y'), '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
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
    //$file = "http://apps.classteacher.school/assets/reports/".$this->session->userdata('pdf');
    ob_clean();
    //$pdf->Output($file.'.pdf','F');	
    $pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'assets/reports/output.pdf', 'F');	  
			
	