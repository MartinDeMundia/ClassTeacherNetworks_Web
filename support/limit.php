<?php
include_once("dbconn.php");
$exam=mysqli_real_escape_string($con,$_GET['s']);



		$q="select  exams.limit from  exams where term1='$exam'";
		
		$f=$con->query($q);
		////echo $q;
		while($row=$f->fetch_assoc()){
			
			?>
			
			<div class="form-group">
			
                            <input placeholder="enter limit..." class="form-control" type="text" id="limit" value="<?php echo $row['limit']; ?>" readonly="true"/>
                          </div>
						  <?php
			
		}

?>