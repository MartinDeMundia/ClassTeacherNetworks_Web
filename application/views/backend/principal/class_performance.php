<hr />
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(site_url('admin/class_performance'));?>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label"><?php echo get_phrase('stream');?></label>
					<select name="class_id" class="form-control selectboxit" id = 'class_id' onchange="select_section(this.value)">
                        <option value=""><?php echo get_phrase('select_a_stream');?></option>
                        <?php 
                        $classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                        foreach($classes as $row):
                        ?>
                            <option value="<?php echo $row['class_id'];?>"
                            	<?php if ($class_id == $row['class_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>
			<div id="section_holder">
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
						<select class="form-control selectboxit" name="section_id" >
							<option value=""><?php echo get_phrase('select_class_first') ?></option>
							 <?php 
								$sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
								foreach($sections as $row):
								?>
									<option value="<?php echo $row['section_id'];?>"
										<?php if ($section_id == $row['section_id']) echo 'selected';?>>
											<?php echo $row['name'];?>
									</option>
								<?php
								endforeach;
							?>
						</select>
					</div>
				</div>
			</div>
			
			<input type="hidden" name="operation" value="selection">
			<div class="col-md-3" style="margin-top: 20px;">
				<button type="submit" id = 'submit' class="btn btn-info"><?php echo get_phrase('view_stream_performance');?></button>
			</div>
		<?php echo form_close();?>
	</div>
</div>

<?php if ($class_id != '' && $section_id != ''):?>
<br>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
			<h3 style="color: #696969;">
				<?php
					$exam_name  = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name; 
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					echo get_phrase('score_sheet_for');
				?>
			</h3>			
			<h4 style="color: #696969;">
				<?php echo get_phrase('stream');?> : <?php echo $class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> : <?php echo $section_name;?>
			</h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>


<hr />

<div class="row">
	<div class="col-md-12">
	 <div style="width:100%;margin-left: 10px;">

	 <div style="float:left;width: 80px;">
	    <div style="float:left;width: 33px;">		
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">11-12</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">10-11</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">9-10</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">8-9</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">7-8</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">6-7</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">5-6</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">4-5</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">3-4</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">2-3</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">1-2</div>
		<div style="float:left;width:100%;margin-bottom:5px;line-height:21px;">0-1</div>

		</div>
	    <div style="float:left;width:10%;">
		  <div style="border-left:1px solid #231f20;height: 306px;margin-left: 20px;"></div>
		</div>
	
	 </div>
	 
			
		<?php 
			$subjects = $this->db->get_where('subject' , array('class_id' => $class_id ,'section_id' => $section_id , 'year' => $running_year))->result_array();
			foreach($subjects as $row):
				$year = $row['year'];
				$subject_id =  $row['subject_id'];
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 80 and mark_obtained < 100 AND `year`LIKE '%$year%'");				
				$students = $query->result_array();
				//echo count($students);
				$g1 = count($students)*12;
				$mark_array[1] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 75 and mark_obtained < 79 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g2 = count($students)*11;
				$mark_array[2] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 70 and mark_obtained < 74 AND `year` LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g3 = count($students)*10;
				$mark_array[3] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 65 and mark_obtained < 69 AND `year` LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g4 = count($students)*9;
				$mark_array[4] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 60 and mark_obtained < 64 AND `year` LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g5 = count($students)*8;
				$mark_array[5] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 55 and mark_obtained < 59 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g6 = count($students)*7;
				$mark_array[6] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 50 and mark_obtained < 54 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g7 = count($students)*6;
				$mark_array[7] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 45 and mark_obtained < 49 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g8 = count($students)*5;
				$mark_array[8] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 40 and mark_obtained < 44 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g9 = count($students)*4;
				$mark_array[9] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 35 and mark_obtained < 39 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g10 = count($students)*3;
				$mark_array[10] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained > 30 and mark_obtained < 34 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g11 = count($students)*2;
				$mark_array[11] = count($students);
				$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id AND  mark_obtained >1 and mark_obtained < 29 AND `year`LIKE '%$year%'"); 
				$students = $query->result_array();
				//echo count($students);
				$g12 = count($students)*1;
				$mark_array[12] = count($students);
			
			
			
			?>
		  <div style="float:left;width:60px">
			<div style="float:left;width:60px;">
			
			<?php $mean = number_format(($g1+$g2+$g3+$g4+$g5+$g6+$g7+$g8+$g9+$s10+$g11+$g12)/array_sum($mark_array),2);?>
			<?php
				$marks = $mean;
				$grade = '';
					if($marks > 0 && $marks <= 1){
						echo $grade = 'D'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 14px;background:#00a89e;position: relative;top: 293px;"></div>
					<?php } else if($marks > 1 && $marks <= 2){
						echo $grade = 'D-'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 44px;background:#00a89e;position: relative;top: 265px;"></div>
					<?php } else if($marks > 2 && $marks <=3){
						echo $grade = 'D'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 68px;background:#00a89e;position: relative;top: 239px;"></div>
					<?php } else if($marks > 3 && $marks <=4){
						echo $grade = 'D+'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 93px;background:#00a89e;position: relative;top: 215px;"></div>
					<?php } else if($marks > 4 && $marks <=5){
						echo $grade = 'C-'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 120px;background:#00a89e;position: relative;top: 188px;"></div>
					<?php } else if($marks > 5 && $marks <= 6){
						 echo $grade = 'C'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 150px;background:#00a89e;position: relative;top: 159px;"></div>
					<?php} else if($marks > 6 && $marks <= 7){
						echo $grade = 'C+'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 172px;background:#00a89e;position: relative;top: 137px;"></div>
					<?php } else if($marks > 7 && $marks <= 8){
						echo $grade = 'B-'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 195px;background:#00a89e;position: relative;top: 111px;"></div>
					<?php } else if($marks > 8 && $marks <= 9){
						echo $grade = 'B'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 220px;background:#00a89e;position: relative;top: 86px;"></div>
					<?php } else if($marks > 9 && $marks <= 10){
						echo  $grade = 'B+'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 250px;background:#00a89e;position: relative;top: 57px;"></div>
					<?php } else if($marks > 10 && $marks <= 11){
						echo $grade = 'A-'; ?>
						<div style="border:1px solid #00a89e;width:50%;height: 270px;background:#00a89e;position: relative;top: 30px;"></div>
					<?php } else if($marks > 11 && $marks <= 12){
						echo $grade = 'A'; ?>
						<div style="border:1px solid #00a89e;width:50%;height:300px;background:#00a89e;"></div>
					<?php }	?>
			</div>
			
			<div style="position: absolute; bottom:-33px;">
			<span ><?php echo $row['name'];?></span>
			</div><br>
		  </div>
		  <?php endforeach;?>	
		  
	 	

</div>
		

	</div>
</div>
<?php endif;?>
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