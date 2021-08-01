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
				
				
				
				

            </ul>
        </li>
		
		
	
		</ul>

</div>
