<!DOCTYPE html>
<html lang="en" dir="">
<head>
	
	<title>manage exam | FRIJOTECH SCHOOL</title>
    
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Mwalimu Digital" />
	<meta name="author" content="frijotech" />
	<link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">
	

	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
 <link href="css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">

    <link href="css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <link href="css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">

    <link href="css/plugins/cropper/cropper.min.css" rel="stylesheet">

    <link href="css/plugins/switchery/switchery.css" rel="stylesheet">

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

    <link href="css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet">

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet">
 <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
   <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
<link href="css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

    <link href="css/plugins/select2/select2.min.css" rel="stylesheet">
	<script type="text/javascript" src="lib/jquery.min.js"></script>
    <link href="css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/skins/default.css">


<link rel="stylesheet" type="text/css" href="lib/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="lib/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="lib/demo/d emo.css">
	<script src="js/jquery-3.1.1.min.js"></script>
      	


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
<body class="md-skin fixed-sidebar pace-done">
	
			
		<div id="wrapper" >
		 <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse collapsed">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg" style="max-height:48px; max-width: 48px"/>
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"></strong>
                             </span> <span class="text-muted text-xs block">admin <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="http://localhost/JSMSP/index.php?admin/manage_profile">Profile</a></li>
                                <li><a href="http://localhost/JSMSP/index.php?admin/message">Mailbox</a></li>
                                <li class="divider"></li>
                                <li><a href="http://localhost/JSMSP/index.php?login/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                           <img alt="image" class="img-circle" src="img/profile_small.jpg" style="max-height:48px; max-width: 48px"/>
                        </div>
                    </li>
  

        <!-- DASHBOARD -->
        <li class=" ">
            <a href="http://localhost/JSMSP/index.php?admin/dashboard">
                <i class="fa fa-th-large"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- STUDENT -->
        <li class=" ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span>Registry</span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <!-- STUDENT ADMISSION -->
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/student_add">
                         Student Admission</span>
                    </a>
                </li>
				 <li class=" ">
                        <a href="http://localhost/JSMSP/index.php?admin/student_bulk_add">
                            <span> <i class="entypo-dot"></i>Admit Bulk Student</span>
							</a>
                    </li>
                <!-- STUDENT BULK ADMISSION -->
				<li class=" ">
                        <a href="http://localhost/JSMSP/index.php?admin/student_information">
                            <span> <i class="entypo-dot"></i>Student Information</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-third-level collapse">
                                                            <li class="">
                                    <a href="http://localhost/JSMSP/index.php?admin/student_information/1">
                                        <span> FORM 1</span>
                                    </a>
									
									 
									
									
                                </li>
                                                            <li class="">
                                    <a href="http://localhost/JSMSP/index.php?admin/student_information/2">
                                        <span> FORM 2</span>
                                    </a>
									
									 
									
									
                                </li>
                                                            <li class="">
                                    <a href="http://localhost/JSMSP/index.php?admin/student_information/3">
                                        <span> FORM 3</span>
                                    </a>
									
									 
									
									
                                </li>
                                                            <li class="">
                                    <a href="http://localhost/JSMSP/index.php?admin/student_information/4">
                                        <span> FORM 4</span>
                                    </a>
									
									 
									
									
                                </li>
                                                    </ul>
						</li>
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/awards">
                         Awards And Discipline</span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/leave">
                         Leaving Certificate</span>
                    </a>
                    
                </li>

            </ul>
        </li>
 <!-- CLASS -->
            <li class=" ">
                <a href="#">
                    <i class="fa fa-list-alt"></i>
                    <span>Class</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class=" ">
                        <a href="http://localhost/JSMSP/index.php?admin/classes">
                            <span> Manage Classes</span>
                        </a>
                    </li>
                  
                </ul>
            </li>
        <!-- ACCOUNT -->
        <li class=" ">
            <a target="blank" href="http://localhost/JSMSP/accounts/admin/home.php">
                <i class="fa fa-suitcase"></i>
                <span>Accounts</span>
            </a>
        </li>

        

        <!-- CLASS -->
        <li class="        ">
            <a href="#">
                <i class="fa fa-certificate"></i>
                 <span class="nav-label">Academics</span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li class=" ">
                <a href="#">
                    <i class="entypo-docs"></i>
                    <span class="nav-label">Subjects</span><span class="fa arrow"></span>
                </a>
                <ul class="nav nav-third-level collapse">
                                            <li class="">
                            <a href="http://localhost/JSMSP/index.php?admin/subject/1">
                                <span>FORM 1</span>
                            </a>
                        </li>
                                            <li class="">
                            <a href="http://localhost/JSMSP/index.php?admin/subject/2">
                                <span>FORM 2</span>
                            </a>
                        </li>
                                            <li class="">
                            <a href="http://localhost/JSMSP/index.php?admin/subject/3">
                                <span>FORM 3</span>
                            </a>
                        </li>
                                            <li class="">
                            <a href="http://localhost/JSMSP/index.php?admin/subject/4">
                                <span>FORM 4</span>
                            </a>
                        </li>
                                    </ul>
            </li>
				
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/options">
                         Subjects Options</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/options">
                         Kcse Registration</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/exam">
                         Exam Names</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/grade">
                         Grading Scale</span>
                    </a>
                </li>
				
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/dataentry">
                         Data Entry</span>
                    </a></li>
					
					
					
					<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/raw">
                         Raw Data</span>
                    </a></li>
					
					
					
					
					<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/results">
                         Results Processing</span>
                    </a>
                </li>
				<li class="        ">
                    <a href="#">
                         Reports</span><span class="fa arrow"></span>
                    </a>
                <ul class="nav nav-third-level collapse">
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/markbook">
                             Blank Mark Book</span>
                    </a>
                </li>
				<li class=" ">
                     <a href="http://localhost/JSMSP/index.php?admin/scoresheet">
                             Score Sheet (Subject)</span>
                    </a>
                </li>
				
				<li class=" ">
                     <a href="http://localhost/JSMSP/index.php?admin/topbottom">
                             Top & Bottom Students</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/improvement">
                             Improvements</span>
                    </a>
                </li><li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/analysis">
                             Exam Analysis</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/graph">
                             Graphs</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/script">
                             Transcripts</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/markbooks">
                             Mark Book</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/broadsheet">
                             Broad Sheet</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/reports">
                              Report Forms</span>
                    </a>
                </li>
				</ul></li> 
				
               
            </ul>
        </li>

        <!-- STAFF -->
        <li class=" ">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Staff</span><span class="fa arrow"></span>
            </a>
            <ul  class="nav nav-second-level collapse">
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/teacher">
                         Staff Details</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/allocation">
                         Subject Allocation</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/allocation_list">
                         Allocation List</span>
                    </a>
                </li>
				<li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/classes">
                         Class Teachers</span>
                    </a>
                </li>
            </ul>
        </li>

      

        <!-- LIBRARY -->
        <li class=" ">
            <a href="library/home.php">
                <i class="fa fa-book"></i>
                <span>Library</span>
            </a>
			
			
        </li>

      

        <!-- DORMITORY -->
        <li class=" ">
            <a href="http://localhost/JSMSP/index.php?admin/dormitory">
                <i class="fa fa-home"></i>
                <span>Dormitory</span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class=" ">
            <a href="http://localhost/JSMSP/index.php?admin/noticeboard">
                <i class="fa fa-bell"></i>
                <span>Noticeboard</span>
            </a>
        </li>

        <!-- MESSAGE -->
        <li class=" ">
            <a href="http://localhost/JSMSP/index.php?admin/message">
                <i class="fa fa-comments"></i>
                <span>Message</span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class=" ">
            <a href="#">
                <i class="fa fa-cog"></i>
                <span>Settings</span><span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/system_settings">
                         General Settings</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/sms_settings">
                         Sms Settings</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="http://localhost/JSMSP/index.php?admin/manage_language">
                         Language Settings</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class=" ">
            <a href="http://localhost/JSMSP/index.php?admin/manage_profile">
                <i class="fa fa-unlock-alt"></i>
                <span>account</span>
            </a>
        </li>

    </ul>

