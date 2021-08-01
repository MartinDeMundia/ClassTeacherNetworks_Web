<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class API extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();       
		//$this->load->model('crud_model');
		date_default_timezone_set("UTC");
    }
	
	public function userToken() {		
	   
	    $user_id = $this->input->post('user_id');
		$role_id = $this->input->post('role_id');
		$token  = $this->input->post('token');
			 		 				
				
		if ($user_id == "") {		
			
			 $data = array ("status" => '0', "msg" => "Require Field Missing User Id,Role Id,Token",'message_list'=> array());
			 echo json_encode($data);
			 exit;
			 
		} else {				
					
			$is_token = $this->is_user_token($user_id,$role_id,$token);	
			 
			if($is_token == 0){
			
				$this->clear_token($token);	
				$user_data = array('user_id' => $user_id,'role_id' => $role_id,'token' => $token);
				$this->db->insert('user_token', $user_data);				 
			}
			
			$data = array('status'=>'1','msg'=>'success');			
			echo json_encode($data);
			exit;						
		}		
	}

    function is_user_token($userId,$roleId,$token)
	{	        			
		$this->db->select('id');
		$this->db->where('user_id', $userId);
		$this->db->where('role_id', $roleId);
		$this->db->where('token', $token);
		$query = $this->db->get('user_token');
		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function clear_token($token) {
	
		$data = array('token' => $token);		
		$this->db->delete('user_token', $data);			
		return 1;	
	}
	
	function getCheckActivation()
    {
		$role_id     = $this->input->post('role_id');
        $phone       = $this->input->post('phone_number');
		$otp = rand(1000, 9999);
		
		$response = array();
		
		if($role_id == 1){
			$query = $this->db->get_where('parent', array('phone' => $phone));
			$cnt = $query->num_rows();
			if($cnt > 0){
				$row = $query->row();
				$isverified = $row->phone_verified;	
				$status = $row->status;
			}
		}	
		else{
			$query = $this->db->get_where('teacher', array('phone' => $phone));
			$cnt = $query->num_rows();
			if($cnt > 0){
				$row = $query->row();
				$isverified = $row->phone_verified;	
				$status = $row->status;
			}
			else{
				$query = $this->db->get_where('principal', array('phone' => $phone));
				$cnt = $query->num_rows();
				if($cnt > 0){
					$row = $query->row();
					$isverified = $row->phone_verified;
					$status = $row->status;
				}				 
			}			 
		}

		if($cnt == 0) $response = array('status'=>'0', 'message' => 'Invalid Phone number', 'otp' =>'');
		elseif($status == 0) $response = array('status'=>'0', 'message' => 'Access denied', 'otp' =>'');
		elseif($isverified == 1) $response = array('status'=>'0', 'message' => 'Already Activated', 'otp' =>'');
		else $response = array('status'=>'1', 'message' => 'Success' , 'otp' => "$otp");

		echo json_encode($response);	
		
	}
	
	function getActivateUser()
    {
		$role_id  = $this->input->post('role_id');
        $phone = $this->input->post('phone_number');
		$password = sha1($this->input->post('password'));
		
		$response = array();
		
		if($role_id == 1){
			$query = $this->db->get_where('parent', array('phone' => $phone));
			$cnt = $query->num_rows();
			if($cnt > 0){
				$row = $query->row();
				$isverified = $row->phone_verified;
				$status = $row->status;
				$this->db->where('phone', $phone);
				$this->db->update('parent', array('phone_verified' => '1' ,'password' => $password ));
			}
		}	
		else{
			$query = $this->db->get_where('teacher', array('phone' => $phone ));
			$cnt = $query->num_rows();
			if($cnt > 0){
				$row = $query->row();
				$isverified = $row->phone_verified;	
				$status = $row->status;
				$this->db->where('phone', $phone);
				$this->db->update('teacher', array('phone_verified' => '1' ,'password' => $password ));				
			}
			else{
				$query = $this->db->get_where('principal', array('phone' => $phone));
				$cnt = $query->num_rows();
				if($cnt > 0){
					$row = $query->row();
					$isverified = $row->phone_verified;	
					$status = $row->status;
					$this->db->where('phone', $phone);
					$this->db->update('principal', array('phone_verified' => '1' ,'password' => $password ));
				}				 
			}			 
		}

		if($cnt == 0) $response = array('status'=>'0', 'message' => 'Invalid Phone number / Password');
		elseif($status == 0) $response = array('status'=>'0', 'message' => 'Access denied');
		elseif($isverified == 1) $response = array('status'=>'0', 'message' => 'Already Activated');
		else $response = array('status'=>'1', 'message' => 'Success');

		echo json_encode($response);
	}
	
	function getLogin()
    {
		$role_id  = $this->input->post('role_id');
		$name  = $this->input->post('name');
        $password = sha1($this->input->post('password'));
		$source = $this->input->post('source');
		
		$response = array();
		$isvalid_phone = $isvalid_email = $ecnt = $pcnt = $status = $isrole = $isverified = 0;
		 		
		switch($role_id)
		{
			case 1:
				
				if($source == 'email'){						

					$query = $this->db->get_where('parent', array('email' => $name));
					$cnt = $query->num_rows();
					
					if($cnt >0){
						
						$isvalid_email =1;
						$query = $this->db->get_where('parent', array('email' => $name,'password' => $password ));
						$ecnt = $query->num_rows();
					}
				}
				elseif($source == 'phone'){			

					$query = $this->db->get_where('parent', array('phone' => $name));
					$cnt = $query->num_rows();
				
					if($cnt >0){
						$isvalid_phone =1;
						$query = $this->db->get_where('parent', array('phone' => $name,'password' => $password ));
						$pcnt = $query->num_rows();
					}
				}
				
				if($ecnt > 0 || $pcnt > 0){
					$row = $query->row();
					 
					$id = $row->parent_id;
					$first_name = $row->name;
					$middle_name = $row->middle_name;
					$last_name = $row->last_name;
					$image = $this->crud_model->get_image_url('parent', $id);
					$phone = $row->phone;
					$email = $row->email;
					$sound = $row->sound;
					$vibrate = $row->vibrate;
					$dnd = $row->dnd;
					$isverified = $row->phone_verified;
					$status = $row->status;
					$isrole = '1';
				}				
				
			break;
			case 2:		
			
				if($source == 'email'){		

					$query = $this->db->get_where('teacher', array('email' => $name));
					$cnt = $query->num_rows();
					
					if($cnt >0){
						
						$isvalid_email =1;				
						$query = $this->db->get_where('teacher', array('email' => $name,'password' => $password ));
						$ecnt = $query->num_rows();
					}
				}
				elseif($source == 'phone'){		

					$query = $this->db->get_where('teacher', array('phone' => $name));
					$cnt = $query->num_rows();
				
					if($cnt >0){
						$isvalid_phone =1;				
						$query = $this->db->get_where('teacher', array('phone' => $name,'password' => $password ));
						$pcnt = $query->num_rows();
					}
				}
				
				if($ecnt > 0 || $pcnt > 0){
					$row = $query->row();
					$id = $row->teacher_id;
					$first_name = $row->name;
					$middle_name = $row->middle_name;
					$last_name = $row->last_name;
					$image = $this->crud_model->get_image_url('teacher', $id);
					$phone = $row->phone;
					$email = $row->email;
					$sound = $row->sound;
					$vibrate = $row->vibrate;
					$dnd = $row->dnd;
					$isverified = $row->phone_verified;	
					$status = $row->status;
					$isrole = '2';
				}
				else{
					
					if($source == 'email'){		
					
						$query = $this->db->get_where('principal', array('email' => $name));
						$cnt = $query->num_rows();
					
						if($cnt >0){
							
							$isvalid_email =1;	
							$query = $this->db->get_where('principal', array('email' => $name,'password' => $password ));
							$ecnt = $query->num_rows();
						}
					}
					elseif($source == 'phone'){	

						$query = $this->db->get_where('principal', array('phone' => $name));
						$cnt = $query->num_rows();
				
						if($cnt >0){
							$isvalid_phone =1;		
							$query = $this->db->get_where('principal', array('phone' => $name,'password' => $password ));
							$pcnt = $query->num_rows();
						}
					}
					
					if($ecnt > 0 || $pcnt > 0){
						$row = $query->row();
						$id = $row->principal_id;
						$first_name = $row->name;
						$middle_name = $row->middle_name;
						$last_name = $row->last_name;
						$image = $this->crud_model->get_image_url('principal', $id);
						$phone = $row->phone;
						$email = $row->email;
						$sound = $row->sound;
						$vibrate = $row->vibrate;
						$dnd = $row->dnd;
						$isverified = $row->phone_verified;	
						$status = $row->status;
						$isrole = '3';
					}
					
				}
				
			break;	
			default:
				$isrole = 0;				
			break;
		}

		if($source == 'phone' && $isvalid_phone == 0) $response = array('status'=>'0', 'message' => 'Invalid Phone number');
		elseif($source == 'phone' && $pcnt == 0) $response = array('status'=>'0', 'message' => 'Invalid Password');
		elseif($source == 'email' && $isvalid_email == 0) $response = array('status'=>'0', 'message' => 'Invalid Email');
		elseif($source == 'email' && $ecnt == 0) $response = array('status'=>'0', 'message' => 'Invalid Password');
		elseif($status != 1) $response = array('status'=>'0', 'message' => 'Access denied');
		elseif($isverified == 0) $response = array('status'=>'0', 'message' => 'Not Activated');
		elseif($isrole == 0) $response = array('status'=>'0', 'message' => 'Invalid role');
		else $response = array('status'=>'1', 'message' => 'Success' , 'user_info' => array('id'=>$id,'first_name'=>$first_name,'middle_name'=>$middle_name,'last_name'=>$last_name,'role'=>$isrole,'image'=>$image,'phone_number'=>$phone,'email'=>$email,'sound_notification'=>$sound,'vibrate_notification'=>$vibrate,'do_not_disturb'=>$dnd,'unread_notifications'=>'0'));

		echo json_encode($response);	
		
	}
	
	
	function getForgetPassword()
    {
		$role_id  = $this->input->post('role_id');
		$name  = $this->input->post('name');        
		$source = $this->input->post('source');
		
		$response = array();
		$ecnt = $pcnt = $id = 0;
		 		
		switch($role_id)
		{
			case 1:
				
				if($source == 'email'){								
					$query = $this->db->get_where('parent', array('email' => $name));
					$ecnt = $query->num_rows();
				}
				elseif($source == 'phone'){			
					 
					$query = $this->db->get_where('parent', array('phone' => $name));
					$pcnt = $query->num_rows();
				}
				
				if($ecnt > 0 || $pcnt > 0){
					$row = $query->row();	 
					$id = $row->parent_id;					 
				}				
				
			break;
			case 2:		
			
				if($source == 'email'){								
					$query = $this->db->get_where('teacher', array('email' => $name));
					$ecnt = $query->num_rows();
				}
				elseif($source == 'phone'){								
					$query = $this->db->get_where('teacher', array('phone' => $name));
					$pcnt = $query->num_rows();
				}
				
				if($ecnt > 0 || $pcnt > 0){
					$row = $query->row();
					$id = $row->teacher_id;		
				}
				else{
					
					if($source == 'email'){								
					$query = $this->db->get_where('principal', array('email' => $name));
					$ecnt = $query->num_rows();
					}
					elseif($source == 'phone'){								
						$query = $this->db->get_where('principal', array('phone' => $name));
						$pcnt = $query->num_rows();
					}
					
					if($ecnt > 0 || $pcnt > 0){
						$row = $query->row();
						$id = $row->principal_id;						
					}
					
				}
				
			break;	
			default:
				$id = 0;				
			break;
		}
		
		$otp = rand(1000, 9999);

		$response = array('status'=>'1', 'message' => 'Success' , 'user_id' => $id,'otp'=>"$otp");

		echo json_encode($response);			
	}
	
	function getResetPassword()
	{
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');				 
		$password  = $this->input->post('password');		
		 
		$response = array('status'=>'0','message'=>'user id missing');	 
				 		
		if($user_id > 0){			 
			
			switch($role_id){
			
				case 1:				
					 
					$this->db->where('parent_id', $user_id);			
					$this->db->update('parent', array('password' => sha1($password)));					 
				
				break;				
				case 2:				
					 				
					$this->db->where('teacher_id', $user_id);			
					$this->db->update('teacher', array('password' => sha1($password)));					 
				
				break;	
				case 3:
									 
					$this->db->where('principal_id', $user_id);			
					$this->db->update('principal', array('password' => sha1($password)));					 
				
				break;
				default:
				break;				
			}
			
			$response = array('status'=>'1', 'message' => 'Success'); 
		}	
		 
		echo json_encode($response);
	}
	
	function getUserDetails($user_id,$role_id)
	{
		
		$response = array('status'=>'0', 'message' => 'Invalid user id or role');
				
		if($role_id == 2){								
			$query = $this->db->get_where('teacher', array('teacher_id' => $user_id));
			$cnt = $query->num_rows();
			$row = $query->row();
			$id = $row->teacher_id;
			$image = $this->crud_model->get_image_url('teacher', $id);
			$isrole = '2';
		}
		elseif($role_id == 3){								
			$query = $this->db->get_where('principal', array('principal_id' => $user_id));
			$cnt = $query->num_rows();
			$row = $query->row();
			$id = $row->principal_id;
			$image = $this->crud_model->get_image_url('principal', $id);
			$isrole = '3';
		}
		else{
			$query = $this->db->get_where('parent', array('parent_id' => $user_id));
			$cnt = $query->num_rows();
			$row = $query->row();
			$id = $row->parent_id;
			$image = $this->crud_model->get_image_url('parent', $id);
			$isrole = '1';
		}
					
		if($cnt > 0 ){					 
			
			$first_name = $row->name;
			$middle_name = $row->middle_name;
			$last_name = $row->last_name;			
			$phone = $row->phone;
			$email = $row->email;
			$sound = $row->sound;
			$vibrate = $row->vibrate;
			$dnd = $row->dnd;
			$isverified = $row->phone_verified;	
			$status = $row->status;					
			$notifycnt = $this->getNotifyCnt($user_id,$role_id);
			
			$response = array('status'=>'1', 'message' => 'Success' , 'user_info' => array('id'=>$id,'first_name'=>$first_name,'middle_name'=>$middle_name,'last_name'=>$last_name,'role'=>$isrole,'image'=>$image,'phone_number'=>$phone,'email'=>$email,'sound_notification'=>$sound,'vibrate_notification'=>$vibrate,'do_not_disturb'=>$dnd,'unread_notifications'=>$notifycnt.""));
		}	

		return json_encode($response);
		
	}
	
	function getUserInfo()
	{
		
		$role_id  = $this->input->post('role_id');
		$user_id  = $this->input->post('user_id');
		
		$response = $this->getUserDetails($user_id,$role_id);	

		echo $response;
	}
	
	function getUpdateProfile()
	{
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$password  = $this->input->post('password');				 
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		 
		$response = array('status'=>'0','message'=>'user id missing');	 
				 		
		if($user_id > 0){			
        
        	if($role_id == 2)
			$school_id  = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->school_id;
			elseif($role_id == 2 || $role_id == 3)
			$school_id  = $this->db->get_where('principal', array('principal_id' => $user_id))->row()->school_id;
            else
            $school_id  = $this->db->get_where('student', array('parent_id' => $user_id))->row()->school_id;
			 
			$data['user_id']  = $user_id;
			$data['role_id']  = $role_id;
			$data['name']  = $name;
			$data['email']  = $email;	
			$data['phone']  = $phone;	
        	$data['school_id']  = $school_id;
			$data['password']  = sha1($password);
			
			if($_FILES['image']['name'] !=''){
				
				$timestamp = strtotime(date("Y-m-d H:i:s"));
				
				$directory = "uploads/media/$timestamp"."-$user_id". $_FILES['image']['name'];		
				move_uploaded_file($_FILES['image']['tmp_name'], $directory);				 
				$data['image']  = $directory;
			}			
			
			$this->db->insert('change_request', $data);	
			
			$noti_arr['title'] = 'Update Profile';
			$noti_arr['content'] = 'Update Profile';
			$noti_arr['type'] = '15';
			$noti_arr['type_id'] = '';
			$noti_arr['student_id'] = '0';
			$noti_arr['receiver_id'] = $user_id;
			$noti_arr['receiver_role'] = $role_id;
			$noti_arr['creator_id'] = $user_id;
			$noti_arr['creator_role'] = $role_id;
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			//if($role_id == 1) $noti_arr['student_id'] = $student_id;
			
			$this->db->insert('notifications', $noti_arr);	 		
				
			$this->notificationAlert($user_id,$role_id,$noti_arr,'Update Profile');
						
			$response = array('status'=>'1', 'message' => 'Success');
		}			 
		 
		echo json_encode($response);
	}
	
	function getUpdatePassword()
	{
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$old_pass  = $this->input->post('old_pass');				 
		$new_pass  = $this->input->post('new_pass');		
		 
		$response = array('status'=>'0','message'=>'user id missing');	 
				 		
		if($user_id > 0){			 
			
			switch($role_id){
			
				case 1:
				
					$query = $this->db->get_where('parent', array('parent_id' => $user_id,'password' => sha1($old_pass )));
					$cnt = $query->num_rows();
					
					if($cnt >0)
					{
						$this->db->where('parent_id', $user_id);			
						$this->db->update('parent', array('password' => sha1($new_pass)));
					}else{
						$response = array('status'=>'0','message'=>'Old password is incorrect');
						echo json_encode($response);
						die;
					}
				
				break;				
				case 2:
				
					$query = $this->db->get_where('teacher', array('teacher_id' => $user_id,'password' => sha1($old_pass )));
					$cnt = $query->num_rows();
					
					if($cnt >0)
					{
				
						$this->db->where('teacher_id', $user_id);			
						$this->db->update('teacher', array('password' => sha1($new_pass)));
					}else{
						$response = array('status'=>'0','message'=>'Old password is incorrect');
						echo json_encode($response);
						die;
					}
				
				break;	
				case 3:
				
					$query = $this->db->get_where('principal', array('principal_id' => $user_id,'password' => sha1($old_pass )));
					$cnt = $query->num_rows();
					
					if($cnt >0)
					{
						$this->db->where('principal_id', $user_id);			
						$this->db->update('principal', array('password' => sha1($new_pass)));
					}else{
						$response = array('status'=>'0','message'=>'Old password is incorrect');
						echo json_encode($response);
						die;
					}
				
				break;
				default:
				break;				
			}
			
			echo $user_info = $this->getUserDetails($user_id,$role_id);	
			die;
		}	
		 
		echo json_encode($response);
	}
	
	
	function getNotifyCnt($id,$role)
	{
		$cnt = $this->db->get_where('notifications', array('is_read' => 0,'receiver_id' => $id,'receiver_role' => $role))->num_rows();
		 	 
		return $cnt;
	}
	
	function getBehaviourContent($id)
	{
		$query = $this->db->get_where('behaviour_content', array('behaviour' => $id));
		$cnt = $query->num_rows();	
		$behaviours = array();
		if($cnt > 0 ){
			$behaviours = $query->result();
		}
		return $behaviours;
	}
	
	function getAccessLookups()
	{	
	 	$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		
		if($role_id == 2)
			$school_id  = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->school_id;
		else
			$school_id  = $this->db->get_where('principal', array('principal_id' => $user_id))->row()->school_id;
		
		$query = $this->db->get_where('absent_reason');
		$cnt = $query->num_rows();		
		
		$absent_reason = array();
		if($cnt > 0 ){
			$rows = $query->result();				 		
			foreach($rows as $k=> $v){
				$absent['id'] = $v->id;
				$absent['reason'] = $v->reason;				
				array_push($absent_reason,$absent);
			}
		}		 
		
		$query = $this->db->get_where('exam', array('school_id' => $school_id));
		$cnt = $query->num_rows();			 
		$exams = array();		
		if($cnt > 0 ){
			$rows = $query->result();				
			foreach($rows as $k=> $v){
				$exam['id'] = $v->exam_id;
				$exam['exam_name'] = $v->name;				 
				array_push($exams,$exam);
			}
		}
		
		$query = $this->db->get_where('behaviours', array('school_id' => $school_id));
		$cnt = $query->num_rows();			 
		$behaviours = array();		
		if($cnt > 0 ){
			$rows = $query->result();				
			foreach($rows as $k=> $v){
				$behaviour['id'] = $v->id;
				$behaviour['behaviour_title'] = $v->behaviour_title;				 
				$behaviour['content']  = $this->getBehaviourContent($v->id);
				array_push($behaviours,$behaviour);
			}
		}
		
		$response = array('status'=>'1','message'=>'success','absent_reason'=>$absent_reason,'exam_list'=>$exams,'behaviour'=>$behaviours);
		echo json_encode($response);
		
	}
	
	function getMyClass($user_id,$role_id){
	
		if($role_id == 2)
			$sections  = $this->db->get_where('section', array('teacher_id' => $user_id))->result_array();
		if($role_id == 3)
			$sections  = $this->db->get_where('section', array('principal_id' => $user_id))->result_array();
		
		$myclass = $myclasses = array();
		if(count($sections) > 0){				 
		
			foreach ($sections as $section) {  
				
			$section_id = $section['section_id'];
			$section_name = $section['name'];
			$total_seat = $section['total_seat'];
			$divides = $section['divides'];
			$columns = $section['columns'];
			$class_id = $section['class_id'];
			$class = $this->db->get_where('class', array('class_id' => $class_id))->row();
			$class_name = $class->name;			 

			$this->db->select('GROUP_CONCAT(subject.class_subject SEPARATOR ",") as subject_id,GROUP_CONCAT(subject.name SEPARATOR ",") as subject_name');
			$this->db->from('subject');
			
			if($role_id == 2) $this->db->where('teacher_id', $user_id); 
			elseif($role_id == 3) $this->db->where('principal_id', $user_id);
							 
			$this->db->where('class_id', $class_id);
			$this->db->where('section_id', $section_id);
			$subject_row = $this->db->get()->row();
			$subject_id = $subject_row->subject_id;	
			$subject_name = $subject_row->subject_name;
	
			$students = $this->db->get_where('enroll', array('class_id' => $class_id,'section_id' => $section_id))->result_array();
			
			$student_info  = array();
			foreach ($students as $row) {
				$student_id = $row['student_id'];
				$student = $this->db->get_where('student', array('student_id' => $student_id))->row();
				
				$student_data['id'] = $student_id;
				$student_data['admission_number'] = $student->student_code;
				$student_data['first_name'] = $student->name;
				$student_data['middle_name'] = $student->middle_name;
				$student_data['last_name'] = $student->last_name;
				$student_data['image'] = $this->crud_model->get_image_url('student', $student_id);
				$student_data['level'] = '';
				$student_data['class_id'] = $class_id;
				$student_data['class_name'] = $class_name;
				$student_data['section_id'] = $section_id;
				$student_data['section_name'] =  $section_name;
				$seat = (int)$this->db->get_where('class_layout_places', array('student_id' => $student_id))->row()->position;
				$student_data['seat'] = "$seat";
				array_push($student_info,$student_data);
			}
			
			$myclass['class_id'] = $class_id;
			$myclass['class_name'] = $class_name;
			$myclass['section_id'] = $section_id;
			$myclass['section_name'] = $section_name;
			$myclass['subject_id'] = $subject_id;
			$myclass['subject_name'] = $subject_name;
			$myclass['total_seat'] = $total_seat;
			$myclass['divides'] = $divides;
			$myclass['column'] = $columns;
			$myclass['myclass'] = '1';
			$myclass['student'] = $student_info;	
			
			array_push($myclasses,$myclass);			
			}			
		}	
		return $myclasses;
	}
	
	function getAccessTeachersDetails()
    {
		
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		
		if($role_id == 2)
			$query = $this->db->get_where('teacher', array('teacher_id' => $user_id));
		elseif($role_id == 3)
			$query = $this->db->get_where('principal', array('principal_id' => $user_id));
		$cnt = $query->num_rows();			
		 
		$response     = array('status'=>'0','message'=>'no data');
		
		if($cnt > 0 ){						
			
			$running_year = $this->db->get_where('settings', array(	'type' => 'running_year'))->row()->description;
			
			$this->db->select('*');
			if($role_id == 2){
				$this->db->where('teacher_id', $user_id);
				$this->db->where('principal_id', 0);
			}
			elseif($role_id == 3){
				$this->db->where('principal_id', $user_id);
				$this->db->where('teacher_id', 0);
			}
			$this->db->group_by('class_subject'); 			
			$subjects = $this->db->get('subject')->result_array();
			
			$teaching_subjects    = array();
			if(count($subjects) > 0){
				foreach ($subjects as $row) {
					$data['subject_id'] = $row['class_subject'];
					$data['name']       = $row['name'];				 
					array_push($teaching_subjects, $data);
				}
			}
			
			$this->db->select('GROUP_CONCAT(subject.section_id SEPARATOR ",") as section_id,GROUP_CONCAT(subject.subject_id SEPARATOR ",") as subject_id');
			$this->db->from('subject');
			if($role_id == 2){
				$this->db->where('teacher_id', $user_id);
				$this->db->where('principal_id', 0);
			}
			if($role_id == 3){
				$this->db->where('principal_id', $user_id);
				$this->db->where('teacher_id', 0);
			}
			
			$subject_row = $this->db->get()->row();	
			$timetable  = $tables = array();
			
			if( count($subject_row) > 0){
				$section_id = $subject_row->section_id;	 
				$subject_id = $subject_row->subject_id;		
				if($section_id !=''){
					$this->db->select('*');
					$this->db->from('section');
					$this->db->where_in('section_id', explode(',',$section_id));
					$query = $this->db->get(); 
					if($query->num_rows() > 0){
						$sections = $query->result_array();
						$subject_id = ($subject_id!='')?$subject_id.',0':'0';	
						foreach($sections as $row){
					
							$class_id = $row['class_id'];
							$class_name = $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;
							$section_name = $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;
							
							for($d=1;$d<=7;$d++){
								
								if($d==1)$day='sunday';
								else if($d==2)$day='monday';
								else if($d==3)$day='tuesday';
								else if($d==4)$day='wednesday';
								else if($d==5)$day='thursday';
								else if($d==6)$day='friday';
								else if($d==7)$day='saturday';
																 
								$this->db->where('day' , $day);
								$this->db->where('class_id' , $class_id);
								$this->db->where('section_id' , $row['section_id']);
								$this->db->where_in('subject_id', explode(',',$subject_id));
								$this->db->where('year' , $running_year);
								$routines = $this->db->get('class_routine')->result_array();
								 
								foreach($routines as $row2){
										
									$subject_name = ($row2['subject_id']>0)?$this->crud_model->get_subject_name_by_id($row2['subject_id']):$row2['break_title']; 
									
										if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0){ 
											$time_start = ($row2['time_start']>12)?$row2['time_start']-12:$row2['time_start'];
											$time_end = ($row2['time_end']>12)?($row2['time_end']-12):$row2['time_end'];
											$timestate = ($row2['time_end']>11 || $row2['time_end']<8)?'PM ':'AM';
											$timestate1 = ($row2['time_start']>11 || $row2['time_start']<8)?'PM ':'AM';
											$time = $time_start.'-'.$time_end.$timestate; 
											$otime = $time_start.':00'. $timestate1; 
										}
										elseif ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0){
											$time_start = ($row2['time_start']>12)?$row2['time_start']-12:$row2['time_start'];
											$time_end = ($row2['time_end']>12)?$row2['time_end']-12:$row2['time_end'];
											
											$timestate = ($row2['time_end']>11 || $row2['time_end']<8)?'PM ':'AM';
											$timestate1 = ($row2['time_start']>11 || $row2['time_start']<8)?'PM ':'AM';
											$time_start_min = ($row2['time_start_min'] >9)?$row2['time_start_min']:$row2['time_start_min'].'0';
											$time = $time_start.':'.$row2['time_start_min'].'-'.$time_end.':'.$row2['time_end_min'].$timestate;
											$otime = $time_start.':'.$time_start_min. $timestate1; 
										}
										 
									$ordertime = strtotime($otime);	 
									$tables[$ordertime][$day]['type'] = $row2['type']; 
									$tables[$ordertime][$day]['time'] = $time;	
									$tables[$ordertime][$day]['day'] = "$subject_name\n$class_name$section_name";		
								}								
								
							}
						}
					}
				}
								 
				ksort($tables);
				 				 
				$i=1;
				$statictable  = array('slot'=>"$i",'time'=>'','mon'=>'','tue'=>'','wed'=>'','thu'=>'','fri'=>'','sat'=>'','break_name'=>'','type'=>'header');
				array_push($timetable,$statictable);
					
				foreach($tables as $t => $v){
					
					$slot['slot'] = "$i";			
										 
					for($d=1;$d<=7;$d++){									
						 
						if($d==1)$day='sunday';
						elseif($d==2)$day='monday';
						else if($d==3)$day='tuesday';
						else if($d==4)$day='wednesday';
						else if($d==5)$day='thursday';
						else if($d==6)$day='friday';
						else if($d==7)$day='saturday';
						
						if(isset($v[$day]['type'])) $type = $v[$day]['type'];
						
						if(isset($v[$day]['time'])) $slot['time'] = $v[$day]['time'];		
						 						
						if(isset($v[$day]['day'])) $sub_title = $v[$day]['day'];
						
						$slot[substr($day,0,3)] = (isset($v[$day]['day']) && $type == 1)?$sub_title :'';	
						 
					}
					
					$slot['break_name'] = ($type == 2)?$sub_title :'';
					$slot['type'] = ($type == 1)?'class':'break';			

					array_push($timetable,$slot);
					
					$i++;
				}
			}			 
			
			$myclass = $this->getMyClass($user_id,$role_id);	


			$this->db->select('subject.class_id,subject.section_id,GROUP_CONCAT(subject.class_subject SEPARATOR ",") as subject_id,GROUP_CONCAT(subject.name SEPARATOR ",") as subject_name');
			$this->db->from('subject');
			if($role_id == 2){
				$this->db->where('teacher_id', $user_id);
				$this->db->where('principal_id', 0);
			}
			if($role_id == 3){
				$this->db->where('principal_id', $user_id);
				$this->db->where('teacher_id', 0);
			}
			$this->db->group_by('subject.class_id'); 	
			$this->db->group_by('subject.section_id'); 
			$subjects = $this->db->get()->result_array();	 
			 
			$subject_class    = array();
			if(count($subjects) > 0){
								
				$this->db->select('GROUP_CONCAT(section.section_id SEPARATOR ",") as section_id ');
				$this->db->from('section');				
				if($role_id == 2) $this->db->where('teacher_id', $user_id); 
				elseif($role_id == 3) $this->db->where('principal_id', $user_id);						 
				$myClassSections = $this->db->get()->row();
								
				$myClassSection = array(0);
				if(count($myClassSections)>0) $myClassSection = explode(',',$myClassSections->section_id);
				 		 								
				foreach ($subjects as $row) {
					$subject_id = $row['subject_id'];
					$subject_name = $row['subject_name'];						
					$class_id = $row['class_id'];
					$section_id = $row['section_id'];
					$section = $this->db->get_where('section', array('section_id' => $section_id))->row();
					$section_name = $section->name;
					$total_seat = $section->total_seat;
					$divides = $section->divides;
					$columns = $section->columns;
					$class = $this->db->get_where('class', array('class_id' => $class_id))->row();
					$class_name = $class->name;					 

					$ismyclass = '0';
					if(in_array($section_id,$myClassSection)) $ismyclass ='1'; 
					
					$students = $this->db->get_where('enroll', array('class_id' => $class_id,'section_id' => $section_id))->result_array();
				
					$student_info  = array();
					foreach ($students as $row) {
						$student_id = $row['student_id'];
						$student = $this->db->get_where('student', array('student_id' => $student_id))->row();
						
						$student_data['id'] = $student_id;
						$student_data['admission_number'] = $student->student_code;
						$student_data['first_name'] = $student->name;
						$student_data['middle_name'] = $student->middle_name;
						$student_data['last_name'] = $student->last_name;
						$student_data['image'] = $this->crud_model->get_image_url('student', $student_id);
						$student_data['level'] = '';
						$student_data['class_id'] = $class_id;
						$student_data['class_name'] = $class_name;
						$student_data['section_id'] = $section_id;
						$student_data['section_name'] =  $section_name;
						$seat = (int)$this->db->get_where('class_layout_places', array('student_id' => $student_id))->row()->position;
						$student_data['seat'] = "$seat";
						array_push($student_info,$student_data);
					}
					
					$subject_class_data['class_id'] = $class_id;
					$subject_class_data['class_name'] = $class_name;
					$subject_class_data['section_id'] = $section_id;
					$subject_class_data['section_name'] = $section_name;
					$subject_class_data['subject_id'] = $subject_id;
					$subject_class_data['subject_name'] = $subject_name;
					$subject_class_data['total_seat'] = $total_seat;
					$subject_class_data['divides'] = $divides;
					$subject_class_data['column'] = $columns;
					$subject_class_data['myclass'] = $ismyclass;
					$subject_class_data['student'] = $student_info;			
					
					array_push($subject_class, $subject_class_data);
				}
			}			
			
			$response = array('status'=>'1','message'=>'success','teaching_subjects'=>$teaching_subjects,'timetable'=>$timetable,'my_class'=>$myclass,'subject_class'=>$subject_class);			 		
		}		
		
        echo json_encode($response);
    }
	
	function getForumComments($forum_id)
	{
		
		$comments_data = $this->db->get_where('group_message', array('group_message_thread_id' => $forum_id))->result_array();
		
		$comments = array();		
		
		if(count($comments_data) > 0){
				
			foreach ($comments_data as $row) {
				 
				if ($row['sender_role'] == 2)
					$comment_by_name = $this->db->get_where('teacher', array('teacher_id' => $row['sender_id']))->row()->name;
				elseif ($row['sender_role'] == 3)
					$comment_by_name = $this->db->get_where('principal', array('principal_id' => $row['sender_id']))->row()->name;
				else
					$comment_by_name = $this->db->get_where('parent', array('parent_id' => $row['sender_id']))->row()->name;
				
				$comment['comment_id'] = $row['group_message_id'];
				$comment['comment'] = $row['message'];
				$comment['comment_by_id'] = $row['sender_id'];
				$comment['comment_by_name'] = $comment_by_name;
				$comment['comment_on'] = $row['created_on'];		 
				
				array_push($comments,$comment);
			}	
			
		}
		
		return $comments;
		
	}
	 
	
	function getForumsListComments($forum_id=0,$iscomments=0,$user_id=0,$role_id=0,$student_id=0,$type='',$status='',$last_id='')
	{
		
		if($forum_id > 0){ 
		  $forums_data = $this->db->get_where('group_message_thread', array('group_message_thread_id' => $forum_id))->result_array();	
		}
		elseif($user_id > 0){
			
			if($role_id == 1){
				
				//$student_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->student_id;
			
				$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
				$class_id = $roll->class_id;
				$section_id = $roll->section_id;
				
				if($last_id > 0){  					
									
					$condi_arr = ($status == 1)?array('group_message_thread_id >' => $last_id,'type' => $type,'is_open' => $status,'class_id' => $class_id,'section_id' => $section_id):array('group_message_thread_id >' => $last_id,'type' => $type,'class_id' => $class_id,'section_id' => $section_id);
					
					$forums_data = $this->db->get_where('group_message_thread', $condi_arr ,0,20)->result_array();
					
				}else{
					
					$condi_arr = ($status == 1)?array('type' => $type,'is_open' => $status,'class_id' => $class_id,'section_id' => $section_id):array('type' => $type,'class_id' => $class_id,'section_id' => $section_id);
				
					$forums_data = $this->db->order_by('group_message_thread_id', 'DESC')->get_where('group_message_thread', $condi_arr ,0,20)->result_array();
					
				}
				
			}else{						
			
				if($last_id > 0){ 		
					
					$query = "select * from group_message_thread where group_message_thread_id > $last_id AND type='$type' AND ((sender_id = '$user_id' AND sender_role = '$role_id') OR send_to = '$role_id') ";
					
					if($status == 1) $query.= " AND is_open = '$status' ";
					
					$query.= " limit 0,20 ";
					
					$forums_data = $this->db->query($query)->result_array();
							
				}else{				

					$query = "select * from group_message_thread where type='$type' AND ((sender_id = '$user_id' AND sender_role = '$role_id') OR send_to = '$role_id') ";
					
					if($status == 1) $query.= " AND is_open = '$status' ";
					
					$query.= " order by group_message_thread_id desc limit 0,20 ";
					
					$forums_data = $this->db->query($query)->result_array();
        				 	
				}				
				 
			}
		}
		else{
			$forums_data = $this->db->get_where('group_message_thread', array('type' => $type))->result_array();
		}
		
		$forums = array();
		
		$response = array('status'=>'1','message'=>'no data','forums_list'=>array());
		
		if(count($forums_data) > 0){
				
			foreach ($forums_data as $row) {
				
				$sender_role = $row['sender_role'];
				
				$forum['id'] = $row['group_message_thread_id'];
				$forum['topic'] = $row['group_name'];
				$forum['posted_id'] = $row['posted_id'];
				$forum['posted_name'] = ($sender_role == 2)?$this->db->get_where('teacher', array('teacher_id' => $row['posted_id']))->row()->name:$this->db->get_where('principal', array('principal_id' => $row['posted_id']))->row()->name;
				$forum['posted_on'] = $row['posted_on'];				
				$forum['from'] = $row['send_from'];
				$forum['to'] = $row['send_to'];
				$forum['class_id'] = $row['class_id'];
				$forum['class_name'] = ($row['class_id'] >0)?$this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name:'';
				$forum['section_id'] = $row['section_id'];
				$forum['section_name'] =  ($row['section_id'] >0)?$this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name:'';
				$forum['is_open'] = $row['is_open'];
				$sender_id = ($user_id >0)?$user_id:$row['sender_id'];
				$role_id = ($role_id >0)?$role_id:$row['sender_role'];
				$row['sender_role'];
				$is_fav = (int) $this->db->get_where('favorite_message', array('thread_id' => $row['group_message_thread_id'],'user_id' => $sender_id,'role_id' => $role_id))->row()->is_fav;
				$forum['is_fav'] = "$is_fav";
				$forum['type'] = $row['type'];
				$comments = $this->getForumComments($row['group_message_thread_id']);
				$total_comments = count($comments);
				$forum['total_comments'] = "$total_comments";
				
				if($iscomments == 1) $forum['comments'] = $comments;
				
				array_push($forums,$forum);
			}
			
			$response = array('status'=>'1','message'=>'success','forums_list'=>$forums);
		}
		
		return $response;
		
	}
	
	function getMessageList($user_id,$role_id)
	{
		$sender = $user_id."_".$role_id;
		
		$query = "select * from msgchat where (sender like '$sender' OR receiver like '$sender') ";
		 				
		$messages_data = $this->db->query($query)->result_array();
						
		$messages = array();
		
		$response = array('status'=>'1','message'=>'no data','message_list'=>array());
		
		if(count($messages_data) > 0){
				
			foreach ($messages_data as $k=> $row) {
				
				if($sender == $row['sender']){
					 
					$receiver = explode('_',$row['receiver']); 
					$message['friend_id'] = $friend_id = $receiver[0];
					$message['role_id'] =  $role_id = $receiver[1];	
					
				}else{
					
					$receiver = explode('_',$row['sender']);				 
					$message['friend_id'] = $friend_id = $receiver[0];
					$message['role_id'] = $role_id = $receiver[1];
				}
			
				if($role_id == 1){
					
					$message['name'] = $this->db->get_where('parent', array('parent_id' => $friend_id))->row()->name;
					$message['image'] = $this->crud_model->get_image_url('parent', $friend_id);
				}elseif($role_id == 2){
					
					$message['name'] = $this->db->get_where('teacher', array('teacher_id' => $friend_id))->row()->name;
					$message['image'] = $this->crud_model->get_image_url('teacher', $friend_id);
				}elseif($role_id == 3){
					
					$message['name'] = $this->db->get_where('principal', array('principal_id' => $friend_id))->row()->name;
					$message['image'] = $this->crud_model->get_image_url('principal', $friend_id);
				}				
				
				$message['last_online'] = '';
				array_push($messages,$message);
			}
			
			$response = array('status'=>'1','message'=>'success','message_list'=>$messages);
		}
		
		return $response;
		
	}
	
	function getHealthList($student_id)
	{
		
		$healths_data = $this->db->get_where('health_reports', array('student_id' => $student_id))->result_array();
		
		$healths = array();
		
		$response = array('status'=>'1','message'=>'no data','allergies'=>array());
		
		if(count($healths_data) > 0){
				
			foreach ($healths_data as $row) {
				
				$health['id'] = $row['id'];
				$health['name'] = $row['title'];
				$health['details'] = $row['details'];
				$health['action'] = $row['action'];
				$health['concern_date'] = $row['concern_date'];
				$health['updated_date'] = $row['updated_date'];
				array_push($healths,$health);
			}
			
			$response = array('status'=>'1','message'=>'success','allergies'=>$healths);
		}
		
		return $response;
		
	}
	
	function getHealthLastOccurenceList($student_id)
	{
		
		$healths_data = $this->db->get_where('health_last_occurence', array('student_id' => $student_id))->result_array();
		
		$healths = array();
		
		$response = array('status'=>'1','message'=>'no data','last_occurences'=>array());
		
		if(count($healths_data) > 0){
				
			foreach ($healths_data as $row) {
				
				$health['id'] = $row['id'];
				$health['name'] = $row['title'];
				$health['details'] = $row['details'];
				$health['action'] = $row['action'];
				$health['concern_date'] = $row['concern_date'];
				$health['updated_date'] = $row['updated_date'];
				array_push($healths,$health);
			}
			
			$response = array('status'=>'1','message'=>'success','last_occurences'=>$healths);
		}
		
		return $response;
		
	}
	
	function getGroupslist($user_id,$role_id)
	{
		
			$groupmem = array();
			
			$response = array('status'=>'1','message'=>'no data','group'=>array());
			
			$groups = $this->db->get_where('groups', array('user_id' => $user_id,'role_id' => $role_id))->result_array();
		
			if(count($groups) > 0){
				
				foreach ($groups as $row) {
					
					$class_id = $row['class_id'];
					$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
					$section_id = $row['section_id'];
					$section_name = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
					$subject_id = $row['subject_id'];
					$subject_name = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name;
					$group_id = $row['id'];
					$group_name = $row['group_name'];
					$studentIds = $row['students'];
					$user_id = $row['user_id'];
					$role_id = $row['role_id'];
					$created_on = $row['created_on'];					
					 			
					$students = $this->db->where_in('student_id', explode(',',$studentIds))->get('student')->result_array();
					 
					$student_info = $student_data = array();
					foreach($students as $row2){
						
						$student_data['id'] = $row2['student_id'];
						$student_data['admission_number'] = $row2['student_code'];
						$student_data['name'] = $row2['name'];
						array_push($student_info,$student_data);
					}
					
					$mem_data['id'] = $group_id;
					$mem_data['name'] = $group_name;
					$mem_data['class_id'] = $class_id;
					$mem_data['class_name'] = $class_name;
					$mem_data['section_id'] = $section_id;
					$mem_data['section_name'] = $section_name;
					$mem_data['subject_id'] = $subject_id;
					$mem_data['subject_name'] = $subject_name;					 
					$mem_data['group_members'] = $student_info;	
					$mem_data['creator_id'] = $user_id;	
					$mem_data['creator_name'] = ($role_id == 2)?$this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->name:$this->db->get_where('principal', array('principal_id' => $user_id))->row()->name;	
					$mem_data['created_on'] = $created_on;	
					
					array_push($groupmem, $mem_data);
					
				}
				
				$response = array('status'=>'1','message'=>'success','group'=>$groupmem);
			}
			
			return $response;
	}
	
	function getAccessTeachersGroup()
    {
		
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		
		if($role_id == 2)
			$query = $this->db->get_where('teacher', array('teacher_id' => $user_id));
		elseif($role_id == 3)
			$query = $this->db->get_where('principal', array('principal_id' => $user_id));
		
		$cnt = $query->num_rows();			
		 
		$response = array('status'=>'0','message'=>'no data', 'group' =>array());
		
		if($cnt > 0 ){		
		
			$response = $this->getGroupslist($user_id,$role_id);
		}
		
		echo json_encode($response);
	}
	
	function getAccessStudentInfo()
	{
	
		$student_id      = $this->input->post('student_id');
		  
		$response        = array();
				
		$student_profile = $this->db->get_where('student', array('student_id' => $student_id))->result_array();
		
        foreach ($student_profile as $row) {
			
            $student['id']  = $row['student_id'];
			$student['admission_number']  = $row['student_code'];
            $student['first_name'] = $row['name'];
			$student['middle_name'] = $row['middle_name'];
			$student['last_name'] = $row['last_name'];
			$student['gender'] = $row['sex'];
			$student['image'] = $this->crud_model->get_image_url('student', $row['student_id']);
			$student['level'] = '';			
            $student['DOB'] = $row['birthday'];
			$seat = (int)$this->db->get_where('class_layout_places', array('student_id' => $student_id))->row()->position;
			$behaviour = $this->getBehaviourRatting($row['student_id']);
            $student['seat'] = "$seat";
            $student['avg_grade'] = '';
            $student['avg_position'] = '';
            $student['overall_behaviour'] = $behaviour['report'];
            $student['behaviour_ratting'] = $behaviour['ratting'];	 
			$parent_id = $row['parent_id'];
        }
       		
        $roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
        $class_id = $roll->class_id;
        $section_id = $roll->section_id;
		$section = $this->db->get_where('section', array('section_id' => $section_id))->row();
		$section_name = $section->name;
		$total_seat = $section->total_seat;
		$divides = $section->divides;
		$columns = $section->columns;
		$class = $this->db->get_where('class', array('class_id' => $class_id))->row();
		$class_name = $class->name;		
		$school_id = $class->school_id;
				
		$query = $this->db->get_where('parent', array('parent_id' => $parent_id));
		$cnt = $query->num_rows();
		$parent_details=array();
		if($cnt >0){
			$parent = $query->row();
			$parent_id = $parent->parent_id;
			$image = $this->crud_model->get_image_url('parent', $parent_id);
			
			$parent_details['id'] = $parent_id;
			$parent_details['first_name'] = $parent->name;
			$parent_details['middle_name'] = $parent->middle_name;
			$parent_details['last_name'] = $parent->last_name;
			$parent_details['occupation'] = $parent->profession;
			$parent_details['image'] = $image;
			$parent_details['email'] = $parent->email;
			$parent_details['phone_number'] = $parent->phone;			
		}
		$student['parent_details'][] = $parent_details;
		
		$school_data = $this->db->get_where('school', array('school_id' => $school_id))->row();
		$school['school_id'] = $school_data->school_id;
		$school['school_name'] = $school_data->school_name;
		$school['school_logo'] = $school_data->logo;		
		$student['school_details'] = $school;
		
		$class_details['class_id'] = $class_id;
		$class_details['class_name'] = $class_name;
		$class_details['section_id'] = $section_id;
		$class_details['section_name'] = $section_name;
		$class_details['total_seat'] = $total_seat;
		$class_details['divides'] = $divides;
		$class_details['column'] = $columns;
		$class_details['level'] = '';
		
		$student['class_details'] = $class_details;
				
		$student['class_teacher'] = $this->getClassTeacher($class_id,$section_id);
 		
		$student['subject_teachers'] = $this->getSubjectTeacher($class_id,$section_id);       
		
		$response = array('status'=>'1','message'=>'success','student'=>$student);
		echo json_encode($response);
	}
	
	function getClassTeacher($class_id,$section_id)
	{
		$user_id = $this->db->get_where('section', array('section_id' => $section_id))->row()->teacher_id;
		$role_id=2;
		
		if((int)$user_id == 0){
			$user_id = $this->db->get_where('section', array('section_id' => $section_id))->row()->principal_id;
			$role_id=3;
		}
		
		$class_teacher = array();
		$class_teacher['id'] = '';
		$class_teacher['first_name'] = '';
		$class_teacher['middle_name'] = '';
		$class_teacher['last_name'] = '';
		$class_teacher['image'] =  '';
		$class_teacher['phone'] = '';
		$class_teacher['email'] = '';
		
		if($user_id > 0){

			if($role_id == 2){
				$teacher = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row();	
				$class_teacher_id = $user_id;
				$image = $this->crud_model->get_image_url('teacher', $user_id);
			}
			elseif($role_id == 3){
				$teacher = $this->db->get_where('principal', array('principal_id' => $user_id))->row();	
				$class_teacher_id = $user_id;
				$image = $this->crud_model->get_image_url('principal', $user_id);
			}
			
			$class_teacher['id'] = $class_teacher_id;
			$class_teacher['first_name'] = $teacher->name;
			$class_teacher['middle_name'] = $teacher->middle_name;
			$class_teacher['last_name'] = $teacher->last_name;
			$class_teacher['image'] =  $image;
			$class_teacher['phone'] = $teacher->phone;
			$class_teacher['email'] = $teacher->email;
			
			$this->db->select('GROUP_CONCAT(subject.subject_id SEPARATOR ",") as subject_id,GROUP_CONCAT(subject.name SEPARATOR ",") as subject_name');
			$this->db->from('subject');
			
			if($role_id == 2) $this->db->where('teacher_id', $user_id);
			elseif($role_id == 3) $this->db->where('principal_id', $user_id);
			
			$this->db->where('class_id', $class_id);
			$this->db->where('section_id', $section_id);
			$subject_row = $this->db->get()->row();
			$class_teacher['subject_id'] = ((int)$subject_row->subject_id>0)?$subject_row->subject_id:'';	
			$class_teacher['subject_name'] = ((int)$subject_row->subject_id>0)?$subject_row->subject_name:'';			
		}		
		
		return $class_teacher;
	}
	function getSubjectTeacher($class_id,$section_id)
	{
		$subjects = $this->db->get_where('subject', array('class_id' => $class_id,'section_id' => $section_id))->result_array();
		
		$subject_teachers  = array();
		
		if(count($subjects) > 0){
			
			foreach ($subjects as $row) {			
				
				$subject_id = $row['subject_id'];
				$subject_name = $row['name'];
				
				$teacher_id = $row['teacher_id'];	
				$teacher_role = 2;
				if($teacher_id == 0){ $teacher_id = $row['principal_id']; $teacher_role = 3; }
				
				if($teacher_role == 2){
					$teacher = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row();	
					$subject_teacher_id = $teacher->teacher_id;
					$image = $this->crud_model->get_image_url('teacher', $subject_teacher_id);
				}
				elseif($teacher_role == 3){
					$teacher = $this->db->get_where('principal', array('principal_id' => $teacher_id))->row();	
					$subject_teacher_id = $teacher->principal_id;
					$image = $this->crud_model->get_image_url('principal', $subject_teacher_id);
				}
				
				$subject_teacher['id'] = $subject_teacher_id;
				$subject_teacher['first_name'] = $teacher->name;
				$subject_teacher['middle_name'] = $teacher->middle_name;
				$subject_teacher['last_name'] = $teacher->last_name;
				$subject_teacher['image'] =  $image;
				$subject_teacher['subject_id'] = $subject_id;
				$subject_teacher['subject_name'] = $subject_name;
				$subject_teacher['phone'] = $teacher->phone;
				$subject_teacher['email'] = $teacher->email;
				
				array_push($subject_teachers, $subject_teacher);				
			}		
			
		}

		return $subject_teachers;	
	}
	
	function getAccessStudentTeacher()
	{
	
		$student_id      = $this->input->post('student_id');
		  
		$response        = array();
						       		
        $roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
        $class_id = $roll->class_id;
        $section_id = $roll->section_id;
		$section = $this->db->get_where('section', array('section_id' => $section_id))->row();
		$section_name = $section->name;
		$total_seat = $section->total_seat;
		$divides = $section->divides;
		$columns = $section->columns;
		$class = $this->db->get_where('class', array('class_id' => $class_id))->row();
		$class_name = $class->name;		
		$school_id = $class->school_id;	 

		$teachers['class_teacher'] = $this->getClassTeacher($class_id,$section_id); 
		
		$teachers['subject_teachers'] = $this->getSubjectTeacher($class_id,$section_id);     
			
		$response = array('status'=>'1','message'=>'success','teachers'=>$teachers);
		echo json_encode($response);
	}
	
	function getAccessStudentEducation()
	{
	
		$student_id  = $this->input->post('student_id');
		
		$school_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->school_id;
		  
		$response  = array();
		
		$exams = $this->db->get_where('exam', array('school_id' => $school_id))->result_array();
		$overall_marks = $detail_marks  = array();
		$grades = '';
		
		foreach ($exams as $row) {
			
			$overall_mark['id'] = $detail_mark['id'] = $row['exam_id']; 
			$overall_mark['exam_name'] = $detail_mark['exam_name'] = $row['name']; 		 
						       		
			$student_marks_arr = $this->db->get_where('mark', array('exam_id' => $row['exam_id'],'student_id' => $student_id))->result_array();
						       
			$marks  = array();
			$total_marks = $student_marks = 0;
			$grades = '';
			 
			foreach ($student_marks_arr as $row2) {
				 
				$subject_mark['subject_name'] = $this->db->get_where('subject', array('subject_id' => $row2['subject_id']))->row()->name;
				
				$subject_mark['total_mark'] = $row2['mark_total']; 
				$subject_mark['student_mark'] = $row2['mark_obtained'];          
				$grade = $this->crud_model->get_grade($row2['mark_obtained'],$school_id);
				$subject_mark['grade'] = $grades = (isset($grade['name']))?$grade['name']:'';       
				$total_marks = $total_marks + $subject_mark['total_mark'];
				$student_marks = $student_marks + $subject_mark['student_mark'];
				array_push($marks, $subject_mark);	
			} 
			$overall_mark['total_marks'] = "$total_marks";
			$overall_mark['student_marks'] = "$student_marks";
			$overall_mark['grade'] = $detail_mark['grade'] = $grades; 
			$detail_mark['marks'] = $marks;
			
			if((int)$total_marks == 0) continue;
			
			array_push($detail_marks, $detail_mark);	
			array_push($overall_marks, $overall_mark);
		}
		
		$eduction['report_download_link']= $this->report($student_id,5);
		
		$eduction['overall_marks']= (count($overall_marks) >0)?$overall_marks:array();	
		$eduction['detail_marks']= (count($detail_marks) >0)?$detail_marks:array();		 
		
		$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
        $class_id = $roll->class_id;
        $section_id = $roll->section_id;
		$assignments = $this->db->get_where('assignments', array('class_id' => $section_id))->result_array();
		$tasks  = array(); 
		foreach ($assignments as $row) {
			
			$task['title'] = $row['title'];
			$task['date'] = $row['due_date'];
			array_push($tasks, $task);
		}
		$eduction['assignments']= $tasks;
		$eduction['overall_performance_grade']= $grades;
				
		$response = array('status'=>'1','message'=>'success','education'=>$eduction);
		echo json_encode($response);
	}
	
	function getBehaviourRatting($student_id)
	{	
		
		$school_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->school_id;
		  
		$behaviours = $no_reportAction = array();
		
		$no_reportCnts = $totreports = 0;
		
		$behaviours_data = $this->db->get_where('behaviours', array('school_id' => $school_id))->result_array();
			
		foreach ($behaviours_data as $row) {			
						 
			$behaviour_content = $this->db->get_where('behaviour_content', array('behaviour' =>$row['id']))->result_array();
        
			$contents  = array();
			 
			foreach ($behaviour_content as $row2) {
				
				$reports = $this->db->get_where('behaviour_reports', array('student_id' =>$student_id,'behaviour' =>$row2['id']))->row();
				$content['report'] = (isset($reports->report))?$reports->report:'Yes';
				$content['action'] = (isset($reports->action))?$reports->action:'';				 
				$totreports += 1;
				if($content['report'] == 'No'){ $no_reportCnts += 1; $no_reportAction[$content['action']] = $content['action'];}
			}  	
		}
		
		
		$action_taken = (count($no_reportAction) >0)?implode(',',$no_reportAction):'No';

		$behaviours['report']= ($no_reportCnts > 5)?'Need to improve':'Good';
		$ratting = ($totreports >0)?floor((($totreports-$no_reportCnts)/$totreports)* 5):0;
		$behaviours['ratting']= "$ratting";
		
		return $behaviours;
		 
	}
	
	function getAccessStudentBehaviour()
	{
	
		$student_id  = $this->input->post('student_id');
		
		$school_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->school_id;
		  
		$overall_behaviours = $detail_behaviours = $response  = $behaviours = $no_reportAction = array();
		
		$no_reportCnts = $totreports = 0;
		
		$behaviours_data = $this->db->get_where('behaviours', array('school_id' => $school_id))->result_array();
			
		foreach ($behaviours_data as $row) {
			
			$overall_behaviour['id'] = $detail_behaviour['id'] = $row['id'];
			$overall_behaviour['behaviour_title'] = $detail_behaviour['behaviour_title'] = $row['behaviour_title'];
						 
			$behaviour_content = $this->db->get_where('behaviour_content', array('behaviour' =>$row['id']))->result_array();
        
			$contents  = array();
			 
			foreach ($behaviour_content as $row2) {
				$content['id'] = $row2['id'];
				$content['content_name'] = $row2['content_name'];
				$reports = $this->db->get_where('behaviour_reports', array('student_id' =>$student_id,'behaviour' =>$row2['id']))->row();
				$content['report'] = (isset($reports->report))?$reports->report:'Yes';
				$content['action'] = (isset($reports->action))?$reports->action:'';
				array_push($contents, $content);
				$totreports += 1;
				if($content['report'] == 'No'){ $no_reportCnts += 1; $no_reportAction[$content['action']] = $content['action'];}
			}  		

			$overall_behaviour['report'] = ($no_reportCnts > 5)?'Need to improve':'Good';	
	 
			$detail_behaviour['content'] = $contents;
			
			array_push($detail_behaviours, $detail_behaviour);	
			array_push($overall_behaviours, $overall_behaviour);
		}
		
		
		$action_taken = (count($no_reportAction) >0)?implode(',',$no_reportAction):'No';
		$ratting = floor((($totreports-$no_reportCnts)/$totreports)* 5);
		$behaviours['overall_behaviour_report']= ($no_reportCnts > 5)?'Need to improve':'Good';
		
		$behaviours['report_download_link']= $this->report($student_id,2);
		$behaviours['overall_behaviour_ratting']= "$ratting";
		$behaviours['overall_behaviour']= $overall_behaviours;
		$behaviours['incidents']= array('count' => "$no_reportCnts", 'action_taken' => $action_taken);
		$behaviours['detailed_behaviour']= $detail_behaviours;
				
		$response = array('status'=>'1','message'=>'success','behaviour'=>$behaviours);
		echo json_encode($response);
	}
	
	function getAccessStudentHealth()
	{
	
		$student_id  = $this->input->post('student_id');		 
		  
		$response  = array();
		
		$healths_data = $this->db->order_by('updated_date', 'ASC')->get_where('health_reports', array('student_id' => $student_id))->result_array();
		
		$last_occurence_data = $this->db->order_by('updated_date', 'ASC')->get_where('health_last_occurence', array('student_id' => $student_id))->result_array();
		
		$concern_date = $action = $further_action = '';
		$healths =array();
		
		$last_occurrences = $known_allergiess  = array();
		 
		foreach ($healths_data as $row) {
			
			$known_allergies['id'] = $row['id'];
			$known_allergies['name'] =  $row['title'];
			$known_allergies['details'] = $row['details'];	
			$known_allergies['updated_date'] = $row['updated_date'];				 
			array_push($known_allergiess, $known_allergies);
		}
		
		foreach ($last_occurence_data as $row) {
			
			$last_occurrence['id'] = $row['id'];
			$last_occurrence['name'] =  $row['title'];
			$last_occurrence['details'] = $row['details'];	
			$last_occurrence['updated_date'] = $row['updated_date'];
			$last_occurrence['concern_date'] = $concern_date =  $row['concern_date'];
			$last_occurrence['action'] = $action = $row['action'];
			$last_occurrence['further_action'] = $further_action = $row['further_action'];			
		 
			array_push($last_occurrences, $last_occurrence);
		}		 
		 
		$healths['report_download_link']= $this->report($student_id,1);
		$healths['last_health_concern']= $concern_date;
		$healths['action_taken']= $action;
		$healths['further_action_needed']= $further_action;
		$healths['overall_health_report']= '';
		$healths['overall_health_ratting']= '0';
		$healths['last_occurrences']= $last_occurrences;	 
		$healths['known_allergies']= $known_allergiess;
				
		$response = array('status'=>'1','message'=>'success','health'=>$healths);
		echo json_encode($response);
	}
	
	function getNoticeboards($notice_id=0,$school_id,$date_from='',$date_to='',$status='')
	{
		if($notice_id > 0)
		{
			$noticeboards = $this->db->get_where('noticeboard', array('notice_id' => $notice_id))->result_array();
		}
		else
		{
						
			$this->db->select('*');			
			$this->db->from('noticeboard');			
			if($date_from !='' && $date_to !='')
				$this->db->where('date BETWEEN "'. date('Y-m-d', strtotime($date_from)). '" and "'. date('Y-m-d', strtotime($date_to)).'"');	
			
			if($status == 1) $this->db->where('date >= "'. date('Y-m-d'). '"');
			elseif($status == 0) $this->db->where('date < "'. date('Y-m-d'). '"');
			
			$this->db->where('school_id', $school_id);
						 					
			$query = $this->db->get();				 
			$noticeboards = $query->result_array();			 
		}
		
		$announcements  = array();
		
		$response = array('status'=>'1','message'=>'success','announcement'=>array());
		
		if(count($noticeboards) > 0){
			
			foreach ($noticeboards as $row) {			
				
				$announcement['id'] = $row['notice_id'];	
				$announcement['title'] = $row['notice_title'];
				$announcement['body'] = $row['notice'];				
				$announcement['type'] = $row['type'];
				$announcement['tags'] = $row['tags'];
				$announcement['date'] = $row['date'];
				$announcement['posted_by'] = $this->db->get_where('principal', array('principal_id' => $row['created_by']))->row()->name;
				$announcement['posted_on'] = $row['created_at'];
				$announcement['status'] = $row['status']; 
				
				array_push($announcements, $announcement);				
			}	
			
			$response = array('status'=>'1','message'=>'success','announcement'=>$announcements);
						 
		}
		return $response;
	}
	
	function getAccessAnnouncement()
	{		
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$status  = $this->input->post('status');
		$date_from  = $this->input->post('date_from');
		$date_to  = $this->input->post('date_to');
		
		if($role_id == 2)
			$school_id = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->school_id;
		elseif($role_id == 3)
			$school_id = $this->db->get_where('principal', array('principal_id' => $user_id))->row()->school_id;
		else
			$school_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->school_id;	
					 
		$response  = $this->getNoticeboards(0,$school_id,$date_from,$date_to,$status);		
		   
		echo json_encode($response);		
	}
	
	function getAccessSingleAnnouncement()
	{		
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$announcement_id  = $this->input->post('announcement_id');

		if($role_id == 2)
			$school_id = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->school_id;
		elseif($role_id == 3)
			$school_id = $this->db->get_where('principal', array('principal_id' => $user_id))->row()->school_id;
		else
			$school_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->school_id;	
		 
		$response  = $this->getNoticeboards($announcement_id,$school_id);		
		   
		echo json_encode($response);		
	}
	
	function getAccessStudentAttendance()
	{
		
		$student_id  = $this->input->post('student_id');
		 		 
		$response  = array();
		
		$attendance_data = $this->db->order_by('date', 'ASC')->get_where('attendance', array('student_id' => $student_id,'status' => 2))->result_array();
		
		$attendances  = $detailed_attendance = array();
		
		if(count($attendance_data) > 0){
			
			foreach ($attendance_data as $row) {			
								 
				$attendance['date'] = $last_missed_date = $row['date'];
				$attendance['period'] = $last_missed_time = $row['period'];
				$attendance['reason'] = $reason = $row['reason'];
				$attendance['subject_id'] = $row['subject_id'];
				$attendance['subject'] = $subject_missed = $this->db->get_where('subject', array('subject_id' => $row['subject_id']))->row()->name; 
				
				array_push($detailed_attendance, $attendance);				
			}

			$attendances['report_download_link']= $this->report($student_id,4);
			$attendances['last_missed_date'] = $last_missed_date;
			$attendances['last_missed_time'] = $last_missed_time;
			$attendances['subject_missed'] = $subject_missed;
			$attendances['reason'] = $reason;
			$attendances['overal_attendance_report'] = '';
			$attendances['overal_attendance_ratting'] = '0';
			$attendances['detailed_attendance'] = $detailed_attendance;
			 
		}
		else{
			
			$attendances['report_download_link']= '';
			$attendances['last_missed_date'] = '';
			$attendances['last_missed_time'] = '';
			$attendances['subject_missed'] = '';
			$attendances['reason'] = '';
			$attendances['overal_attendance_report'] = '';
			$attendances['overal_attendance_ratting'] = '0';
			$attendances['detailed_attendance'] = $detailed_attendance;
		}
		
		$response = array('status'=>'1','message'=>'success','attendance'=>$attendances);
		echo json_encode($response);
	}
	
	function getAccessStudentFees()
	{
		
		$student_id  = $this->input->post('student_id');
		 		 
		$response  = array();
		
		$invoices = $this->db->get_where('invoice', array('student_id' => $student_id))->result_array();
		
		$fees  = $detailed_fees = array();
		
		if(count($invoices) > 0){
			
			$tot_amount = $tot_paid = 0;
			foreach ($invoices as $row) {			
								
				$invoice['id'] = $row['invoice_id'];
				$invoice['title'] = $row['title'];
				$invoice['amount'] = $amount = $row['amount'];
				$amount_paid = $row['amount_paid'];
				$tot_paid = $tot_paid + $amount_paid;
				$tot_amount = $tot_amount + $amount;
				$invoice_contents = $this->db->get_where('invoice_content', array('invoice' => $row['term_id']))->result_array();
				
				$contents = array();
				
				foreach ($invoice_contents as $row2) {
					
					$content['id'] = $row2['id'];
					$content['title'] = $row2['name'];
					$content['amount'] = $row2['amount'];
					array_push($contents, $content);	
				}
				
				$invoice['content'] = $contents;	

				array_push($detailed_fees, $invoice);	
			}

			$balance = $tot_amount - $tot_paid;
			$fees['paid_amount'] = $tot_paid;
			$fees['balance'] = $balance;
			$fees['status'] = ($balance > 0)?"Pending":"Paid";			 
			$fees['detailed_fees'] = $detailed_fees;
			$fees['report_download_link']= $this->report($student_id,3);
			 
		}else{

			$fees['paid_amount'] = '';
			$fees['balance'] = '';
			$fees['status'] = '';			 
			$fees['detailed_fees'] = $detailed_fees;
			$fees['report_download_link']= '';
		}
		
		$response = array('status'=>'1','message'=>'success','fees'=>$fees);
		echo json_encode($response);
	}
	
	function getAccessStudentAssignmentList()
	{
		
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');
		 		 
		$response  = array();
		
		$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
        $class_id = $roll->class_id;
        $section_id = $roll->section_id;
		
		$assignments_data = $this->db->get_where('assignments', array('user_id' => $user_id, 'role_id' => $role_id, 'class_id' => $class_id, 'section_id' => $section_id))->result_array();
		
		$assignments  = $detailed_attendance = array();
		
		if(count($assignments_data) > 0){
			
			foreach ($assignments_data as $row) {							
								 
				$assignment['id'] = $row['assignment_id'];
				$assignment['name'] = $row['title'];
				$assignment['details'] = $row['description'];
				$assignment['given_date'] = $row['given_date'];
				$assignment['due_date'] = $row['due_date'];
				$assignment['subject_id'] = $row['subject_id'];
				$assignment['subject_name'] = $this->db->get_where('subject', array('subject_id' => $row['subject_id']))->row()->name;
				
				$submit_data = $this->db->get_where('assignment_submit', array('assignment' =>$row['assignment_id'],'student_id' => $student_id))->row(); 
				 
				$assignment['submit_on'] = (isset($submit_data->submit_on))?$submit_data->submit_on:'';
				$assignment['status'] = (isset($submit_data->status))?$submit_data->status:'0';
				$assignment['comment'] = (isset($submit_data->comment))?$submit_data->comment:'';			
				array_push($assignments, $assignment);				
			} 
			 
		}        
		
		$response = array('status'=>'1','message'=>'success','assignment'=>$assignments);
		echo json_encode($response);
	}
	
	function getUpdateStudentMark()
	{
		 
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');
		$exam_id  = $this->input->post('exam_id');
		$subject_id  = $this->input->post('subject_id');
		$marks  = $this->input->post('marks');
		$comments  = $this->input->post('comments');		
		 		 
		$response  = array();
		
		$mark_id = $this->db->get_where('mark', array('student_id' => $student_id,'exam_id' => $exam_id,'subject_id' => $subject_id))->row()->mark_id;
		
		$noti_arr['title'] = 'Update Marks';
		$noti_arr['content'] = 'Update Marks';
		$noti_arr['type'] = '2';
		$noti_arr['type_id'] = $mark_id;
		$noti_arr['student_id'] = $student_id;
		$noti_arr['creator_id'] = $user_id;
		$noti_arr['creator_role'] = $role_id;
		$noti_arr['created_on'] = date('Y-m-d h:i:s');
		
		if((int)$mark_id == 0){
			
			$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
			$class_id = $roll->class_id;
			$section_id = $roll->section_id;
		
			$data['student_id']  = $student_id;
			$data['exam_id']  = $exam_id;
			$data['class_id']  = $class_id;
			$data['section_id']  = $section_id;
			$data['subject_id']  = $subject_id;
			$data['mark_obtained']  = $marks;
			$data['comment']  = $comments;
			$this->db->insert('mark', $data);				
			$mark_id = $this->db->insert_id();
			
			$noti_arr['type_id'] = $mark_id;

			$this->db->insert('notifications', $noti_arr);	

		}
		else{
			
			$this->db->where('student_id', $student_id);
			$this->db->where('exam_id', $exam_id);
			$this->db->where('subject_id', $subject_id);
			$this->db->update('mark', array('mark_obtained' => $marks ,'comment' => $comments ));
		}
		
		$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;				
				
		$this->notificationAlert($parent_id,1,$noti_arr,'Update Marks');
		
		$response = array('status'=>'1','message'=>'success');
		echo json_encode($response);
	}
	
	function getAddUpdateAssignment()
	{
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');		
		$subject_id  = $this->input->post('subject_id');
		$assignment_id  = $this->input->post('assignment_id');
		$assignment_name  = $this->input->post('assignment_name');
		$assignment_details  = $this->input->post('assignment_details');
		$given_date  = $this->input->post('given_date');
		$due_date  = $this->input->post('due_date');
		
		
		$noti_arr['title'] = 'Update Assigment';
		$noti_arr['content'] = 'Update Assigment';
		$noti_arr['type'] = '3';
		$noti_arr['type_id'] = $assignment_id;
		$noti_arr['student_id'] = $student_id;
		$noti_arr['creator_id'] = $user_id;
		$noti_arr['creator_role'] = $role_id;
		$noti_arr['created_on'] = date('Y-m-d h:i:s');

				 		 
		$response  = array();		 
		
		if((int)$assignment_id == 0){
			
			$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
			$class_id = $roll->class_id;
			$section_id = $roll->section_id;
		
			$data['user_id']  = $user_id;
			$data['role_id']  = $role_id;			 
			$data['title']  = $assignment_name;
			$data['description']  = $assignment_details;
			$data['class_id']  = $class_id;
			$data['section_id']  = $section_id;
			$data['subject_id']  = $subject_id;
			$data['given_date']  = $given_date;
			$data['due_date']  = $due_date;
			$this->db->insert('assignments', $data);	
			$assignment = $this->db->insert_id();

			$sdata['student_id']  = $student_id;
			$sdata['assignment']  = $assignment;
			$sdata['status']  = '0';
			
			$this->db->insert('assignment_submit', $sdata);	
			
			$assignment_id = $this->db->insert_id();
			$noti_arr['type_id'] = $assignment_id;
			
			$this->db->insert('notifications', $noti_arr);	
				
		}
		else{
			
			$this->db->where('assignment_id', $assignment_id);
			$this->db->update('assignments', array('title' => $title ,'description' => $assignment_details,'given_date' => $given_date ,'due_date' => $due_date));
		}
		
		$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;				
				
		$this->notificationAlert($parent_id,1,$noti_arr,'Update Assigment');
		
		
		$response = array('status'=>'1','message'=>'success');
		echo json_encode($response);
	}
	
	function getSubmitAssignment()
	{
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');				 
		$assignment_id  = $this->input->post('assignment_id');		
		$date  = $this->input->post('date');			 
		$status  = $this->input->post('status');
		 		 
		$response  = array();		 
		
		if($assignment_id > 0){
			
			$id = $this->db->get_where('assignment_submit', array('assignment' => $assignment_id,'student_id' => $student_id))->row()->id;
			
			if((int)$id == 0){
			
				$data['assignment']  = $assignment_id;
				$data['student_id']  = $student_id;
				$data['status']  = $status;
				$data['submit_on']  = $date;
				$this->db->insert('assignment_submit', $data);	
			}else{
			
				$this->db->where('assignment', $assignment_id);
				$this->db->where('student_id', $student_id); 
				$this->db->update('assignment_submit', array('status' => $status,'submit_on' => $date ));
			}
		}		
		
		$response = array('status'=>'1','message'=>'success');
		echo json_encode($response);
	}	

	function getUpdateBehaviour()
	{		 	
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');                                                                                    
		$behaviours  = json_decode($this->input->post('behaviour'), true);		 	
		 	 
		$response = array('status'=>'0','message'=>'behaviour json missing ');		 
		
		if(count($behaviours) > 0 ){
			
			foreach($behaviours as $behaviour)
			{			 
			
				$rep_id = $this->db->get_where('behaviour_reports', array('student_id' => $student_id,'behaviour' => $behaviour['id']))->row()->id;
				
				$noti_arr['title'] = 'Update Behaviour';
				$noti_arr['content'] = 'Update Behaviour';
				$noti_arr['type'] = '4';
				$noti_arr['type_id'] = $rep_id;
				$noti_arr['student_id'] = $student_id;
				$noti_arr['creator_id'] = $user_id;
				$noti_arr['creator_role'] = $role_id;
				$noti_arr['created_on'] = date('Y-m-d h:i:s');
				
				if((int)$rep_id > 0){
					
					$this->db->where('student_id', $student_id);
					$this->db->where('behaviour', $behaviour['id']);					 
					$this->db->update('behaviour_reports', array('report' => $behaviour['report'] ,'action' => $behaviour['action']));
					
										
				}else{
				
					$data['user_id']  = $user_id;
					$data['role_id']  = $role_id;			 
					$data['student_id']  = $student_id;
					$data['behaviour']  = $behaviour['id'];
					$data['report']  = $behaviour['report'];
					$data['action']  = $behaviour['action'];		 
					$this->db->insert('behaviour_reports', $data);	
					$rep_id = $this->db->insert_id();	
					
					$noti_arr['type_id'] = $rep_id;
					$this->db->insert('notifications', $noti_arr);	
					
				}		
			}

			$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;				
				
			$this->notificationAlert($parent_id,1,$noti_arr,'Update Behaviour');

			$response = array('status'=>'1','message'=>'success');
		}		
		
		echo json_encode($response);
	}
	
	function getUpdateAttendance()
	{ 
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');		
		$date  = $this->input->post('date');
		$period  = $this->input->post('period');
		$subject_id  = $this->input->post('subject_id');
		$attendance  = $this->input->post('attendance');
		$reason  = $this->input->post('reason');
		 		 		 
		$response  = array();		 
		
		$attendance_id = $this->db->get_where('attendance', array('student_id' => $student_id,'date' => $date,'subject_id' => $subject_id,'period' => $period))->row()->attendance_id;
		
		$noti_arr['title'] = 'Update Attendance';
		$noti_arr['content'] = 'Update Attendance';
		$noti_arr['type'] = '6';
		$noti_arr['type_id'] = $attendance_id;
		$noti_arr['student_id'] = $student_id;
		$noti_arr['creator_id'] = $user_id;
		$noti_arr['creator_role'] = $role_id;
		$noti_arr['created_on'] = date('Y-m-d h:i:s');
		
		
		if((int)$attendance_id == 0){
			
			$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
			$class_id = $roll->class_id;
			$section_id = $roll->section_id;		
			
			$data['student_id']  = $student_id;
			$data['timestamp']  = strtotime($date);
			$data['date']  = $date;
			$data['period']  = $period;
			$data['class_id']  = $class_id;
			$data['section_id']  = $section_id;
			$data['subject_id']  = $subject_id;
			$data['status']  = $attendance;
			$data['reason']  = $reason;
			$this->db->insert('attendance', $data);	 	
			$attendance_id = $this->db->insert_id();	
			$noti_arr['type_id'] = $attendance_id;
			$this->db->insert('notifications', $noti_arr);	
			
		}
		else{
			
			$this->db->where('student_id', $student_id);
			$this->db->where('date', $date);
			$this->db->where('subject_id', $subject_id);
			$this->db->where('period', $period);
			$this->db->update('attendance', array('status' => $attendance ,'reason' => $reason));
		}
		
		
		$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;				
				
		$this->notificationAlert($parent_id,1,$noti_arr,'Update Attendance');
		
		
		$response = array('status'=>'1','message'=>'success');
		echo json_encode($response);
	}
	
	function getAccessParentDetails()
	{
	
		$user_id      = $this->input->post('user_id');
		$role_id      = $this->input->post('role_id');
		  
		$response = $students = array();
				
		$student_profile = $this->db->get_where('student', array('parent_id' => $user_id))->result_array();
		
        foreach ($student_profile as $row) {
			
			$student = array();
			
            $student['id']  = $student_id = $row['student_id'];
			$student['admission_number'] = $row['student_code'];
            $student['first_name'] = $row['name'];
			$student['middle_name'] = $row['middle_name'];
			$student['last_name'] = $row['last_name'];
			$student['image'] = $this->crud_model->get_image_url('student', $student_id);
			$student['level'] = '';			
            $student['DOB'] = $row['birthday'];
			$seat = (int)$this->db->get_where('class_layout_places', array('student_id' => $student_id))->row()->position;
			$behaviour = $this->getBehaviourRatting($row['student_id']);
            $student['seat'] = "$seat";
            $student['avg_grade'] = '';
            $student['avg_position'] = '';
            $student['overall_behaviour'] = $behaviour['report'];
            $student['behaviour_ratting'] = $behaviour['ratting'];	                  
       		
			$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
			$class_id = $roll->class_id;
			$section_id = $roll->section_id;
			$section = $this->db->get_where('section', array('section_id' => $section_id))->row();
			$section_name = $section->name;
			$total_seat = $section->total_seat;
			$divides = $section->divides;
			$columns = $section->columns;
			$class = $this->db->get_where('class', array('class_id' => $class_id))->row();
			$class_name = $class->name;			 
			$school_id = $class->school_id;
		
			$school_data = $this->db->get_where('school', array('school_id' => $school_id))->row();
			$school['school_id'] = $school_data->school_id;
			$school['school_name'] = $school_data->school_name;
			$school['school_logo'] = $this->crud_model->get_image_url('school',$school['school_id']);		
			$student['school_details'] = $school;
		
			$class_details['class_id'] = $class_id;
			$class_details['class_name'] = $class_name;
			$class_details['section_id'] = $section_id;
			$class_details['section_name'] = $section_name;
			$class_details['total_seat'] = $total_seat;
			$class_details['divides'] = $divides;
			$class_details['column'] = $columns;
			$class_details['level'] = '';
		
			$student['class_details'] = $class_details;		
		
			$student['class_teacher'] = $this->getClassTeacher($class_id,$section_id); 
		
			$student['subject_teachers'] = $this->getSubjectTeacher($class_id,$section_id); 

			array_push($students, $student);

		}
		
		$response = array('status'=>'1','message'=>'success','students'=>$students);
		echo json_encode($response);
	}
	
	function getCreateGroup()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$classId  = $this->input->post('classId');
		$sectionId  = $this->input->post('sectionId');
		$subjectId  = $this->input->post('subjectId');
		$group_name  = $this->input->post('group_name');
		$students  = $this->input->post('students');
		
		if($role_id	== 2)	
			$query = $this->db->get_where('teacher', array('teacher_id' => $user_id));
		elseif($role_id	== 3)	
			$query = $this->db->get_where('principal', array('principal_id' => $user_id));
		
		$cnt = $query->num_rows();			
		 
		$response = array('status'=>'0','message'=>'no data', 'group' =>array());
		
		if($cnt > 0 ){		
					
			$data['user_id']  = $user_id;
			$data['role_id']  = $role_id;
			$data['class_id']  = $classId;
			$data['section_id']  = $sectionId;
			$data['subject_id']  = $subjectId;
			$data['group_name']  = $group_name;
			$data['students']  = $students;
			$data['created_on']  = date('Y-m-d h:i:s');
			 
			$this->db->insert('groups', $data);	 			
		
			$response = $this->getGroupslist($user_id,$role_id);			
		}
		
		echo json_encode($response);
	}
	
	function getUploadMedia()
    { 	          
        $user_id = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
        $title   = $this->input->post('title');
		$details   = $this->input->post('details');
		$path   = $this->input->post('path');
		$type_id   = $this->input->post('type_id');
		$type_name   = $this->input->post('type_name');
		$class_id   = $this->input->post('class_id');
		$section_id   = $this->input->post('section_id');
						
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){		
					
			$data['user_id']  = $user_id;
			$data['role_id']  = $role_id;
			$data['class_id']  = $class_id;
			$data['section_id']  = $section_id;			
			$data['type_id']  = $type_id;
			$data['type_name']  = $type_name;
			$data['title']  = $title;
			$data['details']  = $details;
			$data['created_on']  = date('Y-m-d h:i:s');
			
			if($_FILES['attachment']['name'] !=''){
				
				$timestamp = strtotime(date("Y-m-d H:i:s"));
				
				$directory = "uploads/media/$timestamp"."-$user_id". $_FILES['attachment']['name'];		
				move_uploaded_file($_FILES['attachment']['tmp_name'], $directory);
				$data['file_name']  = $_FILES['attachment']['name'];
				$data['path']  = 'http://shamlatech.net/school/'.$directory;
			}
			 
			$this->db->insert('media', $data);	 	
			$media_id = $this->db->insert_id();	
			
			
			$noti_arr['creator_id'] = $user_id;
			$noti_arr['creator_role'] = $role_id;
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			if($type_id == 1){
				$noti_arr['title'] = 'Add Document';
				$noti_arr['content'] = 'Add Document';
				$noti_arr['type'] = '8';			
				$noti_arr['type_id'] = $media_id;
			}
			elseif($type_id == 2){
				$noti_arr['title'] = 'Add Photo';
				$noti_arr['content'] = 'Add Photo';
				$noti_arr['type'] = '9';			
				$noti_arr['type_id'] = $media_id;
			}
			elseif($type_id == 3){
				$noti_arr['title'] = 'Add Video';
				$noti_arr['content'] = 'Add Video';
				$noti_arr['type'] = '10';			
				$noti_arr['type_id'] = $media_id;
			}
			
			$students = $this->db->get_where('enroll', array('class_id' => $data['class_id'],'section_id' => $data['section_id']))->result_array();
			
			foreach ($students as $row) {
				$noti_arr['student_id'] = $student_id = $row['student_id'];			
				$this->db->insert('notifications', $noti_arr);	
				$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;				
				
				$this->notificationAlert($parent_id,1,$noti_arr,$noti_arr['title']);
			}			
			
			$response = array('status'=>'1','message'=>'success');			 		
		}		 
        
		echo json_encode($response);
    }
	
	function getAddAllergyList()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');
		$title  = $this->input->post('name');
		$details  = $this->input->post('details'); 
		
		$noti_arr['title'] = 'Update Health occurence';
		$noti_arr['content'] = 'Update Health occurence';
		$noti_arr['type'] = '5';
		$noti_arr['type_id'] = '';
		$noti_arr['student_id'] = $student_id;
		$noti_arr['creator_id'] = $user_id;
		$noti_arr['creator_role'] = $role_id;
		$noti_arr['created_on'] = date('Y-m-d h:i:s');
		
		$response = array('status'=>'0','message'=>'student id missing');
		
		if($student_id > 0 ){		
					
			$data['user_id']  = $user_id;
			$data['role_id']  = $role_id;
			$data['student_id']  = $student_id;
			$data['title']  = $title;
			$data['details']  = $details;				
			$data['updated_date']  = date('Y-m-d h:i:s');
			 
			$this->db->insert('health_reports', $data);	
			$rep_id = $this->db->insert_id();	

			$noti_arr['type_id'] = $rep_id;
		
			$response = $this->getHealthList($student_id);		
				
			$this->db->insert('notifications', $noti_arr);		
			
			$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;				
				
			$this->notificationAlert($parent_id,1,$noti_arr,'Update Health occurence');
			
		}
		
		echo json_encode($response);
	}
	
	function getUpdateLastHealthOccurrence()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');
		$date  = $this->input->post('date');
		$occurrence  = $this->input->post('occurrence'); 
		$action  = $this->input->post('action'); 
		$further_action = $this->input->post('further_action'); 
		
		$noti_arr['title'] = 'Update Health occurence';
		$noti_arr['content'] = 'Update Health occurence';
		$noti_arr['type'] = '5';
		$noti_arr['type_id'] = '';
		$noti_arr['student_id'] = $student_id;
		$noti_arr['creator_id'] = $user_id;
		$noti_arr['creator_role'] = $role_id;
		$noti_arr['created_on'] = date('Y-m-d h:i:s');
		
		$response = array('status'=>'0','message'=>'student id missing');
		
		if($student_id > 0 ){		
					
			$data['user_id']  = $user_id;
			$data['role_id']  = $role_id;
			$data['student_id']  = $student_id;
			$data['title']  = $occurrence;
			$data['concern_date']  = $date;		
			$data['action']  = $action;	
			$data['further_action']  = $further_action;	
			$data['updated_date']  = date('Y-m-d h:i:s');
			 
			$this->db->insert('health_last_occurence', $data);	
			$rep_id = $this->db->insert_id();	

			$noti_arr['type_id'] = $rep_id;
		
			$response = $this->getHealthLastOccurenceList($student_id);		
				
			$this->db->insert('notifications', $noti_arr);		
			
			$parent_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;								
			$this->notificationAlert($parent_id,1,$noti_arr,'Update Health occurence');
			
		}
		
		echo json_encode($response);
	}
	
	function getSendFeedback()
	{ 
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$feedback  = $this->input->post('feedback');			 
		 		 		 
		$response = array('status'=>'0','message'=>'user id missing');	 
				 		
		if($user_id > 0){			 
			
			switch($role_id){
			
				case 1:
				
					$this->db->where('parent_id', $user_id);			
					$this->db->update('parent', array('feedback' => $feedback));
				
				break;				
				case 2:
				
					$this->db->where('teacher_id', $user_id);			
					$this->db->update('teacher', array('feedback' => $feedback));
				
				break;					
				default:
				break;				
			}
		}
		
		$response = array('status'=>'1','message'=>'success');
		echo json_encode($response);
	}
	
	function getAccessSchoolEvents()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		 		
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){		
		
			if($role_id == 2)
				$school_id = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->school_id;
			elseif($role_id == 3)
				$school_id = $this->db->get_where('principal', array('principal_id' => $user_id))->row()->school_id;
			else
				$school_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->school_id;
					
			$events_data = $this->db->get_where('events', array('school_id' => $school_id))->result_array();
		
			$events = array();
			
			$response = array('status'=>'1','message'=>'no data', 'events' => array());
		
			if(count($events_data) > 0){
					
				foreach ($events_data as $row) {
					
					$event['id'] = $row['id'];
					$event['title'] = $row['title'];
					$event['details'] = $row['details'];
					$event['date'] = $row['date'];
					array_push($events,$event);
				}
				
				$response = array('status'=>'1','message'=>'success','events'=>$events);
			}			
		}
		
		echo json_encode($response);
	}
	
	function getAccessDocuments()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$last_id  = $this->input->post('last_id');
		 		
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){							
			
			if($role_id == 1){
				
				$student_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->student_id;
			
				$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
				$class_id = $roll->class_id;
				$section_id = $roll->section_id;
				
				if($last_id > 0){ 
				
					$media_data = $this->db->get_where('media', array('id >' => $last_id,'type_id' => 1,'class_id' => $class_id,'section_id' => $section_id),0,20)->result_array();
					
				}else{
				
					$media_data = $this->db->order_by('id', 'DESC')->get_where('media', array('type_id' => 1,'class_id' => $class_id,'section_id' => $section_id),0,20)->result_array();
					
				}
				
			}else{			
			
			
				if($last_id > 0){ 
				
					$media_data = $this->db->get_where('media', array('id >' => $last_id,'type_id' => 1,'user_id' => $user_id,'role_id' => $role_id),0,20)->result_array();
					
				}else{
				
					$media_data = $this->db->order_by('id', 'DESC')->get_where('media', array('type_id' => 1,'user_id' => $user_id,'role_id' => $role_id),0,20)->result_array();
					
				}				
				 
			}
		
			$medias = array();
			
			$response = array('status'=>'1','message'=>'no data', 'document' => array());
		
			if(count($media_data) > 0){
					
				foreach ($media_data as $row) {
					
					$media['id'] = $row['id'];
					$media['title'] = $row['title'];
					$media['details'] = $row['details'];
					$media['file_name'] = $row['file_name'];
					$media['url'] = $row['path'];
					$media['date_time'] = $row['created_on'];
					$media['uploader_id'] = $row['user_id'];
					$media['uploader_name'] = ($role_id == 2)?$this->db->get_where('teacher', array('teacher_id' => $row['user_id']))->row()->name:$this->db->get_where('principal', array('principal_id' => $row['user_id']))->row()->name;
					$media['class_id'] = $row['class_id'];
					$media['class_name'] = $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;
					$media['section_id'] = $row['section_id'];
					$media['section_name'] = $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;
					$media['visible'] = $row['status'];
					
					array_push($medias,$media);
				}
				
				$response = array('status'=>'1','message'=>'success','document'=>$medias);
			}			
		}
		
		echo json_encode($response);
	}
	
	function getAccessPhotos()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$last_id  = $this->input->post('last_id');
		 		
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){				
			 			
			if($role_id == 1){
				
				$student_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->student_id;
			
				$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
				$class_id = $roll->class_id;
				$section_id = $roll->section_id;
				
				if($last_id > 0){ 
				
					$media_data = $this->db->get_where('media', array('id >' => $last_id,'type_id' => 2,'class_id' => $class_id,'section_id' => $section_id),0,20)->result_array();
					
				}else{
				
					$media_data = $this->db->order_by('id', 'DESC')->get_where('media', array('type_id' => 2,'class_id' => $class_id,'section_id' => $section_id),0,20)->result_array();
					
				}
				
			}else{			
			
			
				if($last_id > 0){ 
				
					$media_data = $this->db->get_where('media', array('id >' => $last_id,'type_id' => 2,'user_id' => $user_id,'role_id' => $role_id),0,20)->result_array();
					
				}else{
				
					$media_data = $this->db->order_by('id', 'DESC')->get_where('media', array('type_id' => 2,'user_id' => $user_id,'role_id' => $role_id),0,20)->result_array();
					
				}				
				 
			}
		
			$medias = array();
			
			$response = array('status'=>'1','message'=>'no data', 'image' => array());
		
			if(count($media_data) > 0){
					
				foreach ($media_data as $row) {
					
					$media['id'] = $row['id'];
					$media['title'] = $row['title'];
					$media['details'] = $row['details'];
					$media['file_name'] = $row['file_name'];
					$media['thumb'] = $row['path'];
					$media['url'] = $row['path'];
					$media['date_time'] = $row['created_on'];
					$media['uploader_id'] = $row['user_id'];
					$media['uploader_name'] = ($role_id == 2)?$this->db->get_where('teacher', array('teacher_id' => $row['user_id']))->row()->name:$this->db->get_where('principal', array('principal_id' => $row['user_id']))->row()->name;			
					$media['class_id'] = $row['class_id'];
					$media['class_name'] = $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;
					$media['section_id'] = $row['section_id'];
					$media['section_name'] = $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;
					$media['visible'] = $row['status'];
					
					array_push($medias,$media);
				}
				
				$response = array('status'=>'1','message'=>'success','image'=>$medias);
			}			
		}
		
		echo json_encode($response);
	}
	
	function getAccessVideos()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$last_id  = $this->input->post('last_id');
		 		
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){				
			 			
			if($role_id == 1){
				
				$student_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->student_id;
			
				$roll = $this->db->get_where('enroll', array('student_id' => $student_id))->row();		
				$class_id = $roll->class_id;
				$section_id = $roll->section_id;
				
				if($last_id > 0){ 
				
					$media_data = $this->db->get_where('media', array('id >' => $last_id,'type_id' => 3,'class_id' => $class_id,'section_id' => $section_id),0,20)->result_array();
					
				}else{
				
					$media_data = $this->db->order_by('id', 'DESC')->get_where('media', array('type_id' => 3,'class_id' => $class_id,'section_id' => $section_id),0,20)->result_array();
					
				}
				
			}else{			
			
			
				if($last_id > 0){ 
				
					$media_data = $this->db->get_where('media', array('id >' => $last_id,'type_id' => 3,'user_id' => $user_id,'role_id' => $role_id),0,20)->result_array();
					
				}else{
				
					$media_data = $this->db->order_by('id', 'DESC')->get_where('media', array('type_id' => 3,'user_id' => $user_id,'role_id' => $role_id),0,20)->result_array();
					
				}				
				 
			}
		
			$medias = array();
			
			$response = array('status'=>'1','message'=>'no data', 'video' => array());
		
			if(count($media_data) > 0){
					
				foreach ($media_data as $row) {
					
					$media['id'] = $row['id'];
					$media['title'] = $row['title'];
					$media['details'] = $row['details'];
					$media['file_name'] = $row['file_name'];
					$media['url'] = $row['path'];
					$media['thumb'] = 'http://shamlatech.net/school/uploads/media/video-thumb.jpg';
					$media['date_time'] = $row['created_on'];
					$media['uploader_id'] = $row['user_id'];
					$media['uploader_name'] = ($role_id == 2)?$this->db->get_where('teacher', array('teacher_id' => $row['user_id']))->row()->name:$this->db->get_where('principal', array('principal_id' => $row['user_id']))->row()->name;			
					$media['class_id'] = $row['class_id'];
					$media['class_name'] = $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;
					$media['section_id'] = $row['section_id'];
					$media['section_name'] = $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;
					$media['visible'] = $row['status'];
					
					array_push($medias,$media);
				}
				
				$response = array('status'=>'1','message'=>'success','video'=>$medias);
			}			
		}
		
		echo json_encode($response);
	}
	
	function getRemoveDocument()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$id  = $this->input->post('id');
		 		
		$response = array('status'=>'0','message'=>'id missing');
		
		if($id > 0 ){		

			$data = array('id' => $id);		
			$this->db->delete('media', $data);

			$response = array('status'=>'1','message'=>'success');
		}
		
		echo json_encode($response);
		
	}
	
	function getUpdateNotifications()
	{ 
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$sound  = $this->input->post('sound');		
		$vibrate  = $this->input->post('vibrate');	
		$dnd  = $this->input->post('dnd');	
		 		 		 
		$response = array('status'=>'0','message'=>'user id missing');	 
				 		
		if($user_id > 0){			 
			
			switch($role_id){
			
				case 1:
				
					$this->db->where('parent_id', $user_id);			
					$this->db->update('parent', array('sound' => $sound,'vibrate' => $vibrate,'dnd' => $dnd));
				
				break;				
				case 2:
				
					$this->db->where('teacher_id', $user_id);			
					$this->db->update('teacher', array('sound' => $sound,'vibrate' => $vibrate,'dnd' => $dnd));
				
				break;	
				case 3:
				
					$this->db->where('principal_id', $user_id);			
					$this->db->update('principal', array('sound' => $sound,'vibrate' => $vibrate,'dnd' => $dnd));
				
				break;
				default:
				break;				
			}
			
			echo $user_info = $this->getUserDetails($user_id,$role_id);	
			die;
		}
		
		$response = array('status'=>'1','message'=>'success');
		echo json_encode($response);
	}
	
	function getAccessAllergyList()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');		
		
		$response = array('status'=>'0','message'=>'student id missing');
		
		if($student_id > 0 ){			 		
		
			$response = $this->getHealthList($student_id);			
		}
		
		echo json_encode($response);
	}
	
	function getRemoveAllergyList()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');
		$id  = $this->input->post('id');
		
		$response = array('status'=>'0','message'=>'id missing');
		
		if($id > 0 ){			

			$data = array('id' => $id);		
			$this->db->delete('health_reports', $data);
		
			$response = $this->getHealthList($student_id);			
		}
		
		echo json_encode($response);
	}
	
	function getRemoveGroup()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$group_id  = $this->input->post('group_id');		 
		
		$response = array('status'=>'0','message'=>'group id missing');
		
		if($group_id > 0 ){			

			$data = array('id' => $group_id);		
			$this->db->delete('groups', $data);		
				
			$response = array('status'=>'1','message'=>'success');
		}
		
		echo json_encode($response);
	}
	
	function getSendMessage()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');	
		$to  = $this->input->post('to');
		$sender  = $this->input->post('sender');
		$receiver  = $this->input->post('receiver');
		$message  = $this->input->post('message');
		
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){		
			
			$query = "select id from msgchat where ((sender like '$receiver' AND receiver like '$sender') OR (sender like '$sender' AND receiver like '$receiver'))";
		 				
			$msgchat_id = $this->db->query($query)->row()->id;
			
			if((int)$msgchat_id == 0){
		
				$data['user_id']  = $user_id;
				$data['role_id']  = $role_id;
				$data['send_to']  = $to;
				$data['sender']  = $sender;	
				$data['receiver']  = $receiver;				 
				$this->db->insert('msgchat', $data);				
				$msgchat_id = $this->db->insert_id();
			}
			
			$student_id = 0;
			
			if($role_id == 1) $student_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->student_id;	
			 
			$receiver = explode('_',$receiver);
			
			$noti_arr['title'] = 'MESSAGE';
			$noti_arr['content'] = 'MESSAGE';
			$noti_arr['type'] = '16';
			$noti_arr['type_id'] = $msgchat_id;
			$noti_arr['student_id'] = $student_id;
			$noti_arr['receiver_id'] = $receiver[0];
			$noti_arr['receiver_role'] = $receiver[1];
			$noti_arr['creator_id'] = $user_id;
			$noti_arr['creator_role'] = $role_id;
			$noti_arr['created_on'] = date('Y-m-d h:i:s');

			$this->db->insert('notifications', $noti_arr);	
			
			$noti_arr['sender_id']  = $user_id;
			$noti_arr['sender_role']  = $role_id;
			
			
			if($role_id == 1){ 
				$name = $this->db->get_where('parent' , array('parent_id' => $user_id))->row()->name; 
				$image = $this->crud_model->get_image_url('parent', $user_id); 
			}
			elseif($role_id == 2){
				$name = $this->db->get_where('teacher' , array('teacher_id' => $user_id))->row()->name; 
				$image = $this->crud_model->get_image_url('teacher', $user_id); 
			}
			elseif($role_id == 3){ 
				$name = $this->db->get_where('principal' , array('principal_id' => $user_id))->row()->name; 
				$image = $this->crud_model->get_image_url('principal', $user_id); 
			}
			
			$noti_arr['sender_name']  = $name;
			$noti_arr['sender_image']  = $image;
 							
			$this->notificationAlert($receiver[0],$receiver[1],$noti_arr,$noti_arr['title']);
							
			$response = $this->getMessageList($user_id,$role_id);		 
						
		}
		
		echo json_encode($response);
	}
	
	function getAccessMessageList()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');			 
		
		$response = array('status'=>'0','message'=>'user id missing');
		
		if($user_id > 0 ){						 	
				
			$response = $this->getMessageList($user_id,$role_id);			 
		}
		
		echo json_encode($response);
	}
	
	function getUpdateClassLayout()
	{		 	
		$user_id  = $this->input->post('user_id');
		$role_id  = $this->input->post('role_id');
		$class_id  = $this->input->post('class_id');
		$section_id  = $this->input->post('section_id');
			
		$places  = json_decode($this->input->post('place'), true);		 	
		 
		$response = array('status'=>'0','message'=>'place json missing ','my_class'=>array());		 
		
		if(count($places) > 0 ){
			
			$query = $this->db->get_where('class_layouts', array('class_id' => $class_id,'section_id' => $section_id));			
			$cnt = $query->num_rows();
			
			if($cnt == 0){
				 
				$data['user_id']  = $user_id;	
				$data['role_id']  = $role_id;	
				$data['class_id']  = $class_id;
				$data['section_id']  = $section_id;			 			 	 
				$this->db->insert('class_layouts', $data);	
				$layout_id = $this->db->insert_id();
				
			}else{
				$row = $query->row();
				$layout_id = $row->id;
			}
			
			$data = array('layout_id' => $layout_id);		
			$this->db->delete('class_layout_places', $data);
			
			foreach($places as $place)
			{			 
				$data = array();
				$data['layout_id']  = $layout_id;				 	 
				$data['student_id']  = $place['id'];
				$data['position']  = $place['position'];
				$data['status']  = $place['status'];				 	 
				$this->db->insert('class_layout_places', $data);	
			}	
			
			$myclass = $this->getMyClass($user_id,$role_id);

			$response = array('status'=>'1','message'=>'success','my_class'=>$myclass);
		}		
		
		echo json_encode($response);
	}
	
	function notificationAlert($user_id,$role_id,$data_arr,$message)
	{ 	
	
		if($role_id == 1){
			$parent = $this->db->get_where('parent' , array('parent_id'=>$user_id))->row();
			$n_sound = $parent->sound;
			$n_vibrate = $parent->vibrate;	
		}
		elseif($role_id == 2){
			$teacher = $this->db->get_where('teacher' , array('teacher_id'=>$user_id))->row();
			$n_sound = $teacher->sound;
			$n_vibrate = $teacher->vibrate;	
		}
		elseif($role_id == 3){
			$principal = $this->db->get_where('principal' , array('principal_id'=>$user_id))->row();
			$n_sound = $principal->sound;
			$n_vibrate = $principal->vibrate;	
		}

		$notification = $this->db->get_where('notifications' , array('id'=>$id))->row();
		
		$data_arr['user_id'] = $user_id;
		$data_arr['role_id'] = $role_id;
		$data_arr['n_sound'] = $n_sound;
		$data_arr['n_vibrate'] = $n_vibrate;
		
		$this->sendnotifications($user_id,$role_id,$data_arr,$message); 
	}
	
	function sendnotifications($id,$role_id, $data, $message)
	{
		
		if($id >0){
		$notification = array('title' =>"ClassTeacher" , 'text' => "$message");

		$sendnotifi_token = $this->db->query("SELECT token FROM user_token where user_id = $id  AND role_id =$role_id ");
		$notifi_userlist = $sendnotifi_token->result_array();  
		$Tokens = array();
		for($i=0; $i<count($notifi_userlist); $i++)
		{
			$Tokens[] = $notifi_userlist[$i]['token'];
		if(($i%500==0 || $i==(count($notifi_userlist)-1)))
		{
			$url = 'https://fcm.googleapis.com/fcm/send';
						
					$fields = array();
					$fields['notification'] = $notification;
					$fields['data'] = $data;
					if(is_array($Tokens)){
						$fields['registration_ids'] = $Tokens;
					}else{
						$fields['to'] = $Tokens;
					}
					
					$headers = array();
					$headers[] = 'Content-Type: application/json';
					$headers[] = 'Authorization: key= AAAA2uDNoFI:APA91bEob-tA-TsIxh846TtgotHSUF0QuEBd8O1A-NnlnB6dPwvnuPe1yVCOTi5Cl1Od8kmiDG3qM05Rj7J6KZBQ4Ine06NeF00K15YuYjujTaXMrubJUsTuaqc1f8JkVpkL_2pGuhdk'; // key here

				
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);  
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // IOS fixes
					$result = curl_exec($ch);
					if ($result === FALSE) {
						die('FCM Send Error: ' . curl_error($ch));
					}
					curl_close($ch);

				//return($ch);
				$Tokens = array();
			}
		}
		}
	}
	
	function getAccessNotification()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');		 		
		
		$response = array('status'=>'0','message'=>'user missing');
		
		if($user_id > 0 ){			 				
		
			if($role_id == 1){
				
				$student_id = $this->db->get_where('student', array('parent_id' => $user_id))->row()->student_id;
				
				$notification_data = $this->db->get_where('notifications', array('student_id' => $student_id))->result_array();
				
			}
			else{
				
				$notification_data = $this->db->get_where('notifications', array('receiver_id' => $user_id,'receiver_role' => $role_id))->result_array();
			}
			$notifications = array();
			
			$response = array('status'=>'1','message'=>'no data','notification_list'=>array());
			
			if(count($notification_data) > 0){
					
				foreach ($notification_data as $row) {
					
					$notification['id'] = $row['id'];
					$notification['title'] = $row['title'];
					$notification['content'] = $row['content'];
					$notification['type'] = $row['type'];
					$notification['type_id'] = $row['type_id'];
					$notification['student_id'] = $row['student_id'];
					$notification['datetime'] = $row['created_on'];
					$notification['is_read'] = $row['is_read'];
					array_push($notifications,$notification);
				}
				
				$response = array('status'=>'1','message'=>'success','notification_list'=>$notifications);
			}			
		}
		
		echo json_encode($response);
	}
	
	function getRemoveNotification()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');		 
		$id  = $this->input->post('id');
		
		$response = array('status'=>'0','message'=>'id missing');
		
		if($id > 0 ){			

			$data = array('id' => $id);		
			$this->db->delete('notifications', $data);
		
			$response = array('status'=>'1','message'=>'success');		
		}
		
		echo json_encode($response);
	}
	
	function getReadNotification()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');		 
		$id  = $this->input->post('id');
		
		$response = array('status'=>'0','message'=>'id missing');
		
		if($id > 0 ){			

			$this->db->where('id', $id);
			$this->db->update('notifications', array('is_read' => '1'));
		
			$response = array('status'=>'1','message'=>'success');		
		}
		
		echo json_encode($response);
	}
	
	function getForumsList()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');		 
		$type  = $this->input->post('type'); 
		$status  = $this->input->post('status'); 
		$last_id  = $this->input->post('last_id'); 
		
		$response = array('status'=>'0','message'=>'type missing');
		
		if($type > 0 ){			 			
		
			$response = $this->getForumsListComments(0,0,$user_id,$role_id,$student_id,$type,$status,$last_id);			
		}
		
		echo json_encode($response);
	}
	
	function getAccessSingleForum()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$forum_id  = $this->input->post('forum_id');		 
		 
		$response = array('status'=>'0','message'=>'forum id missing');
		
		if($forum_id > 0 ){			 			
		
			$response = $this->getForumsListComments($forum_id,1,$user_id,$role_id);			
		}
		
		echo json_encode($response);
	}
	
	function getCreateForumsList()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$student_id  = $this->input->post('student_id');
		$topic  = $this->input->post('topic');
		$from  = $this->input->post('from'); 
		$to  = $this->input->post('to'); 
		$type  = $this->input->post('type'); 
		$class_id  = $this->input->post('class_id'); 
		$section_id  = $this->input->post('section_id'); 
		
		$response = array('status'=>'0','message'=>'student id missing');
		
		if($type > 0 ){		
					
					
			if($role_id == 2){ 		
				$school_id = $this->db->get_where('teacher', array('teacher_id' => $user_id))->row()->school_id;
				$principal_id = $this->db->get_where('principal', array('school_id' => $school_id))->row()->principal_id;
			}
			elseif($role_id == 3){
				$school_id = $this->db->get_where('principal', array('principal_id' => $user_id))->row()->school_id;
				$principal_id = $user_id;
			}				
			
			$memberdata[] = '"principal_'.$principal_id.'"';			
			
			if($to == 1) 
			{
				$membersdata = $this->db->get_where('student', array('school_id' => $school_id))->result_array();
				
				if(count($membersdata) > 0){
				
					foreach($membersdata as $member){				 
						
						$memberdata[] = '"parent_'.$member['parent_id'].'"';
						
					}
					
				}
			}
			else
			{
				$membersdata = $this->db->get_where('teacher', array('school_id' => $school_id))->result_array();
				
				if(count($membersdata) > 0){					
					
					foreach($membersdata as $member){
						
						$memberdata[] = $teacher_id = '"teacher_'.$member['teacher_id'].'"';
					 							
					}
					
				}
			}

			$memberdata = implode(',',$memberdata);
			
			$members="[$memberdata]";  
			 
			$data['sender_id']  = $user_id;
			$data['sender_role']  = $role_id;
			$data['group_message_thread_code'] = substr(md5(rand(100000000, 20000000000)), 0, 15);
			$data['group_name']  = $topic;
			$data['members']  = $members;
			$data['type']  = $type;
			$data['send_from']  = $role_id;	
			$data['send_to']  = $to;			 
			$data['class_id']  = $class_id;
			$data['section_id']  = $section_id;
			$data['school_id']  = $school_id;
			$data['posted_id']  = $user_id;
			$data['posted_on']  = date('Y-m-d h:i:s');
			 
			$this->db->insert('group_message_thread', $data);
			$forum_id = $this->db->insert_id();		

			$noti_arr['creator_id'] = $user_id;
			$noti_arr['creator_role'] = $role_id;
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
								
			$userdata = explode(',',$memberdata);
			
			
			$i = $j=0; 
			foreach($userdata as $v){
				
				$user = explode('_',$v);
				$role = $user[0];
				$role = str_replace('"','',$role);
				$uid = str_replace('"','',$user[1]);
				
				if($role == 'parent'){					
					 
					$parent_id = $uid;
					$student_id = $this->db->get_where('student', array('parent_id' => $parent_id))->row()->student_id;	
			
					$noti_arr['title'] = 'Create Forum Teacher to Parent';
					$noti_arr['content'] = 'Create Forum Teacher to Parent';				
					$noti_arr['type'] = '12';	
					$noti_arr['type_id'] = $forum_id;	
					$noti_arr['student_id'] = $student_id;										
											
					$this->notificationAlert($parent_id,1,$noti_arr,$noti_arr['title']);
				
					if($i == 0) $this->db->insert('notifications', $noti_arr);	
					
					$i=1;
				}
				else{ 
					
					$noti_arr['title'] = 'Create Forum Teacher to Teacher';
					$noti_arr['content'] = 'Create Forum Teacher to Teacher';				
					$noti_arr['type'] = '11';			
					$noti_arr['type_id'] = $forum_id;	
					$noti_arr['student_id'] = 0;
					$noti_arr['receiver_id'] = $uid;
					$noti_arr['receiver_role'] = ($role == 'principal')?'3':'2';
					
					if($role == 'principal') 			
						$this->notificationAlert($uid,3,$noti_arr,$noti_arr['title']);
					else
						$this->notificationAlert($uid,2,$noti_arr,$noti_arr['title']);
					
					$this->db->insert('notifications', $noti_arr);	
									
				} 			
				
			}
				
			$response = $this->getForumsListComments($forum_id,1,$user_id,$role_id);
				
		}
		
		echo json_encode($response);
	}
	
	function getReplyForum()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');
		$forum_id  = $this->input->post('forum_id');
		$comment  = $this->input->post('comment');		 
		
		$response = array('status'=>'0','message'=>'forum id missing');
		
		if($forum_id > 0 ){							
			 
			if($role_id == 2) $login_type = 'teacher';
			elseif($role_id == 3) $login_type = 'principal';
			elseif($role_id == 1) $login_type = 'parent';
			 			
			$thread_code = $this->db->get_where('group_message_thread', array('group_message_thread_id' => $forum_id))->row()->group_message_thread_code;
			
			$data['group_message_thread_id']  = $forum_id;	
			$data['group_message_thread_code']  = $thread_code;
			$data['message']  = $comment;
			$data['sender_id']  = $user_id;
			$data['sender_role']  = $role_id;
			$data['timestamp']  = strtotime(date("Y-m-d H:i:s"));
			$data['sender'] = $login_type . '-' . $user_id;
			$data['created_on']  = date('Y-m-d h:i:s');

			$this->db->insert('group_message', $data);	 
		
			$response = $this->getForumsListComments($forum_id,1,$user_id,$role_id);
						
			$noti_arr['creator_id'] = $user_id;
			$noti_arr['creator_role'] = $role_id;
			$noti_arr['created_on'] = date('Y-m-d h:i:s');
			
			$memberdata = $this->db->get_where('group_message_thread', array('group_message_thread_id' => $forum_id))->row()->members;
			
			$memberdata = str_replace('[','',$memberdata);
			$memberdata = str_replace(']','',$memberdata);
								
			$userdata = explode(',',$memberdata);
			
			$i = $j=0; 
			foreach($userdata as $v){
				
				$user = explode('_',$v);
				$role = $user[0];
				$role = str_replace('"','',$role);
				$uid = str_replace('"','',$user[1]);
						 
				if($role == 'parent'){
					
					$parent_id = $uid;
					$student_id = $this->db->get_where('student', array('parent_id' => $parent_id))->row()->student_id;	
			
					$noti_arr['title'] = 'Reply to forum';
					$noti_arr['content'] = 'Reply to forum';
					$noti_arr['type'] = '13';	
					$noti_arr['type_id'] = $forum_id;	
					$noti_arr['student_id'] = $student_id;										
											
					$this->notificationAlert($parent_id,1,$noti_arr,$noti_arr['title']);
				
					if($i == 0) $this->db->insert('notifications', $noti_arr);	
					
					$i=1;
				}
				else{ 					
					
					$noti_arr['title'] = 'Reply to forum';
					$noti_arr['content'] = 'Reply to forum';
					$noti_arr['type'] = '13';				
					$noti_arr['type_id'] = $forum_id;	
					$noti_arr['student_id'] = 0;
					$noti_arr['receiver_id'] = $uid;
					$noti_arr['receiver_role'] = ($role == 'principal')?'3':'2';
					
					if($role == 'principal') 			
						$this->notificationAlert($uid,3,$noti_arr,$noti_arr['title']);
					else
						$this->notificationAlert($uid,2,$noti_arr,$noti_arr['title']);
					
					$this->db->insert('notifications', $noti_arr);	
										
				} 			
				
			}					 
		
			echo json_encode($response);
		}
	}
	
	function getUpdateFavForum()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');		 
		$forum_id  = $this->input->post('forum_id');
		$is_fav  = $this->input->post('fav');
 
		$response = array('status'=>'0','message'=>'forum id missing');
		
		if($forum_id > 0 ){			
		
			$cnt = $this->db->get_where('favorite_message', array('user_id' => $user_id,'role_id' => $role_id,'thread_id' => $forum_id))->num_rows();
		
			if($cnt == 0){
		
				$data['thread_id']  = $forum_id;	
				$data['user_id']  = $user_id;
				$data['role_id']  = $role_id;
				$data['is_fav']  = $is_fav;				
				$this->db->insert('favorite_message', $data);	 	
			}else{
				
				$this->db->where('thread_id', $forum_id);
				$this->db->where('user_id', $user_id);
				$this->db->where('role_id', $role_id);
				$this->db->update('favorite_message', array('is_fav' => $is_fav));
			}
		
			$response = $this->getForumsListComments($forum_id,1,$user_id,$role_id);	
		}
		
		echo json_encode($response);
	}
	
	function getUpdateOpenForum()
    {		 
		$user_id  = $this->input->post('user_id');	
		$role_id  = $this->input->post('role_id');		 
		$forum_id  = $this->input->post('forum_id');
		$is_open  = $this->input->post('open');		 
		$response = array('status'=>'0','message'=>'forum id missing');
		
		if($forum_id > 0 ){			

			$this->db->where('group_message_thread_id', $forum_id);
			$this->db->update('group_message_thread', array('is_open' => $is_open));
		
			$response = $this->getForumsListComments($forum_id,1);	
		}
		
		echo json_encode($response);
	}
	
	function report($param1 = '',$param2 = 1){
						
		$this->load->library('pdf');
        $pdf = $this->pdf->load();
		$pdf->debug = true;

		$student_id = $param1;
				
		$student = $this->db->get_where('student' , array('student_id' => $student_id))->row();
		$data['student_name'] = $student->name;
		$data['school_image'] = $this->crud_model->get_image_url('school',$student->school_id);
		
		$enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
		$class_id = $enroll->class_id;
		$section_id = $enroll->section_id;
		
		$data['class_name'] = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
		
		$teacher_name = $this->db->get_where('teacher' , array('teacher_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->teacher_id))->row()->name;
		
		if($teacher_name == '')
			$teacher_name = $this->db->get_where('principal' , array('principal_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->principal_id))->row()->name;
		
		$data['class_teacher'] = $teacher_name;	
				
		switch($param2){
		
			case 1:
			
				$report_name = 'health_report';
			
				$last_incident = $this->db->order_by('updated_date', 'DESC')->get_where('health_reports' , array('student_id' => $student_id))->row();
				
				$report = $this->db->order_by('updated_date', 'DESC')->get_where('health_reports' , array('student_id' => $student_id))->result_array();
				
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
												 
				$payment_date = $this->db->get_where('payment' , array('invoice_id' => $invoice->invoice_id))->row()->timestamp;
			
				$fee_status = ($invoice->due >0)?'Pending':'Cleared';
				$data['fee_status'] = $fee_status;
				$data['incident_date'] = ($payment_date !='')?date('d M Y',$payment_date):'';
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
			
				$report_name = 'education_report';
				
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
				
				$template = "backend/principal/education_pdf_report";
			break;
			default:
			break;			
		}
 
		$location = 'http://'.$_SERVER['HTTP_HOST'];
		
		$content = $this->load->view($template, $data, true);		
		
        $name = $report_name . date('Y_m_d_H_i_s') . '.pdf';		
	
		$stylesheet = file_get_contents('http://shamlatech.net/school/assets/css/pdf_style.css');
		
        $pdf->WriteHTML($stylesheet,1);
     
		$pdf->WriteHTML($content,2);
			 	
		$pdf->Output($name, 'F');		
		 
		return $location.'/'.$name;
		
	}
	
			
}