
		
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
                                    
                                    <select class="form-control " tabindex="1" id="fr" name="fr"><option value="1">Select Class...</option>
								<?php
								 include_once("dbconn.php");
                                   $q="SELECT * from form";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?>
                                </select>
                                </div>
                                <div class="form-group hidden" style="margin-bottom: 35px;">
                                    
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="Streams" name="Streams"><option value="1">Select Stream...</option>
								<?php
                                   $q="SELECT * from streams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option  value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?><option  value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term" name="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose Year..." class="form-control " tabindex="1" id="year" name="year">
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select> </div>
                                
                                  <div class="form-group" style="margin-bottom: 35px;">
                                    <select data-placeholder="Choose exam..." class="form-control " tabindex="1" id="examtype"><option selected value="1">Select Main Exam...</option>
                                  <?php
								  
								 
								  $q="SELECT term1 from exams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
								 
								  
									  <option   value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
									  
								  }
								  
								  ?>
                                   </option>
									  
                                </select> </div>
                             <div class="form-group hidden" style="margin-bottom: 35px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="subject" onchange="showUser()"><option value="1">Select Subject...</option>
                                  <?php
								  
								  include_once("dbconn.php");
								  $q="SELECT Abbreviation from subjects";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
									  
									  <option value="<?php echo $row['Abbreviation'];?>"><?php echo $row['Abbreviation'];?></option>
									  <?php
								  }
								  
								  ?>
                                   
                                </select> </div>
								
								<div class="form-group" style="margin-bottom: 15px;">
                            <input placeholder="enter minimum subjects to grade..." class="form-control"  type="number" id="subno" name="subno" pattern="[0-9]"/>
                          </div>
								  <div class="hidden" id="cats">
                             <div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c1"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 1 </label></div></div>
							
							<div class="form-group " style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c2"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 2 </label></div></div>
								
								<div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" id="c3" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 3 </label></div></div>

							</div>
							
							<div class="table-responsive" id="include_exams">
							
							</div>
							
							<div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
							<button style="display:;" type="button" class="btn btn-primary btn-sm btn-block" id="process_btn" value="SEARCH" style="display:;">PROCESS</button>
							
                            </div>
							
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
            $(document).ready(function () {
				
				
			$("#term").change(function () {
					var term=$("#term").val();
					var form=$("#fr option:selected").text();
               	$.ajax({
							type: 'POST',
							url:'<?php echo base_url();?>index.php/admin/exam_include/' + form.replace(" ","_") + '/' + term.replace(" ","_") ,
							
							cache: false,
							success: function(result){
								
								$("#include_exams").html(result);
							}
				});
				
				});
				
				$("#fr").change(function () {
					var term=$("#term").val();
					var form=$("#fr option:selected").text();
               	$.ajax({
							type: 'POST',
							url:'<?php echo base_url();?>index.php/admin/exam_include/' + form.replace(" ","_") + '/' + term.replace(" ","_") ,
							
							cache: false,
							success: function(result){
								
								$("#include_exams").html(result);
							}
				});
				
				});
				
				
			$("#process_btn").click(function(){
				
	
	 
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
