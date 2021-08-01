<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

/* End of file Someclass.php */