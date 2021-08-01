<?php 
$edit_data		=	$this->db->get_where('class_routine' , array('class_routine_id' => $param2) )->result_array();
?>
<div class="tab-pane box active" id="edit" style="padding: 5px">
    <div class="box-content">
        <?php foreach($edit_data as $row):?>
        <?php echo form_open(site_url('admin/class_routine/do_update/'.$row['class_routine_id'])  , array('class' => 'form-horizontal validatable','target'=>'_top'));?>
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('Type');?></label>
					<div class="col-sm-5">
						<label><input type="radio" class="type" name="type" class="form-control" <?php echo ($row['type'] ==1)?'checked':'';?> value='1' > Subject </label> <label><input type="radio" class="type" name="type" class="form-control" <?php echo ($row['type'] ==2)?'checked':'';?> value='2'> Break </label>         
					</div>
				</div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                    <div class="col-sm-5">
                        <select id="class_id" name="class_id" class="form-control selectboxit" onchange="section_subject_select(this.value , <?php echo $param2;?>)">
                            <?php 
                            $school_id = $this->session->userdata('school_id');
							$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                            foreach($classes as $row2):
                            ?>
                                <option value="<?php echo $row2['class_id'];?>" <?php if($row['class_id']==$row2['class_id'])echo 'selected';?>>
                                    <?php echo $row2['name'];?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div id="section_subject_edit_holder"></div>
				
				<div id="break_div" class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('break_title');?></label>
					<div class="col-sm-5">
						<input type="text" id="break_title" name="break_title" class="form-control" value="<?php echo $row['break_title'];?>">                
					</div>
				</div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('day');?></label>
                    <div class="col-sm-5">
                        <select name="day" class="form-control selectboxit">
                            <option value="saturday" 	<?php if($row['day']=='saturday')echo 'selected="selected"';?>>saturday</option>
                            <option value="sunday" 		<?php if($row['day']=='sunday')echo 'selected="selected"';?>>sunday</option>
                            <option value="monday" 		<?php if($row['day']=='monday')echo 'selected="selected"';?>>monday</option>
                            <option value="tuesday" 	<?php if($row['day']=='tuesday')echo 'selected="selected"';?>>tuesday</option>
                            <option value="wednesday" 	<?php if($row['day']=='wednesday')echo 'selected="selected"';?>>wednesday</option>
                            <option value="thursday" 	<?php if($row['day']=='thursday')echo 'selected="selected"';?>>thursday</option>
                            <option value="friday" 		<?php if($row['day']=='friday')echo 'selected="selected"';?>>friday</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('starting_time');?></label>
                    <div class="col-sm-9">
                        <?php 
                            if($row['time_start'] < 13)
                            {
                                $time_start		=	$row['time_start'];
                                $time_start_min =   $row['time_start_min'];
                                $starting_ampm	=	1;
                            }
                            else if($row['time_start'] > 12)
                            {
                                $time_start		=	$row['time_start'] - 12;
                                $time_start_min =   $row['time_start_min'];
                                $starting_ampm	=	2;
                            }
                            
                        ?>
                        <div class="col-md-3">
                            <select name="time_start" class="form-control" required>
                            <option value=""><?php echo get_phrase('hour');?></option>
                                <?php for($i = 0; $i <= 12 ; $i++):?>
                                    <option value="<?php echo $i;?>" <?php if($i ==$time_start)echo 'selected="selected"';?>>
                                        <?php echo $i;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="time_start_min" class="form-control" required>
                            <option value=""><?php echo get_phrase('minutes');?></option>
                                <?php for($i = 0; $i <= 11 ; $i++):?>
                                    <option value="<?php echo $i * 5;?>" <?php if (($i * 5) == $time_start_min) echo 'selected';?>><?php echo $i * 5;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="starting_ampm" class="form-control selectboxit">
                                <option value="1" <?php if($starting_ampm	==	'1')echo 'selected="selected"';?>>am</option>
                                <option value="2" <?php if($starting_ampm	==	'2')echo 'selected="selected"';?>>pm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('ending_time');?></label>
                    <div class="col-sm-9">
                        
                        
                        <?php 
                            if($row['time_end'] < 13)
                            {
                                $time_end		=	$row['time_end'];
                                $time_end_min   =   $row['time_end_min'];
                                $ending_ampm	=	1;
                            }
                            else if($row['time_end'] > 12)
                            {
                                $time_end		=	$row['time_end'] - 12;
                                $time_end_min   =   $row['time_end_min'];
                                $ending_ampm	=	2;
                            }
                            
                        ?>
                        <div class="col-md-3">
                            <select name="time_end" class="form-control" required>
                            <option value=""><?php echo get_phrase('hour');?></option>
                                <?php for($i = 0; $i <= 12 ; $i++):?>
                                    <option value="<?php echo $i;?>" <?php if($i ==$time_end)echo 'selected="selected"';?>>
                                        <?php echo $i;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="time_end_min" class="form-control" required>
                            <option value=""><?php echo get_phrase('minutes');?></option>
                                <?php for($i = 0; $i <= 11 ; $i++):?>
                                    <option value="<?php echo $i * 5;?>" <?php if (($i * 5) == $time_end_min) echo 'selected';?>><?php echo $i * 5;?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="ending_ampm" class="form-control selectboxit">
                                <option value="1" <?php if($ending_ampm	==	'1')echo 'selected="selected"';?>>am</option>
                                <option value="2" <?php if($ending_ampm	==	'2')echo 'selected="selected"';?>>pm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-5">
                      <button id="edit_class_routine" type="submit" class="btn btn-info"><?php echo get_phrase('edit_class_routine');?></button>
                  </div>
                </div>
        </form>
        <?php endforeach;?>
    </div>
