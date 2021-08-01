<?php
session_start();
 include_once("dbconn.php");
if(isset($_SESSION['isbn'])){
	$param="and status LIKE('%".$_SESSION['param']."%')";
$isbn="and isbn LIKE('%".$_SESSION['isbn']."%')";
$serial="and serial LIKE('%".$_SESSION['serial']."%')";
$title="and title LIKE('%".$_SESSION['title']."%')";
$author="and author LIKE('%".$_SESSION['author']."%')";
$category="and category LIKE('%".$_SESSION['category']."%')";
$class="and form LIKE('%".$_SESSION['class']."%')";
$subject="and subject LIKE('%".$_SESSION['subject']."%')";
} else{
	
	$serial="";  $isbn=""; $title=""; $author=""; $category=""; $subject="";
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
                          
                            <a id="rpt" href="../PDFS/history.pdf" download="<?php echo strtoupper($_SESSION['subject']."-".$_SESSION['category']."-".$_SESSION['class'].'-borrowing history' ) ?>">
                                <i class="fa fa-print"></i>
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
						<th>Borrower code</th>
						<th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
					$q="SELECT books.status,user_code,serial,isbn,title,form,category,subject from books LEFT JOIN borrowed ON (borrowed.book_id=books.id) where books.status in ('Lost','Issued')  $serial  $isbn $title $author $category $subject";
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
							 <td><?php echo $row['user_code']; ?></td>
							  <td><?php if($row['status']=="AVAILABLE"){ ?><button id="<?php echo $row['id']; ?>" class="btn btn-info btn-sm issue">Issue</button> <?php } else if($row['status']=="Lost") { ?> <small class="label label-danger">Lost</small><?php } else { ?> <small class="label label-info">Borrowed</small><?php } ?> </td>
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
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: '<?php if(isset($_SESSION['category'])){ echo $_SESSION['subject']."  ".$_SESSION['category']."  ".$_SESSION['class']; } ?>'},
                    {extend: 'pdf', title: '<?php if(isset($_SESSION['category'])){ echo $_SESSION['subject']."  ".$_SESSION['category']."  ".$_SESSION['class']; } ?>'},

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