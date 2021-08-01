<?php
session_start();
if (isset($_SESSION['form'])){
require("dbconn.php");
$title='';
$address='';
$tel='';
$q1s="select description from settings where type='system_title'";
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}

$q1s="select description from settings where type='address'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}

?>

 <html lang="en" dir="">
<head>
	
	<title>BroadSheet |  <?php echo strtoupper($title); ?></title>
    
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
                    <a href="index.php?admin/awards">
                        <span><i class="entypo-dot"></i> Awards And Discipline</span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class=" ">
                    <a href="index.php?admin/leave">
                        <span><i class="entypo-dot"></i> Leaving Certificate</span>
                    </a>
                    
                </li>

            </ul>
        </li>
 <!-- CLASS -->
            <li class="opened active ">
                <a href="#">
                    <i class="entypo-flow-tree"></i>
                    <span>CLASS</span></span>
                </a>
                <ul class="nav child_menu">
                    <li class="active ">
                        <a href="index.php?admin/classes">
                            <span> Manage Classes</span>
                        </a>
                    </li>
                  
                </ul>
            </li>
        <!-- ACCOUNT -->
        <li class=" ">
            <a target="blank" href="accounts/admin/home.php">
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
                    <a href="index.php?admin/options">
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
                    <a href="index.php?admin/dataentry">
                        <span><i class="entypo-dot"></i> Data Entry</span>
                    </a>
					<li class=" ">
                    <a href="results.php">
                        <span><i class="entypo-dot"></i> Results Processing</span>
                    </a>
                </li>
				<li class="active ">
                    <a href="markbook.php">
                        <span><i class="entypo-dot"></i> Mark Book</span>
                    </a>
                </li>
				<li class="active ">
                    <a href="broadsheet.php">
                        <span><i class="entypo-dot"></i> Broad Sheet</span>
                    </a>
                </li>
				<li class="active ">
                    <a href="report.php">
                        <span><i class="entypo-dot"></i> Report Forms</span>
                    </a>
                </li>
				<li class="active ">
                    <a href="analysis.php">
                        <span><i class="entypo-dot"></i> Analysis</span>
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
				<li class=" ">
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
		<h2 style="font-weight:200; margin:0px;">Jotech SCHOOL MANAGEMENT SYSTEM</h2>
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
			
			
			<li>
				<a href="index.php?login/logout">
					Log Out <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
		
		<div class="card">
                        <div class="card-header">
                            
							<form method="POST" enctype="multipart/form-data" ><div class="table-responsive">
							<table  class=" table responsive table-con densed">
							<tr>
							<td><select data-placeholder="Choose a Term..." class="select2" tabindex="1" id="term">
                                  
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option><option value="all">ALL</option>
                                </select></td>
								
								
							
							<td><select data-placeholder="Choose exam..." class="select2" tabindex="1" id="examtype">
                                  <?php
								  
								  include_once("dbconn.php");
								  $q="SELECT term1 from exams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
								 
								  
									  <option  <?php if ($_SESSION['en']==$row['term1'])echo 'selected';?> value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
									  
								  }
								  
								  ?>
                                   </option>
									   <option <?php if ($_SESSION['en']=="all")echo 'selected';?> value="all">ALL</option>
                                </select></td>
								
								<td>
								<select data-placeholder="Choose a Term..." class="select2" tabindex="1" id="fr" >
								<?php
                                   $q="SELECT * from form";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option <?php if ($_SESSION['form']==$row['Name'])echo 'selected';?> value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?>
                                </select>
								</td>
								
								
								<td>
								<select data-placeholder="Choose a Term..." class="select2" tabindex="1" id="year">
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option <?php if ($_SESSION['year']==((date("Y")-3)+$i))echo 'selected';?> value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select>
								</td>
								
								
								<td>
								<select data-placeholder="Choose a Term..." class="select2" tabindex="1" id="Streams" >
								<?php
                                   $q="SELECT * from streams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option <?php if ($_SESSION['Stream']==$row['Name'])echo 'selected';?> value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?><option value="all">ALL</option>
                                </select>
								</td>
								<td>
								<button type="button" class="btn btn-primary btn-lg btn-block" id="process" value="SEARCH" style="display:;">PROCESS</button>
								</td>
								</tr>
								
								
								
								<tr>
								
								<tr id="cats" style="display:<?php if ($_SESSION['en'] !== "all") echo 'none';?>;">
								<div  style="display:none;">
								<td>
								<div class="checkbox" id="sp">
                                  INCLUDE CAT 
                                
                                </div>
								
								</td>
								<td>
								<div class="checkbox" id="sp">
                                  <label for="checkbox1" class="form-check-label ">
                                    <input <?php if ($_SESSION['cat1']=="True") echo 'checked';?>  name="checkbox1" value="option1" class="form-check-input" type="checkbox" id="cat1"/>CAT 1
                                  </label>
                                </div>
								
								</td>
								
								<td>
								<div class="checkbox" id="sp">
                                  <label for="checkbox1" class="form-check-label ">
                                    <input <?php if ($_SESSION['cat2']=="True") echo 'checked';?>  name="checkbox1" value="option1" class="form-check-input" type="checkbox" id="cat2"/>CAT 2
                                  </label>
                                </div>
								
								</td>
								<td>
								<div class="checkbox" id="sp">
                                  <label for="checkbox1" class="form-check-label ">
                                    <input <?php if ($_SESSION['cat3']=="True") echo 'checked';?>  name="checkbox1" value="option1" class="form-check-input" type="checkbox" id="cat3"/>CAT 3
                                  </label>
                                </div>
								
								</td>
								</div>
								<td>
								<button style="display:none; type="button" class="btn btn-primary btn-lg btn-block" id="submit2" value="SEARCH" style="display:;">PROCESS</button>
								</td>
								</tr>
								
								</table></div>
								</form>
								
                        </div>
                        
						<!-- FILTER DATA -->
						
						
                    </div>
		
	</div>
	
