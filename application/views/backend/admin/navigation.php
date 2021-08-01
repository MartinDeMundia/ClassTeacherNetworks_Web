<div class="sidebar-menu">
    <header class="logo-env" >
        <!-- logo -->
        <div class="logo" style="">
            <!--<a href="<?php //echo site_url('login'); ?>">-->
			 <a href="<?php echo base_url(); ?>index.php/admin/dashboard">
                <img src="<?php echo base_url('uploads/logo.png');?>"  style="max-height:50px;width:190px"/>
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
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active">
        <li id="search">
  				<form class="" action="<?php echo site_url($account_type . '/student_details'); ?>" method="post">
  					<input type="text" class="search-input" name="student_identifier" placeholder="<?php echo get_phrase('student_name').' / '.get_phrase('code').'...'; ?>" value="" required style="font-family: 'Poppins', sans-serif !important; background-color: #2C2E3E !important; color: #868AA8; border-bottom: 1px solid #3F3E5F;">
  					<button type="submit">
  						<i class="entypo-search"></i>
  					</button>
  				</form>
			  </li -->

        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/dashboard'); ?>">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
		
		<!-- School -->
        <li class="<?php if ($page_name == 'school') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/school'); ?>">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('school'); ?></span>
            </a>
        </li>
		
		<!-- Principal -->
        <li class="<?php if ($page_name == 'principal') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/principal'); ?>">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('principal'); ?></span>
            </a>
        </li>
		
		 <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/teacher'); ?>">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
        </li>

        <!-- PARENTS -->
        <!--li class="<?php if ($page_name == 'parent') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/parent'); ?>">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('parents'); ?></span>
            </a>
        </li-->   

		
		<!-- Forums -->
		<li class="<?php if ($page_name == 'group_message') echo 'opened active'; ?> ">
				<a href="<?php echo site_url('admin/group_message'); ?>">
					<i class="entypo-doc-text-inv"></i>
					<span><?php echo get_phrase('forums'); ?></span>
				</a>
		</li>
		
		<!-- BEHAVIOUR -->
		
		<li class="<?php if ($page_name == 'behaviours') echo 'opened active has-sub';
        ?> ">
		<a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('behaviours'); ?></span>
            </a>
			<ul>
				<li class="<?php if ($page_name == 'behaviours') echo 'active'; ?> ">
					<a href="<?php echo site_url('admin/behaviours'); ?>">
						<i class="entypo-dot"></i>
						<span><?php echo get_phrase('behaviour'); ?></span>
					</a>
				</li>
				
				<!-- School -->
				<li class="<?php if ($page_name == 'behaviour_contents') echo 'active'; ?> ">
					<a href="<?php echo site_url('admin/behaviour_content'); ?>">
						<i class="entypo-dot"></i>
						<span><?php echo get_phrase('behaviour_content'); ?></span>
					</a>
				</li>
			</ul>
		</li>
		
		<!-- BEHAVIOUR -->

        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' )
                    echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/system_settings'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('system_settings'); ?></span>
                    </a>
                </li>				             
            </ul>
        </li>               

    </ul>

</div>
