
<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th><div>#</div></th>
<th><div><?php echo get_phrase('type'); ?></div></th>
<th><div><?php echo get_phrase('title'); ?></div></th>
<th><div><?php echo get_phrase('options'); ?></div></th>
</tr>
</thead>
<tbody>
    <?php
    $count = 1;	 
	
	$school_id = $this->session->userdata('school_id');
						 
	$user_id = $this->session->userdata('login_user_id');      
		 
	$subclassesids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('school_id', $school_id)->get('class')->row()->classes;	 
	
	$medias = $this->db->where_in('class_id', explode(',',$subclassesids))->get('media')->result_array();
	    
    foreach ($medias as $row):
        ?>
        <tr>
            <td><?php echo $count++; ?></td>
			 <td><?php if($row['type_id'] == 1) echo 'Document'; elseif($row['type_id'] == 2) echo 'Photo';if($row['type_id'] == 3) echo 'Video';?></td>
            <td><?php echo $row['title']; ?></td>              
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                        
                        <!-- EDITING LINK -->
                        <li>
                            <a href="<?php echo site_url('admin/media_edit/'.$row['id']);?>">
                                <i class="entypo-pencil"></i>
                                <?php echo get_phrase('edit'); ?>
                            </a>
                        </li>
                        <li class="divider"></li>

                        <!-- DELETION LINK -->
                        <li>
                            <a href="#" onclick="confirm_modal('<?php echo site_url('admin/media/delete/'.$row['id']); ?>');">
                                <i class="entypo-trash"></i>
                                <?php echo get_phrase('delete'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
