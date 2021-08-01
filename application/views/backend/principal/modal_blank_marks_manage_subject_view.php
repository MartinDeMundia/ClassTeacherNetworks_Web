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
                           
                            <th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>
							<th><div><?php echo get_phrase('M3');?></div></th>
                            <th><div><?php echo get_phrase('Exam /90');?></div></th>
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							//$students   =   $this->db->get_where('mark' , array(
							//	'class_id' => $class_id , 'year' => $running_year
							//))->result_array();
							$subject_id =  $this->uri->segment('7');
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id"); 
							$students = $query->result_array();
							$count = 1; foreach($students as $row): 
						 ?>
                        <tr>
                            
                            <td><?php echo $count++;?></td>
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?>
							</td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							 <td>
                                <?php
                                   // echo $row['mark_obtained'];
                                ?>
                            </td>  
							
							
							 <td>
                                <?php
                                    // echo $row['mark_obtained1'];
                                ?>
                            </td> 
							
							 <td>
                                <?php
                                   // echo $row['mark_obtained2'];
                                ?>
                            </td> 
							 <td>
                                <?php
                                   // echo $row['mark_obtained3'];
                                ?>
                            </td> 
							 <td>
                                <?php
									$total_obtained_mark = $row['mark_obtained1']+$row['mark_obtained2']+$row['mark_obtained3'];
									$obtained_workScore_total = ($total_obtained_mark*100/90);
                                   // echo round($obtained_workScore_total);
                                ?>
                            </td> 
							 <td>
                                <?php
                                  //  echo $row['mark_obtained'];
                                ?>
                            </td> 
							 <td>
                              <?php
								$marks = $row['mark_obtained'];
								$grade = '';
								if($marks >=1 && $marks<= 29){
										//echo $grade = 'E';
									}else if($marks > 30 && $marks <= 34){
										//echo $grade = 'D-';
									}else if($marks > 35 && $marks <=39){
										echo $grade = 'D';
									}else if($marks > 40 && $marks <=44){
										//echo $grade = 'D+';
									}else if($marks > 45 && $marks <=49){
										//echo $grade = 'C-';
									}else if($marks > 50 && $marks <= 54){
										//echo $grade = 'C';
									}else if($marks > 55 && $marks <= 59){
										//echo $grade = 'C+';
									}else if($marks > 60 && $marks <= 64){
										//echo $grade = 'B-';
									}else if($marks > 65 && $marks <= 69){
										//echo $grade = 'B';
									}else if($marks > 70 && $marks <= 74){
										//echo $grade = 'B+';
									}else if($marks > 75 && $marks <= 79){
										//echo $grade = 'A-';
									}else if($marks > 80 && $marks <= 100){
										//echo $grade = 'A';
									}
							  ?> 
                            </td> 
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            
							<th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>
							<th><div><?php echo get_phrase('M3');?></div></th>
                            <th><div><?php echo get_phrase('Exam /90');?></div></th>
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $students   =   $this->db->get_where('enroll' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                                ))->result_array();
                               $count = 1; foreach($students as $row):?>
								
                        <tr>
                            
                            <td><?php echo $count++;?></td>
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?></td>
                            <td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            
      
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php endforeach;?>
        <?php endif;?>

        </div>




<script type="text/javascript">
    jQuery(document).ready(function($) {
	   $("#submit").attr('disabled', 'disabled');
	   
	 
    });
	function get_class_section(class_id) {
		 jQuery('#subject_holder').html("<option value=''>select section first</option>");
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });         
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
	
	function get_class_subject(section_id) {
		
		var class_id =  jQuery('#class_id').val();
		if (class_id !== '' && section_id !='') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
            success: function(response)
            {
                jQuery('#subject_holder').html(response);
            }
        });
        $('#submit').removeAttr('disabled');
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
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




