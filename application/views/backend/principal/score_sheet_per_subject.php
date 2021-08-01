<hr />
<?php echo form_open(site_url('admin/score_sheet_per_subject'));?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control">
				<?php
					$exams = $this->db->get_where('exam' , array('year' => $running_year, 'school_id' => $this->session->userdata('school_id')))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
<?php //echo $new_exam_id1 =  $this->uri->segment('3'); ?>
<?php //echo $new_exam_id2 =  $this->uri->segment('4'); ?>
<?php //echo $new_exam_id3 =  $this->uri->segment('5'); ?>
<?php //echo $new_exam_id4 =  $this->uri->segment('6'); ?>
	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select id="class_id" name="class_id" class="form-control selectboxit" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_class');?></option>
				<?php
					$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();	
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div>
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
				<select name="section_id" id="section_holder" class="form-control"  onchange="get_class_subject(this.value)">
					<option value=""><?php echo get_phrase('select_class_first');?></option>		
				</select>
			</div>
		</div>	
		
		<div class ="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_holder" class="form-control">
					<?php 
						
						$user_id = $this->session->userdata('login_user_id');      
						$role = $this->session->userdata('login_type');

						if($role =='teacher')		
        					$subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
						else									
						$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
			
						
						foreach($subjects as $row):
					?>
					<option value="<?php echo $row['subject_id'];?>"
						<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>



<input type="hidden" name="operation" value="selection">
		
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info" id = "submit"><?php echo get_phrase('view_report');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>


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
					//$row['class_id'];
					endforeach;
					
					$new_exam_id =  $this->uri->segment('4');
					 
					//$class_id = 112;   
					//$exam_id = 48;
					$new_subject_id =  $this->uri->segment('6'); 
					$exam_name  = $this->db->get_where('exam' , array('exam_id' => $new_exam_id))->row()->name; 
					$class_name = $this->db->get_where('class' , array('class_id' => $row4['class_id']))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$subject_name = $this->db->get_where('subject' , array('class_subject' => $new_subject_id))->row()->name;
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
				<?php 
					$subject_name = $this->db->get_where('subject' , array('class_subject' => $new_subject_id))->row()->name;
				?>
					<td style="text-align: center;"><?php echo $subject_name;?></td>							
				</tr>
			</thead>
			<tbody>
			<?php
			$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                    foreach($classes as $row23):
					//echo $row23['class_id'];
					endforeach;
				$new_section_id =  $this->uri->segment('5'); 				
				$students = $this->db->get_where('enroll' , array('class_id' => $row23['class_id'] , 'section_id' => $new_section_id ,'year' => $running_year))->result_array();	
				
				foreach($students as $row22):
				//echo $row22['student_id'];
			?>
				<tr>
					<td style="text-align: center;">
						<?php echo $this->db->get_where('student' , array('student_id' => $row22['student_id']))->row()->name;?>
					</td>
				
				<?php
					$total_marks = 0;
					$total_grade_point = 0;
					$new_exam_id =  $this->uri->segment('4');
				?>
					<td style="text-align: center;">
						<?php 
							$obtained_mark_query = 	$this->db->get_where('mark' , array(
													'class_id' => $row23['class_id'] ,
														'exam_id' => $new_exam_id , 
															'subject_id' => $new_subject_id , 
																'student_id' => $row22['student_id'],
																	'year' => $running_year
												));
							
								$obtained_marks = $obtained_mark_query->row()->mark_obtained;
									echo $obtained_marks;
								
							

						?>
					</td>
				
				
				</tr>

			<?php endforeach;?>	

			</tbody>
		</table>
		<!--center>
			<a href="<?php echo site_url('admin/tabulation_sheet_print_view/'.$class_id.'/'.$exam_id.'/'.$section_id);?>" 
				class="btn btn-primary" target="_blank">
				<?php echo get_phrase('print');?>
			</a>
		</center-->
	</div>
</div>
<?php endif;?>


<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#submit").attr('disabled', 'disabled');
});
	function get_class_section(class_id) {
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });
        $('#submit').removeAttr('disabled');
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
	
	function get_class_subject(section_id) {
		
		var class_id =  jQuery('#class_id').val();
		if (class_id !== '' && section_id !='') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
            success: function(response)
            {
                jQuery('#subject_holder').html(response);
            }
        });
        $('#submit').removeAttr('disabled');
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
</script>