</div>

<hr style="margin-top:0px;" />
           <h3 style="">
           	<i class="entypo-right-circled"></i> 
				Results <a target="blank" href="broadsheet-print.php" class="btn btn-default">Print</a>           </h3>

		<link rel="stylesheet" href="assetss/css/boot strap.min.css">
		<?php
include_once("dbconn.php");
//$subjectno=mysqli_real_escape_string($con,$_POST['sn']);
//$f2.Limit1 = 0; 

/*
$form="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$f2="form".mysqli_real_escape_string($con,$_POST['form']);
$Stream=mysqli_real_escape_string($con,$_POST['stream']);
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam'])))); */

function process_thread() {
global $subjectno, $con,$cat1,$cat2,$cat3;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;	
$ex=strtoupper($exm);
       

            If ($Stream =="all") {
                
                        $q1 = "SELECT  adm,Form,Stream from sudtls";
			}
			


             else{
              
                
                        $q1 = "SSELECT  adm,Form,Stream from sudtls stream='$Stream'";
			}
			

            
			
		?>
		
<div class="card"  >
                         <div class="card-header"><center>
						<h3 class="card-title ">BROAD SHEET FOR  <?php echo strtoupper($form." ". $Stream. " ($term - ". $year. ")"); ?></center></h3>
		<div class="card-body ">
		<div class="table-responsive">
                            <table class="table table-bordered datatable" id="table_export" style="font-size:11px; color:;">
                              <thead>
                                <tr>
                              
								  <th scope="col">ADM</th> 
                                  <th scope="col">NAME</th>   
								  <th scope="col">FORM</th>
								  <th scope="col">STREAM</th>
								   
								  <?php
								  $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  ?><th scope="col"><?php echo $sr['subs']; ?></th>
						   <?php
						  
						  }
						  ?>
                              </tr>
                          </thead>
                          <tbody>
						  
						  <?php	
 $qq=mysqli_query($con,$q1);
 $score="";
		while($rs=mysqli_fetch_assoc($qq)){	
						  ?>
						    <tr>
                              
							  <td><?php echo $rs['adm']; ?></td>
                              <td><?php echo $rs['Name']; ?></td>
							  <td><?php echo $rs['Form']; ?></td>
                              <td></td><?php
                              $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			$qsc="SELECT $ex as TotalScore   FROM $f2  WHERE adm='".$rs['adm']."' AND SUBJECT='".$sr['subs']."' AND $f2.term='$term' AND year='$year'";
			$score="";
			$pos="";
			
								  $sc=mysqli_query($con,$qsc);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
						 
		}
		?>
			<td scope="col"><?php echo $score; ?></td><?php
						  }
						  ?>
                          </tr>
                          
                          <?php
						  
						  }
						  ?>
                          
                      </tbody>
                  </table>
                        </div>
						</div></div></div>
						<!-- Footer -->
<footer class="main">
	&copy; 2018 Jotech.com <strong> School Manager</strong>. 
    Developed by Jotech softwares </footer>

		</div>
		


<!-- Chat Histories -->
      	
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
                    <h4 class="modal-title">Jotech SCHOOL MANAGEMENT SYSTEM</h4>
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
    	
    
    
    


						
						<?php
		
			

         
 } 

function main() {
$zero = 0;
global $subjectno, $con,$cat1,$cat2,$cat3;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;


    
 

           
          
                    process_thread();

if (isset($_SESSION['en'])){
$subjectno=0;
$lmt = 0; 
$form=$_SESSION['form'];
$f2=$_SESSION['f2'];
$Stream=$_SESSION['Stream'];
$year=$_SESSION['year'];
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$term=$_SESSION['term'];
$exm=$_SESSION['exm'];
$cat1 = "True";
$cat2 = "False";
$cat3 = "False";
main();
}
else{ echo "No results found";}
}
	?>
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

    <script src="assetss/js/script.js"></script>
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
<?php  }  ?>