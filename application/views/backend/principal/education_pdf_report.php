<?php
 
$select='TotalPercent';								 
								 if($exam1 != ''){
									 $select='TotalScore';
								  }
								  ?>
								  
								  <?php
								  if($exam2 != ''){
									 $select='TotalScore';
								  }
								  ?>
<div class="table-responsive">	 
    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="2">	
	  
	  
	  <?php
	  $name=$this->db->get_where("school", array('school_id'=>$this->session->userdata('school_id')))->row()->school_name;
							  $address=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->address;
							  $telephone=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->phone;
							  $location=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->county;
							  
							  
	  ?>
	  <tr>
	  <td colspan="2" align="center"> 
							   
							   <?php echo '<img src="'.base_url().'uploads/logo.png" width="70" height="70"><B>
							   <br>
							 '. $name.'
							   <br>
							   '.$address.'-
							   
							   '.$location.'
							   <br>
							   '.$telephone.' <br><U><strong class="card-title "><center>REPORT CARD  '.strtoupper($class." ". $stream. " ".$main_exam." ". $subject." ($term - ". $year. ")").'</strong>	</U></B>'; ?>						   </center>
							   </th>
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
	    <table border="0.2">
		<tr  width="100%">
			      <td width="100%" align="left" class="left_side"><strong>RESULTS</strong></td>
				  
			   </tr>
		</table>

		
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="4">	

	 <tr width="100%" >
		<td width="100%">
		    <table class="known_all eduction_tbl bottomBorder" width="100%" border="1" cellspacing="0" cellpadding="0" >
			   
			   <tr  width="100%" scope="col"  style="background-color:#40c3bb; color:#fff;">
			     				  
				<th width="100%" align="left">Subject</th>
				
				<?php			    
										 
				?>   
				<?php
								  if($exam1 != ''){
									  echo '<th>'.$exam1.'</th>';
								  }
								  ?>
								  
								  <?php
								  if($exam2 != ''){
									  echo '<th>'.$exam2.'</th>';
								  }
								  ?>
				
					<th width="100%" align="left" class=""><?php echo $exam_main;?></th>
				<th width="100%" align="left" class="">Total</th>
				<th width="100%" align="left" class="">Grade</th>
				<th width="100%" align="left">Rank</th>
				<th width="100%" align="left">Position</th>
				<th width="100%" align="left">Remarks</th>
				<th width="100%" align="left">Teacher</th>
				  				  
			   </tr>
			   
			 
				
						<?php
						$total=0;
						$subs=0;
					$exm = strtolower(str_replace(" ","",$exam_main));
				    if($exm)	$code=$this->db->query("select distinct(Code) from $exm where adm='$adm' and term='$term' and year='$year'")->result_array();
					foreach($code as $subject):
					$score1=0;
					$score2=0;
					$score3=0;
					$subs+=1;
					$subject_code=$subject['Code'];
					?>
					<tr   width="100%">		
					
					
						
						<td width="100%" align="left" class=""><?php echo ucwords($this->db->get_where("subjects", array("Code"=>$subject['Code']))->row()->Description);?></td>
						<td width="100%" align="center" class="back_tsore"><?php
						$exm = strtolower(str_replace(" ","",$exam_main));
							$score1=$this->db->query("select $select from $exm where adm='$adm' and term='$term' and year='$year' and code='$subject_code'")->row()->$select;

						echo round($score1,0);?></td> 
							<?php
								  if($exam1 != ''){
									  ?>
									 <td width="100%" align="center" class="back_tsore"><?php
						$exm = strtolower(str_replace(" ","",$exam1));
							$score2=$this->db->query("select $select from $exm where adm='$adm' and term='$term' and year='$year' and code='$subject_code'")->row()->$select;

						echo round($score2,0);?></td>
									  <?php
								  }
								  ?>
								  
								  <?php
								  if($exam2 != ''){
									  ?>
									  <td width="100%" align="center" class="back_tsore"><?php
						$exm = strtolower(str_replace(" ","",$exam2));
							$score3=$this->db->query("select $select from $exm where adm='$adm' and term='$term' and year='$year' and code='$subject_code'")->row()->$select;

						echo round($score3,0);?></td>
									  <?php
								  }
								  ?>	  
					  <td width="100%" align="center" class="back_detials_info"><?php echo $score1+$score2+$score3;
					  $total=$total+$score1+$score2+$score3;
					  
					  ?></td> 
					  <td width="100%" align="center" class="back_detials_info"><?php
						$exm = strtolower(str_replace(" ","",$exam_main));
							$grade=$this->db->query("select Grade from $exm where adm='$adm' and term='$term' and year='$year' and code='$subject_code'")->row()->Grade;

						echo $grade;?></td> 
					  <td width="100%" align="center" class=""><?php
						$exm = strtolower(str_replace(" ","",$exam_main));
							$pos=$this->db->query("select PosClass from $exm where adm='$adm' and term='$term' and year='$year' and code='$subject_code'")->row()->PosClass;

						echo $pos;?></td> 
						 <td width="100%" align="center" class=""><?php
						$exm = strtolower(str_replace(" ","",$exam_main));
							$pos=$this->db->query("select PosStream from $exm where adm='$adm' and term='$term' and year='$year' and code='$subject_code'")->row()->PosStream;

						echo $pos;?></td> 
					  <td width="100%" align="center" class=""><?php

						$remark=$this->db->query("select Remarks from gradingscale where Grade='$grade' and school_id='".$this->session->userdata('school_id')."'")->row()->Remarks;

					  echo $remark;?></td>
					  <td width="100%" align="center" class=""><?php echo $teacher_name;?></td> 
				   </tr>
				    <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
				   <?php
				   endforeach;
				   ?>
			   
			       <tr  width="100%" scope="col">
					
						<td width="100%" align="left" class=""></td> 
							  
				  <td width="100%" align="center" class=""><strong>Total</strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><strong><?php echo $total;?></strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><?php

						$meangrade=$this->db->query("select Grade from mean_score where adm='$adm' and term='$term' and year='$year' and school_id='".$this->session->userdata('school_id')."'")->row()->Grade;

					  echo $meangrade;?></td> 
					   <td width="100%" align="center" class=""><strong></strong></td> 
					  
				  <td width="100%" align="center" class=""><strong></strong></td> 
				  <td width="100%" align="left" class=""><?php

						$remark=$this->db->query("select Remarks from gradingscale where Grade='$meangrade' and school_id='".$this->session->userdata('school_id')."'")->row()->Remarks;

					  echo $remark;?></td> 
				  <td width="100%" align="left" class=""></td> 
				 
				  </tr>
			   
			      <tr  width="100%">
					
						<td width="100%" align="left" class=""></td> 
				
			     
				  <td width="100%" align="center" class=""><strong>Out of</strong></td> 
				  <td width="100%" align="center" class="back_detials_info"><strong><?php 
				  
				  echo $subs*100 ;
				  ?></strong></td> 
				  <td width="100%" align="left" class="back_detials_info"></td> 
				  <td width="100%" align="center" class=""><?php echo $outof_position;?></td> 
				  <td width="100%" align="left" class=""></td> 
				  <td width="100%" align="left" class=""></td> 
				 
					</tr>
				
					
				</table>
			</td>				                				                
			</tr>
		
	 </table><br>
	 
	 
	  </div>
	 
	  
	  <div style="float:left;width:100%;">
	  
		<table class="bottomBorder" width="100%">
		  <tr>
			<th></th>
			<th class="back_tsore" align="center">Total Score</th>
			<th class="back_tsore">Average</th>
			<th class="back_tsore">Grade</th>
			<th class="back_tsore">Overal Rank</th>	
