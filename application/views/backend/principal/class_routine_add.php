<hr />
<div class="row">
	<div class="col-md-12">
		<script src="<?php echo base_url(); ?>assets/js/input_tag.js"></script>
		<?php echo form_open(site_url('admin/class_routine/create') , array('class' => 'form-horizontal form-groups validate','target'=>'_top'));?>
		
		<div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
                <div class="col-sm-5">
                    <select name="class_id" id = "class_id" class="form-control selectboxit" style="width:100%;"
                        onchange="return get_class_section_subject(this.value)">
                        <option value=""><?php echo get_phrase('select_stream');?></option>
                        <?php 
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach($classes as $row):
                        ?>
                            <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
        </div>
		
		<div id="section_subject_selection_holder"></div>	
		
		<div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('day');?></label>
                <div class="col-sm-5">
                    <select name="day" class="form-control selectboxit" style="width:100%;" id="time_table_day" required>
					<option>Select Days</option>
                        <option value="sunday">Sunday</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                    </select>
                </div>
        </div>
		
		<div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('Periods');?></label>
                <div class="col-sm-5">
		
		<input id="ms1" style="width:400px;" type="text" class ="ms1" name="ms1" />
				<div style="clear:both;"></div>
                </div>
        </div>
		            
        <div class="form-group">
              <div class="col-sm-offset-3 col-sm-5">
                  <button type="submit" id= "add_class_routine" class="btn btn-info"><?php echo get_phrase('add_class_routine');?></button>
              </div>
            </div>
    <?php echo form_close();?>

	</div>
</div>


<script type="text/javascript">
var class_id = '';
var subject_id  = '';
var section_id = '';
var starting_minute = '';
var time_table_day = '';
var time_table_period = '';
var get_fetch_periods = '';
jQuery(document).ready(function($) {
	$('#subject_div').css('display','');
    $('#add_class_routine').attr('disabled','disabled');
});
    function get_class_section_subject(class_id) {
		var type = $("input[name='type']:checked").val();
        $.ajax({
            url: '<?php echo site_url('admin/get_class_section_subject/');?>' + class_id ,
            success: function(response)
            {
                jQuery('#section_subject_selection_holder').html(response);
				$('#subject_div').css('display','');
            }
        });
    }
function check_validation(){
	subject_id = $('#subject_id').val();
	//section_id = $('#section_id').val();
	get_fetch_periods = $('#get_fetch_periods').val();
//	alert(get_fetch_periods);
    console.log('class_id: '+class_id+' section_id:'+section_id+' subject_id: '+subject_id+' time_table_day: '+time_table_day+' time_table_period: '+get_fetch_periods);
    if(class_id !== '' && section_id !== '' && subject_id !== '' && time_table_day !== '' && get_fetch_periods !== ''){
		 
		 $('#add_class_routine').removeAttr('disabled');
		/*if(subject_id == '' && break_title =='') $("#add_class_routine").attr('disabled', 'disabled');
		else $('#add_class_routine').removeAttr('disabled');*/
    }    
}
$('#class_id').change(function() {
    class_id = $('#class_id').val();
    check_validation();
});
$('#subject_id').change(function() {
    subject_id = $('#subject_id').val();
    check_validation();
});
$('#time_table_day').change(function() {
    time_table_day = $('#time_table_day').val();
    check_validation();
});

