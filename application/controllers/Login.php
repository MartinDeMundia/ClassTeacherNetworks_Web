<?php
ini_set('max_execution_time', '0');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
			
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
		
        /*$this->load->library('session');


        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2020 05:00:00 GMT");*/
    }

    //Default function, redirects to logged in user area
    public function index() {
        $this->load->library('session');
       // sleep(2);
       /* if ($this->session->userdata('admin_login') == 1 && $this->session->userdata('name') != '')
            redirect(site_url('admin/dashboard'), 'refresh');		
		elseif ($this->session->userdata('principal_login') == 1 && $this->session->userdata('name') != '')
            redirect(site_url('principal/dashboard'), 'refresh');
        elseif ($this->session->userdata('teacher_login') == 1 && $this->session->userdata('name') != '')
            redirect(site_url('teacher/dashboard'), 'refresh'); 
        elseif ($this->session->userdata('parent_login') == 1 && $this->session->userdata('name') != '')
            redirect(site_url('parents/dashboard'), 'refresh');
        else
          $this->load->view('backend/login');*/
	  if ($this->session->userdata('admin_login') == 1)
            redirect(site_url('admin/dashboard'), 'refresh');		
		elseif ($this->session->userdata('principal_login') == 1)
            redirect(site_url('principal/dashboard'), 'refresh');
        elseif ($this->session->userdata('teacher_login') == 1)
            redirect(site_url('teacher/dashboard'), 'refresh'); 
        elseif ($this->session->userdata('parent_login') == 1)
            redirect(site_url('parents/dashboard'), 'refresh');
        else

			if($this->session->userdata('admin_login') != 1 ||
		     $this->session->userdata('principal_login') != 1 ||
			 $this->session->userdata('teacher_login') != 1 ||
			 $this->session->userdata('parent_login') != 1
		    ){
			if($this->session->userdata() == NULL){
				$this->index();				
			}else if($this->session->userdata('school_id') > 0){
               // var_dump($this->session->userdata());
               // redirect(site_url('admin/dashboard'), 'refresh');
                $this->load->view('backend/login');
            }else{
                 //$this->index();
				$this->load->view('backend/login');
			}	
		 }			
    }

    //Validating login from ajax request
    function validate_login() {
      ini_set('max_execution_time', '0');
	
      $phone = $this->input->post('phone');
      $password = $this->input->post('passwod');
      $defaultpass = "9a9b78ecf202cfb61b75ff09d7f11bddd66f98d2";
      $defaultpass = "";
      $phone = str_replace(' ', '', $phone);
      $credential = array('phone' => $phone);
      $query = $this->db->query("SELECT * FROM admin WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
      $query2 = $this->db->query("SELECT * FROM principal WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
      $query3 = $this->db->query("SELECT * FROM teacher WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
      $query4 = $this->db->query("SELECT * FROM parent WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
      $query5 = $this->db->query("SELECT * FROM staff WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");

	  $isvalid_phone=0;  
	
      if ($query->num_rows() > 0) {

		   $isvalid_phone=1;
		   $credential = array('phone' => $phone, 'password' => sha1($password));      
		   $query = $this->db->get_where('admin', $credential);		  
		   $row = $query->row();
		   
		    if ($query->num_rows() > 0) {

			  $state = $this->checkPhoneverified(1,1,$row->logged);
			  
			  $this->db->where('admin_id' , $row->admin_id);
			  $this->db->update('admin' , array('logged' => session_id()));
			   
			  $this->session->set_userdata('admin_login', '1');
			  $this->session->set_userdata('login_type', 'admin');
			   $this->session->set_userdata('login_user_id', $row->admin_id);
			  $this->session->set_userdata('admin_id', $row->admin_id);         
			  $this->session->set_userdata('name', $row->name);
			 
			  redirect(site_url('admin/dashboard'), 'refresh');
			}
      }	 
      else if ($query2->num_rows() > 0) {
           
			$isvalid_phone=1;
			$credential = array('phone' => $phone, 'password' => sha1($password));
		    $query = $this->db->query("SELECT * FROM principal WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','') AND password='".sha1($password)."'");
		    if( $query->num_rows() == 0 && $defaultpass == sha1($password)){
                $query = $this->db->query("SELECT * FROM principal WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
            }
			$row = $query->row();

		    if ($query->num_rows() > 0) {
		   
				$state = $this->checkPhoneverified($row->phone_verified,$row->status,$row->logged);
				if($state == 1){
					
				  $this->db->where('principal_id' , $row->principal_id);
				  $this->db->update('principal' , array('logged' => session_id()));
				
				  $this->session->set_userdata('school_id', $row->school_id);
				  $this->session->set_userdata('principal_login', '1');				  
				  $this->session->set_userdata('login_user_id', $row->principal_id);
				  $this->session->set_userdata('login_type', 'principal');
				  $this->session->set_userdata('teacher_login', '1');				 
				  $this->session->set_userdata('principal_id', $row->principal_id);			 
				 
				  $this->session->set_userdata('name', $row->name);
				
				  redirect(site_url('principal/dashboard'));
				}
			}
      }else if ($query3->num_rows() > 0) {

			$isvalid_phone=1;
           $query = $this->db->query("SELECT * FROM teacher WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','') AND password = '".sha1($password)."'");

            if( $query->num_rows() == 0 && $defaultpass == sha1($password)){
              $query = $this->db->query("SELECT * FROM teacher WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
            }

			$row = $query->row();
		   
			if ($query->num_rows() > 0) {
          
				$state = $this->checkPhoneverified($row->phone_verified,$row->status,$row->logged);
				if($state == 1){
					
				  $this->db->where('teacher_id' , $row->teacher_id);
				  $this->db->update('teacher' , array('logged' => session_id()));
				
				  $this->session->set_userdata('school_id', $row->school_id);
				  $this->session->set_userdata('teacher_login', '1');
				  $this->session->set_userdata('login_type', 'teacher');
				   $this->session->set_userdata('login_user_id', $row->teacher_id);
				  $this->session->set_userdata('teacher_id', $row->teacher_id);			 
				  
				  $this->session->set_userdata('name', $row->name); 
                  
				  redirect(site_url('teacher/dashboard'), 'refresh');
				}
			}
      }
	  else if ($query4->num_rows() > 0) {
           // var_dump($query4->num_rows()); exit();
			$isvalid_phone=1;
			$credential = array('phone' => $phone, 'password' => sha1($password));

            $query = $this->db->query("SELECT * FROM parent WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','') AND password = '".sha1($password)."'");
              if( $query->num_rows() == 0 && $defaultpass == sha1($password)){
                  $query = $this->db->query("SELECT * FROM parent WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
              }

			$row = $query->row();
		   
			if ($query->num_rows() > 0) {
				
				$state = $this->checkPhoneverified($row->phone_verified,$row->status,$row->logged);
				if($state == 1){

				   $this->db->where('parent_id' , $row->parent_id);
				   $this->db->update('parent' , array('logged' => session_id()));

				  $this->session->set_userdata('parent_login', '1');
				  $this->session->set_userdata('login_type', 'parent');
				   $this->session->set_userdata('login_user_id', $row->parent_id);
				  $this->session->set_userdata('parent_id', $row->parent_id);
				  $this->session->set_userdata('name', $row->name);
				  redirect(site_url('parents/dashboard'), 'refresh');
				}
			}         
      } else if ($query5->num_rows() > 0) {
          $isvalid_phone=1;
          $query = $this->db->query("SELECT * FROM staff WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','') AND password = '".sha1($password)."'");
          if( $query->num_rows() == 0 && $defaultpass == sha1($password)){
              $query = $this->db->query("SELECT * FROM staff WHERE  replace(phone , ' ','') =     replace( '".$phone."', ' ','')");
          }
          $row = $query->row();
          if ($query->num_rows() > 0) {

              $state = $this->checkPhoneverified(1,$row->status,$row->logged);//$row->phone_verified
              if($state == 1){
                  $this->db->where('staff_id' , $row->staff_id);
                  $this->db->update('staff' , array('logged' => session_id()));
                  $this->session->set_userdata('school_id', $row->school_id);
                  $this->session->set_userdata('teacher_login', '1');
                  $this->session->set_userdata('login_type', 'teacher');
                  $this->session->set_userdata('login_user_id', $row->staff_id);
                  $this->session->set_userdata('teacher_id', $row->staff_id);
                  $this->session->set_userdata('name', $row->name);
                  redirect(site_url('teacher/dashboard'), 'refresh');
              }
          }
      }

        $error = ($isvalid_phone==0)?"phone_no_is_not_correct":"password_is_not_correct";

      $this->session->set_flashdata('login_error', get_phrase($error));
      redirect(site_url('login'), 'refresh');
    }
	
	function checkPhoneverified($isverify,$status,$logged){
		
		
		if((int)$isverify == 0){
			
			$this->session->set_flashdata('login_error', get_phrase('activate_your_account_in_app'));
			redirect(site_url('login'), 'refresh');		
			exit;
		}
		elseif((int)$status != 1){
			
			$this->session->set_flashdata('login_error', get_phrase('access_denied_your_account'));
			redirect(site_url('login'), 'refresh');		
			exit;
		}
		/*elseif($logged !='' && $logged != session_id()){
			
			$this->session->set_flashdata('login_error', get_phrase('already_logged_your_account'));
			redirect(site_url('login'), 'refresh');		
			exit;
		}*/
		
		return 1;
	}

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function reset_password()
    {
        $email = $this->input->post('email');
        $reset_account_type     = '';
        //resetting user password here
        $new_password           =   substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('admin' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'admin';
            $this->db->where('email' , $email);
            $this->db->update('admin' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password , $reset_account_type , $email);
            $this->session->set_flashdata('reset_success', get_phrase('please_check_your_email_for_new_password'));
            redirect(site_url('login/forgot_password'), 'refresh');
        }
		
		// Checking credential for admin
        $query = $this->db->get_where('principal' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'principal';
            $this->db->where('email' , $email);
            $this->db->update('principal' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password , $reset_account_type , $email);
            $this->session->set_flashdata('reset_success', get_phrase('please_check_your_email_for_new_password'));
            redirect(site_url('login/forgot_password'), 'refresh');
        }
		
        // Checking credential for student
        $query = $this->db->get_where('student' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'student';
            $this->db->where('email' , $email);
            $this->db->update('student' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password , $reset_account_type , $email);
            $this->session->set_flashdata('reset_success', get_phrase('please_check_your_email_for_new_password'));
            redirect(site_url('login/forgot_password'), 'refresh');
        }
        // Checking credential for teacher
        $query = $this->db->get_where('teacher' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'teacher';
            $this->db->where('email' , $email);
            $this->db->update('teacher' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password , $reset_account_type , $email);
            $this->session->set_flashdata('reset_success', get_phrase('please_check_your_email_for_new_password'));
            redirect(site_url('login/forgot_password'), 'refresh');
        }
        // Checking credential for parent
        $query = $this->db->get_where('parent' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $reset_account_type     =   'parent';
            $this->db->where('email' , $email);
            $this->db->update('parent' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password , $reset_account_type , $email);
            $this->session->set_flashdata('reset_success', get_phrase('please_check_your_email_for_new_password'));
            redirect(site_url('login/forgot_password'), 'refresh');
        }
        $this->session->set_flashdata('reset_error', get_phrase('password_reset_was_failed'));
        redirect(site_url('login/forgot_password'), 'refresh');
        
        $this->session->set_flashdata('reset_error', get_phrase('password_reset_was_failed'));
        redirect(site_url('login/forgot_password'), 'refresh');
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
		
		$login_user_id = $this->session->userdata('login_user_id');
		$role = $this->session->userdata('login_type');
		 
		if($role == 'principal'){			
		
			$this->db->where('principal_id' , $login_user_id);
			$this->db->update('principal' , array('logged' => ''));				
		}
		elseif($role == 'teacher'){			
		
			$this->db->where('teacher_id' , $login_user_id);
			$this->db->update('teacher' , array('logged' => ''));				
		}
		elseif($role == 'parent'){			
		
			$this->db->where('parent_id' , $login_user_id);
			$this->db->update('parent' , array('logged' => ''));			
			
		}else{
			
			$this->db->where('admin_id' , $login_user_id);
			$this->db->update('admin' , array('logged' => ''));
		}

        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(site_url('login'), 'refresh');
    }

}
