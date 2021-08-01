
<!DOCTYPE html>
<html lang="en" dir="">
<head>
	
	<title>Subject Allocation | AQUINAS HIGH SCHOOL</title>
    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="FPS School Manager Pro - FreePhpSoftwares" />
	<meta name="author" content="FreePhpSoftwares" />
	<link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
	
    <link rel="stylesheet" href="assetss/css/norm alize.css">
   
    <link rel="stylesheet" href="assetss/css/font-awesome.min.css">
    <link rel="stylesheet" href="assetss/css/themify-icons.css">
    <link rel="stylesheet" href="assetss/css/flag-icon.min.css">
    <link rel="stylesheet" href="assetss/scss/st yle.css">
   <link rel="stylesheet" href="assetss/css/lib/chosen/cho sen.min.css">
	

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/neon-core.css">
<link rel="stylesheet" href="assets/css/neon-theme.css">
<link rel="stylesheet" href="assets/css/neon-forms.css">

<link rel="stylesheet" href="assets/css/custom.css">


    <link rel="stylesheet" href="assets/css/skins/default.css">


<script src="assets/js/jquery-1.11.0.min.js"></script>

        <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="assets/images/favicon.png">
<link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="assets/js/vertical-timeline/css/component.css">
<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">


<!--Amcharts-->
<script src="assets/js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="assets/js/amcharts/pie.js" type="text/javascript"></script>
<script src="assets/js/amcharts/serial.js" type="text/javascript"></script>
<script src="assets/js/amcharts/gauge.js" type="text/javascript"></script>
<script src="assets/js/amcharts/funnel.js" type="text/javascript"></script>
<script src="assets/js/amcharts/radar.js" type="text/javascript"></script>
<script src="assets/js/amcharts/exporting/amexport.js" type="text/javascript"></script>
<script src="assets/js/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
<script src="assets/js/amcharts/exporting/canvg.js" type="text/javascript"></script>
<script src="assets/js/amcharts/exporting/jspdf.js" type="text/javascript"></script>
<script src="assets/js/amcharts/exporting/filesaver.js" type="text/javascript"></script>
<script src="assets/js/amcharts/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>

<script>
    function checkDelete()
    {
        var chk=confirm("Are You Sure To Delete This !");
        if(chk)
        {
          return true;  
        }
        else{
            return false;
        }
    }
