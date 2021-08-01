<meta http-equiv="x-ua-compatible" content="IE=10">	  
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/pick-a-color-master/build/1.1.5/css/bootstrap-2.2.2.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/pick-a-color-master/build/1.1.5/css/pick-a-color-1.1.5.min.css"> 	
<style>
select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input{
height:auto !important;
}
div.pick-a-color-markup .hex-pound{
height:auto !important;
}
.tab-content{
overflow:hidden !important;
}
.form-horizontal .control-label{
width:30% !important;
}
</style>
<div class="row">
	<div class="col-md-12">

    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-calendar"></i>
					<?php echo get_phrase('Manage School Timings');?>
                    	</a></li>
                    	
             <li class="">
            	<a href="#assignlessons" data-toggle="tab"><i class="entypo-book"></i>
					Assign no. of lessons per subject
                    	</a></li>
                    	
                    	
                    	
            <li class="">
            	<a href="#assigncodes" data-toggle="tab"><i class="entypo-water"></i>
					Assign teachers code (key identifiers)
                    	</a></li>
                    	
		</ul>
		<!------CONTROL TABS END------>
		<link href="<?php echo base_url(); ?>assets/js/datepic/bootstrap-datetimepicker.css" rel="stylesheet">
		<script src="<?php echo base_url(); ?>assets/js/datepic/moment-with-locales.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/datepic/bootstrap-datetimepicker.js"></script>
		<script type="text/javascript">
		$(function () {
		//$('#datetimepicker3').datetimepicker({
		// format: 'LT'
		//disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 7 })], [moment({ h: 10 }), moment({ h: 24 })]]
		//});
		});
		</script> 
		
		
		
		<div class="tab-content">
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content">
				<?php


                    foreach($edit_data as $row): 
                    	//svar_dump($edit_data); exit();
                        ?>
                        <?php echo form_open(site_url('principal/manage_timetable/update_timetable_info') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
                           

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Class Start Time (H : M )</label>
                                <div class="col-sm-4">	<br/>								
										<div class='input-group date' id='datetimepicker3' style='margin-top:-3%'>
											<input type='text' class="form-control" name="start_time" id="start_time" required value="<?php echo $row['start_time'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
							</div>


							<div class="form-group">
                                <label class="col-sm-4 control-label">Class End Time (H : M )</label>
                                <div class="col-sm-4">	<br/>								
										<div class='input-group date' id='datetimepicker3' style='margin-top:-3%'>
											<input type='text' class="form-control" name="end_time" id="end_time" required value="<?php echo $row['end_time'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
							</div>


							<div class="form-group">
                                <label class="col-sm-3 control-label">Lesson Period Duration (M)</label>
                                <div class="col-sm-2">	<br/>								
										<div class='input-group date' id='div_period_duration' style='margin-top:-3%'>
											<input type='text' class="form-control" name="period_duration" id="period_duration" required value="<?php echo $row['period_duration'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
                                
                                <!-- <div class="col-sm-5">
									<select class="form-control" name="period_duration" id="period_duration" required>
										<option value="">Select the Period Duration</option>
										<option value="30" <?php if ($row['period_duration'] == '30') { echo 'selected';} ?> >30</option>
										<option value="35" <?php if ($row['period_duration'] == '35') { echo 'selected';} ?> >35</option>
										<option value="40" <?php if ($row['period_duration'] == '40') { echo 'selected';} ?> >40</option>
										<option value="45" <?php if ($row['period_duration'] == '45') { echo 'selected';} ?> >45</option>
										<option value="50" <?php if ($row['period_duration'] == '50') { echo 'selected';} ?> >50</option>
										<option value="55" <?php if ($row['period_duration'] == '55') { echo 'selected';} ?> >55</option>
									</select>
                                </div>-->



                            </div>





<div class="form-group">
	<div class="col-md-1">
		&nbsp;
	</div>
<div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-6 control-label">Short Break Start Time (H : M)</label>
                                <div class="col-sm-6">	<br/>								
										<div class='input-group date' id='datetimepicker3' style='margin-top:-10%'>
											<input type='text' class="form-control" name="short_break_startime" id="short_break_startime" required value="<?php echo $row['short_break_startime'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
							</div>
</div>
<div class="col-md-4">


							<div class="form-group">
                                <label class="col-sm-6 control-label">Short Break Duration</label>
                                
                                <div class="col-sm-6">	<br/>								
										<div class='input-group date' id='div_short_break_duration' style='margin-top:-10%'>
											<input type='text' class="form-control" name="short_break_duration" id="short_break_duration" required value="<?php echo $row['short_break_duration'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
                                
                               <!--<div class="col-sm-6">
                                   <select class="form-control" name="short_break_duration" id="short_break_duration" required>
										<option value="">Select the Break Duration</option>
										<option value="5" <?php if ($row['short_break_duration'] == '5') { echo 'selected';} ?> >5 mins</option>
										<option value="10" <?php if ($row['short_break_duration'] == '10') { echo 'selected';} ?> >10 mins</option>
										<option value="15" <?php if ($row['short_break_duration'] == '15') { echo 'selected';} ?> >15 mins</option>
										<option value="20" <?php if ($row['short_break_duration'] == '20') { echo 'selected';} ?> >20 mins</option>
										<option value="25" <?php if ($row['short_break_duration'] == '25') { echo 'selected';} ?> >25 mins</option>
									</select>
                                </div>-->
                                
                                
                            </div>

</div>

</div>



<div class="form-group">
	<div class="col-md-1">
		&nbsp;
	</div>
<div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-6 control-label">Tea Break Start Time (H : M)</label>
                                <div class="col-sm-6">	<br/>								
										<div class='input-group date' id='datetimepicker3' style='margin-top:-10%'>
											<input type='text' class="form-control" name="tea_break_startime" id="tea_break_startime" required value="<?php echo $row['tea_break_startime'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
							</div>
</div>
<div class="col-md-4">


							<div class="form-group">
                                <label class="col-sm-6 control-label">Tea Break Duration</label>
                                
                                
                                <div class="col-sm-6">	<br/>								
										<div class='input-group date' id='div_tea_break_duration' style='margin-top:-10%'>
											<input type='text' class="form-control" name="tea_break_duration" id="tea_break_duration" required value="<?php echo $row['tea_break_duration'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
                                
                                <!--<div class="col-sm-6">
                                   <select class="form-control" name="tea_break_duration" id="tea_break_duration" required>
										<option value="">Select the Break Duration</option>
										<option value="10" <?php if ($row['tea_break_duration'] == '10') { echo 'selected';} ?> >10 mins</option>
										<option value="15" <?php if ($row['tea_break_duration'] == '15') { echo 'selected';} ?> >15 mins</option>
										<option value="20" <?php if ($row['tea_break_duration'] == '20') { echo 'selected';} ?> >20 mins</option>
										<option value="25" <?php if ($row['tea_break_duration'] == '25') { echo 'selected';} ?> >25 mins</option>
									</select>
                                </div>-->
                                
                                
                                
                            </div>

</div>

</div>



<div class="form-group">
	<div class="col-md-1">
		&nbsp;
	</div>
<div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-6 control-label">Lunch Break Start Time (H : M)</label>
                                <div class="col-sm-6">	<br/>								
										<div class='input-group date' id='datetimepicker3' style='margin-top:-10%'>
											<input type='text' class="form-control" name="lunch_break_startime" id="lunch_break_startime" required value="<?php echo $row['lunch_break_startime'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
							</div>
</div>
<div class="col-md-4">


							<div class="form-group">
                                <label class="col-sm-6 control-label">Lunch Break Duration</label>
                                
                                <div class="col-sm-6">	<br/>								
										<div class='input-group date' id='div_lunch_break_duration' style='margin-top:-10%'>
											<input type='text' class="form-control" name="lunch_break_duration" id="lunch_break_duration" required value="<?php echo $row['lunch_break_duration'];?>"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
								</div>
                                
                                <!--<div class="col-sm-6">
                                    <select class="form-control" name="lunch_break_duration" id="lunch_break_duration" required>
										<option value="">Select the Lunch Duration</option>
										<option value="30" <?php if ($row['lunch_break_duration'] == '30') { echo 'selected';} ?> >30 mins</option>
										<option value="35" <?php if ($row['lunch_break_duration'] == '35') { echo 'selected';} ?> >35 mins</option>
										<option value="40" <?php if ($row['lunch_break_duration'] == '40') { echo 'selected';} ?> >40 mins</option>
										<option value="45" <?php if ($row['lunch_break_duration'] == '45') { echo 'selected';} ?> >45 mins</option>
										<option value="50" <?php if ($row['lunch_break_duration'] == '50') { echo 'selected';} ?> >50 mins</option>
										<option value="55" <?php if ($row['lunch_break_duration'] == '55') { echo 'selected';} ?> >55 mins</option>
									</select>
                                </div>-->
                            </div>

</div>

</div>

			



                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('update_school_start_time');?></button>
                              </div>
								</div>
                        </form>
						<?php
                    endforeach;                    
                    ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->
            
            
            
            <div class="tab-pane box" id="assignlessons" style="padding: 5px">
                <div class="box-content">
                
                
                    <div id="subject1" class="form-group" style="margin-bottom: 15px;">
                        <select name="subject_id" id="subject_holder" class="form-control">
                            <?php
                            $query_subj = $this->db->query("                                    
                            SELECT 
                                *
                            FROM
                                class_subjects cs
                                    JOIN
                                subject s ON s.class_subject = cs.id
                                    AND cs.school_id = '".$this->session->userdata('school_id')."'
                            GROUP BY cs.subject
                            ORDER BY cs.subject
                           "); 
                           $subjects = $query_subj->result_array();
                            foreach($subjects as $row):
                                ?>
                                <option value="<?php echo $row['subject'];?>" >
                                    <?php echo $row['subject'];?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                                       
                    
                    <table class="table table-bordered datatable" id="table_export" data-page-length='150'>
                        <thead>
                        <tr>
                            <th width="70"><div>Subject</div></th>
                            <th width="20"><div>No. of lessons</div></th>
                            <th width="10"><div>Allow double lessons</div></th>                     
                        </tr>
                        </thead>
                        <tbody>                         
                      <?php
                            $query_subj = $this->db->query(" 
                                SELECT 
                                    cs.id, cs.subject, subjectvalue ,isdoublelesson
                                FROM
                                    class_subjects cs
                                        LEFT JOIN
                                    timetable_lessons ON timetable_lessons.subject = cs.subject
                                        JOIN
                                    subject s ON s.class_subject = cs.id
                                        AND cs.school_id = '".$this->session->userdata('school_id')."'
                                GROUP BY cs.subject
                                ORDER BY cs.subject
                           "); 
                           $subjects = $query_subj->result_array();
                            foreach($subjects as $row): 
                            
                            if($row['subjectvalue'] > 0){
                                $dynoption = '<option selected value="'.$row['subject'].'_'.$row['subjectvalue'].'">'.$row['subjectvalue'].'</option>';
                            }else{
                                $dynoption ="";
                            }
                            $subjSTr =   "'". $row['subject']."'" ;
                            
                            if($row['isdoublelesson'] == "true"){
                                $Ischecked = "checked"; 
                            }else{
                                $Ischecked = ""; 
                            }
                               echo '<tr><td style="width:40%;">'.$row['subject'].'</td>
                                            <td style="width:20%;">
                                                <select style="text-align:center;width:100%;" placeholder="Select Term..." class=" form-control"  id="saveinput" onchange="savechange(this)">
                                                    '.$dynoption.'
                                                    <option value="">Select No. of Lessons</option>
                                                    <option value="'.$row['subject'].'_0">0</option>
                                                    <option value="'.$row['subject'].'_1">1</option>
                                                    <option value="'.$row['subject'].'_2">2</option>
                                                    <option value="'.$row['subject'].'_3">3</option>
                                                    <option value="'.$row['subject'].'_4">4</option>
                                                    <option value="'.$row['subject'].'_5">5</option>
                                                    <option value="'.$row['subject'].'_6">6</option>
                                                    <option value="'.$row['subject'].'_7">7</option>
                                                    <option value="'.$row['subject'].'_8">8</option>
                                                    <option value="'.$row['subject'].'_9">9</option>
                                                    <option value="'.$row['subject'].'_10">10</option>
                                                </select> 
                                            </td>
                                             <td style="text-align:center;width:20%;"><input class="marksinput" style="text-align:center;" type="checkbox" id="isdouble_"  name="isdouble_"  onchange="savechangecheckbox(this,'.$subjSTr.');" '.$Ischecked.'></td>
                            
                            </tr>';                        
                            endforeach;
                            ?>                       
                        
                        </tbody>
                     </table> 
               </div>
			</div>
			
			
			
			
			
			
			
			
			
			
			
			 <div class="tab-pane box" id="assigncodes" style="padding: 5px">
                <div class="box-content">                
                
                     <table class="table table-bordered datatable" id="table_export" data-page-length='150'>
                        <thead>
                        <tr>
                            <th width="30"><div>Teacher</div></th>
                            <th width="30"><div>Teachers Code</div></th> 
                            <th width="40"><div>Choose Color</div></th>                                         
                        </tr>
                        </thead>
                        <tbody>                         
                      <?php
                            $query_subj = $this->db->query(" 
                                SELECT 
                                    *
                                FROM
                                    teacher WHERE school_id = '".$this->session->userdata('school_id')."' ORDER BY name ASC                      
                           "); 
                           $teachersArr = $query_subj->result_array();
                           foreach($teachersArr as $row):                          
                           $tID = $row['teacher_id'];
                               echo '
                             <tr>
                                        <td style="width:30%;">'.$row['name'].'</td>                                            
                                        <td style="text-align:center;width:30%;"><input class="tcode_" style="text-align:center;" type="text" id="tcode_"  name="tcode_" value="'.$row['teacherscode'].'"  onchange="saveteacherscodebox(this,'.$tID.');" ></td>
                                        <td style="width:40%;"><input onchange="saveteacherscolor(this,'.$tID.');" type="text" value="#'.$row['teacherscolor'].'" name="highlight-color" class="pick-a-color form-control"></td> 
                             </tr>';                        
                            endforeach;
                            ?>                       
                        
                        </tbody>
                     </table> 
                   </div>
                </div>			

		</div>
	</div>
</div>


<script>
function savechange(obj){
    postVrs ={         
            "value":obj.value
        }
        $.post("timetable_lessons_save",postVrs,function(respData){
            /* swal({
                title: respData.content,
                text: 'Saved!',
                type: 'success'
            }); */
        },"json");	

}

function savechangecheckbox(obj,subj){
    postVrs ={         
            "checked":obj.checked,
            "subject":subj
        }
        $.post("timetable_double_lessons_save",postVrs,function(respData){
           /*  swal({
                title: respData.content,
                text: 'Saved!',
                type: 'success'
            }); */
        },"json");	
}

function saveteacherscolor(obj,tID){

    postVrs ={         
            "tid":tID,
            "color":obj.value
        }
        $.post("timetable_teachers_color_save",postVrs,function(respData){
           
        },"json");	

}


function saveteacherscodebox(obj,tID){

    postVrs ={         
            "tid":tID,
            "code":obj.value
        }
        $.post("timetable_teachers_code_save",postVrs,function(respData){
           
        },"json");	
	
}
</script>	

 <script src="<?php echo base_url(); ?>assets/pick-a-color-master/build/1.1.5/js/tinycolor-0.9.14.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/pick-a-color-master/build/1.1.5/js/pick-a-color-1.1.5.js"></script>

  <script type="text/javascript">

   $(document).ready(function () {  
    $(".pick-a-color").pickAColor({
		  showSpectrum            : true,
		  showSavedColors         : true,
		  saveColorsPerElement    : false,
		  fadeMenuToggle          : true,
		  showHexInput            : true,
		  showBasicColors         : true,
		  allowBlank              : false,
		  inlineDropdown          : false
		});
    
   });

  </script>
</body>
</html>
