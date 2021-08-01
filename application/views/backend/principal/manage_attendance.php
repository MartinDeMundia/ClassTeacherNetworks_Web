<hr />

<?php echo form_open(site_url('teacher/attendance_selector/'));?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date');?></label>
			<input required type="text" class="form-control datepicker" name="timestamp" data-format="dd-mm-yyyy"
				value="<?php echo date("d-m-Y");?>"/>
		</div>
	</div>

	<?php
	
		$user_id = $this->session->userdata('login_user_id');      
        
		$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
		
		if($sectionsids!='')
		$query = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section');
		else
        $query = $this->db->get_where('section' , array('class_id' => $class_id));
		
		 
		if($query->num_rows() > 0):
			$sections = $query->result_array();
	?>
	
	<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
				<select name="section_id" id="section_id" class="form-control"  onchange="get_class_subject(this.value)">
					<?php $i=1; foreach($sections as $row): $sele = ($i== 1)?'selected':'';?>
					<option value="<?php echo $row['section_id'];?>" <?php echo $sele;?>><?php echo $row['name'];?></option>
					<?php $i++; endforeach;?>	
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_id" class="form-control" onchange="get_class_subject_periord(this.value)">
					<option value=""><?php echo get_phrase('select_section_first');?></option>		
				</select>
			</div>
		</div> 
	 
		<div class="col-md-2">
			<div class="form-group">
				<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('periord'); ?></label>
				<select class="form-control" name="periord" id="periord" >
					<option value=""><?php echo get_phrase('select_subject_first') ?></option>				 
				</select>
			</div>
		</div>
			 
	<?php endif;?>
	<input type="hidden" id="class_id" name="class_id" value="<?php echo $class_id;?>">
	<input type="hidden" name="year" value="<?php echo $running_year;?>">

	<div class="col-md-4" style="margin-top: 20px;">
		<button type="submit" class="btn btn-info" id = "submit"><?php echo get_phrase('manage_attendance');?></button>
	</div>

</div>
<?php echo form_close();?>

<script type="text/javascript">
	$(document).ready(function($) {
		$("#submit").attr('disabled', 'disabled');
		 
		get_class_subject();	

		setTimeout(function(){ get_class_subject_periord(); }, 3000);
	});
	
	function check_validation(){
		var class_id = $('#class_id').val();
		var section_id = $('#section_id').val();
		var subject_id = $('#subject_id').val();
		var periord = $('#periord').val();
		if(class_id !== '' && section_id !== '' && subject_id !== '' && periord !== null){
			$('#submit').removeAttr('disabled');
		}
		else{
			$('#submit').attr('disabled', 'disabled');	
		}
	}
	
	function get_class_section() {
		var class_id = $("#class_id").val();
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {
                $('#section_holder').html(response);
            }
        });         
	  }
	  
	  check_validation();
	   
	}	
	function get_class_subject() {
		
		var class_id =  jQuery('#class_id').val();
		var section_id =  jQuery('#section_id').val();
		if (class_id !== '' && section_id !='') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id+'/1' ,
            success: function(response)
            {
                $('#subject_id').html(response);
				
				get_class_subject_periord();
            }			
			
        });
         
	  }
	  check_validation();
	}
	
	function get_class_subject_periord() {
		
		var class_id = $('#class_id').val();
		var section_id = $('#section_id').val();
		var subject_id = $('#subject_id').val();
		
        $.ajax({
            url: '<?php echo site_url('admin/get_class_subject_periord/'); ?>' + class_id + '/' + section_id + '/'+ subject_id,
            success: function (response)
            {
                $('#periord').html(response);
            }
        });
		
		check_validation();
    }	
	
</script>