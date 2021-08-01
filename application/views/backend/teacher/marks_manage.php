<hr />
<?php echo form_open(site_url('teacher/marks_selector'));?>
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

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
			<select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_stream');?></option>
				<?php
                
                	$school_id = $this->session->userdata('school_id');
						 
					$user_id = $this->session->userdata('login_user_id');      
							 
					$subclassids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('teacher_id', $user_id)->get('subject')->row()->classes;
						
					$secclassids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('teacher_id', $user_id)->get('section')->row()->classes; 
						
					$subclassids = ($subclassids !='')?$subclassids.",".$secclassids:$secclassids;
						
					$classes = array();
					if($subclassids !='')
						$classes = $this->db->where_in('class_id', explode(',',$subclassids))->get('class')->result_array();                                            
                				 			 
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
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
				<select name="section_id" id="section_holder" onchange="get_class_subject(this.value)" class="form-control">
					<option value=""><?php echo get_phrase('select_class_first');?></option>		
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_holder" class="form-control">
					<option value=""><?php echo get_phrase('select_subject_first');?></option>		
				</select>
			</div>
		</div>		
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info" id = "submit"><?php echo get_phrase('manage_marks');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

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
	function get_offer_class_section(class_id) {
		jQuery('#offer_subject_holder').html("<option value=''>select section first</option>");
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_offer_class_section/');?>' + class_id,
            success: function(response)
            {
                jQuery('#offer_section_holder').html(response);
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
	
	function get_offer_class_subject(section_id) {
		
		var class_id =  jQuery('#class_id').val();
		if (class_id !== '' && section_id !='') { 
		$.ajax({
            url: '<?php echo site_url('admin/get_offer_class_subject/');?>' + class_id + '/'+ section_id ,
            success: function(response)
            {  
                jQuery('#offer_subject_holder').html(response);
            }
        });
        $('#submit').removeAttr('disabled');
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
</script>