<hr />
<div class="row">
	<div class="col-md-12">
			
			<ul class="nav nav-tabs bordered">
				<li class="active">
					<a href="#unpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('create_single_invoice');?></span>
					</a>
				</li>
				<li>
					<a href="#paid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('create_mass_invoice');?></span>
					</a>
				</li>
			</ul>
			
			<div class="tab-content">
            <br>
				<div class="tab-pane active" id="unpaid">

				<!-- creation of single invoice -->
				<?php echo form_open(site_url('admin/invoice/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
				<div class="row">
					<div class="col-md-6">
	                        <div class="panel panel-default panel-shadow" data-collapsed="0">
	                            <div class="panel-heading">
	                                <div class="panel-title"><?php echo get_phrase('invoice_informations');?></div>
	                            </div>
	                            <div class="panel-body">
	                                
	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
	                                    <div class="col-sm-9">
	                                        <select id="class_id" name="class_id" class="form-control selectboxit class_id"
	                                        	onchange="return get_class_section(this.value)">
	                                        	<option value=""><?php echo get_phrase('select_stream');?></option>
	                                        	<?php 
													$classes =  $this->db->get_where('class', array('school_id' => $this->session->userdata('school_id')))->result_array();
	                                        		foreach ($classes as $row):
	                                        	?>
	                                        	<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
	                                        	<?php endforeach;?>
	                                            
	                                        </select>
	                                    </div>
	                                </div>									 
									 
									 <div class="form-group">
		                                <label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
		                                <div class="col-sm-9">
		                                    <select name="section_id" class="form-control" style="width:100%;" id="section_selection_holder" onchange="return get_class_students(this.value)" required>
		                                        <option value=""><?php echo get_phrase('select_class');?></option>
		                                    </select>
		                                </div>
		                            </div>
									
	                                <div class="form-group">
		                                <label class="col-sm-3 control-label"><?php echo get_phrase('student');?></label>
		                                <div class="col-sm-9">
		                                    <select name="student_id" class="form-control" style="width:100%;" id="student_selection_holder" required>
		                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
		                                    </select>
		                                </div>
		                            </div>

	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('term_fee');?></label>
	                                    <div class="col-sm-9">
											<select name="title" class="form-control" style="width:100%;" id="term_selection_holder" onchange="return get_termfee('term_selection_holder')" required>
		                                        <option value=""><?php echo get_phrase('select_class_first');?></option>
		                                    </select>
	                                        <input type="hidden" name="tid" id="tid" value=""/>
	                                    </div>
	                                </div>
	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="form-control" name="description"/>
	                                    </div>
	                                </div>

	                                <div class="form-group">
	                                    <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
	                                    <div class="col-sm-9">
	                                        <input type="text" class="datepicker form-control" name="date"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
	                                    </div>
	                                </div>
	                                
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col-md-6">
                        <div class="panel panel-default panel-shadow" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo get_phrase('payment_informations');?></div>
                            </div>
                            <div class="panel-body">
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('fees');?></label>
                                    <div class="col-sm-9">
                                        <input readonly type="text" class="form-control" id="amount" name="amount"
                                            placeholder="<?php echo get_phrase('enter_total_amount');?>"
                                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('amount_paid');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="amount_paid"
                                            placeholder="<?php echo get_phrase('enter_payment_amount');?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control selectboxit">
											<option value=""><?php echo get_phrase('select');?></option>
                                            <option value="paid"><?php echo get_phrase('paid');?></option>
                                            <option value="unpaid"><?php echo get_phrase('unpaid');?></option>
                                        </select>
                                    </div>
                                </div>

                                <!--div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                                    <div class="col-sm-9">
                                        <select name="method" class="form-control selectboxit">
                                            <option value="1"><?php echo get_phrase('cash');?></option>
                                            <option value="2"><?php echo get_phrase('cheque');?></option>
                                            <option value="3"><?php echo get_phrase('card');?></option>
                                        </select>
                                    </div>
                                </div-->
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5">
                                <button type="submit" class="btn btn-info submit"><?php echo get_phrase('add_invoice');?></button>
                            </div>
                        </div>
                    </div>


	                </div>
	              	<?php echo form_close();?>

				<!-- creation of single invoice -->
					
				</div>
				<div class="tab-pane" id="paid">

				<!-- creation of mass invoice -->
				<?php echo form_open(site_url('admin/invoice/create_mass_invoice') , array('class' => 'form-horizontal form-groups-bordered validate', 'id'=> 'mass' ,'target'=>'_top'));?>
				<br>
				<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-5">

					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
                        <div class="col-sm-9">
                            <select id="massclass_id" name="class_id" class="form-control class_id2"
                            	onchange="return get_class_sectionmass(this.value)" required="">
                            	<option value=""><?php echo get_phrase('select_stream');?></option>
                            	<?php 
                            		$classes =  $this->db->get_where('class', array('school_id' => $this->session->userdata('school_id')))->result_array();
                            		foreach ($classes as $row):
                            	?>
                            	<option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                            	<?php endforeach;?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
						<div class="col-sm-9">
							<select name="section_id" class="form-control" style="width:100%;" id="section_selectionmass_holder" onchange="return get_class_students_mass(this.value)" required>
								<option value=""><?php echo get_phrase('select_class');?></option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('term_fee');?></label>
						<div class="col-sm-9">
							<select name="title" class="form-control" style="width:100%;" id="term_mass_holder" onchange="return get_termfee('term_mass_holder')" required>
								<option value=""><?php echo get_phrase('select_class_first');?></option>
							</select>
							 <input type="hidden" name="tmid" id="tmid" value=""/>
						</div>
					</div>                   

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('fees');?></label>
                        <div class="col-sm-9">
                            <input readonly type="text" class="form-control" id="total" name="amount"
                                placeholder="<?php echo get_phrase('enter_total_amount');?>"
                                    data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('amount_paid');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="amount_paid"
                                placeholder="<?php echo get_phrase('enter_payment_amount');?>"  />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                        <div class="col-sm-9">
                            <select name="status" class="form-control selectboxit">
								<option value=""><?php echo get_phrase('select');?></option>
                                <option value="paid"><?php echo get_phrase('paid');?></option>
                                <option value="unpaid"><?php echo get_phrase('unpaid');?></option>
                            </select>
                        </div>
                    </div>

                    <!--div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                        <div class="col-sm-9">
                            <select name="method" class="form-control selectboxit">
                                <option value="1"><?php echo get_phrase('cash');?></option>
                                <option value="2"><?php echo get_phrase('cheque');?></option>
                                <option value="3"><?php echo get_phrase('card');?></option>
                            </select>
                        </div>
                    </div-->

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        <div class="col-sm-9">
                            <input type="text" class="datepicker form-control" name="date"
                                data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-3">
                            <button type="submit" class="btn btn-info submit2"><?php echo get_phrase('add_invoice');?></button>
                        </div>
                    </div>
                    


				</div>
				<div class="col-md-6">
					<div id="student_selection_holder_mass"></div>
				</div>
				</div>
				<?php echo form_close();?>

				<!-- creation of mass invoice -->

				</div>
				
			</div>
			
			
	</div>
</div>

<script type="text/javascript">

	function select() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = true ;
			}

		//alert('asasas');
	}
	function unselect() {
		var chk = $('.check');
			for (i = 0; i < chk.length; i++) {
				chk[i].checked = false ;
			}
	}
