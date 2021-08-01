<div class="sidebar-menu">
    <header class="logo-env">

        <!-- logo -->
        <div class="logo" style="">
			<a href="<?php echo base_url(); ?>index.php/teacher/dashboard">
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

        <!-- STUDENT -->
        <li class="<?php
        if ($page_name == 'student_add' || $page_name == 'student_profile' ||
            $page_name == 'student_information' ||
			$page_name == 'student_behaviour' || 
			$page_name == 'student_behaviour_details' || 
			$page_name == 'assignment_submit' || $page_name == 'assignmentsubmit_edit' ||
            $page_name == 'student_marksheet' || $page_name == 'manage_attendance' || $page_name == 'manage_attendance_view'  || $page_name == 'tabulation_sheet')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('student'); ?></span>
            </a>
            <ul>

                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_profile' ) echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                    <ul>
                        <?php
                         $school_id = $this->session->userdata('school_id');
						 
						 $user_id = $this->session->userdata('login_user_id');      
							 
						$subclassids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('teacher_id', $user_id)->get('subject')->row()->classes;
						
						$secclassids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('teacher_id', $user_id)->get('section')->row()->classes; 
						
						$subclassids = ($subclassids !='')?$subclassids.",".$secclassids:$secclassids;
						
						$subclasses = array();
						if($subclassids !='')
							$subclasses = $this->db->where_in('class_id', explode(',',$subclassids))->get('class')->result_array();
								 
						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/student_information/'.$row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
				 
				<!--  ATTENDANCE -->
				<li class="<?php if ($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view'  ) echo 'opened active'; ?> ">					 
					
					<a href="#">
						
						<span><i class="entypo-dot"></i><?php echo get_phrase('attendance'); ?></span>
					</a>
					<ul>
						<?php						 
						
						foreach ($subclasses as $row):
							?>
							<li class="<?php if (($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view') && $class_id == $row['class_id']) echo 'active'; ?>">
								<a href="<?php echo site_url($account_type.'/manage_attendance/'.$row['class_id']); ?>">
									<span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>					
					 
				</li>  
				
				<li class="<?php if ($page_name == 'assignment_submit') echo 'active'; ?> ">
                    <a href="<?php echo site_url($account_type.'/assignment_submit'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('assignment_submit'); ?></span>
                    </a>
                </li>




						 
				<!-- Education Progress -->
				
