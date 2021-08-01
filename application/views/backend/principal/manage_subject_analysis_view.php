<?php
//error_reporting(E_ALL);
     //ini_set('display_errors', 1);
?>

<hr />
<?php 
//$school_id = $this->db->get_where('class' , array('class_id' => $class_id))->row()->school_id;
$school_id = $this->session->userdata('school_id');
echo form_open(site_url('admin/subject_analysis_selector'));
$examname = $this->db->get_where('exams' , array('ID' => $exam_id))->row()->Term1;
?>
<div class="row">

	<div class="col-md-2">


		            <div class="form-group" >
		            	<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('term');?></label>
                        <select placeholder="Select Term..." class=" form-control"  id="term" name="term">
                            <option value="<?php  echo urldecode($term) ;?>" selected><?php  echo urldecode($term) ;?></option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select>
                    </div>
 </div>
<div class="col-md-2">
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
                            $r=$this->db->query($q)->result_array();;
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

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
			<select id="class_id" name="class_id" class="form-control selectboxit" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_stream');?></option>
				<option value="all">All</option>
				<?php
					$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();				
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"
					<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div>

	<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
				<select name="section_id" id="section_holder" onchange="get_class_subject(this.value)" class="form-control">
					<?php 
						$sections = $this->db->get_where('section' , array(
							'class_id' => $class_id 
						))->result_array();
						foreach($sections as $row):
					?>
					<option value="<?php echo $row['section_id'];?>" 
						<?php if($section_id == $row['section_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
	</div>


		
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('view_report');?></button>
				<button class="ladda-button ladda-button-demo btn btn-primary" id="print_btn" data-style="zoom-in"><i class="fa fa-print"></i>&nbsp;Print</button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />

<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
					<?php
					$total_points=0;
					$total_num=0;
					?>
						<th><?php echo get_phrase('subject');?></th>
						<th><?php echo get_phrase('code');?></th>
						<?php
						$this->db->order_by("GRADE","ASC");
						$grades=$this->db->get_where("gradingscale",array("school_id"=>$this->session->userdata('school_id')))->result_array();
						//$grades=$this->db->get("gradingscale")->result_array();
						foreach ($grades as $row):
						
						?>
							<th><?php echo $row['Grade'];?></th>
						<?php
						endforeach;
						?>
						<th><?php echo get_phrase('entry');?></th>
						<th><?php echo get_phrase('mean');?></th>
						<th><?php echo get_phrase('grade');?></th>
						<th><?php echo get_phrase('pos');?></th>
						<th>Teacher</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<?php 
					$mark_array ='';
					//$subjects = $this->db->get_where('subjects' , array(
							//'school_id' => $this->session->userdata('school_id')) )->result_array();

			        $user_id = $this->session->userdata('login_user_id');
			        $role = $this->session->userdata('login_type');

	/*		        if($role =='teacher')
			            $subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
			        else
		            $subjects = $this->db->get_where('subject' , array(
		                'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
		            ))->result_array();*/



if($class_id == "all"){
    					$qryIncludes = "
                         SELECT  
							cs.subject name,subject_id,t.name teacher  FROM  class_subjects cs 
							JOIN subject s ON s.name= cs.subject  AND s.section_id = '".$section_id ."'
							LEFT JOIN teacher t ON t.teacher_id = s.teacher_id
							WHERE  cs.school_id = '".$this->session->userdata('school_id')."'   
							AND  cs.is_elective <> 2 GROUP BY cs.subject  ORDER BY  cs.subject ;
						";	

}else{
	    					$qryIncludes = "
                         SELECT  
							cs.subject name,subject_id,t.name teacher  FROM  class_subjects cs 
							JOIN subject s ON s.name= cs.subject AND s.class_id = '".$class_id."' AND s.section_id = '".$section_id ."'
							LEFT JOIN teacher t ON t.teacher_id = s.teacher_id
							WHERE  cs.school_id = '".$this->session->userdata('school_id')."'   
							AND  cs.is_elective <> 2 GROUP BY cs.subject  ORDER BY  cs.subject ;
						";	
}



			            $subjects = $this->db->query($qryIncludes)->result_array();

	                   if($class_id == "all"){
		                   $class =  $this->db->get_where('section' , array('section_id' => $section_id))->row()->class_id;

							$qrySubjR = "SELECT sum(epf.mark) Mark,subject
							FROM exam_processing_final epf WHERE 
							 term ='".urldecode($term)."' AND exam = '".$examname."' AND class_id='".$class."' AND school_id='".$this->session->userdata('school_id')."'
							GROUP BY subject ORDER BY  sum(epf.mark)  DESC ";
						}else{

							$qrySubjR = "SELECT sum(epf.mark) Mark,subject
							FROM exam_processing_final epf WHERE 
							 term ='".urldecode($term)."' AND exam = '".$examname."' AND class_id='".$class_id."' AND section_id = '".$section_id."' AND school_id='".$this->session->userdata('school_id')."'
							GROUP BY subject ORDER BY  sum(epf.mark)  DESC ";

						}

				

			            $querySubjR = $this->db->query($qrySubjR)->result_array(); 
			            $arraySubjRankings = array();
			            $cnt=1;
			            foreach($querySubjR as $rowSubjR){			            
			                $arraySubjRankings[$cnt] = $rowSubjR['subject'];
			                $cnt++;			              
			            }
						
					foreach($subjects as $row):
						$total_points=0;
					   $total_num=0;
						?>
						
						<td><?php echo $row['name'];?></td>
						<td><?php echo $row['subject_id'];?></td>


						<?php $year = 0;?>
						<?php $year1 = date("Y", strtotime("-1 year"));?>
						<?php $year2 = $year1+1;?>
						<?php
						$this->db->order_by("GRADE","ASC");
						$grades=$this->db->get_where("gradingscale",array("school_id"=>$this->session->userdata('school_id')))->result_array();
			
						
				if($class_id == "all"){
	                   $class =  $this->db->get_where('section' , array('section_id' => $section_id))->row()->class_id;

	                  $entry = count($num = $this->db->get_where("exam_processing_final",array("class_id"=>$class,"term"=>urldecode($term),"subject"=>$row['name'],"exam"=>$examname,"school_id"=>$this->session->userdata('school_id')))->result_array());
	               }else{
	               	  $entry = count($num = $this->db->get_where("exam_processing_final",array("class_id"=>$class_id,"section_id"=>$section_id,"term"=>urldecode($term),"subject"=>$row['name'],"exam"=>$examname,"school_id"=>$this->session->userdata('school_id')))->result_array());

	               }

                  $str = $this->db->last_query();




						foreach ($grades as $row1):
						
						$num = $this->db->get_where("cat1",array("Code"=>$row['Code'],"Grade"=>$row1['Grade'],"form"=>'GRADE 1',"school_id"=>$this->session->userdata('school_id')))->result_array();
						$count= count($num);
						$total_num+=$count;
						$total_points+=($count* $row1['Points']);
						?>
						<?php

					if($class_id == "all"){
	                   $class =  $this->db->get_where('section' , array('section_id' => $section_id))->row()->class_id;					

			            $qryGradecount = "            
								SELECT
								 sum(epf.mark) Mark,epf.rank , 
								( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id ) grade,
								count(( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id )) gradecount
								FROM exam_processing_final epf
								WHERE subject='".$row['name']."'
								AND term ='".urldecode($term)."' 
								AND exam = '".$examname."' 
								AND class_id = '".$class."'						
								AND ( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id ) = '".$row1['Grade']."' 
			            ";

			        }else{

			            $qryGradecount = "            
								SELECT
								 sum(epf.mark) Mark,epf.rank , 
								( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id ) grade,
								count(( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id )) gradecount
								FROM exam_processing_final epf
								WHERE subject='".$row['name']."'
								AND term ='".urldecode($term)."' 
								AND exam = '".$examname."'
								AND class_id = '".$class_id."'
								AND section_id = '".$section_id."' 
								AND ( SELECT name FROM grade g WHERE epf.mark >= g.mark_from AND epf.mark <= g.mark_upto AND g.school_id = epf.school_id ) = '".$row1['Grade']."' 
			            ";


			        }
			       
			            $queryGrdCount = $this->db->query($qryGradecount);
			            $rowGCount =   $queryGrdCount->row(); 
			            $gradecount = $rowGCount->gradecount; 			        
						?>
						<th><?php echo $gradecount ;?></th>
						<?php
						endforeach;
						?>
						<th><?php echo $entry;?></th>
						<?php


						if($class_id == "all"){
			                   $class =  $this->db->get_where('section' , array('section_id' => $section_id))->row()->class_id;
			                   			            $qryGradeMean = "            
										SELECT
										 sum(epf.mark) Mark,epf.rank , 
										( SELECT name FROM grade g WHERE sum(epf.mark)/".$entry." >= g.mark_from AND sum(epf.mark)/".$entry." <= g.mark_upto AND g.school_id = epf.school_id ) grade					
										FROM exam_processing_final epf
										WHERE subject='".$row['name']."'
										AND term ='".urldecode($term)."' 
										AND exam = '".$examname."' 
										AND class_id='".$class."'
					            ";
			               }else{
			               				            $qryGradeMean = "            
										SELECT
										 sum(epf.mark) Mark,epf.rank , 
										( SELECT name FROM grade g WHERE sum(epf.mark)/".$entry." >= g.mark_from AND sum(epf.mark)/".$entry." <= g.mark_upto AND g.school_id = epf.school_id ) grade					
										FROM exam_processing_final epf
										WHERE subject='".$row['name']."'
										AND term ='".urldecode($term)."' 
										AND exam = '".$examname."' 
										AND class_id='".$class_id."' AND section_id = '".$section_id."' 
					            ";

			               }




			            $queryGrdMean= $this->db->query($qryGradeMean);
			            $rowGMean =   $queryGrdMean->row(); 			   
			            $totalattained = $rowGMean->Mark;
			            $gradeattacinedsubj = $rowGMean->grade;
						?>
						<th><?php if($entry>0) {echo (int)round($totalattained/$entry,2);}else{ echo 0;}?></th>
                        <th><?php if($entry>0) {echo $gradeattacinedsubj;}?></th>

						<th><?php
						 if(array_search($row['name'], $arraySubjRankings)){
						 	 $arrSear = array_search($row['name'], $arraySubjRankings); 
                             echo  $arrSear;
						 }else{
						 	echo "0";
						 }

						 ?></th>

						  <th><?php echo $row['teacher'];?></th>
					</tr>
					<?php endforeach;?>						
						
				</tbody>
			</table>

		
		<?php echo form_close();?>
		
	</div>
	<div class="col-md-2"></div>
</div>

<script type="text/javascript">



$("#print_btn").click(function() {

			$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
			var cuttoff=encodeURIComponent($("#cutoff").val());				
	        var subjects=$("#subject_holder").val();
			var stream=$("#section_holder").val();
			var year= "<?php  echo date("Y"); ?>";
			var term=$("#term").val();
			var exam=$("#exam_id").val();
			var form=$("#class_id").val();
			var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>index.php/admin/manage_subject_analysis_view_print',
				data:dataString,
				cache:false,
				success:function(result){
                    var obj = JSON.parse(result);					
					window.open(obj.pdfpath);						
				},
				complete: function(result){
					//$('#ibox1').children('.ibox-content').toggleClass('sk-loading');						
					$("#prt").attr("download","FORM " + form + "  " + stream + "  " + term + "  " + exam + "  " + "   " + subjects + "  SCORE SHEET " + year);
					$("#prt").attr("href","<?php echo 'application/views/'.$this->session->userdata('pdf').'.pdf' ; ?>");
				}		
	
		});
		
		return false;
		
	});	













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