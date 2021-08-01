<?php
	$query = $this->db->get_where('section' , array('class_id' => $class_id));
	if($query->num_rows() > 0):
		$sections = $query->result_array();
?>

<div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
    <div class="col-sm-5">
        <select data-validate="required" name="section_id" class="form-control selectboxit" style="width:100%;">
        <?php
			$i=1;
        	foreach($sections as $row): $sele = ($i == 1)?'selected':'';
        ?>
    	<option value="<?php echo $row['section_id'];?>" <?php echo $sele;?>><?php echo $row['name'];?></option>
    	<?php $i++; endforeach;?>
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