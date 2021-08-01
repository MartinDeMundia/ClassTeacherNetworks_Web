<?php 
	$section_id = $parameter1;
	$term = $parameter2;
	$class_id = $parameter3;
	$year = $parameter4;
?>
<style>
.modal-body {
    height: auto !important;
}
.modal-backdrop.fade.in {
    z-index: auto !important;
}
</style>

<link href="<?php echo base_url('assets/dmultiselect/docs/css/bootstrap-3.3.2.min.css');?>" rel="stylesheet"> 
<link href="<?php echo base_url('assets/dmultiselect/docs/css/bootstrap-example.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/dmultiselect/docs/css/prettify.min.css');?>" rel="stylesheet">

<!-- <script src="<?php echo base_url('assets/dmultiselect/docs/js/jquery-2.1.3.min.js');?>"></script>
<script src="<?php echo base_url('assets/dmultiselect/docs/js/bootstrap-3.3.2.min.js');?>"></script> -->
<script src="<?php echo base_url('assets/dmultiselect/docs/js/prettify.min.js');?>"></script>

<link href="<?php echo base_url('assets/dmultiselect/dist/css/bootstrap-multiselect.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/dmultiselect/dist/js/bootstrap-multiselect.js');?>"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                window.prettyPrint() && prettyPrint();
            });
        </script>
