<?php
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);
?>
<div class="table-responsive">
	<div class ="header" style="float:left;width:100%;">
		   <div class ="head_logo" style="float:left;width:25%;">
				<!--<img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>"  width="100px" />-->
				<!-- <img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>"  width="100px" /> -->
				<img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
		   </div>
		   <div class ="header_center" style="float:left;width:50%;">
				<div class ="school_name" style="text-align:center;"><?php echo $school_name_pre;?></div><br><br>
				<div class ="heading" style="text-align:center;">Academic Transcript - Detailed</div>
		   </div>
		  <div class ="stu_addres" style="float:left;width:25%;">
			<span><?php echo $student_address; ?></span><br>
			<span>TEL: <?php echo $student_phone; ?></span><br>
			<span>Printed : <?php echo date('d M Y');?></span>
		 </div>
    </div> <br><br><br>
	<div class ="body_center" style="border:1px solid #000;">
		   <div class ="stu_infor" style="float:left;width:100%;padding:20px">
				<div class="stu_name" style="float:left;width:30%;">NAME : <?php echo ucfirst($student_name);?></div>
				<div class="adm_num" style="float:left;width:20%;">ADM.NO : <?php echo $student_code;?></div>
				<div class="adm_date" style="float:left;width:20%;">ADM.DATE : <?php echo $student_admission;?></div>
				<div class="dob" style="float:left;width:25%;">DATE OF BIRTH : <?php echo $student_birthday;?></div>
		   </div>
		   <div class ="par_infor" style="float:left;width:100%; padding:10px; border-top:1px solid #000; border-bottom:1px solid #000;">
				<div class="guardian" style="float:left;width:35%;">GUARDIAN : <?php echo ucfirst($parent_name);?></div>
				<div class="pobox" style="float:left;width:35%;">P.0 BOX : <?php echo 5;?></div>
				<div class="tell" style="float:left;width:30%;">TEL : <?php echo $student_phone;?></div>
			</div>
			<div class ="gen_infor" style="float:left;width:100%; padding:20px">
				<div class="prisch" style="float:left;width:35%;">PRI.SCH : <?php echo 1;?></div>
				<div class="indexno" style="float:left;width:35%;">K.C.P.E INDEX NO : <?php 2;?></div>
				<div class="year" style="float:left;width:30%;">YEAR : <?php echo 3;?></div>
				<div class="results" style="float:left;width:30%; padding-top:15px">K.C.P.E RESULTS : <?php echo 4;?></div>
				
				<div class ="mark_infor" style="float:left;width:80%; margin:0 auto;"> <br> <br> <br>
					<div class="total" style="float:left;width:20%;">TOTAL : <?php echo 7;?></div>
					<div class="points" style="float:left;width:20%;">POINTS : <?php echo 8;?></div>
					<div class="avg" style="float:left;width:20%;">AVG : <?php echo 9;?></div>
					<div class="meangrade" style="float:left;width:20%;">MG : <?php echo 10;?></div>
				</div>
			</div>
   </div>
   
   <br>
   
	<?php			    
		foreach($report as $v){
			
			$sid = $v['student_id'];
			$exam_name = $this->db->get_where('exam' , array('exam_id' => $v['exam_id']))->row()->name;
			$subject_name = $this->db->get_where('subject' , array('subject_id' => $v['subject_id']))->row()->name;
			$exams[$v['exam_id']] = $exam_name ;			
			$subjects[$v['subject_id']] = $subject_name ;
			$mark_results[$v['subject_id']][$v['exam_id']] = $v['mark_obtained'];
		}
		
		$subjectsCnt =  count($subjects);
		$examsCnt = count($exams);
		$gradeMarks = array();
		if($subjectsCnt > 0){
			ksort($subjects);
			foreach($subjects as $k => $sub){
				foreach($exams as $e => $exam){ 
					$mark_obtained = $mark_results[$k][$e]; 
					$mark_obtained = ($mark_obtained >0)?$mark_obtained:0;
					$overallmark_obtained += $mark_obtained;
					$gradeMarks[$e][] = $mark_obtained ;
				}
			}
			
			$gradeMarks = krsort($gradeMarks);
			
			$grade = $overallmark_obtained/$subjectsCnt;
			
			$grade_score = grade_score($grade);
			 
		}
		
		function grade_score($grade){
			
			if($grade <=29 && $grade >=0) $grade_score = 'E'; 
			elseif($grade <=49 && $grade >=30) $grade_score = 'D'; 
			elseif($grade <=69 && $grade >=50) $grade_score = 'C'; 
			elseif($grade <=89 && $grade >=70) $grade_score = 'B'; 
			elseif($grade <=100 && $grade >=90 ) $grade_score = 'A';
			
			return $grade_score;
			
		}		 
		
		function find_pos($arr,$sid,$sub){
									 
			foreach($arr as $k => $v){
				$score = array_sum($v[$sub]);
				$subscore[$k] = $score; 
				$i++;
			}
			arsort($subscore);		
					
			$i=1;			
			foreach($subscore as $k => $v){
				
				if($sid == $k) return $i;
				$i++;				
			}
			return '';
		}

		$result = $gard_mark_results = array();
		 
		foreach($students as $sk => $v){
			
			$student_id = $v['student_id'];
			
			$exam_name = $this->db->get_where('exam' , array('exam_id' => $v['exam_id']))->row()->name;
			$subject_name = $this->db->get_where('subject' , array('subject_id' => $v['subject_id']))->row()->name;
			$exams[$v['exam_id']] = $exam_name;			
			$subjects[$v['subject_id']] = $subject_name;
			$grade_mark_results[$student_id][$v['subject_id']][$v['exam_id']] = $v['mark_obtained'];
			$studentIds[$student_id] = $student_id;
		}
		//print_r($grade_mark_results); die;
		$subjectsCnt =  count($subjects);
		$examsCnt = count($exams);
		$examgradeMarks = array();
		$subjectgradeMarks = array();
		if($subjectsCnt > 0){
			
			ksort($subjects);
			foreach($subjects as $k => $sub){
				
				$total=0;
				$marks =array();
				
				foreach($exams as $e => $exam){

					foreach($studentIds as $sk => $v){
						$student_id = $v;				
						$mark_obtained = $grade_mark_results[$student_id][$k][$e]; 
						$mark_obtained = ($mark_obtained >0)?$mark_obtained:0;
						$examgradeMarks[$student_id][$exam][] = $mark_obtained ;
						$marks[$student_id] = $mark_obtained;
						
						$subjectgradeMarks[$student_id][$sub][] = $marks[$student_id];
					}							
				}					
				
			}			
			$result['studentexammarks'] = $examgradeMarks;
			$result['studentsubjectmarks'] = $subjectgradeMarks;				
		}		 
	
		
