
<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th><div>#</div></th>
<th><div><?php echo get_phrase('stream'); ?></div></th>
<th><div><?php echo get_phrase('class'); ?></div></th>
<th><div><?php echo get_phrase('subject'); ?></div></th>
<th><div><?php echo get_phrase('title'); ?></div></th>
<th><div><?php echo get_phrase('given_date'); ?></div></th>
<th><div><?php echo get_phrase('due_date'); ?></div></th>
<th><div><?php echo get_phrase('options'); ?></div></th>
</tr>
</thead>
<tbody>
    <?php
    $count = 1;
	$login_user_id = $this->session->userdata('login_user_id');
    $assignments = $this->db->get_where('assignments', array('user_id' => $login_user_id,'role_id' =>3))->result_array();
    foreach ($assignments as $row):
        ?>
        <tr>
            <td><?php echo $count++; ?></td>
			<td><?php echo $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name; ?></td>
			<td><?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name; ?></td>
			<td><?php echo $this->db->get_where('subject', array('subject_id' => $row['subject_id']))->row()->name; ?></td>
            <td><?php echo '<a target="_blank" href="/'.$row['filepath'].'">'.$row['title'].'</a>'; ?></td>
            <td><?php echo date('d M,Y', strtotime($row['given_date'])); ?></td>    
			  <td><?php echo date('d M,Y', strtotime($row['due_date'])); ?></td> 
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                        
                        <!-- EDITING LINK -->
                        <li>
                            <a href="<?php echo site_url('principal/assignment_edit/'.$row['assignment_id']);?>">
                                <i class="entypo-pencil"></i>
                                <?php echo get_phrase('edit'); ?>
                            </a>
                        </li>
                        <li class="divider"></li>

                        <!-- DELETION LINK -->
                        <li>
                            <a href="#" onclick="confirm_modal('<?php echo site_url('principal/assignments/delete/'.$row['assignment_id']); ?>');">
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
