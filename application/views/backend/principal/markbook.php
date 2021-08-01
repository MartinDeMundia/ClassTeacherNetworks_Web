
<div class="wrapper wrapper-content animated bounceIn">

                <div class="p-w-md m-t-sm">
				<div class="">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox" id="ibox1">
                    <div class="ibox-title">
                        <h2>MARKBOOK</h2>
                        <div class="ibox-tools">
                           
                            <a href="../PDFS/markbook2.pdf" id="prt" download="Markbook" class="hidden down">
                                <i class="fa fa-2x fa-print" ></i>
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


<!--                                 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                    <select class="form-control " tabindex="1" id="fr" ><option value="t">Select Class...</option>
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
 -->

		                         <div class="form-group" style="margin-bottom: 35px;">
		                            <select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
		                                <option value="">Select class</option>
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


                               <!--  <div class="form-group" style="margin-bottom: 35px;">
                                    
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="Streams" ><option value="t">Select Stream...</option>
								<?php
                                   $q="SELECT * from streams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option  value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?><option  value="">ALL</option>
                                </select>
                                </div>
 -->

								 <!-- <div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select>
                                </div>
 -->
			                     <div class="form-group" style="margin-bottom: 35px;">
			                        <select placeholder="Select Term..." class=" form-control"  id="term" name="term">
			                            <option value="">Select Term...</option>
			                            <option value="Term 1">Term 1</option>
			                            <option value="Term 2">Term 2</option>
			                            <option value="Term 3">Term 3</option>
			                        </select> 
			                    </div>


								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                 <select data-placeholder="" class="form-control " tabindex="1" id="year" name="year"><option selected value="t">Select Year...</option>
                                 	    <option value="<?php echo date("Y"); ?>" selected><?php echo date("Y"); ?></option>
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select> </div>

                              <div class="form-group  " style="margin-bottom: 35px;">
		                        <select placeholder="Select exam..." class="form-control"  id="examtype" name="examtype" ><option value="">Select Exam...</option>
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

		                        </select>
		                    </div>
                                
                                 

        <!--                           <div class="form-group" style="margin-bottom: 35px;">
                                    <select data-placeholder="Choose exam..." class="form-control " tabindex="1" id="examtype"><option selected value="t">Select Exam...</option>
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
									  
                                </select> </div> -->



<!--                              <div class="form-group" style="margin-bottom: 35px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="subject" onchange="showUser()"><option value="t">Select Subject...</option>
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
                                   
                                </select> </div> -->


                         <div id="subject1" class="form-group" style="margin-bottom: 35px;">

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
		                                <option value="<?php echo $row['name'];?>"
		                                    <?php if($subject_id == $row['subject_id']) echo 'selected';?>>
		                                    <?php echo $row['name'];?>
		                                </option>
		                            <?php endforeach;?>
		                        </select>
		                    </div>


								<div class="form-group" style="margin-bottom: 35px;">
                            <input placeholder="enter CUT OFF grade..." class="form-control bg-warning"  type="text" id="cutoff" name="subno" pattern="[0-9]"/>
                          </div>

                          <div class="form-group" style="margin-bottom: 35px;float:right !important;">
							<button  class="ladda-button ladda-button-demo btn btn-primary" id="bsearch" data-style="zoom-in"><i class="fa fa-search" onclick="showUser();"></i>&nbsp;view</button>
							<button class="ladda-button ladda-button-demo btn btn-primary" id="print_btn" data-style="zoom-in"><i class="fa fa-print" ></i>&nbsp;print</button>						
						
						</div>
								
								  <div class="hidden" id="cats">
                             <div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c1"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 1 </label></div></div>
							
							<div class="form-group " style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c2"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 2 </label></div></div>
								
								<div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" id="c3" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 3 </label></div></div>
							</div>
                            </form>
							
							 			
					
					 </div>
 </div>
    </div>
	 </div>	
		
		 </div>
		 <div id="bs">
		 
		<div class="spiner-example hidden" id="loader">
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
		 <a href="" download="Markbook" id="print_a" class="">download</a>
		 <div id="bs2" class="hidden">
		 <span width="100%" height="100%"></span>
		 <img class="hidden" src="uploads/preloader.gif" id="loader">
		 </div>
		 </div></div></div>
		  <script>



$("#print_btn").click(function(){

		$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
			var cuttoff=encodeURIComponent($("#cutoff").val());				
	        var subjects=$("#subject_holder").val();
			var stream=$("#section_holder").val();
			var year= $("#year").val();
			var term=$("#term").val();
			var exam=$("#examtype").val();
			var form=$("#class_id").val();

			var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>index.php/admin/markbook_print',
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

    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
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

		 
		 
		 
		$(document).ready(function() {
			  function check() {	
				
				
			}
			 
			 $("#print").click(function(){
				  var cuttoff=encodeURIComponent($("#cutoff").val());
				 var subjects=$("#subject").val();
					var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var form=$("#fr option:selected").text();
		var adm="";
		var s="";
		
		if((subjects == "") & (stream == "")  & (year == "")  & (term == "")  & (exam == "")  & (form == "")  ){
			swal({
				title: 'ERROR',
				text : 'Invalid options ',
				type: 'warning'
			});
			}
		else{
				  $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
               
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
				$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>index.php/admin/mark_book_print',
		data:dataString,
		cache:false,
		success:function(result){
			$("#bs").html(result);
			$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
		},
		complete:function(result){
			
			$('#print_a').attr('href','<?php echo __DIR__ .'application/views/backend/'.$this->session->userdata('pdf');?>'+ result);
			//$('#print_a')[0].click();
		}

				});		
			
		}
		return false;
			});
			 
			 
			 
			 
			 
			 
			 
	$("#bsearch").click(function() {	

			var cuttoff=encodeURIComponent($("#cutoff").val());			
			var exam=$("#examtype").val();			
			var form=$("#class_id").val();
			var stream=$("#section_holder").val();
			var term=$("#term").val();
			var year=$("#year").val();
			var subjects=$("#subject_holder").val();			
			var adm="";
			var s="";
		
		if((subjects == "") & (stream == "")  & (year == "")  & (term == "")  & (exam == "")  & (form == "")  ){
			swal({
				title: 'ERROR',
				text : 'Invalid options ',
				type: 'warning'
			});
			}
		else{
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
               
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
				$.ajax({
					type:'POST',
					url:'<?php echo base_url();?>index.php/admin/mark_book',
					data:dataString,
					cache:false,
					success:function(result){
					$("#loader").addClass("hidden");
						$("#bs").html(result);
					if (result>=1){
						
						
						
						
						
					}
			else{
			
			}//location.reload();
		},
			complete: function(result){
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				//$("#prt").removeClass("hidden");
				//$("#prt").attr("download","FORM " + form + "  " + stream + "  " + term + "  " + exam + "  " + subject + "  " + "MARKBOOK " + year);
				//$("#prt")[0].click();
			}
		
		
	}); 
	 
			
			
			
		}
				return false;
				
			});
			

		
			
		 });
		 </script>