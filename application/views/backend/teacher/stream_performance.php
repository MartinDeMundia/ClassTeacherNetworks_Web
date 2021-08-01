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

<?php

if ($class_id){
    $classid =  $this->db->get_where('section' , array('section_id' => $class_id))->row()->class_id;
    $class_name =  $this->db->get_where('section' , array('section_id' => $class_id))->row()->name;
	$exam_name  = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name; 
}else{
$class_name = "Entire School";	
}
?>

<div class="row">
	<div class="col-md-12">
		<?php echo form_open(site_url('teacher/stream_performance'));?>


				<div class="col-md-3">
					    <div class="form-group " >
			                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
	                        <select placeholder="Select exam..." class="form-control"  id="exam_id" name="exam_id" >
	                        	 <option value="">Select Exam...</option> 
	                        	<?php
	                        	if( $examname ){
	                        	?>
	                        	<option value="<?php  echo $exam_id ;?>" selected><?php  echo $examname ;?></option>
								<?php
								}
				                ?>

	                            <?php
	                            $q="SELECT ID,term1 FROM exams WHERE school_id='".$this->session->userdata('school_id')."'";
	                            $r=$this->db->query($q)->result_array();
	                            foreach ($r as $row) :
	                            ?>
	                            <option id="<?php echo $row['ID']; ?>" value="<?php echo $row['ID']; ?>"><?php echo $row['term1']; ?>
	                                <?php
	                                endforeach;
	                                ?>
	                            </option>
	                        </select>
	                    </div>
					</div>


<!-- 
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label"><?php echo get_phrase('stream');?></label>
					<select name="class_id" class="form-control selectboxit" id = 'class_id'>
                        <option value="">Select Stream</option>
                        <?php 
	                        $classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();

						    $qryStream = "	
	                           SELECT section_id, CAST(name AS UNSIGNED) as stream  
	                           FROM section 
	                           WHERE class_id IN (SELECT class_id FROM class WHERE school_id = '".$this->session->userdata('school_id')."') 
	                           GROUP BY CAST(name AS UNSIGNED)  
	                           ORDER BY name ASC ;				
							";														 
							$classes = $this->db->query($qryStream)->result_array();

	                        if((int)$class_name > 0 ) print("<option selected>Class ".(int)$class_name."</option >");
	                   
	                        foreach($classes as $row):
	                        ?>
                            <option value="<?php echo $row['section_id'];?>">
                            		Class <?php echo $row['stream'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>	 -->



			<input type="hidden" name="operation" value="selection">
			<div class="col-md-3" style="margin-top: 20px;">
				<button type="submit" id = 'submit' class="btn btn-info"><?php echo get_phrase('view_stream_performance');?></button>
			</div>
		<?php echo form_close();?>
	</div>
</div>

<!--
<br>
 <div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
			<h3 style="color: #696969;">
				<?php
					//$class_name = $this->db->get_where('class' , array('class_id' => $classid))->row()->name; 
					//$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$section_name = "All";
					echo get_phrase('score_sheet_for');
				?>
			</h3>			
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> : <?php echo (int)$class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('section');?> : <?php echo $section_name;?>
			</h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>
 -->

<hr />

<div class="row">
	<div class="col-md-12">

        <div id="chartContainer"></div>
			<?php
			   $qryData = "
					SELECT sect.section_id, sect.name stream , sect.class_id ,
					sum(epf.mark) total,count(*) entry , epf.exam , ( sum(epf.mark) / count(*)  ) mean 
					FROM section sect
					LEFT JOIN exam_processing_final epf ON epf.section_id = sect.section_id AND epf.class_id = sect.class_id
					WHERE sect.class_id IN (SELECT class_id FROM class WHERE school_id = '".$this->session->userdata('school_id')."' ) 
					GROUP BY sect.name
					ORDER BY sect.name ASC		
				";														 
				$queryData = $this->db->query($qryData)->result_array();

				$dataPoints_1 = array(); 
				foreach($queryData as $rowExamsData){	
			       $dataPoints_1 [] = array("y" =>$rowExamsData['mean'], "label" =>$rowExamsData['stream'] , "indexLabel"=>$rowExamsData['exam']);
				}			   
			?>
		

	</div>
</div>










<script type="text/javascript">


	window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light1", 
		title:{
			text: "Stream Performance"
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
			//$('#submit').attr('disabled', 'disabled');
		<?php } ?>
	});

	function check_validation(){
		var class_id = $('#class_id').val();
		var exam_id = $('#exam_id').val();
		if(class_id !== '' && exam_id !== ''){
			$('#submit').removeAttr('disabled');
		}
		else{
			///$('#submit').attr('disabled', 'disabled');	
		}
	}
	$('#class_id').change(function() {
		
		//check_validation();
	});
	
	$('#exam_id').change(function() {
				
		//check_validation();
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