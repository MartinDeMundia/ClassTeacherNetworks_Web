
<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th><div>#</div></th>
<th><div><?php echo get_phrase('title'); ?></div></th>
<th><div><?php echo get_phrase('date'); ?></div></th>
<th><div><?php echo get_phrase('options'); ?></div></th>
</tr>
</thead>
<tbody>
    <?php
    $count = 1;
	$school_id = $this->session->userdata('school_id');
    $notices = $this->db->get_where('events', array('school_id' => $school_id))->result_array();
    foreach ($notices as $row):
        ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo date('d M,Y', strtotime($row['date'])); ?></td>           
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                        
                        <!-- EDITING LINK -->
                        <li>
                            <a href="<?php echo site_url('admin/event_edit/'.$row['id']);?>">
                                <i class="entypo-pencil"></i>
                                <?php echo get_phrase('edit'); ?>
                            </a>
                        </li>
                        <li class="divider"></li>

                        <!-- DELETION LINK -->
                        <li>
                            <a href="#" onclick="confirm_modal('<?php echo site_url('admin/events/delete/'.$row['id']); ?>');">
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
