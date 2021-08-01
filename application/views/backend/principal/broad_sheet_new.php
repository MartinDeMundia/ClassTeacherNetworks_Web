
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
	                                <select name="section_id" id="section_holder" onchange="" class="form-control">
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
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="year"><option selected value="t">Select Year...</option>
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

			                        </select> 
			                    </div>






								
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
							</div>


							<div class="form-group" style="margin-bottom: 35px;">
							    <button class="ladda-button ladda-button-demo btn btn-primary" id="bsearch" data-style="zoom-in"><i class="fa fa-search" onclick="showUser();"></i>view</button>
						   </div>

							<div class="form-group" style="margin-bottom: 35px;">
							    <button class="ladda-button ladda-button-demo btn btn-primary" id="print_btn" data-style="zoom-in"><i class="fa fa-print" ></i>print</button>
							</div>

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
							url:'<?php echo base_url();?>index.php/admin/broad_sheet_print',
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


        $(function(){

            $('#bsearch').on('click', function(){

               

            })

        })



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
			var subjects=$("#subject_holder").val();
			var stream=$("#section_holder").val();
			var year=$("#year").val();
			var term=$("#term").val();
			var exam=$("#examtype").val();
			var form=$("#class_id").val();
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