<!-- 				 <li class="<?php if ($page_name == 'tabulation_sheet') echo 'active'; ?> ">
                    <a href="<?php echo site_url($account_type.'/tabulation_sheet'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('academic report card'); ?></span>
                    </a>
                </li> -->
				
				<!-- Behavior Chart -->
				<li class="<?php if (( $page_name == 'student_behaviour' || $page_name == 'student_behaviour_details' )) echo 'opened active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('student_behaviours'); ?></span>
					</a>
					<ul>
						<?php					 
						
						foreach ($subclasses as $row):
							?>
							<li class="<?php if ($page_name == 'student_behaviour_details' && $class_id == $row['class_id']) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('teacher/student_behaviour_details/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
						<?php endforeach; ?>
					</ul>			
							 
				</li>		
				
				 
				<li class="<?php if ($page_name == 'student_health'  ) echo 'opened active'; ?> ">					 
					
					<a href="#">
						
						<span><i class="entypo-dot"></i><?php echo get_phrase('student_health'); ?></span>
					</a>
					<ul>
						<?php
						 						
						foreach ($subclasses as $row):
							?>
							<li class="<?php if (($page_name == 'student_health') && $class_id == $row['class_id']) echo 'active'; ?>">
								<a href="<?php echo site_url($account_type.'/student_health/'.$row['class_id']); ?>">
									<span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>					
					 
				</li>  
				
				

            </ul>
        </li>     
		
		<!-- CLASS -->
        <li class="<?php
        if ($page_name == 'class_layout' ||
                $page_name == 'assignments' ||  $page_name == 'teacher_profile'  || $page_name == 'teacher_table' )
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span><?php echo get_phrase('streams'); ?></span>
            </a>
            <ul>
				<li class="<?php if ($page_name == 'teacher_profile' )
					echo 'opened active'; ?> ">
					<a href="<?php echo site_url('teacher/teacher_profile/'.$this->session->userdata('login_user_id'));?>">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('my_streams'); ?></span>
					</a>					 
				</li> 
				<li class="<?php if ($page_name == 'teacher_table' )
					echo 'opened active'; ?> ">
					<a href="<?php echo site_url('teacher/teacher_table/'.$this->session->userdata('login_user_id'));?>">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('my_time_table'); ?></span>
					</a>					 
				</li>
				<li class="<?php if ($page_name == 'assignments' )
					echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type.'/assignments'); ?>">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('assignments'); ?></span>
					</a>					 
				</li>
				<li class="<?php if ($page_name == 'class_layout' )
					echo 'opened active'; ?> ">
					<a href="#">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('stream_layout'); ?></span>
					</a>		
					<ul>
                        <?php
                         						 						 						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'class_layout' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/class_layout/'.$row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
					
				</li>				
			</ul>
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

		<!-- EXAMS -->
        <li class="<?php
        if ($page_name == 'exam' ||
                $page_name == 'grade' ||
                $page_name == 'marks_manage' ||
                    $page_name == 'exam_marks_sms' ||
                            $page_name == 'marks_manage_view' || $page_name == 'question_paper')
                                echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/exam'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_list'); ?></span>
                    </a>
                </li>
                <!--li class="<?php if ($page_name == 'grade') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/grade'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_grades'); ?></span>
                    </a>
                </li-->
                <li class="<?php if ($page_name == 'marks_manage' || $page_name == 'marks_manage_view') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/marks_manage'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('fill_in_marks'); ?></span>
                    </a>
                </li>
				
				<li class="<?php if ($page_name == 'blank_score_sheet') echo 'active'; ?> ">
					<a href="<?php echo site_url('teacher/blank_score_sheet'); ?>">
					<span><i class="entypo-dot"></i> <?php echo get_phrase('blank_score_sheet'); ?></span>
					</a>
				</li>

				<li class="<?php if ($page_name == 'blank_marks_manage_subject') echo 'active'; ?> ">
					<a href="<?php echo site_url('teacher/blank_marks_manage_subject'); ?>">
					<span><i class="entypo-dot"></i> <?php echo get_phrase('blank_mark_book'); ?></span>
					</a>
				</li>
				
				
                <!--li class="<?php if ($page_name == 'exam_marks_sms') echo 'active'; ?> ">
                    <a href="<?php echo site_url('teacher/exam_marks_sms'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('send_marks_by_sms'); ?></span>
                    </a>
                </li-->               
                 
            </ul>
        </li>       

		<!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard' || $page_name == 'noticeboard_edit' || $page_name == 'group_message' || $page_name == 'media' || $page_name == 'media_edit' || $page_name == 'events' || $page_name == 'event_edit') echo 'opened active has-sub'; ?> ">
		
			<a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
            <ul>
				<li class="<?php if ($page_name == 'noticeboard' || $page_name == 'noticeboard_edit') echo 'opened active'; ?> ">
				<a href="<?php echo site_url($account_type.'/noticeboard'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('Announcements'); ?></span>
				</a>
				</li>  
				<li class="<?php if ($page_name == 'media' || $page_name == 'media_edit') echo 'opened active'; ?> ">
				<a href="<?php echo site_url($account_type.'/media'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('media'); ?></span>
				</a>
				</li> 
				<li class="<?php if ($page_name == 'group_message') echo 'opened active'; ?> ">
				<a href="<?php echo site_url($account_type.'/group_message'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('forums'); ?></span>
				</a>
				</li>
				<li class="<?php if ($page_name == 'events') echo 'opened active'; ?> ">
				<a href="<?php echo site_url($account_type.'/events'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('events'); ?></span>
				</a>
				</li>
			</ul> 
		</li> 



		<!-- CLASS ROUTINE OR TIME TABLE-->
		<li class="<?php if ($page_name == 'class_routine_view' || $page_name == 'timetable_upload' ||
                        $page_name == 'class_routine_add' || $page_name == 'class_routine_print_view')
                            echo 'opened active'; ?> ">
			<a href="<?php echo site_url('admin/timetable'); ?>">
				<i class="entypo-target"></i>
				<span><?php echo get_phrase('time_table'); ?></span>
			</a>
