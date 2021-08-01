<hr />
<link href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/canvas/bootstrap.min.css" rel="stylesheet">
<link href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/canvas/style.css" rel="stylesheet">
<link href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/canvas/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/canvas/js/jquery-1.12.4.min.js"></script>
<script src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/assets/canvas/js/bootstrap.min.js"></script>
<style>
.page-body.skin-default.loaded {
    padding: 0px;
}
</style>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<?php echo form_open(site_url('teacher/subject_performance'));?>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label"><?php echo get_phrase('class');?></label>
					<select name="class_id" class="form-control selectboxit" id = 'class_id' onchange="select_section(this.value)">
                        <option value=""><?php echo get_phrase('select_a_class');?></option>
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
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream'); ?></label>
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
				<button type="submit" id = 'submit' class="btn btn-info"><?php echo get_phrase('view_subject_performance');?></button>
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
				<?php echo get_phrase('class');?> : <?php echo $class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('section');?> : <?php echo $section_name;?>
			</h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>
<hr />

<div class="row">
	<div class="col-md-12">
        <div id="chartContainer"></div>
			<?php
			   $qryData = "	
					SELECT cs. subject, sum(mark) total , count(*) entry  , exam , ( sum(mark) / count(*)  ) mean   FROM  class_subjects cs
					JOIN 
					exam_processing_final epf ON cs.subject = epf.subject AND  epf.class_id = '".$class_id ."' AND epf.section_id = '".$section_id ."' 
					WHERE  cs.school_id = '".$this->session->userdata('school_id')."'  AND  cs.is_elective <> 2 
					GROUP BY  cs. subject	
				";														 
				$queryData = $this->db->query($qryData)->result_array();

				$dataPoints_1 = array(); 
				foreach($queryData as $rowExamsData){	
			       $dataPoints_1 [] = array("y" =>number_format($rowExamsData['mean'],2), "label" =>$rowExamsData['subject'] , "indexLabel"=>$rowExamsData['exam']);
				}			   
			?>
	</div>
</div>



<?php endif;?>
<script type="text/javascript">
	window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light1", 
		title:{
			text: "Subjects Performance <?php echo $section_name;?>"
		},
		axisY: {
			title: "Mean Marks Attained"
		},
		data: [{        
			type: "column",  
			showInLegend: true, 
			legendMarkerColor: "grey",
			legendText: "1 Unit = one mean mark",
			dataPoints:<?php echo json_encode($dataPoints_1, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart.render();
	}

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