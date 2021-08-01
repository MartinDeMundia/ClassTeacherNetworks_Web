<hr />
<?php
  $info = $this->db->get_where('assignments', array(
    'assignment_id' => $assignment_id
  ))->result_array();
  foreach ($info as $row): 
  $class_id = $row['class_id'];
  $section_id = $row['section_id'];
  $subject_id = $row['subject_id'];
?>
<div class="row">
  <div class="box-content">
      <?php echo form_open(site_url('principal/assignments/do_update/'.$row['assignment_id']), array(
        'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data',
          'target' => '_top')); ?>
		  
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
			  <div class="col-sm-5">
			<select required name="class_id" class="form-control" id = 'class_id' onchange="get_class_section()">
				<option value=""><?php echo get_phrase('select_a_stream');?></option>
				<?php 
				
				$user_id = $this->session->userdata('login_user_id');      
							 
				$classids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->classes;
				 
				if($classids !='')
					$classes = $this->db->where_in('class_id', explode(',',$classids))->get('class')->result_array();
				else							
					$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
										
				foreach($classes as $class):
				?>
					<option value="<?php echo $class['class_id'];?>"
						<?php if ($class_id == $class['class_id']) echo 'selected';?>>
							<?php echo $class['name'];?>
					</option>
				<?php
				endforeach;
				?>
			</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" ><?php echo get_phrase('class');?></label>
			  <div class="col-sm-5">
			<select required name="section_id" id="section_id" class="form-control"  onchange="get_class_subject()">
				<option value=""><?php echo get_phrase('select_class_first');?></option>
				<?php 
				
				$user_id = $this->session->userdata('login_user_id');      
				 			  	 
				$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
				 
				if($sectionsids!='')
				$sections = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section')->result_array();
				else			
				$sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
			
				foreach($sections as $section):
				?>
					<option value="<?php echo $section['section_id'];?>"
						<?php if ($section_id == $section['section_id']) echo 'selected';?>>
							<?php echo $section['name'];?>
					</option>
				<?php
				endforeach;
				?>
			</select>
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
			  <div class="col-sm-5">
			<select required name="subject_id" id="subject_id" class="form-control" onchange="get_class_subject_periord(this.value)">
				<option value=""><?php echo get_phrase('select_section_first');?></option>
				<?php 
				
				$user_id = $this->session->userdata('login_user_id');      
				 		
				$subjects = $this->db->get_where('subject' , array('principal_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id))->result_array();
				 
				foreach($subjects as $subject):
				?>
					<option value="<?php echo $subject['subject_id'];?>"
						<?php if ($subject_id == $subject['subject_id']) echo 'selected';?>>
							<?php echo $subject['name'];?>
					</option>
				<?php
				endforeach;
				?>
			</select>
			</div>
		</div>
					  
		<div class="form-group">
          <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
          <div class="col-sm-5">
              <input type="text" class="form-control" name="title"
                value="<?php echo $row['title'];?>" required />
          </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('details'); ?></label>
        <div class="col-sm-5">
          <textarea required class="form-control" rows="5" name="details"><?php echo $row['description'];?></textarea>
        </div>
      </div>
      <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo get_phrase('given_date'); ?></label>
          <div class="col-sm-5">
              <input type="text" class="datepicker form-control" name="given_date"
                value="<?php echo date('m/d/Y', strtotime($row['given_date']));?>" required />
          </div>
      </div>    

	  <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo get_phrase('due_date'); ?></label>
          <div class="col-sm-5">
              <input type="text" class="datepicker form-control" name="due_date"
                value="<?php echo date('m/d/Y', strtotime($row['due_date']));?>" required />
          </div>
      </div>

      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-5">
              <button type="submit" id="submit_button" class="btn btn-info"><?php echo get_phrase('update'); ?></button>
          </div>
      </div>
      </form>
  </div>
</div>
<?php endforeach; ?>


<script type="text/javascript">

function get_class_section() {
		var class_id = $("#class_id").val();
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {
                $('#section_id').html(response);
            }
        });         
	  }  
	   
	}	
	function get_class_subject() {
		
		var class_id =  jQuery('#class_id').val();
		var section_id =  jQuery('#section_id').val();
		if (class_id !== '' && section_id !='') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
            success: function(response)
            {
                $('#subject_id').html(response);				
				 
            }			
			
        });         
	  }
	  
	}

</script>