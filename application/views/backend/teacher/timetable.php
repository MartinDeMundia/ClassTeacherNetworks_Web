<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Timetable companion</title>
	<link href="<?php echo base_url('assets/timetable/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/timetable/vendor/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
<!-- 	<link href="<?php echo base_url('assets/timetable/css/sb-admin.css');?>" rel="stylesheet"> -->
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="timetable">Generate & Download timetables</a>
        </li>
        <!-- <li class="breadcrumb-item active"> </li> -->
      </ol>
     
      <div class="row">
        <div class="col-12">
           <?php include 'main.php'; ?>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <!--  <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Core ICT Consultancy 2019</small>
        </div>
      </div>
    </footer> -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">--- </h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
         
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Back</button>
            <a class="btn btn-primary" href="index.php?signOut=1">Logout</a>
          </div>
        </div>
      </div>
    </div>

	<script src="<?php echo base_url('assets/timetable/vendor/jquery/jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/timetable/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
	<script src="<?php echo base_url('assets/timetable/vendor/jquery-easing/jquery.easing.min.js');?>"></script>
	<script src="<?php echo base_url('assets/timetable/js/sb-admin.min.js');?>"></script>
  </div>
</body>

</html>
