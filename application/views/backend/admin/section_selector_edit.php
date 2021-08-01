<?php
	$query = $this->db->get_where('section' , array('class_id' => $class_id));
	if($query->num_rows() > 0): 
		$section_id = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->section_id;
		$sections   = $query->result_array();
?>
	
	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
		<div class="col-sm-5">
			<select required name="section_id" class="form-control">
				<option value=""><?php echo get_phrase('select_section');?></option>
				<?php foreach($sections as $section):?>
				<option value="<?php echo $section['section_id'];?>"
					<?php if($section['section_id'] == $section_id) echo 'selected';?>>
						<?php echo $section['name'];?>
					</option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

<?php endif;?>

	<script type="text/javascript">
	$(document).ready(function() {
        if($.isFunction($.fn.selectBoxIt))
		{
			$("select.selectboxit").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						showFirstOption: attrDefault($this, 'first-option', true),
						'native': attrDefault($this, 'native', false),
						defaultText: attrDefault($this, 'text', ''),
					};
					
				$this.addClass('visible');
				$this.selectBoxIt(opts);
			});
		}
    });
	
</script>