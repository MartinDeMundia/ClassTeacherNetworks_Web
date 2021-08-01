<div class="sidebar-menu">
    <header class="logo-env">

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>index.php/principal/dashboard">
                <img src="<?php echo base_url(); ?>uploads/logo.png" style="max-height:50px;width:190px"/>
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
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

        <li id="search">
  				<form class="" action="<?php echo site_url($account_type.'/student_details') ?>" method="post">
  					<input type="text" class="search-input" name="student_identifier" placeholder="<?php echo get_phrase('student_name').' / '.get_phrase('admission_number'); ?>" value="" required style="font-family: 'Poppins', sans-serif !important; background-color: #2C2E3E !important; color: #868AA8; border-bottom: 1px solid #3F3E5F;">
  					<button type="submit">
  						<i class="entypo-search"></i>
  					</button>
  				</form>
			  </li>

        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
		
			 <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'opened active has-sub';
        ?> ">
		
		    <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teachers'); ?></span>
            </a>
            <ul>
				 
				<li class="<?php if ($page_name == 'teacher_bulk_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/teacher_bulk_add'); ?>">
                        <span><i class="entypo-users"></i> <?php echo get_phrase('create_bulk_teachers'); ?></span>
                    </a>
                </li>

				<!-- PROFILE -->
				<li class="<?php if ($page_name == 'teacher') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type.'/teacher_list'); ?>">
						<i class="entypo-users"></i>
						<span><?php echo get_phrase('profile'); ?></span>
					</a>
				</li>
				
			</ul>        
        </li>   
		<!-- CLASS-->
		
		
		
		<!-- STUDENT -->
        <li class="<?php if ($page_name == 'student_add' ||
                                $page_name == 'student_bulk_add' ||
                                    $page_name == 'student_information' ||
									 $page_name == 'assignment_submit' ||
									  $page_name == 'assignmentsubmit_edit' ||
                                        $page_name == 'student_marksheet' ||
                                            $page_name == 'student_promotion' ||
											$page_name == 'student_behaviour' || 
											$page_name == 'student_behaviour_details' || 
                                              $page_name == 'student_profile' || $page_name == 'manage_attendance' || $page_name == 'manage_attendance_view' || $page_name == 'tabulation_sheet')
                                                echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('students'); ?></span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT BULK ADMISSION -->
                <li class="<?php if ($page_name == 'student_bulk_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_bulk_add'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_bulk_student'); ?></span>
                    </a>
                </li>
                
                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                    <ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id'] || $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">
                            <!--<li class="<?php if ($page_name == 'student_information' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">-->
                                <a href="<?php echo site_url('admin/student_information/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li> 
				
				 <!-- STUDENT LIST PRINT -->
				
				 <li class="<?php if ($page_name == 'student_class_list' || $page_name == 'student_class_list') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_stream_list'); ?></span>
                    </a>
                    <ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_class_list' && $class_id == $row['class_id'] || $page_name == 'student_class_list' && $class_id == $row['class_id']) echo 'active'; ?>">
                            <!--<li class="<?php if ($page_name == 'student_class_list' && $page_name == 'student_class_list' && $class_id == $row['class_id']) echo 'active'; ?>">-->
                                <a href="<?php echo site_url('admin/student_class_list/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
				</ul>
				
				
				
                
		<!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard' || $page_name == 'noticeboard_edit' || $page_name == 'group_message' || $page_name == 'media' || $page_name == 'media_edit' || $page_name == 'events' || $page_name == 'event_edit') echo 'opened active has-sub'; ?> ">
		
			<a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
            <ul>
				<li class="<?php if ($page_name == 'noticeboard' || $page_name == 'noticeboard_edit') echo 'opened active'; ?> ">
				<a href="<?php echo site_url('admin/noticeboard'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('Announcements'); ?></span>
				</a>
				</li>  
				<li class="<?php if ($page_name == 'media' || $page_name == 'media_edit') echo 'opened active'; ?> ">
				<a href="<?php echo site_url('admin/media'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('media'); ?></span>
				</a>
				</li> 
				<li class="<?php if ($page_name == 'group_message') echo 'opened active'; ?> ">
				<a href="<?php echo site_url('principal/group_message'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('forums'); ?></span>
				</a>
				</li>
				<li class="<?php if ($page_name == 'events') echo 'opened active'; ?> ">
				<a href="<?php echo site_url('admin/events'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('events'); ?></span>
				</a>
				</li>
			</ul> 
		</li>      
		
		<!-- STAFF -->
        <li class="<?php if ($page_name == 'staff') echo 'opened active has-sub';
        ?> ">
		
		    <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('non_teaching_staffs'); ?></span>
            </a>
            <ul>
				 
				<li class="<?php if ($page_name == 'staff_bulk_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/staff_bulk_add'); ?>">
                        <span><i class="entypo-users"></i> <?php echo get_phrase('create_bulk_staffs'); ?></span>
                    </a>
                </li>

				<!-- PROFILE -->
				<li class="<?php if ($page_name == 'staff') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type.'/staff_list'); ?>">
						<i class="entypo-users"></i>
						<span><?php echo get_phrase('profile'); ?></span>
					</a>
				</li>
				
			</ul>        
        </li>  
		
          


        <li class="<?php if ($page_name == 'parent') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/parent'); ?>">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('parents'); ?></span>
            </a>
        </li> 		
 <li class="<?php if ($page_name == 'survey') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/survey'); ?>">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('Survey'); ?></span>
            </a>
        </li>
        <!-- STUDY MATERIAL -->
        <!--li class="<?php if ($page_name == 'study_material') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/study_material'); ?>">
                <i class="entypo-book-open"></i>
                <span><?php echo get_phrase('study_material'); ?></span>
            </a>
        </li-->

        <!-- ACADEMIC SYLLABUS -->
        <!--li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
            <a href="<?php echo site_url($account_type.'/academic_syllabus'); ?>">
                <i class="entypo-doc"></i>
                <span><?php echo get_phrase('academic_syllabus'); ?></span>
            </a>
        </li-->  

		

              
		
        
        
		  
		
		<!-- MEAL MENU -->
        <!--li class="<?php if ($page_name == 'meal_menu') echo 'active'; ?> ">
            <a href="<?php echo site_url('principal/meal_menu'); ?>">
                <i class="entypo-doc"></i>
                <span><?php echo get_phrase('meal_menu'); ?></span>
            </a>
        </li--> 		
		
		<!-- CONTACT BOOK -->
        <!--li class="<?php if ($page_name == 'contact_book') echo 'active'; ?> ">
            <a href="<?php echo site_url('principal/contact_book'); ?>">
                <i class="fa fa-users"></i>
                <span><?php echo get_phrase('contact_book'); ?></span>
            </a>
        </li--> 
		
		            
		
		

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'requests' || $page_name == 'manage_profile' ||$page_name == 'principal_profile' ||$page_name == 'principal_table' ||$page_name == 'notification_settings' || $page_name == 'feedback') echo 'opened active has-sub'; ?> ">
		
			<a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>		
			
				<li class="<?php if ($page_name == 'manage_profile') echo 'opened active'; ?> ">
						<a href="<?php echo site_url($account_type . '/manage_profile');?>">
                        	<i class="entypo-info"></i>
							<span><?php echo get_phrase('profile');?></span>
						</a>
				</li>
				
				<li class="<?php if ($page_name == 'principal_profile') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type . '/principal_profile/'.$this->session->userdata('login_user_id'));?>">
                        	<i class="entypo-key"></i>
							<span><?php echo get_phrase('my_streams');?></span>
						</a>
				</li>
				
				<li class="<?php if ($page_name == 'principal_table') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type . '/principal_table/'.$this->session->userdata('login_user_id'));?>">
                        	<i class="entypo-key"></i>
							<span><?php echo get_phrase('my_timetable');?></span>
						</a>
				</li>				
								
				<li class="<?php if ($page_name == 'notification_settings') echo 'opened active'; ?> ">
					<a href="<?php echo site_url('principal/manage_notification'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('notification'); ?></span>
					</a>
				</li>
			
				<!-- Feedback -->
				<li class="<?php if ($page_name == 'feedback') echo 'active'; ?> ">
					<a href="<?php echo site_url('principal/feedback'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('feedback'); ?></span>
					</a>
				</li>		

				<li class="<?php if ($page_name == 'requests') echo 'active'; ?> ">
					<a href="<?php echo site_url('admin/requests'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('profile_change_request_list'); ?></span>
					</a>
				</li>
				

			</ul>
		</li>
		
		
		
	
		</ul>

</div>
