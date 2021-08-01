<style type="text/css">
	.myheadings{
		background:#124057;
		color:white;
	}
</style>		
<div class="wrapper wrapper-content animated fadeInDown">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox" id="ibox1">
                    <div class="ibox-title">
                      
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
							<form role="form" class="form-inline" >
                               

	                        <div class="form-group" style="margin-bottom: 35px;">
	                            <select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
	                                <option value="">Stream</option>
	                                <?php
	                                $classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
	                                foreach($classes as $row):
	                                    ?>
	                                    <option value="<?php echo $row['class_id'];?>"
	                                        <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
	                                <?php endforeach;?>
	                            </select>
	                        </div>



                            <div class="form-group" style="margin-bottom: 35px;">
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


							<div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term" name="term">
                                  <option value="">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select>
                            </div>

						    <div class="form-group" style="margin-bottom: 35px;">
                                    
                                <select data-placeholder="Choose Year..." class="form-control " tabindex="1" id="year" name="year">
                                   	<option selected value="2019">2019</option>
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select> </div>
                                
                                 
		                    <div class="form-group  " style="margin-bottom: 35px;">
		                        <select placeholder="Select exam..." class="form-control"  id="examtype" ><option value="">Select Exam...</option>
		                            <?php


		                            $q="SELECT term1 FROM exams WHERE school_id='".$this->session->userdata('school_id')."'";
		                            $r=$this->db->query($q)->result_array();;
		                            foreach ($r as $row) :
		                            ?>

		                            <option id="<?php echo $row['term1']; ?>" value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
		                                <?php
		                                endforeach;

		                                ?>
		                            </option>

		                        </select> </div>





								
								<!-- <div class="form-group" style="margin-bottom: 15px;">
		                            <input placeholder="enter minimum subjects to grade..." class="form-control"  type="number" id="subno" name="subno" pattern="[0-9]"/>
		                        </div> -->
								  <div class="hidden" id="cats">
                             <div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c1"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 1 </label></div></div>
							
							<div class="form-group " style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c2"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 2 </label></div></div>
								
								<div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" id="c3" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 3 </label></div></div>

							</div>
							
							<h4 class="myheadings">Examinations to include</h4>
							<div class="table-responsive" id="include_exams" style="overflow:hidden;">
                                <table class="table table-bordered datatable" id="table_export">
                                    <thead>
                                    <tr>
                                        <th style='width: 20%;'><div>Id</div></th>
                                        <th style='width: 40%;'><div>Exam name</div></th>
                                        <th style='width: 20%;'><div>Is active</div></th>
                                        <th style='width: 20%;'><div>Percentage to include in main</div></th>                                       
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $students   = $this->db->query("SELECT ID,term1 FROM exams WHERE school_id='".$this->session->userdata('school_id')."'")->result_array();
                                    foreach($students as $row):?>
                                        <tr>
                                            <td style="" ><?php echo $row['ID']; ?></td>
                                            <td><?php echo $row['term1']; ?></td>
                                            <td style="text-align:center;"><input type="checkbox" id="is_active1_s_<?php echo $row['ID']; ?>" onchange="saveExaminables(<?php echo $row['ID']; ?>)" name="is_active1_s_<?php echo $row['ID']; ?>" ></td>
                                            <td style="text-align:center"><input style="text-align:center;float:left;" type="text" id="is_active2_s_<?php echo $row['ID']; ?>" onchange="saveExaminables(<?php echo $row['ID']; ?>)"  name="is_active2_s_<?php echo $row['ID']; ?>" value="0"></td>                                        
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
							</div>




							<h4 class="myheadings">Subjects</h4>
							<div class="table-responsive" id="include_exams" style="overflow:hidden;">
                                <table class="table table-bordered datatable" id="subject_table">
                                    <thead>
                                    <tr>
                                        <th style='width: 20%;'><div>Id</div></th>
                                        <th style='width: 40%;'><div>Subject Name</div></th>
                                        <th style='width: 20%;'><div>Category</div></th> 
                                        <th style='width: 20%;'><div>Is active</div></th>
                                                                             
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

		                            $user_id = $this->session->userdata('login_user_id');
		                            $role = $this->session->userdata('login_type');

		                            if($role =='teacher')
		                                $subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
		                            else
	                                $subjects = $this->db->get_where('subject' , array(
	                                    'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
	                                ))->result_array();
                            
                                    foreach($subjects as $row):?>
                                        <tr>
                                            <td style="" ><?php echo $row['subject_id'];?></td>
                                            <td><?php echo $row['name'];?></td>
                                             <select id="subjectcat" name="subjectcat"><option value="Sciences">Sciences</option><option value="Humanities">Humanities</option><option value="Other">Other</option></select>
                                            <td style="text-align:center;"><input type="checkbox" id="is_active" name="is_active" ></td>                                    
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
							</div>







