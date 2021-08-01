<?php
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);
?>
<div class="table-responsive">
	<div class ="header" style="float:left;width:100%;">
		   <div class ="head_logo" style="float:left;width:25%;">
				<!--<img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>"  width="100px" />-->
				<img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
		   </div>
		   <div class ="header_center" style="float:left;width:50%;">
				<div class ="school_name" style="text-align:center;"><?php echo $school_name_pre;?></div><br><br>
				<div class ="heading" style="text-align:center;">Academic Transcript - Summary</div>
		   </div>
		  <div class ="stu_addres" style="float:left;width:25%;">
			<span><?php echo $student_address; ?></span><br>
			<span>TEL: <?php echo $student_phone; ?></span><br>
			<span>Printed : <?php echo date('d M Y');?></span>
		 </div>
    </div> <br><br><br>
   
   <div class ="stu_infor" style="float:left;width:100%;">
		<div class="stu_name" style="float:left;width:45%;">NAME : <?php echo ucfirst($student_name);?></div>
		<div class="adm_num" style="float:left;width:45%;">ADM.NO : <?php echo $student_code;?></div>
   </div><br>
   
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
						<!--<td width="100%" align="center" class="back_tsore"><?php //echo $mark_obtained;?></td> -->
					<?php
						} 
						$grade = $total / $examsCnt;
						$grade_score = grade_score($grade);
						
						$pos = find_pos($result['studentsubjectmarks'],$sid,$sub);
						$position = $pos.'/'.$studentCnt;
						$remarks = 'WORK HARDER';										
					?>				  
					 <!-- <td width="100%" align="center" class="back_detials_info"><?php //echo $total;?></td> 
					  <td width="100%" align="center" class="back_detials_info"><?php //echo $grade_score;?></td> 
					  <td width="100%" align="center" class=""><?php //echo $position;?></td> -->
					  <!--td width="100%" align="center" class=""><?php //echo $remarks;?></td--> 
					  <!--<td width="100%" align="center" class=""><?php //echo $teacher_name;?></td> -->
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
				  <td width="100%" align="center" class="back_detials_info"><strong><?php echo $outof_total;?></strong></td> 
				  <td width="100%" align="left" class="back_detials_info"></td> 
				  <td width="100%" align="center" class=""><?php echo $outof_position;?></td> 
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
				<th style="border:1px solid #000;">Year</th>
				<th style="border:1px solid #000;">Class</th>
				<th style="border:1px solid #000;">Exam</th>
				<?php 
				$examMarksCnt = count($examMarks);
				foreach($examMarks as $exam => $mark){ 	?><?php } ?>
				<th style="border:1px solid #000;text-align:center;" colspan="4" >Term1<?php //echo $exam;?></th>
				
			</tr>
			<tr>
				<td style="border:1px solid #000;" width="10%"><?php echo $stu_year;?></td>
				<td style="border:1px solid #000;" width="10%"><?php echo $class_name;?></td>
				<td style="border:1px solid #000;" width="10%"><?php echo $exam_name;?></td>
				<td style="border:1px solid #000;">AVG</td>
				<td style="border:1px solid #000;">GRD</td>
				<td style="border:1px solid #000;">SCORE</td>
				<td style="border:1px solid #000;">POSITION</td>	
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
			<td style="border:1px solid #000;"></td>
			<td style="border:1px solid #000;"></td>
			<td style="border:1px solid #000;"></td>
			<!--<td><?php echo $exam;?></td>-->
			<td style="border:1px solid #000;" class="back_tsore "><?php echo number_format(($examMark/$subjectsCnt),2);?></td>
			<td style="border:1px solid #000;" class="back_tsore"><?php echo $grade_score;?></td>
			<td style="border:1px solid #000;" class="back_tsore"><?php echo $examMark  . 'of'.  ($subjectsCnt*100);?></td>
			<td style="border:1px solid #000;" class="back_tsore"><?php echo $pos;?></td>					
			</tr>
			<?php }?>
		   
		</table>
	  </div>
	

	<?php } ?>  
	  
	</div>

 <!--<footer style="float:left;clear:both;position:absolute;bottom:20px;">
 
 
 <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="0" style="border-top:1px solid#14a79d;">	

	  <tr width="100%">
      
		<td width="40%"><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>				                				                
		<td align="center" width="50%"><span>Genrated <span>Genrated <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
</footer>-->
