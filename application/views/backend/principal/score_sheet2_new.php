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
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="year">
                                   	<option value="2019">2019</option>
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


                             <!--    <div class="form-group" style="margin-bottom: 35px;">
                            <input placeholder="enter CUT OFF grade..." class="form-control bg-warning"  type="text" id="cutoff" name="subno" pattern="[0-9]"/>
                          </div> -->
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
                       
						
                        <!-- <div class="ibox-tools">
                            
                            <a href="#" id="prt" class="hidden" download="Score Sheet">
                                <i class="fa fa-2x fa-print" >Print</i>
                            </a>
                        </div> -->
                    </div>
                        <div class="ibox-content" id="ibox2">
                            







           

                        </div>
                    </div>
                </div>
</div>		 
							

<a href="<?php echo base_url();?>support/score1.pdf" download="" id="prt" class="hidden">


    <script id="script">


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
			
			$("#bsearch").click(function() {
				$('#ibox1').children('.ibox-content').toggleClass('sk-loading');
				var cuttoff=encodeURIComponent($("#cutoff").val());			
		        var subjects=$("#subject_holder").val();
				var stream=$("#section_holder").val();
				var year=$("#year").val();
				var term=$("#term").val();
				var exam=$("#examtype").val();
				var form=$("#class_id").val();
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
		        var subjects=$("#subject_holder").val();
				var stream=$("#section_holder").val();
				var year=$("#year").val();
				var term=$("#term").val();
				var exam=$("#examtype").val();
				var form=$("#class_id").val();
				var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&subject=' + subjects + '&cuttoff=' + cuttoff;
				$.ajax({
					type:'POST',
					url:'<?php echo base_url();?>index.php/admin/score_sheet_print',
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
			
			
	});
        
</script>