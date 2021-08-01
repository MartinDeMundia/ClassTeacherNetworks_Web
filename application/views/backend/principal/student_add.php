<div class="row">
	<div class="col-md-8">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('addmission_form');?>
            	</div>
            </div>
			<div class="panel-body">

                <?php echo form_open(site_url('admin/student/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>					
					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('school');?></label>
						<div class="col-sm-5">
							<?php 
							$school_id = $this->session->userdata('school_id');
							
							echo $this->crud_model->get_type_name_by_id('school',$school_id,'school_name');
							
							?>
							
							<input type="hidden" name="school_id"  value="<?php echo $school_id;?>" />						
						</div>
                    </div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
						</div>
					</div>
					

					<!--div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('parent');?></label>

						<div class="col-sm-5">
							<select name="parent_id" class="form-control select2" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php
								$parents =  $this->db->get_where('parent', array('status' => 1))->result_array();
							
								foreach($parents as $row):
									?>
                            		<option value="<?php echo $row['parent_id'];?>">
										<?php echo $row['name'].' Mobile('.$row['phone'].')';?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div>
					</div-->

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>

						<div class="col-sm-5">
							<select name="class_id" class="form-control" data-validate="required" id="class_id"
								data-message-required="<?php echo get_phrase('value_required');?>"
									onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php
								$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['class_id'];?>">
											<?php echo $row['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
		                    <div class="col-sm-5">
		                        <select name="section_id" class="form-control" id="section_selector_holder" data-validate="required" 
								data-message-required="<?php echo get_phrase('value_required');?>"
		                            <option value=""><?php echo get_phrase('select_class_first');?></option>

			                    </select>
			                </div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Admission_number');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="student_code" value="" data-validate="required" id="class_id"
								data-message-required="<?php echo get_phrase('value_required');?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" value="" data-start-view="2">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>

						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"><?php echo get_phrase('male');?></option>
                              <option value="female"><?php echo get_phrase('female');?></option>
                          </select>
						</div>
					</div>

					<!--div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="" >
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="" >
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control" name="email" value="">
						</div>
					</div-->					

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>

						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
					
					
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Entry Marks');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="emarks" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Date of Admission');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="date_of_admission" value="" data-start-view="2">
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('House');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="house_no"  value="" autofocus>
						</div>
					</div>
					
					
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Religion');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="religion" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
						</div>
					</div>


                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
		<blockquote class="blockquote-blue">
			<p>
				<strong>Student Admission Notes</strong>
			</p>
			<p>
				Admitting new students will automatically create an enrollment to the selected class in the running session.
				Please check and recheck the informations you have inserted because once you admit new student, you won't be able
				to edit his/her class,roll,section without promoting to the next session.
			</p>
		</blockquote>
	</div>

</div>

<script type="text/javascript">

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id + '/1' ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

</script>
