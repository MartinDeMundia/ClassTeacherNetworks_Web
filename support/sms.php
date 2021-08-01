<?php
	
	$query="SELECT exam,msg,id from notify where status='New' and user_id='$id'";
		$result=$con->query($query);
		
		 
		 while($row=$result->fetch_assoc()){
			 ?>
			 <li>
                            <div class="dropdown-messages-box">
                                
                                <div class="media-body">
                                   
                                   
                                 
                                    <strong><?php echo $row['msg']."  ". $row['exam']; ?></strong>
                                    
                                </div>
                            </div>
                        </li> 
			 <?php
		 }

?>