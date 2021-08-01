<div class="col-md-3">
	<div class="form-group">
	<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
		<select name="section_id" id="section_id" class="form-control selectboxit">
			<?php 
				
				$user_id = $this->session->userdata('login_user_id');      
				$role = $this->session->userdata('login_type');
				  
				$sectionsids='';
				if($role =='principal')
					$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
				elseif($role =='teacher')
					$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('teacher_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
			
				if($sectionsids!='')
				$sections = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section')->result_array();
				else
				$sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
							
				foreach($sections as $row):
			?>
			<option value="<?php echo $row['section_id'];?>"><?php echo $row['name'];?></option>
			<?php endforeach;?>
		</select>
	</div>
</div>

<script type="text/javascript">
   
    $(document).ready(function () {

        // SelectBoxIt Dropdown replacement
        if ($.isFunction($.fn.selectBoxIt))
        {
            $("select.selectboxit").each(function (i, el)
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