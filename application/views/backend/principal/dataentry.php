.p

<script>


function showUser() {
	var str = document.getElementById("fr").value;
	var str3 = document.getElementById("st").value;
	var str2 = document.getElementById("subject").value;
	var str4 = document.getElementById("year").value;
	var str5 = document.getElementById("term").value;
	var str6 = document.getElementById("examtype").value;
	 document.getElementById("paper").value='0';
    if (str == "") {
        document.getElementById("return").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("return").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","<?php echo base_url();?>support/return.php?f="+str+"&st="+str2+"&s="+str3+"&y="+str4+"&t="+str5+"&exam="+str6,true);
        xmlhttp.send();
    }
}

function showUser3() {
	
    var list = document.getElementsByClassName('marks');
var n;
for (n = 0; n < list.length; ++n) {
    list[n].value='';
}
}
</script>

       <div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('fill_in_marks');?>
            	</div>
            </div>
			<div class="panel-body">
                    
                            <div class="form-group hidden" style="margin-bottom: 15px;">
                                    <select placeholder="Select exam..." class="form-control"  id="examst" ><option value="0">Select Exam...</option>
                                  <?php
								 
								 
								  $q="SELECT term1 from exams where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								  $c=0;
								  foreach ($r as $row) :
									  $c+=1;
									 ?>
									  
									   <option   value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
								 endforeach;
								  
								  ?>
                                   </option>
									  
                                </select> </div> <hr>
								
								<?php if ($c<=0){
									?>
									<script>
										$(document).ready(function() {
											alert("");
											swal({
												title: 'NOTIFICATION',
												text: 'Sorry! Exams for your subjects are closed'
											});
										});
									</script>
									<?php
								}
								else{
									?>
							<form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">
							
							 <div class="form-group" style="margin-bottom: 15px;">
                                    <select placeholder="Select Term..." class=" form-control"  id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select> </div>
								
								 <div id="subject1" class="form-group" style="margin-bottom: 15px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="subject" onchange="showUser()"><option value="0">Select Subject...</option>
                                   <?php
								 
								 $q="SELECT Abbreviation from subjects where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								 foreach($r as $row) :
									 ?>
									  
									  <option value="<?php echo $row['Abbreviation']; ?>"><?php echo $row['Abbreviation']; ?></option>
									  <?php
								 endforeach;
								  ?>
                                   
                                </select> </div>
								
								
								 <div class="form-group  " style="margin-bottom: 15px;">
                                    <select placeholder="Select exam..." class="form-control"  id="examtype" onchange="showUserr(this.value)"><option value="t">Select Exam...</option>
                                  <?php
								  
								 
								  $q="SELECT term1 from exams where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								 foreach ($r as $row) :
									 ?>
									  
									  <option id="<?php echo $row['term1']; ?>" value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
								  endforeach;
								  
								  ?>
                                   </option>
									  
                                </select> </div>
								 <div class="form-group" style="margin-bottom: 15px;">
                                   
								<select placeholder="Select Stream..." class="form-control"  id="fr" onchange="showUser()"><option value="t">Select class...</option>
								<?php
                                   $q="SELECT * from form where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								 foreach ($r as $row) :
									 ?>
                                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								 endforeach;
								  ?>
                                </select> </div>
								
								 <div class="form-group " style="margin-bottom: 15px;">
                                    
								<select placeholder="Select Stream..." class="form-control"  id="st" onchange="showUser()"><option value="t">Select Stream...</option>
								<?php
                                   $q="SELECT * from streams where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								 foreach ($r as $row) :
									 ?>
                                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								endforeach;
								  ?>
                                </select>
								 </div>
								 <div class="form-group" style="margin-bottom: 15px;">
                                    
								<select placeholder="Select Year..." class="form-control"  id="year" onchange="showUser()"><option value="t">Select Year...</option>
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select>
								 </div> <div class="form-group" style="margin-bottom: 15px;">
                                   
								<div id="lim">
								
								</div>
								 </div>
								 <div class="form-group" style="margin-bottom: 15px;">
                                   
                            <div class="col "><input placeholder="enter limit..." class="form-control" type="text" id="limit" /></div>
                          </div>
						  
						   <div class="form-group " style="margin-bottom: 15px;">
                                   
                            <div class="col "><input placeholder="enter subject entry..." class="form-control hidden" type="text" id="entry" /></div>
                          </div>
						  
						  
								<div class="form-group" style="margin-bottom: 15px;">
                            <input placeholder="enter out of..." class="form-control" type="text" id="outof"/>
                          </div>
								
								 
								 <div class="form-group" style="margin-bottom: 15px;">
                                   
								
								 </div>
								 
								 
								
								 <div class="form-group " style="margin-bottom: 15px;">
                                    
								<div class="i-checks" id="sp"><label id="single"> <div style="position: relative;" class="icheckbox_square-green"><input checked="" style="position: absolute; opacity: 0;" id="s9ingle" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> Single subject </label></div>
								 </div>
								<div class="form-group "  style="margin-bottom: 15px;">
                            <div class="col col-sm-7 "><input placeholder="enter paper eg 1" class="form-control hidden" type="text" id="paper" style="display:;">
							<p id="error" style="color:red;display:none;"> Invalid Paper </p>
							</div>
                          </div>
								
								 <div class="form-group" style="margin-bottom: 15px;">
                                    
								<button type="button" class="btn btn-primary btn-lg btn-block hidden" id="activate" value="SEARCH" style="display:;">ACTIVATE</button>
								 </div>
								
								
								</form>
								<?php 
								}
								
								?>
								<div class="alert  alert-danger alert-dismissible fade show" role="alert" id="error_div" style="display:;">
                  <span class="badge badge-pill badge-danger"></span> <p id="errorv"></p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-="true">&times;</span>
                    </button>
                </div>
                   

						
						
					
					<div class="form-group " style="margin-bottom: 15px;">
                                    
								<div class="i-checks" id="sp"><label id="upload"> <div style="position: relative;" class="icheckbox_square-green"><input  style="position: absolute; opacity: 0;" id="up" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> Upload data </label></div>
								 </div>
								 					<div class="form-group " style="margin-bottom: 15px;">
                                    
								
								 </div>
								 
								 <div class="form-group hidden" id="updiv" style="margin-bottom: 15px;">
                                    
								
	
					<div class="form-group">
					 <a class=" " href="<?php echo base_url();?>support/uploads/data.xlsx" download="data sample file">Download blank file</a>
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('select_excel_file');?></label>
                        
						
					</div>
					
					 <form action="<?php echo base_url();?>support/upload.php" class="dropzone" id="dropzoneForm">
                                <div class="fallback">
                                    <input name="file" type="file" id="drop" multiple />
                                </div>
                            </form>
					 
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button class="btn btn-success" id="updata"><i class="entypo-upload"></i><?php echo get_phrase('upload');?></button>
						</div>
					</div>
                <div class="form-group hidden" id="gif">
						<div class="col-sm-offset-3 col-sm-5">
						Uploading please wait...	<img src='<?php echo base_url();?>loader.gif' >
						</div>
					</div>
								 </div>
								 </a>
				