</div>
  
        </nav>			 <div id="page-wrapper" class="gray-bg"><div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
             <ul class="nav navbar-top-links navbar-left">
                <li>
                   <h3 class="m-r-sm  welcome-message">manage exam</h3>
                </li>
                


                
                
            </ul>
        </div>
		
		
		
            <ul class="nav navbar-top-links navbar-right">
               
                


                <li>
                    <a href="http://localhost/JSMSP/index.php?login/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                
            </ul>

        </nav>
        </div>








          
				
            <div class="scroll_content">

			<div class="wrapper wrapper-content animated bounceIn">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>EXAM NAMES</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div><HR>
                    <div class="ibox-content">
<div class="table-responsive">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					exam list                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					add exam                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <table  class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>exam name</div></th>
                    		<th><div>date</div></th>
                    		<th><div>comment</div></th>
							<th><div>Limit</div></th>
                    		<th><div>options</div></th>
						</tr>
					</thead>
                    <tbody>
                    	                        <tr>
							<td>CAT 1</td>
							<td>12/04/2018</td>
							<td>NO COMMENTS </td>
							<td>15</td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('http://localhost/JSMSP/index.php?modal/popup/modal_edit_exam/5');">
                                            <i class="entypo-pencil"></i>
                                                edit                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('http://localhost/JSMSP/index.php?admin/exam/delete/5');">
                                            <i class="entypo-trash"></i>
                                                delete                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                                                <tr>
							<td>CAT 2</td>
							<td>12/04/2018</td>
							<td>NO COMMENTS </td>
							<td>15</td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('http://localhost/JSMSP/index.php?modal/popup/modal_edit_exam/6');">
                                            <i class="entypo-pencil"></i>
                                                edit                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('http://localhost/JSMSP/index.php?admin/exam/delete/6');">
                                            <i class="entypo-trash"></i>
                                                delete                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                                                <tr>
							<td>CAT 3</td>
							<td>12/04/2018</td>
							<td>NO COMMENTS </td>
							<td>15</td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('http://localhost/JSMSP/index.php?modal/popup/modal_edit_exam/7');">
                                            <i class="entypo-pencil"></i>
                                                edit                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('http://localhost/JSMSP/index.php?admin/exam/delete/7');">
                                            <i class="entypo-trash"></i>
                                                delete                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                                                <tr>
							<td>END-TERM</td>
							<td>12/04/2018</td>
							<td>NO COMMENTS </td>
							<td>70</td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('http://localhost/JSMSP/index.php?modal/popup/modal_edit_exam/8');">
                                            <i class="entypo-pencil"></i>
                                                edit                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('http://localhost/JSMSP/index.php?admin/exam/delete/8');">
                                            <i class="entypo-trash"></i>
                                                delete                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                                                <tr>
							<td>MOCK EXAM</td>
							<td>12/13/32</td>
							<td>mocks exam</td>
							<td>70</td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('http://localhost/JSMSP/index.php?modal/popup/modal_edit_exam/13');">
                                            <i class="entypo-pencil"></i>
                                                edit                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('http://localhost/JSMSP/index.php?admin/exam/delete/13');">
                                            <i class="entypo-trash"></i>
                                                delete                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                                                <tr>
							<td>END OF TERM</td>
							<td></td>
							<td></td>
							<td>0</td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('http://localhost/JSMSP/index.php?modal/popup/modal_edit_exam/14');">
                                            <i class="entypo-pencil"></i>
                                                edit                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('http://localhost/JSMSP/index.php?admin/exam/delete/14');">
                                            <i class="entypo-trash"></i>
                                                delete                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                                            </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<form action="http://localhost/JSMSP/index.php?admin/exam/create" class="form-horizontal form-groups-bordered validate" target="_top" method="post" accept-charset="utf-8">
                        
                            <div class="form-group">
                                <label class="col-sm-3 control-label">name</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="Value Required"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">date</label>
                                <div class="col-sm-5">
                                    <input type="text" class="datepicker form-control" name="date"/ required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">comment</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="comment"/>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-sm-3 control-label">Limit</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="limit" required/>
                                </div>
                            </div>
							
                        		<div class="form-group">
                              	<div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info">add exam</button>
                              	</div>
								</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
            
		</div>
	</div>
	