<h4 class="myheadings">Processing options</h4>
<div style="background:#0e2b3c;padding: 2%;">
<form id="processoptions">
<div class="row">
	 <div class="col-lg-3">
        <label class="col-sm-12 control-label ">No. of subjects required</label>
	 </div>

	 <div class="col-lg-9">

                    <div class="form-group ">

                     	<div class="col-sm-2">
                        <label class="col-sm-12 control-label ">Sciences</label>
                       </div>
                        <div class="col-sm-2">
                           <input type="number" onchange="mySubmit(this.form)" class="form-control" name="inpsciences" style="width:50%;"/>
                           <label><input onchange="mySubmit(this.form)" type="checkbox" name="checkbox-sciences" value="1">&nbsp;&nbsp;All</label>
                        </div>

                        <div class="col-sm-2">
                        <label class="col-sm-12 control-label ">Humanities</label>
                       </div>
                        <div class="col-sm-2">
                            <input type="number" onchange="mySubmit(this.form)" class="form-control" name="inphumanities" style="width:50%;"/>
                            <label><input onchange="mySubmit(this.form)" type="checkbox" name="checkbox-humanities" value="1">&nbsp;&nbsp;All</label>
                        </div>


                        <div class="col-sm-2">
                        <label class="col-sm-12 control-label ">Others</label>
                       </div>
                        <div class="col-sm-2">
                            <input type="number" onchange="mySubmit(this.form)" class="form-control" name="inpothers" style="width:50%;"/>
                            <label><input onchange="mySubmit(this.form)" type="checkbox" name="checkbox-others" value="1">&nbsp;&nbsp;All</label>
                        </div>

                    </div>


	 </div>

</div>


<div class="row">
	 <div class="col-lg-3">
        <label class="col-sm-12 control-label ">Calculate mean using</label>
	 </div>

	 <div class="col-lg-9">

                             <div class="">
                             	<div class="col-sm-6">
                             		 <label><input onchange="mySubmit(this.form)" type="radio"  name="groupmean-points" value="0">&nbsp;Total Scores</label>
                             	</div>
                        
                                <div class="col-sm-6">
                                     <label><input onchange="mySubmit(this.form)" type="radio"  name="groupmean-points" value="1">&nbsp;Total Points</label>
                                </div>
                            </div>

	 </div>

</div>


<div class="row">
	 <div class="col-lg-3">
        <label class="col-sm-12 control-label ">Rank student by comparing</label>
	 </div>

	 <div class="col-lg-9">


                             <div class="">
                             	<div class="col-sm-6">
                             		 <label><input onchange="mySubmit(this.form)" type="radio"  name="grouprank-totalscores" value="0">&nbsp;Total Scores</label>
                             	</div>
                        
                                <div class="col-sm-6">
                                     <label><input onchange="mySubmit(this.form)" type="radio"  name="grouprank-totalscores" value="1">&nbsp;Mean Scores</label>
                                </div>
                            </div>

	 </div>

</div>


