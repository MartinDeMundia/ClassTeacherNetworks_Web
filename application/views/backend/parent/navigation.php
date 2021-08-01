<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>index.php/parent/dashboard">
                <img src="<?php echo base_url(); ?>uploads/logo.png"  style="max-height:50px;width:190px"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('parents/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
		
		<li class="<?php
        if ($page_name == 'invoice' || $page_name == 'teacher' ||
            $page_name == 'class_layout' ||
            $page_name == 'behavior' || $page_name == 'health' || $page_name == 'class_routine' || $page_name == 'attendance_report' || $page_name == 'marks')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('student_profile'); ?></span>
            </a>
            <ul>

				<li class="<?php if ($page_name == 'teacher') echo 'opened active';?> ">
					<a href="#">
						<i class="fa fa-user"></i>
						<span><?php echo get_phrase('class_subject_teachers'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
						?>
						<li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/teacher_list/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>
					
					</ul>
				</li>
				
				<!-- CLASS ROUTINE -->
				<li class="<?php if ($page_name == 'class_routine') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('class_time_table'); ?></span>
					</a>
					<ul>
					<?php
						$children_of_parent = $this->db->get_where('student' , array(
							'parent_id' => $this->session->userdata('parent_id')
						))->result_array();
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'class_routine') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/class_routine/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li>

				<!-- ATTENDANCE VIEW FOR CHILDREN -->
				<li class="<?php if ($page_name == 'attendance_report' || $page_name == 'attendance_report_view') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-chart-area"></i>
						<span><?php echo get_phrase('attendance'); ?></span>
					</a>
					<ul>
					<?php
						$children_of_parent = $this->db->get_where('student' , array(
							'parent_id' => $this->session->userdata('parent_id')
						))->result_array();
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'attendance_report') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/attendance_report/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li>

				<!-- EXAMS -->
				<li class="<?php
				if ($page_name == 'marks') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-graduation-cap"></i>
						<span><?php echo get_phrase('education_progress'); ?></span>
					</a>
					<ul>
					<?php
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'marks' && $student_id == $row['student_id']) echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/marks/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li>
				
				<li class="<?php if ($page_name == 'class_layout') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('visual_class_layout'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
							    
							  $enroll = $this->db->get_where('enroll' , array(
            'student_id' => $row['student_id']))->row();
                             $class_id = $enroll->class_id;
                             $section_id = $enroll->section_id;
						?>
						<li class="<?php if ($page_name == 'layout') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/class_layout/'.$class_id.'/'.$section_id); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>			
					</ul>
				</li>			
				
				<!-- PAYMENT -->
				<li class="<?php if ($page_name == 'invoice' || $page_name == 'pay_with_payumoney') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-credit-card"></i>
						<span><?php echo get_phrase('fee_status'); ?></span>
					</a>
					<ul>
					<?php
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/invoice/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li> 

				<!-- ACADEMIC SYLLABUS -->
				<!--li class="<?php if ($page_name == 'academic_syllabus') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('academic_syllabus'); ?></span>
					</a>
					<ul>
					<?php
						$children_of_parent = $this->db->get_where('student' , array(
							'parent_id' => $this->session->userdata('parent_id')
						))->result_array();
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/academic_syllabus/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li-->
				
			</ul>
        </li>	

		<li class="<?php
        if ($page_name == 'calendar' ||
            $page_name == 'media' || $page_name == 'events' || $page_name == 'noticeboard' || $page_name == 'group_message')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('notice_board'); ?></span>
            </a>
            <ul>
			
				<!-- Announcements -->
				<li class="<?php if ($page_name == 'noticeboard') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-credit-card"></i>
						<span><?php echo get_phrase('announcements'); ?></span>
					</a>
					<ul>
					<?php
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/noticeboard/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li> 
				
				<!-- Media -->
				<li class="<?php if ($page_name == 'media') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-credit-card"></i>
						<span><?php echo get_phrase('media'); ?></span>
					</a>
					<ul>
					<?php
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'media') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/media/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li> 	
				
					
				
				<!-- Forums -->
				<li class="<?php if ($page_name == 'group_message') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-credit-card"></i>
						<span><?php echo get_phrase('forums'); ?></span>
					</a>
					<ul>
					<?php
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'group_message') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/group_message'); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li> 
				
				<!-- Calendar -->
				<li class="<?php if ($page_name == 'events') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-credit-card"></i>
						<span><?php echo get_phrase('events'); ?></span>
					</a>
					<ul>
					<?php
						foreach ($children_of_parent as $row):
					?>
						<li class="<?php if ($page_name == 'events') echo 'active'; ?> ">
							<a href="<?php echo site_url('parents/events/'.$row['student_id']); ?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
					<?php endforeach;?>
					</ul>
				</li> 		
				
				
			</ul>
        </li>
		
			
		<li class="<?php if ($page_name == 'report') echo 'opened active has-sub'; ?> ">
		
			<a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('reports'); ?></span>
            </a>
            <ul>		
			
				<li class="<?php if ($page_name == 'report') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('health'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
						?>
						<li class="<?php if ($page_name == 'report') echo 'active'; ?> ">
							<a target="_blank" href="<?php echo site_url('admin/report/'.$row['student_id'].'/1');?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>			
					</ul>
				</li>
			
				<li class="<?php if ($page_name == 'report') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('behavior'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
						?>
						<li class="<?php if ($page_name == 'report') echo 'active'; ?> ">
							<a target="_blank" href="<?php echo site_url('admin/report/'.$row['student_id'].'/2');?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>			
					</ul>
				</li>
				<li class="<?php if ($page_name == 'report') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('fees'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
						?>
						<li class="<?php if ($page_name == 'report') echo 'active'; ?> ">
							<a target="_blank" href="<?php echo site_url('admin/report/'.$row['student_id'].'/3');?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>			
					</ul>
				</li>
				<li class="<?php if ($page_name == 'report') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('attendance'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
						?>
						<li class="<?php if ($page_name == 'report') echo 'active'; ?> ">
							<a target="_blank" href="<?php echo site_url('admin/report/'.$row['student_id'].'/4');?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>			
					</ul>
				</li>
				<li class="<?php if ($page_name == 'report') echo 'opened active';?> ">
					<a href="#">
						<i class="entypo-doc"></i>
						<span><?php echo get_phrase('education_progress'); ?></span>
					</a>
					<ul>			
						<?php
							$children_of_parent = $this->db->get_where('student' , array(
								'parent_id' => $this->session->userdata('parent_id')
							))->result_array();
							foreach ($children_of_parent as $row):
						?>
						<li class="<?php if ($page_name == 'report') echo 'active'; ?> ">
							<a target="_blank" href="<?php echo site_url('admin/report/'.$row['student_id'].'/5');?>">
								<span><i class="entypo-dot"></i> <?php echo $row['name'];?></span>
							</a>
						</li>
						<?php endforeach;?>			
					</ul>
				</li>
								
				
			</ul>
		</li>		
		
        <li class="<?php if ($page_name == 'manage_profile' || $page_name == 'notification_settings' || $page_name == 'feedback') echo 'opened active has-sub'; ?> ">
		
			<a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>		
			
				<li class="<?php if ($page_name == 'manage_profile') echo 'opened active'; ?> ">
						<a href="<?php echo site_url('parents/manage_profile');?>">
                        	<i class="entypo-info"></i>
							<span><?php echo get_phrase('profile');?></span>
						</a>
				</li>				 
								
				<li class="<?php if ($page_name == 'notification_settings') echo 'opened active'; ?> ">
					<a href="<?php echo site_url('parents/manage_notification'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('notification'); ?></span>
					</a>
				</li>
			
				<!-- Feedback -->
				<li class="<?php if ($page_name == 'feedback') echo 'active'; ?> ">
					<a href="<?php echo site_url('parents/feedback'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('feedback'); ?></span>
					</a>
				</li>			
				

			</ul>
		</li>
        

    </ul>

</div>
