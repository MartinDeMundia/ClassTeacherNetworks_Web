<div class="row">
    <div class="col-md-12">

        <!------CONTROL TABS START------>
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
                    <?php echo get_phrase('events_list'); ?>
                </a></li>
        </ul>
        <!------CONTROL TABS END------>


        <div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div>#</div></th>
					<th><div><?php echo get_phrase('event_title'); ?></div></th>   
                    <th><div><?php echo get_phrase('event_date'); ?></div></th>                    
                    <th><div></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($events as $row):  ?>
                            <tr>
                                <td><?php echo $count++; ?></td>								 
                                <td><?php echo $row['title']; ?></td>   
								<td><?php echo date('d M,Y', strtotime($row['date'])); ?></td>	
                                <td>
                                    <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_view_event/'.$row['id']); ?>');"
                                       class="btn btn-default">
                                        <?php echo get_phrase('view'); ?>
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!----TABLE LISTING ENDS-->




        </div>
    </div>
</div>