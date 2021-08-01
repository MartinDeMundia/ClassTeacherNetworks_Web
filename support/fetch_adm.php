
 <?php 
	include_once('dbconn.php');
	$f=mysqli_real_escape_string($con,$_GET['f']);	
	$st=mysqli_real_escape_string($con,$_GET['s']);	
	?>
	
<select style="display: ;" data-placeholder="Choose adm..." class="form-control" tabindex="-1" id="user">
                <option value="select">Select
                </option>
				<?php 
				$q="SELECT name,adm from sudtls where Stream like('%$st%') and form like('%$f%') ORDER BY adm ASC";
						$result=$con->query($q);
						while($row=$result->fetch_assoc()){
							
							
							
							
							?>
							<option value="<?php echo $row['adm']; ?>"><?php echo $row['adm'].'  '.$row['name']; ?>
                </option>
							<?php
						}
						?>
			