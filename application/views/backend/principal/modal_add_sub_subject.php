<?php 
$edit_data		=	$this->db->get_where('class_subjects' , array('id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					Add a subject under selected Main Subject <b>(<?php echo $row['subject'];?>)</b>
            	</div>
            </div>
			<div class="panel-body">





	            <div class="tab-pane box active" id="list">				
	                <table class="table table-bordered datatable" id="table_sub_subjects">
	                	<thead>
	                		<tr>
	                    		<th><div>#</div></th>
	                    		<th><div><?php echo get_phrase('subject code');?></div></th>                   			
	                    		<th><div><?php echo get_phrase('subject_name');?></div></th>
	                    		<th><div>Out Of</div></th>
	                    		<th><div>Del.</div></th>	                    		                  	
							</tr>
						</thead>
	                    <tbody>                    	
	                        <tr>
	                            <td></td>
								<td></td>														
								<td></td>
								<td></td>
								<td></td>					
	                        </tr>                    
	                    </tbody>
	                </table>
				</div>


				
                <?php echo form_open(site_url('admin/class_subjects/do_update/'.$row['id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>                   
				
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('subject_name');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="subject" id="subject" value=""/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('subject_code');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="subject_code" id="subject_code" value="<?php echo $row['subject_code'];?>"/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('total_marks_out_of');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="total_marks_out_of" id="total_marks_out_of"  value=""/>
                        </div>
                    </div>					
										
					
            		<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="button" onClick="doSaveSubSubject()" class="btn btn-info">Save</button>
						</div>
					</div>
        		</form>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>


<script type="text/javascript">



function deleteSubject(subjectid){
            postVrs = {
				"main":"<?php echo $param2; ?>",
				"id":subjectid
            }
            $.post("class_subjects_sub_delete",postVrs,function(respData){
            	 loadSubSubjects("<?php echo $param2; ?>");
            },"json");
}



function loadSubSubjects(mainsubject){

            dataTable =  $('#table_sub_subjects').DataTable();
            dataTable.fnClearTable();
            dataTable.fnDraw();
            postVrs = {
                "main":"<?php echo $param2; ?>"
            }

            $.post("class_subjects_sub",postVrs,function(respData){

                $.each(respData.content, function(i, item) {  

                    btns = '<td>';
                    btns += '<div class="btn-group">';
                    btns += '<button type="button" onclick="deleteSubject('+item.id+')" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdowns">';
                    btns += ' Delete';
                    btns += '</button>';                   


                    btns += '</div>';
                    btns += '</td>';


                    var data = [
                        '<td>'+item.id+'</td>',                    
                        "<td>"+item.subject_code+"</td>",
                        "<td>"+item.subject+"</td>",
                        "<td>"+item.total_marks_out_of+"</td>",
                        btns
                   
                    ];
                    dataTable.fnAddData(data);
                });
            },"json");
		
	}



	function doSaveSubSubject(){
            postVrs = {
				"main":"<?php echo $param2; ?>",
				"subject": $('#subject').val(),
				"subject_code": $('#subject_code').val(),
				"total_marks_out_of":$('#total_marks_out_of').val() 
            }
            $.post("class_subjects_sub_save",postVrs,function(respData){
            	 loadSubSubjects("<?php echo $param2; ?>");
            },"json");
	}


    jQuery(document).ready(function($) {
           loadSubSubjects("<?php echo $param2; ?>"); 
    });

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
	
</script>


