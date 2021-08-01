<?php
	$query = $this->db->get_where('section' , array('class_id' => $class_id));
	if($query->num_rows() > 0):
		$sections = $query->result_array();
?>

<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
    <div class="col-sm-5">
        <select name="section_id" id="section_id" class="form-control" style="width:100%;" onchange="return get_class_subject();">
            <option value="">select Stream</option>
        <?php
			$i=1;
        	foreach($sections as $row):
				if($i == 1) $section_id = $row['section_id']
        ?>
    	<option value="<?php echo $row['section_id'];?>"><?php echo $row['name'];?></option>
    	<?php $i++;endforeach;?>
        </select>
    </div>
</div>
	
<?php endif;?>

<div class="form-group" id="subject_div" >
    <label class="col-sm-3 control-label"><?php echo get_phrase('subject');?></label>
    <div class="col-sm-5">
        <select id="subject_id" name="subject_id" class="form-control" style="width:100%;" onchange="return get_class_subject();>
		<option value="">select</option>
        <?php
        	$subjects = $this->db->get_where('subject' , array('class_id' => $class_id,'section_id' => $section_id))->result_array();
        	foreach($subjects as $row):
        ?>
    	<option value="<?php echo $row['subject_id'];?>"><?php echo $row['name'];?></option>
    	<?php endforeach;?>
        </select>
    </div>
</div>


<script type="text/javascript">
function get_class_subject() {
			var class_id =  jQuery('#class_id').val();
			var section_id =  jQuery('#section_id').val();
			if (class_id !== '' && section_id !='') {
			$.ajax({
				url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
				success: function(response)
				{
					$('#subject_id').html(response);				
					 
				}			
				
			});
			 
		  }		  
		}	
    $(document).ready(function() {
		
			$('#section_id').change(function() {
				section_id = $('#section_id').val();
				check_validation();
			});
		
			$('#subject_id').change(function() {
				subject_id = $('#subject_id').val();
				if(subject_id>0) $('#break_title').val('');
				check_validation();
			});
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