<div class="row">
	 <div class="col-lg-3">
        <label class="col-sm-12 control-label ">Pick best subjects by comparing</label>
	 </div>

	 <div class="col-lg-9">


                             <div class="">
                             	<div class="col-sm-6">
                             		 <label><input onchange="mySubmit(this.form)" type="radio"  name="groupbest-grades" value="0">&nbsp;Grades</label>
                             	</div>
                        
                                <div class="col-sm-6">
                                     <label><input onchange="mySubmit(this.form)" type="radio"  name="groupbest-grades" value="1">&nbsp;Scores</label>
                                </div>
                            </div>


	 </div>

</div>


</div>

<div class="row" style="padding:1%;">
	 <div class="col-lg-3">
        <button style="display:;" type="button" class="btn btn-primary btn-sm btn-block" id="process_btn" value="SEARCH" style="display:;">PROCESS</button>	
	 </div>
</div>

<form>


















							
						<!-- 	<div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
							<button style="display:;" type="button" class="btn btn-primary btn-sm btn-block" id="process_btn" value="SEARCH" style="display:;">PROCESS</button>							
                            </div> -->
							
							<h5 id="title" class="hidden">Progress</h5>
							<div class="progress hidden">
                                <div class="progress-bar  progress-bar-animated progress-bar-success " style="width: 0%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
							</div>						
							
                            </form>
								 
                      
                           </div>
                        </div></div></div></div></div></div>
						<div id="holder">
						<div class="spiner-example hidden" id="gif">
                                <div class="sk-spinner sk-spinner-cube-grid">
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                </div>
                            </div>
						</div>			
           
