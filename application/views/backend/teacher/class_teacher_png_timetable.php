<?php
    $class_name    =   $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
    $section_name  =   $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
    $system_name   =   $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $running_year  =   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
    $school_id  =   $this->db->get_where('teacher' , array('teacher_id'=>$class_id))->row()->school_id;
	
function testct($routine_check,$dd)
{
		if(!in_array($dd,$routine_check))
		{
			return $dd;		
		}
		else
		{
			$arr2 = array(1,2,3,4,5,6,7,8,9);										
			$get_respo = array_diff($arr2,$routine_check);
			return current($get_respo);
		}
}
								
// Time Table Settings Start 
	$query_timetable_settings = $this->db->get_where('timetable_settings' , array('school_id' => $school_id ));
	$array_tt_settings = $query_timetable_settings->result_array();
	$starting_time = substr($array_tt_settings[0]['start_time'], 0, -3);
	$period_duration = $array_tt_settings[0]['period_duration'];
	$break_duration = $array_tt_settings[0]['break_duration'];
	$break_between_period = $array_tt_settings[0]['break_between_period'];
	$lunch_duration = $array_tt_settings[0]['lunch_duration'];
	$lunch_between_period = $array_tt_settings[0]['lunch_between_period'];

// Time Table Settings Start 
	
	//SELECT subject_id FROM `subject` where teacher_id = '.$teacher_id.' and year = '2018-2019'
		
	$this->db->select('GROUP_CONCAT(subject.section_id SEPARATOR ",") as section_id,GROUP_CONCAT(subject.subject_id SEPARATOR ",") as subject_id');
	$this->db->from('subject');
	$this->db->where('principal_id', 0);
	$this->db->where('teacher_id', $class_id);
	$subject_row = $this->db->get()->row();	 
	$section_id = $subject_row->section_id;	 
	$subject_id = $subject_row->subject_id;	
	
	$teacher_name    =   $this->db->get_where('teacher' , array('teacher_id' => $class_id))->row()->name;
?>


