
<div class="wrapper wrapper-content animated bounceIn">

                <div class="p-w-md m-t-sm">
				<div class="">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox" id="ibox1">
                    <div class="ibox-title">
                        <h2>BROAD SHEET</h2>
                        <div class="ibox-tools">
                            <a href="../PDFS/broadsheet.pdf" id="prt" download="" class="hidden">
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
                                <div class="form-group" style="margin-bottom: 35px;">
                                    
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
                                <div class="form-group" style="margin-bottom: 35px;">
                                    
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
								 <div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="year"><option selected value="t">Select Year...</option>
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select> </div>
                                
                                  <div class="form-group" style="margin-bottom: 35px;">
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
									  
                                </select> </div>
                             <div class="form-group hidden" style="margin-bottom: 35px;">
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
                                   
                                </select> </div>
								
								<div class="form-group" style="margin-bottom: 35px;">
                            <input placeholder="enter CUT OFF grade..." class="form-control bg-warning"  type="text" id="cutoff" name="subno" pattern="[0-9]"/>
                          </div>
								  <div class="hidden" id="cats">
                             <div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c1"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 1 </label></div></div>
							
							<div class="form-group " style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" value="" type="checkbox" id="c2"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 2 </label></div></div>
								
								<div class="form-group" style="margin-bottom: 35px;margin-left: 35px;">
								
										
								<div class="i-checks"><label class=""> <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" id="c3" value="" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;" class="iCheck-helper"></ins></div> <i></i> CAT 3 </label></div></div>
							</div><div class="form-group" style="margin-bottom: 35px;">
							<button class="ladda-button ladda-button-demo btn btn-primary" id="print" data-style="zoom-in"><i class="fa fa-search" onclick="showUser();"></i>print</button>
							</div>
							<div class="form-group" style="margin-bottom: 35px;">
							<button class="ladda-button ladda-button-demo btn btn-primary" id="bsearch" data-style="zoom-in"><i class="fa fa-search" onclick="showUser();"></i>view</button></div>
					 </div><h5 id="title" class="hidden">Progress</h5>
							<div class="progress hidden">
                                <div class="progress-bar  progress-bar-animated progress-bar-success " style="width: 0%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							
							
                            </form>
							
							 			
					 
					
 </div>
    </div>
	 </div>	
		<a href="" download="broadsheet" id="print_a"></a>
		 </div>
		 <div id="load_sheet">
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
		 
		 </div></div></div>
		  <script>
            $(document).ready(function () {
			
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>
		 <script>

        $(function(){

            $('#bsearch').on('click', function(){

               

            })

        })

    </script>
		 <script>
		 
		 
		 
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
		
		if((subjects == "t") & (stream == "t")  & (year == "t")  & (term == "t")  & (exam == "t")  & (form == "t")  ){
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
		url:'<?php echo base_url();?>index.php/admin/printsheet',
		data:dataString,
		cache:false,
		success:function(result){
			
			$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
		},
		complete:function(result){
			
			
		}

				});		
			
		}
		return false;
			});
			 
			 
			 
			 
			 
			 
			 
			 $("#bsearch").click(function() {
				// $("#bs").load("<?php echo base_url();?>markbook.php");
				 ////setTimeout(check,3000);
	 var cuttoff=encodeURIComponent($("#cutoff").val());
				 var subjects=$("#subject").val();
					var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var form=$("#fr option:selected").text();
		var adm="";
		var s="";
		
		if((subjects == "t") & (stream == "t")  & (year == "t")  & (term == "t")  & (exam == "t")  & (form == "t")  ){
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
		url:'<?php echo base_url();?>index.php/admin/broad_sheet',
		data:dataString,
		cache:false,
		success:function(result){
			$("#loader").addClass("hidden");
				$("#load_sheet").html(result);
			if (result>=1){
				
				
				
				$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>index.php/admin/printsheet.php',
		//data:dataString,
		cache:false,
		success:function(result){
			if (result>=1){
			
			}
			else{
			
			}//location.reload();
		}, 
					complete: function(){
						//$("#prt")[0].click();
						
					}
		
		
		});
				
			}
			else{
			
			}//location.reload();
		},
			complete: function(result){
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				//$("#prt").removeClass("hidden");
				//$("#prt").attr("download","FORM " + form + "  " + stream + "  " + term + "  " + exam + "  " + "BROAD SHEET " + year);
				//$("#prt")[0].click();
			}
		
		
	}); 
	 
			
			
			
		}
				return false;
				
			});
			

			$("#examtype").change(function() {
//alert($("#examtype").val());
			if ($("#examtype").val()=="END OF TERM"){
				
				$("#cats").removeClass("hidden");
			}else{
				$("#cats").addClass("hidden");
			}
				
			});
			
		 });
		 
		 </script>