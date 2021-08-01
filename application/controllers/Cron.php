<?php
//error_reporting(0); 


class FCM{
	
	
	function __construct() {
    }
	
   public function pushNotification($registatoin_ids, $notification,$device_type){	   
	   
	  $url = 'https://fcm.googleapis.com/fcm/send';
      if($device_type == "Android"){
            $fields = array(
                'to' => $registatoin_ids,
                'data' => $notification
            );
      } else {
            $fields = array(
                'to' => $registatoin_ids,
                'notification' => $notification
            );
      }
      // Firebase API Key
      $headers = array(
	   'Authorization:Key=AAAADPFD3Jw:APA91bEJ1ibalab11NcB0UY4oV9ZYwThAiNSzj0tTZv_HFykt0eW8xLw-EJZUl-cQEAenEGqNHdYgs-j2wIChZ1m-1ReiW5LKnpQ02MEm8JJx-CKyXxguagc3ERbfwEDK4lij46mtDRx',
       'Content-Type:application/json');
	 // Open connection
	  $ch = curl_init();
	  // Set the url, number of POST vars, POST data
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_POST, true);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  // Disabling SSL Certificate support temporarly
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	  $result = curl_exec($ch);
	  if ($result === FALSE) {
		  die('Curl failed: ' . curl_error($ch));
	  }else{
		  echo $result ; 
	  }
	  curl_close($ch);	   
	   
   }
}


class Cron
{  
    
    function fcmpush(){
		$conn = mysqli_connect("apps.classteacher.school","appsuserclass",">UKn}6=MK[w^`P5B")or die(mysqli_error());
		mysqli_select_db($conn,"appsclassteacher");	
	
		$fcm = new FCM;
		$notification = array();
		$arrNotification= array();			
		$arrData = array();	
		
		//get weeks notifications
		$qryData = "
		SELECT *
		FROM notifications
		WHERE yearweek(DATE(created_on), 1) = yearweek(curdate(), 1) AND is_read = 0  ORDER BY created_on DESC
		";  
		
		$notification_data = mysqli_query($conn,$qryData)or die(mysqli_error($conn));
			
		while($row = mysqli_fetch_assoc($notification_data)) {		
			if($row['receiver_role'] == 1){
				$student_id = $row['student_id'];
				$sql = "SELECT parent_id FROM  student WHERE student_id = '".$student_id."' ";
				$res = mysqli_query($conn,$sql);
				$rowstud = mysqli_fetch_assoc($res);
				$receiver_id = $rowstud['parent_id'];			
				
			}else{
				$receiver_id =  $row['receiver_id'];
			}	
			$arrNotification["body"] ="Created by Martin Mundia M.";
			$arrNotification["created_on"] = $row['created_on'];
			$arrNotification["id"] = $row['id'];
			$arrNotification["title"] = $row['title'];//"Upcoming lesson for Tr. Mundia";
			$arrNotification["content"] = $row['content'];//"You have an upcoming Kiswahili lesson at 08:00 AM";
			$arrNotification["user_id"] = $receiver_id;
			$arrNotification["imageUrl"] = "http://h5.4j.com/thumb/Ninja-Run.jpg";
			$arrNotification["gameUrl"] = "https://h5.4j.com/Ninja-Run/index.php?pubid=noad";		
			$arrNotification["sound"] = "default";
			$arrNotification["type"] = 1;
			//var_dump($arrNotification); echo "<hr>"; exit();
			$regId = "/topics/all";
			$fcm->pushNotification($regId, $arrNotification,"Android");			
			//sleep(1);
		}
		
		
	}	
	
}
$cls = new Cron();
$cls->fcmpush(); 
?>