</script>

<script type="text/javascript">
    function get_class_students(section_id) {
        if (section_id !== '') {
		var class_id = jQuery('#class_id').val();
        $.ajax({
            url: '<?php echo site_url('admin/get_class_students/');?>' + class_id + '/' + section_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder').html(response);
            }
        });
    }
}
</script>

<script type="text/javascript"> 
 
function get_class_section(class_id) {
	jQuery.ajax({
		url: '<?php echo site_url('admin/get_class_section/');?>' + class_id + '/1',
		success: function(response)
		{  
			jQuery('#section_selection_holder').html(response);
		}
	});
	
	jQuery.ajax({
		url: '<?php echo site_url('admin/get_terms/');?>' + class_id,
		success: function(response)
		{  
			jQuery('#term_selection_holder').html(response);
			
			var tamt = jQuery('#term_selection_holder option:selected').attr('tamt');			 
			jQuery('#amount').val(tamt);
		}
	});
}

function get_termfee(selection) {
		
	var tamt = jQuery('#'+selection+' option:selected').attr('tamt');	
	var tid = jQuery('#'+selection+' option:selected').attr('tid');	
	
	if(selection == 'term_mass_holder'){ jQuery('#tmid').val(tid); jQuery('#total').val(tamt); }
	else{ jQuery('#tid').val(tid); jQuery('#amount').val(tamt); }
}	

function get_class_sectionmass(class_id) {
	jQuery.ajax({
		url: '<?php echo site_url('admin/get_class_section/');?>' + class_id + '/1',
		success: function(response)
		{  
			jQuery('#section_selectionmass_holder').html(response);
		}
	});
	jQuery.ajax({
		url: '<?php echo site_url('admin/get_terms/');?>' + class_id + '/1',
		success: function(response)
		{  
			jQuery('#term_mass_holder').html(response);			
			var tamt = jQuery('#term_mass_holder option:selected').attr('tamt');			
			jQuery('#total').val(tamt);
			
		}
	});
}
 
</script>

<script type="text/javascript">
var class_id = '';
jQuery(document).ready(function($) {
    $('.submit').attr('disabled', 'disabled');	
	
});
    function get_class_students_mass(section_id) {
    	if (section_id !== '') {
		var class_id = jQuery('#massclass_id').val();
        $.ajax({
            url: '<?php echo site_url('admin/get_class_students_mass/');?>'  + class_id + '/' + section_id ,
            success: function(response)
            {
                jQuery('#student_selection_holder_mass').html(response);
            }
        });
      }
    }
    function check_validation(){
        if (class_id !== '') {
            $('.submit').removeAttr('disabled');
        }
        else{
            $('.submit').attr('disabled', 'disabled');
        }
    }
    $('.class_id').change(function(){
        class_id = $('.class_id').val();
        check_validation();
    });
</script>