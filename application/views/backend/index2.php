<?php
     //  error_reporting(E_ALL);
  ////ini_set('display_errors', 1);
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	//$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	$text_align         =	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;
	$account_type       =	$this->session->userdata('login_type');
	$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
	$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
	$running_year 		=   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
	?>
<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left') echo 'rtl';?>">
<head>




	<?php include 'includes_top.php';?>

</head>
<body class="page-body <?php if ($skin_colour != '') echo 'skin-' . $skin_colour;?>" >
	<div class="page-container <?php if ($text_align == 'right-to-left') echo 'right-sidebar';?>">
		
		<div class="main-content">

		

          

			<?php include 'principal/'.$page_name.'.php';?>

			
    <?php include 'includes_bottom.php';?>

</body>
</html>
