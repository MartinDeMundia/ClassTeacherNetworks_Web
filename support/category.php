<link href="css/plugins/select2/select2.min.css" rel="stylesheet" />
 <?php 
	include_once('dbconn.php');
	$f=mysqli_real_escape_string($con,$_GET['t']);	
	if($f=="student"){
	?>
	
<select style="display: ;" data-placeholder="select borrower code..." class="form-control chosen-select" tabindex="-1" id="user">
                <option value="select">Select
                </option>
				<?php 
				$q="SELECT name,adm from sudtls ";
						$result=$con->query($q);
						while($row=$result->fetch_assoc()){
							
							
							
							
							?>
							<option value="<?php echo $row['adm']; ?>"><?php echo $row['adm'].'  '.$row['name']; ?>
                </option>
							<?php
						}
						?>
						</select>
						<?php
						 
							
						
						} else{
							
						?>
						
						
						
						
						<select style="display: ;" data-placeholder="select borrower code..." class="form-control chosen-select" tabindex="-1" id="user">
                <option value="select">Select
                </option>
				<?php 
				$q="SELECT names,empno from staffs ";
						$result=$con->query($q);
						while($row=$result->fetch_assoc()){
							
							
							
							
							?>
							<option value="<?php echo $row['empno']; ?>"><?php echo $row['empno'].'  '.$row['names']; ?>
                </option>
							<?php
						}
						
						?>
						</select>
						<?php
						} 
							
						?>
						
						
				 <script src="js/plugins/select2/select2.full.min.js"></script>
<script>
$(document).ready(function() {
	
	 $('.chosen-select').chosen({width: "100%"});
	
});

</script>				 
						
			