  <a onClick="PrintElem('#notice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print
        <i class="entypo-print"></i>
   </a>
<br>
<div class="row" id="notice_print">
	<div class="col-md-2"></div>
	<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th><?php echo get_phrase('subject');?></th>
						<th><?php echo get_phrase('code');?></th>
						<th><?php echo get_phrase('A');?></th>
						<th><?php echo get_phrase('A-');?></th>
						<th><?php echo get_phrase('B+');?></th>
						<th><?php echo get_phrase('B');?></th>
						<th><?php echo get_phrase('B-');?></th>
						<th><?php echo get_phrase('C+');?></th>
						<th><?php echo get_phrase('C');?></th>
						<th><?php echo get_phrase('C-');?></th>
						<th><?php echo get_phrase('D+');?></th>
						<th><?php echo get_phrase('D');?></th>
						<th><?php echo get_phrase('D-');?></th>
						<th><?php echo get_phrase('E');?></th>
						<th><?php echo get_phrase('entry');?></th>
						<th><?php echo get_phrase('mean');?></th>
						<th><?php echo get_phrase('grade');?></th>
						<th><?php echo get_phrase('mean-2017');?></th>
						<th><?php echo get_phrase('grade');?></th>
						<th><?php echo get_phrase('diff');?></th>
						<th><?php echo get_phrase('pos');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<?php 					
					$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description.'</br>';	
					$class_id = $this->uri->segment(5).'</br>';
					$section_id = $this->uri->segment(6).'</br>';
					$exam_id = $this->uri->segment(4).'</br>';
					$subject_id = $this->uri->segment(7).'</br>';					
					$mark_array ='';
					$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'section_id' => $section_id , 'subject_id' => $subject_id, 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
						
						foreach($subjects as $row):?>
						
						<td><?php echo $row['name'];?></td>
						<td><?php echo $row['subject_id'];?></td>
						<?php $year = $row['year'];?>
						<?php $year1 = date("Y", strtotime("-1 year"));?>
						<?php $year2 = $year1+1;?>
						<td>
						<?php
							
							$subject_id =  $row['subject_id'];
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 80 and mark_obtained < 100 AND `year`LIKE '%$year%'");				
							$students = $query->result_array();
							echo count($students);
							$g1 = count($students)*12;
							$mark_array[1] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 75 and mark_obtained < 79 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g2 = count($students)*11;
							$mark_array[2] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 70 and mark_obtained < 74 AND `year` LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g3 = count($students)*10;
							$mark_array[3] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 65 and mark_obtained < 69 AND `year` LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g4 = count($students)*9;
							$mark_array[4] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 60 and mark_obtained < 64 AND `year` LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g5 = count($students)*8;
							$mark_array[5] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 55 and mark_obtained < 59 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g6 = count($students)*7;
							$mark_array[6] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 50 and mark_obtained < 54 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g7 = count($students)*6;
							$mark_array[7] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 45 and mark_obtained < 49 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g8 = count($students)*5;
							$mark_array[8] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 40 and mark_obtained < 44 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g9 = count($students)*4;
							$mark_array[9] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 35 and mark_obtained < 39 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g10 = count($students)*3;
							$mark_array[10] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 30 and mark_obtained < 34 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g11 = count($students)*2;
							$mark_array[11] = count($students);
						 ?>
						</td>
						<td>
						<?php
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained >1 and mark_obtained < 29 AND `year`LIKE '%$year%'"); 
							$students = $query->result_array();
							echo count($students);
							$g12 = count($students)*1;
							$mark_array[12] = count($students);
						 ?>
						</td>
						<td><?php echo array_sum($mark_array); ?></td>
						<td><?php echo $mean1 = number_format(($g1+$g2+$g3+$g4+$g5+$g6+$g7+$g8+$g9+$s10+$g11+$g12)/array_sum($mark_array),2)?></td>
						<td>
						<?php
							$marks = $mean1;
							$grade = '';
							 if($marks > 1 && $marks <= 0){
									echo $grade = 'D-';
								}else if($marks > 2 && $marks <=1){
									echo $grade = 'D';
								}else if($marks > 3 && $marks <=2){
									echo $grade = 'D+';
								}else if($marks > 4 && $marks <=3){
									echo $grade = 'C-';
								}else if($marks > 5 && $marks <= 4){
									echo $grade = 'C';
								}else if($marks > 6 && $marks <= 5){
									echo $grade = 'C+';
								}else if($marks > 7 && $marks <= 6){
									echo $grade = 'B-';
								}else if($marks > 8 && $marks <= 7){
									echo $grade = 'B';
								}else if($marks > 9 && $marks <= 10){
									echo $grade = 'B+';
								}else if($marks > 10 && $marks <= 11){
									echo $grade = 'A-';
								}else if($marks > 11 && $marks <= 12){
									echo $grade = 'A';
								}
						  ?> 
						</td>
							<?php
							$subject_id =  $row['subject_id'];
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 80 and mark_obtained < 100 AND `year`LIKE '%$year1-$year2%'");				
							$students = $query->result_array();
							$g11 = count($students)*12;
							$mark_array1[13] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 75 and mark_obtained < 79 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g22 = count($students)*11;
							$mark_array1[14] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 70 and mark_obtained < 74 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g33 = count($students)*10;
							$mark_array1[15] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 65 and mark_obtained < 69 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g44 = count($students)*9;
							$mark_array1[16] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 60 and mark_obtained < 64 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g55 = count($students)*8;
							$mark_array1[17] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 55 and mark_obtained < 59 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g66 = count($students)*7;
							$mark_array1[18] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 50 and mark_obtained < 54 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g77 = count($students)*6;
							$mark_array1[19] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 45 and mark_obtained < 49 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g88 = count($students)*5;
							$mark_array1[20] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 40 and mark_obtained < 44 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							//echo count($students);
							$g99 = count($students)*4;
							$mark_array1[21] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 35 and mark_obtained < 39 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g110 = count($students)*3;
							$mark_array[22] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 30 and mark_obtained < 34 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g111 = count($students)*2;
							$mark_array[23] = count($students);
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained >1 and mark_obtained < 29 AND `year`LIKE '%$year1-$year2%'"); 
							$students = $query->result_array();
							$g112 = count($students)*1;
							$mark_array1[24] = count($students);
						 ?>

						<td><?php echo $mean2 = number_format(($g11+$g22+$g33+$g44+$g55+$g66+$g77+$g88+$g99+$g110+$g111+$g112)/array_sum($mark_array1),2)?></td>
						<td>
						<?php
							$marks1 = $mean2;
							$grade2 = '';
							 if($marks1 > 1 && $marks1 <= 0){
									echo $grade2 = 'D-';
								}else if($marks1 >= 2 && $marks1 <=1){
									echo $grade2 = 'D';
								}else if($marks1 >= 3 && $marks1 <=2){
									echo $grade2 = 'D+';
								}else if($marks1 >= 4 && $marks1 <=3){
									echo $grade2 = 'C-';
								}else if($marks1 >= 5 && $marks1 <= 4){
									echo $grade2 = 'C';
								}else if($marks1 >= 6 && $marks1 <= 5){
									echo $grade2 = 'C+';
								}else if($marks1 >= 7 && $marks1 <= 6){
									echo $grade2 = 'B-';
								}else if($marks1 >= 8 && $marks1 <= 7){
									echo $grade2 = 'B';
								}else if($marks1 >= 9 && $marks1 <= 10){
									echo $grade2 = 'B+';
								}else if($marks1 >= 10 && $marks1 <= 11){
									echo $grade2 = 'A-';
								}else if($marks1 >= 11 && $marks1 <= 12){
									echo $grade2 = 'A';
								}
						  ?> 
						</td>
						<td><?php echo $mean = ($mean1-$mean2);?></td>
						<td>					
						 <?php 
								$grade3 = '';
								if($mean >= 0 && $mean <= 1){
									echo $grade3 = '12';
								}else if($mean >= 1 && $mean <=2){
									echo $grade3 = '11';
								}else if($mean >= 2 && $mean <=3){
									echo $grade3 = '10';
								}else if($mean >= 3 && $mean <=4){
									echo $grade3 = '9';
								}else if($mean >= 4 && $mean <=5){
									echo $grade3 = '8';
								}else if($mean >= 5 && $mean <= 6){
									echo $grade3 = '7';
								}else if($mean >= 6 && $mean <= 7){
									echo $grade3 = '6';
								}else if($mean >= 7 && $mean <= 8){
									echo $grade3 = '5';
								}else if($mean >= 8 && $mean <= 9){
									echo $grade3 = '4';
								}else if($mean >= 9 && $mean <= 10){
									echo $grade3 = '3';
								}else if($mean >= 10 && $mean <= 11){
									echo $grade3 = '2';
								}else if($mean >= 11 && $mean <= 12){
									echo $grade3 = '1';
								}
						 ?>
						</td>
					</tr>
					<?php endforeach;?>						
						
				</tbody>
			</table>

		
		<?php echo form_close();?>
		
	</div>
	<div class="col-md-2"></div>
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