<div id="return" class="">
						
						
						</div>


    
				 </div>
		 </div></div></div>
				
				
                    
                        
                        
						<!-- FILTER DATA -->
						
						
                   
                

         <script src="<?php echo base_url();?>js/plugins/dropzone/dropzone.js"></script>       

 <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>
<script src="<?php echo base_url('assets/dropzone/dropzone.js');?>"></script>
<script>
 Dropzone.options.dropzoneForm = {
            paramName: "userfile", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
			url:'<?php echo base_url();?>support/upload.php',
            dictDefaultMessage: "<strong>Drop files here or click to upload. </strong>"
        };
$(document).ready(function() {
	$("#single").click(function() {
		
		if ($("#s9ingle").prop('checked')==true){
		//alert($("#s9ingle").prop('checked'));
		$("#paper").addClass('hidden');
	}else{
		$("#paper").removeClass('hidden');
		//alert($("#s9ingle").prop('checked'));
		
		
	}
		
		
	});
	
	$("#upload").click(function() {
		
		if ($("#up").prop('checked')==true){
		//alert($("#s9ingle").prop('checked'));
		$("#updiv").removeClass('hidden');
		$("#return").addClass('hidden');
	}else{
		$("#updiv").addClass('hidden');
		$("#return").removeClass('hidden');
		//alert($("#s9ingle").prop('checked'));
		
		
	}
		
		
	});
	
	
$(".i-checks").iCheck(function(){
	//alert("");
	
	
});
	$("#examst").change(function(){
		var id2=parseInt($("#examst").val());
		var id='id=' + $("#examst").val();
		if(id2>=1){
		
		$.ajax({
		type: 'POST',
		url:'<?php echo base_url();?>support/examfetch.php',
		data: id,
		dataType: 'json',
		success: function(response){
			$("#examtype").val(response.exam);
			$("#term").val(response.term);
			$("#year").val(response.year);
			$("#fr").val(response.form);
			$("#st").val(response.stream);
			$("#limit").val(response.limit);
			//alert(response.form);
			$("#entry").removeClass("hidden");
			$("#subject1").removeClass("hidden");
			showUser();
		}
		
		});
		}else{
			
			swal({
				title: 'Select a valid exam',
				text: '',
				type: 'warning'
			});
		}
		
	});
	$("#entry").focusout(function() {
		var param="activate";
		var entry=$("#entry").val(); 
		var subject=$("#subject").val();
		var form=$("#fr").val(); 
		var stream=$("#st").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var dataString = 'entry=' + entry  + '&subject=' + subject  + '&form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&param=' + param ;
		$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>support/entry.php',
				data:dataString,
				cache:false,
				success:function(result){
					
				}
		});
		
		
		
		
		
	});
	
	$('body').on('keypress', '.marks',function(e){
		
		 var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
          
		
		
		var no_error=true;
	
		var marks=parseInt($(this).val());
		var outof=$("#outof").val();
		var limit=$("#limit").val();
		var subject=$("#subject").val();
		var single=$("#s9ingle").prop('checked');
		var paper=$("#paper").val();
		var admno=$(this).attr('id');
		var form=$("#fr").val(); 
		var stream=$("#st").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var dataString = 'marks=' + marks + '&outof=' + outof + '&limit=' + limit + '&single=' + single + '&subject=' + subject + '&paper=' + paper + '&admno=' + admno + '&form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam;
		
		if (subject ==0 ){
			
			
			swal({
					title:"ERROR!",
					text: "Invalid subject",
					type: "warning"
				});
			no_error=false;
		}
		//alert ((single==="true"));
		if ($("#s9ingle").prop('checked')==true){
			
			
			
			
			
		}else{
			
			if(paper=="" || paper<1 || paper>4){
				swal({
					title:"ERROR!",
					text: "Invalid paper",
					type: "warning"
				});
				no_error=false;
			}else{
				
				
				no_error=true;
			}
			
		}
		
		if (marks > outof){
			swal({
					title:"ERROR!",
					text: marks + "  Score can't be greater than out of  " + outof,
					type: "warning"
				});
			
			no_error=false;
		}
		if (outof <=0 ){
			
			
			swal({
					title:"ERROR!",
					text: "Invalid outof",
					type: "warning"
				});
			no_error=false;
		}
		if (limit <=0 ){
			
			swal({
					title:"ERROR!",
					text: "Invalid Limit",
					type: "warning"
				});
			no_error=false;
		}
		if (marks <=0 ){
			
			swal({
					title:"ERROR!",
					text: "Invalid Score",
					type: "warning"
				});
			no_error=false;
		}
		
		if (outof>100){
			
			swal({
					title:"ERROR!",
					text: "Invalid Out of",
					type: "warning"
				});
			no_error=false;
		}
		if (no_error){
			
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>support/save.php',
				data:dataString,
				cache:false,
				success:function(result){
					//$("#paper").val('');
					if (result>=1){
						$("#errorv").html("");
						/////$("#save" + admno).addRemove('fa fa-close');
						$("#save" + admno).addClass('fa fa-check');
							$("#save" + admno).attr("style","color:green;");
					}else{
							//$("#save" + admno).addRemove('fa fa-check');
						$("#save" + admno).addClass('fa fa-close');
						$("#save" + admno).attr("style","color:red;");
					}
					//$("#error_div").slideDown('slow');
			//$("#errorv").html(result);
				}
				
			});
		
		 $("input")[ $("input").index(this)+1].focus();
		
		}else{
			
		}
	
		
    }else{	  
	}
	});
	
	$('#updata').click(function(){
		var no_error=true;
	
	var id2=parseInt($("#examst").val());
		//var marks=parseInt($(this).val());
		var outof=$("#outof").val();
		var limit=$("#limit").val();
		//var subject=$("#subject").val();
		var single=$("#s9ingle").prop('checked');
		var paper=$("#paper").val();
		//var admno=$(this).attr('id');
		var form=$("#fr").val(); 
		var stream=$("#st").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var dataString = 'outof=' + outof + '&limit=' + limit + '&single=' + single  + '&paper=' + paper  + '&form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam;
		//alert ((single==="true"));
		if ($("#s9ingle").prop('checked')==true){
			
			
			
			
			
		}else{
			
			if(paper=="" || paper<1 || paper>4){
				swal({
					title:"ERROR!",
					text: "Invalid paper",
					type: "warning"
				});
				no_error=false;
			}else{
				
				
				no_error=true;
			}
			
		}
		
		
		if (outof <=0 ){
			
			
			swal({
					title:"ERROR!",
					text: "Invalid outof",
					type: "warning"
				});
			no_error=false;
		}
		if (limit <=0 ){
			
			swal({
					title:"ERROR!",
					text: "Invalid Limit",
					type: "warning"
				});
			no_error=false;
		}
		
		
		if (outof>100){
			
			swal({
					title:"ERROR!",
					text: "Invalid Out of",
					type: "warning"
				});
			no_error=false;
		}
		if (no_error){
			
			if(id2>=0 && parseInt($("#entry").val())>0){
				$("#gif").removeClass('hidden');
				
				alert($("#drop").val());
				
				
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>support/excel.php',
				data:dataString,
				cache:false,
				success:function(result){
					$("#gif").addClass('hidden');
					if (result>=1){
					swal({
					title:"SUCCESS!",
					text: "",
					type: "success"
				});
						$("#errorv").html("");
						$("#save" + admno).addClass('ti-check');
							$("#save" + admno).attr("style","color:green;");
					}else{
							
						$("#save" + admno).addClass('ti-close');
						$("#save" + admno).attr("style","color:red;");
					}
					//$("#error_div").slideDown('slow');
			//$("#errorv").html(result);
				}
				
			});
			}else{
			$("#subject1").addClass("hidden");
			swal({
				title: 'Select a valid exam and entry level',
				text: '',
				type: 'warning'
			});
		}
			
			
		}else{
			
		}
		  
   
	});
});

</script>
   
   
	
	


