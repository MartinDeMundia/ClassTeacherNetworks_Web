<table class="table table-striped dataTables-example">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Subject </th>
                        <th>Teacher Name </th>
                        <th>Total Entry </th>
                        <th>Submitted </th>
                        <th>Remaining </th>
                        <th>Status</th>
						<th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					include 'dbconn.php';
					session_start();
$i=0;
		$id = $_SESSION['id'];
		$sql = "SELECT * FROM openexam WHERE id = '$id'";
		$query = $con->query($sql);
		$row = $query->fetch_assoc();
		$q12222 = "SELECT DISTINCT(Abbreviation) as sub1,description from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 $subject="";
		$name="";
		$entry='';
		$diff="";
		$m="";
		$id="";
				$i+=1;
				$q="SELECT subject,entry FROM entry WHERE Year='".$row['year']."' and term='".$row['term']."' AND form='".$row['form']."' AND subject='".$rs22['sub1']."' and stream='".$row['stream']."'";
						$result=$con->query($q);
						
						while($row1=$result->fetch_assoc()){
							//echo $q;
							$q1 = "SELECT Name,Empno FROM subjectallocationa WHERE form='".$row['form']."' AND subject='".$row1['subject']."' and stream='".$row['stream']."'";	
						$qq=mysqli_query($con,$q1);
						while($rs=mysqli_fetch_assoc($qq)){

	
	
	
	$exm=strtolower(str_replace("-","",str_replace(" ","",$row['exam'])));
	 $q13 = "SELECT COUNT(distinct(Adm)) as m FROM  $exm where Year='".$row['year']."' and term='".$row['term']."' AND form='".$row['form']."' AND subject='".$row1['subject']."' and stream='".$row['stream']."'";
						
						$name=$rs['Name']; 
						$id=$rs['Empno'];
						}
			$qq3=mysqli_query($con,$q13);
			while($rs3=mysqli_fetch_assoc($qq3)){
			$m=0;
			if($rs3['m']>0){
		
			$m=$rs3['m'];
	
				}
		else{
		
		$m=0;
		
		}
   	
				


		
		$subject=$rs22['sub1'];
		
		

							
							
						?>
					
                    
                   <?php  
 
 
 
 }
 $entry=$row1['entry'];
 $diff=($row1['entry']-$m);
						} ?>
						<tr>
                        <td><?php echo $i; 					?></td>
                        <td><?php echo  $rs22['description'];	?></td>
                        <td><?php echo 	$name;	?></td>
                        <td><?php echo  $entry;		?></td>
                        <td><?php echo $m; 					?></td>
                        <td><?php echo $diff; ?></td>
                        <td><?php if($diff>0 || $m<=0){				?>
						<i class="fa fa-remove text-danger">
							<?php	}else{	?><i class="fa fa-check text-success"><?php	} ?> </td>
                        <td><?php if($diff>0 || $m<=0){ ?><button class="btn btn-default btn-sm" id="<?php echo $id; ?>">Request marks</button> <?php } ?></td>
                       
                    </tr>
					<?php
						}
				   
				   ?>
                    </tbody>
                </table>
				
				<script>
				  $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: '<?php echo $row['form']. " ".$row['term']."  ".$row['exam']."  ".$row['year']. " PUBLISHING STATUS"    ?>'},
                    {extend: 'pdf', title: '<?php echo $row['form']. " ".$row['term']."  ".$row['exam']."  ".$row['year']. " PUBLISHING STATUS"    ?>',pageSize: 'A4',orientation: 'portrait'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			  });
			</script>
				
				
				
				