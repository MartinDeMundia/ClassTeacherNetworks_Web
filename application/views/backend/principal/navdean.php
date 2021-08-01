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
                <li class="<?php if ($page_name == 'activate_exam' || $page_name == 'activate_exam') echo 'active'; ?> ">
                    <a href="<?php echo site_url('principal/activate_exam'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('activate_exam'); ?></span>
                    </a>
        </li>
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
		  
		  
		  <li class="root-level has-sub">
			<a href="#">
				<i class="entypo-dot"></i>
				<span>Academic Reports</span>
			</a>
			<ul>
			<li class="<?php if ($page_name == 'score_sheet_per_subject') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/score_sheet_per_subject'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('score_sheet_per_subject'); ?></span>
                    </a>
        </li>
				
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
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('Report Cards'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('form' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['Id'] && $report == 5) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_report/' . $row['Id'].'/5'); ?>">
                                    <span> <?php echo $row['Name']; ?></span>
                                </a>
                            </li>
							
							
							
                        <?php endforeach; ?>
                    </ul>					
					
				</li>

			</ul>
		</li>
		  
		
		<!--Subject Analysis-->
		
		
		<!--Academic Report cards-->
		
		
		
		
		<!--Academic Reports-->
		
		
				
				
				<li class="<?php if (( $page_name == 'student_report' )) echo 'active'; ?>">
					<a href="#">
						<span><i class="entypo-dot"></i><?php echo get_phrase('Subject Reports'); ?></span>
					</a>
					
					<ul>
                        <?php
                        $school_id = $this->session->userdata('school_id');
						$classes = $this->db->get_where('form' , array('school_id' => $school_id))->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_report' && $class_id == $row['Id'] && $report == 5) echo 'active'; ?>">
                             
                                <a href="<?php echo site_url('admin/student_report/' . $row['Id'].'/6'); ?>">
                                    <span> <?php echo $row['Name']; ?></span>
                                </a>
                            </li>
							
							
							
                        <?php endforeach;  ?>
                    </ul>					
					
				</li>
		
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