<div id="print">

    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>

    <center>
        <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height : 60px;"><br>
        <h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
		<h3 style="font-weight: 100;">Teacher Name : <?php echo $teacher_name;?></h3>
    </center>
    <table style="width:100%; border-collapse:collapse;border: 1px solid #eee; margin-top: 10px;" border="1">
        <thead>
					<tr class="gradeA">
					   <th style="text-align:center;width:8%;" >Days</th>
					   <th style="text-align:center;width:8%;">Period 1 <br/>(<?php echo $starting_time .' - '. date("H:i",strtotime($starting_time.'+'.$period_duration.' minute')); ?>)</th>
					   
					   <th style="text-align:center;width:8%;">Period 2 <br/>(<?php 
					   $second_start = date("H:i",strtotime($starting_time.'+'.$period_duration.' minute'));
					   $second_end = date("H:i",strtotime($starting_time.'+'.($period_duration * 2).' minute'));
					   echo $second_start .' - '. $second_end; ?>)</th>
					   
					   <th style="text-align:center;width:8%;">Period 3 <br/>(<?php 
					   $third_end = date("H:i",strtotime($starting_time.'+'.($period_duration * 3).' minute'));
					   echo $second_end .' - '. $third_end; ?>)</th>				   
					   					   
					   <th style="text-align:center;width:8%;">Period 4<br/>(<?php 
					   $fourth_end = date("H:i",strtotime($starting_time.'+'.($period_duration * 4).' minute'));
					   echo $third_end .' - '. $fourth_end; ?>)<br/></th>
					   					   
					   <th style="text-align:center;width:8%;">Break<br/>(<?php 
					   $break_end = date("H:i",strtotime($fourth_end.'+'.$break_duration.' minute'));
					   echo $fourth_end .' - '. date("H:i",strtotime($fourth_end.'+'.$break_duration.' minute')); ?>)</th>
					  
					   <th style="text-align:center;width:8%;">Period 5 <br/>(<?php 
					   $fifth_end = date("H:i",strtotime($break_end.'+'.$period_duration.' minute'));
					   echo $break_end .' - '. date("H:i",strtotime($break_end.'+'.$period_duration.' minute')); ?>)
					   </th>
					   
					   <th style="text-align:center;width:8%;">Period 6 <br/> (<?php 
					   $sixth_end = date("H:i",strtotime($fifth_end.'+'.$period_duration.' minute'));
					   echo $fifth_end .' - '. $sixth_end; ?>)</th>
					   
					  
					   <th style="text-align:center;width:8%;">Lunch<br/> (<?php 
					   $lunch_end = date("H:i",strtotime($sixth_end.'+'.$lunch_duration.' minute'));
					   echo $sixth_end .' - '. $lunch_end; ?>)</th>
					  
					   
					   <th style="text-align:center;width:8%;">Period 7 <br/>(<?php 
					   $seventh_end = date("H:i",strtotime($lunch_end.'+'.$period_duration.' minute'));
					   echo $lunch_end.' - '. $seventh_end; ?>)</th>
					   
					   <th style="text-align:center;width:8%;">Period 8 <br/>(<?php 
					   $eight_end = date("H:i",strtotime($seventh_end.'+'.$period_duration.' minute'));
					   echo $seventh_end.' - '. $eight_end; ?>)</th>
					<tr>
				 </thead>
                    <tbody>
                        <?php 
                        for($d=1;$d<=7;$d++):
                        
                        if($d==1)$day='sunday';
                        else if($d==2)$day='monday';
                        else if($d==3)$day='tuesday';
                        else if($d==4)$day='wednesday';
                        else if($d==5)$day='thursday';
                        else if($d==6)$day='friday';
                        else if($d==7)$day='saturday';
						
						$this->db->where('day', $day);
						$this->db->where('year' , $running_year);
						$this->db->where_in('subject_id', explode(',',$subject_id));
						$this->db->order_by("period", "asc");
						$routines  =  $this->db->get('class_routine_time_table')->result_array();
		
						echo '<tr class="gradeA">
										<td width="100">'.strtoupper($day).'</td>';
										if(count($routines) == 0 && $d == 7 || count($routines) == 0 && $d == 1)
										{
												echo '<td align="center" colspan="10">';
												echo 'Leave';
												echo '</td>';
										}
										elseif(count($routines) == 0 && $d != 7 || count($routines) == 0 && $d != 1)
										{
											for($dd=1;$dd<=8;$dd++) {
													$routines[$dd]['period'] = $dd;
													$routines[$dd]['type'] = 'S';
													$routines[$dd]['subject_id'] = 'AAA';											
											}
										}
										elseif(count($routines) != 0 && $d != 7 || count($routines) != 0 && $d != 1)
										{
											$routine_check = array();
											for($dd=0;$dd<8;$dd++) {
												if(!in_array($routines[$dd]['period'],$routine_check))
												{
													$get_test = testct($routine_check,$dd);
													$routines[$dd]['period'] = ($routines[$dd]['period'] != '') ? $routines[$dd]['period'] : $get_test;
													$routines[$dd]['type'] = ($routines[$dd]['type'] != '') ? $routines[$dd]['type'] : 'S';
													//$routines[$dd]['type'] = 'S';
													array_push($routine_check,$routines[$dd]['period']);
												}
											}
										}
										
										$usernames = array();
 
										foreach ($routines as $user) {
											$usernames[] = $user['period'];
										}
										
										$rrr = array_multisort($usernames, SORT_ASC, $routines);
										
										
									foreach($routines as $row2) 
									{
										if($row2['subject_id'] == 'AAA')
										{
											$sub_name ='N/A';
										}elseif($row2['subject_id'] == '')
										{
											$sub_name ='N/A';
										}else
										{
											$sub_name = $this->crud_model->get_subject_name_by_id($row2['subject_id']);
										}	
										
										if($row2['period'] == 1 && $row2['type'] == 'M')
										{
											echo '<td colspan="2" align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 1 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										
										if($row2['period'] == 2 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 3 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 3 && $row2['type'] == 'M')
										{
											echo '<td colspan="2" align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
																			
										if($row2['period'] == 4 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 4)
										{
											if($d == 2) {
											echo '<td rowspan="5" style="vertical-align : middle;text-align:center;">';
											echo 'Break';
											echo '</td>';
											}
										}
										
										if($row2['period'] == 5 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 5 && $row2['type'] == 'M')
										{
											echo '<td colspan="2" align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										
										if($row2['period'] == 6 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 6)
										{
											if($d == 2) {
											echo '<td rowspan="5" style="vertical-align : middle;text-align:center;">';
											echo 'Lunch';
											echo '</td>';
											}
										}
										
										if($row2['period'] == 7 && $row2['type'] == 'M')
										{
											echo '<td colspan="2" align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 7 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
										
										if($row2['period'] == 8 && $row2['type'] == 'S')
										{
											echo '<td align="center">';
											echo $sub_name;
											echo '<br/>';
											echo $this->db->get_where('class' , array('class_id' => $row2['class_id']))->row()->name.' -  '.$this->db->get_where('section' , array('section_id' => $row2['section_id']))->row()->name;
											echo '</td>';
										}
									}
									echo '</tr>';
                        ?>
                       
						
                        <?php endfor;?>
                        
                    </tbody>
   </table>

<br>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

<script type="text/javascript">

   /* $(document).ready(function()
    {
        var teacher_id = "<?php echo $class_id; ?>";
            html2canvas([document.getElementById('print')], 
            {
                onrendered: function(canvas) 
                {
                           document.body.appendChild(canvas);
                           var imgageData = canvas.toDataURL('image/png');
                           var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                           $.ajax({ 
                            type: "POST", 
                            url: "<?php echo base_url(); ?>index.php/teacher/savepng_timetable?tid="+teacher_id,
                            dataType: 'text',
                            data: {base64data : newData},
                            success:function(data)	
                            { 
                                console.log('success');
                            }
                           });
                   
                }
            });
    });*/
</script>