?> 
	  
	<!--<div style="float:left;width:50%;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="0" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health" width="100%"  border="1" cellpadding="0" cellspacing="0" width="" style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Overall Performance</td> <td width="180"><?php //echo $overall_performance;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="100%" align="left" class="left_side">Last Exam</td> <td width="50%"><?php //echo $exam_date;?></td>
			   </tr>
			   <tr  width="100%">
			   <td></td>
			       <td width="50%" align="" style="color:red">Grade: <?php //echo $grade_score;?></td>
			   </tr>
			</table>
		</td>				                				                
		</tr>
	 </table>
	 </div>-->
	 
	   <!--<div style="float:left;width:100%;border-top:1px solid #14a79d;height:10px;"></div>-->
	   
	  
	  
	  <div style="float:left;width:100%;clear:both;"></div>
	 
	
	   <div style="float:left;width:100%;">
	    <!--<table>
		<tr width="100%">
			 <td width="100%" align="left" class="left_side"><strong>RESULTS</strong></td>	  
		</tr>
		</table> -->	   
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="4">	

	 <tr width="100%">
		<td width="100%">
		    <table class="known_all eduction_tbl bottomBorder" width="100%" border="0" cellspacing="0" cellpadding="0" >
			   
			 <!--  <tr  width="100%" scope="col">
			     				  
				<th width="100%" align="left">Subject</th>
				
				<?php			    
					foreach($exams as $e => $exam){						 
				?>   
					<th width="100%" align="left" class="back_tsore"><?php //echo $exam;?></th>
				<?php } ?> 
				<th width="100%" align="left" class="back_detials_info">Total</th>
				<th width="100%" align="left" class="back_detials_info">Grade</th>
				
				<th width="100%" align="left">Position</th>
				<!--th width="100%" align="left">Remarks</th-->
				<!--<th width="100%" align="left">Teacher</th>
				  				  
			   </tr> -->
			   
			   <?php		
				
				if($subjectsCnt > 0){
						
				?>
			   	     
				<?php  
					ksort($subjects);
					
					$overall_total=0;
					
					foreach($subjects as $k => $sub){
						
					?>
						
					<tr  width="100%">		
					
					<?php  		 
					
						$total=0;	
						
						$teacher_name = $this->db->get_where('teacher' , array('teacher_id' => $this->db->get_where('subject' , array('subject_id' => $k))->row()->teacher_id))->row()->name;
		
						if($teacher_name == '')
							$teacher_name = $this->db->get_where('principal' , array('principal_id' => $this->db->get_where('subject' , array('subject_id' => $k))->row()->principal_id))->row()->name;
					?> 
						<!--<td width="100%" align="left" class=""><?php //echo $sub;?></td>-->
						<?php 
						foreach($exams as $e => $exam){ 
							$mark_obtained = $mark_results[$k][$e]; 
							$mark_obtained = ($mark_obtained >0)?$mark_obtained:0;
							$examMarks[$exam][] = $mark_obtained ;
							$total+= $mark_obtained;							
					?>
					<?php
						} 
						$grade = $total / $examsCnt;
						$grade_score = grade_score($grade);
						
						$pos = find_pos($result['studentsubjectmarks'],$sid,$sub);
						$position = $pos.'/'.$studentCnt;
						$remarks = 'WORK HARDER';										
					?>				  

				   </tr>
				   <?php
						$overall_total+=$total;
						$overall_position=$position;
						$outof_total= ($subjectsCnt*$examsCnt)*100;
						$outof_position = $studentCnt;
					}
						
					?>    
			   
			      <!-- <tr  width="100%">
					<?php for($i =1; $i<=$examsCnt; $i++){ ?> 
						<td width="100%" align="left" class=""></td> 
					<?php }?>				  
				  <td width="100%" align="center" class=""><strong>Total</strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><strong><?php //echo $overall_total;?></strong></td> 
				  <td width="100%" align="left" class="back_detials_info"></td> 
				  <td width="100%" align="center" class=""><strong><?php //echo $overall_position;?></strong></td> 
				  <td width="100%" align="left" class=""></td> 
				  <td width="100%" align="left" class=""></td> 
				 
				  </tr>-->
			   
			     <!-- <tr  width="100%">
					<?php for($i =1; $i<=$examsCnt; $i++){ ?> 
						<td width="100%" align="left" class=""></td> 
					<?php }?>
			     
				  <td width="100%" align="center" class=""><strong>Out of</strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><strong><?php //echo $outof_total;?></strong></td> 
				  <td width="100%" align="left" class="back_detials_info"></td> 
				  <td width="100%" align="center" class=""><?php //echo $outof_position;?></td> 
				  <td width="100%" align="left" class=""></td> 
				  <td width="100%" align="left" class=""></td> 
				 
					</tr>-->
				<?php }?>	
					
				</table>
			</td>				                				                
			</tr>
		
	 </table>
	 
	 
	  </div>
	  
	<?php		
    
	if($subjectsCnt > 0){
						
	?>  
	  
	  <div style="float:left;width:100%;">
	  
		<table class="bottomBorder" width="100%">
			<tr>
				<th width="20%" style="font-size:38px;text-align:center;border:1px solid #000;">YEAR</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">CLASS</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">EXAM</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">TERM</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">POSITION</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">AVG</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">MG</th>
				<th width="10%" style="font-size:38px;text-align:center;border:1px solid #000;">TOTAL</th>
				<?php 
				$class_id = $stu_class_id;
					$section_id = $stu_section_id;
					$running_year =  $stu_year;
					$subjects = $this->db->get_where('subject' , array('class_id' => $class_id ,'section_id' => $section_id , 'year' => $running_year))->result_array();
					foreach($subjects as $row):
				?>
				<th width="10%" style="border:1px solid #000;font-size:38px;text-align:center;"><?php echo $row['name'];?><br><?php echo $row['subject_id'];?></th>
				<?php endforeach;?>				
				
			</tr>

			<?php 
			$examMarksCnt = count($examMarks);
			foreach($examMarks as $exam => $mark){ 
				$examMark = array_sum($mark);	
				$chart[$exam] = $examMark;
				$grade = $examMark;
				$avg = $examMark/$subjectsCnt;
				$grade_score = grade_score($avg);
				$pos = find_pos($result['studentexammarks'],$sid,$exam);
			?>
			<tr>
			<td width="20%" style="font-size:34px;border:1px solid #000;"><?php echo $stu_year;?></td>
			<td width="10%" style="font-size:34px;border:1px solid #000;"><?php echo $class_name ?></td>
			<td width="10%" style="font-size:34px;border:1px solid #000;"><?php echo $exam_name;?></td>
			<td width="10%" style="font-size:34px;border:1px solid #000;"><?php echo $exam;?></td>
			<td width="10%" style="font-size:34px;border:1px solid #000;" class="back_tsore"><?php echo $pos.'/' .$outof_position;?></td>	
			<td width="10%" style="font-size:34px;border:1px solid #000;" class="back_tsore"><?php echo round($examMark/$subjectsCnt,2);?></td>
			<td width="10%" style="font-size:34px;border:1px solid #000;" class="back_tsore"><?php echo $grade_score;?></td>
			<td width="10%" style="font-size:34px;border:1px solid #000;" class="back_tsore"><?php echo $examMark.'of'.($subjectsCnt*100);?></td>				
			<?php
					$total_marks = 0;
					$total_grade_point = 0; 
					$class_id = $stu_class_id;
					$exam_id = $stu_examid;
					$section_id = $stu_section_id;
					$running_year =  $stu_year;
					$subjects = $this->db->get_where('subject' , array('class_id' => $class_id ,'section_id' => $section_id , 'year' => $running_year))->result_array();					
					foreach($subjects as $row2):
			 ?>
					<td width="10px" style="border:1px solid #000; font-size:34px;">
						<?php 
							$obtained_mark_query = 	$this->db->get_where('mark' , array(
													'class_id' => $class_id , 
														'exam_id' => $exam_id , 
															'subject_id' => $row2['subject_id'] , 
																'student_id' => $stu_student_id,
																	'year' => $running_year
												));
							if ($obtained_mark_query->num_rows() > 0) {
								$obtained_marks = $obtained_mark_query->row()->mark_obtained;
								//echo $obtained_marks;
								if ($obtained_marks >= 0 && $obtained_marks != '') {
									$grade = $this->crud_model->get_grade($obtained_marks);
									$total_grade_point += $grade['grade_point'];
								}
								$total_marks += $obtained_marks;
								
								echo $obtained_marks.'=';
								echo $grade_score;
								
							}
							

						?>
					</td>
				<?php endforeach;?>			
			</tr>
			<?php }?>
		</table>
	  </div>
	  
	

	<?php } ?>  
	  
	</div>
	<br>
	<div class ="footer_content" width="100%" style="float:left;">
		<div width="20%" style="float:left;">
			<span> Time Spent : 1 Year</span>
		</div>
		<div width="80%" style="float:right;">
			
			<table width="80%" class="table table-hover tablesorter" cellspacing="1" cellpadding="0" style="border-top:1px solid#14a79d; float:right;">	
				<tr>
					<td colspan ="13"> *** MEAN  GRADE SUMMERY *** </td>
				</tr><br>
				
				<tr>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">A</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">A-</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">B+</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">B</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">B-</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">C+</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">C</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">C-</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">D+</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">D</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">D-</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">E</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">Z</td>
				</tr>
				
				<tr>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">1</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">1</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">1</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">0</td>
					<td style="font-size:18px;text-align:center;border:1px solid #000;">A</td>
				</tr>			
			</table>
			<table width="80%" class="table table-hover tablesorter" cellspacing="1" cellpadding="0" style="border-top:1px solid#14a79d;">	
				<tr>
					<td>---Missing Score</td>
					<td>= ---Subject Not Taken</td>
					<td>Y --- Irregularity</td>
				</tr><br>
				
				<tr>
					<td>Z --- Not Graded</td>
					<td>" --- Subject Not Include In Totals</td>
				</tr>
			</table>
		
		</div>
	</div>
	

 <!--<footer style="float:left;clear:both;position:absolute;bottom:20px;">
 
 
 <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="0" style="border-top:1px solid#14a79d;">	

	  <tr width="100%">
      
		<td width="40%"><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>				                				                
		<td align="center" width="50%"><span>Genrated <span>Genrated <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
</footer>-->
