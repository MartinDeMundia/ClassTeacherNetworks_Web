<style>
.tab-content{
    overflow-x:hidden;
}
</style>
<div class="wrapper wrapper-content animated fadeIn">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>EXAM NAMES</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">
<div class="table-responsive">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('exam_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_exam');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <table  class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('exam_name');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
                    		<th><div><?php echo get_phrase('comment');?></div></th>
							<th><div><?php echo get_phrase('Limit');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php foreach($exams as $row):?>
                        <tr>
							<td><?php echo $row['Term1'];?></td>
							<td><?php echo $row['date'];?></td>
							<td><?php echo $row['comment'];?></td>
							<td><?php echo $row['limit'];?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_exam/<?php echo $row['ID'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>admin/exam/delete/<?php echo $row['ID'];?>');">
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
                	<?php echo form_open(base_url() . 'index.php/admin/exam/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'id'=>'form'));?>
                        
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="datepicker form-control" name="date"/ required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('comment');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="comment"/>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Limit');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="limit" required/>
                                </div>
                            </div>
							
                        		<div class="form-group">
                              	<div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_exam');?></button>
                              	</div>
								</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
            
		</div>
	</div>
	
</div>
 </div>
</div></div></div></div></div>

<script>
$(document).ready(function(){
	
	$("#form").submit(function(e){
		e.preventDefault();
		////alert("");
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: new FormData($("#form")[0]),
			cache:false,
			processData:false,
			contentType:false,
			success: function(res){
                var obj = JSON.parse(res);               
				
				if(obj.res=="1"){
					swal({
						title: 'SUCCESS',
						text: obj.message,
						type: 'success'
						
					});
                    window.location ="http://apps.classteacher.school/admin/exam";
				}else{
                   swal({
                        title: 'SUCCESS',
                        text: obj.message,
                        type: 'success'
                        
                    });					
				}
				
			}
			
		});
		
		//return false;
	});
	
	
});


</script>