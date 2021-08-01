<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Principal extends CI_Controller
{


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
		//if ($this->session->userdata('principal_login') != 1) $this->clearsess();		
    }
	
	function clearsess(){
		
		$login_user_id = $this->session->userdata('login_user_id');
		
		$this->db->where('principal_id' , $login_user_id);
		$this->db->update('principal' , array('logged' => ''));	
		$this->session->sess_destroy();	
	}

    /***default functin, redirects to login page if no principal logged in yet***/
    /*public function index()
    {		
        if ($this->session->userdata('principal_login') != 1){
			$this->clearsess();		 
			redirect(site_url('login'), 'refresh');
		}
        else{
            redirect(site_url('principal/dashboard'), 'refresh');
		}
    }*/

    /***TEACHER DASHBOARD***/
    function dashboard()
    {
		 
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$this->session->set_userdata('login_type', 'principal');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('principal_dashboard');
     	 
        $this->load->view('backend/index', $page_data);
    }
	
	//NEW FUNCTION
	
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
		$main_exam	=	$this->input->post('exam');
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
		
		//$page_data['page_name']  = 'score_sheet';
       /// $page_data['page_title'] = get_phrase('score_sheet');
       /// $out=$this->load->view('score_sheet', $page_data);
	//$this->set_output($out); 
	echo 1;
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
		$main_exam	=	$this->input->post('exam');
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
	
	
	 function broad_sheet()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$class		=	$this->input->post('form');
		$main_exam	=	$this->input->post('exam');
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
	
	
	
	 function printsheet()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$stream		=	$this->input->post('stream');
		$cutoff		=	$this->input->post('cuttoff');
		$term		=	$this->input->post('term');
		$year		=	$this->input->post('year');
		$class		=	$this->input->post('form');
		$main_exam	=	$this->input->post('exam');
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
        echo $this->session->userdata('pdf').'.pdf';
		
    }
	
	//END
	
	
	
	
	
	function principal_profile($principal_id)
	{
		if ($this->session->userdata('principal_login') != 1) {
		  redirect(base_url(), 'refresh');
		}
		$page_data['page_name']  = 'principal_profile';
			$page_data['page_title'] = get_phrase('principal_streams');
		$page_data['principal_id']  = $principal_id;
			$this->load->view('backend/index', $page_data);
	}
	
	function principal_table($principal_id)
	{
		if ($this->session->userdata('principal_login') != 1) {
		  redirect(base_url(), 'refresh');
		}
		$page_data['page_name']  = 'principal_table';
		$principal = $this->crud_model->get_type_name_by_id('principal',$principal_id); 
		$page_title = "$principal timetable";
		$page_data['page_title'] = get_phrase($page_title);
		$page_data['principal_id']  = $principal_id;
			$this->load->view('backend/index', $page_data);
	}
	
	function teacher_profile($teacher_id)
	{
		if ($this->session->userdata('principal_login') != 1) {
		  redirect(base_url(), 'refresh');
		}
		$page_data['page_name']  = 'teacher_profile';
			$page_data['page_title'] = get_phrase('teacher_classes');
		$page_data['teacher_id']  = $teacher_id;
			$this->load->view('backend/index', $page_data);
	}
	
	function teacher_table($teacher_id)
	{
		if ($this->session->userdata('principal_login') != 1) {
		  redirect(base_url(), 'refresh');
		}
		$page_data['page_name']  = 'teacher_table';
		$teacher = $this->crud_model->get_type_name_by_id('teacher',$teacher_id); 
		$page_title = "$teacher timetable";
		$page_data['page_title'] = get_phrase($page_title);
		$page_data['teacher_id']  = $teacher_id;
			$this->load->view('backend/index', $page_data);
	}
	
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
			$parent_id =0;
            if((int)$validation == 0){
				$parent_id   = $this->db->get_where('parent' , array('email' => $data['email']))->row()->parent_id;
			}
			elseif((int)$validation2 == 0){
				
				$parent_id   = $this->db->get_where('parent' , array('phone' => $data['phone']))->row()->parent_id;
				
				/*$this->session->set_flashdata('error_message' , get_phrase('the_particular_number_is_already_ assigned'));
				redirect(site_url('admin/parent_add/'.$student_id), 'refresh');*/
			}
			
			if($parent_id  == 0){
				$this->db->insert('parent', $data);
				$parent_id = $this->db->insert_id();
			}					 
               
			$pdata['parent_id'] = $parent_id;
			$this->db->where('student_id' , $student_id);
			$this->db->update('student' , $pdata);
			
			$this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
			$this->email_model->account_opening_email('parent', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
		 
			redirect(site_url('principal/parent'), 'refresh');
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
            if ($validation == 1) {
                $this->db->where('parent_id' , $param2);
                $this->db->update('parent' , $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(site_url('principal/parent'), 'refresh');
        }
        if ($param1 == 'delete') {
            $this->db->where('parent_id' , $param2);
            $this->db->delete('parent');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('principal/parent'), 'refresh');
        }
        $page_data['page_title'] 	= get_phrase('all_parents');
        $page_data['page_name']  = 'parent';
        $this->load->view('backend/index', $page_data);
    }


    /*ENTRY OF A NEW STUDENT*/


    /****MANAGE STUDENTS CLASSWISE*****/

	function student_information($class_id = '')
	{
		if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');

		$page_data['page_name']  	= 'student_information';
		$page_data['page_title'] 	= get_phrase('student_information'). " - ".get_phrase('class')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}

  function student_profile($student_id)
  {
    if ($this->session->userdata('principal_login') != 1) {
      redirect(base_url(), 'refresh');
    }
    $page_data['page_name']  = 'student_profile';
		$page_data['page_title'] = get_phrase('student_profile');
    $page_data['student_id']  = $student_id;
		$this->load->view('backend/index', $page_data);
  }

	function student_marksheet($student_id = '') {
        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');
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
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/principal/student_marksheet_print_view', $page_data);
    }



    function get_class_section($class_id)
    {
        $sections = $this->db->get_where('section' , array(
            'class_id' => $class_id
        ))->result_array();
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_subject($class_id)
    {
        $subject = $this->db->get_where('subject' , array(
            'class_id' => $class_id ,'teacher_id'=>$this->session->userdata('principal_id')
        ))->result_array();
        foreach ($subject as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
    /****MANAGE TEACHERS*****/
    function teacher_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
		$school_id = $this->session->userdata('school_id');
        $page_data['teachers']   = $this->db->get_where('teacher' , array(
            'school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('teacher_list');
        $this->load->view('backend/index', $page_data);
    }
	
	function staff_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
        
		$school_id = $this->session->userdata('school_id');
        $page_data['teachers']   = $this->db->get_where('staff' , array(
            'school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'staff';
        $page_data['page_title'] = get_phrase('staff_list');
        $this->load->view('backend/index', $page_data);
    }
	
	function teacher($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'create') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']     = $this->input->post('name');
			$data['tsc_number']     = $this->input->post('tsc_number');
			$data['designation']     = $this->input->post('role');
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
				$this->session->set_flashdata('error_message' , get_phrase('tsc_number_is_already_ assigned_to_teacher'));
			}			
			else{
                $this->db->insert('teacher', $data);
                $teacher_id = $this->db->insert_id();
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $teacher_id . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('teacher', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }    

            redirect(site_url('principal/teacher_list'), 'refresh');
        }
        if ($param1 == 'do_update') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']        = $this->input->post('name');
			$data['tsc_number']        = $this->input->post('tsc_number');
			$data['designation']     = $this->input->post('role');
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

            redirect(site_url('principal/teacher_list'), 'refresh');
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
            redirect(site_url('principal/teacher_list'), 'refresh');
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('manage_teacher');
        $this->load->view('backend/index', $page_data);
    }
	
	
	function staff($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']     = $this->input->post('name');
			$data['designation'] = $this->input->post('role');
            $data['email']    = $this->input->post('email');           
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
             
            $validation = 1; //email_validation($data['email']);
            if($validation == 1){
                $this->db->insert('staff', $data);
                $teacher_id = $this->db->insert_id();
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $teacher_id . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                $this->email_model->account_opening_email('staff', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(site_url('principal/staff_list'), 'refresh');
        }
        if ($param1 == 'do_update') {
			
			$data['school_id']    = $this->input->post('school_id');
            $data['name']        = $this->input->post('name');
			$data['designation']     = $this->input->post('role');
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
            
            $validation = email_validation_for_edit($data['email'], $param2, 'staff');
            if($validation == 1){
                $this->db->where('staff_id', $param2);
                $this->db->update('staff', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $param2 . '.jpg');
                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('this_email_id_is_not_available'));
            }

            redirect(site_url('principal/staff_list'), 'refresh');
        }         
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('staff', array(
                'staff_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('staff_id', $param2);
            $this->db->delete('staff');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('principal/staff_list'), 'refresh');
        }
        $page_data['staffs']   = $this->db->get_where('staff', array('school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'staff';
        $page_data['page_title'] = get_phrase('manage_staff');
        $this->load->view('backend/index', $page_data);
    }

    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'create') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');

            if ($this->input->post('teacher_id') != null) {
                $data['teacher_id'] = $this->input->post('teacher_id');
            }
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($data['class_id'] != '') {
                $this->db->insert('subject', $data);
                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('select_class'));
            }

            redirect(site_url('principal/subject/'.$data['class_id']), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name']       = $this->input->post('name');
            $data['class_id']   = $this->input->post('class_id');

            if ($this->input->post('teacher_id') != null) {
                $data['teacher_id'] = $this->input->post('teacher_id');
            }
            else{
                $data['teacher_id'] = null;
            }
            $data['year']       = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
            if ($data['class_id'] != '') {
               $this->db->where('subject_id', $param2);
               $this->db->update('subject', $data);
               $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            }
            else{
                $this->session->set_flashdata('error_message' , get_phrase('select_class'));
            }

            redirect(site_url('principal/subject/'.$data['class_id']), 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            redirect(site_url('principal/subject/'.$param3), 'refresh');
        }
		 $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array(
            'class_id' => $param1,
            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->view('backend/index', $page_data);
    }



    /****MANAGE EXAM MARKS*****/
    function marks_manage()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'marks_manage_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_selector()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');

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
        redirect(site_url('principal/marks_manage_view/'. $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']) , 'refresh');

    }
else{
        $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
}
}
    function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        if ($class_id != '' && $exam_id != '') {
        $marks_of_students = $this->db->get_where('mark' , array(
            'exam_id' => $exam_id,
                'class_id' => $class_id,
                    'section_id' => $section_id,
                        'year' => $running_year,
                            'subject_id' => $subject_id
        ))->result_array();
        foreach($marks_of_students as $row) {
            $obtained_marks = $this->input->post('marks_obtained_'.$row['mark_id']);
            $comment = $this->input->post('comment_'.$row['mark_id']);
            $this->db->where('mark_id' , $row['mark_id']);
            $this->db->update('mark' , array('mark_obtained' => $obtained_marks , 'comment' => $comment));
        }
        $this->session->set_flashdata('flash_message' , get_phrase('marks_updated'));
        redirect(site_url('principal/marks_manage_view/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id), 'refresh');
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
        $this->load->view('backend/principal/marks_get_subject' , $page_data);
    }


    // ACADEMIC SYLLABUS
    function academic_syllabus($class_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
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
        $data['title']                  =   $this->input->post('title');
        $data['description']            =   $this->input->post('description');
        $data['class_id']               =   $this->input->post('class_id');
        if ($this->input->post('subject_id') != null) {
           $data['subject_id']          =   $this->input->post('subject_id');
        }
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
        redirect(site_url('principal/academic_syllabus/'. $data['class_id']) , 'refresh');

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

    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');

        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(site_url('principal/backup_restore'), 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(site_url('principal/backup_restore'), 'refresh');
        }

        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
            $validation = email_validation_for_edit($data['email'], $this->session->userdata('principal_id'), 'principal');
            if ($validation == 1) {
                $this->db->where('principal_id', $this->session->userdata('principal_id'));
                $this->db->update('principal', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/principal_image/' . $this->session->userdata('principal_id') . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('principal/manage_profile/'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

            $current_password = $this->db->get_where('principal', array(
                'principal_id' => $this->session->userdata('principal_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('principal_id', $this->session->userdata('principal_id'));
                $this->db->update('principal', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_mismatch'));
            }
            redirect(site_url('principal/manage_profile/'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('principal', array(
            'principal_id' => $this->session->userdata('principal_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	
	function manage_notification($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_notification') {
            $data['sound']        = $this->input->post('sound');
            $data['vibrate']       = $this->input->post('vibrate');
			$data['dnd']       = $this->input->post('dnd');
            
            $this->db->where('principal_id', $this->session->userdata('principal_id'));
            $this->db->update('principal', $data);
               
            $this->session->set_flashdata('flash_message', get_phrase('updated'));            
            redirect(site_url('principal/manage_notification/'), 'refresh');
        }
         
        $page_data['page_name']  = 'notification_settings';
        $page_data['page_title'] = get_phrase('notification_setting');
        $page_data['edit_data']  = $this->db->get_where('principal', array(
            'principal_id' => $this->session->userdata('principal_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	
	function feedback($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        
        if ($param1 == 'update_feedback') {
            $data['feedback']  = $this->input->post('feedback');           

			$this->db->where('principal_id', $this->session->userdata('principal_id'));
			$this->db->update('principal', array('feedback' => $data['feedback']
			));
			$this->session->set_flashdata('flash_message', get_phrase('updated'));
             
            redirect(site_url('principal/feedback/'), 'refresh');
        }
        $page_data['page_name']  = 'feedback';
        $page_data['page_title'] = get_phrase('feedback');
        $page_data['edit_data']  = $this->db->get_where('principal', array(
            'principal_id' => $this->session->userdata('principal_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	
	function assignments($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$login_user_id = $this->session->userdata('login_user_id');
        if ($param1 == 'create') {

	        	if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/assignments/'. "ASSIGNMENT_(".date('Y-m-d',strtotime($this->input->post('given_date'))).")".$_FILES["userfile"]["name"])){
	        		$myfilepath = "uploads/assignments/". "ASSIGNMENT_(".date('Y-m-d',strtotime($this->input->post('given_date'))).")".$_FILES["userfile"]["name"];
	        	}else{
	                $myfilepath = "";
	        	}        
			
			$data['class_id'] = $this->input->post('class_id');
			$data['section_id'] = $this->input->post('section_id');
			$data['subject_id'] = $this->input->post('subject_id');
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('details');          
			$data['user_id'] =  $login_user_id;
			$data['role_id'] =  3;
			$data['filepath'] =  $myfilepath;
            $data['given_date'] = date('Y-m-d',strtotime($this->input->post('given_date')));
            $data['due_date'] = date('Y-m-d',strtotime($this->input->post('due_date')));
            $this->db->insert('assignments', $data);
			$assignments_id = $this->db->insert_id();
			
			$noti_arr['title'] = 'Add Update Assigment';
			$noti_arr['content'] = 'Add Update Assigment';
			$noti_arr['type'] = '3';
			$noti_arr['type_id'] = $assignments_id;
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			$students = $this->db->get_where('enroll', array('class_id' => $data['class_id'],'section_id' => $data['section_id']))->result_array();
            foreach ($students as $row)
            {				
				$noti_arr['student_id'] = $student_id = $row['student_id'];
				$this->db->insert('notifications', $noti_arr);	 		
				
				$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
					
				$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'Add Update Assigment');
			}				
					             
            $this->session->set_flashdata('flash_message' , get_phrase('assignments_added_successfully'));
            redirect(site_url('principal/assignments'), 'refresh');
        }
        if ($param1 == 'do_update') {
            
            $data['class_id'] = $this->input->post('class_id');
			$data['section_id'] = $this->input->post('section_id');
			$data['subject_id'] = $this->input->post('subject_id');
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('details');          
			$data['user_id'] =  $login_user_id;
			$data['role_id'] =  3;
            $data['given_date'] = date('Y-m-d',strtotime($this->input->post('given_date')));
            $data['due_date'] = date('Y-m-d',strtotime($this->input->post('due_date')));

            $this->db->where('assignment_id', $param2);
            $this->db->update('assignments', $data);
 
            $this->session->set_flashdata('flash_message' , get_phrase('assignment_updated'));
            redirect(site_url('principal/assignments'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('assignments', array(
                'assignment_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('assignment_id', $param2);
            $this->db->delete('assignments');
            $this->session->set_flashdata('flash_message' , get_phrase('assignment_deleted'));
            redirect(site_url('principal/assignments'), 'refresh');
        }
		
		if ($param1 == 'do_submit') {
			
            foreach ($this->input->post('student_id') as $id) {

				$data['assignment']  = $this->input->post('assignment');
                $data['student_id'] = $id;
                $data['submit_on'] = date('Y-m-d',strtotime($this->input->post('submit_on')));
                $data['status']  = 2;                 
                $this->db->insert('assignment_submit', $data);                     
            }

            $this->session->set_flashdata('flash_message' , get_phrase('assignment_submit_successfully'));
            redirect(site_url('principal/assignment_submit'), 'refresh');
        }
        
        $page_data['page_name']  = 'assignments';
        $page_data['page_title'] = get_phrase('assignments');
        $this->load->view('backend/index', $page_data);
    }

    function assignment_edit($assignment_id) {
      if ($this->session->userdata('principal_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'assignment_edit';
      $page_data['assignment_id'] = $assignment_id;
      $page_data['page_title'] = get_phrase('edit_event');
      $this->load->view('backend/index', $page_data);
    }

    function reload_assignment() {
        $this->load->view('backend/principal/assignments');
    }
	
	function assignment_submit()
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
		$login_user_id = $this->session->userdata('login_user_id');               
        $page_data['page_name']  = 'assignment_submit';
        $page_data['page_title'] = get_phrase('assignment_submit');
        $this->load->view('backend/index', $page_data);
    }
	
	function assignmentsubmit_edit($assignment_id) {
      if ($this->session->userdata('principal_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'assignmentsubmit_edit';
      $page_data['assignment_id'] = $assignment_id;
      $page_data['page_title'] = get_phrase('assignmentsubmit_edit');
      $this->load->view('backend/index', $page_data);
    }

    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($class_id)
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'class_routine';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->load->view('backend/principal/class_routine_print_view' , $page_data);
    }

	/****** DAILY ATTENDANCE *****************/
    function manage_attendance($class_id)
    {
        if($this->session->userdata('principal_login')!=1)
            redirect(base_url() , 'refresh');

        $class_name = $this->db->get_where('class' , array(
            'class_id' => $class_id
        ))->row()->name;
        $page_data['page_name']  =  'manage_attendance';
        $page_data['class_id']   =  $class_id;
        $page_data['page_title'] =  get_phrase('manage_attendance_of_class') . ' ' . $class_name;
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '' , $section_id = '' , $timestamp = '')
    {
        if($this->session->userdata('principal_login')!=1)
            redirect(base_url() , 'refresh');
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
        redirect(site_url('principal/manage_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['timestamp']),'refresh');
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
                            //$this->sms_model->send_sms($message,$receiver_phone);
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
        redirect(site_url('principal/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$timestamp ), 'refresh');
    }


    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');

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

        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');
        $this->load->view('backend/index', $page_data);

    }

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(base_url(), 'refresh');
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
			$data['tags']           = $this->input->post('tags');
			$data['type']           = $this->input->post('type');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);
            redirect(site_url('principal/noticeboard/'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
			$data['tags']           = $this->input->post('tags');
			$data['type']           = $this->input->post('type');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);
            $this->session->set_flashdata('flash_message', get_phrase('notice_updated'));
            redirect(site_url('principal/noticeboard/'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            redirect(site_url('principal/noticeboard/'), 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices']    = $this->db->get_where('noticeboard',array('school_id'=>$school_id,'status'=>1))->result_array();
        $this->load->view('backend/index', $page_data);
    }


    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/
    function document($do = '', $document_id = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect('login', 'refresh');
        if ($do == 'upload') {
            move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/document/" . $_FILES["userfile"]["name"]);
            $data['document_name'] = $this->input->post('document_name');
            $data['file_name']     = $_FILES["userfile"]["name"];
            $data['file_size']     = $_FILES["userfile"]["size"];
            $this->db->insert('document', $data);
            redirect(site_url('principal/manage_document'), 'refresh');
        }
        if ($do == 'delete') {
            $this->db->where('document_id', $document_id);
            $this->db->delete('document');
            redirect(site_url('principal/manage_document'), 'refresh');
        }
        $page_data['page_name']  = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $page_data['documents']  = $this->db->get('document')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*********MANAGE STUDY MATERIAL************/
    function study_material($task = "", $document_id = "")
    {
        if ($this->session->userdata('principal_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create")
        {
            $this->crud_model->save_study_material_info();
            $this->session->set_flashdata('flash_message' , get_phrase('study_material_info_saved_successfuly'));
            redirect(site_url('principal/study_material/'), 'refresh');
        }

        if ($task == "update")
        {
            $this->crud_model->update_study_material_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('study_material_info_updated_successfuly'));
            redirect(site_url('principal/study_material/'), 'refresh');
        }

        if ($task == "delete")
        {
            $this->crud_model->delete_study_material_info($document_id);
            redirect(site_url('principal/study_material/'), 'refresh');
        }

        $data['study_material_info']    = $this->crud_model->select_study_material_info_for_teacher();
        $data['page_name']              = 'study_material';
        $data['page_title']             = get_phrase('study_material');
        $this->load->view('backend/index', $data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('principal_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        $max_size = 2097152;
        if ($param1 == 'send_new') {

            // Folder creation
            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                  redirect(site_url('principal/message/message_new/'), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('principal/message/message_read/'.$message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {

            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                  redirect(site_url('principal/message/message_read/'.$param2), 'refresh');

              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('principal/message/message_read/'.$param2), 'refresh');
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

    //GROUP MESSAGE
    function group_message($param1 = "group_message_home", $param2 = ""){
      if ($this->session->userdata('principal_login') != 1)
          redirect(base_url(), 'refresh');
      $max_size = 2097152;

      if ($param1 == 'group_message_read') {
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
              redirect(site_url('principal/group_message/group_message_read/'.$param2), 'refresh');
          }
          else{
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);  //$param2 = message_thread_code
        $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
          redirect(site_url('principal/group_message/group_message_read/'.$param2), 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group_message';
      $page_data['page_title']                = get_phrase('group_messaging');
      $this->load->view('backend/index', $page_data);
    }

    // MANAGE QUESTION PAPERS
    function question_paper($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('principal_login') != 1)
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == "create")
        {
            $this->crud_model->create_question_paper();
            $this->session->set_flashdata('flash_message', get_phrase('data_created_successfully'));
            redirect(site_url('principal/question_paper'), 'refresh');
        }

        if ($param1 == "update")
        {
            $this->crud_model->update_question_paper($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(site_url('principal/question_paper'), 'refresh');
        }

        if ($param1 == "delete")
        {
            $this->crud_model->delete_question_paper($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
            redirect(site_url('principal/question_paper'), 'refresh');
        }

        $data['page_name']  = 'question_paper';
        $data['page_title'] = get_phrase('question_paper');
        $this->load->view('backend/index', $data);
    }

    // Details of searched student
    function student_details(){
      if ($this->session->userdata('principal_login') != 1)
          redirect(base_url(), 'refresh');

      $student_identifier = $this->input->post('student_identifier');
      $query_by_code = $this->db->get_where('student', array('student_code' => $student_identifier));

      if ($query_by_code->num_rows() == 0) {
        $this->db->like('name', $student_identifier);
        $query_by_name = $this->db->get('student');
        if ($query_by_name->num_rows() == 0) {
          $this->session->set_flashdata('error_message' , get_phrase('no_student_found'));
            redirect(site_url('principal/dashboard'), 'refresh');
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
    
    
    function class_layout_change($lid,$stuid,$place=0){
		
		 
		 $cnt = $this->db->get_where('class_layout_places', array('layout_id' => $lid,'position' => $place))->num_rows();
		
		if($cnt >0){
			
			$query_update_current_position = $this->db->get_where('class_layout_places', array('layout_id' => $lid, 'student_id' => $stuid, 'status' => 'placed' ))->result_array();
			//print_r($query_update_current_position);
			//exit;
			if(count($query_update_current_position) == 1)
			{
				$this->db->where('position' , $query_update_current_position[0]['position']);
				$this->db->where('layout_id' , $lid);
				$this->db->where('id' , $query_update_current_position[0]['id']);
				$this->db->update('class_layout_places' , array('student_id' =>0,'status'=>'free'
                ));
			}
		    $this->db->where('position' , $place);
            $this->db->where('layout_id' , $lid);
            $this->db->update('class_layout_places' , array('student_id' =>$stuid,'status'=>'placed'
                ));
		}else{
		    $data['student_id']  = $stuid;
            $data['layout_id']   = $lid;		
            $data['position']   = $place;
            $data['status']   = 'placed';			
            $this->db->insert('class_layout_places', $data);
		}
	
	}
	
	function behaviour_update($stuid){
		if ($this->session->userdata('principal_login') != 1)
          redirect(base_url(), 'refresh');
		
		$login_user_id = $this->session->userdata('login_user_id');
		$behaviours = $this->input->post('behaviour');
		$reports = $this->input->post('report');
		$actions = $this->input->post('action');

		$i=0;
		foreach($behaviours as $final_result){
				$value_update = $this->input->post('others_'.$final_result);
				$this->db->where('student_id' , $stuid);
				$this->db->where('behaviour' , $final_result);
				$this->db->update('behaviour_reports' , array('others'=>$value_update));
			$i++;
			
		}

		foreach($behaviours as $k => $behaviour){
			$report = $reports[$k];
			$action = ($report == 'no')?$actions[$k]:'';
			$cnt = $this->db->get_where('behaviour_reports', array('student_id' => $stuid,'behaviour' => $behaviour))->num_rows();
		
			if($cnt >0){
                $others = $this->input->post('others_'.$behaviour);
				$this->db->where('student_id' , $stuid);
				$this->db->where('behaviour' , $behaviour);

				$this->db->update('behaviour_reports' , array('report' =>$report,'action'=>$action,'others'=>$others,'updated_on'=>date('Y-m-d H:i:s')));
                //var_dump($behaviour); echo "<hr>";
			}else{

				//$i=0;
				foreach($behaviours as $final_res){
				$value_upd = $this->input->post('others_'.$final_res);	
				$data['user_id']  = $login_user_id;
				$data['role_id']  = 3;
				$data['student_id']  = $stuid;
				$data['behaviour']   = $behaviour;
				$data['report']   = $report;
				$data['action']   = $action;
				$data['others']   = $value_upd;
				$this->db->insert('behaviour_reports', $data);
				//$i++;
				}
			}	
		}

		//exit();
		//$this->session->set_flashdata('flash_message', get_phrase('behaviour_updated_successful'));
		redirect(site_url('admin/student_behaviour/'.$stuid), 'refresh');
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
                      $this->session->set_flashdata('error_message', get_phrase('some_classes_are_not_available'));
					$validation = 0;  
                }
				if((int)$section_id == 0){
                      $this->session->set_flashdata('error_message', get_phrase('some_streams_are_not_available'));
					  $validation = 0;  
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
					$this->session->set_flashdata('flash_message', get_phrase('timetable_imported'));
                } 
            	 
			}  
			
			redirect(site_url('principal/timetable_upload'), 'refresh');               
        }        
    	 
        $page_data['page_name']  = 'timetable_upload';
        $page_data['page_title'] = get_phrase('timetable_import');
        $this->load->view('backend/index', $page_data); 
    }
    
    /******MANAGE OWN School Timetable Start ***/
    function manage_timetable($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('principal_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_timetable_info') {
            $data['start_time']        = $this->input->post('start_time');
            $data['period_duration']       = $this->input->post('period_duration');
			$data['end_time']       = $this->input->post('end_time');
			$data['short_break_duration']       = $this->input->post('short_break_duration');
			$data['short_break_startime']       = $this->input->post('short_break_startime');
			$data['tea_break_duration']       = $this->input->post('tea_break_duration');
			$data['tea_break_startime']       = $this->input->post('tea_break_startime');
			$data['lunch_break_duration']       = $this->input->post('lunch_break_duration');
			$data['lunch_break_startime']       = $this->input->post('lunch_break_startime');
			$data['school_id']       = $this->session->userdata('school_id');

            $validation = timetable_settings_for_edit($data);

            if ($validation == 1) {
                $this->db->where('school_id', $this->session->userdata('school_id'));
                $this->db->update('timetable_settings', $data);
                $this->session->set_flashdata('flash_message', get_phrase('Timetable Settings Updated Successfully...'));
            }
            else{
				
				$this->db->insert('timetable_settings', $data);
				$assignments_id = $this->db->insert_id();
                $this->session->set_flashdata('flash_message', get_phrase('Timetable Settings Added Successfully...'));
            }
           // redirect(site_url('principal/manage_timetable/'), 'refresh');
        }

        $page_data['page_name']  = 'timetable_settings';
        $page_data['page_title'] = get_phrase('timetable_settings');
        $page_data['edit_data']  = $this->db->get_where('timetable_settings', array(
            'school_id' => $this->session->userdata('school_id')
        ))->result_array(); 

       $this->load->view('backend/index', $page_data);
    }
	/******MANAGE OWN School Timetable End ***/
}