</script>	
</head>
<body class="page-body skin-default" >
	<div class="page-container " >
		<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        

        <!-- logo collapse icon -->
        <div class="sidebar" style="">
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
        <li class=" ">
            <a href="index.php?admin/dashboard">
                <i class="entypo-gauge"></i>
                <span>DASHBOARD</span>
            </a>
        </li>

        <!-- STUDENT -->
        <li class=" ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span>REGISTRY</span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class=" ">
                    <a href="index.php?admin/student_add">
                        <span><i class="entypo-dot"></i> Student Admission</span>
                    </a>
                </li>
				 <li class=" ">
                        <a href="index.php?admin/student_bulk_add">
                            <span> <i class="entypo-dot"></i>Admit Bulk Student</span>
							</a>
                    </li>
                <!-- STUDENT BULK ADMISSION -->
				<li class=" ">
                        <a href="index.php?admin/student_information">
                            <span> <i class="entypo-dot"></i>Student Information</span></span>
                        </a>
                        <ul class="nav child_menu">
                                                            <li class="">
                                    <a href="index.php?admin/student_information/1">
                                        <span> FORM 1</span>
                                    </a>
									
									 
									
									
                                </li>
                                                            <li class="">
                                    <a href="index.php?admin/student_information/2">
                                        <span> FORM 2</span>
                                    </a>
									
									 
									
									
                                </li>
                                                            <li class="">
                                    <a href="index.php?admin/student_information/3">
                                        <span> FORM 3</span>
                                    </a>
									
									 
									
									
                                </li>
                                                            <li class="">
                                    <a href="index.php?admin/student_information/4">
                                        <span> FORM 4</span>
                                    </a>
									
									 
									
									
                                </li>
                                                    </ul>
						</li>
                <li class=" ">
                    <a href="index.php?admin/student_bulk_add">
                        <span><i class="entypo-dot"></i> Awards And Discipline</span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class=" ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> Leaving Certificate</span>
                    </a>
                    
                </li>

            </ul>
        </li>
 <!-- CLASS -->
            <li class=" ">
                <a href="#">
                    <i class="entypo-flow-tree"></i>
                    <span>CLASS</span></span>
                </a>
                <ul class="nav child_menu">
                    <li class=" ">
                        <a href="index.php?admin/classes">
                            <span> Manage Classes</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="index.php?admin/section">
                            <span> Manage Sections</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="index.php?admin/academic_syllabus">
                            <span> Academic Syllabus</span>
                        </a>
                    </li>
                </ul>
            </li>
        <!-- ACCOUNT -->
        <li class=" ">
            <a href="index.php?admin/teacher">
                <i class="entypo-suitcase"></i>
                <span>ACCOUNTS</span>
            </a>
        </li>

        

        <!-- CLASS -->
        <li class=" ">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span>ACADEMICS</span>
            </a>
            <ul>
                <li class=" ">
                <a href="#">
                    <i class="entypo-docs"></i>
                    <span>Subjects</span></span>
                </a>
                <ul class="nav child_menu">
                                            <li class="">
                            <a href="index.php?admin/subject/1">
                                <span>FORM 1</span>
                            </a>
                        </li>
                                            <li class="">
                            <a href="index.php?admin/subject/2">
                                <span>FORM 2</span>
                            </a>
                        </li>
                                            <li class="">
                            <a href="index.php?admin/subject/3">
                                <span>FORM 3</span>
                            </a>
                        </li>
                                            <li class="">
                            <a href="index.php?admin/subject/4">
                                <span>FORM 4</span>
                            </a>
                        </li>
                                    </ul>
            </li>
				
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Subjects Options</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/exam">
                        <span><i class="entypo-dot"></i> Exam Names</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/grade">
                        <span><i class="entypo-dot"></i> Grading Scale</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Tagets</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/dataentry">
                        <span><i class="entypo-dot"></i> Data Entry</span>
                    </a>
					<li class=" ">
                    <a href="results.php">
                        <span><i class="entypo-dot"></i> Results Processing</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Mark Book</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="broadsheet.php">
                        <span><i class="entypo-dot"></i> Broad Sheet</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Report Forms</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Graphical Analysis</span>
                    </a>
                </li>
               
            </ul>
        </li>

        <!-- STAFF -->
        <li class=" ">
            <a href="#">
                <i class="entypo-users"></i>
                <span>STAFF</span>
            </a>
            <ul>
                <li class=" ">
                    <a href="index.php?admin/teacher">
                        <span><i class="entypo-dot"></i> Staff Details</span>
                    </a>
                </li>
				<li class="active ">
                    <a href="index.php?admin/allocation">
                        <span><i class="entypo-dot"></i> Subject Allocation</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Allocation List</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Class Teachers</span>
                    </a>
                </li>
            </ul>
        </li>

      

        <!-- LIBRARY -->
        <li class=" ">
            <a href="index.php?admin/book">
                <i class="entypo-book"></i>
                <span>LIBRARY</span>
            </a>
			<ul>
                <li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Catalogue</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Issue Books</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Collect Items</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Lost Items</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Items Overdue</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Borrowed Items</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="index.php?admin/classes">
                        <span><i class="entypo-dot"></i> Messaging</span>
                    </a>
                </li>
            </ul>
			
        </li>

      

        <!-- DORMITORY -->
        <li class=" ">
            <a href="index.php?admin/dormitory">
                <i class="entypo-home"></i>
                <span>DORMITORY</span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class=" ">
            <a href="index.php?admin/noticeboard">
                <i class="entypo-doc-text-inv"></i>
                <span>NOTICEBOARD</span>
            </a>
        </li>

        <!-- MESSAGE -->
        <li class=" ">
            <a href="index.php?admin/message">
                <i class="entypo-mail"></i>
                <span>MESSAGE</span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class=" ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span>SETTINGS</span>
            </a>
            <ul>
                <li class=" ">
                    <a href="index.php?admin/system_settings">
                        <span><i class="entypo-dot"></i> General Settings</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="index.php?admin/sms_settings">
                        <span><i class="entypo-dot"></i> Sms Settings</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="index.php?admin/manage_language">
                        <span><i class="entypo-dot"></i> Language Settings</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class=" ">
            <a href="index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span>account</span>
            </a>
        </li>

    </ul>

