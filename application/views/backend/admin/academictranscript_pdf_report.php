<div class="table-responsive">	 
    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5">	
	  <tr width="100%">
		<td width="25%" style='background-color:#073350 !important'><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100px"/></td>				                				                
		<td align="right"><img class="health_logo_1" src="<?php echo base_url('/assets/images/pdf_logo/education.png');?>" />
	  </tr>
	  </table>
	  <br>
	 <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
     
    <div style="float:left;width:50%;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="0" cellpadding="0">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health educ_tbl" width="100%"  border="1" cellpadding="0" cellspacing="0" width="" style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Name</td> <td width="180"><?php echo $student_name;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="" align="left" class="left_side">Class</td> <td width="50%"><?php echo $class_name;?></td>
			   </tr>
			   <tr  width="100%">
			      <td width="" align="left" class="left_side">class Teacher </td> <td width="50%"><?php echo $class_teacher;?></td>
			   </tr>
			  
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
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
	  
	<div style="float:left;width:50%;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="0" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health" width="100%"  border="1" cellpadding="0" cellspacing="0" width="" style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Overall Performance</td> <td width="180"><?php echo $overall_performance;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="100%" align="left" class="left_side">Last Exam</td> <td width="50%"><?php echo $exam_date;?></td>
			   </tr>
			   <tr  width="100%">
			   <td></td>
			       <td width="50%" align="" style="color:red">Grade: <?php echo $grade_score;?></td>
			   </tr>
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  <br>
	   <div style="float:left;width:100%;border-top:1px solid #14a79d;height:10px;"></div>
	   
	  
	  
	  <div style="float:left;width:100%;clear:both;"></div>
	 
	 <br>
	   <div style="float:left;width:100%;">
	    <table>
		<tr  width="100%">
			      <td width="100%" align="left" class="left_side"><strong>RESULTS</strong></td>
				  
			   </tr>
		</table>	   
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="4">	

	 <tr width="100%">
		<td width="100%">
		    <table class="known_all eduction_tbl bottomBorder" width="100%" border="0" cellspacing="0" cellpadding="0" >
			   
			   <tr  width="100%" scope="col">
			     				  
				<th width="100%" align="left">Subject</th>
				
				<?php			    
					foreach($exams as $e => $exam){						 
				?>   
					<th width="100%" align="left" class="back_tsore"><?php echo $exam;?></th>
				<?php } ?> 
				<th width="100%" align="left" class="back_detials_info">Total</th>
				<th width="100%" align="left" class="back_detials_info">Grade</th>
				
				<th width="100%" align="left">Position</th>
				<!--th width="100%" align="left">Remarks</th-->
				<th width="100%" align="left">Teacher</th>
				  				  
			   </tr>
			   
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
						<td width="100%" align="left" class=""><?php echo $sub;?></td>
						<?php 
						foreach($exams as $e => $exam){ 
							$mark_obtained = $mark_results[$k][$e]; 
							$mark_obtained = ($mark_obtained >0)?$mark_obtained:0;
							$examMarks[$exam][] = $mark_obtained ;
							$total+= $mark_obtained;							
					?>
						<td width="100%" align="center" class="back_tsore"><?php echo $mark_obtained;?></td> 
					<?php
						} 
						$grade = $total / $examsCnt;
						$grade_score = grade_score($grade);
						
						$pos = find_pos($result['studentsubjectmarks'],$sid,$sub);
						$position = $pos.'/'.$studentCnt;
						$remarks = 'WORK HARDER';										
					?>				  
					  <td width="100%" align="center" class="back_detials_info"><?php echo $total;?></td> 
					  <td width="100%" align="center" class="back_detials_info"><?php echo $grade_score;?></td> 
					  <td width="100%" align="center" class=""><?php echo $position;?></td> 
					  <!--td width="100%" align="center" class=""><?php echo $remarks;?></td--> 
					  <td width="100%" align="center" class=""><?php echo $teacher_name;?></td> 
				   </tr>
				   <?php
						$overall_total+=$total;
						$overall_position=$position;
						$outof_total= ($subjectsCnt*$examsCnt)*100;
						$outof_position = $studentCnt;
					}
						
					?>    
			   
			       <tr  width="100%">
					<?php for($i =1; $i<=$examsCnt; $i++){ ?> 
						<td width="100%" align="left" class=""></td> 
					<?php }?>				  
				  <td width="100%" align="center" class=""><strong>Total</strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><strong><?php echo $overall_total;?></strong></td> 
				  <td width="100%" align="left" class="back_detials_info"></td> 
				  <td width="100%" align="center" class=""><strong><?php echo $overall_position;?></strong></td> 
				  <td width="100%" align="left" class=""></td> 
				  <td width="100%" align="left" class=""></td> 
				 
				  </tr>
			   
			      <tr  width="100%">
					<?php for($i =1; $i<=$examsCnt; $i++){ ?> 
						<td width="100%" align="left" class=""></td> 
					<?php }?>
			     
				  <td width="100%" align="center" class=""><strong>Out of</strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><strong><?php echo $outof_total;?></strong></td> 
				  <td width="100%" align="left" class="back_detials_info"></td> 
				  <td width="100%" align="center" class=""><?php echo $outof_position;?></td> 
				  <td width="100%" align="left" class=""></td> 
				  <td width="100%" align="left" class=""></td> 
				 
					</tr>
				<?php }?>	
					
				</table>
			</td>				                				                
			</tr>
		
	 </table><br>
	 
	 
	  </div>
	  
	<?php		
    
	if($subjectsCnt > 0){
						
	?>  
	  
	  <div style="float:left;width:100%;">
	  
		<table class="bottomBorder" width="100%">
		  <tr>
			<th></th>
			<th class="back_tsore" align="center">Total Score</th>
			<th class="back_tsore">Average</th>
			<th class="back_tsore">Grade</th>
			<th class="back_tsore">Overall Position</th>			 
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
			<td><?php echo $exam;?></td>
			<td class="back_tsore"><?php echo $examMark.'/'.($subjectsCnt*100);?></td>
			<td class="back_tsore"><?php echo ($examMark/$subjectsCnt);?></td>
			<td class="back_tsore"><?php echo $grade_score;?></td>
			<td class="back_tsore"><?php echo $pos;?></td>					
			</tr>
			<?php }?>
		   
		</table>
	  </div>
	
	  
	  <div style="float:left;width:100%;border-bottom:1px solid #14a79d; height:10px;"></div><br>
	
	  
	 <div style="float:left;width:50%;">
	
	 
	 <div style="float:left;">
	    <div style="float:left;width:10%;">
		  <div style="float:left;width:100%;margin-bottom:5px;">100</div>
		  <div style="float:left;width:100%;margin-bottom:5px;">90</div>
		  <div style="float:left;width:100%;margin-bottom:5px;">70</div>
		  <div style="float:left;width:100%;margin-bottom:5px;">50</div>
		  <div style="float:left;width:100%;margin-bottom:5px;">30</div>
		  <div style="float:left;width:100%;margin-bottom:5px;">10</div>
		</div>
	    <div style="float:left;width:10%;">
		  <div style="border-left:1px solid #231f20;height:143px;"></div>
		</div>
		
		<?php 
		 
		foreach($chart as $exam => $mark){ 	

			$mark = $mark/$subjectsCnt;
		
		?>
	    <div style="float:left;width:20%;padding:5px 8px 0;height:140px;">
		<?php if($mark ==100) { ?>
		    <div style="border:1px solid #00a89e;width:10%;height:140px;background:#00a89e;margin-top:-5px;"></div>
		<?php } else if ($mark < 100 && $mark > 90) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:125px;background:#00a89e;margin-top:12px;"></div>
		<?php } else if ($mark == 90) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:110px;background:#00a89e;margin-top:28px;"></div>
		
		<?php } else if ($mark < 90 && $mark > 70) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:105px;background:#00a89e;margin-top:32px;"></div>
		<?php } else if ($mark == 70) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:90px;background:#00a89e;margin-top:48px;"></div>
		
		<?php } else if ($mark < 70 && $mark > 50) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:85px;background:#00a89e;margin-top:53px;"></div>
		
		<?php } else if ($mark == 50) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:60px;background:#00a89e;margin-top:78px;"></div>
		
		<?php } else if ($mark < 50 && $mark > 30) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:52px;background:#00a89e;margin-top:85px;"></div>
		
		
		<?php } else if ($mark == 30) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:35px;background:#00a89e;margin-top:102px;"></div>
		
		<?php } else if ($mark < 30 && $mark > 10) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:20px;background:#00a89e;margin-top:118px;"></div>
		<?php } else if ($mark == 10) { ?>
		<div style="border:1px solid #00a89e;width:10%;height:15px;background:#00a89e;margin-top:122px;"></div>
		
		<?php } ?>
		
		</div>
				
		<?php }?> 
		 
	 </div>
	 
	 <div style="float:left;width:300px;border-top:1px solid #231f20;margin-left:34px;margin-top:-5px;"></div>
	 
	  <div style="float:left;width:350px;margin-left:80px;margin-top:10px;">
		<?php 		
		foreach($chart as $exam => $mark){ 				
		?>
	   <div style="width:30%;float:left;text-align:center;"><?php echo $exam;?></div>
		<?php } ?>
	   
	  </div>	 

	</div>
 
	<div style="float:right;width:40%;">
	 <table class="bottomBorder chart_right_edu" width="100%">
	  <tr>
	   
		<th>CLASS TEACHER REMARKS</th>
		<th></th>
	   
	  </tr>
	  <tr>
		<td align="left">Academics</td>
		<td align="right" style="background:#f2fbfa;padding:6px;"><strong>Work Harder</strong></td>
	   
		
	  </tr>
	  <tr>
		 <td align="left">Activities</td>
		<td align="right" style="background:#f2fbfa;padding:6px;"><strong>Good</strong></td>
		
	  </tr>
	  <tr>
		 <td align="left">Conduct</td>
		<td align="right" style="background:#f2fbfa;padding:6px;"><strong>Excellent</strong></td>
		
	  </tr>
	</table>
	</div>


	<div style="float:left;width:100%;border-bottom:1px solid #14a79d; height:30px;clear:both;"></div>

	<div style="float:left;width:100%;clear:both;">
	<table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10" style="border-top:1px solid#14a79d;float:left;">	
	<tr width="100%">

			<td align="center"><span>GRADING SYSTEM</span></td>
		  </tr>
		  <tr width="100%">

			<td width="100%"><br><img class="" src="<?php echo base_url('/assets/images/pdf_logo/grade.png');?>" /></td>
		  </tr>
		  </table></div><br>

	<div style="border-bottom:1px solid #14a79d; height:20px;float:left;width:100%"></div>
	
	<?php } ?>  
	  
	</div>

 <footer style="float:left;clear:both;position:absolute;bottom:20px;">
 
 
 <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="0" style="border-top:1px solid#14a79d;">	

	  <tr width="100%">
      
		<td width="40%"><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>				                				                
		<td align="center" width="50%"><span>Genrated <span>Genrated <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
</footer>
