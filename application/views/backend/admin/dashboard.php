<hr />
<div class="row">
	<!--div class="col-md-8">
    	<div class="row">           
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
    </div-->

	<div class="col-md-12">
		<div class="row">
		
			<div class="col-md-3">
				<a href="<?php echo base_url();?>index.php/admin/schooltype">
                <div class="tile-stats tile-blue" id="myBtn" style="cursor: pointer;"> 
                    <div class="icon"><i class="entypo-chart-bar"></i></div>
                    <?php
						$check	=	array( 'status' => '1' );
						$query = $this->db->get_where('school' , $check);
						$present_today		=	$query->num_rows();
						?>
                    <div class="num" data-start="0" data-end="<?php echo $present_today;?>"
                    		data-postfix="" data-duration="500" data-delay="0">0</div>

                    <h3><?php echo get_phrase('schools');?></h3>
                   <p>Total schools</p>
                </div>
				</a>
            </div>
			

            <div class="col-md-3">

                <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-group"></i></div>
                    <div class="num" data-start="0"
												data-end="
													<?php
														$number_of_student_in_current_session = $this->db->get_where('enroll', array('year' => $running_year))->num_rows();
														echo $number_of_student_in_current_session;
														//echo $this->db->count_all('student');
													?>
													"
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>

                    <h3><?php echo get_phrase('student');?></h3>
                   <p>Total students</p>
                </div>

            </div>
            <div class="col-md-3">

                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('teacher');?>"
                    		data-postfix="" data-duration="800" data-delay="0">0</div>

                    <h3><?php echo get_phrase('teacher');?></h3>
                   <p>Total teachers</p>
                </div>

            </div>
            <div class="col-md-3">

                <div class="tile-stats tile-aqua">
                    <div class="icon"><i class="entypo-user"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('parent');?>"
                    		data-postfix="" data-duration="500" data-delay="0">0</div>

                    <h3><?php echo get_phrase('parent');?></h3>
                   <p>Total parents</p>
                </div>

            </div>
            
    	</div>
    </div>

</div>



    <script>
  $(document).ready(function() {
	  return '';
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
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>)
						},
						<?php
						endforeach
						?>

					]
				});
	});
  </script>

  
  
<script>
var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0]; 
btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>


<style>
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
	height: 215px;
	position:relative;
	bottom:75px;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>