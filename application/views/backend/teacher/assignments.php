<hr />
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
                    <?php echo get_phrase('assignments_list'); ?>
                </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_assignment'); ?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------>


        <div class="tab-content">
            <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <div class="row">

                    <div class="col-md-12">

                        

                        <div class="tab-content">
                             
                            <div class="tab-pane active" id="running">

                                <?php include 'assignments_list.php'; ?>

                            </div>
                             
                        </div>


                    </div>

                </div>
            </div>
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(site_url('teacher/assignments/create') , array(
                      'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data',
                        'target' => '_top')); ?>
						
                    
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
						  <div class="col-sm-5">
						<select required name="class_id" class="form-control selectboxit" id = 'class_id' onchange="get_class_section()">
							<option value=""><?php echo get_phrase('select_a_stream');?></option>
							<?php 
							$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
							foreach($classes as $row):
							?>
								<option value="<?php echo $row['class_id'];?>"
									<?php if ($class_id == $row['class_id']) echo 'selected';?>>
										<?php echo $row['name'];?>
								</option>
							<?php
							endforeach;
							?>
						</select>
						</div>
					</div>
			 
					<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
					  <div class="col-sm-5">
						<select required name="section_id" id="section_id" class="form-control"  onchange="get_class_subject()">
							<option value=""><?php echo get_phrase('select_class_first');?></option>	
						</select>
						</div>
					</div>	
					
					<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
					  <div class="col-sm-5">
						<select required name="subject_id" id="subject_id" class="form-control" onchange="get_class_subject_periord(this.value)">
							<option value=""><?php echo get_phrase('select_section_first');?></option>
						</select>
						</div>
					</div>
					
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="title" required />
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><?php echo get_phrase('details'); ?></label>
                  		<div class="col-sm-5">
                  		  <textarea required class="form-control" rows="5" name="details"></textarea>
                  		</div>
                  	</div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('given_date'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="datepicker form-control" name="given_date"
                              value="<?php echo date('m/d/Y');?>" required />
                        </div>
                    </div>
					
					 <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('due_date'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="datepicker form-control" name="due_date"
                              value="<?php echo date('m/d/Y');?>" required />
                        </div>
                    </div>                                  

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" id="submit_button" class="btn btn-info"><?php echo get_phrase('add'); ?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!----CREATION FORM ENDS-->

        </div>
    </div>
</div>

<script type="text/javascript">

function get_class_section() {
		var class_id = $("#class_id").val();
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {				 
                $('#section_id').html(response);
            }
        });         
	  }  
	   
	}	
	function get_class_subject() {
		
		var class_id =  jQuery('#class_id').val();
		var section_id =  jQuery('#section_id').val();
		if (class_id !== '' && section_id !='') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
            success: function(response)
            {
                $('#subject_id').html(response);				
				 
            }			
			
        });         
	  }
	  
	}

</script>