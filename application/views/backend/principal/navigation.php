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
		
		<li class="<?php
        if ($page_name == 'class' ||
                $page_name == 'section' || $page_name == 'class_subjects' || $page_name == 'behaviours' || $page_name == 'behaviour_contents' ||
                    $page_name == 'subject'  || $page_name == 'assignments'  || $page_name == 'timetable_upload'|| $page_name == 'class_routine_view' || $page_name == 'class_routine_add' || $page_name == 'class_routine_print_view' )
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span><?php echo get_phrase('Streams'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'class') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/classes'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_streams'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'section') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/section'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_classes'); ?></span>
                    </a>
                </li>
				
				<li class="<?php if ($page_name == 'class_subjects') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/class_subjects'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('stream_subjects'); ?></span>
                    </a>
                </li>
				
				<!-- SUBJECT -->
				<li class="<?php if ($page_name == 'subject') echo 'opened active'; ?> ">
					<a href="#">
						<i class="entypo-docs"></i>
						<span><?php echo get_phrase('manage_subjects'); ?></span>
					</a>
					<ul>
						<?php $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
						foreach ($classes as $row):
							?>
							<li class="<?php if ($page_name == 'subject' && $class_id == $row['class_id']) echo 'active'; ?>">
								<a href="<?php echo site_url($account_type.'/subject/'.$row['class_id']); ?>">
									<span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li> 
				
				<li class="<?php if ($page_name == 'student_elective_subject' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-docs"></i> <?php echo get_phrase('manage_elective_subject'); ?></span>
                    </a>
                    <ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_elective_subject' && $class_id == $row['class_id'] || $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">
                            <!--<li class="<?php if ($page_name == 'student_elective_subject' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">-->
                                <a href="<?php echo site_url('admin/student_elective_subject/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
				
				<!--<li class="<?php// if ($page_name == 'behaviours' || $page_name == 'behaviour_contents') echo 'opened active'; ?> ">
					<a href="#">
						<i class="entypo-dot"></i>
						<span><?php// echo get_phrase('behaviour_masters'); ?></span>
					</a>
					<ul>						
						 
						<li class="<?php// if ($page_name == 'behaviours') echo 'active'; ?>">
							<a href="<?php// echo site_url('admin/behaviours/'); ?>">
								<span><?php// echo get_phrase('behaviours'); ?></span>
							</a>
						</li>
						
						<li class="<?php// if ($page_name == 'behaviour_contents') echo 'active'; ?>">
							<a href="<?php// echo site_url('admin/behaviour_content/'); ?>">
								<span><?php// echo get_phrase('behaviour_contents'); ?></span>
							</a>
						</li>
					 
					</ul>
				</li> -->
				
				
				
				<li class="<?php if ($page_name == 'assignments') echo 'active'; ?> ">
                    <a href="<?php echo site_url('principal/assignments'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('assignments'); ?></span>
                    </a>
                </li>
				
				
				<!--<li class="<?php if ($page_name == 'class_layout') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/class_layout/1');?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('stream_layout'); ?></span>
                    </a>
                </li>-->
                
                
                
                
                <li class="<?php if ($page_name == 'class_routine_view' ||
                                $page_name == 'class_routine_add' || $page_name == 'class_routine_print_view')
                                    echo 'opened active'; ?> ">
					<a href="#">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('stream_layout'); ?></span>
					</a>
					<ul>
						<?php
						$school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
						foreach ($classes as $row):
							?>
							<li class="<?php if ($page_name == 'class_layout' && $class_id == $row['class_id']) echo 'active'; ?>">
								<a href="<?php echo site_url('admin/class_layout/'.$row['class_id']); ?>">
									<span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
				
				
				
            </ul>
        </li>
		
		<!-- CLASS ROUTINE OR TIME TABLE-->
				<li class="<?php if ($page_name == 'class_routine_view' || $page_name == 'timetable_upload' ||
                                $page_name == 'class_routine_add' || $page_name == 'class_routine_print_view')
                                    echo 'opened active'; ?> ">
					<a href="#">
						<i class="entypo-target"></i>
						<span><?php echo get_phrase('time_table'); ?></span>
					</a>
					<ul>
					    <li class="<?php if ($page_name == 'timetable_settings') echo 'active'; ?> ">
								<a href="<?php echo site_url('admin/timetable_settings'); ?>">
									<span><?php echo get_phrase('timetable_settings'); ?></span>
								</a>
						</li>
						<!--<li class="<?php if ($page_name == 'timetable_upload') echo 'active'; ?> ">
							<a href="<?php echo site_url('admin/timetable_upload'); ?>">
								<span><?php echo get_phrase('import_timetable'); ?></span>
							</a>
						</li>-->
                        <li class="<?php if ($page_name == 'timetable_settings') echo 'active'; ?> ">
                                <a href="<?php echo site_url('admin/timetable'); ?>">
                                    <span>Timetable</span>
                                </a>
                        </li>					

					</ul>
				</li>



         <!-- CBC Curriculum-->
                <li class="<?php if ($page_name == 'class_routine_view' || $page_name == 'timetable_upload' ||
                                $page_name == 'class_routine_add' || $page_name == 'class_routine_print_view')
                                    echo 'opened active'; ?> ">
                    <a href="#">
                        <i class="entypo-book-open"></i>
                        <span>CBC Report Card</span>
                    </a>
                    <ul>
                        <li class="<?php if ($page_name == 'reportdesign') echo 'active'; ?> ">
                                <a href="<?php echo site_url('admin/reportdesign'); ?>">
                                    <span>CBC Report Design</span>
                                </a>
                        </li>
                    
                        <li class="<?php if ($page_name == 'generatecbcreport') echo 'active'; ?> ">
                                <a href="<?php echo site_url('admin/generatecbcreport/0/0/0/0/0'); ?>">
                                    <span>Generate CBC Report</span>
                                </a>
                        </li>                   

                    </ul>
                </li>
		
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
				
				
				
				
                <li class="<?php if (( $page_name == 'student_health' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('student_health'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_health' && $class_id == $row['class_id']) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_health/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>					
					
				</li>
				
					<!-- Education Progress -->
				
				 <li class="<?php if ($page_name == 'assignment_submit') echo 'active'; ?> ">
                    <a href="<?php echo site_url('principal/assignment_submit'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('assignment_submit'); ?></span>
                    </a>
                </li>
				
				  				
				 
                <!-- STUDENT PROMOTION -->
                <!--li class="<?php if ($page_name == 'student_promotion') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_promotion'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_promotion'); ?></span>
                    </a>
                </li-->

            </ul>
        </li> 
		
		<!-- DAILY ATTENDANCE -->
				<li class="<?php if ($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view' || $page_name == 'attendance_report' || $page_name == 'attendance_report_view')
											echo 'opened active'; ?> ">					 
					
					<a href="#">
						<i class="entypo-chart-area"></i>
						<span><?php echo get_phrase('attendance'); ?></span>
					</a>
					<ul>
						<?php
						$school_id = $this->session->userdata('school_id');
						
						$user_id = $this->session->userdata('login_user_id');      
							 
						$classids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('principal_id', $user_id)->group_by("class_id")->get('subject')->row()->classes;
						 
						if($classids !='')
							$classes = $this->db->where_in('class_id', explode(',',$classids))->get('class')->result_array();
						else							
							$classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
						
						 
						foreach ($classes as $row):
							?>
							<li class="<?php if (($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view') && $class_id == $row['class_id']) echo 'active'; ?>">
								<a href="<?php echo site_url($account_type.'/manage_attendance/'.$row['class_id']); ?>">
									<span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>					
					 
				</li> 
		
		<li class="<?php if (( $page_name == 'student_behaviour' || $page_name == 'student_behaviour_details' )) echo 'opened active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('student_behaviour'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_behaviour_details' && $class_id == $row['class_id']) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_behaviour_details/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>					
					
				</li> 
		
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
                <span><?php echo get_phrase('academics'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/exam'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'grade') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/grade'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_grades'); ?></span>
                    </a>
                </li>
				<li class="<?php if ($page_name == 'performance_grade') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/performance_grade'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('performance_grades'); ?></span>
                    </a>
                </li>
                <!--<li class="<?php if ($page_name == 'marks_manage' || $page_name == 'marks_manage_view') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/marks_manage'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_marks'); ?></span>
                    </a>
                </li>
                li class="<?php if ($page_name == 'exam_marks_sms') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/exam_marks_sms'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('send_marks_by_sms'); ?></span>
                    </a>
                </li-->           
                
						<li class="<?php if ($page_name == 'marks_manage' || $page_name == 'marks_manage_view') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/marks_manage'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('fill_in_marks'); ?></span>
                    </a>
        </li>
		
		<li class="<?php if ($page_name == 'processdata') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/results'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('Result Processing'); ?></span>
                    </a>
       </li>
		
		
				
		<li class="<?php if ($page_name == 'score_sheet_per_subject') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/score_sheet_per_subject'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('score_sheet_per_subject'); ?></span>
                    </a>
        </li>
				
		
		
		<li class="<?php if ($page_name == 'blank_score_sheet') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/blank_score_sheet'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('blank_score_sheet'); ?></span>
                    </a>
          </li>
		
		<li class="<?php if ($page_name == 'blank_marks_manage_subject') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/blank_marks_manage_subject'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('blank_mark_book'); ?></span>
                    </a>
          </li>
		
		
		
		<!--Mark Book-->
		
		<li class="<?php if ($page_name == 'markbook' || $page_name == 'marks_manage_subject_view') echo 'active'; ?> "> 
				<a href="<?php echo site_url('admin/markbook'); ?>">
				<span><i class="entypo-dot"></i> <?php echo get_phrase('mark_book_per_subject'); ?></span>                    </a>
                </li>
				<li class="<?php if ($page_name == 'broadsheet') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/broadsheet'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('broad sheet'); ?></span>
                    </a>
       </li>
				
            </ul>
        </li>
		
		<!--score_sheets-->

		
		<!--Mark Book-->
		
		
		<!--Subject Analysis-->
		
		<!--<li class="<?php if ($page_name == 'manage_subject_analysis' || $page_name == 'manage_subject_analysis_view') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/manage_subject_analysis'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('subject_analysis'); ?></span>
                    </a>
          </li>-->
		  

		
		<!--Subject Analysis-->
		
		
		<!--Academic Report cards-->
		
		
		
		

		
		<!--Academic Reports-->
		
			   
	   
	   <!--Academic Transcript-->
		
	   
	   <li class="<?php if ($page_name == 'academic_transcript' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('academic_transcript'); ?></span>
                    </a>
                    <ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'academic_transcript' && $class_id == $row['class_id'] || $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">
                            <!--<li class="<?php if ($page_name == 'academic_transcript' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">-->
                                <a href="<?php echo site_url('admin/academic_transcript/' . $row['class_id']); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
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
                    <a href="<?php echo site_url('admin/subject_performance'); ?>">
					 <i class="entypo-chart-bar"></i>
					 <span><?php echo get_phrase('subject_performance'); ?></span>
                    </a>
                </li>
				<li class="">
                    <a href="<?php echo site_url('admin/stream_performance'); ?>">
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
						<span><i class="entypo-dot"></i><?php echo get_phrase('health'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['class_id'] && $report == 1) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_report/' . $row['class_id'].'/1'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>					
					
				</li>
				
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('behaviour'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['class_id'] && $report == 2) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_report/' . $row['class_id'].'/2'); ?>">
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
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['class_id'] && $report == 3) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_report/' . $row['class_id'].'/3'); ?>">
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
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['class_id'] && $report == 4) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_report/' . $row['class_id'].'/4'); ?>">
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
                                <a href="<?php echo site_url('admin/student_report/' . $row['class_id'].'/7'); ?>">
                                    <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                            
                        <?php endforeach; ?>
                    </ul>                   
                    
                </li>



                 <!--  <li class="root-level has-sub"> -->
            <li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
                    <a href="#">
                        <i class="entypo-dot"></i>
                        <span>Subject Analysis Reports</span>
                    </a>
                    <ul>
                        <li class="<?php if ($page_name == 'manage_subject_analysis' || $page_name == 'manage_subject_analysis_view') echo 'active'; ?> ">
                            <a href="<?php echo site_url('admin/manage_subject_analysis'); ?>">
                                        <span><i class="entypo-dot"></i> <?php echo get_phrase('subject_analysis'); ?></span>
                             </a>
                        </li>
                        <li class=" <?php if ($page_name == 'manage_subject_analysis_per_subject' || $page_name == 'manage_subject_analysis_per_subject_view') echo 'active'; ?> ">
                            <a href="<?php echo site_url('admin/manage_subject_analysis_per_subject'); ?>">
                                        <span><i class="entypo-dot"></i> <?php echo get_phrase('subject_analysis_per_subject'); ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                  





             <!--Academic Reports-->        
                    <li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
                                <a href="#">
                                    <span><i class="entypo-dot"></i><?php echo get_phrase('academic reports'); ?></span>
                                </a>

                                <ul>
                                    <?php
                                    $school_id = $this->session->userdata('school_id');
                                    $classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                                    foreach ($classes as $row):
                                        ?>
                                        <li class="<?php if ($page_name == 'student_report' && $class_id == $row['class_id'] && $report == 5) echo 'active'; ?>">
                                         
                                            <a href="<?php echo site_url('admin/student_report/' . $row['class_id'].'/5'); ?>">
                                                <span><?php echo get_phrase('stream'); ?> <?php echo $row['name']; ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                            </li>
            				
				
				
				

            </ul>
        </li>
		
		
		
		
		
		
        <!-- ACCOUNTING -->
        <li class="<?php
        if ($page_name == 'income' || 
			$page_name == 'terms' ||
				$page_name == 'fees' ||
                        $page_name == 'student_payment' ||
                        $page_name == 'fees_upload')
                            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-suitcase"></i>
                <span><?php echo get_phrase('school_fees'); ?></span>
            </a>
            <ul>
			
			
				<li class="<?php if ($page_name == 'terms') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/terms'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('terms_list'); ?></span>
                    </a>
                </li> 
				
				 <li class="<?php if ($page_name == 'fees') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/fee'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('fees_structure'); ?></span>
                    </a>
                </li> 
				
				<li class="<?php if ($page_name == 'student_payment') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/student_payment'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_student_payment'); ?></span>
                    </a>
                </li>
				
				<li class="<?php if ($page_name == 'fees_upload') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/fees_upload'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('import_fees_records'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'income') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_payments'); ?></span>
                    </a>
                </li>    

				
				
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
		
		            
		
        <li class="<?php if ($page_name == 'survey') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/survey'); ?>">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('Survey'); ?></span>
            </a>
        </li>
		

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
