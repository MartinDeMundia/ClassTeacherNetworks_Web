<hr />
<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
                    <?php echo get_phrase('media_list'); ?>
                </a></li>
            <li>
                <a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_media'); ?>
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

                                <?php include 'medialist.php'; ?>

                            </div>
                             
                        </div>


                    </div>

                </div>
            </div>
            <!----TABLE LISTING ENDS--->


            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(site_url('teacher/media/create') , array(
                      'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data',
                        'target' => '_top')); ?>
						
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>
                        <div class="col-sm-5">
                            <select required data-validate="required" name="type_id" class="form-control" >
							 <option value=''>select</option>
							 <option value='1'>Document</option>
							 <option value='2'>Photo</option>
							 <option value='3'>Video</option>
							 </select>
                        </div>
                    </div>						
					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
						  <div class="col-sm-5">
						<select name="class_id" class="form-control" id = 'class_id' onchange="get_class_section()">
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
						<select name="section_id" id="section_id" class="form-control" >
							<option value=""><?php echo get_phrase('select_class_first');?></option>	
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
                      <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Files');?></label>
                      <div class="col-sm-7">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                           <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                          <div>
                            <span class="btn btn-white btn-file">
                              <span class="fileinput-new"><?php echo get_phrase('select_media_file'); ?></span>                             
                              <input type="file" name="media" >
                            </span>
                           
                          </div>
                        </div>
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

</script>
