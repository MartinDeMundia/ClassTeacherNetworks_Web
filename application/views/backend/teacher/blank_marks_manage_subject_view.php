<?php 
$school_id = $this->db->get_where('class' , array('class_id' => $class_id))->row()->school_id;
echo form_open(site_url('teacher/blank_marks_subject_selector'));
?>
<div class="row">

	<div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px;">
                    	<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('year');?></label>
                        <select placeholder="Select Year..." class="form-control"  id="year" name="year" ><option value="">Select Year...</option>
                            <option selected value="2019">2019</option>
                            <?php
                            for ($i=0; $i<=3;$i++){
                                ?>
                                <option value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
    </div>


	<div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px;">
                    	<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('term');?></label>
                        <select placeholder="Select Term..." class=" form-control"  id="term" name="term">
                            <option value="" selected="">Select Term...</option>
                            <?php if($term)?><option value="<?php echo urldecode($term); ?>" selected=""><?php echo urldecode($term); ?></option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select> 
                    </div>
    </div>



	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" id="examtype" class="form-control" required>
			<?php if($exam)?><option value="<?php echo urldecode($exam); ?>" selected=""><?php echo urldecode($exam); ?></option>
				<?php					
                    $exams = $this->db->get_where('exams' , array('school_id' => $school_id))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['Term1'];?>"
					<?php if($exam_id == $row['ID']) echo 'selected';?>><?php echo $row['Term1'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_class');?></option>
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
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
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
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_holder" class="form-control">
					<?php 
						
						$user_id = $this->session->userdata('login_user_id');      
						$role = $this->session->userdata('login_type');

						if($role =='teacher')		
        					$subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
						else									
						$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
			
						
						foreach($subjects as $row):
					?>
					<option value="<?php echo $row['subject_id'];?>"
						<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;float:right !important;">
			<center>
				<button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;<?php echo get_phrase('view_marks');?></button>
				<button class="ladda-button ladda-button-demo btn btn-primary" id="print_btn" data-style="zoom-in"><i class="fa fa-print"></i>&nbsp;Print</button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />



<div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>                           
                            <th width="80"><div>#</div></th>
							<th width="80" style="width:10%;"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>	

                             <?php
								$qryIncludes = "
									SELECT
									Term1 exam,percentage 
									FROM exam_processing ep
									JOIN exam_processing_includes epi ON epi.exam_processing_id = ep.id AND epi.is_active=1
									JOIN exams e ON e.ID = epi.exam_id
									WHERE ep.class_id = '".$class_id."' AND ep.stream_id = '".$section_id."' AND ep.term = '".urldecode($term)."' AND ep.year='".$year."' AND exam = '".urldecode($exam)."'
								 ";
								 
					            $queryInclude = $this->db->query($qryIncludes)->result_array(); 
					           
					            foreach($queryInclude as $rowExamsIncluded){	
					               echo "<th style='text-align:center;'><div>".$rowExamsIncluded['exam']."/<b>".$rowExamsIncluded['percentage']."</b></div></th>";
					            }
						     ?>	
                            <th style='text-align:center;'><div><?php echo get_phrase('Total /100');?></div></th>
                            <th style='text-align:center;'><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>



                              
                             <?php

                             $subjectsname = $this->db->get_where('subject' , array('subject_id' => $subject))->row()->name;

                                 $qryincludes = '
									SELECT
									Term1 exam,percentage 
									FROM exam_processing ep
									JOIN exam_processing_includes epi ON epi.exam_processing_id = ep.id AND epi.is_active=1
									JOIN exams e ON e.ID = epi.exam_id
									WHERE ep.class_id = "'.$class_id.'" AND ep.stream_id = "'.$section_id.'" AND ep.term = "'.urldecode($term).'" AND ep.year="'.$year.'" AND exam = "'.urldecode($exam).'"
					                                        ';

							       $includexams  = $this->db->query($qryincludes)->result_array();
							       $colarrays = array();
							       $colpercarrays = array();
							       foreach($includexams as $rowexams){
							       	$colarrays[] = preg_replace('/\s+/', '', $rowexams['exam']);
							       	$colpercarrays[] = $rowexams['percentage'];
							       }
							       $colstring = implode("`,`",$colarrays);


                             $qry = '
        
                              SELECT * 
                                        FROM enroll e 
                                        JOIN student s ON s.student_id = e.student_id  
                                        LEFT JOIN student_marks sm ON sm.studentid = s.student_id AND sm.term = "'.urldecode($term).'" AND sm.subject = "'.$subject.'" AND sm.examtype = "'.urldecode($exam).'" 
                                        WHERE 
                                        school_id =  "'.$this->session->userdata('school_id').'"
                                        ';

						          if($class_id > 0 ) $qry .= ' AND e.class_id =  "'.$class_id .'" ';
						          if($section_id > 0 ) $qry .= ' AND e.section_id =  "'.$section_id .'" ';
						         $qry .= ' GROUP BY s.student_id ';

                                    $students   = $this->db->query($qry)->result_array();

                                      foreach($students as $row):?>
                                        <tr>
                                        	<td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                                            <td style="" ><?php  echo $row['student_code']; ?></td>                                           
                                            <td style="" ><?php  echo $row['name']; ?></td>

                                           <?php
                                           $sumtotal = 0;$GradeM="";
                                           if(count($colarrays)){
                                           	foreach ($colarrays as $key => $colname) {
                                           		$sqlincluded = "SELECT `".strtolower($colname)."` mark  FROM exam_processing_marks WHERE student_id ='".$row["student_id"]."' AND subject='".$subjectsname."' AND exam='".urldecode($exam)."'";
												$queryMarkInclude = $this->db->query($sqlincluded);
												$rowExamIncluded =   $queryMarkInclude->row(); 
												$sMark = $rowExamIncluded->mark;
                                           		echo '<td style="text-align:center;">'.$sMark.'</td>';
                                           		 $sumtotal =  $sumtotal + $sMark ; 
                                           	}

                                           	//fetch grade
                                           	$sqlGrd = "SELECT name FROM grade g WHERE ".$sumtotal." >= g.mark_from AND ".$sumtotal." <=  g.mark_upto AND g.school_id = '".$this->session->userdata('school_id')."' ";
											$queryGrd = $this->db->query($sqlGrd);
												$rowGrd =   $queryGrd->row(); 
												$GradeM = $rowGrd->name;
                                           }

                            

                                           ?>


                                            <td style="text-align:center;" ><?php echo $sumtotal; ?></td>
                                            <td style="text-align:center;"><?php echo $GradeM; ?></td>

                                        </tr>
                                    <?php endforeach;?>


                  



                    </tbody>
                </table>

            </div>    

        </div>

<script type="text/javascript">


$("#print_btn").click(function(){

			$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
			var cuttoff=encodeURIComponent($("#cutoff").val());				
	        var subjects=$("#subject_holder").val();
			var stream=$("#section_holder").val();
			var year= "<?php  echo date("Y"); ?>";
			var term=$("#term").val();
			var exam=$("#examtype").val();
			var form=$("#class_id").val();
			var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>teacher/blank_marks_manage_subject_print',
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




     function loadGrid(term,subject,examtype,fr,st,year){
            dataTable =  $('#table_export').DataTable();
            dataTable.fnClearTable();
            dataTable.fnDraw();
            postVrs = {
                "term":term,
                "subject":subject,
                "examtype":examtype,
                "fr":fr,
                "st":st,
                "year":year
            }
            $.post("/teacher/blank_marks_manage_view",postVrs,function(respData){
               markincludes="<td></td><td></td>";
                $.each(respData.content, function(i, item) {
                      markincludes="";
                	  $.each(item.marks, function(i,markobj) {

                	  	 $.each(markobj, function(i,markobjValue) {
                	  	 	markincludes += '<td>'+ markobjValue +'</td>,';
	                        alert(markincludes);
                	  	 });
                	  

                	  });

                
                    var data = [
                        '<td><img src='+item.img+' class="img-circle" width="30" /></td>',
                        '<td>'+item.admno+'</td>',                      
                        '<td>'+item.student+'</td>',
                       // "<td></td>",
                        markincludes,
                        "<td></td>",
                        "<td></td>"
                    ];
                    //alert(data.toSource());
                    dataTable.fnAddData(data);
                });
            },"json");

        }

        $('select').on('change', function(){
            //loadGrid( $('#term').val(),$('#subject_holder').val(),$('#examtype').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val());
        });



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





































<?php  exit(); ?>


<div class="btn-group" style="float:right; margin:0px; "  >
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		Print Option <span class="caret"></span>
		</button>
		<ul class="dropdown-menu dropdown-default pull-right" role="menu">
			<?php 
			$school_id = $this->session->userdata('school_id');
			$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
			$class_idp = ($classes[0]['class_id']);											
			?>
			<li>
			<a href="#" onclick="showAjaxModal('<?php $subject_id =  $this->uri->segment('6'); echo site_url('modal/popup/modal_blank_marks_manage_subject_view/'.$exam_id.'/'.$class_idp.'/'.$section_id.'/'.$subject_id);?>');">
			<i class="entypo-pencil"></i>
			<?php echo get_phrase('print_mark_book');?>
			</a>
		</li>										
		</ul>
 </div>

<hr />
<?php 
$school_id = $this->db->get_where('class' , array('class_id' => $class_id))->row()->school_id;
echo form_open(site_url('teacher/blank_marks_subject_selector'));
?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control" required>
				<?php
					 $exams = $this->db->get_where('exam' , array('school_id' => $school_id,'year' => $running_year))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"
					<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select id="class_id" name="class_id" class="form-control selectboxit" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_class');?></option>
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
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
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
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_holder" class="form-control">
					<?php 
						
						$user_id = $this->session->userdata('login_user_id');      
						$role = $this->session->userdata('login_type');

						if($role =='teacher')		
        					$subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
						else									
						$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
			
						
						foreach($subjects as $row):
					?>
					<option value="<?php echo $row['subject_id'];?>"
						<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info"><?php echo get_phrase('view_marks');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />



<div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>
							<th><div><?php echo get_phrase('M3');?></div></th>
							<th><div><?php echo get_phrase('M4');?></div></th>
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
							$subject_id =  $this->uri->segment('6');
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
                                   //  echo $row['mark_obtained1'];
                                ?>
                            </td> 
							
							 <td>
                                <?php
                                  //  echo $row['mark_obtained2'];
                                ?>
                            </td> 
							 <td>
                                <?php
                                  //  echo $row['mark_obtained3'];
                                ?>
                            </td> 
							 <td>
                                <?php
                                  //  echo $row['mark_obtained4'];
                                ?>
                            </td> 
							 <td>
                                <?php
									$total_obtained_mark = $row['mark_obtained1']+$row['mark_obtained2']+$row['mark_obtained3']+$row['mark_obtained4'];
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
										//echo $grade = 'D';
									}else if($marks > 40 && $marks <=44){
									//	echo $grade = 'D+';
									}else if($marks > 45 && $marks <=49){
										//echo $grade = 'C-';
									}else if($marks > 50 && $marks <= 54){
										//echo $grade = 'C';
									}else if($marks > 55 && $marks <= 59){
									//	echo $grade = 'C+';
									}else if($marks > 60 && $marks <= 64){
									//	echo $grade = 'B-';
									}else if($marks > 65 && $marks <= 69){
									//	echo $grade = 'B';
									}else if($marks > 70 && $marks <= 74){
									//	echo $grade = 'B+';
									}else if($marks > 75 && $marks <= 79){
									//	echo $grade = 'A-';
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