<th class="back_tsore">Position</th>				
		  </tr>
		  
			
		  
			<tr>
			<td></td>
			<td class="back_tsore"><?php echo ($total); ?></td>
			<td class="back_tsore"><?php echo ($total/$subs); ?></td>
			<td class="back_tsore"><?php $points= ($total/$subs); 
			if($points>0)$grd= $this->db->query("select Grade from gradingscale where $points>=min and $points<=max")->row()->Grade;
			echo $grd;
			?></td>
			<td class="back_tsore">
			
			<?php

						$rank=$this->db->query("select PosClass from mean_score where adm='$adm' and term='$term' and year='$year' and school_id='".$this->session->userdata('school_id')."'")->row()->PosClass;

					  echo $rank;?>
			</td>
			<td class="back_tsore">
			
			<?php

						$pos=$this->db->query("select PosStream from mean_score where adm='$adm' and term='$term' and year='$year' and school_id='".$this->session->userdata('school_id')."'")->row()->PosStream;

					  echo $pos;?>
			</td>					
			</tr>
			
		   
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
		
		
	    <div style="float:left;width:20%;padding:5px 8px 0;height:140px;">
		
		    <div style="border:1px solid #00a89e;width:10%;height:<?php echo ($total/$subs)+ 40 ; ?>px;background:#00a89e;margin-top:0px;"></div>
	
		
		
		
		</div>
				
		
		 
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

			<table class="bottomBorder" width="100%">
			<tr>
			
			<th class="back_tsore" align="center">Score</th>
			<?php
			
			$gs=$this->db->get_where("gradingscale",array("school_id"=>$this->session->userdata('school_id')))->result_array();
			
			foreach($gs as $row):
			
			
			?>
		  
			<th class="back_tsore"><?php echo $row['min'].'-'.$row['max']; ?></th>
			
		
		  <?php
		  endforeach ;
		  ?>
		    </tr>
		  <tr>
			
			<th class="back_tsore" align="center">Grade</th>
			<?php
			
			$gs=$this->db->get_where("gradingscale",array("school_id"=>$this->session->userdata('school_id')))->result_array();
			
			foreach($gs as $row):
			
			
			?>
		  
			<th class="back_tsore"><?php echo $row['Grade']; ?></th>
			
		  
		  <?php
		  endforeach ;
		  ?>
		  </tr>
		  </table>
		  
		  </tr>
		  </table></div><br>

	<div style="border-bottom:1px solid #14a79d; height:20px;float:left;width:100%"></div>
	
	
	  
	</div>
	

 <footer style="float:left;clear:both;position:absolute;bottom:20px;">
 
 
 <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="0" style="border-top:1px solid#14a79d;">	

	  <tr width="100%">
      
		<td width="20%"><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>				                				                
		<td align="center" width="50%"><span> <span>Generated on <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
	  
</footer>