<hr />
<?php 
$school_id = $this->db->get_where('class' , array('class_id' => $class_id))->row()->school_id;
echo form_open(site_url('admin/marks_selector'));
?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control" required>
				<?php
					 $exams = $this->db->get_where('exam' , array('school_id' => $school_id,'year' => $running_year))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"
					<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
			<select id="class_id" name="class_id" class="form-control selectboxit" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_stream');?></option>
				<?php
					$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"
					<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div>
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
				<select name="section_id" id="section_holder" onchange="get_class_subject(this.value)" class="form-control">
					<?php 
						$sections = $this->db->get_where('section' , array(
							'class_id' => $class_id 
						))->result_array();
						foreach($sections as $row):
					?>
					<option value="<?php echo $row['section_id'];?>" 
						<?php if($section_id == $row['section_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
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
						<?php  if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info"><?php echo get_phrase('manage_marks');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />
<div class="row" style="text-align: center;">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<div class="tile-stats tile-gray">
			<div class="icon"><i class="entypo-chart-bar"></i></div>
			
			<h3 style="color: #696969;"><?php echo get_phrase('marks_for');?> <?php echo $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;?></h3>
			<h4 style="color: #696969;">
				<?php echo get_phrase('stream');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> : 
				<?php echo get_phrase('class');?> <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?> 
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('subject');?> : <?php echo $this->db->get_where('subject' , array('class_subject' => $subject_id))->row()->name;?>
			</h4>
		</div>
	</div>
	<div class="col-sm-4"></div>
</div>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-12">

		<?php echo form_open(site_url('admin/marks_update/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id));?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo get_phrase('id');?></th>
						<th><?php echo get_phrase('name');?></th>
						<th><?php echo get_phrase('marks_obtained');?></th>
						<th><?php echo get_phrase('comment');?></th>
					</tr>
				</thead>
				<tbody>
				
				<?php
					$count = 1;
					$ori = array(
						'class_id' => $class_id, 
							'section_id' => $section_id,
								'subject_id' => $subject_id,
								'year' => $running_year,
								'exam_id' => $exam_id
					);
					$marks_of_students = $this->db->get_where('mark' , $ori)->result_array();
					foreach($marks_of_students as $row): 
										
				?>
					<tr>
						<td><?php echo $count++;?></td>

                        <td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->student_code;?></td>

						<td>
							<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
						</td>
						<?php
							$query = $this->db->query("SELECT * FROM `subject` LEFT JOIN `class_subjects` ON class_subjects.id =subject.class_subject WHERE `subject_id`=$subject_id"); 
							$data = $query->result_array();
							$parts = ($data[0]['parts']);
							if($parts == '2') { ?>
						<td>
							<div class="col-lg-12">
								<div class="col-lg-4">Part 1							
									<input type="text" class="form-control input_mark" id ="mark_obtained1_<?php echo $row['mark_id'];?>" name="mark_obtained1_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained1'];?>" maxlength="2">	
								</div>
								<div class="col-lg-4">Part 2								
									<input type="text" class="form-control input_mark" id ="mark_obtained2_<?php echo $row['mark_id'];?>" name="mark_obtained2_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained2'];?>" maxlength="2">
								</div>
								<div class="col-lg-4">Total	
								<input type="text" class="form-control totalmark" id="total1" name="total1" value="" /> 
								</div>
							</div>	
							<script type="text/javascript">
								var BASE_URL = "<?php echo base_url();?>";
							</script>
							<script>
							jQuery(document).ready(function(){
								//jQuery('#total1').focus(function(){
									jQuery(document).on('click focus', '#total1', function(e) {
									var item11 = $('#mark_obtained1_<?php echo $row['mark_id'];?>').val();
									var item22 = $('#mark_obtained2_<?php echo $row['mark_id'];?>').val();
									//var item33 = $('#mark_obtained3_<?php echo $row['mark_id'];?>').val();
									var total1 = parseInt(item11) + parseInt(item22);
									var settings = {
									  "async": true,
									  "crossDomain": true,
									  "url": BASE_URL+'index.php/admin/get_comments',
									  "method": "POST",
									  "headers": {
										"content-type": "application/x-www-form-urlencoded",
										"cache-control": "no-cache",
										"postman-token": "9a883d3f-ae40-67f7-4944-d2842a80eb1d"
									  },
									  "data": {
										"exam_id" :$('#marks_obtained_<?php echo $row['exam_id'];?>').val(),
										"class_id": $('#marks_obtained_<?php echo $row['class_id'];?>').val(),
										"section_id": $('#marks_obtained_<?php echo $row['section_id'];?>').val(),
										"mark_id": total1,										
									  }
									}

								$.ajax(settings).done(function (response) {
								  console.log(response);
								  jQuery('#comment_'+<?php echo $row['mark_id'];?>).val(response); 
								});
									
									
								}); 
							});
							</script>
							<script type="text/javascript">
								$(document).on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
									  if (event.keyCode == 13) {
										event.preventDefault();
										var fields = $(this).closest("form").find("input, textarea");
										var index = fields.index(this) + 1;
										var field;
										fields.eq(
										  fields.length <= index
										  ? 0
										  : index
										).focus();
									  }									  
									});
							</script>							
						</td>
						<?php } elseif ($parts == '3') { ?>
							<td>
							<div class="col-lg-12">
								<div class="col-lg-3">Part 1							
									<input type="text" class="form-control input_mark" id ="mark_obtained1_<?php echo $row['mark_id'];?>" name="mark_obtained1_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained1'];?>" maxlength="2">	
								</div>
								<div class="col-lg-3">Part 2								
									<input type="text" class="form-control input_mark" id ="mark_obtained2_<?php echo $row['mark_id'];?>" name="mark_obtained2_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained2'];?>" maxlength="2">
								</div>
								<div class="col-lg-3">Part 3								
									<input type="text" class="form-control input_mark" id ="mark_obtained3_<?php echo $row['mark_id'];?>" name="mark_obtained3_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained3'];?>" maxlength="2">
								</div>
								<div class="col-lg-3">Total	
								<input type="text" class="form-control totalmark" id="total1" name="total1" value="" /> 
								</div>
							</div>
							<script type="text/javascript">
								var BASE_URL = "<?php echo base_url();?>";
							</script>							
							<script>
							jQuery(document).ready(function(){
								//jQuery('#total1').focus(function(){
									jQuery(document).on('click focus', '#total1', function(e) {
									var item11 = $('#mark_obtained1_<?php echo $row['mark_id'];?>').val();
									var item22 = $('#mark_obtained2_<?php echo $row['mark_id'];?>').val();
									var item33 = $('#mark_obtained3_<?php echo $row['mark_id'];?>').val();
									var total1 = parseInt(item11) + parseInt(item22) + parseInt(item33);
									var settings = {
									  "async": true,
									  "crossDomain": true,
									  "url": BASE_URL+'index.php/admin/get_comments',
									  "method": "POST",
									  "headers": {
										"content-type": "application/x-www-form-urlencoded",
										"cache-control": "no-cache",
										"postman-token": "9a883d3f-ae40-67f7-4944-d2842a80eb1d"
									  },
									  "data": {
										"exam_id" :$('#marks_obtained_<?php echo $row['exam_id'];?>').val(),
										"class_id": $('#marks_obtained_<?php echo $row['class_id'];?>').val(),
										"section_id": $('#marks_obtained_<?php echo $row['section_id'];?>').val(),
										"mark_id": total1,										
									  }
									}

								$.ajax(settings).done(function (response) {
								  console.log(response);
								  jQuery('#comment_'+<?php echo $row['mark_id'];?>).val(response); 
								});
									
									
								}); 
							});
							</script>
							<script type="text/javascript">
								$(document).on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
									  if (event.keyCode == 13) {
										event.preventDefault();
										var fields = $(this).closest("form").find("input, textarea");
										var index = fields.index(this) + 1;
										var field;
										fields.eq(
										  fields.length <= index
										  ? 0
										  : index
										).focus();
									  }									  
									});
							</script>							
						</td>
						<?php } elseif ($parts == '4') { ?>
							<td>
							<div class="col-lg-12">
								<div class="col-lg-2">Part 1							
									<input type="text" class="form-control input_mark" id ="mark_obtained1_<?php echo $row['mark_id'];?>" name="mark_obtained1_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained1'];?>" maxlength="2">	
								</div>
								<div class="col-lg-2">Part 2								
									<input type="text" class="form-control input_mark" id ="mark_obtained2_<?php echo $row['mark_id'];?>" name="mark_obtained2_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained2'];?>" maxlength="2">
								</div>
								<div class="col-lg-2">Part 3								
									<input type="text" class="form-control input_mark" id ="mark_obtained3_<?php echo $row['mark_id'];?>" name="mark_obtained3_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained3'];?>" maxlength="2">
								</div>
								<div class="col-lg-2">Part 4								
									<input type="text" class="form-control input_mark" id ="mark_obtained4_<?php echo $row['mark_id'];?>" name="mark_obtained4_<?php echo $row['mark_id'];?>" value="<?php echo $row['mark_obtained4'];?>" maxlength="2">
								</div>
								<div class="col-lg-2">Total	
								<input type="text" class="form-control totalmark" id="total1" name="total1" value="" /> 
								</div>
							</div>	
							<script type="text/javascript">
								var BASE_URL = "<?php echo base_url();?>";
							</script>
							<script>
							jQuery(document).ready(function(){
								//jQuery('#total1').focus(function(){
									jQuery(document).on('click focus', '#total1', function(e) {
									var item11 = $('#mark_obtained1_<?php echo $row['mark_id'];?>').val();
									var item22 = $('#mark_obtained2_<?php echo $row['mark_id'];?>').val();
									var item33 = $('#mark_obtained3_<?php echo $row['mark_id'];?>').val();
									var item44 = $('#mark_obtained4_<?php echo $row['mark_id'];?>').val();
									var total1 = parseInt(item11) + parseInt(item22) + parseInt(item33)+ parseInt(item44);
									var settings = {
									  "async": true,
									  "crossDomain": true,
									  "url": BASE_URL+'index.php/admin/get_comments',
									  "method": "POST",
									  "headers": {
										"content-type": "application/x-www-form-urlencoded",
										"cache-control": "no-cache",
										"postman-token": "9a883d3f-ae40-67f7-4944-d2842a80eb1d"
									  },
									  "data": {
										"exam_id" :$('#marks_obtained_<?php echo $row['exam_id'];?>').val(),
										"class_id": $('#marks_obtained_<?php echo $row['class_id'];?>').val(),
										"section_id": $('#marks_obtained_<?php echo $row['section_id'];?>').val(),
										"mark_id": total1,										
									  }
									}

								$.ajax(settings).done(function (response) {
								  console.log(response);
								  jQuery('#comment_'+<?php echo $row['mark_id'];?>).val(response); 
								});
									
									
								}); 
							});
							</script>
							<script type="text/javascript">
								$(document).on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
									  if (event.keyCode == 13) {
										event.preventDefault();
										var fields = $(this).closest("form").find("input, textarea");
										var index = fields.index(this) + 1;
										var field;
										fields.eq(
										  fields.length <= index
										  ? 0
										  : index
										).focus();
									  }									  
									});
							</script>							
						</td>
							
						<?php } else { ?>
						<td>
						<div class="col-lg-12">
								<div class="col-lg-6">Mark
									<input type="text" class="form-control input_mark" name="marks_obtained_<?php echo $row['mark_id'];?>" id ="marks_obtained_<?php echo $row['mark_id'];?>"
										value="<?php echo $row['mark_obtained'];?>" maxlength="2">	

									<input type="hidden" class="form-control input_mark" name="marks_obtained_<?php echo $row['class_id'];?>" id ="marks_obtained_<?php echo $row['class_id'];?>"
									value="<?php echo $row['class_id'];?>" maxlength="2">	
									<input type="hidden" class="form-control input_mark" name="marks_obtained_<?php echo $row['section_id'];?>" id ="marks_obtained_<?php echo $row['section_id'];?>"
									value="<?php echo $row['section_id'];?>" maxlength="2">	
									<input type="hidden" class="form-control input_mark" name="marks_obtained_<?php echo $row['mark_id'];?>" id ="marks_obtained_<?php echo $row['exam_id'];?>"
									value="<?php echo $row['exam_id'];?>" maxlength="2">	
										
										
										
										
								</div>
								<div class="col-lg-6">Total
								<input type="text" class="form-control totalmark" id="total11" name="total11" value="" /> 
								</div>
						</div>
						<script type="text/javascript">
								var BASE_URL = "<?php echo base_url();?>";
							</script>
							<script>
							jQuery(document).ready(function(){
									jQuery(document).on('click focus', '#total11', function(e) {
									var item1 = $('#marks_obtained_<?php echo $row['mark_id'];?>').val();
									var item2 = $('#marks_obtained_<?php echo $row['class_id'];?>').val();
									var item3 = $('#marks_obtained_<?php echo $row['section_id'];?>').val();
									var item4 = $('#marks_obtained_<?php echo $row['exam_id'];?>').val();
									var total11 = parseInt(item1);
									//jQuery('#total11').val(total11); 
									
									var settings = {
									  "async": true,
									  "crossDomain": true,
									  "url": BASE_URL+'index.php/admin/get_comments',
									  "method": "POST",
									  "headers": {
										"content-type": "application/x-www-form-urlencoded",
										"cache-control": "no-cache",
										"postman-token": "9a883d3f-ae40-67f7-4944-d2842a80eb1d"
									  },
									  "data": {
										"exam_id" :$('#marks_obtained_<?php echo $row['exam_id'];?>').val(),
										"class_id": $('#marks_obtained_<?php echo $row['class_id'];?>').val(),
										"section_id": $('#marks_obtained_<?php echo $row['section_id'];?>').val(),
										"mark_id": total11,										
									  }
									}

								$.ajax(settings).done(function (response) {
								  console.log(response);
								  jQuery('#comment_'+<?php echo $row['mark_id'];?>).val(response);
								});
								}); 
							});
							</script>
								<script type="text/javascript">
								$(document).on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
									  if (event.keyCode == 13) {
										event.preventDefault();
										var fields = $(this).closest("form").find("input, textarea");
										var index = fields.index(this) + 1;
										var field;
										fields.eq(
										  fields.length <= index
										  ? 0
										  : index
										).focus();
									  }
									});
							</script>	
						</td>
						<?php } ?>
						<td>
						<div class="col-lg-12">Comment
						<input type="text" class="form-control" name="comment_<?php echo $row['mark_id'];?>"
								id="comment_<?php echo $row['mark_id'];?>" value="<?php echo $row['comment'];?>">
						</td> 
						</div>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>

		<center>
			<button type="submit" class="btn btn-success" id="submit_button">
				<i class="entypo-check"></i> <?php echo get_phrase('save_changes');?>
			</button>
		</center>
		<?php echo form_close();?>
		
	</div>
	<div class="col-md-2"></div>
</div>
<style>
.input_mark, .totalmark {

}
</style>

<script type="text/javascript">
    jQuery(document).ready(function($) {
	   $("#submit").attr('disabled', 'disabled');
	   
	 
    });
	function get_class_section(class_id) {
		 jQuery('#subject_holder').html("<option value=''>select section first</option>");
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });         
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