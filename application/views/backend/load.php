
<?php


    error_reporting(E_ALL);
   ini_set('display_errors', 1);
	 $account_type       =	$this->session->userdata('login_type');
		 include $account_type.'/'.$page_name.'.php';
		 
		 ?>
	