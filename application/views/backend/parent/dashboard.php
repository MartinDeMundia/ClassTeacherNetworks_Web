<div class="row">
	<div class="col-md-12">
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
</div>
<?php 
$children_of_parent = $this->db->get_where('student' , array('parent_id' => $this->session->userdata('parent_id')))->result_array();
						
						//print_r($this->session->userdata('parent_id'));
						
						//exit;
?>



    <script>
  $(document).ready(function() {

	  var calendar = $('#notice_calendar');

				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},

					//defaultView: 'basicWeek',

					editable: false,
					firstDay: 1,
					height: 530,
					droppable: false,

					events: [
						<?php
						
						foreach ($children_of_parent as $crow){ 
							$school_id = $crow['school_id'];					
							$school_data = $this->db->query("select school_name from school where school_id=$school_id")->row(); 
							$school_name = $school_data->school_name;
							$events = $this->db->get_where('events' , array('school_id'=>$school_id))->result_array();
							foreach($events as $row){
							?>
							{
								title: "<?php echo $school_name.": ".$row['title'];?>",
								start: new Date(<?php echo date('Y',strtotime($row['date']));?>, <?php echo date('m',strtotime($row['date']))-1;?>, <?php echo date('d',strtotime($row['date']));?>),
								end:	new Date(<?php echo date('Y',strtotime($row['date']));?>, <?php echo date('m',strtotime($row['date']))-1;?>, <?php echo date('d',strtotime($row['date']));?>)
							},
							<?php
							}
						}
						?>
					]
				});
	});
  </script>
