	 <div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('score_sheet');?>
            	</div>
            </div>
			<div class="panel-body">
					 
					<form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">
                                <div class="form-group" style="margin-bottom: 35px;">
                                    
                                    <select class="form-control " tabindex="1" id="fr" ><option value="1">Select Class...</option>
								<?php
                                   $q="SELECT * from form where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								 foreach ($r as $row) :
									 ?>
                                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								 endforeach;
								  ?>
                                </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 35px;">
                                    
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="Streams" ><option value="t">Select Stream...</option>
								<?php
                                   $q="SELECT * from streams where school_id='".$this->session->userdata('school_id')."'";
								  $r=$this->db->query($q)->result_array();;
								 foreach ($r as $row) :
									 ?>
                                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								endforeach;
								  ?><option  value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="year">
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
                             <div class="form-group" style="margin-bottom: 35px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="subject" onchange=""><option value="t">Select Subject...</option>
                                 <?php
								 
								 $q="SELECT Abbreviation from subjects ";
								  $r=$this->db->query($q)->result_array();;
								 foreach($r as $row) :
									 ?>
									  
									  <option value="<?php echo $row['Abbreviation']; ?>"><?php echo $row['Abbreviation']; ?></option>
									  <?php
								 endforeach;
								  ?>
                                   
                                   
                                </select> </div><div class="form-group" style="margin-bottom: 35px;">
                            <input placeholder="enter CUT OFF grade..." class="form-control bg-warning"  type="text" id="cutoff" name="subno" pattern="[0-9]"/>
                          </div>
                               <div class="form-group" style="margin-bottom: 35px;">
                                <button class="ladda-button ladda-button-demo btn btn-primary" id="bsearch" data-style="zoom-in"><i class="fa fa-search"></i>search</button>    </div><div class="form-group" style="margin-bottom: 35px;">
                                <button class="ladda-button ladda-button-demo btn btn-primary" id="print_btn" data-style="zoom-in"><i class="fa fa-search"></i>Print</button>    </div>
                            </form>
					 
					 
					 
				 </div>
		 </div></div></div>	 
			<div class="row">
	<div class="col-lg-12">
                    <div class="ibox">
					
					<div class="ibox-title">
                       
						
                        <div class="ibox-tools">
                            
                            <a href="#" id="prt" class="hidden" download="Score Sheet">
                                <i class="fa fa-2x fa-print" >Print</i>
                            </a>
                        </div></div>
                        <div class="ibox-content" id="ibox2">
                            







           

                        </div>
                    </div>
                </div>
</div>		 
							

<a href="<?php echo base_url();?>support/score1.pdf" download="" id="prt" class="hidden">


    <script id="script">
        $(document).ready(function() {
			
			$("#bsearch").click(function() {
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				var cuttoff=encodeURIComponent($("#cutoff").val());
				//$("#prt").addClass("hidden");
     var subjects=$("#subject").val();
					var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var form=$("#fr").val();
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
				$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>index.php/admin/score_sheet',
		data:dataString,
		cache:false,
		success:function(result){
			$("#ibox2").html(result);
			$("#prt").removeClass("hidden");
		},
			complete: function(result){
				
				
				
				
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				
				
				
				
			}
		
		
	});
		return false;
				
			});
			
	$("#print_btn").click(function() {
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				var cuttoff=encodeURIComponent($("#cutoff").val());
				//$("#prt").addClass("hidden");
     var subjects=$("#subject").val();
					var stream=$("#Streams").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var form=$("#fr").val();
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
	$.ajax({
		type:'POST',
		url:'<?php echo base_url();?>index.php/admin/score_sheet_print',
		data:dataString,
		cache:false,
		success:function(result){
			
		},
			complete: function(result){
				//$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				
				$("#prt").attr("download","FORM " + form + "  " + stream + "  " + term + "  " + exam + "  " + "   " + subjects + "  SCORE SHEET " + year);
				$("#prt").attr("href","<?php echo 'application/views/'.$this->session->userdata('pdf').'.pdf' ; ?>");
			}
		
		
	});
	
	return false;
	
	});
	
			
			
		});
        
    </script>