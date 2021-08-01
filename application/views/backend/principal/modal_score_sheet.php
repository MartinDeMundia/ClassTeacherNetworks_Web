  <a onClick="PrintElem('#notice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print
        <i class="entypo-print"></i>
   </a>
<br>

<div class="row" id="notice_print">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
				<td style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>
				<?php 
				$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;	
				$class_id = $this->uri->segment(4);
				$section_id = $this->uri->segment(6);
				$exam_id = $this->uri->segment(5);
					$subjects = $this->db->get_where('subject' , array('class_id' => $class_id , 'section_id' => $section_id , 'year' => $running_year))->result_array();
					foreach($subjects as $row1): 
				?>
					<td style="text-align: center;"><?php echo $row1['name'];?><?php echo $row1['offer_subject'];?></td>
				<?php endforeach;?>				
				</tr>
			</thead>
			<tbody>
			<?php
				$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
				$class_id = $this->uri->segment(4);
				$section_id = $this->uri->segment(6);
				$exam_id = $this->uri->segment(5);
				$school_id = $this->session->userdata('school_id');
				$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
				$bl_class_id = ($classes['class_id']);	
				$students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'section_id' => $section_id ,'year' => $running_year))->result_array();
				foreach($students as $row9):
			?>
				<tr>
					<td style="text-align: center;">
						<?php echo $this->db->get_where('student' , array('student_id' => $row9['student_id']))->row()->name;?>
					</td>
				<?php
				$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
				$class_id = $this->uri->segment(4);
				$section_id = $this->uri->segment(6);
				$exam_id = $this->uri->segment(5);
					$total_marks = 0;
					$total_grade_point = 0;  
					foreach($subjects as $row3): 
				?>
					<td style="text-align: center;">
						<?php 
							$obtained_mark_query = 	$this->db->get_where('mark' , array(
													'class_id' => $class_id , 
														'exam_id' => $exam_id , 
															'subject_id' => $row3['subject_id'] , 
																'student_id' => $row9['student_id'],
																	'year' => $running_year
												));
							if ( $obtained_mark_query->num_rows() > 0) {
								$obtained_marks = $obtained_mark_query->row()->mark_obtained;
								echo $obtained_marks;
								if ($obtained_marks >= 0 && $obtained_marks != '') {
									$grade = $this->crud_model->get_grade($obtained_marks);
									$total_grade_point += $grade['grade_point'];
								}
								$total_marks += $obtained_marks;
							}
							

						?>
					</td>
				<?php endforeach;?>
				
				</tr>

			<?php endforeach;?>

			</tbody>
		</table>

	</div>
</div>

<script type="text/javascript">
	var class_id = '';
	var section_id  = '';
	var exam_id  = '';
	jQuery(document).ready(function($) {
		<?php if($section_id > 0){?>
			$('#submit').removeAttr('disabled');
		<?php }else{?>
			$('#submit').attr('disabled', 'disabled');
		<?php } ?>
	});
	function check_validation(){
		var class_id = $('#class_id').val();
		var exam_id = $('#exam_id').val();
		if(class_id !== '' && exam_id !== ''){
			$('#submit').removeAttr('disabled');
		}
		else{
			$('#submit').attr('disabled', 'disabled');	
		}
	}
	$('#class_id').change(function() {
		
		check_validation();
	});
	
	$('#exam_id').change(function() {
				
		check_validation();
	});
</script>
<script type="text/javascript">
    function select_section(class_id) {

        $.ajax({
            url: '<?php echo site_url('admin/get_section/'); ?>' + class_id,
            success: function (response)
            {

                jQuery('#section_holder').html(response);
            }
        });
    }
</script>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'blank_score_sheet', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Student Information</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        var is_chrome = Boolean(mywindow.chrome);
        if (is_chrome) {
            setTimeout(function() {
                mywindow.print();
                mywindow.close();

                return true;
            }, 550);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }
	
</script>




