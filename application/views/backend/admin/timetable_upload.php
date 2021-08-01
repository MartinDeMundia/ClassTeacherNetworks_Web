<hr />
<?php echo form_open(site_url('admin/bulk_import_add_using_csv/import') ,
			array('class' => 'form-inline validate', 'style' => 'text-align:center;',  'enctype' => 'multipart/form-data'));?>
 
<div class="row">
	<div class="col-md-offset-4 col-md-4" style="padding: 15px;">
		<button type="button" class="btn btn-primary" name="generate_csv" id="generate_csv"><?php echo get_phrase('generate_').'CSV '.get_phrase('file'); ?></button>
	</div>
	<div class="col-md-offset-4 col-md-4" style="padding-bottom:15px;">
	<input type="file" name="userfile" class="form-control file2 inline btn btn-info" data-label="<i class='entypo-tag'></i> Select CSV File"
	                   	data-validate="required" data-message-required="<?php echo get_phrase('required'); ?>"
	               		accept="text/csv, .csv" />
	</div>
	<div class="col-md-offset-4 col-md-4">
		<button type="submit" class="btn btn-success" name="import_csv" id="import_csv"><?php echo get_phrase('import_CSV'); ?></button>
	</div>
</div>
<br><br>
<?php echo form_close();?>
<div class="row">
	<div class="col-md-12" style="padding: 10px; background-color: #B3E5FC; color: #424242;">
		<p style="font-weight: 700; font-size: 15px;">
			<?php echo get_phrase('please_follow_the_instructions_for_import_timetable:'); ?>
		</p>
			<ol>
				<li style="padding: 5px;"><?php echo get_phrase('at_first').'" Generate CSV File".'; ?></li>
				<li style="padding: 5px;"><?php echo get_phrase('open_the_downloaded_').'"timetable.csv" File. ';?></li>
				<li style="padding: 5px;"><?php echo get_phrase('save_the_edited_').'"timetable.csv" File.';?></li>
				<li style="padding: 5px;"><?php echo get_phrase('click_the_').'"Select CSV File" '.get_phrase('and_choose_the_file_you_just_edited').'.';?></li>
				<li style="padding: 5px;"><?php echo get_phrase('import_that_file.');?></li>
				<li style="padding: 5px;"><?php echo get_phrase('hit_').'"Import CSV File".';?></li>
			</ol>
			 
	</div>
</div>

<a href="" download="timetable.csv" style="display: none;" id = "bulk">Download</a>

<script>

</script>
<script type="text/javascript">
var class_selection = '';
jQuery(document).ready(function($) {
	$('#submit_button').attr('disabled', 'disabled');

	});	 
	$("#generate_csv").click(function(){
		 		 
		$.ajax({
			url: '<?php echo site_url('admin/generate_timetable_csv');?>',
			success: function(response) {
				toastr.success("<?php echo get_phrase('file_generated'); ?>");
					$("#bulk").attr('href', response);
					jQuery('#bulk')[0].click();
				//document.location = response;
			}
		});
		 
	});
</script>