<!-- 
<link href="<?php echo base_url('assets/timepicki/css/timepicki.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/timepicki/js/timepicki.js');?>"></script>
 -->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					Add record on time table
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/createtimetable/'.$class_id.'/'.$section_id.'/'.$term.'/'.$year), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'id'=>'form' ));?>
            
            <div class="padded">


               
                <div class="form-group">
                    <label class="col-sm-3 control-label">Day</label>
                    <div class="col-sm-8">
                          <select placeholder="Select Term..." class=" form-control"  id="tday" name="tday">
                            <option value="">Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                             <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select> 
                    </div>
                </div>

               <div class="form-group">
                    <label class="col-sm-3 control-label">Subject</label>
                    <div class="col-sm-8">


                            <select id="tsubject" name="tsubject" class="form-control" onchange="">
                                <option value="">Select Subject</option>
                                <?php

                                $qryData = " 
                                   SELECT * FROM class_subjects cs  WHERE   cs.school_id = '".$this->session->userdata('school_id')."'         
                                ";

                                $sTeacher = $this->db->query($qryData)->result_array();
                                foreach($sTeacher as $row):
                                    ?>
                                    <option value="<?php echo $row['id'];?>"
                                        <?php if($subject_id == $row['id']) echo 'selected';?>><?php echo $row['subject'];?></option>
                                <?php endforeach;?>
                            </select> 

                        <!-- <input type="text" class="form-control" name="tsubject" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/> -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Subject Teacher</label>
                    <div class="col-sm-8">


                            <select id="teacher" name="teacher" class="form-control" onchange="">
                                <option value="">Select Teacher</option>
                                <?php

								$qryData = " 
                                       SELECT * FROM teacher WHERE school_id = '".$this->session->userdata('school_id')."'
								";

                                $sTeacher = $this->db->query($qryData)->result_array();
                                foreach($sTeacher as $row):
                                    ?>
                                    <option value="<?php echo $row['teacher_id'];?>"
                                        <?php if($teacher_id == $row['teacher_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                            </select>                      
                    </div>
                </div>




                 <div class="form-group">
                    <label class="col-sm-3 control-label">Time Slot</label>
                    <div class="col-sm-8">

                                       <?php

                                                $timeslots = array();
                                                $start_date = "08:00:00";   
                                                $end_date = "16:00:00";
                                                $lessonperiod_in_minutes = "40";
                                                $shortbreak = "09:20:00";
                                                $shortbreakduration = "5";
                                                $teabreak = "11:25:00";
                                                $teabreakduration = "20";
                                                $lunchbreak = "13:45:00";
                                                $lunchbreakbreakduration = "55";
                                               $dbsettings =  $this->db->get_where('timetable_settings', array(
                                                    'school_id' => $this->session->userdata('school_id')
                                                ))->result_array(); 

                                               if(count($dbsettings)){
                                                $start_date = date('H:i',strtotime($dbsettings[0]["start_time"]));
                                                $end_date = date('H:i',strtotime($dbsettings[0]["end_time"]));  
                                                $lessonperiod_in_minutes = $dbsettings[0]["period_duration"];
                                                $shortbreak = date('H:i',strtotime($dbsettings[0]["short_break_startime"]));
                                                $shortbreakduration = $dbsettings[0]["short_break_duration"];
                                                $teabreak =   date('H:i',strtotime($dbsettings[0]["tea_break_startime"]));
                                                $teabreakduration = $dbsettings[0]["tea_break_duration"];
                                                $lunchbreak = date('H:i',strtotime($dbsettings[0]["lunch_break_startime"])); 
                                                $lunchbreakbreakduration = $dbsettings[0]["lunch_break_duration"];
                                               }
                                               $hashortbreak = 0;
                                                $begin = new DateTime( $start_date );
                                                $end = new DateTime(date("H:i",strtotime("+1 minutes", strtotime($end_date))));
                                                while($begin < $end) {
                                                    $period[] = $begin->format('H:i');
                                                    $begin->modify('+1 minutes');
                                                }

                                            $lsbegin = date_create($period[0])->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                            $lesnend =  $lsbegin->format('H:i'); 
                                            $timeslots[] =   array($period[0],$lesnend);
                                             $i = 1;
                                                for ($j = 0 ;$j <= count($period)-1 ; $j++){ 
                                                    $sTime = $period[$j];
                                                    if($i == 1){ 

                                                         $lend = date_create($sTime)->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                                         $lsnend =  $lend->format('H:i'); 
                                                    }

                                                    if($shortbreak  == $sTime ){
                                                              $sBreak = date_create($sTime)->add(date_interval_create_from_date_string($shortbreakduration.' minutes')); 
                                                              $shortbreakend =  $sBreak->format('H:i');
                                                             // $timeslots[] =   array($shortbreak,$shortbreakend); 
                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($shortbreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $shortbreakend ;
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }


                                                    if($teabreak  == $sTime ){
                                                              $sTBreak = date_create($sTime)->add(date_interval_create_from_date_string($teabreakduration.' minutes')); 
                                                              $teabreakend =  $sTBreak->format('H:i');
                                                              ///$timeslots[] =   array($teabreak,$teabreakend);
                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($teabreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $teabreakend ;
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }

                                                    if($lunchbreak  == $sTime ){
                                                              $sTBreak = date_create($sTime)->add(date_interval_create_from_date_string($lunchbreakbreakduration.' minutes')); 
                                                              $lunchbreakend =  $sTBreak->format('H:i'); 
                                                              //$timeslots[] =   array($lunchbreak,$lunchbreakend);   
                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($lunchbreakbreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $lunchbreakend ; 
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }
                                                    if($sTime == $lsnend ){
                                                            $lsbegin = date_create($lsnend)->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                                            $lesnend =  $lsbegin->format('H:i');
                                                            $timeslots[] =   array($lsnend,$lesnend); 
                                                      $i=0;
                                                      $sTime = $period[$j + 1] = $lsnend;
                                                     }        

                                                   if( $sTime == date('H:i',strtotime($end_date))){
                                                    break;
                                                   }    

                                                 $i ++;

                                                }

                                       ?>  

                    <select id="tslots" name="tslots[]" multiple="multiple">
                        <?php
                        foreach ($timeslots as $key => $tslots) {
                           echo '<option value='.$tslots[0].'-'.$tslots[1].'>'.$tslots[0]." - ".$tslots[1].'</option>';
                        }
                        ?>                    
                    </select>

                    <script type="text/javascript">
                        $(document).ready(function() {
                           // $('#tslots').multiselect();
                                 $('#tslots').multiselect({
                                                    enableClickableOptGroups: true,
                                                    enableCollapsibleOptGroups: true,
                                                    enableFiltering: true,
                                                    includeSelectAllOption: false
                            
                                });
                        });
                    </script>   

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Venue</label>
                    <div class="col-sm-5">
                        <input readonly type="text" class="form-control" name="tvenue" value="<?php  echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name; ?>" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info">Add Record</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>





<script>
$(document).ready(function(){
	
	$("#form").submit(function(e){
		e.preventDefault();
		////alert("");
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: new FormData($("#form")[0]),
			cache:false,
			processData:false,
			contentType:false,
			success: function(res){
                var obj = JSON.parse(res); 
				if(obj.res=="1"){
					swal({
						title: 'SUCCESS',
						text: obj.message,
						type: 'success'
						
					});
                 parent.loadTimeTable();
				}else{
                   swal({
                        title: 'SUCCESS',
                        text: obj.message,
                        type: 'success'
                        
                    });					
				}
				
			}
			
		});
		
		//return false;
	});	
	
});

</script>