$('#section_id').change(function() {
				section_id = $('#section_id').val();
				check_validation();
});
/*$('#time_table_period').change(function() {
    time_table_period = $('#time_table_period').val();
    check_validation();
});
$('#get_fetch_periods').change(function() {
    time_table_period = $('#get_fetch_periods').val();
    check_validation();
});*/
</script>
<style>
.tag-ctn{
    position: relative;
    height: 28px;
    padding: 0;
    margin-bottom: 0px;
    font-size: 14px;
    line-height: 20px;
    color: #555555;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    background-color: #ffffff;
    border: 1px solid #cccccc;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
    -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
    -o-transition: border linear 0.2s, box-shadow linear 0.2s;
    transition: border linear 0.2s, box-shadow linear 0.2s;
    cursor: default;
    display: block;
}
.tag-ctn-invalid{
    border: 1px solid #CC0000;
}
.tag-ctn-readonly{
    cursor: pointer;
}
.tag-ctn-disabled{
    cursor: not-allowed;
    background-color: #eeeeee;
}
.tag-ctn-bootstrap-focus,
.tag-ctn-bootstrap-focus .tag-res-ctn{
    border-color: rgba(82, 168, 236, 0.8) !important;
    /* IE6-9 */
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6) !important;
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6) !important;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6) !important;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.tag-ctn input{
    border: 0;
    box-shadow: none;
    -webkit-transition: none;
    outline: none;
    display: block;
    padding: 4px 6px;
    line-height: normal;
    overflow: hidden;
    height: auto;
    border-radius: 0;
    float: left;
    margin: 2px 0 2px 2px;
}
.tag-ctn-disabled input{
    cursor: not-allowed;
    background-color: #eeeeee;
}
.tag-ctn .tag-input-readonly{
    cursor: pointer;
}
.tag-ctn .tag-empty-text{
    color: #DDD;
}
.tag-ctn input:focus{
    border: 0;
    box-shadow: none;
    -webkit-transition: none;
    background: #FFF;
}
.tag-ctn .tag-trigger{
    float: right;
    width: 27px;
    height:100%;
    position:absolute;
    right:0;
    border-left: 1px solid #CCC;
    background: #EEE;
    cursor: pointer;
}
.tag-ctn .tag-trigger .tag-trigger-ico {
    display: inline-block;
    width: 0;
    height: 0;
    vertical-align: top;
    border-top: 4px solid gray;
    border-right: 4px solid transparent;
    border-left: 4px solid transparent;
    content: "";
    margin-left: 9px;
    margin-top: 13px;
}
.tag-ctn .tag-trigger:hover{
    background: -moz-linear-gradient(100% 100% 90deg, #e3e3e3, #f1f1f1);
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f1f1f1), to(#e3e3e3));
}
.tag-ctn .tag-trigger:hover .tag-trigger-ico{
    background-position: 0 -4px;
}
.tag-ctn-disabled .tag-trigger{
    cursor: not-allowed;
    background-color: #eeeeee;
}
.tag-ctn-bootstrap-focus{
    border-bottom: 1px solid #CCC;
}
.tag-res-ctn{
    position: relative;
    background: #FFF;
    overflow-y: auto;
    z-index: 9999;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid #CCC;
    left: -1px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
    -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
    -o-transition: border linear 0.2s, box-shadow linear 0.2s;
    transition: border linear 0.2s, box-shadow linear 0.2s;
    border-top: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.tag-res-ctn .tag-res-group{
    line-height: 23px;
    text-align: left;
    padding: 2px 5px;
    font-weight: bold;
    border-bottom: 1px dotted #CCC;
    border-top: 1px solid #CCC;
    background: #f3edff;
    color: #333;
}
.tag-res-ctn .tag-res-item{
    line-height: 25px;
    text-align: left;
    padding: 2px 5px;
    color: #666;
    cursor: pointer;
}
.tag-res-ctn .tag-res-item-grouped{
    padding-left: 15px;
}
.tag-res-ctn .tag-res-odd{
    background: #F3F3F3;
}
.tag-res-ctn .tag-res-item-active{
    background-color: #3875D7;
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3875D7', endColorstr='#2A62BC', GradientType=0 );
    background-image: -webkit-gradient(linear, 0 0, 0 100%, color-stop(20%, #3875D7), color-stop(90%, #2A62BC));
    background-image: -webkit-linear-gradient(top, #3875D7 20%, #2A62BC 90%);
    background-image: -moz-linear-gradient(top, #3875D7 20%, #2A62BC 90%);
    background-image: -o-linear-gradient(top, #3875D7 20%, #2A62BC 90%);
    background-image: linear-gradient(#3875D7 20%, #2A62BC 90%);
    color: #fff;
}
.tag-sel-ctn{
    overflow: auto;
    line-height: 22px;
    padding-right:27px;
}
.tag-sel-ctn .tag-sel-item{
    background: #555;
    color: #EEE;
    float: left;
    font-size: 12px;
    padding: 0 5px;
    border-radius: 3px;
    margin-left: 5px;
    margin-top: 4px;
}
.tag-sel-ctn .tag-sel-text{
    background: #FFF;
    color: #666;
    padding-right: 0;
    margin-left: 0;
    font-size: 14px;
    font-weight: normal;
}
.tag-res-ctn .tag-res-item em{
    font-style: normal;
    background: #565656;
    color: #FFF;
}
.tag-sel-ctn .tag-sel-item:hover{
    background: #565656;
}
.tag-sel-ctn .tag-sel-text:hover{
    background: #FFF;
}
.tag-sel-ctn .tag-sel-item-active{
    border: 1px solid red;
    background: #757575;
}
.tag-ctn .tag-sel-ctn .tag-sel-item{
    margin-top: 3px;
}
.tag-stacked .tag-sel-item{
    float: inherit;
}
.tag-sel-ctn .tag-sel-item .tag-close-btn{
    width: 7px;
    cursor: pointer;
    height: 7px;
    float: right;
    margin: 8px 2px 0 10px;
   background-image: url(data:image/png;base64,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);

}
.tag-sel-ctn .tag-sel-item .tag-close-btn:hover{
    background-position: 0 -7px;
}
.tag-helper{
    color: #AAA;
    font-size: 10px;
    position: absolute;
    top: -17px;
    right: 0;
}
</style>