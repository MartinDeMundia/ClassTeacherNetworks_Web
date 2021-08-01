<?php

$subject=$subject1;
$class=$form1;
$school_id=$this->session->userdata('school_id');
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

<div class="table-responsive">
		<span width="100%" height="100%"></span>
						  <table class="table table-bordered dataTables-example" style="font-size:12px; color:; border-collapse=collapse" id="mr">
						  <thead>
						  <tr>
							  <?php 
							  $name=$this->db->get_where("school", array('school_id'=>$this->session->userdata('school_id')))->row()->school_name;
							  $address=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->address;
							  $telephone=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->phone;
							  $location=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->county;
							  $subjectname =$this->db->get_where("subject", array('subject_id'=>$subject))->row()->name;
							  $school_image = $this->crud_model->get_image_url('school',$school_id);
							  ?>
							   <th colspan="10" > 
							   <center>
							  <!--  <img src="<?php echo base_url();?>uploads/logo.png" width=70 height=70> -->
							   <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
							   <br>
							   <?php echo $name; ?>
							   <br>
							   <?php echo $address; ?>
							   <br>
							   <?php echo $location; ?>
							   <br>
							   <?php echo $telephone; ?>
							   </center>
							   </th>
							  </tr>
						  <tr>
						    <th>#</th>
							<th>ST</th> 
							<th>ADM</th>   
							<th>NAME </th>
					<!-- 		<th>RANK </th> -->
							<th>POSITION </th>
							<th>SCORE</th>
						<!-- 	<th>%</th> -->
							<th>GRADE</th>
						  </tr></thead>
						  <tbody>
						     <?php
									/*$qry = '
									SELECT * 
									FROM enroll e 
									JOIN student s ON s.student_id = e.student_id  
									LEFT JOIN student_marks sm ON sm.studentid = s.student_id AND sm.term = "'.$term.'"  AND LOWER(sm.examtype) = "'.$en.'" 
									WHERE 
									school_id =  "'.$this->session->userdata('school_id').'"
									';  */

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
										AND epf.subject = '".$subjectname."' AND term='".$term."'
										LEFT JOIN exam_processing_marks epm ON epm.id = epf.parent_id 

										WHERE s.school_id = '".$this->session->userdata('school_id')."'
						            ";

									$qry =  $qry." ".$qryfilter; 

									$qry .= ' GROUP BY s.student_id ORDER BY rank ASC ';								

									$students   = $this->db->query($qry)->result_array();

									$rnk = 1 ; //temp
									foreach($students as $rowStud){
										echo '<tr>';
			                              echo '<td>'.(int)$rowStud['rank'].'</td>';	
			                              echo '<td>'.$sreamname.'</td>';						
										  echo '<td>'.$rowStud['student_code'].'</td>';
										  echo '<td style="width:70%;">'.$rowStud['name'].'</td>';
			                              echo '<td>'.(int)$rowStud['rank'].'</td>';										  
										/*  echo '<td>0</td>';*/
			                              echo '<td>'.(int)$rowStud['marks'].'</td>';										 		
									      echo '<td>'.$rowStud['grade'].'</td>';
									      echo '</tr>';
									      $rnk++;	

								      }
								?>
								  
									</tbody>
									</table>
									</div>
									</div>
	