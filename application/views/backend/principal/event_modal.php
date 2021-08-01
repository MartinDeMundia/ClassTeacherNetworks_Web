<hr />
<div class="row">
    <div class="col-md-12 show_div">

       
     
			<img src="<?php echo base_url('uploads/event.gif');?>" id="gif" style="display: none;">
                <div class="box-content" id="add_event">
                    <?php echo form_open(site_url('admin/events/create') , array(
                      'class' => 'form-horizontal form-groups-bordered validate event_form', 'enctype' => 'multipart/form-data',
                        'target' => '_top')); ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control tile_event" name="title" required />
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><?php echo get_phrase('details'); ?></label>
                  		<div class="col-sm-5">
                  		  <textarea class="form-control" rows="5" name="details"></textarea>
                  		</div>
                  	</div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" disabled name="create_timestamp"
                              value="<?php echo str_replace("-","/",str_replace(")","",$param2));?>" required />
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('image');?></label>
                      <div class="col-sm-7">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-new thumbnail" style="width: 300px; height: 150px;" data-trigger="fileinput">
                            <img src="<?php echo base_url(); ?>uploads/placeholder.png" alt="...">
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                          <div>
                            <span class="btn btn-white btn-file">
                              <span class="fileinput-new"><?php echo get_phrase('select_image'); ?></span>
                              <span class="fileinput-exists"><?php echo get_phrase('change'); ?></span>
                              <input type="file" name="image" accept="image/*">
                            </span>
                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput"><?php echo get_phrase('remove'); ?></a>
                          </div>
                        </div>
                      </div>
                    </div>                     

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" id="submit_button" class="btn btn-info load_button" onClick="save();"><?php echo get_phrase('add'); ?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!----CREATION FORM ENDS-->

        </div>
   

<script>
function save() {
if($('.tile_event').val() != ''){
	//$('#gif').css("display", "block");
	<?php 
	
	sleep(10);?>
	// $('#gif').css("display", "block");
     //$('#gif').delay(100000).fadeOut(2000); 
	/* setTimeout(function(){
event.preventDefault();
$('#gif').css("display", "block");
},20000);*/
   }
    
    
}
$(document).ready(function(){
	console.log(13);
	
	/*$('.load_button').click(function(){
   if($('.tile_event').val() != ''){
     $('#gif').show(1000); 
	 console.log(4545);
   }
});*/
	
	/*$(".event_form").submit(function(e) {
setTimeout(function(){
event.preventDefault();
},2000);
$('#gif').show(500); 
return true;
});*/
});
</script>