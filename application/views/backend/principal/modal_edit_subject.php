<?php 
$edit_data		=	$this->db->get_where('subject' , array('subject_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
$class_id = $row['class_id'];
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_subject');?>
            	</div>
            </div>
			<div class="panel-body">
                <?php echo form_open(site_url('admin/subject/do_update/'.$row['subject_id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                <div class="padded">
							                          						
							<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
								
                                <div class="col-sm-5">
								
									<select required class="form-control" name="name" >
										<?php 
										$school_id = $this->session->userdata('school_id');
										$class_subjects = $this->db->get_where('class_subjects' , array('school_id' => $school_id))->result_array();
										foreach($class_subjects as $sub):
										?>
											<option value="<?php echo $sub['id'];?>"
												<?php if($row['class_subject'] == $sub['id'])echo 'selected';?>>
													<?php echo $sub['subject'];?>
														</option>
										<?php
										endforeach;
										?>
									</select>                                   
                                </div>
                            </div>				
							
				
				
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
					
                    <div class="col-sm-5 controls">
                        <select required class="form-control" id="class_id" name="class_id" onchange="return section_select(this.value ,'<?php echo $param2;?>')" >
                            <?php 
                            $school_id = $this->session->userdata('school_id');
							$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                            foreach($classes as $row2):
                            ?>
                                <option value="<?php echo $row2['class_id'];?>"
                                    <?php if($class_id == $row2['class_id'])echo 'selected';?>>
                                        <?php echo $row2['name'];?>
                                            </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
				<div class="form-group" id="section_selection_edit"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('teacher');?></label>
                    <div class="col-sm-5 controls">
                        <select required name="teacher_id" id="teacher_id"  class="form-control">
                            <?php 
                            $principals = $this->db->get_where('principal' , array('school_id' => $school_id))->result_array(); 
							$teachers = $this->db->get_where('teacher' , array('school_id' => $school_id))->result_array();
							foreach($principals as $prin):
								?>
								<option value="p-<?php echo $prin['principal_id'];?>">
										Principal-<?php echo $prin['name'];?>
										</option>
							<?php
							endforeach;
                            foreach($teachers as $row2):
                            ?>
                                <option value="t-<?php echo $row2['teacher_id'];?>"
                                    <?php if($row['teacher_id'] == $row2['teacher_id'])echo 'selected';?>>
                                        <?php echo $row2['name'];?>
                                            </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
			</div>	
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_subject');?></button>
                    </div>
                 </div>
        		</form>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>

<script type="text/javascript">
section_select(<?php echo $class_id;?> ,<?php echo $param2;?>);
    function section_select(class_id,subject_id) {
        $.ajax({
            url: '<?php echo site_url('admin/section_edit/');?>' + class_id + '/' + subject_id ,
            success: function(response)
            {
                jQuery('#section_selection_edit').html(response);
            }
        });
    }
	

</script>
