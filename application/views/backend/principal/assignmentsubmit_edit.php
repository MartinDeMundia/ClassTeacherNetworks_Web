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
<?php echo form_open(site_url('principal/assignments/do_submit/'.$row['assignment_id']), array(
        'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data',
          'target' => '_top')); ?>
	<div class="col-md-1"></div>
	<div class="col-md-5">
  		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
			  <div class="col-sm-5">
			<select required name="class_id" class="form-control" id = 'class_id' >
				 
				<?php 
								 							
				$classes = $this->db->get_where('class' , array('class_id' => $class_id))->result_array();
										
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
			<label class="col-sm-3 control-label" ><?php echo get_phrase('section');?></label>
			  <div class="col-sm-5">
			<select required name="section_id" id="section_id" class="form-control" >
				 
				<?php 				
			 		
				$sections = $this->db->get_where('section' , array('section_id' => $section_id))->result_array();
			
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
			<select required name="subject_id" id="subject_id" class="form-control" >
				 
				<?php 				 
				 		
				$subjects = $this->db->get_where('subject' , array('subject_id' => $subject_id))->result_array();
				 
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
              <input readonly type="text" class="form-control" name="title"
                value="<?php echo $row['title'];?>" required />
          </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('details'); ?></label>
        <div class="col-sm-5">
          <textarea readonly required class="form-control" rows="5" name="details"><?php echo $row['description'];?></textarea>
        </div>
      </div>
      <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo get_phrase('given_date'); ?></label>
          <div class="col-sm-5">
              <input readonly type="text" class=" form-control" name="given_date"
                value="<?php echo date('m/d/Y', strtotime($row['given_date']));?>" required />
          </div>
      </div>    

	  <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo get_phrase('due_date'); ?></label>
          <div class="col-sm-5">
              <input readonly type="text" class=" form-control" name="due_date"
                value="<?php echo date('m/d/Y', strtotime($row['due_date']));?>" required />
          </div>
      </div>     
    
  </div>
  <div class="col-md-5">
  <?php
  
		$studentsids = $this->db->select("GROUP_CONCAT(student_id) as students")->where('assignment', $assignment_id)->where('status >', 0)->group_by("assignment")->get('assignment_submit')->row()->students;
		$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;		 
		if($studentsids!='')
			
			$students = $this->db->where('class_id', $class_id)->where('section_id', $section_id)->where('year', $running_year )->where_not_in('student_id', explode(',',$studentsids))->get('enroll')->result_array();
			
		else			
  
		$students = $this->db->get_where('enroll' , array(
            'class_id' => $class_id ,'section_id' => $section_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
		
		$frmdiv =  '<div class="form-group">
                <label class="col-sm-3 control-label">' . get_phrase('assignment_non_submit_students_list') . '</label>
                <div class="col-sm-9">';
		$is_student=0;
        foreach ($students as $row) {
             $name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
           $frmdiv.= '<div class="checkbox">
                    <label><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name .'</label>
                </div>';
			$is_student=1;
        }
		
		if($is_student == 1){
			
			echo $frmdiv;
			
			echo '<input type="hidden" name="assignment" value="' . $assignment_id . '"><br><button type="button" class="btn btn-default" onClick="select()">'.get_phrase('select_all').'</button>';
			echo '<button style="margin-left: 5px;" type="button" class="btn btn-default" onClick="unselect()"> '.get_phrase('select_none').' </button>';
			echo '</div></div> <div class="form-group">
			  <label class="col-sm-3 control-label">Submit On</label><div class="col-sm-5">
				  <input type="text" class="datepicker form-control" name="submit_on" value="" required />
			  </div> </div>';		  
			echo '<div class="form-group">
				  <div class="col-sm-offset-3 col-sm-5">
					  <button type="submit" id="submit_button" class="btn btn-info">Submit</button>
				  </div>
			  </div>';
		}
		else{
			
			echo '<div class="form-group"> <div class="col-sm-9">All students have submitted assignments</div> </div>';
		}
	?>
  
  </div>
     </form>
  
</div>
<?php endforeach; ?>


<script type="text/javascript">

	function select() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = true ;
			}

		//alert('asasas');
	}
	function unselect() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = false ;
			}
	}
</script>