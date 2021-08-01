<?php 
$edit_data		=	$this->db->get_where('class_subjects' , array('id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_class_subject');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/class_subjects/do_update/'.$row['id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <div class="form-group">							
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject_type');?></label>			
                                <div class="col-sm-5">								
									<select name="is_elective" class="uniform" style="width:100%;height: 35px;border: 1px solid #ebebeb;" onchange = "return val(this.value);">									    
                                    	<option>Select subject type</option>
										<option value="0"><?php echo get_phrase('Main Subject');?></option>
                                    	<option value="1"><?php echo get_phrase('Elective Subject');?></option>
                                    	<option value="2">Non Examinable Subject</option>
                                    </select>                                   
                                </div>
                    </div>

					<div class="" id = "extradiv" style ="display:none">
						<label class="col-sm-3 control-label"><?php echo get_phrase('subject_group');?></label>
						<div class="form-group">
								
                                <div class="col-sm-5">
                                    <select name="subject_group" class="uniform" style="width:50%;height: 35px;border: 1px solid #ebebeb;" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">									    
                                    	<option>Select Group</option>
										<option value="g1"><?php echo get_phrase('group_1');?></option>
                                    	<option value="g2"><?php echo get_phrase('group_2');?></option>
                                    	<option value="g3"><?php echo get_phrase('group_3');?></option>
                                    	<option value="g4"><?php echo get_phrase('group_4');?></option>
                                    	<option value="g5"><?php echo get_phrase('group_5');?></option>
                                    	<option value="g6"><?php echo get_phrase('group_6');?></option>
                                    	<option value="g7"><?php echo get_phrase('group_7');?></option>
                                    </select>
                                </div>
                        </div>
                        </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('subject_name');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="subject" value="<?php echo $row['subject'];?>"/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('subject_code');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="subject_code" value="<?php echo $row['subject_code'];?>"/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('total_marks_out_of');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="total_marks_out_of" value="<?php echo $row['total_marks_out_of'];?>"/>
                        </div>
                    </div>
					<?php  if($row['parts'] == '2'){ ?>
					
					<?php  if($row['parts'] == '2'){
							$style='style="display: block;"';
							}else{
							$style='style="display: none;"';
							}
					?>
					<div class="subject_part_section" <?php echo $style; ?>>	
						<div class="padded">   
							<label class="col-sm-3 control-label"><?php echo get_phrase('Subject Parts');?></label>				
							<div class="form-group">
								<div class="col-sm-5">	
								<?php if($row['parts'] == '2') $checked = 'checked="checked"' ?>								
									<input type="checkbox" name="parts" value="2" <?php echo $checked; ?>> 									
								</div>							
							</div>							
                        </div>
						
						<div id="sub_parts" class="padded">                            
							<div class="form-group">							
								<label class="col-sm-3 control-label"><?php echo get_phrase('part1');?></label>
                                <div class="col-sm-3">
									<input type="text" class="form-control" name="part1" value="<?php echo $row['part1'];?>"/>					
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part1_mark" value="<?php echo $row['part1_mark'];?>"/>					
								</div>								
							</div> 
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part2');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part2" value="<?php echo $row['part2'];?>"/>
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part2_mark" value="<?php echo $row['part2_mark'];?>"/>					
								</div>								
							</div>
		
                        </div>
					</div>
					<?php } ?>
					
					<?php  if($row['parts'] == '3'){ ?>
					
					<?php  if($row['parts'] == '3'){
							$style='style="display: block;"';
							}else{
							$style='style="display: none;"';
							}
					?>
					<div class="subject_part_section" <?php echo $style; ?>>	
						<div class="padded">   
							<label class="col-sm-3 control-label"><?php echo get_phrase('Subject Parts');?></label>				
							<div class="form-group">
								<div class="col-sm-5">	
								<?php if($row['parts'] == '3') $checked = 'checked="checked"' ?>								
									<input type="checkbox" name="parts" value="3" <?php echo $checked; ?>> 									
								</div>							
							</div>							
                        </div>
						
						<div id="sub_parts" class="padded">                            
							<div class="form-group">							
								<label class="col-sm-3 control-label"><?php echo get_phrase('part1');?></label>
                                <div class="col-sm-3">
									<input type="text" class="form-control" name="part3" value="<?php echo $row['part3'];?>"/>					
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part3_mark" value="<?php echo $row['part3_mark'];?>"/>					
								</div>								
							</div> 
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part2');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part4" value="<?php echo $row['part4'];?>"/>
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part4_mark" value="<?php echo $row['part4_mark'];?>"/>					
								</div>								
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part3');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part5" value="<?php echo $row['part5'];?>"/>
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part5_mark" value="<?php echo $row['part5_mark'];?>"/>					
								</div>								
							</div>
                        </div>
					</div>
					
					<?php  } ?>
					
					<?php  if($row['parts'] == '4'){ ?>
					
					<?php  if($row['parts'] == '4'){
							$style='style="display: block;"';
							}else{
							$style='style="display: none;"';
							}
					?>
					<div class="subject_part_section" <?php echo $style; ?>>	
						<div class="padded">   
							<label class="col-sm-3 control-label"><?php echo get_phrase('Subject Parts');?></label>				
							<div class="form-group">
								<div class="col-sm-5">	
								<?php if($row['parts'] == '4') $checked = 'checked="checked"' ?>								
									<input type="checkbox" name="parts" value="4" <?php echo $checked; ?>> 									
								</div>							
							</div>							
                        </div>
						
						<div id="sub_parts" class="padded">                            
							<div class="form-group">							
								<label class="col-sm-3 control-label"><?php echo get_phrase('part1');?></label>
                                <div class="col-sm-3">
									<input type="text" class="form-control" name="part6" value="<?php echo $row['part6'];?>"/>					
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part6_mark" value="<?php echo $row['part6_mark'];?>"/>					
								</div>								
							</div> 
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part2');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part7" value="<?php echo $row['part7'];?>"/>
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part7_mark" value="<?php echo $row['part7_mark'];?>"/>					
								</div>								
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part3');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part8" value="<?php echo $row['part8'];?>"/>
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part8_mark" value="<?php echo $row['part8_mark'];?>"/>					
								</div>								
							</div>
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part3');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part9" value="<?php echo $row['part9'];?>"/>
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="part9_mark" value="<?php echo $row['part9_mark'];?>"/>					
								</div>								
							</div>
							
							
                        </div>
					</div>
					<?php  } ?>
					
					
					
					
					
					
					
					
            		<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_class_subject');?></button>
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

<script>
function val(x)
{
    if (x =="1" )
    {
            document.getElementById("extradiv").style.display ="block";
    }else
    {
            document.getElementById("extradiv").style.display = "none";
    }

}
	
</script>


