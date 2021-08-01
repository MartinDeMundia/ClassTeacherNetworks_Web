<hr />

<?php

	$this->db->select('GROUP_CONCAT(subject.section_id SEPARATOR ",") as section_id,GROUP_CONCAT(subject.subject_id SEPARATOR ",") as subject_id');
	$this->db->from('subject');
	$this->db->where('teacher_id', 0);
	$this->db->where('principal_id', $principal_id);
	$subject_row = $this->db->get()->row();	
	$section_id = $subject_row->section_id;	 
	$subject_id = $subject_row->subject_id;		
	
	$this->db->select('*');
	$this->db->from('section');
	$this->db->where_in('section_id', explode(',',$section_id));
	$query = $this->db->get(); 
    if($query->num_rows() > 0):
        $sections = $query->result_array();
    foreach($sections as $row): $class_id = $row['class_id'];
?>
<div class="row">
    
    <div class="col-md-12">

        <div class="panel panel-default" data-collapsed="0">
            <div class="panel-heading" >
                <div class="panel-title" style="font-size: 16px; color: white; text-align: center;">
                    <?php echo get_phrase('class');?> - <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> : 
                    <?php echo get_phrase('section');?> - <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;?>
                    <a href="<?php echo site_url('teacher/class_routine_print_view/'.$class_id.'/'.$row['section_id']);?>"
                        class="btn btn-primary btn-xs pull-right" target="_blank">
                            <i class="entypo-print"></i> <?php echo get_phrase('print');?>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                
                <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                    <tbody>
                        <?php 
                        for($d=1;$d<=7;$d++):
                        
                        if($d==1)$day='sunday';
                        else if($d==2)$day='monday';
                        else if($d==3)$day='tuesday';
                        else if($d==4)$day='wednesday';
                        else if($d==5)$day='thursday';
                        else if($d==6)$day='friday';
                        else if($d==7)$day='saturday';
                        ?>
                        <tr class="gradeA">
                            <td width="100"><?php echo strtoupper($day);?></td>
                            <td>
                                <?php
                                $this->db->order_by("time_start", "asc");
								$this->db->order_by("time_start_min", "asc");
                                $this->db->where('day' , $day);
                                $this->db->where('class_id' , $class_id);
                                $this->db->where('section_id' , $row['section_id']);
								$this->db->where_in('subject_id', explode(',',$subject_id));
                                $this->db->where('year' , $running_year);
                                $routines   =   $this->db->get('class_routine')->result_array();
 
                                foreach($routines as $row2):
                                ?>
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <?php echo $this->crud_model->get_subject_name_by_id($row2['subject_id']);?>
                                       <?php
                                            if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0){ 
												$time_start = ($row2['time_start']>12)?$row2['time_start']-12:$row2['time_start'];
												$time_end = ($row2['time_end']>12)?($row2['time_end']-12):$row2['time_end'];
												$timestate = ($row2['time_end']>11)?'PM ':'AM';
                                                echo '('.$time_start.'-'.$time_end.$timestate.')';
											}
                                            if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0){
												
												$time_start = ($row2['time_start']>12)?$row2['time_start']-12:$row2['time_start'];
												$time_end = ($row2['time_end']>12)?($row2['time_end']-12):$row2['time_end'];
												$timestate = ($row2['time_end']>11)?'PM ':'AM';
											
                                                echo '('.$time_start.':'.$row2['time_start_min'].'-'.$time_end.':'.$row2['time_end_min'].$timestate.')';
											}
                                        ?>
                                        <span class="caret"></span>
                                    </button>
                                </div>
                                <?php endforeach;?>

                            </td>
                        </tr>
                        <?php endfor;?>
                        
                    </tbody>
                </table>
                
            </div>
        </div>

    </div>

</div>
<?php endforeach;?>
<?php endif;?>