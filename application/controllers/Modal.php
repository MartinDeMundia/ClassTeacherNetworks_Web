<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  @author   : Creativeitem
 *  date    : 14 september, 2017
 *  Ekattor School Management System Pro
 *  http://codecanyon.net/user/Creativeitem
 *  http://support.creativeitem.com
 */
class Modal extends CI_Controller {


	function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{

	}


	/*
	*	$page_name		=	The name of page
	*/
	function popup($page_name = '' , $param2 = '' , $param3 = '' , $param4 = '' , $param5 = '')
	{
		$account_type		=	$this->session->userdata('login_type');
		$page_data['param2']		=	$param2;
		$page_data['param3']		=	$param3;
		$page_data['param4']		=	$param4;
		$page_data['param5']		=	$param5;
		$this->load->view( 'backend/'.$account_type.'/'.$page_name.'.php' ,$page_data);
		if ($page_name != "create_group" && $page_name != "edit_group" && $page_name != "group_info") {
			echo '<script src="'. base_url(). 'assets/js/neon-custom-ajax.js"></script>';
		}
	}


	function popupexam($page_name = '' , $stream = '' , $term = '' , $subject = '' , $exam = ''){
		$account_type		=	$this->session->userdata('login_type');
		$page_data['stream']		=	$stream;
		$page_data['term']		=	$term;
		$page_data['subject']		=	$subject;
		$page_data['exam']		=	$exam;
		$this->load->view( 'backend/'.$account_type.'/'.$page_name.'.php' ,$page_data);
		
	}

	function popupcustom($page_name = '' , $parameter1 = '' , $parameter2 = '' , $parameter3 = '' , $parameter4 = '',$parameter5 = ''){
		$account_type		=	$this->session->userdata('login_type');
		$page_data['parameter1']		=	$parameter1;
		$page_data['parameter2']		=	$parameter2;
		$page_data['parameter3']		=	$parameter3;
		$page_data['parameter4']		=	$parameter4;
		$page_data['parameter5']		=	$parameter5;
		$this->load->view( 'backend/'.$account_type.'/'.$page_name.'.php' ,$page_data);
		
	}

}
