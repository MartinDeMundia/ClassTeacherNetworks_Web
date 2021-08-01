<?php 
session_start();
	include 'dbconn.php';
	if(isset($_SESSION['form'])){
$form="class ='".$_SESSION['form']."'";
$year="and year ='".$_SESSION['year']."'";
} else{
	
	$form="";  $year=""; 
}
	
	
	?>

<div class="row">
                <div class="col-lg-12">
                <div class="ibox " id="ibox2">
                    <div class="ibox-title">
                        <h5><?php if(isset($_SESSION['year'])){ echo strtoupper('Index numbers for form '.$_SESSION['form']."  ".$_SESSION['year']); } ?></h5>
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
                        <th>#</th>
						 <th>ADM No.</th>
                        <th>NAME</th>
                        <th>INDEX No.</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
					$q="SELECT sudtls.name,kcseindex.adm,kcseindex.index FROM kcseindex LEFT JOIN sudtls ON (sudtls.Adm=kcseindex.adm) where $form  $year ";
					//echo $q;
					$i=0;
					$result=$con->query($q);
					while($row=$result->fetch_assoc()){
					$i+=1;
					?>
                    <tr class="">
                        <td><?php echo $i; ?></td>
                         <td><?php echo $row['adm']; ?></td>
						  <td><?php echo $row['name']; ?></td>
						   <td><?php echo $row['index']; ?></td>
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
                    {extend: 'excel', title: '<?php if(isset($_SESSION['category'])){ echo strtoupper('Index numbers for form '.$_SESSION['form']."  ".$_SESSION['year']); } ?>'},
                    {extend: 'pdf', title: '<?php if(isset($_SESSION['category'])){ echo strtoupper('Index numbers for form '.$_SESSION['form']."  ".$_SESSION['year']); } ?>'},

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