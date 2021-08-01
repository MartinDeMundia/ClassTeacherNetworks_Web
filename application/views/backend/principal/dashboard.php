<hr>
<div class="row">
	<div class="col-md-8">
    	<div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('event_schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="col-md-4">
		<div class="row">
		    
		    
		    <div class="col-md-12">

                <div class="tile-stats tile-blue">
                    <div class="icon"><i class="fa fa-group"></i></div>
                  
							
							<div class="num"><?php 
				   $school_id = $this->session->userdata('school_id');
				   echo $school_name = $this->db->get_where('school' , array('school_id' => $school_id))->row()->school_name;
				   $school_image = $this->crud_model->get_image_url('school',$school_id);
				   ?></div>
                   <div class="col-md-6" style="padding:0;">
                    <h3><?php echo $license_code = $this->db->get_where('school' , array('school_id' => $school_id))->row()->license_code;?></h3>
                   <p>License code</p>
				   </div>
				   
				   <div class="col-md-6" style="padding:0;">
                     <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100%" >
				   </div>
				    <div class="clearfix"></div>
				  
				  <div class="col-md-6" style="padding:0;">
                    <h3><?php echo $activation_date = $this->db->get_where('school' , array('school_id' => $school_id))->row()->activation_date;?></h3>
                   <p>Activation Date</p>
				   </div>
				   
				  
				    <div class="col-md-6" style="padding:0;">
                    <h3><?php echo $expiry_date = $this->db->get_where('school' , array('school_id' => $school_id))->row()->expiry_date;?></h3>
                   <p>Expiry Date</p>
				   </div>
				   
				   
				
				   
				  
				   
                </div>

            </div>
            
            <div class="col-md-12">

                <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-group"></i></div>
                    <div class="num" data-start="0" data-end="<?php $query = $this->db->get_where('student' , array('school_id'=>$this->session->userdata('school_id'))); echo $query->num_rows();?>"
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>

                    <h3><?php echo get_phrase('student');?></h3>
                   <p>Total students</p>
                </div>

            </div>
            <div class="col-md-12">

                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="<?php $query = $this->db->get_where('teacher' , array('school_id'=>$this->session->userdata('school_id'))); echo $query->num_rows(); ?>"
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>

                    <h3><?php echo get_phrase('teacher');?></h3>
                   <p>Total teachers</p>
                </div>

            </div>        
                   
           <div class="col-md-12">

                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="<?php $query = $this->db->get_where('change_request' , array('school_id'=>$this->session->userdata('school_id'))); echo $query->num_rows(); ?>"
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>

                    <h3><?php echo get_phrase('profile_change_requests');?></h3>
                    
                </div>

            </div>   
           
    	</div>
    </div>

</div>



    <script>
  $(document).ready(function() {

	  var calendar = $('#notice_calendar');

				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
    dateClick: function(info) {
      alert('clicked ' + info.dateStr);
    },
    select: function(start, end, jsEvent) {
		var d = ("0" + start.getDate()).slice(-2);
		var m =("0" + start.getMonth()+1).slice(-2);
		m.toString();
		var m2 ="";
		var d2 ="";
		 if (m.length == 1) 
		 {
			 m2 = '0' + m;
		 }
			if (d.length == 1) {
				d2 = '0' + d;
				}
		var mm = m + '-' + d + '-' + start.getFullYear(); 
      showAjaxModal('<?php echo base_url(); ?>index.php/modal/popup/event_modal/'+ mm);
    },

					//defaultView: 'basicWeek',
						selectable: true,
					editable: true,
					firstDay: 1,
					height: 530,
					droppable: false,
					
					events: [
						<?php
						$events	= $this->db->get_where('events' , array('school_id'=>$this->session->userdata('school_id')))->result_array();
						foreach($events as $row):
						?>
						{
							title: "<?php echo $row['title'];?>",
							start: new Date(<?php echo date('Y',strtotime($row['date']));?>, <?php echo date('m',strtotime($row['date']))-1;?>, <?php echo date('d',strtotime($row['date']));?>),
							end:	new Date(<?php echo date('Y',strtotime($row['date']));?>, <?php echo date('m',strtotime($row['date']))-1;?>, <?php echo date('d',strtotime($row['date']));?>)
						},
						<?php
						endforeach
						?>

					]
				});
	});
  </script>
