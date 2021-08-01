<?php
session_start();
	include("dbconn.php");
$date=Date("d/m/Y");
$cat="";
$type="";
		if(isset($_SESSION['date'])){
         $date=$_SESSION['date'];
		 $cat=$_SESSION['cat'];
		 $type=$_SESSION['type'];
          //unset($_SESSION['date']);
        }
		?>
		<?php
if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-succes'>
             
             <center> <h4><i class='icon fa fa-book'></i>
              ".$_SESSION['success']. "</h4></center>
            </div>
          ";
          unset($_SESSION['success']);
        }
?>
<table class="table table-bordered table-striped table-responsive" id="table_export">
    <thead>
      <tr class="danger">
        <th>ID</th>
        <th>NAME</th>
        <th>MESSAGE</th>
      </tr>
    </thead>
    <tbody>
	<?php
	include("dbconn.php");
	$query="SELECT uniques,Name,Message FROM messages where Category='".$cat."' and Date='".$date."'  and Status='".$type."'";
	$da=$con->query($query);
	while($row=$da->fetch_assoc()){
	?>
	
      <tr>
        <td><?php  echo $row['uniques']; ?></td>
        <td><?php  echo $row['Name']; ?></td>
        <td><?php  echo $row['Message']; ?></td>
      </tr>
      <?php
	}
	
	?>
    </tbody>
  </table>