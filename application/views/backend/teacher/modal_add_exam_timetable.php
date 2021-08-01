<?php 
	$section_id = $parameter1;
	$term = $parameter2;
	$class_id = $parameter3;
	$year = $parameter4;
  $exam = $parameter5;
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
 
<link href="<?php echo base_url('assets/timepicki/css/timepicki.css');?>" rel="stylesheet">
<script src="<?php echo base_url('assets/timepicki/js/timepicki.js');?>"></script>


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
				
                <?php echo form_open(site_url('admin/createexamtimetable/'.$class_id.'/'.$section_id.'/'.$term.'/'.$year.'/'. $exam ), array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'id'=>'form' ));?>
            
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


                            <select id="tsubject" name="tsubject" class="form-control" onchange="setunitcode(this.value,$(this).find('option:selected').text())">
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
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Exam/Unit Code</label>
                    <div class="col-sm-5">
                          <input type="text" class="form-control" name="unitcode" id="unitcode" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                    </div>
                </div>


                  <div class="form-group">
                    <div col-sm-6>
                      <label class="col-sm-3 control-label">Start time</label>
                      <div class="col-sm-3">
                             <input id="starttime" class="form-control" type="text" name="starttime"/>
                      </div>
                    </div>

                  </div>



                 <div class="form-group">                

                    <div col-sm-6>
                      <label class="col-sm-3 control-label">End time</label>
                      <div class="col-sm-3">
                             <input id="endtime" class="form-control" type="text" name="endtime"/>
                      </div>
                    </div>

                  </div>




                  <style>
                        .timepicker_wrap {
                            width: 280px;
                        }
                  </style>

                  <script>

  $('#starttime').timepicki({
    show_meridian:false,
    min_hour_value:0,
    max_hour_value:23,
    step_size_minutes:15,
    overflow_minutes:true,
    increase_direction:'up',
    disable_keyboard_mobile: true});


    $('#endtime').timepicki({
    show_meridian:false,
    min_hour_value:0,
    max_hour_value:23,
    step_size_minutes:15,
    overflow_minutes:true,
    increase_direction:'up',
    disable_keyboard_mobile: true});

                       // $('#starttime').timepicki();
                       // $('#endtime').timepicki();
                  </script>



      

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

function setunitcode(value,selText){
  slString =  selText.substring(0, 4);
  $("#unitcode").val(slString+""+value);
}

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





