<?php
session_start();
 include_once("dbconn.php");
if(isset($_SESSION['id'])){
$id="and  user_code LIKE('%".$_SESSION['id']."%')";
$serial="and serial LIKE('%".$_SESSION['serial']."%')";
} else{
	
	$serial="";  $id="and user_code LIKE ('%not found%')"; 
}

?>
<div class="row">
                <div class="col-lg-12">
                <div class="ibox " id="ibox2">
                    <div class="ibox-title">
                        <h5><?php if(isset($_SESSION['category'])){ echo $_SESSION['subject']."  ".$_SESSION['category']."  ".$_SESSION['class']; } ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                          
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
<div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>Serial</th>
						 <th>ISBN</th>
                        <th>Title</th>
                        <th>Class</th>
                        <th>Category</th>
                        <th>Subject</th>
						<th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
					$q="SELECT books.status,serial,isbn,title,form,category,subject,books.id FROM books LEFT JOIN borrowed ON (borrowed.book_id=books.id) WHERE borrowed.status='Active' $id $serial";
					//echo $q;
					$result=$con->query($q);
					while($row=$result->fetch_assoc()){
					
					?>
                    <tr class="">
                        <td><?php echo $row['serial']; ?></td>
                         <td><?php echo $row['isbn']; ?></td>
						  <td><?php echo $row['title']; ?></td>
						   <td><?php echo $row['form']; ?></td>
						    <td><?php echo $row['category']; ?></td>
							 <td><?php echo $row['subject']; ?></td>
							  <td><?php if($row['status']=="Issued"){ ?><button id="<?php echo $row['id']; ?>" class="btn btn-info btn-sm return">Return</button> <?php } else if($row['status']=="Lost") { ?> <small class="label label-danger">Lost</small><?php } else { ?> <?php } ?> </td>
                    </tr>
					<?php 
					}
					?>
					 </tbody>
                    
                    </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        
			 <script>
        $(document).ready(function(){
			
			
			
			
			 $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    
                    
                    
                ]

            });
			
			
			
          

        });

    </script>