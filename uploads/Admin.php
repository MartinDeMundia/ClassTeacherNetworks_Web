<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		 $this->load->library('Pdftc');
        $this->load->library('session');
        $this->load->model('Barcode_model');

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		//if ($this->session->userdata('admin_login') != 1) $this->clearsess();		
    }
	
	function clearsess(){
		
		$login_user_id = $this->session->userdata('login_user_id');
		
		$this->db->where('admin_id' , $login_user_id);
		$this->db->update('admin' , array('logged' => ''));	
		$this->session->sess_destroy();		
	}

    /***default functin, redirects to login page if no admin logged in yet***/
   /* public function index()
    {
        $login_user_id = $this->session->userdata('login_user_id');
		
        if ($this->session->userdata('admin_login') != 1){
			$this->clearsess();	 
			redirect(site_url('login'), 'refresh');
		}
        else{
            redirect(site_url('admin/dashboard'), 'refresh');
		}
    }*/
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
		$this->session->set_userdata('login_type', 'admin');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
	
	
	
	function parent_add($student_id)
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['student_id']  = $student_id;
		$page_data['page_name']  = 'modal_parent_add';
		$page_data['page_title'] = get_phrase('parent_details');
		$this->load->view('backend/index', $page_data);
	}
	
	function parent_extra_add($student_id)
	{
		//echo 131;
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['student_id']  = $student_id;
		$page_data['page_name']  = 'modal_parent_extra_add';
		$page_data['page_title'] = get_phrase('parent_details');
		$this->load->view('backend/index', $page_data);
	}

    /****MANAGE STUDENTS CLASSWISE*****/
	function student_add()
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['page_name']  = 'student_add';
		$page_data['page_title'] = get_phrase('add_student');
		$this->load->view('backend/index', $page_data);
	}

	function student_bulk_add()
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$page_data['page_name']  = 'student_bulk_add';
		$page_data['page_title'] = get_phrase('add_bulk_student');
		$this->load->view('backend/index', $page_data);
	}

  function student_profile($student_id)
  {
    if ($this->session->userdata('principal_login') != 1) {
      redirect(site_url('login'), 'refresh');
    }
    $page_data['page_name']  = 'student_profile';
		$page_data['page_title'] = get_phrase('student_profile');
    $page_data['student_id']  = $student_id;
		$this->load->view('backend/index', $page_data);
  }
  
    function health_occurence($student_id)
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['student_id']  = $student_id;
		$page_data['page_name']  = 'health_occurence';
		$page_data['page_title'] = get_phrase('health_occurence');
		$this->load->view('backend/index', $page_data);
	}
	
	function health_occurence_create($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        
            $data['user_id']       = $this->session->userdata('login_user_id');
            $data['role_id']       = 3;
            $data['title']       =   $this->input->post('occurence');
            $data['action']   =   $this->input->post('action1');		
			$data['further_action']   =   $this->input->post('action2');
			$data['concern_date']   =  date('Y-m-d' , strtotime($this->input->post('date')));
			$data['student_id']       =  $student_id =  $this->input->post('student_id');
			
			$class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
			 
			$this->db->insert('health_last_occurence' , $data);
			$this->session->set_flashdata('flash_message' , get_phrase('health_occurence_added_successfully'));
		 
			redirect(site_url('admin/student_health/' . $class_id), 'refresh');
    }


    function get_sections($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/student_bulk_add_sections' , $page_data);
    }

	function student_information($class_id = '')
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['page_name']  	= 'student_information';
		$page_data['page_title'] 	= get_phrase('student_information'). " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;

		$this->load->view('backend/index', $page_data);
	}
	
	function academic_transcript($class_id = '', $report='')
	{
	if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		if($report ==5)  $report_title='academic_transcript';

		$page_data['page_name'] = 'academic_pdf_transcript';
		$page_data['page_title'] = 'Academic Transcript'. " - ".get_phrase('stream')." : ".
		$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$page_data['report'] 	= $report;
		$this->load->view('backend/index', $page_data);
	}
	
	
	function student_report($class_id = '', $report='',$offset=0)
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		if($report ==1) $report_title='health_report';
		elseif($report ==2) $report_title='behaviour_report';
		elseif($report ==3) $report_title='fees_report';
		elseif($report ==4) $report_title='attendance_report';
		elseif($report ==5) $report_title='student_report_forms';
		$page_data['offset']=$offset;
		$page_data['page_name'] = 'student_report';
		$page_data['page_title'] = get_phrase($report_title). " - ".get_phrase('stream')." : ".
		$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$page_data['report'] 	= $report;
		$this->load->view('backend/index', $page_data);
	}
	
	function student_health($class_id = '')
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['page_name'] = 'student_health';
		$page_data['page_title'] = get_phrase('student_health_occurence'). " - ".get_phrase('stream')." : ".
		$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
	
	function student_class_list($class_id = '')
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['page_name'] = 'student_class_list';
		$page_data['page_title'] = get_phrase('student_stream_list'). " - ".get_phrase('stream')." : ".
		$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
	

    function student_marksheet($student_id = '') {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $student_name = $this->db->get_where('student' , array('student_id' => $student_id))->row()->name;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
        $page_data['page_name']  =   'student_marksheet';
        $page_data['page_title'] =   get_phrase('marksheet_for') . ' ' . $student_name . ' (' . get_phrase('class') . ' ' . $class_name . ')';
        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id , $exam_id) {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/admin/student_marksheet_print_view', $page_data);
    }

    function student($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;

        if ($param1 == 'create') {
			$data['school_id'] = $this->input->post('school_id');
            $data['name'] = $this->input->post('name');
            if($this->input->post('birthday') != null){
              $data['birthday']     = $this->input->post('birthday');
            }
            if($this->input->post('sex') != null){
              $data['sex']          = $this->input->post('sex');
            }
            if($this->input->post('address') != null){
              $data['address']      = $this->input->post('address');
            }
            if($this->input->post('phone') != null){
              $data['phone']        = $this->input->post('phone');
            }
            if($this->input->post('student_code') != null){
                $data['student_code'] = $this->input->post('student_code');
                /*$code_validation = code_validation_insert($data['student_code']);
                if(!$code_validation) {
                    $this->session->set_flashdata('error_message' , get_phrase('this_id_no_is_not_available'));
                    redirect(site_url('admin/student_add'), 'refresh');
                }*/
            }

            $data['email']        = $this->input->post('email'); 
			
            if($this->input->post('parent_id') != null){
                $data['parent_id']    = $this->input->post('parent_id');
            }
            
            if($this->input->post('emarks') != null){
                $data['emarks']    = $this->input->post('emarks');
            }
			
			if($this->input->post('house_no') != null){
                $data['house_no']    = $this->input->post('house_no');
            }
			
			if($this->input->post('religion') != null){
                $data['religion']    = $this->input->post('religion');
            }
            
            
			if($this->input->post('date_of_admission') != null){
                $data['date_of_admission']    = $this->input->post('date_of_admission');
            }
			
			$validation = 1;
             
			if($this->input->post('email') != ''){
				$validation = email_validation($data['email']);
			}
			$data['form']       = $this->input->post('class_id');
			$data['stream']       = $this->input->post('section_id');
            if($validation == 1) {
                $this->db->insert('student', $data);
                $student_id = $this->db->insert_id();

                $data2['student_id']     = $student_id;
                $data2['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
                if($this->input->post('class_id') != null){
                  $data2['class_id']       = $this->input->post('class_id');
                }
                if ($this->input->post('section_id') != '') {
                    $data2['section_id'] = $this->input->post('section_id');
                }
                if ($this->input->post('roll') != '') {
                    $data2['roll']           = $this->input->post('roll');
                }
                $data2['date_added']     = strtotime(date("Y-m-d H:i:s"));
                $data2['year']           = $running_year;
                $this->db->insert('enroll', $data2);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');

                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                //$this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
				
				redirect(site_url('admin/parent_add/'.$student_id), 'refresh');
            }
            else {
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('admin/student_add'), 'refresh');
        }
        if ($param1 == 'do_update') {
			
            $data['name']           = $this->input->post('name');
            $data['email']          = $this->input->post('email');
            //$data['parent_id']      = $this->input->post('parent_id');
            if ($this->input->post('birthday') != null) {
                $data['birthday']   = $this->input->post('birthday');
            }
            if ($this->input->post('sex') != null) {
                $data['sex']            = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
               $data['address']        = $this->input->post('address');
            }
            if ($this->input->post('phone') != null) {
                $data['phone']          = $this->input->post('phone');
            }           

if($this->input->post('emarks') != null){
                $data['emarks']    = $this->input->post('emarks');
            }
			
			if($this->input->post('house_no') != null){
                $data['house_no']    = $this->input->post('house_no');
            }
			
			if($this->input->post('religion') != null){
                $data['religion']    = $this->input->post('religion');
            }
			
			if($this->input->post('date_of_admission') != null){
                $data['date_of_admission']    = $this->input->post('date_of_admission');
            }			

            //student id
            if($this->input->post('student_code') != null){
                $data['student_code'] = $this->input->post('student_code');
                /*$code_validation = code_validation_update($data['student_code'],$param2);
                if(!$code_validation){
                    $this->session->set_flashdata('error_message' , get_phrase('this_id_no_is_not_available'));
                    redirect(site_url('admin/student_information/' . $param3), 'refresh');
                }*/
            }
			
			$validation =1;
			if($this->input->post('email') != ''){

				$validation = email_validation_for_edit($data['email'], $param2, 'student');
			}
			
			
            if($validation == 1){
                $this->db->where('student_id', $param2);
                $this->db->update('student', $data);

                $data2['section_id'] = $this->input->post('section_id');
                if ($this->input->post('roll') != null) {
                  $data2['roll'] = $this->input->post('roll');
                }
                else{
                  $data2['roll'] = null;
                }
                $running_year = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
                $this->db->where('student_id' , $param2);
                $this->db->where('year' , $running_year);
                $this->db->update('enroll' , array(
                    'section_id' => $data2['section_id'] , 'roll' => $data2['roll']
                ));

                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param2 . '.jpg');
                $this->crud_model->clear_cache();
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
           }
           else{
             $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
           }
            redirect(site_url('admin/student_information/' . $param3), 'refresh');
        }
    }

    function delete_student($student_id = '', $class_id = '') {
      $this->crud_model->delete_student($student_id);
      $this->session->set_flashdata('flash_message' , get_phrase('student_deleted'));
      redirect(site_url('admin/student_information/' . $class_id), 'refresh');
    }

    // STUDENT PROMOTION
    function student_promotion($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if($param1 == 'promote') {
            $running_year  =   $this->input->post('running_year');
            $from_class_id =   $this->input->post('promotion_from_class_id');
            $students_of_promotion_class =   $this->db->get_where('enroll' , array(
                'class_id' => $from_class_id , 'year' => $running_year
            ))->result_array();
            foreach($students_of_promotion_class as $row) {
                $enroll_data['enroll_code']     =   substr(md5(rand(0, 1000000)), 0, 7);
                $enroll_data['student_id']      =   $row['student_id'];
                $enroll_data['class_id']        =   $this->input->post('promotion_status_'.$row['student_id']);
                $enroll_data['year']            =   $this->input->post('promotion_year');
                $enroll_data['date_added']      =   strtotime(date("Y-m-d H:i:s"));
                $this->db->insert('enroll' , $enroll_data);
            }
            $this->session->set_flashdata('flash_message' , get_phrase('new_enrollment_successfull'));
            redirect(site_url('admin/student_promotion'), 'refresh');
        }

        $page_data['page_title']    = get_phrase('student_promotion');
        $page_data['page_name']  = 'student_promotion';
        $this->load->view('backend/index', $page_data);
    }

    function get_students_to_promote($class_id_from , $class_id_to , $running_year , $promotion_year)
    {
        $page_data['class_id_from']     =   $class_id_from;
        $page_data['class_id_to']       =   $class_id_to;
        $page_data['running_year']      =   $running_year;
        $page_data['promotion_year']    =   $promotion_year;
        $this->load->view('backend/admin/student_promotion_selector' , $page_data);
    }

	
     /****MANAGE PARENTS CLASSWISE*****/
    function parent($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']        			= $this->input->post('name');
            $data['email']       			= $this->input->post('email');
            $data['password']    			= sha1($this->input->post('password'));
			$data['status']     = $this->input->post('status');
			$student_id   = $this->input->post('student_id');
            if ($this->input->post('phone') != null) {
               $data['phone'] = $this->input->post('phone');
            }
            if ($this->input->post('address') != null) {
               $data['address'] = $this->input->post('address');
            }
            if ($this->input->post('profession') != null) {
               $data['profession'] = $this->input->post('profession');
            }
            $validation = email_validation($data['email']);
			$validation2 = phone_validation($data['phone']);
            if((int)$validation == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
			}
			elseif((int)$validation2 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
				redirect(site_url('admin/parent_add/'.$student_id), 'refresh');
			}
			else{
                $this->db->insert('parent', $data);
				$parent_id = $this->db->insert_id();
				
				$pdata['parent_id'] = $parent_id;
				$this->db->where('student_id' , $student_id);
                $this->db->update('student' , $pdata);
		
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('parent', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }            

            redirect(site_url('admin/student_add'), 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']                   = $this->input->post('name');
            $data['email']                  = $this->input->post('email');
			$data['status']     = $this->input->post('status');
            if ($this->input->post('phone') != null) {
               $data['phone'] = $this->input->post('phone');
            }
            else{
              $data['phone'] = null;
            }
            if ($this->input->post('address') != null) {
                $data['address'] = $this->input->post('address');
            }
            else{
               $data['address'] = null;
            }
            if ($this->input->post('profession') != null) {
                $data['profession'] = $this->input->post('profession');
            }
            else{
                $data['profession'] = null;
            }
            $validation = email_validation_for_edit($data['email'], $param2, 'parent');
            $validation2 = phone_validation_for_edit($data['phone'], $param2, 'parent');
			
           if((int)$validation == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
			}
			elseif((int)$validation2 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
			}
			else{
				
				$phone = $this->db->get_where('parent', array('parent_id' => $param2))->row()->phone;		
				if($phone != $data['phone']) $data['phone_verified'] = '0';
				
                $this->db->where('parent_id' , $param2);
                $this->db->update('parent' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            
            redirect(site_url('admin/parent'), 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('parent_id' , $param2);
            $this->db->delete('parent');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/parent'), 'refresh');
        }
        $page_data['page_title'] 	= get_phrase('all_parents');
        $page_data['page_name']  = 'parent';
        $this->load->view('backend/index', $page_data);
    }
	
	
	/****MANAGE SCHOOLS*****/
    function school($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['school_name'] = $this->input->post('name');
            $data['license_code'] = $this->input->post('license_code');
			$data['amount'] = $this->input->post('amount');
			$data['paid_by']  = $this->input->post('paid_by');
			$data['payment_method']     = $this->input->post('payment_method');
			$data['school_type']     = $this->input->post('school_type');
			$data['primary_school_type']     = $this->input->post('primary_school_type');
			$data['county']     = $this->input->post('county');
			$data['status']     = $this->input->post('status');
			
            if ($this->input->post('activation_date') != null) {
                $activation_date = $this->input->post('activation_date');
			    $data['activation_date'] = date('Y/m/d',strtotime($activation_date));
				$data['expiry_date'] = date('Y/m/d', strtotime("+1 years", strtotime($activation_date)));
			}        
			if ($this->input->post('payment_date') != null) {
                $payment_date = $this->input->post(payment_date);
			    $data['payment_date'] = date('Y/m/d',strtotime($payment_date));
            } 
			$this->db->insert('school', $data);
			$school_id = $this->db->insert_id();
			if($_FILES['file']['name'] !='') move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/school_image/' . $school_id . '.jpg');
			
			$this->session->set_flashdata('flash_message' , get_phrase('school_data_added'));
            redirect(site_url('admin/school'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['school_name']        = $this->input->post('name'); 
			$data['license_code'] = $this->input->post('license_code');
			$data['amount'] = $this->input->post('amount');
			$data['paid_by']  = $this->input->post('paid_by');
			$data['payment_method']     = $this->input->post('payment_method');
			$data['school_type']     = $this->input->post('school_type');
			$data['primary_school_type']     = $this->input->post('primary_school_type');
			$data['county']     = $this->input->post('county');
			$data['status']     = $this->input->post('status');

            if ($this->input->post('activation_date') != null) {
               $activation_date = $this->input->post('activation_date');
			    $data['activation_date'] = date('Y/m/d',strtotime($activation_date));
				$data['expiry_date'] = date('Y/m/d', strtotime("+1 years", strtotime($activation_date)));
            }
            else{
              $data['activation_date'] = null;
			  $data['expiry_date'] = null;
            }            
			
			if ($this->input->post('payment_date') != null) {
                $payment_date = $this->input->post(payment_date);
			    $data['payment_date'] = date('Y/m/d',strtotime($payment_date));
            } 

			$this->db->where('school_id', $param2);
            $this->db->update('school', $data);
			
			$active['status'] = $data['status'];
			$this->db->where('school_id', $param2);
            $this->db->update('principal', $active);
			
			$this->db->where('school_id', $param2);
            $this->db->update('teacher', $active);
			
			$parents = $this->db->select("GROUP_CONCAT(parent_id) as parents")->where('school_id', $param2)->group_by("school_id")->get('student')->row()->parents;
						 			
			$this->db->where_in('parent_id', explode(',',$parents))->update('parent', $active);
						 
			if($_FILES['file']['name'] !='') move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/school_image/' . $param2 . '.jpg');
			$this->session->set_flashdata('flash_message' , get_phrase('school_data_updated'));
            redirect(site_url('admin/school'), 'refresh');
        }       
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('school', array(
                'school_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('school_id', $param2);
            $this->db->delete('school');
        
        	$this->db->where('school_id', $param2);
            $this->db->delete('principal');
        
        	$this->db->where('school_id', $param2);
            $this->db->delete('teacher');
			
			$this->db->where('school_id', $param2);
            $this->db->delete('staff');
        
        	$this->db->where('school_id', $param2);
            $this->db->delete('student');
        
        	 $parentsids = $this->db->select("GROUP_CONCAT(parent_id) as parents")->where_in('school_id',$param2)->get('student')->row()->parents;
							
			if($parentsids!=''){
            
            	$othersparentsids = $this->db->select("GROUP_CONCAT(parent_id) as parents")->where_in('parent_id', explode(',',$parentsids))->where_not_in('school_id',$param2)->get('student')->row()->parents;
            
            	$this->db->where_not_in('parent_id', explode(',',$othersparentsids));
				$this->db->where_in('parent_id', explode(',',$parentsids));
           		$this->db->delete('parent');
            }
        
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/school'), 'refresh');
        }
        $page_data['schools']   = $this->db->get('school')->result_array();
        $page_data['page_name']  = 'school';
        $page_data['page_title'] = get_phrase('manage_school');
        $this->load->view('backend/index', $page_data);
    }
	
	
	 /****MANAGE PRINCIPAL*****/
    function principal($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
			$data['school_id']    = $this->input->post('school_id');
            $data['name']     = $this->input->post('name');
            $data['email']    = $this->input->post('email');
            $data['password'] = sha1($this->input->post('password'));
			$data['status']     = $this->input->post('status');
			$data['school_type']     = $this->input->post('school_type');
			$data['primary_school_type']     = $this->input->post('primary_school_type');
			$data['county']     = $this->input->post('county');
            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            if ($this->input->post('sex') != null) {
               $data['sex'] = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address'] = $this->input->post('address');
            }
            if ($this->input->post('phone') != null) {
                $data['phone'] = $this->input->post('phone');
            }                         

            $validation = email_validation($data['email']);
			$validation2 = phone_validation($data['phone']);
            if((int)$validation == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
			}
			elseif((int)$validation2 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
			}
			else{
				
                $this->db->insert('principal', $data);
                $principal_id = $this->db->insert_id();
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/principal_image/' . $principal_id . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('principal', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }           

            redirect(site_url('admin/principal'), 'refresh');
        }
        if ($param1 == 'do_update') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
			$data['school_type']     = $this->input->post('school_type');
			$data['primary_school_type']     = $this->input->post('primary_school_type');
			$data['county']     = $this->input->post('county');
			$data['status']     = $this->input->post('status');
            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            else{
              $data['birthday'] = null;
            }
            if ($this->input->post('sex') != null) {
                $data['sex']         = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address']     = $this->input->post('address');
            }
            else{
              $data['address'] = null;
            }
            if ($this->input->post('phone') != null) {
               $data['phone']       = $this->input->post('phone');
            }
            else{
              $data['phone'] = null;
            }                       

            $validation = email_validation_for_edit($data['email'], $param2, 'principal');
			$validation2 = phone_validation_for_edit($data['phone'], $param2, 'principal');
			
           if((int)$validation == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
			}
			elseif((int)$validation2 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
			}
			else{
				
				$phone = $this->db->get_where('principal', array('principal_id' => $param2))->row()->phone;		
				if($phone != $data['phone']) $data['phone_verified'] = '0';
				
                $this->db->where('principal_id', $param2);
                $this->db->update('principal', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/principal_image/' . $param2 . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }             

            redirect(site_url('admin/principal'), 'refresh');
        }
        else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_principal_id'] = $param2;
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('principal', array(
                'principal_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('principal_id', $param2);
            $this->db->delete('principal');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/principal'), 'refresh');
        }
        $page_data['principals']   = $this->db->get('principal')->result_array();
        $page_data['page_name']  = 'principal';
        $page_data['page_title'] = get_phrase('manage_principal');
        $this->load->view('backend/index', $page_data);
    }


    /****MANAGE TEACHERS*****/
    function teacher($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']     = $this->input->post('name');
			$data['tsc_number']     = $this->input->post('tsc_number');
            $data['email']    = $this->input->post('email');
            $data['password'] = sha1($this->input->post('password'));
			$data['status']     = $this->input->post('status');
            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            if ($this->input->post('sex') != null) {
               $data['sex'] = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address'] = $this->input->post('address');
            }
            if ($this->input->post('phone') != null) {
                $data['phone'] = $this->input->post('phone');
            }            
             
            $validation = email_validation($data['email']);
			$validation2 = phone_validation($data['phone']);
			$validation3 = tsc_validation($data['tsc_number']);
            if((int)$validation == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
			}
			elseif((int)$validation2 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
			}
			elseif((int)$validation3 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('tsc_number_is_already_assigned_to_teacher'));
			}
			else{
                $this->db->insert('teacher', $data);
                $teacher_id = $this->db->insert_id();
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }             

            redirect(site_url('admin/teacher'), 'refresh');
        }
        if ($param1 == 'do_update') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']        = $this->input->post('name');
			$data['tsc_number']        = $this->input->post('tsc_number');
            $data['email']       = $this->input->post('email');
			$data['status']     = $this->input->post('status');
            if ($this->input->post('birthday') != null) {
                $data['birthday'] = $this->input->post('birthday');
            }
            else{
              $data['birthday'] = null;
            }
            if ($this->input->post('sex') != null) {
                $data['sex']         = $this->input->post('sex');
            }
            if ($this->input->post('address') != null) {
                $data['address']     = $this->input->post('address');
            }
            else{
              $data['address'] = null;
            }
            if ($this->input->post('phone') != null) {
               $data['phone']       = $this->input->post('phone');
            }
            else{
              $data['phone'] = null;
            }           
            
            $validation = email_validation_for_edit($data['email'], $param2, 'teacher');
            $validation2 = phone_validation_for_edit($data['phone'], $param2, 'teacher');
			$validation3 = tsc_validation_for_edit($data['tsc_number'], $param2, 'teacher');
			
           if((int)$validation == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
			}
			elseif((int)$validation2 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
			}
			elseif((int)$validation3 == 0){
				$this->session->set_flashdata('error_message' , get_phrase('this_tsc_number_is_already_assigned_to_teacher'));
			}
			else{
				
				$phone = $this->db->get_where('teacher', array('teacher_id' => $param2))->row()->phone;		
				if($phone != $data['phone']) $data['phone_verified'] = '0';
				
                $this->db->where('teacher_id', $param2);
                $this->db->update('teacher', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $param2 . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            

            redirect(site_url('admin/teacher'), 'refresh');
        }
        else if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('teacher', array(
                'teacher_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('teacher_id', $param2);
            $this->db->delete('teacher');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/teacher'), 'refresh');
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('manage_teacher');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
			
			$data['class_subject'] = $class_subject =  $this->input->post('name');			
			$subject_name = $this->db->get_where('class_subjects' , array('id' => $data['class_subject']))->row()->subject;	 
			$data['name'] = $subject_name;					
            $data['class_id']   = $class_id = $this->input->post('class_id');
			$data['section_id']   = $section_id = $this->input->post('section_id');
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('teacher_id') != null) {
                $teacher_id  = $this->input->post('teacher_id');
				$teacher = explode('-',$teacher_id);
				if($teacher[0] == 't') $data['teacher_id'] = $teacher[1];
				elseif($teacher[0] == 'p') $data['principal_id'] = $teacher[1];		
            }
			
			
			$cnt = $this->db->get_where('subject' , array('class_subject' => $class_subject,'class_id' => $class_id,'section_id' => $section_id,'teacher_id' => $teacher_id))->num_rows();		
			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('already_assigned_subject_teacher_for_selected_class_stream'));
				redirect(site_url('admin/subject/' . $data['class_id']), 'refresh');
				die;
			}

            $this->db->insert('subject', $data);
			$subject_id = $this->db->insert_id();
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
			
			$noti_arr['title'] = 'Teacher Change/Add to subject';
			$noti_arr['content'] = 'Teacher Change/Add to subject';
			$noti_arr['type'] = '1';
			$noti_arr['type_id'] = $subject_id;
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			$students = $this->db->get_where('enroll', array('class_id' => $data['class_id'],'section_id' => $data['section_id']))->result_array();
            foreach ($students as $row)
            {				
				$noti_arr['student_id'] = $student_id = $row['student_id'];
				$this->db->insert('notifications', $noti_arr);	 		
				
				$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
					
				$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'Teacher Change/Add to subject');
			}		
			
            redirect(site_url('admin/subject/' . $data['class_id']), 'refresh');
        }
				 
        if ($param1 == 'do_update') {
			
			$data['class_subject'] = $this->input->post('name');			
			$subject_name = $this->db->get_where('class_subjects' , array('id' => $data['class_subject']))->row()->subject;			 
			$data['name'] = $subject_name;			
            $data['class_id']   = $this->input->post('class_id');
			$data['section_id']   = $this->input->post('section_id');
			$data['teacher_id'] = 0;
			$data['principal_id'] = 0;
            $teacher_id  = $this->input->post('teacher_id');
			$teacher = explode('-',$teacher_id);
			if($teacher[0] == 't') $data['teacher_id'] = $teacher[1];
			elseif($teacher[0] == 'p') $data['principal_id'] = $teacher[1];
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->where('subject_id', $param2);
            $this->db->update('subject', $data);
			
			/*
			$noti_arr['title'] = 'Teacher Change/Add to subject';
			$noti_arr['content'] = 'Teacher Change/Add to subject';
			$noti_arr['type'] = '1';
			$noti_arr['type_id'] = $param2;
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			$students = $this->db->get_where('enroll', array('class_id' => $data['class_id'],'section_id' => $data['section_id']))->result_array();
            foreach ($students as $row)
            {				
				$noti_arr['student_id'] = $student_id = $row['student_id'];	
				 				
				$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
					
				$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'Teacher Change/Add to subject');
			}*/	
			
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/subject/' . $data['class_id']), 'refresh');
			
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
			
			$cnt = $this->db->get_where('class_routine' , array('subject_id' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_subject_mapped_in_timetable'));
				redirect(site_url('admin/subject/' . $param3), 'refresh');
				die;
			}
			
			$cnt = $this->db->get_where('assignments' , array('subject_id' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_subject_mapped_in_assignments'));
				redirect(site_url('admin/subject/' . $param3), 'refresh');
				die;
			}
			
			
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/subject/' . $param3), 'refresh');
        }
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
		    $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array('class_id' => $param1, 'year' => $running_year))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->view('backend/index', $page_data);
    }
	
	function terms($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');
		
        if ($param1 == 'create') {
            $data['title']         = $this->input->post('title');
			//$data['fees']  = $this->input->post('fees');	
			$data['class_id']  = $this->input->post('class_id');
			$data['school_id']  = $school_id;
			$data['year']  = $this->db->get_where('settings',array('type'=>'running_year'))->row()->description;
            
            $this->db->insert('terms', $data);         

            $this->session->set_flashdata('flash_message' , get_phrase('terms_added_successfully'));
            redirect(site_url('admin/terms'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['title']         = $this->input->post('title');
			//$data['fees']  = $this->input->post('fees');
            $data['class_id']  = $this->input->post('class_id');
            $this->db->where('id', $param2);
            $this->db->update('terms', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('terms_updated'));
            redirect(site_url('admin/terms'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('terms', array(
                'id' => $param2
            ))->result_array();
        }
         
        $page_data['terms']  = $this->db->get_where('terms', array('school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'terms';
        $page_data['page_title'] = get_phrase('terms_list');
        $this->load->view('backend/index', $page_data);
    }
	
	function fee($term_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        // detect the first class
		
		$school_id = $this->session->userdata('school_id');
        if ($term_id == '')
            $term_id  =   $this->db->get_where('terms' , array('school_id' => $school_id))->first_row()->class_id;

        $page_data['page_name']  = 'fees';
        $page_data['page_title'] = get_phrase('fees_structure');
        $page_data['term_id']   = $term_id;
		 $page_data['school_id']   = $school_id;
        $this->load->view('backend/index', $page_data);
    }
	
	function fees($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']       =   $this->input->post('name');
            $data['invoice']   =   $this->input->post('term_id');		
			$data['amount']   =   $this->input->post('amount');	
			 
			$this->db->insert('invoice_content' , $data);
			$this->session->set_flashdata('flash_message' , get_phrase('fee_added_successfully'));
		 
			redirect(site_url('admin/fee/' . $data['invoice']), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']       =   $this->input->post('name');
            $data['invoice']   =   $this->input->post('term_id');
			$data['amount']   =   $this->input->post('amount');	
			 
			$this->db->where('id' , $param2);
			$this->db->update('invoice_content' , $data);
			$this->session->set_flashdata('flash_message' , get_phrase('fee_updated'));


			redirect(site_url('admin/fee/' . $data['invoice']), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('invoice_content');
            $this->session->set_flashdata('flash_message' , get_phrase('fee_deleted'));
            redirect(site_url('admin/fee'), 'refresh');
        }
    }
	
	function behaviours($param1 = '', $param2 = '')
    {
         /*if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');*/
		
        if ($param1 == 'create') {
            $data['behaviour_title']         = $this->input->post('title');			 
			//$data['school_id']  = $school_id;			 
            
            $this->db->insert('behaviours', $data);         

            $this->session->set_flashdata('flash_message' , get_phrase('behaviours_added_successfully'));
            redirect(site_url('admin/behaviours'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['behaviour_title']         = $this->input->post('title');			 
            $this->db->where('id', $param2);
            $this->db->update('behaviours', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('behaviours_updated'));
            redirect(site_url('admin/behaviours'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('behaviours', array(
                'id' => $param2
            ))->result_array();
        }else if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('behaviours');
            $this->session->set_flashdata('flash_message' , get_phrase('behaviour_content_deleted'));
            redirect(site_url('admin/behaviours'), 'refresh');
        }
		
         
        $page_data['behaviours'] = $this->db->get_where('behaviours')->result_array();
        $page_data['page_name']  = 'behaviours';
        $page_data['page_title'] = get_phrase('student_behaviours');
        $this->load->view('backend/index', $page_data);
    }
	
	function behaviour_content($behaviour_id = '')
    {
        /*if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');*/
        // detect the first class
		
		//$school_id = $this->session->userdata('school_id');
        if ($behaviour_id == '')
            $behaviour_id  =   $this->db->get_where('behaviours' , array('id' => $behaviour_id))->first_row()->id;

        $page_data['page_name']  = 'behaviour_contents';
        $page_data['page_title'] = get_phrase('behaviour_contents');
        $page_data['behaviour_id']   = $behaviour_id;
		//$page_data['school_id']   = $school_id;
        $this->load->view('backend/index', $page_data);
    }
	
	function behaviour_contents($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['content_name']       =   $this->input->post('title');
            $data['behaviour']   =   $this->input->post('behaviour_id');		
			$data['actions']   =   $this->input->post('actions');	
			 
			$this->db->insert('behaviour_content' , $data);
			$this->session->set_flashdata('flash_message' , get_phrase('behaviour_content_added_successfully'));
		 
			redirect(site_url('admin/behaviour_content/' . $data['behaviour']), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['content_name']       =   $this->input->post('title');
            $data['behaviour']   =   $this->input->post('behaviour_id');
			$data['actions']   =   $this->input->post('actions');	
			 
			$this->db->where('id' , $param2);
			$this->db->update('behaviour_content' , $data);
			$this->session->set_flashdata('flash_message' , get_phrase('behaviour_content_updated'));

			redirect(site_url('admin/behaviour_content/' . $data['behaviour']), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('id' , $param2);
            $this->db->delete('behaviour_content');
            $this->session->set_flashdata('flash_message' , get_phrase('behaviour_content_deleted'));
            redirect(site_url('admin/behaviour_content'), 'refresh');
        }
    }
		
	function requests($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh'); 
		
    	$school_id = $this->session->userdata('school_id');
    
        if ($param1 == 'do_update') {
			
			$change_request = $this->db->get_where('change_request' , array('id' => $param2))->row();
			
			$user_id = $change_request->user_id;
			$role_id = $change_request->role_id;
			$name = $change_request->name;
			$email = $change_request->email;
			$phone = $change_request->phone;
			$image = $change_request->image;
			
			if($user_id > 0){			 
			
				switch($role_id){
				
					case 1:
					
						if($name!=''){
							$this->db->where('parent_id', $user_id);			
							$this->db->update('parent', array('name' => $name));	
						}
						
						if($email!=''){
							$this->db->where('parent_id', $user_id);	
							$this->db->update('parent', array('email' => $email));	
						}
						
						if($phone!=''){
							$this->db->where('parent_id', $user_id);	
							$this->db->update('parent', array('phone' => $phone,'phone_verified' => '0'));
						}
						
						if($image!='') copy($image, 'uploads/parent_image/' . $user_id . '.jpg');
					
					break;				
					case 2:
					
						if($name!=''){
							$this->db->where('teacher_id', $user_id);			
							$this->db->update('teacher', array('name' => $name));	
						}
						
						if($email!=''){
							$this->db->where('teacher_id', $user_id);	
							$this->db->update('teacher', array('email' => $email));	
						}
						
						if($phone!=''){
							$this->db->where('teacher_id', $user_id);	
							$this->db->update('teacher', array('phone' => $phone,'phone_verified' => '0'));
						}
						
						if($image!='') copy($image, 'uploads/teacher_image/' . $user_id . '.jpg');
					
					break;
					case 3:
						
						if($name!=''){
							$this->db->where('principal_id', $user_id);			
							$this->db->update('principal', array('name' => $name));	
						}
						
						if($email!=''){
							$this->db->where('principal_id', $user_id);	
							$this->db->update('principal', array('email' => $email));	
						}
						
						if($phone!=''){
							$this->db->where('principal_id', $user_id);	
							$this->db->update('principal', array('phone' => $phone,'phone_verified' => '0'));
						}			
						 
						if($image!='') copy($image, 'uploads/principal_image/' . $user_id . '.jpg');
					
					break;					
					default:
					break;				
				}
				
				$this->db->where('id', $param2);
				$this->db->delete('change_request');
				$this->session->set_flashdata('flash_message' , get_phrase('requests_approved'));
				redirect(site_url('admin/requests'), 'refresh');
			}            
			
        } else if ($param1 == 'edit') {
			
            $page_data['edit_data'] = $this->db->get_where('change_request', array(
                'id' => $param2
            ))->result_array();
        }
         
        $page_data['requests']    = $this->db->get_where('change_request', array('school_id'=>$school_id))->result_array();
        $page_data['page_name']  = 'requests';
        $page_data['page_title'] = get_phrase('profile_change_requests');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE CLASSES*****/
    function classes($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');
		
        if ($param1 == 'create') {
            $data['name']         = $this->input->post('name');			
            $data['school_id']   = $this->input->post('school_id');
            
            $this->db->insert('class', $data);
            $class_id = $this->db->insert_id();
            //create a section by default
            $data2['class_id']  =   $class_id;
            $data2['name']      =   'A';            
            $this->db->insert('section' , $data2);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/classes'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name'] = $this->input->post('name');			 
            $data['school_id'] = $this->input->post('school_id');
            
            $this->db->where('class_id', $param2);
            $this->db->update('class', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/classes'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class', array(
                'class_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
			
			$cnt  = $this->db->get_where('section' , array('class_id' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_class_mapped_in_section'));
				redirect(site_url('admin/classes'), 'refresh');
				die;
			}
			
            $this->db->where('class_id', $param2);
            $this->db->delete('class');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/classes'), 'refresh');
        }
        $page_data['classdata'] = $classes  = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
	    $page_data['page_name']  = 'class';
        $page_data['page_title'] = get_phrase('manage_stream');
        $this->load->view('backend/index', $page_data);
    }
	function class_subjects($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
		
        if ($param1 == 'create') {
			$parts_check = $this->input->post('parts');
			if($parts_check == 2) {
            $data['subject'] = $this->input->post('subject');            
            $data['is_elective'] = $this->input->post('is_elective');			 
            $data['parts'] = $this->input->post('parts');
			$data['subject_group'] = $this->input->post('subject_group');			
            $data['part1'] = $this->input->post('part1');			 
            $data['part2'] = $this->input->post('part2');			 
            $data['part1_mark'] = $this->input->post('part1_mark');				 
            $data['part2_mark'] = $this->input->post('part2_mark');				 
            $data['school_id'] = $this->session->userdata('school_id');	
			} elseif($parts_check == 3) { 
				$data['subject'] = $this->input->post('subject');
				$data['is_elective'] = $this->input->post('is_elective');			 
				$data['parts'] = $this->input->post('parts');
				$data['subject_group'] = $this->input->post('subject_group');			
				$data['part3'] = $this->input->post('part3');			 
				$data['part4'] = $this->input->post('part4');				 
				$data['part5'] = $this->input->post('part5');				 
				$data['part3_mark'] = $this->input->post('part3_mark');				 
				$data['part4_mark'] = $this->input->post('part4_mark');				 
				$data['part5_mark'] = $this->input->post('part5_mark');				 
				$data['school_id'] = $this->session->userdata('school_id');	 
			}elseif($parts_check == 4) {
				$data['subject'] = $this->input->post('subject');
				$data['is_elective'] = $this->input->post('is_elective');			 
				$data['parts'] = $this->input->post('parts');
				$data['subject_group'] = $this->input->post('subject_group');			
				$data['part6'] = $this->input->post('part6');			 
				$data['part7'] = $this->input->post('part7');				 
				$data['part8'] = $this->input->post('part8');				 
				$data['part9'] = $this->input->post('part9');				 
				$data['part6_mark'] = $this->input->post('part6_mark');				 
				$data['part7_mark'] = $this->input->post('part7_mark');				 
				$data['part8_mark'] = $this->input->post('part8_mark');				 
				$data['part9_mark'] = $this->input->post('part9_mark');				 
				$data['school_id'] = $this->session->userdata('school_id');	
			} else {	
			$data['subject'] = $this->input->post('subject');
			$data['subject_code'] = $this->input->post('subject_code');
            $data['is_elective'] = $this->input->post('is_elective');
			$data['parts'] = 0;
			$data['subject_group'] = $this->input->post('subject_group');
			$data['total_marks_out_of'] = $this->input->post('total_marks_out_of');
            $data['part1'] = $this->input->post('part1');			 
            $data['part2'] = $this->input->post('part2');				 
            $data['part3'] = $this->input->post('part3');				 
            $data['part1_mark'] = $this->input->post('part1_mark');				 
            $data['part2_mark'] = $this->input->post('part2_mark');				 
            $data['part3_mark'] = $this->input->post('part3_mark');				 
            $data['school_id'] = $this->session->userdata('school_id');			
			}			
            $this->db->insert('class_subjects', $data);  
            $this->session->set_flashdata('flash_message' , get_phrase('class_subject_added_successfully'));
            redirect(site_url('admin/class_subjects'), 'refresh');
        }
		
		
        if ($param1 == 'do_update') {
			$parts_check = $this->input->post('parts');
			if($parts_check == 2) {
            $data['subject'] = $this->input->post('subject');
            $data['is_elective'] = $this->input->post('is_elective');
			$data['parts'] = $this->input->post('parts');
			$data['subject_group'] = $this->input->post('subject_group');			
            $data['part1'] = $this->input->post('part1');			 
            $data['part2'] = $this->input->post('part2');				 
            $data['part1_mark'] = $this->input->post('part1_mark');				 
            $data['part2_mark'] = $this->input->post('part2_mark');
			} elseif($parts_check == 3) { 
			$data['subject'] = $this->input->post('subject');
            $data['is_elective'] = $this->input->post('is_elective');
			$data['parts'] = $this->input->post('parts');
			$data['subject_group'] = $this->input->post('subject_group');			
            $data['part3'] = $this->input->post('part3');			 
            $data['part4'] = $this->input->post('part4');				 
            $data['part5'] = $this->input->post('part5');				 
            $data['part3_mark'] = $this->input->post('part3_mark');				 
            $data['part4_mark'] = $this->input->post('part4_mark');				 
            $data['part5_mark'] = $this->input->post('part5_mark');	
			}elseif($parts_check == 4) { 
			$data['subject'] = $this->input->post('subject');
            $data['is_elective'] = $this->input->post('is_elective');
			$data['parts'] = $this->input->post('parts');
			$data['subject_group'] = $this->input->post('subject_group');			
            $data['part6'] = $this->input->post('part6');			 
            $data['part7'] = $this->input->post('part7');				 
            $data['part8'] = $this->input->post('part8');				 
            $data['part9'] = $this->input->post('part9');				 
            $data['part6_mark'] = $this->input->post('part6_mark');				 
            $data['part7_mark'] = $this->input->post('part7_mark');				 
            $data['part8_mark'] = $this->input->post('part8_mark');	
            $data['part9_mark'] = $this->input->post('part9_mark');	
			} else {
			$data['subject'] = $this->input->post('subject');
			$data['subject_code'] = $this->input->post('subject_code');
            $data['is_elective'] = $this->input->post('is_elective');
			$data['parts'] = $this->input->post('parts');
			$data['subject_group'] = $this->input->post('subject_group');			
			$data['total_marks_out_of'] = $this->input->post('total_marks_out_of');			
            $data['part1'] = $this->input->post('part1');			 
            $data['part2'] = $this->input->post('part2');				 
            $data['part3'] = $this->input->post('part3');				 
            $data['part1_mark'] = $this->input->post('part1_mark');				 
            $data['part2_mark'] = $this->input->post('part2_mark');				 
            $data['part3_mark'] = $this->input->post('part3_mark');	
			}
            $this->db->where('id', $param2);
            $this->db->update('class_subjects', $data);
			
			$sdata['name'] = $data['subject'];
			$sdata['is_elective'] = $data['is_elective'];
			$this->db->where('class_subject', $param2);
            $this->db->update('subject', $sdata);
			
            $this->session->set_flashdata('flash_message' , get_phrase('class_subject_updated'));
            redirect(site_url('admin/class_subjects'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class_subjects', array(
                'id' => $param2))->result_array();
        }
        if ($param1 == 'delete') {
			
			$cnt  = $this->db->get_where('subject' , array('class_subject' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_class_subject_mapped_in_subject'));
				redirect(site_url('admin/class_subjects'), 'refresh');
				die;
			}		
			
            $this->db->where('id', $param2);
            $this->db->delete('class_subjects');
            $this->session->set_flashdata('flash_message' , get_phrase('class_subject_deleted'));
            redirect(site_url('admin/class_subjects'), 'refresh');
        }
        $page_data['class_subjectss'] = $class_subjects  = $this->db->get_where('class_subjects', array('school_id' => $school_id))->result_array();
	    $page_data['page_name']  = 'class_subjects';
        $page_data['page_title'] = get_phrase('stream_subjects');
        $this->load->view('backend/index', $page_data);
    }
     function get_subject($class_id)
    {
        $subject = $this->db->get_where('subject' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($subject as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
    // ACADEMIC SYLLABUS
    function academic_syllabus($class_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        // detect the first class
        if ($class_id == '')
            $class_id           =   $this->db->get('class')->first_row()->class_id;

        $page_data['page_name']  = 'academic_syllabus';
        $page_data['page_title'] = get_phrase('academic_syllabus');
        $page_data['class_id']   = $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function upload_academic_syllabus()
    {
        $data['academic_syllabus_code'] =   substr(md5(rand(0, 1000000)), 0, 7);
        if ($this->input->post('description') != null) {
           $data['description'] = $this->input->post('description');
        }
        $data['title']                  =   $this->input->post('title');
        $data['class_id']               =   $this->input->post('class_id');
        $data['subject_id']             =   $this->input->post('subject_id');
        $data['uploader_type']          =   $this->session->userdata('login_type');
        $data['uploader_id']            =   $this->session->userdata('login_user_id');
        $data['year']                   =   $this->db->get_where('settings',array('type'=>'running_year'))->row()->description;
        $data['timestamp']              =   strtotime(date("Y-m-d H:i:s"));
        //uploading file using codeigniter upload library
        $files = $_FILES['file_name'];
        $this->load->library('upload');
        $config['upload_path']   =  'uploads/syllabus/';
        $config['allowed_types'] =  '*';
        $_FILES['file_name']['name']     = $files['name'];
        $_FILES['file_name']['type']     = $files['type'];
        $_FILES['file_name']['tmp_name'] = $files['tmp_name'];
        $_FILES['file_name']['size']     = $files['size'];
        $this->upload->initialize($config);
        $this->upload->do_upload('file_name');

        $data['file_name'] = $_FILES['file_name']['name'];

        $this->db->insert('academic_syllabus', $data);
        $this->session->set_flashdata('flash_message' , get_phrase('syllabus_uploaded'));
        redirect(site_url('admin/academic_syllabus/' . $data['class_id']), 'refresh');

    }

    function download_academic_syllabus($academic_syllabus_code)
    {
        $file_name = $this->db->get_where('academic_syllabus', array(
            'academic_syllabus_code' => $academic_syllabus_code
        ))->row()->file_name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/syllabus/" . $file_name);
        $name = $file_name;

        force_download($name, $data);
    }

    function delete_academic_syllabus($academic_syllabus_code) {
      $file_name = $this->db->get_where('academic_syllabus', array(
          'academic_syllabus_code' => $academic_syllabus_code
      ))->row()->file_name;
      if (file_exists('uploads/syllabus/'.$file_name)) {
        // unlink('uploads/syllabus/'.$file_name);
      }
      $this->db->where('academic_syllabus_code', $academic_syllabus_code);
      $this->db->delete('academic_syllabus');

      $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
      redirect(site_url('admin/academic_syllabus'), 'refresh');

    }
	

    /****MANAGE SECTIONS*****/
    function section($class_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        // detect the first class
		
		$school_id = $this->session->userdata('school_id');
        if ($class_id == '')
            $class_id           =   $this->db->get_where('class' , array('school_id' => $school_id))->first_row()->class_id;

        $page_data['page_name']  = 'section';
        $page_data['page_title'] = get_phrase('manage_classes');
        $page_data['class_id']   = $class_id;
		 $page_data['school_id']   = $school_id;
        $this->load->view('backend/index', $page_data);
    }

    function sections($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']       =   $this->input->post('name');
			$data['total_seat']  = $this->input->post('total_seats');
			$data['divides']  = $this->input->post('divides');
			$data['columns'] = $this->input->post('columns');
            $data['class_id']   =   $this->input->post('class_id');
			
			$teacher_id  = $this->input->post('teacher_id');
			$teacher = explode('-',$teacher_id);
			if($teacher[0] == 't') $data['teacher_id'] = $teacher[1];
			elseif($teacher[0] == 'p') $data['principal_id'] = $teacher[1];			
            
            if ($this->input->post('nick_name') != null) {
               $data['nick_name'] = $this->input->post('nick_name');
            }
            $validation = duplication_of_section_on_create($data['class_id'], $data['name']);
            if($validation == 1){
                $this->db->insert('section' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('duplicate_name_of_section_is_not_allowed'));
            }

            redirect(site_url('admin/section/' . $data['class_id']), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']       =   $this->input->post('name');
			$data['total_seat']  = $this->input->post('total_seats');
			$data['divides']  = $this->input->post('divides');
			$data['columns'] = $this->input->post('columns');
            $data['class_id']   =   $this->input->post('class_id');
			$data['teacher_id'] = 0;
			$data['principal_id'] = 0;
			$teacher_id  = $this->input->post('teacher_id');
			$teacher = explode('-',$teacher_id);
			if($teacher[0] == 't') $data['teacher_id'] = $teacher[1];
			elseif($teacher[0] == 'p') $data['principal_id'] = $teacher[1];		
            if ($this->input->post('nick_name') != null) {
                $data['nick_name'] = $this->input->post('nick_name');
            }
            else{
                $data['nick_name'] = null;
            }
            $validation = duplication_of_section_on_edit($param2, $data['class_id'], $data['name']);
            if ($validation == 1) {
               $this->db->where('section_id' , $param2);
               $this->db->update('section' , $data);
               $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
               $this->session->set_flashdata('error_message' , get_phrase('duplicate_name_of_section_is_not_allowed'));
            }

            redirect(site_url('admin/section/' . $data['class_id']), 'refresh');
        }

        if ($param1 == 'delete') {
			
			$cnt = $this->db->get_where('subject' , array('section_id' => $param2))->num_rows();	
			 			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_section_mapped_in_subjects'));
				redirect(site_url('admin/section'), 'refresh');
				die;
			}
			$cnt = $this->db->get_where('enroll' , array('section_id' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_section_mapped_in_students'));
				redirect(site_url('admin/section'), 'refresh');
				die;
			}
			$cnt = $this->db->get_where('class_routine' , array('section_id' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_section_mapped_in_timetable'));
				redirect(site_url('admin/section'), 'refresh');
				die;
			}
			
			$cnt = $this->db->get_where('assignments' , array('section_id' => $param2))->num_rows();			
			if($cnt >0){
				$this->session->set_flashdata('error_message' , get_phrase('Cant_be_delete_selected_section_mapped_in_assignments'));
				redirect(site_url('admin/section'), 'refresh');
				die;
			}
			
            $this->db->where('section_id' , $param2);
            $this->db->delete('section');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/section'), 'refresh');
        }
    }
	
	function get_terms($class_id)
    {				 
        $terms = $this->db->get_where('terms' , array('class_id' => $class_id, 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array();
		
		echo '<option tid="" tamt="" value="" >select</option>';
        foreach ($terms as $row) {
			$amount=0;
			$fees = $this->db->get_where('invoice_content' , array('invoice' => $row['id']))->result_array();
			foreach($fees as $fee){
				$amount+= $fee['amount'];
			}
			
			$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
			
            echo '<option tid="' . $row['id'] . '" tamt="' . $amount . '" value="' . $row['title'] . '" >' . $row['title'] . '</option>';
        }
    }	 

    function get_class_section($class_id,$isall=0)
    {
		
		$user_id = $this->session->userdata('login_user_id');      
        $role = $this->session->userdata('login_type');
		  
		$sectionsids='';
		if($role =='principal')
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
		elseif($role =='teacher')
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('teacher_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
	
		if($sectionsids!='' && $isall == 0)
		$sections = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section')->result_array();
		else
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
				
		  echo '<option value="">select section</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }
	
	function get_class_section_elective($class_id,$isall=0)
    {
		
		$user_id = $this->session->userdata('login_user_id');      
        $role = $this->session->userdata('login_type');
		  
		$sectionsids='';
		if($role =='principal')
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
		elseif($role =='teacher')
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('teacher_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
	
		if($sectionsids!='' && $isall == 0)
		$sections = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section')->result_array();
		else
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
				
		  echo '<option value="">select section</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['offer_subject'] . '</option>';
        }
    }
	
	function get_offer_class_section($class_id,$isall=0)
    {
		
		$user_id = $this->session->userdata('login_user_id');      
        $role = $this->session->userdata('login_type');
		  
		$sectionsids='';
		if($role =='principal')
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('principal_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
		elseif($role =='teacher')
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('teacher_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
	
		if($sectionsids!='' && $isall == 0)
		$sections = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section')->result_array();
		else
        $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
				
		  echo '<option value="">select section</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_subject($class_id,$section_id=0)
    {
		
		$user_id = $this->session->userdata('login_user_id');      
        $role = $this->session->userdata('login_type');
		  		 
		/*if($role =='principal')			
        $subjects = $this->db->get_where('subject' , array('principal_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id))->result_array();
		else*/
		if($role =='teacher')		
        $subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id
        ))->result_array();
		else
		$subjects = $this->db->get_where('subject' , array('class_id' => $class_id,'section_id' => $section_id
        ))->result_array();
 				
		$i=1;
        foreach ($subjects as $row) { $sele = ($i == 1)?"selected":"";
            echo '<option value="' . $row['subject_id'] . '" '. $sele.'>' . $row['name'] . '</option>';
        }
    }
	
	function get_offer_class_subject($class_id,$section_id=0)
    {
		
		$user_id = $this->session->userdata('login_user_id');      
        $role = $this->session->userdata('login_type');
		  		 
		/*if($role =='principal')			
        $subjects = $this->db->get_where('subject' , array('principal_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id))->result_array();
		else*/
		if($role =='teacher')		
        $offer_subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id
        ))->result_array();
		else
		$offer_subjects = $this->db->get_where('subject' , array('class_id' => $class_id,'section_id' => $section_id
        ))->result_array();
 				
		$i=1;
        foreach ($offer_subjects as $row) { $sele1 = ($i == 1)?"selected":"";
            echo '<option value="' . $row['subject_id'] . '" '. $sele1.'>' . $row['offer_subject'] . '</option>';
        }
    }
	
	function get_class_subject_periord($class_id,$section_id,$subject_id)
    {
        $periords = $this->db->get_where('class_routine' , array(
            'class_id' => $class_id,'section_id' => $section_id,'subject_id' => $subject_id))->result_array();
		$i=1;
        foreach ($periords as $row) { $sele = ($i == 1)?"selected":"";
			$time_start = ($row['time_start_min'] >0)?$row['time_start'].':'.$row['time_start_min']:$row['time_start'];
			$time_end = ($row['time_end_min'] >0)?$row['time_end'].':'.$row['time_end_min']:$row['time_end'];
            echo '<option value="' . $time_start."-".$time_end . '" '. $sele.'>' . $time_start."-".$time_end . '</option>';
        }
    }

    function get_class_students($class_id,$section_id=0)
    {
        $students = $this->db->get_where('enroll' , array(
            'class_id' => $class_id ,'section_id' => $section_id, 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        foreach ($students as $row) {
            $name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
            echo '<option value="' . $row['student_id'] . '">' . $name . '</option>';
        }
    }

    function get_class_students_mass($class_id,$section_id=0)
    {
        $students = $this->db->get_where('enroll' , array(
            'class_id' => $class_id ,'section_id' => $section_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        echo '<div class="form-group">
                <label class="col-sm-3 control-label">' . get_phrase('students') . '</label>
                <div class="col-sm-9">';
        foreach ($students as $row) {
             $name = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
            echo '<div class="checkbox">
                    <label><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name .'</label>
                </div>';
        }
        echo '<br><button type="button" class="btn btn-default" onClick="select()">'.get_phrase('select_all').'</button>';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-default" onClick="unselect()"> '.get_phrase('select_none').' </button>';
        echo '</div></div>';
    }



    /****MANAGE EXAMS*****/
    function exam($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');
		
		
		 $page_data['exams']      = $this->db->get('exams')->result_array();
        $page_data['page_name']  = 'exam';
        $page_data['page_title'] = get_phrase('manage_exam');
		
     
        if ($param1 == 'create') {
			
			$this->db->like('Term1', $this->input->post('name'));
			
			$this->db->from('exams'); 
			$result= $this->db->count_all_results();
			if($result >= 1){
				echo "exam already exist";
			}else{
			
            $data['Term1']    = $this->input->post('name');
			$tbname			=  strtolower(str_replace("-","",str_replace(" ","",$this->input->post('name'))));
            $data['date']    = $this->input->post('date');
            $data['comment'] = $this->input->post('comment');
			 $data['limit'] = $this->input->post('limit');
			 	$data['school_id'] = $school_id;
            $this->db->insert('exams', $data);
           if($this->db->query("
		   CREATE TABLE `$tbname` ENGINE=INNODB  COLLATE = latin1_swedish_ci COMMENT = '' SELECT `Adm`, `Subject`, `Code`, `Date`, `PosClass`, `PosStream`, `Term`, `Stream`, `TotalScore`, `Id`, `Grade`, `TotalPercent`, `Form`, `subno`, `Year`,school_id,exam_type FROM `cat1a` WHERE 1 = 0;
		  ")){
			  
				
			 $this->db->query("ALTER TABLE `scores`     ADD COLUMN `$tbname` DOUBLE DEFAULT '0' NOT NULL ;"); 
			 $this->db->query("ALTER TABLE `mean_score`     ADD COLUMN `$tbname` DOUBLE DEFAULT '0' NOT NULL ;"); 
			  $this->db->query("ALTER TABLE `mean_score`     ADD COLUMN `pc$tbname` DOUBLE DEFAULT '0' NOT NULL ;"); 
			  
			  $this->db->query("ALTER TABLE `mean_score`     ADD COLUMN `tm$tbname` DOUBLE DEFAULT '0' NOT NULL ;"); 
			  
			  	  $this->db->query("ALTER TABLE `mean_score`     ADD COLUMN `ps$tbname` DOUBLE DEFAULT '0' NOT NULL ;"); 
			 $this->db->query("ALTER TABLE `$tbname`     CHANGE `Id` `Id` INT(11) NOT NULL AUTO_INCREMENT,    ADD PRIMARY KEY(`Id`);");
			  
				 $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
			}
			else{
				 $this->session->set_flashdata('flash_message' , get_phrase('failed'));
			}
         
		 
		 //CREATE/ALTER FUNCTIONS
		 	$exams= $this->db->get("exams")->result_array();
						$i=0;
						$str='';
						foreach($exams as $row):
						$this->db->query("DROP FUNCTION IF EXISTS `".str_replace(" ","",strtolower($row['Term1']))."sumt`");
						$this->db->query("CREATE  FUNCTION `".str_replace(" ","",strtolower($row['Term1']))."sumt`(adm DOUBLE,trm VARCHAR(10),yr VARCHAR(10),form VARCHAR(10) ,school_id INT ) RETURNS DOUBLE
						DETERMINISTIC
							BEGIN
								DECLARE val DOUBLE;
								SELECT (SUM(TotalScore)) INTO val FROM ".str_replace(" ","",strtolower($row['Term1']))." WHERE ".str_replace(" ","",strtolower($row['Term1'])).".Adm=adm AND Term=trm AND ".str_replace(" ","",strtolower($row['Term1'])).".Year=yr AND ".str_replace(" ","",strtolower($row['Term1'])).".Form=form and school_id=school_id GROUP BY adm;
								RETURN val;
							END
					");
						$this->db->query("DROP FUNCTION IF EXISTS `".str_replace(" ","",strtolower($row['Term1']))."avgs`");
							$this->db->query("CREATE  FUNCTION `".str_replace(" ","",strtolower($row['Term1']))."avgs`(adm DOUBLE,trm VARCHAR(10),yr VARCHAR(10),form VARCHAR(10) ,school_id INT) RETURNS DOUBLE
						DETERMINISTIC
							BEGIN
								DECLARE val DOUBLE;
								SELECT (AVG(TotalScore)) INTO val FROM ".str_replace(" ","",strtolower($row['Term1']))." WHERE ".str_replace(" ","",strtolower($row['Term1'])).".Adm=adm AND Term=trm AND ".str_replace(" ","",strtolower($row['Term1'])).".Year=yr AND ".str_replace(" ","",strtolower($row['Term1'])).".Form=form and school_id=school_id GROUP BY adm;
								RETURN val;
							END
					");
								$this->db->query("DROP FUNCTION IF EXISTS `".str_replace(" ","",strtolower($row['Term1']))."avgp`");
								$this->db->query("CREATE  FUNCTION `".str_replace(" ","",strtolower($row['Term1']))."avgp`(adm DOUBLE,trm VARCHAR(10),yr VARCHAR(10),form VARCHAR(10),school_id INT ) RETURNS DOUBLE
						DETERMINISTIC
							BEGIN
								DECLARE val DOUBLE;
								SELECT (AVG(TotalPercent)) INTO val FROM ".str_replace(" ","",strtolower($row['Term1']))." WHERE ".str_replace(" ","",strtolower($row['Term1'])).".Adm=adm AND Term=trm AND ".str_replace(" ","",strtolower($row['Term1'])).".Year=yr AND ".str_replace(" ","",strtolower($row['Term1'])).".Form=form and school_id=school_id GROUP BY adm;
								RETURN val;
							END
					");
							endforeach ;
		 
		 
		 
		 
		 
		 //CREATE A TRIGGER FOR RESULT PROCESSING
		 
		 //ON INSERT
			$exams= $this->db->get("exams")->result_array();

						$i=0;
						$str='';

					$str='CREATE   TRIGGER `processa` AFTER INSERT ON `scores` FOR EACH ROW BEGIN  ';
					foreach($exams as $row):
					$i+=1;
						if ($i==1){
					   $str.=' IF(new.Etype="'.strtolower($row['Term1']).'") THEN
						INSERT INTO '.str_replace(" ","",strtolower($row['Term1'])).'(exam_type,YEAR,Form,Stream,Grade,TotalScore,TotalPercent,Adm,CODE,term,SUBJECT,school_id) VALUES(new.Etype,new.Year,new.Form,new.Stream,rgrade(((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100),new.school_id),new.'.str_replace(" ","",strtolower($row['Term1'])).',((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100),new.Adm,new.code,new.term,sub(new.code),school_id);';
						
						$str.="SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE as c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE,stream, TotalScore DESC
						) AS A SET dest.PosStream=pos  WHERE  dest.Adm=A.di and dest.code=A.c;
						SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE AS c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE, TotalScore DESC
						) AS A SET dest.Posclass=pos  WHERE  dest.Adm=A.di AND dest.code=A.c ;";	
						
						
						
							}else{

								$str.=' ELSEIF(new.Etype="'.strtolower($row['Term1']).'") THEN		
							INSERT INTO '.str_replace(" ","",strtolower($row['Term1'])).'(exam_type,YEAR,Form,Stream,Grade,TotalScore,TotalPercent,Adm,CODE,term,SUBJECT,school_id) VALUES(new.Etype,new.Year,new.Form,new.Stream,rgrade(((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100),new.school_id),new.'.str_replace(" ","",strtolower($row['Term1'])).',((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100),new.Adm,new.code,new.term,sub(new.code),school_id);';
							
							
							$str.="SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE as c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE,stream, TotalScore DESC
						) AS A SET dest.PosStream=pos  WHERE  dest.Adm=A.di and dest.code=A.c;
						SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE AS c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE, TotalScore DESC
						) AS A SET dest.Posclass=pos  WHERE  dest.Adm=A.di AND dest.code=A.c ;";	
						
							
							
							
							}
							
							endforeach ;
								
								$str.=' END IF   ;    
							END ;

																																																									
						';
						$this->db->query("DROP TRIGGER IF EXISTS `processa`");
						$this->db->query($str);
						
						
						//UPDATE
						
						
$exams= $this->db->get("exams")->result_array();

						$i=0;
						$str='';

					$str='CREATE   TRIGGER `process_update` AFTER UPDATE ON `scores` FOR EACH ROW BEGIN  ';
					foreach($exams as $row):
					$i+=1;
						if ($i==1){
					   $str.=' IF(new.Etype="'.strtolower($row['Term1']).'") THEN
						UPDATE '.str_replace(" ","",strtolower($row['Term1'])).' SET Grade=rgrade(((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100),new.school_id),TotalScore=new.'.str_replace(" ","",strtolower($row['Term1'])).',TotalPercent=((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100) WHERE adm=new.adm AND YEAR=new.year AND term=new.term AND CODE=new.code AND school_id=new.school_id;';
						
						$str.="SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE as c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE,stream, TotalScore DESC
						) AS A SET dest.PosStream=pos  WHERE  dest.Adm=A.di and dest.code=A.c;
						SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE AS c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE, TotalScore DESC
						) AS A SET dest.Posclass=pos  WHERE  dest.Adm=A.di AND dest.code=A.c ;";	
						
						
						
							}else{

								$str.=' ELSEIF(new.Etype="'.strtolower($row['Term1']).'") THEN		
							UPDATE '.str_replace(" ","",strtolower($row['Term1'])).' SET Grade=rgrade(((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100),new.school_id),TotalScore=new.'.str_replace(" ","",strtolower($row['Term1'])).',TotalPercent=((new.'.str_replace(" ","",strtolower($row['Term1'])).'/new.Limit1)*100) WHERE adm=new.adm AND YEAR=new.year AND term=new.term AND CODE=new.code AND school_id=new.school_id;';
							
							
							$str.="SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE as c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE,stream, TotalScore DESC
						) AS A SET dest.PosStream=pos  WHERE  dest.Adm=A.di and dest.code=A.c;
						SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE ".str_replace(" ","",strtolower($row['Term1']))." AS dest, (
						SELECT adm AS di, @r6=IF(CODE=@sub,1,@rr:=0) AS rank4,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream,
						@sub:=CODE AS c
						FROM ".str_replace(" ","",strtolower($row['Term1']))."  ORDER BY CODE, TotalScore DESC
						) AS A SET dest.Posclass=pos  WHERE  dest.Adm=A.di AND dest.code=A.c ;";	
						
							
							
							
							}
							
							endforeach ;
								
								$str.=' END IF   ;    
							END ;

																																																									
						';
						$this->db->query("DROP TRIGGER IF EXISTS `process_update`");
						$this->db->query($str);
						
						
						///MEAN SCORE TRIGGER CREATION
						
						
						
						$exams= $this->db->get("exams")->result_array();
						$i=0;
						$str='';
	foreach($exams as $row):
							$i+=1;					
							$this->db->query("DROP TRIGGER IF EXISTS insert_".str_replace(" ","",strtolower($row['Term1'])).$i."");				
							$str='CREATE   TRIGGER insert_'.str_replace(" ","",strtolower($row['Term1'])).''.$i.' AFTER insert ON '.str_replace(" ","",strtolower($row['Term1'])).' FOR EACH ROW BEGIN  ';							
							$str.='DELETE FROM mean_score WHERE adm=new.adm AND YEAR=new.year AND term=new.term and school_id=new.school_id and exam_type=new.exam_type;';
							$str.='	INSERT INTO mean_score('.str_replace(" ","",strtolower($row['Term1'])).',exam_type,school_id,YEAR,subno,tm'.str_replace(" ","",strtolower($row['Term1'])).',Adm,Term,Stream,TotalScore,TotalPercent,Form) VALUES('.str_replace(" ","",strtolower($row['Term1'])).'avgs(new.adm,new.term,new.year,new.form,new.school_id),new.exam_type,new.school_id,new.Year,new.subno,'.str_replace(" ","",strtolower($row['Term1'])).'sumt(new.adm,new.term,new.year,new.form,new.school_id),new.adm,new.Term,new.Stream,'.str_replace(" ","",strtolower($row['Term1'])).'avgs(new.adm,new.term,new.year,new.form,new.school_id),'.str_replace(" ","",strtolower($row['Term1'])).'avgp(new.adm,new.term,new.year,new.form,new.school_id) ,new.Form); ';	
							
							$str.="SET @rank = 1; SET @stream=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
							UPDATE mean_score AS dest, (
							SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2, @rr:=@rr+1,
							@rank=IF(".str_replace(" ","",strtolower($row['Term1']))."=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
							 @score:=".str_replace(" ","",strtolower($row['Term1'])).",
							@r3:=@rnk AS pos,
							@stream:=stream
							 FROM mean_score WHERE Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  and school_id = new.school_id and exam_type=new.exam_type ORDER BY stream, ".str_replace(" ","",strtolower($row['Term1']))." DESC
							) AS A SET dest.ps".str_replace(" ","",strtolower($row['Term1']))."=pos  WHERE  dest.Adm=A.di ;
							SET @rank = 1; SET @stream=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
							UPDATE mean_score AS dest, (
							SELECT adm AS di,@r2=IF(stream=@stream,1,1) AS rank2, @rr:=@rr+1,
							@rank=IF(".str_replace(" ","",strtolower($row['Term1']))."=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
							 @score:=".str_replace(" ","",strtolower($row['Term1'])).",
							@r3:=@rnk AS pos,
							@stream:=stream
							 FROM mean_score WHERE Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  and school_id = new.school_id and exam_type=new.exam_type ORDER BY  ".str_replace(" ","",strtolower($row['Term1']))." DESC
							) AS A SET dest.pc".str_replace(" ","",strtolower($row['Term1']))."=pos  WHERE  dest.Adm=A.di ;";								
							$str.='   
							END ; ';
									//EXECUTE QUERY
							$this->db->query($str);
									
					endforeach ;
						
						
$exams= $this->db->get("exams")->result_array();
						$i=0;
						$str='';
	foreach($exams as $row):
							$i+=1;					
							$this->db->query("DROP TRIGGER IF EXISTS update_".str_replace(" ","",strtolower($row['Term1']))."$i");				
							$str='CREATE   TRIGGER update_'.str_replace(" ","",strtolower($row['Term1'])).''.$i.' AFTER UPDATE ON '.str_replace(" ","",strtolower($row['Term1'])).' FOR EACH ROW BEGIN  ';							
							
							$str.='	UPDATE mean_score SET '.str_replace(" ","",strtolower($row['Term1'])).'='.str_replace(" ","",strtolower($row['Term1'])).'avgs(new.adm,new.term,new.year,new.form,new.school_id),tm'.str_replace(" ","",strtolower($row['Term1'])).'='.str_replace(" ","",strtolower($row['Term1'])).'sumt(new.adm,new.term,new.year,new.form,new.school_id),TotalScore='.str_replace(" ","",strtolower($row['Term1'])).'avgs(new.adm,new.term,new.year,new.form,new.school_id),TotalPercent='.str_replace(" ","",strtolower($row['Term1'])).'avgp(new.adm,new.term,new.year,new.form,new.school_id) WHERE adm=new.adm AND YEAR=new.year AND term=new.term AND CODE=new.code AND school_id=new.school_id AND exam_type=new.exam_type;';
							
							$str.="SET @rank = 1; SET @stream=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
							UPDATE mean_score AS dest, (
							SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2, @rr:=@rr+1,
							@rank=IF(".str_replace(" ","",strtolower($row['Term1']))."=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
							 @score:=".str_replace(" ","",strtolower($row['Term1'])).",
							@r3:=@rnk AS pos,
							@stream:=stream
							 FROM mean_score WHERE Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  and school_id = new.school_id and exam_type=new.exam_type ORDER BY stream, ".str_replace(" ","",strtolower($row['Term1']))." DESC
							) AS A SET dest.ps".str_replace(" ","",strtolower($row['Term1']))."=pos  WHERE  dest.Adm=A.di ;
							SET @rank = 1; SET @stream=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
							UPDATE mean_score AS dest, (
							SELECT adm AS di,@r2=IF(stream=@stream,1,1) AS rank2, @rr:=@rr+1,
							@rank=IF(".str_replace(" ","",strtolower($row['Term1']))."=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
							 @score:=".str_replace(" ","",strtolower($row['Term1'])).",
							@r3:=@rnk AS pos,
							@stream:=stream
							 FROM mean_score WHERE Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  and school_id = new.school_id and exam_type=new.exam_type ORDER BY  ".str_replace(" ","",strtolower($row['Term1']))." DESC
							) AS A SET dest.pc".str_replace(" ","",strtolower($row['Term1']))."=pos  WHERE  dest.Adm=A.di ;";								
							$str.='   
							END ; ';
									//EXECUTE QUERY
							$this->db->query($str);
									
					endforeach ;
									
									
			}
							
			
        }
		
		
        if ($param1 == 'create') {
            $data['name']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            $data['year']    = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
			$data['school_id'] = $school_id;
            $this->db->insert('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/exam'), 'refresh');
        }
        if ($param1 == 'edit' && $param2 == 'do_update') {
            $data['name']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
            else{
              $data['comment'] = null;
            }
            $data['year']    = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

            $this->db->where('exam_id', $param3);
            $this->db->update('exam', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/exam'), 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('exam', array(
                'exam_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('exam_id', $param2);
            $this->db->delete('exam');
          	
          	$this->db->where('exam_id', $param2);
            $this->db->delete('mark');
          
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/exam'), 'refresh');
        }
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $page_data['exams']      = $this->db->get_where('exam', array('school_id' => $school_id,'year' => $running_year))->result_array();
        $page_data['page_name']  = 'exam';
        $page_data['page_title'] = get_phrase('manage_exam');
        $this->load->view('backend/index', $page_data);
    }

    /****** SEND EXAM MARKS VIA SMS ********/
    function exam_marks_sms($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 == 'send_sms') {

            $exam_id    =   $this->input->post('exam_id');
            $class_id   =   $this->input->post('class_id');
            $receiver   =   $this->input->post('receiver');
            if ($exam_id != '' && $class_id != '' && $receiver != '') {
            // get all the students of the selected class
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $class_id,
                    'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
            ))->result_array();
            // get the marks of the student for selected exam
            foreach ($students as $row) {
                if ($receiver == 'student')
                    $receiver_phone = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone;
                if ($receiver == 'parent') {
                    $parent_id =  $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                    if($parent_id != '' || $parent_id != null) {
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $row['parent_id']))->row()->phone;
                        if($receiver_phone == null){
                          $this->session->set_flashdata('error_message' , get_phrase('parent_phone_number_is_not_found'));
                        }
                    }
                }
                $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                $this->db->where('exam_id' , $exam_id);
                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('year', $running_year);
                $marks = $this->db->get('mark')->result_array();

                $message = '';
                foreach ($marks as $row2) {
                    $subject       = $this->db->get_where('subject' , array('subject_id' => $row2['subject_id']))->row()->name;
                    $mark_obtained = $row2['mark_obtained'];
                    $message      .= $row2['student_id'] . $subject . ' : ' . $mark_obtained . ' , ';

                }
                // send sms
                $this->sms_model->send_sms( $message , $receiver_phone );
            }
            $this->session->set_flashdata('flash_message' , get_phrase('message_sent'));
          }
          else{
            $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
          }
            redirect(site_url('admin/exam_marks_sms'), 'refresh');
        }

        $page_data['page_name']  = 'exam_marks_sms';
        $page_data['page_title'] = get_phrase('send_marks_by_sms');
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'dataentry';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }
	
	
	 function marks_manage_app($param='')
    {
       
	  $id = $param;
		if($id==""){
			$id=0;
		}
		
		$school_id = $this->db->get_where("teacher", array("teacher_id"=>$id))->row()->school_id;
		
		
		
		  $this->session->set_userdata('school_id', $school_id);
	   
        $page_data['page_name']  =   'fill';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index2', $page_data);
    }
	

    function marks_manage_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'marks_manage_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    /*function marks_selector()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){
        $query = $this->db->get_where('mark' , array(
                    'exam_id' => $data['exam_id'],
                        'class_id' => $data['class_id'],
                            'section_id' => $data['section_id'],
                                'subject_id' => $data['subject_id'],
                                    'year' => $data['year']
                ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();
            foreach($students as $row) {
                $data['student_id'] = $row['student_id'];
                $this->db->insert('mark' , $data);
            }
        }
        redirect(site_url('admin/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']), 'refresh');
    }
    else{
        $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }
}*/

		function marks_selector()
			{
				if ($this->session->userdata('principal_login') != 1)
					redirect(site_url('login'), 'refresh');

				$data['exam_id']    = $this->input->post('exam_id');
				$data['class_id']   = $this->input->post('class_id');
				$data['section_id'] = $this->input->post('section_id');
				$subje = $this->input->post('subject_id');
				
				$dsubject_id = $this->db->get_where('subject' , array('subject_id'=>$subje))->row()->class_subject;
				$data['subject_id'] =$dsubject_id;
				$data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
				if($data['class_id'] != '' && $data['exam_id'] != ''){
                  $query = $this->db->get_where('mark' , array(
                    'exam_id' => $data['exam_id'],
                        'class_id' => $data['class_id'],
                            'section_id' => $data['section_id'],
                                'subject_id' => $dsubject_id,
                                    'year' => $data['year']
                ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();
            foreach($students as $row) {
                $data['student_id'] = $row['student_id'];
                $this->db->insert('mark' , $data);
            }
        }
					redirect(site_url('admin/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $dsubject_id), 'refresh');
				}
			else{
				$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
				$page_data['page_name']  =   'marks_manage';
				$page_data['page_title'] = get_phrase('manage_exam_marks');
				$this->load->view('backend/index', $page_data);
			}	
				/*
				
			  if($data['class_id'] != '' && $data['exam_id'] != ''){
				$query = $this->db->get_where('mark' , array(
							'exam_id' => $data['exam_id'],
								'class_id' => $data['class_id'],
									'section_id' => $data['section_id'],
										'subject_id' => $dsubject_id,
											'year' => $data['year']
						));
				if($query->num_rows() < 1) {
					$students = $this->db->get_where('enroll' , array(
						'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
					))->result_array();
					foreach($students as $row) {
						$data['student_id'] = $row['student_id'];
						$this->db->insert('mark' , $data);
					}
				}
				
			}
			else{
				$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
				$page_data['page_name']  =   'marks_manage';
				$page_data['page_title'] = get_phrase('manage_exam_marks');
				$this->load->view('backend/index', $page_data);
			}*/
		}


	function get_comments()
	{	
		//$class_id = $this->input->post('class_id');
		
		$class_id = '24'; 
		//$class_id = $this->uri->segment(4);	
		
		$exam_id = $this->input->post('exam_id');
		
		$section_id = $this->input->post('section_id');
		$mark_id = $this->input->post('mark_id');
		$school_id = $this->db->get_where('class' , array('class_id' => $class_id))->row()->school_id;
		$query = $this->db->query("SELECT COMMENT FROM `grade` where $mark_id BETWEEN mark_from AND mark_upto AND school_id =".$school_id);
		$data = $query->result_array();
		$comments = ($data[0]['COMMENT']);
		echo $comments;
		return $comments;
	}

    /*function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
		
        if ($class_id != '' && $exam_id != '') {
		$noti_arr['title'] = 'Add Update Marks';
		$noti_arr['content'] = 'Add Update Marks';
		$noti_arr['type'] = '2';		
		$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
		$noti_arr['creator_role'] = '3';
		$noti_arr['created_on'] = date('Y-m-d h:i:s');	
						
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $marks_of_students = $this->db->get_where('mark' , array(
            'exam_id' => $exam_id,
                'class_id' => $class_id,
                    'section_id' => $section_id,
                        'year' => $running_year,
                            'subject_id' => $subject_id
        ))->result_array();
        foreach($marks_of_students as $row) {
			   // $obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
				//$obtained_marks1 = $this->input->post('mark_obtained1_'.$row['mark_id']);
			   // $obtained_marks2 = $this->input->post('mark_obtained2_'.$row['mark_id']);
			   // $obtained_marks3 = $this->input->post('mark_obtained3_'.$row['mark_id']);
            $comment = $this->input->post('comment_'.$row['mark_id']);
            /*$this->db->where('mark_id' , $row['mark_id']);
			$this->db->update('mark' , array('mark_obtained' => $obtained_marks ,'mark_obtained1' => $obtained_marks1 ,'mark_obtained2' => $obtained_marks2, 'mark_obtained3' => $obtained_marks3,'comment' => $comment));*/
			/*$query = $this->db->query("SELECT * FROM `subject` LEFT JOIN `class_subjects` ON class_subjects.id =subject.class_subject WHERE `subject_id`=$subject_id"); 
			$data = $query->result_array();
			$parts = ($data[0]['parts']);
			if($parts == 2) {
				$obtained_marks1 = $this->input->post('mark_obtained1_'.$row['mark_id']);
				$obtained_marks2 = $this->input->post('mark_obtained2_'.$row['mark_id']);
				$obtained_marks3 = $this->input->post('mark_obtained3_'.$row['mark_id']);
				$comment = $this->input->post('comment_'.$row['mark_id']);
				$total_obtained_mark = $obtained_marks1+$obtained_marks2+$obtained_marks3;
				$obtained_marks_total = ($total_obtained_mark*100/90);
				$obtained_marks_total;
				$this->db->where('mark_id' , $row['mark_id']);
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks ,'mark_obtained1' => $obtained_marks1 ,'mark_obtained2' => $obtained_marks2, 'mark_obtained3' => $obtained_marks3,'comment' => $comment));
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks_total));
			} else {
				
			$obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
			$comment = $this->input->post('comment_'.$row['mark_id']);
            $this->db->where('mark_id' , $row['mark_id']);
			$this->db->update('mark' , array('mark_obtained' => $obtained_marks,'comment' => $comment));
				
			}
			$noti_arr['type_id'] = $row['mark_id'];
			$noti_arr['student_id'] = $student_id = $row['student_id'];	
			$this->db->insert('notifications', $noti_arr);
				
			$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
					
			$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'Add Update Marks');
			
        }
        $this->session->set_flashdata('flash_message' , get_phrase('marks_updated'));
        redirect(site_url('admin/marks_manage_view/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id), 'refresh');
    }
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'marks_manage';
			$page_data['page_title'] = get_phrase('manage_exam_marks');
			$this->load->view('backend/index', $page_data);
		}
	}*/
	
	function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
		
        if ($class_id != '' && $exam_id != '') {
		$noti_arr['title'] = 'Add Update Marks';
		$noti_arr['content'] = 'Add Update Marks';
		$noti_arr['type'] = '2';		
		$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
		$noti_arr['creator_role'] = '3';
		$noti_arr['created_on'] = date('Y-m-d h:i:s');	
						
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $marks_of_students = $this->db->get_where('mark' , array(
            'exam_id' => $exam_id,
                'class_id' => $class_id,
                    'section_id' => $section_id,
                        'year' => $running_year,
                            'subject_id' => $subject_id
        ))->result_array();
        foreach($marks_of_students as $row) {
			   // $obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
				//$obtained_marks1 = $this->input->post('mark_obtained1_'.$row['mark_id']);
			   // $obtained_marks2 = $this->input->post('mark_obtained2_'.$row['mark_id']);
			   // $obtained_marks3 = $this->input->post('mark_obtained3_'.$row['mark_id']);
            $comment = $this->input->post('comment_'.$row['mark_id']);
            /*$this->db->where('mark_id' , $row['mark_id']);
			$this->db->update('mark' , array('mark_obtained' => $obtained_marks ,'mark_obtained1' => $obtained_marks1 ,'mark_obtained2' => $obtained_marks2, 'mark_obtained3' => $obtained_marks3,'comment' => $comment));*/
			$query = $this->db->query("SELECT * FROM `subject` LEFT JOIN `class_subjects` ON class_subjects.id =subject.class_subject WHERE `subject_id`=$subject_id"); 
			$data = $query->result_array();
			$parts = ($data[0]['parts']);
			if($parts == 2) {
				$obtained_marks1 = $this->input->post('mark_obtained1_'.$row['mark_id']);
				$obtained_marks2 = $this->input->post('mark_obtained2_'.$row['mark_id']);
				//$obtained_marks3 = $this->input->post('mark_obtained3_'.$row['mark_id']);
				$comment = $this->input->post('comment_'.$row['mark_id']);
				$total_obtained_mark = $obtained_marks1+$obtained_marks2;
				$obtained_marks_total = ($total_obtained_mark*100/90);
				$obtained_marks_total;
				$this->db->where('mark_id' , $row['mark_id']);
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks ,'mark_obtained1' => $obtained_marks1 ,'mark_obtained2' => $obtained_marks2,'comment' => $comment));
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks_total));
			}elseif ($parts == 3) {
				$obtained_marks1 = $this->input->post('mark_obtained1_'.$row['mark_id']);
				$obtained_marks2 = $this->input->post('mark_obtained2_'.$row['mark_id']);
				$obtained_marks3 = $this->input->post('mark_obtained3_'.$row['mark_id']);
				$comment = $this->input->post('comment_'.$row['mark_id']);
				$total_obtained_mark = $obtained_marks1+$obtained_marks2+$obtained_marks3;
				$obtained_marks_total = ($total_obtained_mark*100/90);
				$obtained_marks_total;
				$this->db->where('mark_id' , $row['mark_id']);
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks ,'mark_obtained1' => $obtained_marks1 ,'mark_obtained2' => $obtained_marks2, 'mark_obtained3' => $obtained_marks3,'comment' => $comment));
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks_total));
			}elseif ($parts == 4) {
				$obtained_marks1 = $this->input->post('mark_obtained1_'.$row['mark_id']);
				$obtained_marks2 = $this->input->post('mark_obtained2_'.$row['mark_id']);
				$obtained_marks3 = $this->input->post('mark_obtained3_'.$row['mark_id']);
				$obtained_marks4 = $this->input->post('mark_obtained4_'.$row['mark_id']);
				$comment = $this->input->post('comment_'.$row['mark_id']);
				$total_obtained_mark = $obtained_marks1+$obtained_marks2+$obtained_marks3+$obtained_marks4;
				$obtained_marks_total = ($total_obtained_mark*100/90);
				$obtained_marks_total;
				$this->db->where('mark_id' , $row['mark_id']);
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks ,'mark_obtained1' => $obtained_marks1 ,'mark_obtained2' => $obtained_marks2, 'mark_obtained3' => $obtained_marks3,'mark_obtained4' => $obtained_marks4,'comment' => $comment));
				$this->db->update('mark' , array('mark_obtained' => $obtained_marks_total));
			}

			else {
			$obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
			$comment = $this->input->post('comment_'.$row['mark_id']);
            $this->db->where('mark_id' , $row['mark_id']);
			$this->db->update('mark' , array('mark_obtained' => $obtained_marks,'comment' => $comment));
				
			}
			$noti_arr['type_id'] = $row['mark_id'];
			$noti_arr['student_id'] = $student_id = $row['student_id'];	
			$this->db->insert('notifications', $noti_arr);
				
			$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
					
			$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'Add Update Marks');
			
        }
        $this->session->set_flashdata('flash_message' , get_phrase('marks_updated'));
        redirect(site_url('admin/marks_manage_view/' . $exam_id . '/' . $class_id . '/' . $section_id . '/' . $subject_id), 'refresh');
    }
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'marks_manage';
			$page_data['page_title'] = get_phrase('manage_exam_marks');
			$this->load->view('backend/index', $page_data);
		}
	}
	
    function marks_get_subject($class_id)
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/marks_get_subject' , $page_data);
    }

    // TABULATION SHEET
    function tabulation_sheet($class_id = '' , $exam_id = '', $section_id = '') {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('admin/tabulation_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('admin/tabulation_sheet'), 'refresh');
            }
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
		$page_data['section_id']   = $section_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'tabulation_sheet';
        $page_data['page_title'] = get_phrase('broad_sheet');
        $this->load->view('backend/index', $page_data);

    }
	//PROCESS EXAM
	function results()
	{
		 if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
	 $page_data['page_name']  = 'processdata';
        $page_data['page_title'] = get_phrase('Results_processing');
        $this->load->view('backend/index', $page_data);	
	}
	
	 function exam_include($param1 = '' , $param2 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');
        $page_data['page_name']  = 'exam_includes';
		$page_data['exam_name'] = $this->db->get_where('openexam', array(
                'form' => str_replace("_"," ",$param1), 'term' =>  str_replace("_"," ",$param2)
            ))->result_array();
        $this->load->view('backend/load', $page_data); 
    }
	  function process_exam($param1 = '' , $param2 = '' , $param3 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');
		
		if ($param1 == 'create') {
			
			$total_score_holder='tm'.trim(str_replace(" ","",$this->input->post('exam')));
						$avg_score_holder=trim(str_replace(" ","",$this->input->post('exam')));
						if(trim($this->input->post('includes')) !== ""){
							$total_score_holder='(SUM(tm'.trim(str_replace(" ","",$this->input->post('exam'))). ') + SUM( tm'.str_replace("+"," ) + SUM(sm",$this->input->post('includes'))."))";
							$avg_score_holder="(SUM(".str_replace(" ","",$this->input->post('exam')). ') + SUM('.str_replace("+",") + SUM(",$this->input->post('includes'))."))";
						}
						$str='CREATE   TRIGGER `main_exam` AFTER INSERT ON `process` FOR EACH ROW BEGIN  
						UPDATE mean_score AS dest, (

SELECT subjects(scores.adm,new.term,new.year,new.form,new.school_id) as s,adm FROM scores 

 ) A SET subno=s WHERE dest.Adm = A.adm;
						
						';
				
					   $str.='UPDATE mean_score as dest,(
					   
					   select '.$avg_score_holder.' as score,'.$total_score_holder.' as mark,adm from mean_score where Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  AND school_id = new.school_id GROUP BY adm) as A
					   
					   SET TotalScore=score,TotalPercent=score,TotalMarks=mark,Grade=rgrade2(score,new.school_id,subno,new.subno) WHERE dest.Adm=A.adm and exam_type=new.exam_main; ';
						
						$str.="SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE mean_score AS dest, (
						SELECT adm AS di,@r2=IF(stream=@stream,1,@rr:=0) AS rank2,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream
						FROM mean_score WHERE Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  AND school_id = new.school_id AND exam_type='".$this->input->post('exam')."' ORDER BY stream, TotalScore DESC
						) AS A SET dest.PosStream=pos  WHERE  dest.Adm=A.di ;
						SET @r6=0;SET @rank = 1; SET @stream=''; SET @sub=''; SET @rnk=1; SET @score=0; SET @rr=0; SET @r3=1; SET @r2='';
						UPDATE mean_score AS dest, (
						SELECT adm AS di,@rr:=@rr+1,
						@rank=IF(TotalScore=@score,@rnk:=@r3,@rnk:=@rr) AS rank,
						@score:=TotalScore,
						@r3:=@rnk AS pos,
						@stream:=stream
						FROM mean_score WHERE Term=new.term AND mean_score.Year=new.Year AND mean_score.Form=new.form  AND school_id = new.school_id AND exam_type='".$this->input->post('exam')."' ORDER BY  TotalScore DESC
						) AS A SET dest.Posclass=pos  WHERE  dest.Adm=A.di  ;";
			
			$str.='    
							END ;

																																																									
						';
						$this->db->query("DROP TRIGGER IF EXISTS `main_exam`");
						$this->db->query($str);
			$exam_to_include=$this->input->post('includes');
			$exam1="";
			if ($exam_to_include != ''){
				 $data['exam1'] = $exam_to_include;
				if(strpos($exam_to_include,"+") != false){
					$exam1 = explode("+",$exam_to_include);
					 $data['exam1'] = $exam1[0];
					  $data['exam2'] =  $exam1[1];
				}
				
			}
            $data['form']               =   $this->input->post('form');
            $data['term'] =   $this->input->post('term');
            $data['subno']         =   $this->input->post('subjectno');
            $data['exam_main']        =   $this->input->post('exam');
            $data['includes']              =   $this->input->post('includes');
            $data['year']              =   $this->input->post('year');
            $this->db->insert('process' , $data); 
			
			echo 1;
			
			
        }
		
       
    }
	
	
	//BROAD SHEET
	function broadsheet()
	{
		 if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
	 $page_data['page_name']  = 'broadsheet';
        $page_data['page_title'] = get_phrase('Broadsheet');
        $this->load->view('backend/index', $page_data);	
	}
	
	function printsheet()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$class		=	$this->input->post('form');
		$main_exam	=	strtolower($this->input->post('exam'));
		if($stream != ''){
		$page_data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->result_array();
		}else{
			$page_data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$stream))->result_array();
		}
		$page_data['exam1']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam1;
		
		$page_data['exam2']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam2;
		
		$page_data['class']= $class;
		$page_data['year']= $year;
		$page_data['term']= $term;
		$page_data['cutoff']= $cutoff;
		$page_data['stream']= $stream;
		$page_data['main_exam']= $main_exam;
        $page_data['page_name']  = 'print_sheet';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/load', $page_data);
		
    }
	
	function broad_sheet()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$class		=	$this->input->post('form');
		$main_exam	=	strtolower($this->input->post('exam'));
		if($stream != ''){
		$page_data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->result_array();
		}else{
			$page_data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$stream))->result_array();
		}
		$page_data['exam1']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam1;
		
		$page_data['exam2']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam2;
		$page_data['cutoff']= $cutoff;
		$page_data['class']= $class;
		$page_data['year']= $year;
		$page_data['term']= $term;
		$page_data['stream']= $stream;
		$page_data['main_exam']= $main_exam;
        $page_data['page_name']  = 'broad_sheet';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/load', $page_data);
		
    }
	
	
	
	function tabulation_sheet_blank($class_id = '' , $exam_id = '', $section_id = '') {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('admin/tabulation_sheet_blank/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('admin/tabulation_sheet_blank'), 'refresh');
            }
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
		$page_data['section_id']   = $section_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'tabulation_sheet_blank';
        $page_data['page_title'] = get_phrase('broad_sheet_blank');
        $this->load->view('backend/index', $page_data);

    }
	
	
	

    function tabulation_sheet_print_view($class_id , $exam_id, $section_id) {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['class_id'] = $class_id;
		$page_data['section_id']  = $section_id;
        $page_data['exam_id']  = $exam_id;
        $this->load->view('backend/principal/tabulation_sheet_print_view' , $page_data);
    }
		//

    /****MANAGE GRADES*****/
    function grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
			$data['school_id']   = $school_id;
            $this->db->insert('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/grade'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['mark_from']   = $this->input->post('mark_from');
            $data['mark_upto']   = $this->input->post('mark_upto');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
            else{
              $data['comment'] = null;
            }

            $this->db->where('grade_id', $param2);
            $this->db->update('grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/grade'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('grade', array(
                'grade_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('grade_id', $param2);
            $this->db->delete('grade');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/grade'), 'refresh');
        }
        $page_data['grades'] = $this->db->get_where('grade', array('school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'grade';
        $page_data['page_title'] = get_phrase('manage_grade');
        $this->load->view('backend/index', $page_data);
    }

    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {

            if($this->input->post('class_id') != null){
               $data['class_id']       = $this->input->post('class_id');
            }
			
            $data['section_id']     = $this->input->post('section_id');
            $data['subject_id']     = $this->input->post('subject_id');
			$data['day']     = $this->input->post('day');
			$data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
			$array_string_period = json_decode($this->input->post('ms1'));
			
				foreach($array_string_period as $value)
				{
					if(count($array_string_period) == 1)
					{
						$data['type']     = 'S';
					}else
					{
						$data['type']     = 'M';
					}
					
					$data['period']     = $value;	
					
		
					$teacher_id_get = $this->db->get_where('subject' , array('subject_id' => $data['subject_id']))->row()->teacher_id;				
					$array = array(
					   'class_id'      => $data['class_id'],
					   'section_id'    => $data['section_id'],
					   'subject_id'      => $data['subject_id'],
					   'period'    => $data['period'],
					   'teacher_id' => $teacher_id_get,
					   'type'    => $data['type'],
					   'day'           => $data['day'],
					   'year'          => $data['year']
					); 
					$data['teacher_id']     = $teacher_id_get;	
					$validation = duplication_of_class_timetable_on_create($array);	
						if ($validation == 1) {
							
							//Check the available period for on the same day and same section Start.
							$check_period_exists = period_exists($array);	
							if($check_period_exists == 1)
							{
								$check_teacher_exists = teacher_check_exists($array);	
								if ($check_teacher_exists == 1) {
									$this->db->insert('class_routine_time_table', $data);
									$this->session->set_flashdata('flash_message' , get_phrase('TimeTable Period Added_successfully...'));
								}else
								{
									$this->session->set_flashdata('error_message' , get_phrase('Conflicts with same subject  and selected subject already exists in that different section Day'));
								}
							}else
							{
								$this->session->set_flashdata('error_message' , get_phrase('Selected Period already added for other subjects on the same day'));
							}
							//Check the available period for on the same day and same section End...
						}else{
							
							//Check the teacher whether they have already allocated for the selected day and period to other stream...
								$check_teacher_exists = teacher_check_exists($array);	
								if ($check_teacher_exists == 1) {
									$this->db->insert('class_routine_time_table', $data);
									$this->session->set_flashdata('flash_message' , get_phrase('TimeTable Period Added_successfully...'));
								}else
								{
									$this->session->set_flashdata('error_message' , get_phrase('Conflicts with same subject  and selected subject already exists in that Day'));
								}
						}				
				}
            redirect(site_url('admin/class_routine_add'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['class_id']       = $this->input->post('class_id');
            if($this->input->post('section_id') != '') {
                $data['section_id'] = $this->input->post('section_id');
            }
			
			$data['type']  = $this->input->post('type');
            $data['subject_id']     = $this->input->post('subject_id');
			$data['break_title']     = $this->input->post('break_title');

            // 12 AM for starting time
            if ($this->input->post('time_start') == 12 && $this->input->post('starting_ampm') == 1) {
                $data['time_start'] = 24;
            }
            // 12 PM for starting time
            else if ($this->input->post('time_start') == 12 && $this->input->post('starting_ampm') == 2) {
                $data['time_start'] = 12;
            }
            // otherwise for starting time
            else{
                $data['time_start']     = $this->input->post('time_start') + (12 * ($this->input->post('starting_ampm') - 1));
            }
            // 12 AM for ending time
            if ($this->input->post('time_end') == 12 && $this->input->post('ending_ampm') == 1) {
                $data['time_end'] = 24;
            }
            // 12 PM for ending time
            else if ($this->input->post('time_end') == 12 && $this->input->post('ending_ampm') == 2) {
                $data['time_end'] = 12;
            }
            // otherwise for ending time
            else{
                $data['time_end']       = $this->input->post('time_end') + (12 * ($this->input->post('ending_ampm') - 1));
            }

            $data['time_start_min'] = $this->input->post('time_start_min');
            $data['time_end_min']   = $this->input->post('time_end_min');
            $data['day']            = $this->input->post('day');
            $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($data['subject_id'] != '' || $data['break_title'] !='') {
            // checking duplication
            $array = array(
               'section_id'    => $data['section_id'],
               'class_id'      => $data['class_id'],
               'time_start'    => $data['time_start'],
               'time_end'      => $data['time_end'],
               'time_start_min'=> $data['time_start_min'],
               'time_end_min'  => $data['time_end_min'],
               'day'           => $data['day'],
               'year'          => $data['year']
            );
            $validation = duplication_of_class_routine_on_edit($array, $param2);

            if ($validation == 1) {
                $this->db->where('class_routine_id', $param2);
                $this->db->update('class_routine', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('time_conflicts'));
            }
          }
          else{
            $this->session->set_flashdata('error_message' , get_phrase('subject_is_not_found'));
          }

            redirect(site_url('admin/class_routine_view/' . $data['class_id']), 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('class_routine', array(
                'class_routine_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $class_id = $this->db->get_where('class_routine' , array('class_routine_id' => $param2))->row()->class_id;
            $this->db->where('class_routine_id', $param2);
            $this->db->delete('class_routine');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/class_routine_view/' . $class_id), 'refresh');
        }

    }

    function class_routine_add()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'class_routine_add';
        $page_data['page_title'] = get_phrase('add_stream_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_view($class_id)
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'class_routine_view';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('stream_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->load->view('backend/admin/class_routine_print_view' , $page_data);
    }

    function get_class_section_subject($class_id='')
    {
        $page_data['class_id'] = $class_id;		 
        $this->load->view('backend/admin/class_routine_section_subject_selector' , $page_data);
    }
	
	function get_class_section_selector($class_id='')
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/section_selector' , $page_data);
    }
	
	function get_class_section_selector_elective($class_id='')
    {
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/admin/section_selector' , $page_data);
    }

    function section_subject_edit($class_id , $class_routine_id)
    {
        $page_data['class_id']          =   $class_id;
        $page_data['class_routine_id']  =   $class_routine_id;
        $this->load->view('backend/admin/class_routine_section_subject_edit' , $page_data);
    }
	
	function section_edit($class_id, $subject_id)
    {
        $page_data['class_id']          =   $class_id;     
		$page_data['subject_id']          =   $subject_id; 
        $this->load->view('backend/admin/section_selector_edit' , $page_data);
    }

    function manage_attendance()
    {
        if($this->session->userdata('principal_login')!=1)
            redirect(site_url('login'), 'refresh');

        $page_data['page_name']  =  'manage_attendance';
        $page_data['page_title'] =  get_phrase('manage_attendance_of_stream');
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '' , $section_id = '' , $timestamp = '')
    {
        if($this->session->userdata('principal_login')!=1)
            redirect(site_url('login'), 'refresh');

        $class_name = $this->db->get_where('class' , array(
            'class_id' => $class_id
        ))->row()->name;
        $page_data['class_id'] = $class_id;
        $page_data['timestamp'] = $timestamp;
        $page_data['page_name'] = 'manage_attendance_view';
        $section_name = $this->db->get_where('section' , array(
            'section_id' => $section_id
        ))->row()->name;
        $page_data['section_id'] = $section_id;
        $page_data['page_title'] = get_phrase('manage_attendance_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $this->load->view('backend/index', $page_data);
    }
    function get_section($class_id) {
          $page_data['class_id'] = $class_id;
          $this->load->view('backend/admin/manage_attendance_section_holder' , $page_data);
    }
    function attendance_selector()
    {
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');
        $data['timestamp']  = strtotime($this->input->post('timestamp'));
        $data['section_id'] = $this->input->post('section_id');
        $query = $this->db->get_where('attendance' ,array(
            'class_id'=>$data['class_id'],
                'section_id'=>$data['section_id'],
                    'year'=>$data['year'],
                        'timestamp'=>$data['timestamp']
        ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();

            foreach($students as $row) {
                $attn_data['class_id']   = $data['class_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
                $attn_data['section_id'] = $data['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $this->db->insert('attendance' , $attn_data);
            }

        }
        redirect(site_url('admin/manage_attendance_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['timestamp']),'refresh');
    }

    function attendance_update($class_id = '' , $section_id = '' , $timestamp = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
        $attendance_of_students = $this->db->get_where('attendance' , array(
            'class_id'=>$class_id,'section_id'=>$section_id,'year'=>$running_year,'timestamp'=>$timestamp
        ))->result_array();
        foreach($attendance_of_students as $row) {
            $attendance_status = $this->input->post('status_'.$row['attendance_id']);
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('attendance' , array('status' => $attendance_status));

            if ($attendance_status == 2) {

                if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                    $student_name   = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
                    $parent_id      = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                    $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                    if($parent_id != null && $parent_id != 0){
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                        if($receiver_phone != '' || $receiver_phone != null){
                            $this->sms_model->send_sms($message,$receiver_phone);
                        }
                        else{
                            $this->session->set_flashdata('error_message' , get_phrase('parent_phone_number_is_not_found'));
                        }
                    }
                    else{
                        $this->session->set_flashdata('error_message' , get_phrase('parent_phone_number_is_not_found'));
                    }
                }
            }
        }
        $this->session->set_flashdata('flash_message' , get_phrase('attendance_updated'));
        redirect(site_url('admin/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$timestamp) , 'refresh');
    }

	/****** DAILY ATTENDANCE *****************/
	function manage_attendance2($date='',$month='',$year='',$class_id='' , $section_id = '' , $session = '')
	{
		if($this->session->userdata('principal_login')!=1)
            redirect(site_url('login') , 'refresh');

        $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;


		if($_POST)
		{
			// Loop all the students of $class_id
            $this->db->where('class_id' , $class_id);
            if($section_id != '') {
                $this->db->where('section_id' , $section_id);
            }
            //$session = base64_decode( urldecode( $session ) );
            $this->db->where('year' , $session);
            $students = $this->db->get('enroll')->result_array();
            foreach ($students as $row)
            {
                $attendance_status  =   $this->input->post('status_' . $row['student_id']);

                $this->db->where('student_id' , $row['student_id']);
                $this->db->where('date' , $date);
                $this->db->where('year' , $year);
                $this->db->where('class_id' , $row['class_id']);
                if($row['section_id'] != '' && $row['section_id'] != 0) {
                    $this->db->where('section_id' , $row['section_id']);
                }
                $this->db->where('session' , $session);

                $this->db->update('attendance' , array('status' => $attendance_status));

                if ($attendance_status == 2) {

                    if ($active_sms_service != '' || $active_sms_service != 'disabled') {
                        $student_name   = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;
                        $parent_id      = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->parent_id;
                        $receiver_phone = $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->phone;
                        $message        = 'Your child' . ' ' . $student_name . 'is absent today.';
                        $this->sms_model->send_sms($message,$receiver_phone);
                    }
                }

            }

			$this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
			redirect(site_url('admin/manage_attendance/'.$date.'/'.$month.'/'.$year.'/'.$class_id.'/'.$section_id.'/'.$session) , 'refresh');
		}
        $page_data['date']       =	$date;
        $page_data['month']      =	$month;
        $page_data['year']       =	$year;
        $page_data['class_id']   =  $class_id;
        $page_data['section_id'] =  $section_id;
        $page_data['session']    =  $session;

        $page_data['page_name']  =	'manage_attendance';
        $page_data['page_title'] =	get_phrase('manage_daily_attendance');
		$this->load->view('backend/index', $page_data);
	}
	function attendance_selector2()
	{
        //$session = $this->input->post('session');
        //$encoded_session = urlencode( base64_encode( $session ) );
		redirect(site_url('admin/manage_attendance/'.$this->input->post('date').'/'.
					$this->input->post('month').'/'.
						$this->input->post('year').'/'.
							$this->input->post('class_id').'/'.
                                $this->input->post('section_id').'/'.
                                    $this->input->post('session')) , 'refresh');
	}
        ///////ATTENDANCE REPORT /////
     function attendance_report() {
         $page_data['month']        = date('m');
         $page_data['page_name']    = 'attendance_report';
         $page_data['page_title']   = get_phrase('attendance_report');
         $this->load->view('backend/index',$page_data);
     }
     function attendance_report_view($class_id = '', $section_id = '', $month = '', $sessional_year = '')
     {
         if($this->session->userdata('principal_login')!=1)
            redirect(base_url() , 'refresh');

        $class_name                     = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
        $section_name                   = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
        $page_data['class_id']          = $class_id;
        $page_data['section_id']        = $section_id;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $page_data['page_name']         = 'attendance_report_view';
        $page_data['page_title']        = get_phrase('attendance_report_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name;
        $this->load->view('backend/index', $page_data);
     }
     function attendance_report_print_view($class_id ='' , $section_id = '' , $month = '', $sessional_year = '') {
          if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['class_id']          = $class_id;
        $page_data['section_id']        = $section_id;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $this->load->view('backend/admin/attendance_report_print_view' , $page_data);
    }

    function attendance_report_selector()
    {   if($this->input->post('class_id') == '' || $this->input->post('sessional_year') == '') {
            $this->session->set_flashdata('error_message' , get_phrase('please_make_sure_class_and_sessional_year_are_selected'));
            redirect(site_url('admin/attendance_report'), 'refresh');
        }
        $data['class_id']       = $this->input->post('class_id');
        $data['section_id']     = $this->input->post('section_id');
        $data['month']          = $this->input->post('month');
        $data['sessional_year'] = $this->input->post('sessional_year');
        redirect(site_url('admin/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'] . '/' . $data['sessional_year']), 'refresh');
    }

    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
			$data['school_id']         = $school_id;
            $data['student_id']         = $this->input->post('student_id');
			$data['term_id']              = $this->input->post('tid');
            $data['title']              = $this->input->post('title');
            $data['amount']             = $this->input->post('amount');
            $data['amount_paid']        = $this->input->post('amount_paid');
            $data['due']  = ($data['amount_paid'] >0)?$data['amount'] - $data['amount_paid']:$data['amount'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));
            $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']    = $this->input->post('description');
            }

            $this->db->insert('invoice', $data);
            $invoice_id = $this->db->insert_id();
			
			if($data['amount_paid'] >0){

				$data2['invoice_id']        =   $invoice_id;
				$data2['student_id']        =   $this->input->post('student_id');
				$data2['title']             =   $this->input->post('title');
				$data2['payment_type']      =  'income';
				//$data2['method']            =   $this->input->post('method');
				$data2['amount']            =   $this->input->post('amount_paid');
				$data2['timestamp']         =   strtotime($this->input->post('date'));
				$data2['year']              =  $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
				if ($this->input->post('description') != null) {
					$data2['description']    = $this->input->post('description');
				}
				$this->db->insert('payment' , $data2);
			}

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/student_payment'), 'refresh');
        }

        if ($param1 == 'create_mass_invoice') {
            foreach ($this->input->post('student_id') as $id) {

				$data['school_id']         = $school_id;
                $data['student_id']         = $id;
				$data['term_id']              = $this->input->post('tmid');
                $data['title']              = $this->input->post('title');
                $data['description']        = $this->input->post('description');
                $data['amount']             = $this->input->post('amount');
                $data['amount_paid']        = $this->input->post('amount_paid');
				
                $data['due']  = ($data['amount_paid'] >0)?$data['amount'] - $data['amount_paid']:$data['amount'];
                $data['status']             = $this->input->post('status');
                $data['creation_timestamp'] = strtotime($this->input->post('date'));
                $data['year']               = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

                $this->db->insert('invoice', $data);
                $invoice_id = $this->db->insert_id();

				if($data['amount_paid'] >0){
					$data2['invoice_id']        =   $invoice_id;
					$data2['student_id']        =   $id;
					$data2['title']             =   $this->input->post('title');
					$data2['description']       =   $this->input->post('description');
					$data2['payment_type']      =  'income';
					//$data2['method']            =   $this->input->post('method');
					$data2['amount']            =   $this->input->post('amount_paid');
					$data2['timestamp']         =   strtotime($this->input->post('date'));
					$data2['year']               =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

					$this->db->insert('payment' , $data2); 
				}
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/student_payment'), 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['student_id']         = $this->input->post('student_id');		 
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['amount']             = $this->input->post('amount');
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = strtotime($this->input->post('date'));

            $this->db->where('invoice_id', $param2);
            $this->db->update('invoice', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/income'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('invoice', array(
                'invoice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'take_payment') {
            $data['invoice_id']   =   $this->input->post('invoice_id');
            $data['student_id']   =   $this->input->post('student_id');
            $data['title']        =   $this->input->post('title');
            $data['description']  =   $this->input->post('description');
            $data['payment_type'] =   'income';
            $data['method']       =   $this->input->post('method');
            $data['amount']       =   $this->input->post('amount');
            $data['timestamp']    =   strtotime($this->input->post('timestamp'));
			$data['paid_date']    =   date('Y-m-d',strtotime($this->input->post('timestamp')));
            $data['year']         =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            $this->db->insert('payment' , $data);

            $status['status']   =   $this->input->post('status');
            $this->db->where('invoice_id' , $param2);
            $this->db->update('invoice' , array('status' => $status['status']));

            $data2['amount_paid']   =   $this->input->post('amount');
            $data2['status']        =   $this->input->post('status');
            $this->db->where('invoice_id' , $param2);
            $this->db->set('amount_paid', 'amount_paid + ' . $data2['amount_paid'], FALSE);
            $this->db->set('due', 'due - ' . $data2['amount_paid'], FALSE);
            $this->db->update('invoice');

            $this->session->set_flashdata('flash_message' , get_phrase('payment_successfull'));
            redirect(site_url('admin/income'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('invoice_id', $param2);
            $this->db->delete('invoice');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/income'), 'refresh');
        }
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**********ACCOUNTING********************/
    function income($param1 = 'invoices' , $param2 = '')
    {
       if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param2 == 'filter_history')
            $page_data['student_id'] = $this->input->post('student_id');
        else
            $page_data['student_id'] = 'all';

        $page_data['page_name']  = 'income';
        $page_data['page_title'] = get_phrase('student_payments');
        $this->db->order_by('creation_timestamp', 'desc');
        $page_data['invoices'] = $this->db->get('invoice')->result_array();
        $page_data['active_tab']  = $param1;
        $this->load->view('backend/index', $page_data);
    }

    function student_payment($param1 = '' , $param2 = '' , $param3 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'student_payment';
        $page_data['page_title'] = get_phrase('create_student_payment');
        $this->load->view('backend/index', $page_data);
    }

    function expense($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']     =   $this->input->post('description');
            }
            $this->db->insert('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/expense'), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['title']               =   $this->input->post('title');
            $data['expense_category_id'] =   $this->input->post('expense_category_id');
            $data['payment_type']        =   'expense';
            $data['method']              =   $this->input->post('method');
            $data['amount']              =   $this->input->post('amount');
            $data['timestamp']           =   strtotime($this->input->post('timestamp'));
            $data['year']                =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($this->input->post('description') != null) {
                $data['description']     =   $this->input->post('description');
            }
            else{
                $data['description']     =   null;
            }
            $this->db->where('payment_id' , $param2);
            $this->db->update('payment' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/expense'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('payment_id' , $param2);
            $this->db->delete('payment');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/expense'), 'refresh');
        }

        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = get_phrase('expenses');
        $this->load->view('backend/index', $page_data);
    }

    function expense_category($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']   =   $this->input->post('name');
            $this->db->insert('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/expense_category'), 'refresh');
        }
        if ($param1 == 'edit') {
            $data['name']   =   $this->input->post('name');
            $this->db->where('expense_category_id' , $param2);
            $this->db->update('expense_category' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/expense_category'), 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('expense_category_id' , $param2);
            $this->db->delete('expense_category');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/expense_category'), 'refresh');
        }

        $page_data['page_name']  = 'expense_category';
        $page_data['page_title'] = get_phrase('expense_category');
        $this->load->view('backend/index', $page_data);
    }

    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');
            $data['class_id']    = $this->input->post('class_id');
            if ($this->input->post('description') != null) {
               $data['description'] = $this->input->post('description');
            }
            if ($this->input->post('price') != null) {
               $data['price'] = $this->input->post('price');
            }
            if ($this->input->post('author') != null) {
               $data['author'] = $this->input->post('author');
            }
            if(!empty($_FILES["file_name"]["name"])) {
                $data['file_name'] = $_FILES["file_name"]["name"];
            }

            $this->db->insert('book', $data);

            if(!empty($_FILES["file_name"]["name"])) {
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" . $_FILES["file_name"]["name"]);
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/book'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');
            $data['class_id']    = $this->input->post('class_id');
            if ($this->input->post('description') != null) {
               $data['description'] = $this->input->post('description');
            }
            else{
               $data['description'] = null;
            }
            if ($this->input->post('price') != null) {
               $data['price'] = $this->input->post('price');
            }
            else{
                $data['price'] = null;
            }
            if ($this->input->post('author') != null) {
               $data['author'] = $this->input->post('author');
            }
            else{
               $data['author'] = null;
            }

            if(!empty($_FILES["file_name"]["name"])) {
                $data['file_name'] = $_FILES["file_name"]["name"];
            }

            $this->db->where('book_id', $param2);
            $this->db->update('book', $data);

            if(!empty($_FILES["file_name"]["name"])) {
                move_uploaded_file($_FILES["file_name"]["tmp_name"], "uploads/document/" . $_FILES["file_name"]["name"]);
            }

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/book'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('book', array(
                'book_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('book_id', $param2);
            $this->db->delete('book');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/book'), 'refresh');
        }
        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/
    function transport($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');
        if ($param1 == 'create') {
            $data['route_name']        = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            if ($this->input->post('description') != null) {
               $data['description']    = $this->input->post('description');
            }
            if ($this->input->post('route_fare') != null) {
               $data['route_fare']     = $this->input->post('route_fare');
            }

            $this->db->insert('transport', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/transport'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['route_name']        = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            if ($this->input->post('description') != null) {
               $data['description']    = $this->input->post('description');
            }
            else{
                $data['description'] = null;
            }
            if ($this->input->post('route_fare') != null) {
               $data['route_fare']   = $this->input->post('route_fare');
            }
            else{
                $data['route_fare']  = null;
            }

            $this->db->where('transport_id', $param2);
            $this->db->update('transport', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/transport'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('transport', array(
                'transport_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('transport_id', $param2);
            $this->db->delete('transport');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/transport'), 'refresh');
        }
        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE DORMITORY / HOSTELS / ROOMS ********************/
    function dormitory($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
            $data['name']           = $this->input->post('name');
            $data['number_of_room'] = $this->input->post('number_of_room');
            if ($this->input->post('description') != null) {
                $data['description']    = $this->input->post('description');
            }

            $this->db->insert('dormitory', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/dormitory'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']           = $this->input->post('name');
            $data['number_of_room'] = $this->input->post('number_of_room');
            if ($this->input->post('description') != null) {
                $data['description']    = $this->input->post('description');
            }
            else{
                $data['description'] = null;
            }
            $this->db->where('dormitory_id', $param2);
            $this->db->update('dormitory', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/dormitory'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('dormitory', array(
                'dormitory_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('dormitory_id', $param2);
            $this->db->delete('dormitory');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/dormitory'), 'refresh');
        }
        $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
        $page_data['page_name']   = 'dormitory';
        $page_data['page_title']  = get_phrase('manage_dormitory');
        $this->load->view('backend/index', $page_data);

    }

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
			$data['tags']           = $this->input->post('tags');
			$data['type']           = $this->input->post('type');            
			$data['school_id']     =  $school_id;
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
			$data['date'] = date('Y-m-d',$data['create_timestamp']);
			$data['created_by'] = $this->session->userdata('login_user_id');
			$data['created_at'] = date('Y-m-d h:i:s');
            if ($_FILES['image']['name'] != '') {
              $data['image']  = $_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/frontend/noticeboard/'. $_FILES['image']['name']);
            }
            $this->db->insert('noticeboard', $data);
			
			$noticeboard_id = $this->db->insert_id();
			
			$noti_arr['title'] = 'New Announcement';
			$noti_arr['content'] = 'New Announcement';
			$noti_arr['type'] = '14';
			$noti_arr['type_id'] = $noticeboard_id;
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			$classes = $this->db->get_where('class', array('school_id' => $school_id))->result_array();
            foreach ($classes as $crow)
            {
			
				$students = $this->db->get_where('enroll', array('class_id' => $crow['class_id']))->result_array();
				
				foreach ($students as $row)
				{				
					$noti_arr['student_id'] = $student_id = $row['student_id'];
					$this->db->insert('notifications', $noti_arr);	 		
					
					$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
						
					$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'New Announcement');
				}	
			}			

            /*$check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('student')->result_array();
                $teachers = $this->db->get('teacher')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            }*/

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/noticeboard'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $image = $this->db->get_where('noticeboard', array('notice_id' => $param2))->row()->image;
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
			$data['tags']           = $this->input->post('tags');
			$data['type']           = $this->input->post('type');            
			$data['school_id']     =  $school_id;
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
			$data['date'] = date('Y-m-d',$data['create_timestamp']);
			 	
            if ($_FILES['image']['name'] != '') {
              $data['image']  = $_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/frontend/noticeboard/'. $_FILES['image']['name']);
            } else {
              $data['image']  = $image;
            }

            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);

            /*$check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {
                // sms sending configurations

                $parents  = $this->db->get('parent')->result_array();
                $students = $this->db->get('student')->result_array();
                $teachers = $this->db->get('teacher')->result_array();
                $date     = $this->input->post('create_timestamp');
                $message  = $data['notice_title'] . ' ';
                $message .= get_phrase('on') . ' ' . $date;
                foreach($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($students as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
                foreach($teachers as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message , $reciever_phone);
                }
            } */

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/noticeboard'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/noticeboard'), 'refresh');
        }
        if ($param1 == 'mark_as_archive') {
            $this->db->where('notice_id' , $param2);
            $this->db->update('noticeboard' , array('status' => 0));
            redirect(site_url('admin/noticeboard'), 'refresh');
        }

        if ($param1 == 'remove_from_archived') {
            $this->db->where('notice_id' , $param2);
            $this->db->update('noticeboard' , array('status' => 1));
            redirect(site_url('admin/noticeboard'), 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('announcements');
        $this->load->view('backend/index', $page_data);
    }

    function noticeboard_edit($notice_id) {
      if ($this->session->userdata('principal_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'noticeboard_edit';
      $page_data['notice_id'] = $notice_id;
      $page_data['page_title'] = get_phrase('edit_notice');
      $this->load->view('backend/index', $page_data);
    }

    function reload_noticeboard() {
        $this->load->view('backend/admin/noticeboard');
    }
	
	function media($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
		$user_id = $this->session->userdata('login_user_id'); 
		$login_type = $this->session->userdata('login_type');

        var_dump($param1); exit();

        if ($param1 == 'create') {
            $data['title']  = $this->input->post('title');
			$data['class_id']  = $this->input->post('class_id');
			$data['section_id']  = $this->input->post('section_id');
            $data['details']  = $this->input->post('details');    
			$data['type_id']  = $this->input->post('type_id');  
			$data['user_id']  = $user_id; 
			$data['role_id']  = 3;
            if ($_FILES['media']['name'] != '') {
				$timestamp = strtotime(date("Y-m-d H:i:s"));				
				$directory = "uploads/media/$timestamp"."-$user_id". $_FILES['media']['name'];
				$data['file_name']  = $_FILES['media']['name'];
				move_uploaded_file($_FILES['media']['tmp_name'], $directory);
				$data['path']  = 'http://apps.classteacher.school/'.$directory;
            }

            $this->db->insert('media', $data);     

			$media_id = $this->db->insert_id();
			
			if($data['type_id'] == 1){
				$noti_arr['title'] = 'Add Document';
				$noti_arr['content'] = 'Add Document';
				$noti_arr['type'] = '8';
			}
			elseif($data['type_id'] == 2){
				$noti_arr['title'] = 'Add Photo';
				$noti_arr['content'] = 'Add Photo';
				$noti_arr['type'] = '9';
			}
			elseif($data['type_id'] == 3){
				$noti_arr['title'] = 'Add Video';
				$noti_arr['content'] = 'Add Video';
				$noti_arr['type'] = '10';
			}
			$noti_arr['type_id'] = $media_id;
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			if($data['class_id'] > 0){
				$classes = $this->db->get_where('class', array('class_id' => $data['class_id']))->result_array();
				
			}else{
				$classes = $this->db->get_where('class', array('school_id' => $school_id))->result_array();
			}
			
			
            foreach ($classes as $crow)
            {
				if($data['section_id'] >0){
					
					$students = $this->db->get_where('enroll', array('class_id' => $crow['class_id'],'section_id' => $data['section_id']))->result_array();
					
				}else{
					
					$students = $this->db->get_where('enroll', array('class_id' => $crow['class_id']))->result_array();
				}
				
				foreach ($students as $row)
				{				
					$noti_arr['student_id'] = $student_id = $row['student_id'];
					$this->db->insert('notifications', $noti_arr);	 		
					
					$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
						
					$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,$noti_arr['title']);
				}	
			}

            $this->session->set_flashdata('flash_message' , get_phrase('media_added_successfully'));
            redirect(site_url('admin/media'), 'refresh');
        }
        if ($param1 == 'do_update') {
           
            $data['title']  = $this->input->post('title');
			$data['class_id']  = $this->input->post('class_id');
			$data['section_id']  = $this->input->post('section_id');
            $data['details']  = $this->input->post('details');
			$data['type_id']  = $this->input->post('type_id');  
                      
            if ($_FILES['media']['name'] != '') {
				$timestamp = strtotime(date("Y-m-d H:i:s"));				
				$directory = "uploads/media/$timestamp"."-$user_id". $_FILES['media']['name'];
				$data['file_name']  = $_FILES['media']['name'];
				move_uploaded_file($_FILES['media']['tmp_name'], $directory);
				$data['path']  = 'http://apps.classteacher.school/'.$directory;
            } 

            $this->db->where('id', $param2);
            $this->db->update('media', $data);             

            $this->session->set_flashdata('flash_message' , get_phrase('media_updated'));
            redirect(site_url('admin/media'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('media', array('id' => $param2))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('media');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/media'), 'refresh');
        }
        
        $page_data['page_name']  = 'media';
        $page_data['page_title'] = get_phrase('medias');
        $this->load->view('backend/index', $page_data);
    }

    function media_edit($media_id) {
      if ($this->session->userdata('principal_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'media_edit';
      $page_data['media_id'] = $media_id;
      $page_data['page_title'] = get_phrase('edit_media');
      $this->load->view('backend/index', $page_data);
    }

    function reload_media() {
        $this->load->view('backend/admin/media');
    }	
	
	
	function events($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
			echo"<div style='text-align:center;'><img src='http://apps.classteacher.school/uploads/event.gif' /></div><br>";
			echo"<div style='text-align:center;'>Event are Adding...</div>";
            $data['title']     = $this->input->post('title');
            $data['details']           = $this->input->post('details');          
			$data['school_id']     =  $school_id;
            $data['date'] = date('Y-m-d',strtotime($this->input->post('create_timestamp')));
            if ($_FILES['image']['name'] != '') {
              $data['image']  = $_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/events/'. $_FILES['image']['name']);
            }
            $this->db->insert('events', $data);
			$event_id = $this->db->insert_id();
			
			$noti_arr['title'] = 'New Event';
			$noti_arr['content'] = 'New Event';
			$noti_arr['type'] = '7';
			$noti_arr['type_id'] = $event_id;
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			$classes = $this->db->get_where('class', array('school_id' => $school_id))->result_array();
            foreach ($classes as $crow)
            {
			
				$students = $this->db->get_where('enroll', array('class_id' => $crow['class_id']))->result_array();
				
				foreach ($students as $row)
				{				
					$noti_arr['student_id'] = $student_id = $row['student_id'];
					$this->db->insert('notifications', $noti_arr);	 		
					
					$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
						
					$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'New Event');
				}	
			}
			 
            $this->session->set_flashdata('flash_message' , get_phrase('event_added_successfully'));
            redirect(site_url('admin/events'), 'refresh');
        }
        if ($param1 == 'do_update') {
            
            $data['title']     = $this->input->post('title');
            $data['details']           = $this->input->post('details');            
			$data['school_id']     =  $school_id;
            $data['date'] = date('Y-m-d',strtotime($this->input->post('create_timestamp')));
            if ($_FILES['image']['name'] != '') {
              $data['image']  = $_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/events/'. $_FILES['image']['name']);
            } 

            $this->db->where('id', $param2);
            $this->db->update('events', $data);
 
            $this->session->set_flashdata('flash_message' , get_phrase('event_updated'));
            redirect(site_url('admin/events'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('events', array(
                'id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('events');
            $this->session->set_flashdata('flash_message' , get_phrase('event_deleted'));
            redirect(site_url('admin/events'), 'refresh');
        }
        
        $page_data['page_name']  = 'events';
        $page_data['page_title'] = get_phrase('events');
        $this->load->view('backend/index', $page_data);
    }

    function event_edit($event_id) {
      if ($this->session->userdata('principal_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'event_edit';
      $page_data['event_id'] = $event_id;
      $page_data['page_title'] = get_phrase('edit_event');
      $this->load->view('backend/index', $page_data);
    }

    function reload_events() {
        $this->load->view('backend/admin/noticeboard');
    }
	
    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        /*if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');*/
        $max_size = 2097152;
        if ($param1 == 'send_new') {
            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                redirect(site_url('admin/message/message_new'), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }

            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('admin/message/message_read/' . $message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {

            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                redirect(site_url('admin/message/message_read/' . $param2), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }

            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('admin/message/message_read/' . $param2), 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    function group_message($param1 = "group_message_home", $param2 = ""){
      //if ($this->session->userdata('principal_login') != 1)
        //  redirect(site_url('login'), 'refresh');
      $max_size = 2097152;
      if ($param1 == "create_group") {
        $this->crud_model->create_group();
      }
      elseif ($param1 == "edit_group") {
        $this->crud_model->update_group($param2);
      }
      elseif ($param1 == 'group_message_read') {
        $page_data['current_message_thread_code'] = $param2;
      }
      else if($param1 == 'send_reply'){
        if (!file_exists('uploads/group_messaging_attached_file/')) {
          $oldmask = umask(0);  // helpful when used in linux server
          mkdir ('uploads/group_messaging_attached_file/', 0777);
        }
        if ($_FILES['attached_file_on_messaging']['name'] != "") {
          if($_FILES['attached_file_on_messaging']['size'] > $max_size){
            $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
            redirect(site_url('admin/group_message/group_message_read/' . $param2), 'refresh');
          }
          else{
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);  //$param2 = message_thread_code
        $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
        redirect(site_url('admin/group_message/group_message_read/' . $param2), 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group_message';
      $page_data['page_title']                = get_phrase('group_messaging');
      $this->load->view('backend/index', $page_data);
    }
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 == 'do_update') {

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    //Payment settings
    function payment_settings($param1 = ""){
      if ($this->session->userdata('admin_login') != 1)
          redirect(site_url('login'), 'refresh');

      if ($param1 == 'update_stripe_keys') {
            $this->crud_model->update_stripe_keys();
            $this->session->set_flashdata('flash_message', get_phrase('payment_settings_updated'));
            redirect(site_url('admin/payment_settings'), 'refresh');
      }

      if ($param1 == 'update_paypal_keys') {
          $this->crud_model->update_paypal_keys();
          $this->session->set_flashdata('flash_message', get_phrase('payment_settings_updated'));
          redirect(site_url('admin/payment_settings'), 'refresh');
      }
      if ($param1 == 'update_payumoney_keys') {
        $this->crud_model->update_payumoney_keys();
        $this->session->set_flashdata('flash_message', get_phrase('payment_settings_updated'));
        redirect(site_url('admin/payment_settings'), 'refresh');
      }
      $page_data['page_name']  = 'payment_settings';
      $page_data['page_title'] = get_phrase('payment_settings');
      $page_data['settings']   = $this->db->get('settings')->result_array();
      $this->load->view('backend/index', $page_data);
    }
    // FRONTEND

    function frontend_pages($param1 = '', $param2 = '', $param3 = '') {
      if ($this->session->userdata('admin_login') != 1) {
        redirect(site_url('login'), 'refresh');
      }
      if ($param1 == 'events') {
        $page_data['page_content']  = 'frontend_events';
      }
      if ($param1 == 'gallery') {
        $page_data['page_content']  = 'frontend_gallery';
      }
      if ($param1 == 'privacy_policy') {
        $page_data['page_content']  = 'frontend_privacy_policy';
      }
      if ($param1 == 'about_us') {
        $page_data['page_content']  = 'frontend_about_us';
      }
      if ($param1 == 'terms_conditions') {
        $page_data['page_content']  = 'frontend_terms_conditions';
      }
      if ($param1 == 'homepage_slider') {
        $page_data['page_content']  = 'frontend_slider';
      }
      if ($param1 == '' || $param1 == 'general') {
        $page_data['page_content']  = 'frontend_general_settings';
      }
      if ($param1 == 'gallery_image') {
        $page_data['page_content']  = 'frontend_gallery_image';
        $page_data['gallery_id']  = $param2;
      }
      $page_data['page_name'] = 'frontend_pages';
      $page_data['page_title']  = get_phrase('pages');
      $this->load->view('backend/index', $page_data);
    }

    function frontend_events($param1 = '', $param2 = '') {
      if ($param1 == 'add_event') {
        $this->frontend_model->add_event();
        $this->session->set_flashdata('flash_message' , get_phrase('event_added_successfully'));
        redirect(site_url('admin/frontend_pages/events'), 'refresh');
      }
      if ($param1 == 'edit_event') {
        $this->frontend_model->edit_event($param2);
        $this->session->set_flashdata('flash_message' , get_phrase('event_updated_successfully'));
        redirect(site_url('admin/frontend_pages/events'), 'refresh');
      }
      if ($param1 == 'delete') {
        $this->frontend_model->delete_event($param2);
        $this->session->set_flashdata('flash_message' , get_phrase('event_deleted'));
        redirect(site_url('admin/frontend_pages/events'), 'refresh');
      }
    }

    function frontend_gallery($param1 = '', $param2 = '', $param3 = '') {
      if ($param1 == 'add_gallery') {
        $this->frontend_model->add_gallery();
        $this->session->set_flashdata('flash_message' , get_phrase('gallery_added_successfully'));
        redirect(site_url('admin/frontend_pages/gallery'), 'refresh');
      }
      if ($param1 == 'edit_gallery') {
        $this->frontend_model->edit_gallery($param2);
        $this->session->set_flashdata('flash_message' , get_phrase('gallery_updated_successfully'));
        redirect(site_url('admin/frontend_pages/gallery'), 'refresh');
      }
      if ($param1 == 'upload_images') {
        $this->frontend_model->add_gallery_images($param2);
        $this->session->set_flashdata('flash_message' , get_phrase('images_uploaded'));
        redirect(site_url('admin/frontend_pages/gallery_image/'.$param2), 'refresh');
      }
      if ($param1 == 'delete_image') {
        $this->frontend_model->delete_gallery_image($param2);
        $this->session->set_flashdata('flash_message' , get_phrase('images_deleted'));
        redirect(site_url('admin/frontend_pages/gallery_image/'.$param3), 'refresh');
      }

    }

    function frontend_news($param1 = '', $param2 = '') {
      if ($param1 == 'add_news') {
        $this->frontend_model->add_news();
        $this->session->set_flashdata('flash_message' , get_phrase('news_added_successfully'));
        redirect(site_url('admin/frontend_pages/news'), 'refresh');
      }
      if ($param1 == 'edit_news') {

      }
      if ($param1 == 'delete') {
        $this->frontend_model->delete_news($param2);
        $this->session->set_flashdata('flash_message' , get_phrase('news_was_deleted'));
        redirect(site_url('admin/frontend_pages/news'), 'refresh');
      }
    }

    function frontend_settings($task) {
      if ($task == 'update_terms_conditions') {
        $this->frontend_model->update_terms_conditions();
        $this->session->set_flashdata('flash_message' , get_phrase('terms_updated'));
        redirect(site_url('admin/frontend_pages/terms_conditions'), 'refresh');
      }
      if ($task == 'update_about_us') {
        $this->frontend_model->update_about_us();
        $this->session->set_flashdata('flash_message' , get_phrase('about_us_updated'));
        redirect(site_url('admin/frontend_pages/about_us'), 'refresh');
      }
      if ($task == 'update_privacy_policy') {
        $this->frontend_model->update_privacy_policy();
        $this->session->set_flashdata('flash_message' , get_phrase('privacy_policy_updated'));
        redirect(site_url('admin/frontend_pages/privacy_policy'), 'refresh');
      }
      if ($task == 'update_general_settings') {
        $this->frontend_model->update_frontend_general_settings();
        $this->session->set_flashdata('flash_message' , get_phrase('general_settings_updated'));
        redirect(site_url('admin/frontend_pages/general'), 'refresh');
      }
      if ($task == 'update_slider_images') {
        $this->frontend_model->update_slider_images();
        $this->session->set_flashdata('flash_message' , get_phrase('slider_images_updated'));
        redirect(site_url('admin/frontend_pages/homepage_slider'), 'refresh');
      }
    }

    function frontend_themes() {
      if ($this->session->userdata('admin_login') != 1) {
        redirect(site_url('login'), 'refresh');
      }
      $page_data['page_name'] = 'frontend_themes';
      $page_data['page_title']  = get_phrase('themes');
      $this->load->view('backend/index', $page_data);
    }

    // FRONTEND


    function get_session_changer()
    {
        $this->load->view('backend/admin/change_session');
    }

    function change_session()
    {
        $data['description'] = $this->input->post('running_year');
        $this->db->where('type' , 'running_year');
        $this->db->update('settings' , $data);
        $this->session->set_flashdata('flash_message' , get_phrase('session_changed'));
        redirect(site_url('admin/dashboard'), 'refresh');
    }

	/***** UPDATE PRODUCT *****/

	function update( $task = '', $purchase_code = '' ) {

        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        // Create update directory.
        $dir    = 'update';
        if ( !is_dir($dir) )
            mkdir($dir, 0777, true);

        $zipped_file_name   = $_FILES["file_name"]["name"];
        $path               = 'update/' . $zipped_file_name;

        move_uploaded_file($_FILES["file_name"]["tmp_name"], $path);

        // Unzip uploaded update file and remove zip file.
        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo('update');
            $zip->close();
            unlink($path);
        }

        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        $str                = file_get_contents('./update/' . $unzipped_file_name . '/update_config.json');
        $json               = json_decode($str, true);

		// Run php modifications
		require './update/' . $unzipped_file_name . '/update_script.php';

        // Create new directories.
        if(!empty($json['directory'])) {
            foreach($json['directory'] as $directory) {
                if ( !is_dir( $directory['name']) )
                    mkdir( $directory['name'], 0777, true );
            }
        }

        // Create/Replace new files.
        if(!empty($json['files'])) {
            foreach($json['files'] as $file)
                copy($file['root_directory'], $file['update_directory']);
        }

        $this->session->set_flashdata('flash_message' , get_phrase('product_updated_successfully'));
        redirect(site_url('admin/system_settings'), 'refresh');
    }

    /*****SMS SETTINGS*********/
    function sms_settings($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'clickatell') {

            $data['description'] = $this->input->post('clickatell_user');
            $this->db->where('type' , 'clickatell_user');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_password');
            $this->db->where('type' , 'clickatell_password');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('clickatell_api_id');
            $this->db->where('type' , 'clickatell_api_id');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/sms_settings'), 'refresh');
        }

        if ($param1 == 'twilio') {

            $data['description'] = $this->input->post('twilio_account_sid');
            $this->db->where('type' , 'twilio_account_sid');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_auth_token');
            $this->db->where('type' , 'twilio_auth_token');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('twilio_sender_phone_number');
            $this->db->where('type' , 'twilio_sender_phone_number');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/sms_settings'), 'refresh');
        }
        if ($param1 == 'msg91') {

            $data['description'] = $this->input->post('authentication_key');
            $this->db->where('type' , 'msg91_authentication_key');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('sender_ID');
            $this->db->where('type' , 'msg91_sender_ID');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('msg91_route');
            $this->db->where('type' , 'msg91_route');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('msg91_country_code');
            $this->db->where('type' , 'msg91_country_code');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/sms_settings'), 'refresh');
        }

        if ($param1 == 'active_service') {

            $data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type' , 'active_sms_service');
            $this->db->update('settings' , $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/sms_settings'), 'refresh');
        }

        $page_data['page_name']  = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
			redirect(site_url('login'), 'refresh');

		if ($param1 == 'edit_phrase') {
			$page_data['edit_profile'] 	= $param2;
		}
		if ($param1 == 'update_phrase') {
			$language	=	$param2;
			$total_phrase	=	$this->input->post('total_phrase');
			for($i = 1 ; $i < $total_phrase ; $i++)
			{
				//$data[$language]	=	$this->input->post('phrase').$i;
				$this->db->where('phrase_id' , $i);
				$this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
			}
			redirect(site_url('admin/manage_language/edit_phrase/'.$language), 'refresh');
		}
		if ($param1 == 'do_update') {
			$language        = $this->input->post('language');
			$data[$language] = $this->input->post('phrase');
			$this->db->where('phrase_id', $param2);
			$this->db->update('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(site_url('admin/manage_language'), 'refresh');
		}
		if ($param1 == 'add_phrase') {
			$data['phrase'] = $this->input->post('phrase');
			$this->db->insert('language', $data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(site_url('admin/manage_language'), 'refresh');
		}
		if ($param1 == 'add_language') {
			$language = $this->input->post('language');
			$this->load->dbforge();
			$fields = array(
				$language => array(
					'type' => 'LONGTEXT'
				)
			);
			$this->dbforge->add_column('language', $fields);

			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(site_url('admin/manage_language'), 'refresh');
		}
		if ($param1 == 'delete_language') {
			$language = $param2;
			$this->load->dbforge();
			$this->dbforge->drop_column('language', $language);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));

			redirect(site_url('admin/manage_language'), 'refresh');
		}
		$page_data['page_name']        = 'manage_language';
		$page_data['page_title']       = get_phrase('manage_language');
		//$page_data['language_phrases'] = $this->db->get('language')->result_array();
		$this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');

            $admin_id = $param2;

            $validation = email_validation_for_edit($data['email'], $admin_id, 'admin');
            if($validation == 1){
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/admin_image/' . $this->session->userdata('admin_id') . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('admin/manage_profile'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

            $current_password = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_mismatch'));
            }
            redirect(site_url('admin/manage_profile'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'admin_id' => $this->session->userdata('admin_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    // VIEW QUESTION PAPERS
    function question_paper($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['page_name']  = 'question_paper';
        $data['page_title'] = get_phrase('question_paper');
        $this->load->view('backend/index', $data);
    }

    // MANAGE LIBRARIANS
    function librarian($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['email']      = $this->input->post('email');
            $data['password']   = sha1($this->input->post('password'));
            $validation = email_validation($data['email']);
            if ($validation == 1) {
                $this->db->insert('librarian', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('librarian', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('admin/librarian'), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']   = $this->input->post('name');
            $data['email']  = $this->input->post('email');
            $validation = email_validation_for_edit($data['email'], $param2, 'librarian');
            if ($validation == 1) {
                $this->db->where('librarian_id' , $param2);
                $this->db->update('librarian' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(site_url('admin/librarian'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('librarian_id' , $param2);
            $this->db->delete('librarian');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/librarian'), 'refresh');
        }

        $page_data['page_title']    = get_phrase('all_librarians');
        $page_data['page_name']     = 'librarian';
        $this->load->view('backend/index', $page_data);
    }

    // MANAGE ACCOUNTANTS
    function accountant($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['email']      = $this->input->post('email');
            $data['password']   = sha1($this->input->post('password'));

            $validation = email_validation($data['email']);
            if ($validation == 1) {
                $this->db->insert('accountant', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('accountant', $data['email'], $this->input->post('password')); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(site_url('admin/accountant'), 'refresh');
        }

        if ($param1 == 'edit') {
            $data['name']   = $this->input->post('name');
            $data['email']  = $this->input->post('email');

            $validation = email_validation_for_edit($data['email'], $param2, 'accountant');
            if($validation == 1){
                $this->db->where('accountant_id' , $param2);
                $this->db->update('accountant' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(site_url('admin/accountant'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('accountant_id' , $param2);
            $this->db->delete('accountant');

            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/accountant'), 'refresh');
        }

        $page_data['page_title']    = get_phrase('all_accountants');
        $page_data['page_name']     = 'accountant';
        $this->load->view('backend/index', $page_data);
    }


    // bulk student_add using CSV
    function generate_bulk_student_csv($class_id = '', $section_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['class_id']   = $class_id;
        $data['section_id'] = $section_id;
        $data['year']       = $this->db->get_where('settings', array('type'=>'running_year'))->row()->description;

        $file   = fopen("uploads/bulk_student.csv", "w");
        $line   = array('NEMIS No.', 'Admission Number', 'Student Name', 'Parent Name', 'Parent Phone',  'Parent Email');
        fputcsv($file, $line, ',');
       echo $file_path = base_url() . 'uploads/bulk_student.csv';
    }
    // CSV IMPORT 
    function bulk_student_add_using_csv($param1 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

       if ($param1 == 'import') {
		   
		 if($_FILES['userfile']['type'] == 'application/vnd.ms-excel') 
		 {
			 
          if ($this->input->post('class_id') != '' && $this->input->post('section_id') != '') {
			  
			  $school_id = $this->session->userdata('school_id');

              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/bulk_student.csv');
              $csv = array_map('str_getcsv', file('uploads/bulk_student.csv'));
              $count = 1;
              $array_size = sizeof($csv);

             foreach ($csv as $row) {
                  if ($count == 1) {
                      $count++;
                      continue;
                  }
				  
				  $parent_id = $this->db->get_where('parent' , array('phone' => $row[4]))->row()->parent_id;
				  
				  if((int)$parent_id == ''){
					  
					$pwd = $this->generateRandomString();
					$pdata['name']  = $row[3];
					$pdata['phone']  = $row[4];
					$pdata['password']  = sha1($pwd);
					$pdata['email']  = $row[5];
					$this->db->insert('parent', $pdata);
                    $parent_id = $this->db->insert_id();
					//$this->email_model->account_opening_email('parent', $data['email'],$pwd,$data['phone']); //SEND EMAIL ACCOUNT OPENING EMAIL
				  }
                  $data['nemis'] = $row[0];
				  $data['school_id']  = $school_id;
                  $data['name'] = $row[2];
                  $data['student_code']  = $row[1];                  
                  $data['parent_id'] = $parent_id;     

					$data['form']    = $this->input->post('class_id');
                    $data['stream']  = $this->input->post('section_id');				  
                 /*student id (code) validation
                 $code_validation = code_validation_insert($data['student_code']);
                 if(!$code_validation){
                     $this->session->set_flashdata('error_message' , get_phrase('this_id_no_is_not_available'));
                     redirect(site_url('admin/student_add'), 'refresh');
                 }*/
                 //student id validation ends
				  $validation = 1;
				  //if($data['email'] !='') $validation = email_validation($data['email']);
				  
                  if ($validation == 1) {
                    $this->db->insert('student', $data);
                    $student_id = $this->db->insert_id();
                    $data2['student_id']  = $student_id;
                    $data2['class_id']    = $this->input->post('class_id');
                    $data2['section_id']  = $this->input->post('section_id');
//                    $data2['roll']        = $row[1];
                    $data2['enroll_code'] =   substr(md5(rand(0, 1000000)), 0, 7);
                    $data2['date_added']  =   strtotime(date("Y-m-d H:i:s"));
                    $data2['year']        =   $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
                    $this->db->insert('enroll' , $data2);
                  }
                  else{
                    if ($array_size == 2) {
                      $this->session->set_flashdata('error_message', get_phrase('this_email_id_"').$data['email'].get_phrase('"_is_not_available'));
                      //redirect(site_url('admin/student_bulk_add'), 'refresh');
                    }
                    elseif($array_size > 2){
                      $this->session->set_flashdata('error_message', get_phrase('some_email_IDs_are_not_available'));
                    }
                  }

              }

					
              $this->session->set_flashdata('flash_message', get_phrase('student_imported '));
              //redirect(site_url('admin/student_bulk_add'), 'refresh');
           }
           else{
             $this->session->set_flashdata('error_message', get_phrase('please_make_sure_class_and_section_is_selected'));
            // redirect(site_url('admin/student_bulk_add'), 'refresh');
           }
		   }
		 else
		 {
             $this->session->set_flashdata('error_message', get_phrase('please_make_sure_uploaded_file_is_csv_format/type.'));
             //redirect(site_url('admin/student_bulk_add'), 'refresh');
		 }
	   }
        
        $page_data['page_name']  = 'student_bulk_add';
        $page_data['page_title'] = get_phrase('add_bulk_student');
        $this->load->view('backend/index', $page_data);
    }
	
	function teacher_bulk_add()
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$page_data['page_name']  = 'teacher_bulk_add';
		$page_data['page_title'] = get_phrase('add_bulk_teacher');
		$this->load->view('backend/index', $page_data);
	}	
	
	// bulk teacher_add using CSV
    function generate_bulk_teacher_csv()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');       

        $file   = fopen("uploads/bulk_teachers.csv", "w");
        $line   = array('Teacher Name', 'Tsc Number', 'Phone', 'Email', 'Address', 'Full / Part Time', 'Sex', 'Date Of Birth', 'Role');
        fputcsv($file, $line, ',');
       echo $file_path = base_url() . 'uploads/bulk_teachers.csv';
    }
	
	// CSV IMPORT
    function bulk_teacher_add_using_csv($param1 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

       if ($param1 == 'import') {
		   
		    if($_FILES['userfile']['type'] == 'application/vnd.ms-excel') 
		    {
          	  
			  $school_id = $this->session->userdata('school_id');

              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/bulk_teachers.csv');
              $csv = array_map('str_getcsv', file('uploads/bulk_teachers.csv'));
              $count = 1;
              $array_size = sizeof($csv);

            foreach ($csv as $row) {
				if ($count == 1) {
				  $count++;
				  continue;
				}

				$role  = $row[8];
				//$designation  = $row[2];
				//$class  = $row[2];
				//$section  = $row[3];
				//$subject  = $row[4];			

				$teacher_id = $principal_id = 0;
				 
				if(strtolower($designation) == 'principal'){
					$principal_id = $this->db->get_where('principal' , array('phone' => $row[5]))->row()->principal_id;
				}
				  
				$teacher_id = $this->db->get_where('teacher' , array('phone' => $row[5]))->row()->teacher_id;  
								  
				if((int)$teacher_id == 0 && (int)$principal_id == 0){
				  
					$pwd = $this->generateRandomString();
					$data['school_id']  = $school_id;
					$data['sex'] = $row[6];
					$data['birthday'] = $row[7];
					$data['address'] = $row[4];
					$data['name']  = $row[0];
					$data['designation']  = $role;
					$data['details']  = $row[5];	
					$data['phone']  = $row[2];
					$data['password']  = sha1($pwd);
					$data['email']  = $row[3];
					$data['tsc_number']  = $row[1];											
				}                  
				                               
				$validation = 1;
				if($data['email'] !='') $validation = email_validation($data['email']);

				if ($validation == 1) {
				  
					if(strtolower($designation) == 'principal' && $principal_id == 0){
						
						$this->db->insert('principal', $data);
						$principal_id = $this->db->insert_id();
						$this->email_model->account_opening_email('principal', $data['email'],$pwd,$data['phone']); //SEND EMAIL ACCOUNT OPENING EMAIL
						
					}else if($teacher_id == 0){
						
						$this->db->insert('teacher', $data);
						$teacher_id = $this->db->insert_id();
						$this->email_model->account_opening_email('teacher', $data['email'],$pwd,$data['phone']); //SEND EMAIL ACCOUNT OPENING EMAIL
					}
					
					$class_id = $this->db->get_where('class' , array('name' => $class,'school_id'=> $school_id))->row()->class_id;
				  
					if((int)$class_id == 0){
					  
						$cdata['school_id']  = $school_id;
					   	$cdata['name']  = $class;
						$this->db->insert('class', $cdata);
						$class_id = $this->db->insert_id(); 
				    }
					
					$section_id = $this->db->get_where('section' , array('name' => $section, 'class_id' => $class_id))->row()->section_id;
				  
					if((int)$section_id == 0){					  
						
					   	$sdata['name']  = $section;
						$sdata['class_id']  = $class_id;
						
						if('class teacher' == strtolower($role)){
							$sdata['principal_id']  = $principal_id;
							$sdata['teacher_id']  = $teacher_id;
						}
						$this->db->insert('section', $sdata);
						$section_id = $this->db->insert_id(); 
						
				    }else{

						if('class teacher' == strtolower($role)){
							$sdata['principal_id']  = $principal_id;
							$sdata['teacher_id']  = $teacher_id;
                        	$this->db->where('section_id' , $section_id);
							$this->db->update('section' , $sdata);
						}						
						
					}					
					
					$subject_id = $this->db->get_where('subject' , array('name' => $subject, 'section_id' => $section_id))->row()->subject_id;
				  
					if((int)$subject_id == 0){					  
						
					   	$data2['name']  = $subject;
						$data2['class_id']  = $class_id;
						$data2['section_id']  = $section_id;		 
						$data2['principal_id']  = $principal_id;
						$data2['teacher_id']  = $teacher_id;						 
						$this->db->insert('subject', $data2);
						$subject_id = $this->db->insert_id(); 
						
				    }
                	/*else{
						 
						$data2['principal_id']  = $principal_id;
						$data2['teacher_id']  = $teacher_id;
						$this->db->where('subject_id' , $subject_id);
						$this->db->update('subject' , $data2);
					}*/					
					
                }else{
					  					  
                    if ($array_size == 2) {
                      $this->session->set_flashdata('error_message', get_phrase('this_email_id_"').$data['email'].get_phrase('"_is_not_available'));
                      redirect(site_url('admin/teacher_bulk_add'), 'refresh');
                    }
                    elseif($array_size > 2){
                      $this->session->set_flashdata('error_message', get_phrase('some_email_IDs_are_not_available'));
                    }
                }
			}  
			$this->session->set_flashdata('flash_message', get_phrase('teacher_imported'));
			redirect(site_url('admin/teacher_bulk_add'), 'refresh');
			}
		else
		{
             $this->session->set_flashdata('error_message', get_phrase('please_make_sure_uploaded_file_is_csv_format/type.'));
             redirect(site_url('admin/teacher_bulk_add'), 'refresh');
		}
        }         
        $page_data['page_name']  = 'teacher_bulk_add';
        $page_data['page_title'] = get_phrase('add_bulk_teacher');
        $this->load->view('backend/index', $page_data);
    }
	
	
	function staff_bulk_add()
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$page_data['page_name']  = 'staff_bulk_add';
		$page_data['page_title'] = get_phrase('add_bulk_staff');
		$this->load->view('backend/index', $page_data);
	}		
	 
    function generate_bulk_staff_csv()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');       

        $file   = fopen("uploads/bulk_staffs.csv", "w");
        $line   = array('Staff Name', 'Role', 'Full / Part Time', 'Phone Number', 'Email');
        fputcsv($file, $line, ',');
       echo $file_path = base_url() . 'uploads/bulk_staffs.csv';
    }
	
	// CSV IMPORT
    function bulk_staff_add_using_csv($param1 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

       if ($param1 == 'import') {
		   
		   if($_FILES['userfile']['type'] == 'application/vnd.ms-excel') 
		    {
          	  
			  $school_id = $this->session->userdata('school_id');

              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/bulk_staffs.csv');
              $csv = array_map('str_getcsv', file('uploads/bulk_staffs.csv'));
              $count = 1;
              $array_size = sizeof($csv);

            foreach ($csv as $row) {
				if ($count == 1) {
				  $count++;
				  continue;
				}							  

				$staff_id = 0;				 
				  
				$staff_id = $this->db->get_where('staff' , array('school_id'=>$school_id,'phone' => $row[3]))->row()->staff_id;  
								  
				if((int)$staff_id == 0){				  
					
					$data['school_id']  = $school_id;
					$data['name']  = $row[0];
					$data['designation']  = $row[1];
					$data['details']  = $row[2];	
					$data['phone']  = $row[3];					
					$data['email']  = $row[4];					
				}                  
				                               
				$validation = 1;
				//if($data['email'] !='') $validation = email_validation($data['email']);

				if ($validation == 1) {
				  
					if($staff_id == 0){
						
						$this->db->insert('staff', $data);
						$staff_id = $this->db->insert_id();
						
					}				 
					
                }else{
					  					  
                    if ($array_size == 2) {
                      $this->session->set_flashdata('error_message', get_phrase('this_email_id_"').$data['email'].get_phrase('"_is_not_available'));
                      redirect(site_url('admin/staff_bulk_add'), 'refresh');
                    }
                    elseif($array_size > 2){
                      $this->session->set_flashdata('error_message', get_phrase('some_email_IDs_are_not_available'));
                    }
                }
			}  
			$this->session->set_flashdata('flash_message', get_phrase('staff_imported'));
			redirect(site_url('admin/staff_bulk_add'), 'refresh');   
        
		}     
		else
		{
             $this->session->set_flashdata('error_message', get_phrase('please_make_sure_uploaded_file_is_csv_format/type.'));
             redirect(site_url('admin/staff_bulk_add'), 'refresh');
		}
       }         
        $page_data['page_name']  = 'staff_bulk_add';
        $page_data['page_title'] = get_phrase('add_bulk_staff');
        $this->load->view('backend/index', $page_data);
    }
	
	function timetable_upload()
	{
		 
		$page_data['page_name']  = 'timetable_upload';
		$page_data['page_title'] = get_phrase('timetable_import');
		$this->load->view('backend/index', $page_data);
	}		
	 
    function generate_timetable_csv()
    {
            

        $file   = fopen("uploads/timetable.csv", "w");
        $line   = array('Day(ie:monday)','Is Break(yes/no)', 'Break Title(skip_if_not_break)', 'Start Time(h:i)','End Time(h:i)','Class', 'Stream', 'Subject');
        fputcsv($file, $line, ',');
       echo $file_path = base_url() . 'uploads/timetable.csv';
    }
	
	// CSV IMPORT
    function bulk_import_add_using_csv($param1 = '') {         
		 
       if ($param1 == 'import') {
          	  
			$school_id = $this->session->userdata('school_id'); 
 
              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/timetable.csv');
              $csv = array_map('str_getcsv', file('uploads/timetable.csv'));
              $count = 1;
              $array_size = sizeof($csv);

            foreach ($csv as $row) {
				if ($count == 1) {
				  $count++;
				  continue;
				}						 		 
				  			
				$class_id = $this->db->get_where('class' , array('name' => $row[5],'school_id'=> $school_id))->row()->class_id;  
				$section_id = $this->db->get_where('section' , array('class_id'=>$class_id,'name' => $row[6]))->row()->section_id;
            	$subject_id =0;
                if($row[7] !='')
					$subject_id = $this->db->get_where('subject' , array('class_id'=>$class_id,'section_id'=>$section_id,'name' => $row[7]))->row()->subject_id;
					                                
				$validation = 1;
				
				if((int)$class_id == 0){                     
					$validation = 0;  
					continue;
                }
				if((int)$section_id == 0){                      
					  $validation = 0;  
					  continue;
                }				 
				
				if ($validation == 1) {
				  					 
					$data['day'] = $row[0];
					$data['type'] = ($row[1] == 'yes')?2:1;
					$data['break_title'] = ($row[1] == 'yes')?$row[2]:'';
					$time_start = explode(':',$row[3]);
					$time_end = explode(':',$row[4]);
					$data['time_start'] = $time_start[0];
					$data['time_start_min'] = $time_start[1];
					$data['time_end'] =  $time_end[0];
					$data['time_end_min'] =  $time_end[1];
					$data['class_id'] = $class_id;
					$data['section_id'] = $section_id;
					$data['subject_id'] = (int)$subject_id;
					$data['year'] =    $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
					
					$this->db->insert('class_routine', $data);							 			 
					
                } 
            	 
			}

			if ($validation == 1) $this->session->set_flashdata('flash_message', get_phrase('timetable_imported'));			
			else $this->session->set_flashdata('error_message', get_phrase('some_class_streams_are_not_available'));
			
			redirect(site_url('admin/timetable_upload'), 'refresh');               
        }        
    	  redirect(site_url('admin/timetable_upload'), 'refresh'); die;
        $page_data['page_name']  = 'timetable_upload';
        $page_data['page_title'] = get_phrase('timetable_import');
        $this->load->view('backend/index', $page_data); 
    }
	
	function fees_upload()
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$page_data['page_name']  = 'fees_upload';
		$page_data['page_title'] = get_phrase('fees_records_import');
		$this->load->view('backend/index', $page_data);
	}		
	 
    function generate_fees_csv()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');       

        $file   = fopen("uploads/fees.csv", "w");
        $line   = array('Admission No','Student Name', 'Class','Term', 'Amount','Paid Date(MM-DD-YY)');
        fputcsv($file, $line, ',');
       echo $file_path = base_url() . 'uploads/fees.csv';
    }
	
	// CSV IMPORT
    function import_fees_csv($param1 = '') {

        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

       if ($param1 == 'import') {
          	  
			  $school_id = $this->session->userdata('school_id');

              move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/fees.csv');
              $csv = array_map('str_getcsv', file('uploads/fees.csv'));
              $count = 1;
              $array_size = sizeof($csv);

            foreach ($csv as $row) {
				if ($count == 1) {
				  $count++;
				  continue;
				}						 		 
				  
				$student_id = $this->db->get_where('student' , array('student_code' => $row[0]))->row()->student_id;  
				$class_id = $this->db->get_where('class' , array('name' => $row[2],'school_id' =>$school_id))->row()->class_id;
				$term_id = $this->db->get_where('terms' , array('class_id' => $class_id,'title' =>  $row[3]))->row()->id;
				
				$invoice= $this->db->get_where('invoice' , array('student_id' => $student_id,'term_id' =>  $term_id))->row();
				
				$invoice_id = $invoice->invoice_id;
				$invoice_amount = $invoice->amount;
            	$amount_paid = $invoice->amount_paid;
				$due = $invoice->due;     

				if((int)$term_id == 0){
                      $this->session->set_flashdata('error_message', get_phrase('some_term_are_not_available'));
                }
				elseif((int)$invoice_id == 0){
                      $this->session->set_flashdata('error_message', get_phrase('some_invoice_not_available'));
                }
				
				if ($invoice_id > 0) {
				  					 
					$data['title'] = $row[3];
					$data['payment_type'] = 'income';
					$data['invoice_id'] = $invoice_id;					 
					$data['student_id'] = $student_id;
					$data['amount'] = $row[4];
					$data['timestamp'] =  strtotime(date('Y-m-d',strtotime($row[5])));				 
					$data['paid_date'] = date('Y-m-d',strtotime($row[5]));					 
					$data['year'] =    $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
					
					$this->db->insert('payment', $data);	
					
					$this->db->where('invoice_id' , $invoice_id);
					if($data['amount'] >= $due){						
						$this->db->update('invoice' , array('amount_paid' =>$invoice_amount,'due' => 0,'status' => 'paid'));
					}else{
						
                    	$paidamt = $amount_paid + $data['amount'];
						$balance = $invoice_amount - $paidamt ;
                    	
						$this->db->update('invoice' , array('amount_paid' =>$paidamt,'due' =>$balance,'status' => 'unpaid'));
					}
					$this->session->set_flashdata('flash_message', get_phrase('fees_records_imported'));
                } 
			}  
			
			redirect(site_url('admin/fees_upload'), 'refresh');                
        }         
        $page_data['page_name']  = 'fees_upload';
        $page_data['page_title'] = get_phrase('fees_records_import');
        $this->load->view('backend/index', $page_data);
    }

    function study_material($task = "", $document_id = "")
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($task == "create")
        {
            $this->crud_model->save_study_material_info();
            $this->session->set_flashdata('flash_message' , get_phrase('study_material_info_saved_successfuly'));
            redirect(site_url('admin/study_material'), 'refresh');
        }

        if ($task == "update")
        {
            $this->crud_model->update_study_material_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('study_material_info_updated_successfuly'));
            redirect(site_url('admin/study_material'), 'refresh');
        }

        if ($task == "delete")
        {
            $this->crud_model->delete_study_material_info($document_id);
            redirect(site_url('admin/study_material'), 'refresh');
        }

        $data['study_material_info']    = $this->crud_model->select_study_material_info();
        $data['page_name']              = 'study_material';
        $data['page_title']             = get_phrase('study_material');
        $this->load->view('backend/index', $data);
    }

    //new code
    function print_id($id){
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $data['id'] = $id;
        $this->load->view('backend/admin/print_id', $data);
    }

    function create_barcode($student_id)
    {

        return $this->Barcode_model->create_barcode($student_id);

    }

    // Details of searched student
    function student_details($param1 = ""){
      if ($this->session->userdata('principal_login') != 1)
          redirect(site_url('login'), 'refresh');

      $student_identifier = $this->input->post('student_identifier');
      $query_by_code = $this->db->get_where('student', array('student_code' => $student_identifier));

      if ($query_by_code->num_rows() == 0) {
        $this->db->like('name', $student_identifier);
        $query_by_name = $this->db->get('student');
        if ($query_by_name->num_rows() == 0) {
          $this->session->set_flashdata('error_message' , get_phrase('no_student_found'));
          redirect(site_url('admin/dashboard'), 'refresh');
        }
        else{
          $page_data['student_information'] = $query_by_name->result_array();
        }
      }
      else{
        $page_data['student_information'] = $query_by_code->result_array();
      }
      $page_data['page_name']  	= 'search_result';
  		$page_data['page_title'] 	= get_phrase('search_result');
  		$this->load->view('backend/index', $page_data);
    }
     function report_data(){
		 $this->session->set_userdata('term', $this->input->post('term'));
		 $this->session->set_userdata('year', $this->input->post('year'));
		  $this->session->set_userdata('exam', $this->input->post('exam'));
	 }
    function report($param1 = '',$param2 = 1){
		
		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		$pdf->debug = true;
		$data['term'] = $this->session->userdata('term');
		$data['year'] = $this->session->userdata('year');
		$data['exam_main'] = $this->session->userdata('exam');
		$student_id = $param1;
		$data['adm']=$param1;
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$student = $this->db->get_where('sudtls' , array('Adm' => $student_id))->row();
		$data['student_name'] = $student->Name;
		$data['school_image'] = $this->crud_model->get_image_url('school',$student->school_id);
		$student2 = $this->db->get_where('student' , array('student_code' => $student_id))->row();
		$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
		$class = $student->Form;
		$class_id = $student2->class_id;
		$section_id = $student2->section_id;
		$stream = $student->Stream;
		$data['class_name'] = $this->db->get_where('form' , array('Id' => $class))->row()->Name . ' '.$stream;
		$class_name =  $this->db->get_where('form' , array('Id' => $class))->row()->Name;
		
		$main_exam	=	strtolower($this->input->post('exam'));
		if($stream != ''){
		$data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year,"Adm"=>$student_id))->result_array();
		}else{
			$data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year,"stream"=>$stream,"Adm"=>$student_id))->result_array();
		}
		$data['exam1']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year))->row()->exam1;
		
		$data['exam2']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year))->row()->exam2;
		
		$teacher_name = $this->db->get_where('teacher' , array('teacher_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->teacher_id))->row()->name;
		
		if($teacher_name == '')
			$teacher_name = $this->db->get_where('principal' , array('principal_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->principal_id))->row()->name;
		
		$data['class_teacher'] = $teacher_name;	
				
		switch($param2){
		
			case 1:
			
				$report_name = 'health_report';
			
				$last_incident = $this->db->order_by('updated_date', 'DESC')->get_where('health_last_occurence' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('updated_date', 'DESC')->get_where('health_last_occurence' , array('student_id' => $student_id))->result_array();
				
				$data['overall_health'] = ($last_incident->updated_date !='')?'Good':'';
				$data['incident_date'] = ($last_incident->updated_date !='')?date('d M Y',strtotime($last_incident->updated_date)):'';
				$data['incident_action'] = $last_incident->action;
				$data['report'] = $report;
				
				$template = "backend/principal/health_report_pdf";
				
			break;
			case 2:
			
				$report_name = 'behaviour_report';
			
				$last_incident = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->result_array();
				
				$data['overall_behaviour'] = ($last_incident->updated_on !='')?'Good':'';
				$data['incident_date'] = ($last_incident->updated_on !='')?date('d M Y',strtotime($last_incident->updated_on)):'';
				$data['incident_action'] = $last_incident->action;
				$data['report'] = $report;
			
			
				$template = "backend/principal/behaviour_pdf_report";
			break;
			case 3:
			
				$report_name = 'fee_report';
			
				$invoice = $this->db->order_by('term_id', 'DSEC')->get_where('invoice' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('term_id', 'ASC')->get_where('invoice' , array('student_id' => $student_id))->result_array();
												 
				$payment_date = $this->db->get_where('payment' , array('invoice_id' => $invoice->invoice_id))->row()->paid_date;
				 
				$fee_status = ($invoice->due >0)?'Pending':'Cleared';
				$data['fee_status'] = $fee_status;
				$data['incident_date'] = ($payment_date !='' && $payment_date != 0)?date('d M Y',strtotime($payment_date)):'';
				$data['balance'] = $invoice->due;
				$data['report'] = $report;
				
				$template = "backend/principal/fee_pdf_report";
			break;
			case 4:
			
				$report_name = 'attendance_report';
				
				$last_incident = $this->db->order_by('date', 'DESC')->get_where('attendance' , array('student_id' => $student_id,'status' => 2))->row();
				
				$report = $this->db->order_by('date', 'ASC')->get_where('attendance' , array('student_id' => $student_id,'status' => 2))->result_array();
				
				$data['overall_attendance'] = ($last_incident->date !='')?'Good':'';
				$data['incident_date'] = ($last_incident->date !='')?date('d M Y',strtotime($last_incident->date)):'';
				$data['incident_reason'] = $last_incident->reason;
				$data['report'] = $report;
				
				$template = "backend/principal/attendance_pdf_report";
			break;
			case 5:
			
				$report_name = 'academic_progress_report';
				
				$last_exam = $this->db->get_where('exam' , array('exam_id' => $this->db->order_by('exam_id', 'DESC')->get_where('mark' , array('student_id' => $student_id))->row()->exam_id))->row();				
				
				
				$report = $this->db->order_by('exam_id', 'ASC')->get_where('mark' , array('student_id' => $student_id))->result_array();
				//echo ("<pre>");
				//print_r ($report); exit;
				//echo ("</pre>");
				$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
				
				$class_id = $enroll->class_id;
				
				$section_id = $enroll->section_id;
				
				
				
				$studentCnt = $this->db->get_where('enroll' , array('class_id' => $class_id,'section_id' => $section_id))->num_rows();
				
				$students = $this->db->order_by('student_id', 'ASC')->get_where('mark' , array('class_id' => $class_id,'section_id' => $section_id))->result_array();
				
				$data['studentCnt'] = $studentCnt;
				$data['students'] = $students;
				
				$data['overall_performance'] = ($last_exam->date !='')?'Good':'';
				$data['exam_date'] = ($last_exam->date !='')?date('d M Y',strtotime($last_exam->date)):'';				 
				$data['report'] = $report;
				//echo ("<pre>");
				//print_r($report); exit;
				//echo ("</pre>");
				
				$template = "backend/principal/education_pdf_report";
						
			break;
			default:
			break;	
			
		}
 
		$location = __DIR__ .'/assets/pdf/';
		
		$content = $this->load->view($template, $data, true);		
		
        $name = $report_name . date('Y_m_d_H_i_s') . '.pdf';		
	
		$stylesheet = file_get_contents('http://apps.classteacher.school/assets/css/pdf_style.css');
		
        $pdf->WriteHTML($stylesheet,1);
     
		$pdf->WriteHTML($content,2);
			 	
		$pdf->Output($name, 'I');		
		echo 'test';
		exit;
		
	} 
  
    function class_layout($class_id)
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'class_layout';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('stream_layout');
       $this->load->view('backend/index', $page_data);
    }
    	
	function class_layout_edit($class_id)
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'class_layout_edit';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('class_layout_edit');
        $this->load->view('backend/index', $page_data);
    }
    
    function student_behaviour($id)
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
		$student = $this->db->get_where('student' , array('student_id' => $id))->row();
		$student_name = $student->name;
		$school = $student->school_id;
        $page_data['page_name']  = 'student_behaviour';
        $page_data['student_id']  =   $id;
		$page_data['school_id']  =   $school;
        $page_data['page_title'] = get_phrase('student_behaviour').'-'.$student_name;
       $this->load->view('backend/index', $page_data);
    }
    
    function student_behaviour_details($class_id)
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'student_behaviour_details';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('student_behaviours');
        $this->load->view('backend/index', $page_data);
    }
	
	function marks_manage_subject()
    {		
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'marks_manage_subject';
        $page_data['page_title'] = get_phrase('mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
	
	function blank_marks_manage_subject()
    {		
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'blank_marks_manage_subject';
        $page_data['page_title'] = get_phrase('blank_mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
	
	///NEW MARKBOOK
	
	function markbook()
	{
		 if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
	 $page_data['page_name']  = 'markbook';
        $page_data['page_title'] = get_phrase('Blank_mark_sheet');
        $this->load->view('backend/index', $page_data);	
	}
	
	function mark_book()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$subject	=	$this->input->post('subject');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$class		=	$this->input->post('form');
		$main_exam	=	strtolower($this->input->post('exam'));
		if($stream != ''){
		$page_data['exam']= $this->db->get_where(str_replace(" ","",$main_exam), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"subject"=>$subject))->result_array();
		}else{
			$page_data['exam']= $this->db->get_where(str_replace(" ","",$main_exam), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$stream,"subject"=>$subject))->result_array();
		}
		$page_data['exam1']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam1;
		
		$page_data['exam2']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam2;
		$page_data['cutoff']= $cutoff;
		$page_data['class']= $class;
		$page_data['year']= $year;
		$page_data['term']= $term;
		$page_data['subject']= $subject;
		$page_data['stream']= $stream;
		$page_data['main_exam']= $main_exam;
        $page_data['page_name']  = 'mark_book';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/load', $page_data);
		
    }
	
	function mark_book_print()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$subject	=	$this->input->post('subject');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$class		=	$this->input->post('form');
		$main_exam	=	strtolower($this->input->post('exam'));
		if($stream != ''){
		$page_data['exam']= $this->db->get_where(str_replace(" ","",$main_exam), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"subject"=>$subject))->result_array();
		}else{
			$page_data['exam']= $this->db->get_where(str_replace(" ","",$main_exam), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$stream,"subject"=>$subject))->result_array();
		}
		$page_data['exam1']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam1;
		
		$page_data['exam2']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year))->row()->exam2;
		$page_data['cutoff']= $cutoff;
		$page_data['class']= $class;
		$page_data['year']= $year;
		$page_data['term']= $term;
		$page_data['subject']= $subject;
		$page_data['stream']= $stream;
		$page_data['main_exam']= $main_exam;
        $page_data['page_name']  = 'mark_book_print';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/load', $page_data);
		
    }
	
	function marks_manage_subject_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'marks_manage_subject_view';
        $page_data['page_title'] = get_phrase('mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
	
	
	function blank_marks_manage_subject_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'blank_marks_manage_subject_view';
        $page_data['page_title'] = get_phrase('blank_mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
	
	
	
	function marks_subject_selector()
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $ssubje = $this->input->post('subject_id');
		$ssubject_id = $this->db->get_where('subject' , array('subject_id'=>$ssubje))->row()->class_subject;
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){
			$query = $this->db->get_where('mark' , array(
						'exam_id' => $data['exam_id'],
							'class_id' => $data['class_id'],
								'section_id' => $data['section_id'],
									'subject_id' => $ssubject_id,
										'year' => $data['year']
					));
			if($query->num_rows() < 1) {
				$students = $this->db->get_where('enroll' , array(
					'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
				))->result_array();
				foreach($students as $row) {
					$data['student_id'] = $row['student_id'];
					$this->db->insert('mark' , $data);
				}
			}
			redirect(site_url('admin/marks_manage_subject_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $ssubject_id), 'refresh');
		}
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'marks_manage';
			$page_data['page_title'] = get_phrase('manage_exam_marks');
			$this->load->view('backend/index', $page_data);
		}
	}
	
	
	
	
	
	function blank_marks_subject_selector()
    {
        if ($this->session->userdata('principal_login') != 1)
        redirect(site_url('login'), 'refresh');
        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        //$data['subject_id'] = $this->input->post('subject_id');
		$sdsubje = $this->input->post('subject_id');
		$sdsubject_id = $this->db->get_where('subject' , array('subject_id'=>$sdsubje))->row()->class_subject;
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){
			$query = $this->db->get_where('mark' , array(
						'exam_id' => $data['exam_id'],
							'class_id' => $data['class_id'],
								'section_id' => $data['section_id'],
									'subject_id' => $sdsubject_id,
										'year' => $data['year']
					));
			if($query->num_rows() < 1) {
				$students = $this->db->get_where('enroll' , array(
					'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
				))->result_array();
				foreach($students as $row) {
					$data['student_id'] = $row['student_id'];
					$this->db->insert('mark' , $data);
				}
			}
			redirect(site_url('admin/blank_marks_manage_subject_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $sdsubject_id), 'refresh');
		}
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'blank_mark_book';
			$page_data['page_title'] = get_phrase('blank_mark_book');
			$this->load->view('backend/index', $page_data);
		}
	}
	
	
	
	function manage_subject_analysis()
    {		
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'manage_subject_analysis';
        $page_data['page_title'] = get_phrase('subject_analysis');
        $this->load->view('backend/index', $page_data);
    }
	
	function manage_subject_analysis_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'manage_subject_analysis_view';
        $page_data['page_title'] = get_phrase('subject_analysis_report');
        $this->load->view('backend/index', $page_data);
    }
	
	function subject_analysis_selector()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){
			$query = $this->db->get_where('mark' , array(
						'exam_id' => $data['exam_id'],
							'class_id' => $data['class_id'],
								'section_id' => $data['section_id'],
									'subject_id' => $data['subject_id'],
										'year' => $data['year']
					));
			if($query->num_rows() < 1) {
				$students = $this->db->get_where('enroll' , array(
					'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
				))->result_array();
				foreach($students as $row) {
					$data['student_id'] = $row['student_id'];
					$this->db->insert('mark' , $data);
				}
			}
			redirect(site_url('admin/manage_subject_analysis_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']), 'refresh');
		}
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'manage_subject_analysis';
			$page_data['page_title'] = get_phrase('subject_analysis');
			$this->load->view('backend/index', $page_data);
		}
	}
	
	
	
	
	
	
	function manage_subject_analysis_per_subject()
    {		
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'manage_subject_analysis_per_subject';
        $page_data['page_title'] = get_phrase('subject_analysis_per_subject'); 
        $this->load->view('backend/index', $page_data);
    }
	
	
	
	function manage_subject_analysis_per_subject_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'manage_subject_analysis_per_subject_view';
        $page_data['page_title'] = get_phrase('subject_analysis_per_subject_report');
        $this->load->view('backend/index', $page_data);
    }
	
	
	
	function subject_analysis_per_subject_selector()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){
			$query = $this->db->get_where('mark' , array(
						'exam_id' => $data['exam_id'],
							'class_id' => $data['class_id'],
								'section_id' => $data['section_id'],
									'subject_id' => $data['subject_id'],
										'year' => $data['year']
					));
			if($query->num_rows() < 1) {
				$students = $this->db->get_where('enroll' , array(
					'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
				))->result_array();
				foreach($students as $row) {
					$data['student_id'] = $row['student_id'];
					$this->db->insert('mark' , $data);
				}
			}
			redirect(site_url('admin/manage_subject_analysis_per_subject_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']), 'refresh');
		}
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'manage_subject_analysis_per_subject';
			$page_data['page_title'] = get_phrase('subject_analysis_per_subject');
			$this->load->view('backend/index', $page_data);
		}
	}
	
	
	
	
	
	/******* PERFORMANCE GRADE SECTION STARTS ********/
	
	function performance_grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
            $data['name']        = $this->input->post('name');            
            $data['mean_from']   = $this->input->post('mean_from');
            $data['mean_upto']   = $this->input->post('mean_upto');            
			$data['school_id']   = $school_id;
            $this->db->insert('performance_grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(site_url('admin/performance_grade'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']        = $this->input->post('name');            
            $data['mean_from']   = $this->input->post('mean_from');
            $data['mean_upto']   = $this->input->post('mean_upto');
            $this->db->where('performance_grade_id', $param2);
            $this->db->update('performance_grade', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('admin/performance_grade'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('performance_grade', array(
                'performance_grade_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('performance_grade_id', $param2);
            $this->db->delete('performance_grade');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('admin/performance_grade'), 'refresh');
        }
        $page_data1['performance_grades'] = $this->db->get_where('performance_grade', array('school_id' => $school_id))->result_array();
        $page_data1['page_name']  = 'performance_grade';
        $page_data1['page_title'] = get_phrase('manage_performance_grade');
        $this->load->view('backend/index', $page_data1);
    }
	
	/******* PERFORMANCE GRADE SECTION ENDS ********/
	
	/******* SCORE SHEET SECTION STARTS ********/
	 function score_sheet()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$subject	=	$this->input->post('subject');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$form		=	$this->input->post('form');
		$main_exam	=	$this->input->post('exam');
		
		$page_data['cutoff']= $cutoff;
		$page_data['form1']= $form;
		$page_data['year1']= $year;
		$page_data['term1']= $term;
		$page_data['subject1']= $subject;
		$page_data['stream1']= $stream;
		$page_data['exam1']= $main_exam;
		
		$page_data['page_name']  = 'score_sheet';
      $page_data['page_title'] = get_phrase('score_sheet');
     $this->load->view('backend/load', $page_data);
	//$this->set_output($out); 
	
	}
	
	 function score_sheet_print()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$subject	=	$this->input->post('subject');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$form		=	$this->input->post('form');
		$main_exam	=	$this->input->post('exam');
		
		$page_data['cutoff']= $cutoff;
		$page_data['form1']= $form;
		$page_data['year1']= $year;
		$page_data['term1']= $term;
		$page_data['subject1']= $subject;
		$page_data['stream1']= $stream;
		$page_data['exam1']= $main_exam;
		
		$page_data['page_name']  = 'score_sheet_print';
        $page_data['page_title'] = get_phrase('score_sheet');
        $this->load->view('backend/load', $page_data);
	
	}
	function score_sheet1($class_id = '' , $exam_id = '', $section_id = '') {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');
			

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('admin/score_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('admin/score_sheet'), 'refresh');
            }
        }
		
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
		$page_data['section_id']   = $section_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'score_sheet';
        $page_data['page_title'] = get_phrase('score_sheet_details');
        $this->load->view('backend/index', $page_data);

    }
	
	function blank_score_sheet($class_id = '' , $exam_id = '', $section_id = '') {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');
			

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('admin/blank_score_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('admin/blank_score_sheet'), 'refresh');
            }
        }
		
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
		$page_data['section_id']   = $section_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'blank_score_sheet';
        $page_data['page_title'] = get_phrase('score_sheet_details');
        $this->load->view('backend/index', $page_data);

    }
	
	
	function score_sheet_per_subject($exam_id = '', $class_id = '' ,  $section_id = '', $subject_id = '') {
		
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');
			//$page_data['subject_id']   = $this->input->post('subject_id');
			$srsubje = $this->input->post('subject_id');
		    $srsubject_id = $this->db->get_where('subject' , array('subject_id'=>$srsubje))->row()->class_subject;

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('admin/score_sheet_per_subject/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']. '/' . $srsubject_id), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('admin/score_sheet_per_subject'), 'refresh');
            }
        }
		
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
		$page_data['section_id']   = $section_id;
		$page_data['subject_id']   = $subject_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'score_sheet2';
        $page_data['page_title'] = get_phrase('score_sheet_per_subject_details');
        $this->load->view('backend/index', $page_data);

    }
	

	
	/******* BLANK SCORE SHEET SECTION ENDS ********/
	
	/******* Elective Subject Analysis Starts *******/
	
	/********New elective information**************/
	
	function student_elective_subject($class_id = '')
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['page_name']  	= 'student_elective_subject';
		$page_data['page_title'] 	= get_phrase('manage_elective_subject'). " - ".get_phrase('stream')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
	function manage_elective_subject_student($param1 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;		
		$school_id = $this->session->userdata('school_id');
		
		if ($param1 == 'create') {

			$school_id = $this->session->userdata('school_id');	
			$student_id = $this->uri->segment(4);
			$class_id = $this->uri->segment(5);
			$section_id = $this->uri->segment(6);
			$group2_elective = $this->input->post('group2_elective[]');
			$group3_elective = $this->input->post('group3_elective[]');
			$group4_elective = $this->input->post('group4_elective[]');
			$group5_elective = $this->input->post('group5_elective[]');
			$group6_elective = $this->input->post('group6_elective[]');
			$group7_elective = $this->input->post('group7_elective[]');
			$check_array1 = implode(',',$group2_elective);
			$check_array2 = implode(',',$group3_elective);
			$check_array3 = implode(',',$group4_elective);
			$check_array4 = implode(',',$group5_elective);
			$check_array5 = implode(',',$group6_elective);
			$check_array6 = implode(',',$group7_elective);
			
			$post_data = array(
			'id'=> $this->input->post('id'),								
			'student_id'=> $student_id,							
			'section_id'=> $section_id,								
			'school_id'=> $school_id,
			'class_id'=> $class_id,											
			'group2_elective'=> $check_array1,											
			'group3_elective'=> $check_array2,											
			'group4_elective'=> $check_array3,
			'group5_elective'=> $check_array4,											
			'group6_elective'=> $check_array5,											
			'group7_elective'=> $check_array6		
			);	
			$this->db->insert('elective_subjects', $post_data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));			
			redirect(site_url('admin/student_elective_subject/'.$class_id), 'refresh');
		}
		
		$page_data['page_name']        = 'student_elective_subject';
		$page_data['page_title'] = get_phrase('group_elective_subjects');
		$this->load->view('backend/index', $page_data);
    }
	
	
	
	function manage_elective_subject_class($param1 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;		
		$school_id = $this->session->userdata('school_id');
		
		if ($param1 == 'create') { 
			$class_id = $this->uri->segment(4);
			$school_id = $this->session->userdata('school_id');			
			$edit_data = $this->db->get_where('enroll' , array('year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description, 'class_id'=>$class_id))->result_array();
			foreach ($edit_data as $row2) { 
			$student_id = $row2['student_id'];
			$class_id = $row2['class_id'];
			$section_id = $row2['section_id'];
			$group2_elective = $this->input->post('group2_elective[]');
			$group3_elective = $this->input->post('group3_elective[]');
			$group4_elective = $this->input->post('group4_elective[]');
			$group5_elective = $this->input->post('group5_elective[]');
			$group6_elective = $this->input->post('group6_elective[]');
			$group7_elective = $this->input->post('group7_elective[]');
			$check_array1 = implode(',',$group2_elective);
			$check_array2 = implode(',',$group3_elective);
			$check_array3 = implode(',',$group4_elective);
			$check_array4 = implode(',',$group5_elective);
			$check_array5 = implode(',',$group6_elective);
			$check_array6 = implode(',',$group7_elective);
			
			$post_data = array(
			//'id'=> $this->input->post('id'),								
			'student_id'=> $student_id,							
			'section_id'=> $section_id,								
			'school_id'=> $school_id,
			'class_id'=> $class_id,											
			'group2_elective'=> $check_array1,											
			'group3_elective'=> $check_array2,											
			'group4_elective'=> $check_array3,
			'group5_elective'=> $check_array4,											
			'group6_elective'=> $check_array5,											
			'group7_elective'=> $check_array6		
			);	
			//echo '<pre>';
			//print_r($post_data);
			//echo '</pre>';
			$this->db->insert('elective_subjects', $post_data);
			}
			//$student_id = $this->uri->segment(4);
			//$class_id = $this->uri->segment(5);
			//$section_id = $this->uri->segment(6);
			//exit;
			//$this->db->insert('elective_subjects', $post_data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));			
			redirect(site_url('admin/student_elective_subject/'.$class_id), 'refresh');
		}
		
		$page_data['page_name']        = 'student_elective_subject';
		$page_data['page_title'] = get_phrase('group_elective_subjects');
		$this->load->view('backend/index', $page_data);
    }


	
	/***** Updated code *****/

	function manage_elective_subject_student_edit($param1 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;		
		$school_id = $this->session->userdata('school_id');
		
		if ($param1 == 'update') {

			$school_id = $this->session->userdata('school_id');	
			$student_id = $this->uri->segment(4);
			$class_id = $this->uri->segment(5);
			$section_id = $this->uri->segment(6);
			$group2_elective = $this->input->post('group2_elective[]');
			$group3_elective = $this->input->post('group3_elective[]');
			$group4_elective = $this->input->post('group4_elective[]');
			$group5_elective = $this->input->post('group5_elective[]');
			$group6_elective = $this->input->post('group6_elective[]');
			$group7_elective = $this->input->post('group7_elective[]');
			$check_array1 = implode(',',$group2_elective);
			$check_array2 = implode(',',$group3_elective);
			$check_array3 = implode(',',$group4_elective);
			$check_array4 = implode(',',$group5_elective);
			$check_array5 = implode(',',$group6_elective);
			$check_array6 = implode(',',$group7_elective);
			
			$post_data = array(							
				'student_id'=> $student_id,							
				'section_id'=> $section_id,								
				'school_id'=> $school_id,
				'class_id'=> $class_id,											
				'group2_elective'=> $check_array1,											
				'group3_elective'=> $check_array2,											
				'group4_elective'=> $check_array3,											
				'group5_elective'=> $check_array4,											
				'group6_elective'=> $check_array5,											
				'group7_elective'=> $check_array6														
			);
			
			$this->db->where('student_id' , $student_id);
			$this->db->update('elective_subjects', $post_data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(site_url('admin/student_elective_subject/'.$class_id), 'refresh');
		}
		
		$page_data['page_name']        = 'student_elective_subject';
		$page_data['page_title'] 	= get_phrase('manage_elective_subject'). " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
    }
	
	
	function manage_elective_subject_class_edit($param1 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');

        $running_year = $this->db->get_where('settings' , array(
            'type' => 'running_year'
        ))->row()->description;		
		$school_id = $this->session->userdata('school_id');
		
		if ($param1 == 'update') {
			$school_id = $this->session->userdata('school_id');	
			$student_id = $this->uri->segment(4);
			$class_id = $this->uri->segment(5);
			$section_id = $this->uri->segment(6);
			$group2_elective = $this->input->post('group2_elective[]');
			$group3_elective = $this->input->post('group3_elective[]');
			$group4_elective = $this->input->post('group4_elective[]');
			$group5_elective = $this->input->post('group5_elective[]');
			$group6_elective = $this->input->post('group6_elective[]');
			$group7_elective = $this->input->post('group7_elective[]');
			$check_array1 = implode(',',$group2_elective);
			$check_array2 = implode(',',$group3_elective);
			$check_array3 = implode(',',$group4_elective);
			$check_array4 = implode(',',$group5_elective);
			$check_array5 = implode(',',$group6_elective);
			$check_array6 = implode(',',$group7_elective);
			
			$post_data = array(							
				'student_id'=> $student_id,							
				'section_id'=> $section_id,								
				'school_id'=> $school_id,
				'class_id'=> $class_id,											
				'group2_elective'=> $check_array1,											
				'group3_elective'=> $check_array2,											
				'group4_elective'=> $check_array3,											
				'group5_elective'=> $check_array4,											
				'group6_elective'=> $check_array5,											
				'group7_elective'=> $check_array6														
			);
			
			$this->db->where('class_id' , $class_id);
			$this->db->update('elective_subjects', $post_data);
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
			redirect(site_url('admin/student_elective_subject/'.$class_id), 'refresh');
		}
		
		$page_data['page_name']        = 'student_elective_subject';
		$page_data['page_title'] 	= get_phrase('manage_elective_subject'). " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
    }
	

/***** Updated code *****/
	
/******* Elective Subject Analysis Ends *******/
	


	function subject_performance($class_id = '' , $section_id = '') {
       if ($this->session->userdata('principal_login') != 1)
           redirect(site_url('login'), 'refresh');

       if ($this->input->post('operation') == 'selection') {
           $page_data['exam_id']    = $this->input->post('exam_id');
           $page_data['class_id']   = $this->input->post('class_id');
		  $page_data['section_id']   = $this->input->post('section_id');

           if ($page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
               redirect(site_url('admin/subject_performance/' . $page_data['class_id'] . '/'. $page_data['section_id']), 'refresh');
           } else {
               $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
               redirect(site_url('admin/subject_performance'), 'refresh');
           }
       }
       $page_data['exam_id']    = $exam_id;
       $page_data['class_id']   = $class_id;
	   $page_data['section_id']   = $section_id;

       $page_data['page_info'] = 'Exam marks';

       $page_data['page_name']  = 'subject_performance';
       $page_data['page_title'] = get_phrase('subject_performance_graph_sheet_details');
       $this->load->view('backend/index', $page_data);

   }	
	
	/******* Class performance graph_sheet Ends *******/
	
	function stream_performance($class_id = '' , $section_id = '') {
       if ($this->session->userdata('principal_login') != 1)
           redirect(site_url('login'), 'refresh');

       if ($this->input->post('operation') == 'selection') {
           $page_data['exam_id']    = $this->input->post('exam_id');
           $page_data['class_id']   = $this->input->post('class_id');
		  $page_data['section_id']   = $this->input->post('section_id');

           if ($page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
               redirect(site_url('admin/stream_performance/' . $page_data['class_id'] . '/'. $page_data['section_id']), 'refresh');
           } else {
               $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
               redirect(site_url('admin/stream_performance'), 'refresh');
           }
       }
       $page_data['exam_id']    = $exam_id;
       $page_data['class_id']   = $class_id;
	   $page_data['section_id']   = $section_id;

       $page_data['page_info'] = 'Exam marks';

       $page_data['page_name']  = 'stream_performance';
       $page_data['page_title'] = get_phrase('stream_performance_graph_sheet_details');
       $this->load->view('backend/index', $page_data);

   }	
	
	/******* Class performance graph_sheet Ends *******/
	
	
	
	function class_performance($class_id = '' , $section_id = '') {
       if ($this->session->userdata('principal_login') != 1)
           redirect(site_url('login'), 'refresh');

       if ($this->input->post('operation') == 'selection') {
           $page_data['exam_id']    = $this->input->post('exam_id');
           $page_data['class_id']   = $this->input->post('class_id');
		  $page_data['section_id']   = $this->input->post('section_id');

           if ($page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
               redirect(site_url('admin/class_performance/' . $page_data['class_id'] . '/'. $page_data['section_id']), 'refresh');
           } else {
               $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
               redirect(site_url('admin/class_performance'), 'refresh');
           }
       }
       $page_data['exam_id']    = $exam_id;
       $page_data['class_id']   = $class_id;
	   $page_data['section_id']   = $section_id;

       $page_data['page_info'] = 'Exam marks';

       $page_data['page_name']  = 'class_performance';
       $page_data['page_title'] = get_phrase('class_performance_graph_sheet_details');
       $this->load->view('backend/index', $page_data);

   }	
	
	/******* Class performance graph_sheet Ends *******/
	
	
	
	
	/********** ACADEMIC TRANSCRIPT  *********/
	
	function academic_report_summery($param1 = '',$param2 = 1)
	{
		$this->load->library('pdfl');
        $pdfl = $this->pdfl->load();
		$pdfl->debug = true;

		$student_id = $param1;
		
		$student = $this->db->get_where('student' , array('student_id' => $student_id))->row();
		$data['student_name'] = $student->name;
		$data['student_address'] = $student->address;
		$data['student_phone'] = $student->phone;
		$data['student_code'] = $student->student_code;
		$data['school_image'] = $this->crud_model->get_image_url('school',$student->school_id);
		
		
		$school_name = $this->db->get_where('school' , array('school_id' => $student->school_id))->row();
		$data['school_name_pre'] =  $school_name->school_name;
		$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
		$class_id = $enroll->class_id;
		$section_id = $enroll->section_id;
		$data['stu_year'] =  $enroll->year;
		
		$markde = $this->db->get_where('mark' , array('student_id' => $student_id))->row();
		$examid = $markde->exam_id;
		
		$examde = $this->db->get_where('exam' , array('exam_id' => $examid))->row();
		$data['exam_name'] = $examde->name;
		$data['class_name'] = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
		
		$teacher_name = $this->db->get_where('teacher' , array('teacher_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->teacher_id))->row()->name;
		
		if($teacher_name == '')
			$teacher_name = $this->db->get_where('principal' , array('principal_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->principal_id))->row()->name;
		
		$data['class_teacher'] = $teacher_name;
		
		switch($param2){
		
			/*case 1:
			
				$report_name = 'health_report';
			
				$last_incident = $this->db->order_by('updated_date', 'DESC')->get_where('health_last_occurence' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('updated_date', 'DESC')->get_where('health_last_occurence' , array('student_id' => $student_id))->result_array();
				
				$data['overall_health'] = ($last_incident->updated_date !='')?'Good':'';
				$data['incident_date'] = ($last_incident->updated_date !='')?date('d M Y',strtotime($last_incident->updated_date)):'';
				$data['incident_action'] = $last_incident->action;
				$data['report'] = $report;
				
				$template = "backend/principal/health_report_pdf";
				
			break;
			case 2:
			
				$report_name = 'behaviour_report';
			
				$last_incident = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->result_array();
				
				$data['overall_behaviour'] = ($last_incident->updated_on !='')?'Good':'';
				$data['incident_date'] = ($last_incident->updated_on !='')?date('d M Y',strtotime($last_incident->updated_on)):'';
				$data['incident_action'] = $last_incident->action;
				$data['report'] = $report;
			
			
				$template = "backend/principal/behaviour_pdf_report";
			break;
			case 3:
			
				$report_name = 'fee_report';
			
				$invoice = $this->db->order_by('term_id', 'DSEC')->get_where('invoice' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('term_id', 'ASC')->get_where('invoice' , array('student_id' => $student_id))->result_array();
												 
				$payment_date = $this->db->get_where('payment' , array('invoice_id' => $invoice->invoice_id))->row()->paid_date;
				 
				$fee_status = ($invoice->due >0)?'Pending':'Cleared';
				$data['fee_status'] = $fee_status;
				$data['incident_date'] = ($payment_date !='' && $payment_date != 0)?date('d M Y',strtotime($payment_date)):'';
				$data['balance'] = $invoice->due;
				$data['report'] = $report;
				
				$template = "backend/principal/fee_pdf_report";
			break;
			case 4:
			
				$report_name = 'attendance_report';
				
				$last_incident = $this->db->order_by('date', 'DESC')->get_where('attendance' , array('student_id' => $student_id,'status' => 2))->row();
				
				$report = $this->db->order_by('date', 'ASC')->get_where('attendance' , array('student_id' => $student_id,'status' => 2))->result_array();
				
				$data['overall_attendance'] = ($last_incident->date !='')?'Good':'';
				$data['incident_date'] = ($last_incident->date !='')?date('d M Y',strtotime($last_incident->date)):'';
				$data['incident_reason'] = $last_incident->reason;
				$data['report'] = $report;
				
				$template = "backend/principal/attendance_pdf_report";
			break;*/
			case 5:
			
				$report_name = 'academic_transcript_report';
				
				$last_exam = $this->db->get_where('exam' , array('exam_id' => $this->db->order_by('exam_id', 'DESC')->get_where('mark' , array('student_id' => $student_id))->row()->exam_id))->row();
				
				$report = $this->db->order_by('exam_id', 'ASC')->get_where('mark' , array('student_id' => $student_id))->result_array();
				
				$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
				
				$class_id = $enroll->class_id;
				$section_id = $enroll->section_id;
				
				$studentCnt = $this->db->get_where('enroll' , array('class_id' => $class_id,'section_id' => $section_id))->num_rows();
				
				$students = $this->db->order_by('student_id', 'ASC')->get_where('mark' , array('class_id' => $class_id,'section_id' => $section_id))->result_array();
				
				$data['studentCnt'] = $studentCnt;
				$data['students'] = $students;
				
				$data['overall_performance'] = ($last_exam->date !='')?'Good':'';
				$data['exam_date'] = ($last_exam->date !='')?date('d M Y',strtotime($last_exam->date)):'';				 
				$data['report'] = $report;
				
				$template = "backend/principal/academictranscript_pdf_report";
			break;
			default:
			break;			
		}
 
		$location = __DIR__ .'/assets/pdf/';
		
		$content = $this->load->view($template, $data, true);		
		
        $name = $report_name . date('Y_m_d_H_i_s') . '.pdf';		
	
		$stylesheet = file_get_contents('http://apps.classteacher.school/assets/css/pdf_style.css');
		
        $pdfl->WriteHTML($stylesheet,1);
     
		$pdfl->WriteHTML($content,2);
			 	
		$pdfl->Output($name, 'I');		
		
		
	} 
	
	
	
	function academic_report_detail($param1 = '',$param2 = 1)
	{
		$this->load->library('pdfl');
        $pdfl = $this->pdfl->load();
		$pdfl->debug = true;

		$student_id = $param1;
		
		$student = $this->db->get_where('student' , array('student_id' => $student_id))->row();
		$data['stu_student_id'] = $student->student_id;
		$data['student_name'] = $student->name;
		$data['student_address'] = $student->address;
		$data['student_phone'] = $student->phone;
		$data['student_code'] = $student->student_code;
		$data['student_birthday'] = $student->birthday;
		$data['student_admission'] = $student->date_of_admission;
		$data['school_image'] = $this->crud_model->get_image_url('school',$student->school_id);
		
		$parent = $this->db->get_where('parent' , array('parent_id' => $student->parent_id))->row();
		$data['parent_name'] = $parent->name;
		
		$school_name = $this->db->get_where('school' , array('school_id' => $student->school_id))->row();
		$data['school_name_pre'] =  $school_name->school_name;
		$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
		$class_id = $enroll->class_id;
		$data['stu_class_id'] = $enroll->class_id;
		$section_id = $enroll->section_id;
		$data['stu_section_id'] = $enroll->section_id;
		$data['stu_year'] =  $enroll->year;
		
		$markde = $this->db->get_where('mark' , array('student_id' => $student_id))->row();
		$examid = $markde->exam_id;
		$data['stu_examid'] = $markde->exam_id;
		
		$examde = $this->db->get_where('exam' , array('exam_id' => $examid))->row();
		$data['exam_name'] = $examde->name;
		$data['class_name'] = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
		
		$teacher_name = $this->db->get_where('teacher' , array('teacher_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->teacher_id))->row()->name;
		
		if($teacher_name == '')
			$teacher_name = $this->db->get_where('principal' , array('principal_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->principal_id))->row()->name;
		
		$data['class_teacher'] = $teacher_name;
		
		
		
		switch($param2){
		
		
			case 5:
			
				$report_name = 'academic_transcript_report';
				
				$last_exam = $this->db->get_where('exam' , array('exam_id' => $this->db->order_by('exam_id', 'DESC')->get_where('mark' , array('student_id' => $student_id))->row()->exam_id))->row();
				
				$report = $this->db->order_by('exam_id', 'ASC')->get_where('mark' , array('student_id' => $student_id))->result_array();
				
				$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
				
				$class_id = $enroll->class_id;
				$section_id = $enroll->section_id;
				
				$studentCnt = $this->db->get_where('enroll' , array('class_id' => $class_id,'section_id' => $section_id))->num_rows();
				
				$students = $this->db->order_by('student_id', 'ASC')->get_where('mark' , array('class_id' => $class_id,'section_id' => $section_id))->result_array();
				
				$data['studentCnt'] = $studentCnt;
				$data['students'] = $students;
				
				$data['overall_performance'] = ($last_exam->date !='')?'Good':'';
				$data['exam_date'] = ($last_exam->date !='')?date('d M Y',strtotime($last_exam->date)):'';				 
				$data['report'] = $report;
				
				$template = "backend/principal/academictranscriptdetailed_pdf_report";
			break;
			default:
			break;			
		}
 
		$location = __DIR__ .'/assets/pdf/';
		
		$content = $this->load->view($template, $data, true);		
		
        $name = $report_name . date('Y_m_d_H_i_s') . '.pdf';		
	
		$stylesheet = file_get_contents('http://apps.classteacher.school/assets/css/pdf_style.css');
		
        $pdfl->WriteHTML($stylesheet,1);
     
		$pdfl->WriteHTML($content,2);
			 	
		$pdfl->Output($name, 'I');		

	}
	
	function schooltype()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
		$this->session->set_userdata('login_type', 'admin');
        $page_data['page_name']  = 'schooltype';
        $page_data['page_title'] = get_phrase('admin_schooltype');
        $this->load->view('backend/index', $page_data);
    }
	
	/* Time Table Settings Added Start */
	function timetable_settings()
	{
		$this->session->userdata('school_id');
		$page_data['page_name']  = 'timetable_settings';
		$page_data['page_title'] = get_phrase('timetable_settings');
		$count_array = $this->db->get_where('timetable_settings', array('school_id' => $this->session->userdata('school_id')))->result_array();
		
		if(count($count_array) == 0)
		{
			$srr[] = array('start_time'=>'','period_duration'=>'','break_duration'=>'','break_between_period'=>'','lunch_duration'=>'','lunch_between_period'=>'');
		}else
		{
			$srr = $count_array;
		}					
		$page_data['edit_data']  = $srr;
		$this->load->view('backend/index', $page_data);
	}
	/* Time Table Settings Added End */
	
}
