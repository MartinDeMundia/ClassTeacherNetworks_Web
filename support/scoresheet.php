<?php
session_start();
require("dbconn.php");
require('fpdf/diag.php');
$title='';
$address='';
$tel='';
$q1s="select description from settings where type='system_title'";
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}
$subject=mysqli_real_escape_string($con,$_POST['subject']);
$form=mysqli_real_escape_string($con,$_POST['form']);
//$f2=str_replace("form";mysqli_real_escape_string($con,$_POST['form']);
$stream=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$term=mysqli_real_escape_string($con,$_POST['term']);      
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));

$f="";
$qs="SELECT Name  FROM form where Id='$form'";
$results=mysqli_query($con,$qs);
while($rs=mysqli_fetch_assoc($results)){
	
	$f=$rs['Name'];
}



$divv='';
if($en=="END OF TERM")
{
	
	
	
	$exm="ve";
}else{
	
	$equery = "SELECT openexam.limit FROM openexam WHERE  form='".$f."' and term='$term' and year='$year' and exam='$en' limit 1";
	//echo $equery;
	$r=$con->query($equery);
	$ro=$r->fetch_assoc();
	
	$divv=' / '.$ro['limit'];
	
	
}





		if(file_exists('PDFS/uu.pdf')){
rename('PDFS/markbook.pdf','PDFS/'.date('dmyh:i:sa').'pdf');
		}
$q1s="select description from settings where type='address'";
  $qs="SELECT code from subjects where Abbreviation='".$subject."'";
								  $rs=mysqli_query($con,$qs);
								  while($rows=mysqli_fetch_assoc($rs)){
									$code=$rows['code'];
								  }
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}
?>

	<div class="wrapper wrapper-content animated bounceIn">

                <div class="p-w-md m-t-sm">
				<div class="scroll_content">
<div class="row">
	 <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h2> <?php echo strtoupper($en.' '.$subject.' score sheet   -  '.$f. ' '.$stream. ' '.$year); ?></h2>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                             <a href="../PDFS/score.pdf" id="prt" download="Score Sheet">
                                <i class="fa fa-2x fa-print " ></i>
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
                            <table class="table table-bordered dataTables-example"  style="font-size:11px; color:;">
                              <thead>
                                <tr>

	

								  
						   
						 <th scope="col">#</th>
								 <th scope="col">ST </th>
                                  <th scope="col">ADM </th>
								  <th scope="col">NAME OF STUDENT</th>
								   <th scope="col">SCORE <?php echo $divv ?></th>
								      <th scope="col">PERCENTAGE SCORE</th>
								    <th scope="col">GRADE</th>
						  <th scope="col"></th>
						  </tr>
                          </thead>
                          <tbody>
						   <tr>
                              
<?php
						 //where Form='$form' and Stream='$stream'
						 if(strtolower($stream)=="all"){
							 $query="SELECT * from sudtls where Form='$form'";
						 }else{
						  $query="SELECT * from sudtls where Form='$form' and Stream='$stream'";
						 }
						  $results=mysqli_query($con,$query);
						  $NUM=0;
						 while($row=mysqli_fetch_assoc($results)){
							  $NUM+=1;
							  $qs="SELECT Code AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
								  ?>
								  <th> <?php echo $NUM; ?> </td>
								  <th> <?php echo substr($row['Stream']; ?> </td> 
                                  <th> <?php echo  $row['Adm']; ?> </td>   
								  <th> <?php echo $row['Name']; ?> </td>
								  <?php
					if($en=="END OF TERM"){
						 $qs1="SELECT totalscore  AS count FROM ".$exm." where Adm='".$row['Adm']."' and code='$code' and  term='$term' and year='$year' and form='$f' order by totalscore desc";
						
					}else {
			 $qs1="SELECT $exm  AS count,limit1 FROM scores where Adm='".$row['Adm']."' and code='$code' and  term='$term' and year='$year' and etype='$en' order by $exm desc";
					}
		$subs1=mysqli_query($con,$qs1);
		$res=0;
		$lmt=0;
		$p=0;
		$div='';
		$mult=1;
		while($sr2=mysqli_fetch_assoc($subs1)){
			
						  $res=$sr2['count'];
						  if($en=="END OF TERM"){
							  $lmt=1;
						  }else{
						  $lmt=$sr2['limit1'];
						  $div='/'.$lmt.'';
						  $mult=100;
						  }
						 
						  }
						  if($res>=1){
							  $p=($res/$lmt)*$mult;
							  ?>
						  <th> <?php echo round($res,0) ; ?> </td>
						   <th> <?php echo round($p,0) ; ?> </td>
						   <?php
						   $qs1U="SELECT grade   AS count FROM gradingscale where min>=$res and max<=$p";
		$subs1U=mysqli_query($con,$qs1U);
		$res1=0;
		//echo $qs1U;
		while($sr2U=mysqli_fetch_assoc($subs1U)){
						   $res1=$sr2U['count'];
		} ?>
						  <th> <?php echo $res1 ; ?> </td><?php
						  }else{
							  ?>
							   <th> <?php echo '-' ; ?> </td>
							  <th> <?php echo '-' ; ?> </td>
							  <th> <?php echo '-' ; ?> </td>
							  <?php
						  }
						  
						
						 ?>
   </div>
                </div>
</div></div></div></div></div>


	