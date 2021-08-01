<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_teacher');?>
            	</div>
            </div>
			<div class="panel-body">

      <?php echo form_open(site_url('principal/teacher/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('tsc_number');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="tsc_number" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>	

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('role');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="role" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="">
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
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control" name="email" value="" data-validate="required">
						</div>
					</div>

					<!--div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="password" value="" data-validate="required" id="password">
						</div>
						<div class="col-sm-3">
						   <div class="weak_pswd" style="display:none;">
                           <meter value="0.3">60%</meter>
						   <p>Short</p>
						   </div>
						   
						   <div class="med_pswd" style="display:none;">
                           <meter value="0.5">60%</meter>
						   <p>Medium</p>
						   </div>
						   
						   <div class="strong_pswd" style="display:none;">
                           <meter value="0.8">60%</meter>
						   <p>Strong</p>
						   </div>
						   
						   <div class="great_pswd" style="display:none;">
                           <meter value="1">60%</meter>
						   <p>Great</p>
						   </div>
						   
						   
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
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('school');?></label>
                        
						<div class="col-sm-5">
							<select name="school_id" class="form-control" required>              
                              <?php 
									$schooles = $this->db->get_where('school', array('school_id' => $this->session->userdata('school_id')))->result_array();
									 
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
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_teacher');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){

        $("#password").keyup(function() {

           
			if(this.value.match(/[a-z]+/)) {
                //strength++;
				$('.weak_pswd').css("display","block");
				$('.med_pswd').css("display","none");
$('.strong_pswd').css("display","none");
$('.great_pswd').css("display","none");
            }
			
			 if(this.value.match(/[0-9]+/)) {
                $('.weak_pswd').css("display","block");
				$('.med_pswd').css("display","none");
$('.strong_pswd').css("display","none");
$('.great_pswd').css("display","none");
            }
			
			 if(this.value.match(/^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/)) {
                $('.med_pswd').css("display","block");
				$('.weak_pswd').css("display","none");
$('.strong_pswd').css("display","none");
$('.great_pswd').css("display","none");
            }
			
			 if(this.value.match(/^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/)) {
                $('.strong_pswd').css("display","block");
				$('.weak_pswd').css("display","none");
$('.med_pswd').css("display","none");
$('.great_pswd').css("display","none");
            }
			
			 if(this.value.match(/^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/)) {
                $('.great_pswd').css("display","block");
				$('.weak_pswd').css("display","none");
$('.strong_pswd').css("display","none");
$('.med_pswd').css("display","none");
            }


           
        });
     });


</script>
<style>
.weak_pswd meter::-webkit-meter-optimum-value {
  background: red;
}
.weak_pswd meter::-moz-meter-bar { /* Firefox Pseudo Class */
  background: red;
}

.med_pswd meter::-webkit-meter-optimum-value {
  background: orange;
}
.med_pswd meter::-moz-meter-bar { /* Firefox Pseudo Class */
  background: orange;
}

.strong_pswd meter::-webkit-meter-optimum-value {
  background: #3EA055;
}
.strong_pswd meter::-moz-meter-bar { /* Firefox Pseudo Class */
  background: #3EA055;
}

.great_pswd meter::-webkit-meter-optimum-value {
  background: green;
}
.great_pswd meter::-moz-meter-bar { /* Firefox Pseudo Class */
  background: green;
}
</style>
