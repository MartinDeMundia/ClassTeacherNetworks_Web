<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('terms_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_term');?>
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
							<th><div><?php echo get_phrase('stream');?></div></th>
                    		<th><div><?php echo get_phrase('title');?></div></th>  			 					 
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($terms as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;?></td>	
							<td><?php echo $row['title'];?></td>		 						
							 
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_term/'.$row['id']);?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
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
                	<?php echo form_open(site_url('admin/terms/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div> 
							<!--div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('fees');?></label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" name="fees" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div-->  
							
							<div class="form-group">
								<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
								
								<div class="col-sm-5">
									<select name="class_id" class="form-control" required>
									  <option value=""><?php echo get_phrase('select');?></option>
									  <?php 
											$school_id = $this->session->userdata('school_id');
											$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
											foreach($classes as $row):
												?>
												<option value="<?php echo $row['class_id'];?>">
														<?php echo $row['name'];?>
														</option>
											<?php
											endforeach;
										?>
								  </select>
								</div> 
							</div>
							 							 
                             
                        </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_term');?></button>
                              </div>
							</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
		</div>
	</div>
</div>