</div>
 </div>
</div></div></div></div></div>

</div></div></div>
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
			<div class="footer fixed">
                    <div class="pull-right">
                        For help contact <strong>0741727458</strong> 
                    </div>
                    <div>
                        <strong>Copyright</strong> FRIJOTECH &copy; 2019                    </div>
                </div>
		</div>
		
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
    <div class="modal inmodal fade" id="modal_ajax" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
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
    <div class="modal inmodal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link">delete</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>		

   	<!-- Bottom Scripts -->
	 <script src="js/jquery-3.1.1.min.js"></script> 
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
 <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="js/plugins/dataTables/datatables.min.js"></script>
    <!-- GITTER -->
    <script src="js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
  

	<script type="text/javascript" src="lib/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="lib/jquery.edatagrid.js"></script>
    <!-- ChartJS-->
      <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>

    <!-- Toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>
 <script src="js/plugins/chartJs/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
 <script src="js/plugins/ladda/spin.min.js"></script>
    <script src="js/plugins/ladda/ladda.min.js"></script>
    <script src="js/plugins/ladda/ladda.jquery.min.js"></script>
 <script src="js/plugins/iCheck/icheck.min.js"></script>
 <script src="js/plugins/chartJs/Chart.min.js"></script>
<script>

    $(document).ready(function (){

        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 2000 });

        // Bind progress buttons and simulate loading progress
        Ladda.bind( '.progress-demo .ladda-button',{
            callback: function( instance ){
                var progress = 0;
                var interval = setInterval( function(){
                    progress = Math.min( progress + Math.random() * 0.1, 1 );
                    instance.setProgress( progress );

                    if( progress === 1 ){
                        instance.stop();
                        clearInterval( interval );
                    }
                }, 200 );
            }
        });


        var l = $( '.ladda-button-demo' ).ladda();

        l.click(function(){
            // Start loading
            l.ladda( 'start' );

            // Timeout example
            // Do something in backend and then stop ladda
            setTimeout(function(){
                l.ladda('stop');
            },12000)


        });

    });

</script>



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