</div>	
		<div class="main-content">
		
			<div class="row">
	<div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
		<h2 style="font-weight:200; margin:0px;">FRIJOTECH SCHOOL MANAGEMENT SYSTEM</h2>
    </div>
	<!-- Raw Links -->
	<div class="col-md-12 col-sm-12 clearfix ">
		
        <ul class="list-inline links-list pull-left">
        <!-- Language Selector -->			
           <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        	<i class="entypo-user"></i> admin                    </a>

								<ul class="dropdown-menu pull-left">
					<li>
						<a href="index.php?admin/manage_profile">
                        	<i class="entypo-info"></i>
							<span>Edit Profile</span>
						</a>
					</li>
					<li>
						<a href="index.php?admin/manage_profile">
                        	<i class="entypo-key"></i>
							<span>change password</span>
						</a>
					</li>
				</ul>
											</li>
        </ul>
        
        
		<ul class="list-inline links-list pull-right">
			
			<!-- Language Selector 			
           <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <i class="entypo-globe"></i> language
                    </a>
				
				<ul class="dropdown-menu pull-left">
					                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/english">
                                            <img src="assets/images/flag/english.png" style="width:16px; height:16px;" />	
												 <span>english</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/bengali">
                                            <img src="assets/images/flag/bengali.png" style="width:16px; height:16px;" />	
												 <span>bengali</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/spanish">
                                            <img src="assets/images/flag/spanish.png" style="width:16px; height:16px;" />	
												 <span>spanish</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/arabic">
                                            <img src="assets/images/flag/arabic.png" style="width:16px; height:16px;" />	
												 <span>arabic</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/dutch">
                                            <img src="assets/images/flag/dutch.png" style="width:16px; height:16px;" />	
												 <span>dutch</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/russian">
                                            <img src="assets/images/flag/russian.png" style="width:16px; height:16px;" />	
												 <span>russian</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/chinese">
                                            <img src="assets/images/flag/chinese.png" style="width:16px; height:16px;" />	
												 <span>chinese</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/turkish">
                                            <img src="assets/images/flag/turkish.png" style="width:16px; height:16px;" />	
												 <span>turkish</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/portuguese">
                                            <img src="assets/images/flag/portuguese.png" style="width:16px; height:16px;" />	
												 <span>portuguese</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/hungarian">
                                            <img src="assets/images/flag/hungarian.png" style="width:16px; height:16px;" />	
												 <span>hungarian</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/french">
                                            <img src="assets/images/flag/french.png" style="width:16px; height:16px;" />	
												 <span>french</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/greek">
                                            <img src="assets/images/flag/greek.png" style="width:16px; height:16px;" />	
												 <span>greek</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/german">
                                            <img src="assets/images/flag/german.png" style="width:16px; height:16px;" />	
												 <span>german</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/italian">
                                            <img src="assets/images/flag/italian.png" style="width:16px; height:16px;" />	
												 <span>italian</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/thai">
                                            <img src="assets/images/flag/thai.png" style="width:16px; height:16px;" />	
												 <span>thai</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/urdu">
                                            <img src="assets/images/flag/urdu.png" style="width:16px; height:16px;" />	
												 <span>urdu</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/hindi">
                                            <img src="assets/images/flag/hindi.png" style="width:16px; height:16px;" />	
												 <span>hindi</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/latin">
                                            <img src="assets/images/flag/latin.png" style="width:16px; height:16px;" />	
												 <span>latin</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/indonesian">
                                            <img src="assets/images/flag/indonesian.png" style="width:16px; height:16px;" />	
												 <span>indonesian</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/japanese">
                                            <img src="assets/images/flag/japanese.png" style="width:16px; height:16px;" />	
												 <span>japanese</span>
                                        </a>
                                    </li>
                                                                    <li class="">
                                        <a href="index.php?multilanguage/select_language/korean">
                                            <img src="assets/images/flag/korean.png" style="width:16px; height:16px;" />	
												 <span>korean</span>
                                        </a>
                                    </li>
                                                    
				</ul>
				
			</li>
			-->
			<!--<li class="sep"></li>-->
			
			<li>
				<a href="index.php?login/logout">
					Log Out <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
	</div>
	