<!-- 			<ul>
                <li class="<?php if ($page_name == 'timetable_settings') echo 'active'; ?> ">
                        <a href="<?php echo site_url('admin/timetable'); ?>">
                            <span>Timetable</span>
                        </a>
                </li>					

			</ul> -->
		</li>



		<!-- GRAPHS -->
        <li class="<?php if ($page_name == 'graph_sheet') echo 'opened active has-sub';
        ?> ">
		
		    <a href="#">
				<i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('graphs'); ?></span>
            </a>
            <ul>
				 
				<li class="">
                    <a href="<?php echo site_url('teacher/subject_performance'); ?>">
					 <i class="entypo-chart-bar"></i>
					 <span><?php echo get_phrase('subject_performance'); ?></span>
                    </a>
                </li>
				<li class="">
                    <a href="<?php echo site_url('teacher/stream_performance'); ?>">
					 <i class="entypo-chart-bar"></i>
					<span><?php echo get_phrase('stream_performance'); ?></span>
                    </a>
                </li>				
			</ul>        
        </li> 




		
		
		<!-- REPORTS -->
        <li class="<?php if ($page_name == 'student_report') echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('reports'); ?></span>
            </a>
            <ul>              
								 
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('health'); ?></span></a>	
						<ul>
                        <?php
                       						 						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/student_report/'.$row['class_id'].'/1'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
					
				</li>
				
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('behavior'); ?></span>
					</a>
						<ul>
                        <?php
                          
						 						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/student_report/'.$row['class_id'].'/2'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
					
				</li>
				
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('fees'); ?></span>
					</a>
					<ul>
                        <?php                          
						 						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/student_report/'.$row['class_id'].'/3'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
					
				</li>
				
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('attendance'); ?></span>
					</a>
						<ul>
                        <?php
                         
						 						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/student_report/'.$row['class_id'].'/4'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
					
				</li>






				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('Subject Reports'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
                        $classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['class_id'] && $report == 7) echo 'active'; ?>">                             
                                <a href="<?php echo site_url('teacher/student_report/' . $row['class_id'].'/7'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
							
                        <?php endforeach; ?>
                    </ul>					
					
				</li>



			  <li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
				<a href="#">
					<i class="entypo-dot"></i>
					<span>Subject Analysis Reports</span>
				</a>
				<ul>
					<li class="<?php if ($page_name == 'manage_subject_analysis' || $page_name == 'manage_subject_analysis_view') echo 'active'; ?> ">
						<a href="<?php echo site_url('teacher/manage_subject_analysis'); ?>">
									<span><i class="entypo-dot"></i> <?php echo get_phrase('subject_analysis'); ?></span>
						 </a>
					</li>
					<li class=" <?php if ($page_name == 'manage_subject_analysis_per_subject' || $page_name == 'manage_subject_analysis_per_subject_view') echo 'active'; ?> ">
						<a href="<?php echo site_url('teacher/manage_subject_analysis_per_subject'); ?>">
									<span><i class="entypo-dot"></i>Analysis per Subject</span>
						</a>
					</li>

				</ul>
			</li>








				
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('academic reports'); ?></span>
					</a>
						<ul>
                        <?php
                          
						 						 
                        foreach ($subclasses as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id']) echo 'active'; ?>">
                                <a href="<?php echo site_url($account_type.'/student_report/'.$row['class_id'].'/5'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
					
				</li>		               

            </ul>
        </li>            
		          

		
        <li class="<?php if ($page_name == 'survey') echo 'active'; ?> ">
            <a href="<?php echo site_url('teacher/survey'); ?>">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('Survey'); ?></span>
            </a>
        </li>

		<!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile' ||$page_name == 'teacher_profile' ||$page_name == 'teacher_table' ||$page_name == 'notification_settings' || $page_name == 'feedback') echo 'opened active has-sub'; ?> ">
		
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
				
				<li class="<?php if ($page_name == 'teacher_profile') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type . '/teacher_profile/'.$this->session->userdata('login_user_id'));?>">
                        	<i class="entypo-key"></i>
							<span><?php echo get_phrase('my_streams');?></span>
						</a>
				</li>
				
				<li class="<?php if ($page_name == 'teacher_table') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type . '/teacher_table/'.$this->session->userdata('login_user_id'));?>">
                        	<i class="entypo-key"></i>
							<span><?php echo get_phrase('my_timetable');?></span>
						</a>
				</li>				
								
				<li class="<?php if ($page_name == 'notification_settings') echo 'opened active'; ?> ">
					<a href="<?php echo site_url($account_type . '/manage_notification'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('notification'); ?></span>
					</a>
				</li>
			
				<!-- Feedback -->
				<li class="<?php if ($page_name == 'feedback') echo 'active'; ?> ">
					<a href="<?php echo site_url($account_type . '/feedback'); ?>">
						<i class="entypo-lock"></i>
						<span><?php echo get_phrase('feedback'); ?></span>
					</a>
				</li>			
				

			</ul>
		</li>

    </ul>

</div>
