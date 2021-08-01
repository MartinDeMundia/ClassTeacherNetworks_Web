

			<div class="wrapper wrapper-content animated bounceIn">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox" id="ibox1">
                    <div class="ibox-title">
                        <h2> SCORE SHEET</h2>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                             <a href="../PDFS/score.pdf" id="prt" download="Score Sheet">
                                <i class="fa fa-2x fa-print " ></i>
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
                                    
                                    <select class="form-control select2" tabindex="1" id="fr" ><option value="1">Select Form...</option>
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
                                    
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="Streams" ><option value="t">Select Stream...</option>
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
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="year">
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select> </div>
                                
                                  <div class="form-group" style="margin-bottom: 35px;">
                                    <select data-placeholder="Choose exam..." class="form-control select2" tabindex="1" id="examtype"><option selected value="t">Select Exam...</option>
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
									   <option  value="all">ALL</option>
                                </select> </div>
                             <div class="form-group" style="margin-bottom: 35px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="subject" onchange=""><option value="t">Select Subject...</option>
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
                                <button class="ladda-button ladda-button-demo btn btn-primary" id="bsearch" data-style="zoom-in"><i class="fa fa-search"></i>search</button>    </div>
                            </form>
					 
					 
					 
					 
					 
							</div>
								
 </div>
    </div><div class="row hidden">
	<div class="col-lg-12">
                    <div class="ibox">
					
					<div class="ibox-title">
                       
						
                        <div class="ibox-tools">
                            
                            <a href="../PDFS/score.pdf" id="p rt" download="Score Sheet">
                                <i class="fa fa-2x fa-print" ></i>
                            </a>
                        </div></div>
                        <div class="ibox-content">
                            <div class="text-center pdf-toolbar">

                            <div class="btn-group">
                                <button id="prev" class="btn btn-white"><i class="fa fa-long-arrow-left"></i> <span class="hidden-xs">Previous</span></button>
                                <button id="next" class="btn btn-white"><i class="fa fa-long-arrow-right"></i> <span class="hidden-xs">Next</span></button>
                                <button id="zoomin" class="btn btn-white"><i class="fa fa-search-minus"></i> <span class="hidden-xs">Zoom In</span></button>
                                <button id="zoomout" class="btn btn-white"><i class="fa fa-search-plus"></i> <span class="hidden-xs">Zoom Out</span> </button>
                                <button id="zoomfit" class="btn btn-white"> 100%</button>
                                <span class="btn btn-white hidden-xs">Page: </span>

                            <div class="input-group">
                                <input type="text" class="form-control" id="page_num">

                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-white" id="page_count">/ 22</button>
                                </div>
                            </div>
  
                                </div>
                        </div>







            <div class="text-center m-t-md table-responsive">
                <canvas id="the-canvas" class="pdfcanvas border-left-right border-top-bottom b-r-md"></canvas>
            </div>

                        </div>
                    </div>
                </div>
</div></div></div></div></div>

	<script>
		
	</script>




    <script id="script">
        $(document).ready(function() {
			
			$("#bsearch").click(function() {
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				
				var l = Ladda.bind('.ladda-button-demo');
     var subjects=$("#subject").val();
					var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var form=$("#fr").val();
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects;
				$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>sc.php',
		data:dataString,
		cache:false,
		success:function(result){
			if (result>=1){
				
			}
			else{
			
			}//location.reload();
		},
			complete: function(result){
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				$("#prt").removeClass("hidden");
				$("#prt").attr("download","FORM " + form + "  " + stream + "  " + term + "  " + exam + "  " + "   " + subjects + "  SCORE SHEET " + year);
				//$("#prt")[0].click();
			}
		
		
	});
				return true;
				
			});
			
		});
        
    </script>
