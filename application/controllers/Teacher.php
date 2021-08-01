<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->load->library('Pdftc');
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		//if ($this->session->userdata('teacher_login') != 1) $this->clearsess();		
    }
	
	function clearsess(){
		
		$login_user_id = $this->session->userdata('login_user_id');
		
		$this->db->where('teacher_id' , $login_user_id);
		$this->db->update('teacher' , array('logged' => ''));	
		$this->session->sess_destroy();	
	}

    /***default functin, redirects to login page if no teacher logged in yet***/
    public function index()
    {
       $login_user_id = $this->session->userdata('login_user_id');
		
        if ($this->session->userdata('teacher_login') != 1){
			$this->clearsess();			 
			redirect(site_url('login'), 'refresh');
		}
        else{
            redirect(site_url('teacher/dashboard'), 'refresh');
		}
    }

    /***TEACHER DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
		$this->session->set_userdata('login_type', 'teacher');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('teacher_dashboard');
        $this->load->view('backend/index', $page_data);
    }
	
	function teacher_profile($teacher_id)
	{
		if ($this->session->userdata('teacher_login') != 1) {
		  redirect(base_url(), 'refresh');
		}
		$page_data['page_name']  = 'teacher_profile';
			$page_data['page_title'] = get_phrase('teacher_streams');
		$page_data['teacher_id']  = $teacher_id;
			$this->load->view('backend/index', $page_data);
	}
	
	function teacher_table($teacher_id)
	{
		if ($this->session->userdata('teacher_login') != 1) {
		  redirect(base_url(), 'refresh');
		}
		$page_data['page_name']  = 'teacher_table';
		$teacher = $this->crud_model->get_type_name_by_id('teacher',$teacher_id); 
		$page_title = "$teacher timetable";
		$page_data['page_title'] = get_phrase($page_title);
		$page_data['teacher_id']  = $teacher_id;
			$this->load->view('backend/index', $page_data);
	}


    /*ENTRY OF A NEW STUDENT*/


    /****MANAGE STUDENTS CLASSWISE*****/

	function student_information($class_id = '')
	{
		if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

		$page_data['page_name']  	= 'student_information';
		$page_data['page_title'] 	= get_phrase('student_information'). " - ".get_phrase('stream')." : ".
											$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
	function student_report($class_id = '',$report='' ,$offset=0)
	{
		if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
		
		if($report ==1) $report_title='health_report';
		elseif($report ==2) $report_title='behaviour_report';
		elseif($report ==3) $report_title='fees_report';
		elseif($report ==4) $report_title='attendance_report';
		elseif($report ==5) $report_title='education_report';
        elseif($report ==6) $report_title='Subject Reports';

		$page_data['offset']=$offset;
        $page_data['page_name'] = 'student_report';
		$page_data['page_title'] = get_phrase($report_title). " - ".get_phrase('stream')." : ".
		$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$page_data['report'] 	= $report;
		$this->load->view('backend/index', $page_data);
	}

  function student_profile($student_id)
  {
    if ($this->session->userdata('teacher_login') != 1) {
      redirect(base_url(), 'refresh');
    }
    $page_data['page_name']  = 'student_profile';
		$page_data['page_title'] = get_phrase('student_profile');
    $page_data['student_id']  = $student_id;
		$this->load->view('backend/index', $page_data);
  }

	function student_marksheet($student_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
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
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/teacher/student_marksheet_print_view', $page_data);
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
            'class_id' => $class_id ,'teacher_id'=>$this->session->userdata('teacher_id')
        ))->result_array();
        foreach ($subject as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }
    /****MANAGE TEACHERS*****/
    function teacher_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        $page_data['teachers']   = $this->db->get('teacher')->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('teacher_list');
        $this->load->view('backend/index', $page_data);
    }



    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
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

            redirect(site_url('teacher/subject/'.$data['class_id']), 'refresh');
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

            redirect(site_url('teacher/subject/'.$data['class_id']), 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('subject', array(
                'subject_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('subject_id', $param2);
            $this->db->delete('subject');
            redirect(site_url('teacher/subject/'.$param3), 'refresh');
        }
		 $page_data['class_id']   = $param1;
        $page_data['subjects']   = $this->db->get_where('subject' , array(
            'class_id' => $param1,'teacher_id'=>$this->session->userdata('teacher_id'),
            'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
        ))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->load->view('backend/index', $page_data);
    }



    function marks_manage()
    {

        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'data_entry_marks';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }


    function marks_manage_saving(){
      $arrstudis = $this->input->post('studis');
      $arrstudismarks = $this->input->post('studismarks');
      $studisubmarksmain = $this->input->post('studisubmarksmain');
      $term = $this->input->post('term');
      $subject_id = $this->input->post('subject');
      $examtype = $this->input->post('examtype');
      $class_id = $this->input->post('fr');
      $section_id = $this->input->post('st');
      $year = $this->input->post('year');
      $outof = $this->input->post('outof');
      $limit = $this->input->post('limit');

      $user_id = $this->session->userdata('login_user_id');
        $sql = "";
        $role_id = 3;
        switch($role_id) {
            case 1:
                $sql = "SELECT *  FROM parent WHERE parent_id = '".$user_id."'";
                break;
            case 2:
                $sql = "SELECT *  FROM teacher  WHERE teacher_id = '".$user_id."'";
                break;
            case 3:
                $sql = "SELECT *  FROM principal  WHERE principal_id = '".$user_id."'";
                break;
            default:
                break;
        }
        $schoolid = 0;
        $res = $this->db->query($sql);
        $schoolidArr = $res->result();
        if(count($schoolidArr)){
            $schoolidArr = $schoolidArr[0];
            $schoolid = $schoolidArr->school_id;
        }


      $cnt = 0;
        $subject = $this->db->get_where("subject", array("subject_id"=>$subject_id))->row()->name;
        foreach($arrstudis as $studentid){
        
    
         foreach($studisubmarksmain[$cnt] as $submarks){
            $this->db->query("DELETE FROM sub_subject_marks WHERE studentid = '".$submarks[0]."' AND examtype='".$examtype."' AND term='".$term."' AND subject='".$submarks[2]."'");
                    $sqlsubj = "INSERT INTO sub_subject_marks 
                            (`studentid`,`examtype`,`subject`,`term`,`marks`,`teacher`,`school`)
                            VALUES(
                            '".$submarks[0]."',
                            '".$examtype."',
                            '".$submarks[2]."',
                            '".$term."',
                            '".$submarks[1]."',
                            '".$this->session->userdata('login_user_id')."',
                            '".$schoolid."'
                            )
                            ";
                   $this->db->query($sqlsubj);
               }

            $data['studentid'] = $studentid;
            $data['examtype'] = $examtype;
            $data['names'] = "";
            $data['subject'] = $subject;
            $data['term'] = $term;
            $data['marks'] = $arrstudismarks[$cnt];
            $data['teacher'] = $this->session->userdata('login_user_id');
            $data['outof'] = $outof;
            $data['limit'] = $limit;
            $data['school'] = $schoolid;
            $sql = "DELETE FROM student_marks WHERE studentid = '".$studentid."' AND term = '" . $term . "'  AND subject = '" . $subject . "' AND examtype = '" . $examtype . "'  ";
            $this->db->query($sql);
            $this->db->insert('student_marks', $data);
            //link to the old table


            $exam_id = $this->db->get_where("exams", array("Term1"=>$examtype))->row()->ID;

            //link to the old table
            $sqlmark = "DELETE FROM mark WHERE student_id = '".$studentid."' AND class_id = '".$class_id."' AND  subject_id = '" . $subject_id . "' AND exam_id = '" . $exam_id . "'  ";
            $this->db->query($sqlmark);

            $mark['student_id'] = $studentid;
            $mark['subject_id'] = $subject_id;
            $mark['class_id'] = $class_id;
            $mark['section_id'] = $section_id;
            $mark['exam_id'] = $exam_id;
            $mark['mark_obtained'] = $arrstudismarks[$cnt];
            $mark['mark_total'] = $outof;
            $mark['year'] = "2018-2019"; //temporary
            $mark['comment'] = "test";
            $this->db->insert('mark', $mark);

            $cnt ++;
        }
        echo json_encode(array("response"=>"Saved!"));
    }


    function getSubsubjectMark($subjectid,$studentid,$examtype,$term){
        $sqlMark = "SELECT * FROM sub_subject_marks WHERE examtype = '".$examtype."' AND subject='".$subjectid."' AND term='".$term."' AND studentid = '".$studentid."'";   
        $query = $this->db->query($sqlMark);
        $rowmark =   $query->row();
        return ($rowmark->marks)?(int)$rowmark->marks:""; 
    }

    function marks_manage_saved()
    {
        $class_id = $this->input->post('fr');
        $stream_id = $this->input->post('st');
        $examtype = $this->input->post('examtype');
        $year = $this->input->post('year');
        $term = $this->input->post('term');
        $subjectid = $this->input->post('subject');


        $subject = $this->db->get_where("subject", array("subject_id"=>$subjectid))->row()->name;

        $qry = '
        
                              SELECT * 
                                        FROM enroll e 
                                        JOIN student s ON s.student_id = e.student_id  
                                        LEFT JOIN student_marks sm ON sm.studentid = s.student_id AND sm.term = "'.$term.'" AND sm.subject = "'.$subject.'" AND sm.examtype = "'.$examtype.'" 
                                        WHERE 
                                        school_id =  "'.$this->session->userdata('school_id').'"
                                        ';

          if($class_id > 0 ) $qry .= ' AND e.class_id =  "'.$class_id .'" ';
          if($stream_id > 0 ) $qry .= ' AND e.section_id =  "'.$stream_id .'" ';


        $qry .= ' GROUP BY s.student_id ';

        $students   = $this->db->query($qry)->result_array();
        $respArray = array();
        $respArrayAll = array();
        foreach($students as $row){
            $respArray["img"] =  $this->crud_model->get_image_url('student',$row['student_id']);
            $respArray["admno"] = $row["student_code"];
            $respArray["student"] = $row["name"];

            $respArray["subject"] = $subject;

            $sqladditionalsubjects = "
                    SELECT csub.* 
                    FROM class_subjects  cs
                    JOIN subject s ON s.name = cs.subject 
                    JOIN class_subjects  csub ON csub.parentid = cs.id 
                    WHERE s.subject_id = '".$subjectid."'  
                    AND cs.school_id =  '".$this->session->userdata('school_id')."'
                    ";

                 $subjadd   = $this->db->query($sqladditionalsubjects)->result_array();
                 $subsubjectsid = array();
                 $subsubjectsname = array();
                 $subsubjectmark = array();
                 $subsubjectmarkoutof = array();
                     foreach($subjadd as $rowsubjadded){
                        $subsubjectsid[]= $rowsubjadded['id'];
                        $subsubjectsname[]= $rowsubjadded['subject'];
                        $subsubjectmark[]= $this->getSubsubjectMark($rowsubjadded['id'],$row['student_id'],$examtype,$term);
                        $subsubjectmarkoutof[]= $rowsubjadded['total_marks_out_of'];
                     }


            $respArray["subsubject"] = $subsubjectsid;
            $respArray["subsubjectname"] = $subsubjectsname;
            $respArray["subsubjectmark"] = $subsubjectmark;
             $respArray["subsubjectmarkoutof"] = $subsubjectmarkoutof;

            $respArray["section"] = $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;
            $respArray["profilelink"] = site_url('admin/student_profile/'.$row['student_id']);
            $respArray["editlink"] = "'".site_url('modal/popup/modal_student_edit/'.$row['student_id'])."'";
            $respArray["deletelink"] = "'".site_url('admin/delete_student/'.$row['student_id'].'/'.$row['class_id'])."'";
            $respArray["marks"] = ($row["marks"])?(int)$row["marks"]:"";
            $respArray["student_id"] =$row["student_id"];
            array_push($respArrayAll,$respArray);
        }
        echo json_encode(array("content"=>$respArrayAll));
    }



    function s_report($param1 = '',$adm='') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        
        
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->debug = true;
        
        
        if($param1=='create'){
            $data['exam'] = $this->input->post('exam');
            $data['term'] = $this->input->post('term');
            $data['year'] = $this->input->post('year');
            $data['adm'] = $this->input->post('adm');
            $data['item'] = $this->input->post('items');
            $data['description'] = $this->input->post('des');
            $data['subject'] = $this->input->post('subject');
            
            $this->db->insert("subject_reports",$data);
            if($this->db->affected_rows() > 0){
                
                echo 1;
            }
            
        }
        
        if($param1=='view'){
            $student_id = $adm;
                $server="localhost";
                $db="appsclassteacher";
                $user="appsuserclass";
                $pass=">UKn}6=MK[w^`P5B";
                $version="0.9d";
                $pgport=5432;
                $pchartfolder="./class/pchart2";

                $this->load->library('PHPJasperXML');
                $phpXMLObject = new PHPJasperXML();
                   
                    $sqlClasses = "
                        SELECT 
                        c.name classname , sect.name stream , e.class_id ,sect.section_id
                        FROM student s 
                        JOIN enroll e ON e.student_id = s.student_id 
                        JOIN class c ON c.class_id = e.class_id
                        JOIN section sect  ON sect.section_id = e.section_id
                        WHERE s.student_id = '".$student_id."'
                    ";
                    $queryClasses = $this->db->query($sqlClasses);
                    $rowClassDetails =   $queryClasses->row(); 

                    $class= $rowClassDetails->classname;
                    $stream= $rowClassDetails->stream;
                    $class_id= $rowClassDetails->class_id;
                    $stream_id= $rowClassDetails->section_id;

                    $sql = "
                            SELECT
                            now() as generateddate,  
                            s.student_id,s.name,s.sex,s.date_of_admission,sch.school_id,sch.school_name, sch.logo,s.student_code,
                            sch.website,sch.email,sch.address,sch.telephone,now() as tdate, e.class_id,c.name classname,
                            sr.Subject,
                            sr.Item,
                            sr.Description,
                            t.name  Teacher
                            FROM student s 
                            JOIN school sch ON sch.school_id = s.school_id 
                            JOIN enroll e ON e.student_id = s.student_id 
                            JOIN class c ON c. class_id = e.class_id 
                            LEFT JOIN subject_reports sr ON sr.adm = s.student_id
                            LEFT JOIN subject subj ON  subj.name =  sr.subject  AND subj.class_id = c. class_id AND      subj.section_id = e.section_id
                            LEFT JOIN  teacher t ON t.teacher_id = subj.teacher_id                  
                            WHERE s.student_id = '".$student_id."' GROUP BY sr.Subject ORDER BY sr.Id ASC
                         ";

                    $name=$this->db->get_where("school", array('school_id'=>$this->session->userdata('school_id')))->row()->school_name;
                    $address=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->address;
                    $telephone=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->phone;
                    $location=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->county;
                    

                    $classteacher = ""; 
                    if($stream_id >0){
                        $sqlteacher = "
                        SELECT t.name teacher , s.teacher_id  
                        FROM  section s
                        JOIN teacher t ON t.teacher_id = s.teacher_id 
                        WHERE  section_id = '".$stream_id."'
                        ";
                        $queryTeacher = $this->db->query($sqlteacher);
                        $rowTeacher =   $queryTeacher->row();
                        if($rowTeacher){
                            $classteacher = $rowTeacher->teacher; 
                        }               

                    }  

                   $school_image = $this->crud_model->get_image_url('school',$this->session->userdata('school_id'));
                   $logo =  ($school_image !='')?$school_image:base_url('/uploads/logo.png');
                   $logo = file_get_contents($logo);
                   $binary = imagecreatefromstring($logo);
                   $target_dir = "uploads/logoPNG.png";                 
                   ImagePNG($binary, $target_dir);
                   $logo = base_url($target_dir);

                    $class_name = $stream.",".$class;

                    $phpXMLObject->arrayParameter=array(
                    "class_name"=> $class_name,
                    "academics"=> $academics,
                    "activities"=> $activities,
                    "conduct"=> $conduct,
                    "totalscore"=> $totalscore,
                    "mean"=> $mean,
                    "grade"=> $grade,
                    "rank"=> $rank,
                    "name"=> $name,
                    "class_teacher"=>$classteacher,
                    "address"=>$address,
                    "telephone"=>$telephone,
                    "location"=> $location,
                    "logo-default"=>"http://apps.classteacher.school/assets/images/pdf_logo/logo.png",
                    "logo"=>$logo,
                    "graph"=>$graph,
                    "reportlabel"=>'SUBJECT REPORT  '.strtoupper($stream." ". $class. " "),
                    $this->id = 1,
                    "sql"=>$sql
                    );
                    $phpXMLObject->load_xml_file(dirname(__FILE__)."/PDF/pdf-s_reportform.jrxml");
                    $phpXMLObject->transferDBtoArray($server,$user,$pass,$db);
                    $phpXMLObject->outpage("I");
                    exit();

    /*        $data['term'] = $this->session->userdata('term');
        $data['year'] = $this->session->userdata('year');
        $data['exam'] = $this->session->userdata('exam');
            $data['adm'] = $adm;
            $data['student']    = $this->db->get_where("student",array("student_id"=>$adm))->row()->name;
            $data['page_name'] = 'subject_report_pdf';
        $this->load->view('backend/load', $data);
            */            
        }
        
        
        $page_data['page_title'] = 'Subjects Reports';
        $page_data['page_name'] = 'lpos';
        $page_data['student_name']  = $this->db->get_where("student",array("student_id"=>$adm))->row()->name;
        $page_data['adm']   = $adm;
        $this->load->view('backend/index', $page_data);
    }

    function subject_performance($class_id = '' , $section_id = '') {
           if ($this->session->userdata('teacher_login') != 1)
               redirect(site_url('login'), 'refresh');

           if ($this->input->post('operation') == 'selection') {
               $page_data['exam_id']    = $this->input->post('exam_id');
               $page_data['class_id']   = $this->input->post('class_id');
              $page_data['section_id']   = $this->input->post('section_id');

               if ($page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                   redirect(site_url('teacher/subject_performance/' . $page_data['class_id'] . '/'. $page_data['section_id']), 'refresh');
               } else {
                   $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                   redirect(site_url('teacher/subject_performance'), 'refresh');
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
           if ($this->session->userdata('teacher_login') != 1)
               redirect(site_url('login'), 'refresh');

           if ($this->input->post('operation') == 'selection') {
               $page_data['exam_id']    = $this->input->post('exam_id');
               $page_data['class_id']   = $this->input->post('class_id');
               $page_data['section_id']   = $this->input->post('section_id');

               $page_data['section_id'] = "all";

               if ($page_data['class_id'] > 0) {
                   redirect(site_url('teacher/stream_performance/' . $page_data['class_id'] . '/'. $page_data['section_id']), 'refresh');
               } else {
                   $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                   redirect(site_url('teacher/stream_performance'), 'refresh');
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



     function survey($param1='',$param2='',$param3=''){
               if($param3==''){
                   
                   $param3=1;
                   
               }
                if($param1=='create'){
                $title  = $this->input->post('title');
                $no  = $this->input->post('quizs');
                $questions  = $this->input->post('quiz');
                $target  = $this->input->post('target');
                $answers  = $this->input->post('ans');
                //CREATE SURVEY     
                $survey['title'] = $title;
                $survey['quizs'] = $no;
                $survey['target'] = $target;
                $survey['status'] = 'Active';
                $survey['school_id'] = $this->session->userdata('school_id');
                $this->db->insert("survey",$survey);
                 $insert_id = $this->db->insert_id();
                $question2 = explode(',',$questions);
                $answers2 = explode(',',$answers);
                for($i = 0; $i< count($question2);$i++){
                
                $quiz['question'] = $question2[$i];
                $quiz['survey'] = $insert_id;
                $this->db->insert("survey_questions",$quiz);
                $quiz_id = $this->db->insert_id();
                $answer_single = explode('#',$answers2[$i]);
                for($j = 0; $j< count($answer_single);$j++){
                $an['answer'] = $answer_single[$j];
                $an['question_id'] = $quiz_id;
                $this->db->insert("survey_answers",$an);
                }
                }
            }
                if($param1==''){
                $page_data['page_name']  = 'survey';
                $page_data['page_title'] = get_phrase('create_survey');
                $this->load->view('backend/index', $page_data);
                }
                
                if($param1=='take'){
                    $page_data['survey_id']  = $param2;
                    $page_data['user_id']  = $param3;
                $page_data['page_name']  = 'survey_questions';
                $page_data['page_title'] = get_phrase('create_survey');
                $this->load->view('backend/index', $page_data);
                }
                
                if($param1=='answer'){
                    $an['answer'] = $answer_single[$j];
                $id = $this->input->post('id');
                $id2 = $this->input->post('qid');
                $dd['answer_id']= $id;
                $dd['question_id']= $id2;
                $dd['user_id']= $this->input->post('user_id');
                $this->db->insert("survey_data",$dd);
                
                $votes = $this->db->get_where("survey_answers",array("id"=>$id))->row()->votes;
                $d['votes'] = $votes + 1;
                $this->db->where("id",$id);
                $this->db->update("survey_answers",$d);
                if ($this->db->affected_rows() > 0){
                    
                    echo 1;
                    
                }
                
                
                }
                
            }
    



    /****MANAGE EXAM MARKS*****/
    function marks_manage_old()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  =   'marks_manage';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }

    function marks_manage_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'marks_manage_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->load->view('backend/index', $page_data);
    }



   function manage_subject_analysis()
    {       
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'manage_subject_analysis';
        $page_data['page_title'] = get_phrase('subject_analysis');
        $this->load->view('backend/index', $page_data);
    }



        function manage_subject_analysis_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '0' , $term ='')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['term'] =   $term;
        $page_data['page_name']  =   'manage_subject_analysis_view';
        $page_data['page_title'] = get_phrase('subject_analysis_report');
        $this->load->view('backend/index', $page_data);
    }
    


    function subject_analysis_selector()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['term'] = $this->input->post('term');
        $data['year']       = $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
        if($data['class_id'] != '' && $data['exam_id'] != ''){

            $query = $this->db->get_where('mark' , array(
                        'exam_id' => $data['exam_id'],
                            'class_id' => $data['class_id'],
                                'section_id' => $data['section_id'],
                                    'subject_id' => $data['subject_id'],
                                        'year' => $data['year']
                    ));

            redirect(site_url('teacher/manage_subject_analysis_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/0/'.$data['term']), 'refresh');
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
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  =   'manage_subject_analysis_per_subject';
        $page_data['page_title'] = get_phrase('subject_analysis_per_subject'); 
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    function manage_subject_analysis_per_subject_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '',$term='')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['term']    =   $term;
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
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        $data['term']    = $this->input->post('term');
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
        
            redirect(site_url('teacher/manage_subject_analysis_per_subject_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id'].'/'. $data['term']), 'refresh');
        }
        else{
            $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
            $page_data['page_name']  =   'manage_subject_analysis_per_subject';
            $page_data['page_title'] = get_phrase('subject_analysis_per_subject');
            $this->load->view('backend/index', $page_data);
        }
    }


        function manage_subject_analysis_subject_view_print() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        //$subject  =   $this->input->post('subject');
        $stream     =   $this->input->post('stream');
        $cutoff     =   $this->input->post('cuttoff');
        $term       =   $this->input->post('term');
        $year       =   $this->input->post('year');
        $form       =   $this->input->post('form');
        $main_exam  =   $this->input->post('exam');
        $subject    =   $this->input->post('subject');
        
        //$page_data['cutoff']= $cutoff;
        $page_data['form']= $form;
        $page_data['year']= $year;
        $page_data['term']= $term;
        $page_data['subject_id']= $subject;
        $page_data['stream']= $stream;
        $page_data['exam']= $main_exam;
        
        $page_data['page_name']  = 'manage_subject_analysis_subject_view_print';
        $page_data['page_title'] = get_phrase('score_sheet');
        $this->load->view('backend/load', $page_data);
    
    }


       function manage_subject_analysis_view_print() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        //$subject  =   $this->input->post('subject');
        $stream     =   $this->input->post('stream');
        $cutoff     =   $this->input->post('cuttoff');
        $term       =   $this->input->post('term');
        $year       =   $this->input->post('year');
        $form       =   $this->input->post('form');
        $main_exam  =   $this->input->post('exam');
        
        //$page_data['cutoff']= $cutoff;
        $page_data['form']= $form;
        $page_data['year']= $year;
        $page_data['term']= $term;
        //$page_data['subject1']= $subject;
        $page_data['stream']= $stream;
        $page_data['exam']= $main_exam;
        
        $page_data['page_name']  = 'manage_subject_analysis_view_print';
        $page_data['page_title'] = get_phrase('score_sheet');
        $this->load->view('backend/load', $page_data);
    
    }
    


    function marks_selector()
    {
        if ($this->session->userdata('teacher_login') != 1)
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
        redirect(site_url('teacher/marks_manage_view/'. $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']) , 'refresh');

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
        redirect(site_url('teacher/marks_manage_view/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id), 'refresh');
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
        $this->load->view('backend/teacher/marks_get_subject' , $page_data);
    }


    // ACADEMIC SYLLABUS
    function academic_syllabus($class_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
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
        redirect(site_url('teacher/academic_syllabus/'. $data['class_id']) , 'refresh');

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
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(site_url('teacher/backup_restore'), 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(site_url('teacher/backup_restore'), 'refresh');
        }

        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $data['name']        = $this->input->post('name');
            $data['email']       = $this->input->post('email');
            $validation = email_validation_for_edit($data['email'], $this->session->userdata('teacher_id'), 'teacher');
            if ($validation == 1) {
                $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
                $this->db->update('teacher', $data);
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/teacher_image/' . $this->session->userdata('teacher_id') . '.jpg');
                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            }
            else{
                $this->session->set_flashdata('error_message', get_phrase('this_email_id_is_not_available'));
            }
            redirect(site_url('teacher/manage_profile/'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = sha1($this->input->post('password'));
            $data['new_password']         = sha1($this->input->post('new_password'));
            $data['confirm_new_password'] = sha1($this->input->post('confirm_new_password'));

            $current_password = $this->db->get_where('teacher', array(
                'teacher_id' => $this->session->userdata('teacher_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
                $this->db->update('teacher', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('password_mismatch'));
            }
            redirect(site_url('teacher/manage_profile/'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('teacher', array(
            'teacher_id' => $this->session->userdata('teacher_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	function manage_notification($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_notification') {
            $data['sound']        = $this->input->post('sound');
            $data['vibrate']       = $this->input->post('vibrate');
			$data['dnd']       = $this->input->post('dnd');
            
            $this->db->where('teacher_id', $this->session->userdata('teacher_id'));
            $this->db->update('teacher', $data);
               
            $this->session->set_flashdata('flash_message', get_phrase('updated'));            
            redirect(site_url('teacher/manage_notification/'), 'refresh');
        }
         
        $page_data['page_name']  = 'notification_settings';
        $page_data['page_title'] = get_phrase('notification_setting');
        $page_data['edit_data']  = $this->db->get_where('teacher', array(
            'teacher_id' => $this->session->userdata('teacher_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	
	function feedback($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        
        if ($param1 == 'update_feedback') {
            $data['feedback']  = $this->input->post('feedback');           

			$this->db->where('teacher_id', $this->session->userdata('teacher_id'));
			$this->db->update('teacher', array('feedback' => $data['feedback']
			));
			$this->session->set_flashdata('flash_message', get_phrase('updated'));
             
            redirect(site_url('teacher/feedback/'), 'refresh');
        }
        $page_data['page_name']  = 'feedback';
        $page_data['page_title'] = get_phrase('feedback');
        $page_data['edit_data']  = $this->db->get_where('teacher', array(
            'teacher_id' => $this->session->userdata('teacher_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	
	function assignments($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
		$login_user_id = $this->session->userdata('login_user_id');
        if ($param1 == 'create') {
			
			$data['class_id'] = $this->input->post('class_id');
			$data['section_id'] = $this->input->post('section_id');
			$data['subject_id'] = $this->input->post('subject_id');
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('details');          
			$data['user_id'] =  $login_user_id;
			$data['role_id'] =  2;
            $data['given_date'] = date('Y-m-d',strtotime($this->input->post('given_date')));
            $data['due_date'] = date('Y-m-d',strtotime($this->input->post('due_date')));
            $this->db->insert('assignments', $data);
             
            $this->session->set_flashdata('flash_message' , get_phrase('assignments_added_successfully'));
            redirect(site_url('teacher/assignments'), 'refresh');
        }
        if ($param1 == 'do_update') {
            
            $data['class_id'] = $this->input->post('class_id');
			$data['section_id'] = $this->input->post('section_id');
			$data['subject_id'] = $this->input->post('subject_id');
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('details');          
			$data['user_id'] =  $login_user_id;
			$data['role_id'] =  2;
            $data['given_date'] = date('Y-m-d',strtotime($this->input->post('given_date')));
            $data['due_date'] = date('Y-m-d',strtotime($this->input->post('due_date')));

            $this->db->where('assignment_id', $param2);
            $this->db->update('assignments', $data);
 
            $this->session->set_flashdata('flash_message' , get_phrase('assignment_updated'));
            redirect(site_url('teacher/assignments'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('assignments', array(
                'assignment_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('assignment_id', $param2);
            $this->db->delete('assignments');
            $this->session->set_flashdata('flash_message' , get_phrase('assignment_deleted'));
            redirect(site_url('teacher/assignments'), 'refresh');
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
            redirect(site_url('teacher/assignment_submit'), 'refresh');
        }
        
        $page_data['page_name']  = 'assignments';
        $page_data['page_title'] = get_phrase('assignments');
        $this->load->view('backend/index', $page_data);
    }

    function assignment_edit($assignment_id) {
      if ($this->session->userdata('teacher_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'assignment_edit';
      $page_data['assignment_id'] = $assignment_id;
      $page_data['page_title'] = get_phrase('edit_event');
      $this->load->view('backend/index', $page_data);
    }

    function reload_assignment() {
        $this->load->view('backend/teacher/assignments');
    }
	
	function assignment_submit()
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
		$login_user_id = $this->session->userdata('login_user_id');               
        $page_data['page_name']  = 'assignment_submit';
        $page_data['page_title'] = get_phrase('assignment_submit');
        $this->load->view('backend/index', $page_data);
    }
	
	function assignmentsubmit_edit($assignment_id) {
      if ($this->session->userdata('teacher_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'assignmentsubmit_edit';
      $page_data['assignment_id'] = $assignment_id;
      $page_data['page_title'] = get_phrase('assignmentsubmit_edit');
      $this->load->view('backend/index', $page_data);
    }

    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($class_id)
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'class_routine';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('class_routine');
        $this->load->view('backend/index', $page_data);
    }

    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->load->view('backend/teacher/class_routine_print_view' , $page_data);
    }

	/****** DAILY ATTENDANCE *****************/
    function manage_attendance($class_id)
    {
        if($this->session->userdata('teacher_login')!=1)
            redirect(base_url() , 'refresh');

        $class_name = $this->db->get_where('class' , array(
            'class_id' => $class_id
        ))->row()->name;
        $page_data['page_name']  =  'manage_attendance';
        $page_data['class_id']   =  $class_id;
        $page_data['page_title'] =  get_phrase('manage_attendance_of_stream') . ' ' . $class_name;
        $this->load->view('backend/index', $page_data);
    }

    function manage_attendance_view($class_id = '' , $section_id = '' , $subject_id = '', $timestamp = '')
    {
        if($this->session->userdata('teacher_login')!=1)
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
		$subject_name = $this->db->get_where('subject' , array(
            'subject_id' => $subject_id
        ))->row()->name;
        $page_data['section_id'] = $section_id;
		$page_data['subject_id'] = $subject_id;
        $page_data['page_title'] = get_phrase('manage_attendance_of_class') . ' ' . $class_name . ' : ' . get_phrase('section') . ' ' . $section_name. ' : ' . get_phrase('subject') . ' ' . $subject_name;
        $this->load->view('backend/index', $page_data);
    }

    function attendance_selector()
    {
        $data['class_id']   = $this->input->post('class_id');
        $data['year']       = $this->input->post('year');		
        $data['timestamp']  = strtotime($this->input->post('timestamp'));
		$data['date']  = date('Y-m-d',$data['timestamp']);
		$data['section_id'] = $this->input->post('section_id');
		$data['subject_id'] = $this->input->post('subject_id');
		$data['periord'] = $this->input->post('periord');
        $query = $this->db->get_where('attendance' ,array(
            'class_id'=>$data['class_id'],
                'section_id'=>$data['section_id'],
				 'subject_id'=>$data['subject_id'],
				 'timestamp'=> $data['timestamp']
        ));
        if($query->num_rows() < 1) {
            $students = $this->db->get_where('enroll' , array(
                'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            ))->result_array();
            foreach($students as $row) {
                $attn_data['class_id']   = $data['class_id'];
                $attn_data['year']       = $data['year'];
                $attn_data['timestamp']  = $data['timestamp'];
				$attn_data['date']  = $data['date'];
                $attn_data['section_id'] = $data['section_id'];
				$attn_data['subject_id'] = $data['subject_id'];
				$attn_data['period'] = $data['periord'];
                $attn_data['student_id'] = $row['student_id'];
                $this->db->insert('attendance' , $attn_data);
            }

        }
        redirect(site_url('teacher/manage_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['subject_id'].'/'.$data['timestamp']),'refresh');
    }

    function attendance_update($class_id = '' , $section_id = '' , $subject_id = ''  , $timestamp = '')
    {
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $active_sms_service = $this->db->get_where('settings' , array('type' => 'active_sms_service'))->row()->description;
        $attendance_of_students = $this->db->get_where('attendance' , array(
            'class_id'=>$class_id,'section_id'=>$section_id,'subject_id'=>$subject_id,'year'=>$running_year,'timestamp'=>$timestamp
        ))->result_array();
        foreach($attendance_of_students as $row) {
            $attendance_status = $this->input->post('status_'.$row['attendance_id']);
            $this->db->where('attendance_id' , $row['attendance_id']);
            $this->db->update('attendance' , array('status' => $attendance_status));
			
			$noti_arr['title'] = 'Update Attendance';
			$noti_arr['content'] = 'Update Attendance';
			$noti_arr['type'] = '6';
			$noti_arr['type_id'] = $row['attendance_id'];
			$noti_arr['creator_id'] = $this->session->userdata('login_user_id');
			$noti_arr['creator_role'] = '3';
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
						 			
			$noti_arr['student_id'] = $student_id = $row['student_id'];
			$this->db->insert('notifications', $noti_arr);	 		
			
			$parent_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->parent_id;
				
			$this->crud_model->notificationAlert($parent_id,'1',$noti_arr,'Update Attendance');
			 
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
        redirect(site_url('teacher/manage_attendance_view/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$timestamp ), 'refresh');
    }
	
	
	function attendance_report() {
         $page_data['month']        = date('m');
         $page_data['page_name']    = 'attendance_report';
         $page_data['page_title']   = get_phrase('attendance_report');
         $this->load->view('backend/index',$page_data);
     }
     function attendance_report_view($class_id = '', $section_id = '', $month = '', $sessional_year = '')
     {
         if($this->session->userdata('teacher_login')!=1)
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
          if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['class_id']          = $class_id;
        $page_data['section_id']        = $section_id;
        $page_data['month']             = $month;
        $page_data['sessional_year']    = $sessional_year;
        $this->load->view('backend/teacher/attendance_report_print_view' , $page_data);
    }

    function attendance_report_selector()
    {   if($this->input->post('class_id') == '' || $this->input->post('sessional_year') == '') {
            $this->session->set_flashdata('error_message' , get_phrase('please_make_sure_class_and_sessional_year_are_selected'));
            redirect(site_url('teacher/attendance_report'), 'refresh');
        }
        $data['class_id']       = $this->input->post('class_id');
        $data['section_id']     = $this->input->post('section_id');
        $data['month']          = $this->input->post('month');
        $data['sessional_year'] = $this->input->post('sessional_year');
        redirect(site_url('teacher/attendance_report_view/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['month'] . '/' . $data['sessional_year']), 'refresh');
    }
	
	
	    /****MANAGE EXAMS*****/
    function exam($param1 = '', $param2 = '' , $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
        
        if ($param1 == 'create') {  
              $result = $this->db->get_where('exams' , array('Term1' =>$this->input->post('name'),'school_id' => $this->session->userdata('school_id')
             ))->result_array();
            if(count($result) >= 1){
            echo json_encode(array("res"=>0,"message"=>"Exam already exist (".$this->input->post('name').")"));
            }else{
            
            $data['Term1']    = $this->input->post('name');
            $tbname         =  strtolower(str_replace("-","",str_replace(" ","",$this->input->post('name'))));
            $data['date']    = $this->input->post('date');
            $data['comment'] = $this->input->post('comment');
            $data['limit'] = $this->input->post('limit');
            $data['school_id'] = $school_id;
            $this->db->insert('exams', $data);      
            echo json_encode(array("res"=>1,"message"=>"Successfully added an exam (".$this->input->post('name').")"));            
            
         }
         exit();
        }

        if ($param1 == 'edit' && $param2 == 'do_update') {
            $data['Term1']    = $this->input->post('name');
            $data['date']    = $this->input->post('date');
            if ($this->input->post('comment') != null) {
                $data['comment'] = $this->input->post('comment');
            }
            else{
              $data['comment'] = null;
            }  

            $this->db->where('ID', $param3);
            $this->db->update('exams', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(site_url('teacher/exam'), 'refresh');
        }
        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('exams', array(
                'ID' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('ID', $param2);
            $this->db->delete('exams');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('teacher/exam'), 'refresh');
        }
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $page_data['exams']      = $this->db->get_where('exams', array('school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'exam';
        $page_data['page_title'] = get_phrase('manage_exam');
        $this->load->view('backend/index', $page_data);
    }

    /****** SEND EXAM MARKS VIA SMS ********/
    function exam_marks_sms($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
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
	
	
	/****MANAGE GRADES*****/
    function grade($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
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
            redirect(site_url('teacher/grade'), 'refresh');
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
            redirect(site_url('teacher/grade'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('grade', array(
                'grade_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('grade_id', $param2);
            $this->db->delete('grade');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('teacher/grade'), 'refresh');
        }
        $page_data['grades'] = $this->db->get_where('grade', array('school_id' => $school_id))->result_array();
        $page_data['page_name']  = 'grade';
        $page_data['page_title'] = get_phrase('manage_grade');
        $this->load->view('backend/index', $page_data);
    }
	
	// TABULATION SHEET
    function tabulation_sheet($class_id = '' , $exam_id = '' , $section_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('teacher/tabulation_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('teacher/tabulation_sheet'), 'refresh');
            }
        }
        $page_data['exam_id']    = $exam_id;
        $page_data['class_id']   = $class_id;
		$page_data['section_id']   = $section_id;

        $page_data['page_info'] = 'Exam marks';

        $page_data['page_name']  = 'tabulation_sheet';
        $page_data['page_title'] = get_phrase('report_card');
        $this->load->view('backend/index', $page_data);

    }

    function tabulation_sheet_print_view($class_id , $exam_id , $section_id) {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['class_id'] = $class_id;
		$page_data['section_id']  = $exam_id;
        $page_data['exam_id']  = $exam_id;
        $this->load->view('backend/teacher/tabulation_sheet_print_view' , $page_data);
    }

    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

        $page_data['books']      = $this->db->get('book')->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');
        $this->load->view('backend/index', $page_data);

    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/
    function transport($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');

        $page_data['transports'] = $this->db->get('transport')->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');
        $this->load->view('backend/index', $page_data);

    }

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);
            redirect(site_url('teacher/noticeboard/'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);
            $this->session->set_flashdata('flash_message', get_phrase('notice_updated'));
            redirect(site_url('teacher/noticeboard/'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            redirect(site_url('teacher/noticeboard/'), 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('announcements');
        $page_data['notices']    = $this->db->get_where('noticeboard',array('school_id'=>$school_id,'status'=>1))->result_array();
        $this->load->view('backend/index', $page_data);
    }
	
	function media($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
		$user_id = $this->session->userdata('login_user_id'); 
		$login_type = $this->session->userdata('login_type');
        if ($param1 == 'create') {
			$data['class_id']  = $this->input->post('class_id');
			$data['section_id']  = $this->input->post('section_id');
            $data['title']  = $this->input->post('title');
            $data['details']  = $this->input->post('details');    
			$data['type_id']  = $this->input->post('type_id');  
			$data['user_id']  = $user_id; 
			$data['role_id']  = 2;
						 
            if ($_FILES['media']['name'] != '') {
				$timestamp = strtotime(date("Y-m-d H:i:s"));				
				$directory = "uploads/media/$timestamp"."-$user_id". $_FILES['media']['name'];
				$data['file_name']  = $_FILES['media']['name'];
				move_uploaded_file($_FILES['media']['tmp_name'], $directory);
				$data['path']  = 'http://apps.classteacher.school/'.$directory;
            }
            $this->db->insert('media', $data);            

            $this->session->set_flashdata('flash_message' , get_phrase('media_added_successfully'));
            redirect(site_url('teacher/media'), 'refresh');
        }
        if ($param1 == 'do_update') {
           
			$data['class_id']  = $this->input->post('class_id');
			$data['section_id']  = $this->input->post('section_id');
            $data['title']  = $this->input->post('title');
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
            redirect(site_url('teacher/media'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('media', array('id' => $param2))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('media');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(site_url('teacher/media'), 'refresh');
        }
        
        $page_data['page_name']  = 'media';
        $page_data['page_title'] = get_phrase('medias');
        $this->load->view('backend/index', $page_data);
    }

    function media_edit($media_id) {
      if ($this->session->userdata('teacher_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'media_edit';
      $page_data['media_id'] = $media_id;
      $page_data['page_title'] = get_phrase('edit_media');
      $this->load->view('backend/index', $page_data);
    }

    function reload_media() {
        $this->load->view('backend/teacher/media');
    }	
	
	
	function events($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
		$school_id = $this->session->userdata('school_id');
        if ($param1 == 'create') {
            $data['title']     = $this->input->post('title');
            $data['details']           = $this->input->post('details');          
			$data['school_id']     =  $school_id;
            $data['date'] = date('Y-m-d',strtotime($this->input->post('create_timestamp')));
            if ($_FILES['image']['name'] != '') {
              $data['image']  = $_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/events/'. $_FILES['image']['name']);
            }
            $this->db->insert('events', $data);
             
            $this->session->set_flashdata('flash_message' , get_phrase('event_added_successfully'));
            redirect(site_url('teacher/events'), 'refresh');
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
            redirect(site_url('teacher/events'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('events', array(
                'id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('id', $param2);
            $this->db->delete('events');
            $this->session->set_flashdata('flash_message' , get_phrase('event_deleted'));
            redirect(site_url('teacher/events'), 'refresh');
        }
        
        $page_data['page_name']  = 'events';
        $page_data['page_title'] = get_phrase('events');
        $this->load->view('backend/index', $page_data);
    }

    function event_edit($event_id) {
      if ($this->session->userdata('teacher_login') != 1)
          redirect(site_url('login'), 'refresh');

      $page_data['page_name']  = 'event_edit';
      $page_data['event_id'] = $event_id;
      $page_data['page_title'] = get_phrase('edit_event');
      $this->load->view('backend/index', $page_data);
    }

    function reload_events() {
        $this->load->view('backend/teacher/noticeboard');
    }


    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/
    function document($do = '', $document_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect('login', 'refresh');
        if ($do == 'upload') {
            move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/document/" . $_FILES["userfile"]["name"]);
            $data['document_name'] = $this->input->post('document_name');
            $data['file_name']     = $_FILES["userfile"]["name"];
            $data['file_size']     = $_FILES["userfile"]["size"];
            $this->db->insert('document', $data);
            redirect(site_url('teacher/manage_document'), 'refresh');
        }
        if ($do == 'delete') {
            $this->db->where('document_id', $document_id);
            $this->db->delete('document');
            redirect(site_url('teacher/manage_document'), 'refresh');
        }
        $page_data['page_name']  = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $page_data['documents']  = $this->db->get('document')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*********MANAGE STUDY MATERIAL************/
    function study_material($task = "", $document_id = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }

        if ($task == "create")
        {
            $this->crud_model->save_study_material_info();
            $this->session->set_flashdata('flash_message' , get_phrase('study_material_info_saved_successfuly'));
            redirect(site_url('teacher/study_material/'), 'refresh');
        }

        if ($task == "update")
        {
            $this->crud_model->update_study_material_info($document_id);
            $this->session->set_flashdata('flash_message' , get_phrase('study_material_info_updated_successfuly'));
            redirect(site_url('teacher/study_material/'), 'refresh');
        }

        if ($task == "delete")
        {
            $this->crud_model->delete_study_material_info($document_id);
            redirect(site_url('teacher/study_material/'), 'refresh');
        }

        $data['study_material_info']    = $this->crud_model->select_study_material_info_for_teacher();
        $data['page_name']              = 'study_material';
        $data['page_title']             = get_phrase('study_material');
        $this->load->view('backend/index', $data);
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('teacher_login') != 1)
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
                  redirect(site_url('teacher/message/message_new/'), 'refresh');
              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('teacher/message/message_read/'.$message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {

            if (!file_exists('uploads/private_messaging_attached_file/')) {
              $oldmask = umask(0);  // helpful when used in linux server
              mkdir ('uploads/private_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
              if($_FILES['attached_file_on_messaging']['size'] > $max_size){
                $this->session->set_flashdata('error_message' , get_phrase('file_size_can_not_be_larger_that_2_Megabyte'));
                  redirect(site_url('teacher/message/message_read/'.$param2), 'refresh');

              }
              else{
                $file_path = 'uploads/private_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
                move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
              }
            }
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(site_url('teacher/message/message_read/'.$param2), 'refresh');
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
      if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');
      $max_size = 2097152;

	  if ($param1 == "create_group") {
        $this->crud_model->create_group('teacher');
      }
      elseif ($param1 == "edit_group") {
        $this->crud_model->update_group($param2,'teacher');
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
              redirect(site_url('teacher/group_message/group_message_read/'.$param2), 'refresh');
          }
          else{
            $file_path = 'uploads/group_messaging_attached_file/'.$_FILES['attached_file_on_messaging']['name'];
            move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
          }
        }

        $this->crud_model->send_reply_group_message($param2);  //$param2 = message_thread_code
        $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
          redirect(site_url('teacher/group_message/group_message_read/'.$param2), 'refresh');
      }
      $page_data['message_inner_page_name']   = $param1;
      $page_data['page_name']                 = 'group_message';
      $page_data['page_title']                = get_phrase('group_messaging');
      $this->load->view('backend/index', $page_data);
    }

    // MANAGE QUESTION PAPERS
    function question_paper($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('teacher_login') != 1)
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == "create")
        {
            $this->crud_model->create_question_paper();
            $this->session->set_flashdata('flash_message', get_phrase('data_created_successfully'));
            redirect(site_url('teacher/question_paper'), 'refresh');
        }

        if ($param1 == "update")
        {
            $this->crud_model->update_question_paper($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_updated_successfully'));
            redirect(site_url('teacher/question_paper'), 'refresh');
        }

        if ($param1 == "delete")
        {
            $this->crud_model->delete_question_paper($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
            redirect(site_url('teacher/question_paper'), 'refresh');
        }

        $data['page_name']  = 'question_paper';
        $data['page_title'] = get_phrase('question_paper');
        $this->load->view('backend/index', $data);
    }

    // Details of searched student
    function student_details(){
      if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');

      $student_identifier = $this->input->post('student_identifier');
      $query_by_code = $this->db->get_where('student', array('student_code' => $student_identifier));

      if ($query_by_code->num_rows() == 0) {
        $this->db->like('name', $student_identifier);
        $query_by_name = $this->db->get('student');
        if ($query_by_name->num_rows() == 0) {
          $this->session->set_flashdata('error_message' , get_phrase('no_student_found'));
            redirect(site_url('teacher/dashboard'), 'refresh');
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
    
    function class_layout($class_id)
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'class_layout';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('class_layout');
       $this->load->view('backend/index', $page_data);
	
    }
	
	
	function class_layout_edit($class_id)
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'class_layout_edit';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('class_layout_edit');
       $this->load->view('backend/index', $page_data);
		
		
	
    }
    
    function class_layout_change($lid,$stuid,$place=0){
		
		 
		 $cnt = $this->db->get_where('class_layout_places', array('layout_id' => $lid,'position' => $place))->num_rows();
		
		if($cnt >0){
		    
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
	
	    function health_occurence($student_id)
	{
		if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['student_id']  = $student_id;
		$page_data['page_name']  = 'health_occurence';
		$page_data['page_title'] = get_phrase('health_occurence');
		$this->load->view('backend/index', $page_data);
	}
	
	function health_occurence_create($param1 = '' , $param2 = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
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
		 
			redirect(site_url('teacher/student_health/' . $class_id), 'refresh');
    }
    
    function student_health($class_id = '')
	{
		if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');

		$page_data['page_name'] = 'student_health';
		$page_data['page_title'] = get_phrase('student_health_occurence'). " - ".get_phrase('class')." : ".
		$this->crud_model->get_class_name($class_id);
		$page_data['class_id'] 	= $class_id;
		$this->load->view('backend/index', $page_data);
	}
	
	 function student_behaviour($id)
    {
        if ($this->session->userdata('teacher_login') != 1)
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
        if ($this->session->userdata('teacher_login') != 1)
            redirect(site_url('login'), 'refresh');
        $page_data['page_name']  = 'student_behaviour_details';
        $page_data['class_id']  =   $class_id;
        $page_data['page_title'] = get_phrase('student_behaviours');
       $this->load->view('backend/index', $page_data);
		
		
	
    }
	
	function behaviour_update($stuid){
				
		if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');
		
		$login_user_id = $this->session->userdata('login_user_id');
		 		
		$behaviours = $this->input->post('behaviour');
		$reports = $this->input->post('report');
		$actions = $this->input->post('action');
		
		foreach($behaviours as $k => $behaviour){
			
			$report = $reports[$k];
			$action = ($report == 'no')?$actions[$k]:'';
			
			$cnt = $this->db->get_where('behaviour_reports', array('student_id' => $stuid,'behaviour' => $behaviour))->num_rows();
		
			if($cnt >0){
				
				$this->db->where('student_id' , $stuid);
				$this->db->where('behaviour' , $behaviour);
				$this->db->update('behaviour_reports' , array('report' =>$report,'action'=>$action));
				
			}else{
				
				$data['user_id']  = $login_user_id;
				$data['role_id']  = 2;
				$data['student_id']  = $stuid;
				$data['behaviour']   = $behaviour;
				$data['report']   = $report;
				$data['action']   = $action;
				$this->db->insert('behaviour_reports', $data);
			}	
			
		}
		 
		$this->session->set_flashdata('flash_message', get_phrase('behaviour_updated_successful'));
		redirect(site_url('teacher/student_behaviour/'.$stuid), 'refresh');
	}
	
	function get_comments()
	{	
		$class_id = $this->input->post('class_id');
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
	
	
	function blank_score_sheet($class_id = '' , $exam_id = '', $section_id = '') {
        if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');

        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            $page_data['class_id']   = $this->input->post('class_id');
			$page_data['section_id']   = $this->input->post('section_id');
			

            if ($page_data['exam_id'] > 0 && $page_data['section_id'] > 0 && $page_data['class_id'] > 0) {
                redirect(site_url('teacher/blank_score_sheet/' . $page_data['class_id'] . '/' . $page_data['exam_id']. '/' . $page_data['section_id']), 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose class & section and exam');
                redirect(site_url('teacher/blank_score_sheet'), 'refresh');
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
	
	function blank_marks_manage_subject()
    {		
        if ($this->session->userdata('teacher_login') != 1)
          redirect(base_url(), 'refresh');
        $page_data['page_name']  =   'blank_marks_manage_subject';
        $page_data['page_title'] = get_phrase('blank_mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
	
/*	function blank_marks_manage_subject_view($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
         redirect(base_url(), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
        $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['page_name']  =   'blank_marks_manage_subject_view';
        $page_data['page_title'] = get_phrase('blank_mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
*/

    function blank_marks_manage_subject_view($exam = '' , $class_id = '' , $section_id = '' , $subject = '' , $year='2019',$term='Term 1')
    {
        if ($this->session->userdata('teacher_login') != 1)
        redirect(site_url('login'), 'refresh');
        $page_data['exam']    =   $exam;
        $page_data['class_id']   =   $class_id;
        $page_data['subject'] =   $subject;
        $page_data['section_id'] =   $section_id;
        $page_data['year']   =   $year;
        $page_data['term']   =   $term;
        $page_data['page_name']  =   'blank_marks_manage_subject_view';
        $page_data['page_title'] = get_phrase('blank_mark_book_report');
        $this->load->view('backend/index', $page_data);
    }
    

    function blank_marks_subject_selector()
    {
        if ($this->session->userdata('teacher_login') != 1)
        redirect(site_url('login'), 'refresh');
        $data['exam']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject'] = $this->input->post('subject_id');
        $data['year'] = $this->input->post('year');
        $data['term'] = $this->input->post('term');

       if($data['class_id'] != '' && $data['exam'] != ''){
            
            redirect(site_url('teacher/blank_marks_manage_subject_view/' . $data['exam'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' .$data['subject'].'/'.$data['year'].'/'. $data['term']), 'refresh');
        }
        else{
            $this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
            $page_data['page_name']  =   'blank_mark_book';
            $page_data['page_title'] = get_phrase('blank_mark_book');
            $this->load->view('backend/index', $page_data);
        }
    }


    function blank_marks_manage_subject_print() {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');        
        $stream     =   $this->input->post('stream');
        $cutoff     =   $this->input->post('cuttoff');
        $term       =   $this->input->post('term');
        $year       =   $this->input->post('year');
        $form       =   $this->input->post('form');
        $main_exam  =   $this->input->post('exam');
        $subject    =   $this->input->post('subject');      
        
        $page_data['form']= $form;
        $page_data['year']= $year;
        $page_data['term']= $term;
        $page_data['subject_id']= $subject;
        $page_data['stream']= $stream;
        $page_data['exam']= $main_exam;
        
        $page_data['page_name']  = 'blank_marks_manage_subject_print';
        $page_data['page_title'] = get_phrase('score_sheet');
        $this->load->view('backend/load', $page_data);
    
    }

    
	
/*	function blank_marks_subject_selector()
    {
        if ($this->session->userdata('teacher_login') != 1)
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
			redirect(site_url('teacher/blank_marks_manage_subject_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id'] . '/' . $data['subject_id']), 'refresh');
		}
		else{
			$this->session->set_flashdata('error_message' , get_phrase('select_all_the_fields'));
			$page_data['page_name']  =   'blank_mark_book';
			$page_data['page_title'] = get_phrase('blank_mark_book');
			$this->load->view('backend/index', $page_data);
		}
	}
	*/

}
