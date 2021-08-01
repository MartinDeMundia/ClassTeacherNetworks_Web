<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_parent');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('principal/parent/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="">
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
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="number" class="form-control" name="phone" value="" data-validate="required">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('profession');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="profession" value="">
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
							<input type="hidden" name="student_id" value="<?php echo $student_id;?>" />
							<button type="submit" class="btn btn-default"><?php echo get_phrase('add_parent');?></button>
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