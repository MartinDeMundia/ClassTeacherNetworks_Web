<hr />
<?php
  $info = $this->db->get_where('media', array('id' => $media_id))->result_array();
  foreach ($info as $row):
  $class_id = $row['class_id'];
  $section_id = $row['section_id'];
?>
<div class="row">
  <div class="box-content">
      <?php echo form_open(site_url('admin/media/do_update/'.$row['id']), array(
        'class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data',
          'target' => '_top')); ?>
		  
		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>
			<div class="col-sm-5">
				<select required data-validate="required" name="type_id" class="form-control" >
				 <option value='' <?php echo ($row['type_id'] == 0)?'selected':'';?>>select</option>
				 <option value='1' <?php echo ($row['type_id'] == 1)?'selected':'';?>>Document</option>
				 <option value='2' <?php echo ($row['type_id'] == 2)?'selected':'';?>>Photo</option>
				 <option value='3' <?php echo ($row['type_id'] == 3)?'selected':'';?>>Video</option>
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
				foreach($classes as $class):
				?>
					<option value="<?php echo $class['class_id'];?>"
						<?php if ($class_id == $class['class_id']) echo 'selected';?>>
							<?php echo $class['name'];?>
					</option>
				<?php
				endforeach;
				?>
			</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" ><?php echo get_phrase('class');?></label>
			  <div class="col-sm-5">
			<select name="section_id" id="section_id" class="form-control"  onchange="get_class_subject()">
				<option value=""><?php echo get_phrase('select_class_first');?></option>
				<?php 
				$sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
				foreach($sections as $section):
				?>
					<option value="<?php echo $section['section_id'];?>"
						<?php if ($section_id == $section['section_id']) echo 'selected';?>>
							<?php echo $section['name'];?>
					</option>
				<?php
				endforeach;
				?>
			</select>
			</div>
		</div>	
		  
      <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>
          <div class="col-sm-5">
              <input type="text" class="form-control" name="title"
                value="<?php echo $row['title'];?>" required />
          </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('details'); ?></label>
        <div class="col-sm-5">
          <textarea required class="form-control" rows="5" name="details"><?php echo $row['details'];?></textarea>
        </div>
      </div>      

      <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Files');?></label>
        <div class="col-sm-7">
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div>    
			<a target="_blank" href="<?php echo $row['path'];?>">Open File</a>
            </div>
           <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
            <div>
              <span class="btn btn-white btn-file">
                <span class="fileinput-new"><?php echo get_phrase('change_media_file'); ?></span>       
                <input type="file" name="media">
              </span>              
            </div>
          </div>
        </div>
      </div>      

      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-5">
              <button type="submit" id="submit_button" class="btn btn-info"><?php echo get_phrase('update'); ?></button>
          </div>
      </div>
      </form>
  </div>
</div>
<?php endforeach; ?>

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

