<hr />
<div class="row">

	<div class="btn-group" style="float:right; margin:30px 5px 20px 0px; "  >
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		Print Option <span class="caret"></span>
		</button>
		<ul class="dropdown-menu dropdown-default pull-right" role="menu">
			<?php 
			$school_id = $this->session->userdata('school_id');
			$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
			$class_idp = ($classes[0]['class_id']);											
			?>
			<li>
			<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_class_subjects_print/');?>');">
			<i class="entypo-pencil"></i>
			<?php echo get_phrase('stream_subject'); ?>
			</a>
		</li>										
		</ul>
	</div>



	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('stream_subjects_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_stream_subject');?>
                    	</a></li>			
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('subject code');?></div></th>                   			
                    		<th><div><?php echo get_phrase('subject_name');?></div></th>
                    		<th><div>Subject Type</div></th>                    			
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($class_subjectss as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['id'];?></td>														
							<td><?php echo $row['subject'];?></td>
							<?php
							if($row['is_elective'] == 0){
								$subjnature = "Main Subject";
							}else if($row['is_elective'] == 1){
                                $subjnature = "Elective Subject";
							}else if($row['is_elective'] == 2){
                                $subjnature = "Non Examinable Subject";
							}else{
                                 $subjnature = "Not Set";
							}
							?>
                            <td><?php echo $subjnature;?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>										
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_class_subject/'.$row['id']);?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                        </a>										
                                    </li>


                                   <li class="divider"></li>

                                    <!-- EDITING LINK -->
                                    <li>										
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_add_sub_subject/'.$row['id']);?>');">
                                            <i class="entypo-plus"></i>
                                                Add a sub subject (e.g Paper 1, Paper 2, Composition , Insha)
                                        </a>										
                                    </li>

                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/class_subjects/delete/'.$row['id']);?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete');?>
										</a>
                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(site_url('admin/class_subjects/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="">
						<label class="col-sm-3 control-label"><?php echo get_phrase('subject_type');?></label>
						<div class="form-group">
                                <div class="col-sm-5">
                                    <select name="is_elective" class="uniform" style="width:50%;height: 35px;border: 1px solid #ebebeb;" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" onchange = "return val(this.value);">							    
                                    	<option>Select subject type</option>
										<option value="0"><?php echo get_phrase('Main Subject');?></option>
                                    	<option value="1"><?php echo get_phrase('Elective Subject');?></option>
                                    	<option value="2">Non Examinable Subject</option>
                                    </select>
                                </div>								
						</div>						
						</div>	
						<div class="" id = "extradiv" style ="display:none">
						<label class="col-sm-3 control-label"><?php echo get_phrase('subject_group');?></label>
						<div class="form-group">
								
                                <div class="col-sm-5">
                                    <select name="subject_group" class="uniform" style="width:50%;height: 35px;border: 1px solid #ebebeb;" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">									    
                                    	<option>Select Group</option>										
                                    	<option value="g2"><?php echo get_phrase('group_2');?></option>
                                    	<option value="g3"><?php echo get_phrase('group_3');?></option>
                                    	<option value="g4"><?php echo get_phrase('group_4');?></option>
                                    	<option value="g5"><?php echo get_phrase('group_5');?></option>
                                    </select>
                                </div>
                        </div>
                        </div>
						
						<div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject_name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="subject" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>	
                                </div>								
                            </div>													
                        </div>
						<div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('subject_code');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="subject_code" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>	
                                </div>								
                            </div>													
                        </div>
						<div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('total_marks_out_of');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="total_marks_out_of" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>	
                                </div>								
                            </div>													
                        </div>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo get_phrase('Select Subject Parts');?></label>
							<div class="col-sm-5">
								<select name ="parts" id="colorselector" class="uniform" style="width:50%;height: 35px;border: 1px solid #ebebeb;" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
									 <option value="0"><?php echo get_phrase('Select Subject Parts');?></option>
									 <option value="2"><?php echo get_phrase('Subject with 2 Part');?></option>
									 <option value="3"><?php echo get_phrase('Subject with 3 Part');?></option>
									 <option value="4"><?php echo get_phrase('Subject with 4 Part');?></option>
							   </select>
						    </div>
						</div>
						
					<div class="form-group">		
						<div id="2" class="colors padded" style="display:none;">                            
							<div class="form-group">							
								<label class="col-sm-3 control-label"><?php echo get_phrase('part1');?></label>
                                <div class="col-sm-3">
									<input type="text" class="form-control" name="part1"/>					
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part1_mark"/>					
								</div>								
							</div> 
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part2');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part2" />
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part2_mark"/>					
								</div>								
							</div>
											
                        </div>
						
						<div id="3" class="colors padded" style="display:none;"> 
						
						<div class="form-group">							
								<label class="col-sm-3 control-label"><?php echo get_phrase('part1');?></label>
                                <div class="col-sm-3">
									<input type="text" class="form-control" name="part3"/>					
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part3_mark"/>					
								</div>								
							</div> 
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part2');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part4" />
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part4_mark"/>					
								</div>								
							</div>
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part3');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part5" />
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part5_mark"/>					
								</div>								
							</div>	
						 </div>
						 
						 
						 
						 <div id="4" class="colors padded" style="display:none;"> 
						
						<div class="form-group">							
								<label class="col-sm-3 control-label"><?php echo get_phrase('part1');?></label>
                                <div class="col-sm-3">
									<input type="text" class="form-control" name="part6"/>					
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part6_mark"/>					
								</div>								
							</div> 
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part2');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part7" />
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part7_mark"/>					
								</div>								
							</div>
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part3');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part8" />
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part8_mark"/>					
								</div>								
							</div>	
							
								<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('part4');?></label>
                                <div class="col-sm-3">										
									<input type="text" class="form-control" name="part9" />
								</div>
								<label class="col-sm-2 control-label"><?php echo get_phrase('maximum_mark_in_%');?></label>
								<div class="col-sm-1">
									<input type="text" class="form-control" name="part9_mark"/>					
								</div>								
							</div>	
							
						 </div>
						 
					 </div>
						 

                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_stream_subject');?></button>
                              </div>
						</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
			
			<!----ADD OFFER SUBJECT FORM STARTS---->
			                
			</div>
			
			<!----ADD OFFER SUBJECT FORM ENDS---->
		</div>
	</div>
</div>



<hr />






<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
	
	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export_offer").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
	
function myFunction() {
    var x = document.getElementById("sub_parts");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}






function myFunction1() {
    var x = document.getElementById("sub_parts1");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function myFunction2() {
    var x = document.getElementById("sub_parts2");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function myFunction3() {
    var x = document.getElementById("sub_parts3");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}


function val(x)
{
    if (x =="1" )
    {
            document.getElementById("extradiv").style.display ="block";
    }else
    {
            document.getElementById("extradiv").style.display = "none";
    }	

}






$(function() {
  $('#colorselector').change(function(){
    $('.colors').hide();
    $('#' + $(this).val()).show();
  });
});
		
</script>