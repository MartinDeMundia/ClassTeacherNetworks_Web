
<div class="btn-group" style="float:right; margin:0px; "  >
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		Print Option <span class="caret"></span>
		</button>
		<ul class="dropdown-menu dropdown-default pull-right" role="menu">
			<?php 
			$school_id = $this->session->userdata('school_id');
			$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
			$class_idp = ($classes[0]['class_id']);											
			?>
			<li>
			<a href="#" onclick="showAjaxModal('<?php $subject_id =  $this->uri->segment('6'); echo site_url('modal/popup/modal_blank_marks_manage_subject_view/'.$exam_id.'/'.$class_idp.'/'.$section_id.'/'.$subject_id);?>');">
			<i class="entypo-pencil"></i>
			<?php echo get_phrase('print_mark_book');?>
			</a>
		</li>										
		</ul>
 </div>


<hr />
<?php echo form_open(site_url('teacher/blank_marks_subject_selector'));?>
<div class="row">

	
	 	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control" required>
				<?php					
                    $exams = $this->db->get_where('exams' , array('school_id' => $school_id))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['ID'];?>"
					<?php if($exam_id == $row['ID']) echo 'selected';?>><?php echo $row['Term1'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

<!-- 	<div class="col-md-2">
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
 -->



	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
			<select id="class_id" name="class_id" class="form-control selectboxit" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_stream');?></option>
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
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
				<select name="section_id" id="section_holder" class="form-control"  onchange="get_class_subject(this.value)">
					<option value=""><?php echo get_phrase('select_class_first');?></option>		
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_holder" class="form-control" >
					<option value=""><?php echo get_phrase('select_subject_first');?></option>		
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info" id = "submit"><?php echo get_phrase('view_marks');?></button>
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