</div>

<script type="text/javascript">
    function section_subject_select(class_id , class_routine_id) {
		var type = $("input[name='type']:checked").val();
        $.ajax({
            url: '<?php echo site_url('admin/section_subject_edit/');?>' + class_id + '/' + class_routine_id ,
            success: function(response)
            {
                jQuery('#section_subject_edit_holder').html(response);
				if(type == 1){ $('#subject_div').css('display','');$('#break_div').css('display','none');  }
				else{ $('#break_div').css('display',''); $('#subject_div').css('display','none'); }
            }
        });
    }
	
	function check_validation(){
		
		var class_id = $('#class_id').val();
		var section_id = $('#section_id').val();
		var subject_id = $('#subject_id').val();
		var starting_hour = $('#starting_hour').val();
		var starting_minute = $('#starting_minute').val();
		var ending_hour = $('#ending_hour').val();
		var ending_minute = $('#ending_minute').val();
		var break_title = $('#break_title').val(); 
		if(class_id !== '' && section_id !== '' && starting_hour !== '' && starting_minute  !== '' && ending_hour  !== '' && ending_minute !== ''){
				 
				if(subject_id == '' && break_title =='') $("#edit_class_routine").attr('disabled', 'disabled');
				else $('#edit_class_routine').removeAttr('disabled');
			}    
	}
	$('.type').change(function() {  
		if (this.value == 1) {
			 $('#subject_div').css('display','');$('#break_div').css('display','none'); 
				
		}
		else if (this.value == 2) {
			$('#break_div').css('display',''); $('#subject_div').css('display','none'); 
		}
	});
	$('#class_id').change(function() {
		 
		check_validation();
	});
	$('#subject_id').change(function() {
		var subject_id = $('#subject_id').val();
		if(subject_id>0) $('#break_title').val('');
		check_validation();
	});
	$('#break_title').blur(function() {
		var subject_id = $('#subject_id').val();
		if(subject_id>0) $('#break_title').val(''); 
		check_validation();
	});
	$('#starting_hour').change(function() {
		 
		check_validation();
	});
	$('#starting_minute').change(function() {
		 
		check_validation();
	});
	$('#ending_hour').change(function() {
		 
		check_validation();
	});
	$('#ending_minute').change(function() {
		 
		check_validation();
	});

</script>

<script type="text/javascript">
 
    $(document).ready(function() {
		
		$('#break_div').css('display','none');
        var class_id = $('#class_id').val();
        var class_routine_id = '<?php echo $param2;?>';
        section_subject_select(class_id,class_routine_id);
        
    }); 
</script>