<script>


	function mySubmit(theForm) {
    $.ajax({
        data: $(theForm).serialize(), 
        type: "POST", 
        url: 'process_save_otheroptions', 
        success: function (response) { 
           // $('#here').html(response); 
        }
    });
   }

	function saveExaminables(selExamId){
		      postVrs = {
                "term":$('#term').val(),            
                "examtype":$('#examtype').val(),
                "fr":$('#class_id').val(),
                "st":$('#section_holder').val(),
                "year":$('#year').val(),
                "toaddexam":selExamId,
                "toaddexamactive":$('#is_active1_s_'+selExamId).is(':checked'),
                "toaddexampercentage":$('#is_active2_s_'+selExamId).val()
            }
            $.post("process_save_exams",postVrs,function(respData){
            	if(respData.bool==false){

            				swal({
				                title: "ERROR!",
				                text: respData.response,
				                type: "warning"
				            });

            	}else{


            	}

            },"json");  
	}



  function saveSubjectExaminables(selSubjId){
		      postVrs = {
                "term":$('#term').val(),            
                "examtype":$('#examtype').val(),
                "fr":$('#class_id').val(),
                "st":$('#section_holder').val(),
                "year":$('#year').val(),
                "toaddsubj":selSubjId,
                "toaddsubjctive":$('#is_active_subj_'+selSubjId).is(':checked'),
                "toaddsubjcat":$('#subjectcat_'+selSubjId).val()
            }
            $.post("process_save_subjects",postVrs,function(respData){
            	if(respData.bool==false){

            				swal({
				                title: "ERROR!",
				                text: respData.response,
				                type: "warning"
				            });

            	}else{


            	}

            },"json");  
	}




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


            $(document).ready(function () {




     function loadSubjGrid(term,examtype,fr,st,year){

            dataTable =  $('#subject_table').DataTable();
            dataTable.fnClearTable();
            dataTable.fnDraw();
            postVrs = {
                "term":term,            
                "examtype":examtype,
                "fr":fr,
                "st":st,
                "year":year
            }
            $.post("process_load_subject",postVrs,function(respData){
                 ischecked = "";
                $.each(respData.content, function(i, item) { 
             
                   

                    var data = [
                        '<td>'+item.subject_id+'</td>',                 
                        "<td>"+item.name+"</td>",                       
                        '<td style="text-align:center"><select onchange="saveSubjectExaminables('+item.subject_id+')" id="subjectcat_'+item.subject_id+'" name="subjectcat"><option value="Sciences">Sciences</option><option value="Humanities">Humanities</option><option value="Other">Other</option></select></td>',
                        '<td style="text-align:center;"><input onchange="saveSubjectExaminables('+item.subject_id+')" type="checkbox" id="is_active_subj_'+item.subject_id+'" name="is_active" '+item.is_active +'></td>'
                       
                    ];
                    dataTable.fnAddData(data);
                       if(item.is_active == 1){
                             $("#is_active_subj_"+item.subject_id).prop('checked', true); 
                        }else{
                             $("#is_active_subj_"+item.subject_id).prop('checked', false); 
                        } 
                });
            },"json");

        }


         $('select').on('change', function(){
            loadSubjGrid( $('#term').val(),$('#examtype').val(),$('#class_id').val(),$('#section_holder').val(),$('#year').val());
          });
				
				
			$("#term").change(function () {
					/*var term=$("#term").val();
					var form=$("#fr option:selected").text();
               	$.ajax({
							type: 'POST',
							url:'<?php echo base_url();?>index.php/admin/exam_include/' + form.replace(" ","_") + '/' + term.replace(" ","_") ,
							
							cache: false,
							success: function(result){
								
								$("#include_exams").html(result);
							}
				});*/
				
				});
				
				$("#fr").change(function () {



					/*var term=$("#term").val();
					var form=$("#fr option:selected").text();
               	$.ajax({
							type: 'POST',
							url:'<?php echo base_url();?>index.php/admin/exam_include/' + form.replace(" ","_") + '/' + term.replace(" ","_") ,
							
							cache: false,
							success: function(result){
								
								$("#include_exams").html(result);
							}
				});*/
				
				});



$("#process_btn").click(function(){
   
   $("#process_btn").attr("disabled", true);

		    postVrs = {
                "term":$('#term').val(),            
                "examtype":$('#examtype').val(),
                "fr":$('#class_id').val(),
                "st":$('#section_holder').val(),
                "year":$('#year').val()
            }
            $.post("process_do_process",postVrs,function(respData){
            	if(respData.bool==false){

            				swal({
				                title: "ERROR!",
				                text: respData.response,
				                type: "warning"
				            });
				           $("#process_btn").attr("disabled", false);

            	}else{

            		        swal({
				                title: "Exam Processing..",
				                text: respData.response,
				                type: "success"
				            });

            		 $("#process_btn").attr("disabled", false);
            	}

            },"json");  


});




				
				
$("#process_btns").click(function(){
				
	
	 
	var form=$("#fr option:selected").text();
	
		var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var subjectno=$("#subno").val();
		
		var param="";
		 
	
	
	if(term==1){
		swal({
                title: "ERROR!",
                text: 'Term is required',
                type: "warning"
            });
	}else if(form==1){
		swal({
                title: "ERROR!",
                text: 'Class is required',
                type: "warning"
            });
	}else if(exam==1){
		swal({
                title: "ERROR!",
                text: 'Main exam required',
                type: "warning"
            });
	}else if(subjectno==""){
		swal({
                title: "ERROR!",
                text: 'Minimum number of subjects required',
                type: "warning"
            });
	}
	
	
	else{
		var exams = [];
        $.each($(".include option:selected"), function(){            
            exams.push($(this).val());
        });
		
	$("#gif").removeClass('hidden');
	$("#mr").addClass("hidden");
		var includes = exams.join(" + ");
		
		var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&includes=' + includes.replace(" ","") + '&subjectno=' + subjectno;
	$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
	$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>index.php/admin/process_exam/create',
				data:dataString,
				cache:false,
				success:function(result){
					 $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
					if (result==1){
						toastr.success('Results Processing completed successifully');
						
					}else{
						
						swal({
                title: "ERROR!",
                text: result,
                type: "warning"
            });
					}
					
				}
				
			});
	}
	return false ;
});
			
			
				
				
            });
        </script>
