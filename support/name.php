<?php
include_once("dbconn.php");
$q=mysqli_real_escape_string($con,$_GET['q']);

$s="SELECT name FROM sudtls where Adm='$q'";

$r=$con->query($s);
while($row=$r->fetch_assoc()){
	
	?>
	<label class="col-sm-3 control-label"><?php echo $row['name'];?></label>
	<?php
}




?>