</div>

<hr style="margin-top:0px;" />
           <h3 style="">
           	<i class="entypo-right-circled"></i> 
				Subject Allocation           </h3>

			 <link rel="stylesheet" href="assetss/css/norm alize.css">
   
    <link rel="stylesheet" href="assetss/css/font-awesome.min.css">
    <link rel="stylesheet" href="assetss/css/themify-icons.css">
    <link rel="stylesheet" href="assetss/css/flag-icon.min.css">
    <link rel="stylesheet" href="assetss/scss/st yle.css">
   <link rel="stylesheet" href="assetss/css/lib/chosen/cho sen.min.css">
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered table responsive">
		<table  class=" table responsive table-con densed">
							<tr><td>
			<li class="active">             	<select data-placeholder="Choose a Term..." class="select2" tabindex="1" id="fr" >
								                                    <option value="1">FORM 1</option>
                                                                       <option value="2">FORM 2</option>
                                                                       <option value="3">FORM 3</option>
                                                                       <option value="4">FORM 4</option>
                                                                   </select></li></td><td>
			<li>
            	STREAM
				<select data-placeholder="Choose a Term..." class="select2" tabindex="1" id="Streams" >
								                                    <option  value="undefined">undefined</option>
                                                                       <option  value="ELECTRICAL ENGINEERING ">ELECTRICAL ENGINEERING </option>
                                                                   </select>
				</li>
				</td><td>
			<li>
						<br><button type="button" class="btn btn-primary" id="btn_search" style="height:40px; width:100px;"><i class="entypo-search"></i>Search</button>		</li>
				</td></tr>
								
								</table
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				<div id="datax">
               <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div>teacher name</div></th>
							 <div><th scope="col">Subject 1</div></th>
						   <div><th scope="col">Subject 2</div></th>
						   <div><th scope="col">Subject 3</div></th>
						   <div><th scope="col">Subject 4</div></th>
						   <div><th scope="col">Subject 5</div></th>
						   <div><th scope="col">Subject 6</div></th>
						   <div><th scope="col">Subject 7</div></th>
						   <div><th scope="col">Subject 8</div></th>
						                       		
						</tr>
					</thead>
                    <tbody>
                    	                        <tr>
                            <td>1</td>
							<td>jobuh frida</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
														<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
																	 
                                    <option  value="101">eng</option>
                                   									 
                                    <option  value="102">kisw</option>
                                   									 
                                    <option  value="103">math</option>
                                   									 
                                    <option  value="122">CHEM</option>
                                   									 
                                    <option  value="322">BIO</option>
                                   									 
                                    <option  value="223">BUSI</option>
                                   									 
                                    <option  value="333">AGRI</option>
                                   									 
                                    <option  value="339">COMP</option>
                                                                   </select>
								
        					</td>
							                        </tr>
                                            </tbody>
                </table>
			</div>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			
			<!----CREATION FORM ENDS-->
		</div>
	</div>
</div>

<script src="assetss/js/script.js"></script>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>
			<!-- Footer -->
<footer class="main">
	&copy; 2018 frijotech.com <strong> School Manager</strong>. 
    Developed by frijotech softwares </footer>

		</div>
		
        	
	</div>
	
        <script type="text/javascript">
	function showAjaxModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">FRIJOTECH SCHOOL MANAGEMENT SYSTEM</h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                
                    
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <script type="text/javascript">
	function confirm_modal(delete_url)
	{
		jQuery('#modal-4').modal('show', {backdrop: 'static'});
		document.getElementById('delete_link').setAttribute('href' , delete_url);
	}
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">delete</a>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>	
    	
    
    
    

	<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">
	<link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">

   	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/toastr.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/fileinput.js"></script>
    
    <script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/datatables/TableTools.min.js"></script>
	<script src="assets/js/dataTables.bootstrap.js"></script>
	<script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
	<script src="assets/js/datatables/lodash.min.js"></script>
	<script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>

    
	<script src="assets/js/neon-calendar.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>


<!-- SHOW TOASTR NOTIFIVATION -->


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>    
</body>
</html>