<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_staff');?>
            	</div>
            </div>
			<div class="panel-body">

      <?php echo form_open(site_url('principal/staff/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>			

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('role');?></label>
							<div class="col-sm-5">
							<select name="role" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="1"><?php echo get_phrase('secretary');?></option>
                              <option value="2"><?php echo get_phrase('Dean of Studies');?></option>
							   <option value="3"><?php echo get_phrase('Nurse');?></option>
                              <option value="4"><?php echo get_phrase('Discipline Master');?></option>
							    <option value="5"><?php echo get_phrase('none');?></option>
                          </select>
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

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="" >
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
						<div class="col-sm-5">
							<input type="number" class="form-control" name="phone" value="" data-validate="required">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" value="" data-validate="required">
						</div>
					</div>	

							<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('confirm_password');?></label>
						<div class="col-sm-5">
							<input type="password" class="form-control" name="confirm_password" value="" data-validate="required">
						</div>
					</div>	

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
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('school');?></label>
                        
						<div class="col-sm-5">
							<select name="school_id" class="form-control" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$school_id = $this->session->userdata('school_id');
									$schooles = $this->db->get_where('school' , array('school_id' => $school_id))->result_array();									 
									foreach($schooles as $row):
										?>
                                		<option value="<?php echo $row['school_id'];?>">
												<?php echo $row['school_name'];?>
                                                </option>
                                    <?php
									endforeach;
								?>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                                <div class="col-sm-5">
                                    <select name="status" class="uniform" style="width:100%;">
                                    	<option value="1"><?php echo get_phrase('active');?></option>
                                    	<option value="2"><?php echo get_phrase('suspend');?></option>
                                    </select>
                                </div>
                    </div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_staff');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>