<?php 
session_start();
	include 'dbconn.php';
		$form = mysqli_real_escape_string($con,$_POST['form']);
		$id = mysqli_real_escape_string($con,$_POST['id']);
		$sql = "SELECT * FROM openexam WHERE id = '$id'";
		$query = $con->query($sql);
		$row = $query->fetch_assoc();

		$exam=$row['exam'];
		$term=$row['term'];
		$year=$row['year'];
		$f1=$row['form'];
		$tb=str_replace(" ","",str_replace("-","",$f1));
		
		$query="SELECT posClass,adm from ".$tb."term where Year='$year' and Term='$term' ORDER BY PosClass asc";
		$res=$con->query($query);
		
		$qq="select description from settings where type='school_code'";
		$r=$con->query($qq);
		
		$r1=$r->fetch_assoc();
		$code=$r1['description'];
		$i=0;
		while($row=$res->fetch_assoc()){
		$i+=1;
		$q1="select adm,form from sudtls where adm='".$row['adm']."'";
		$r2=$con->query($q1);
		
		$rw=$r2->fetch_assoc();
		$pos=$code."".$i;
		$adm1=$rw['adm'];
		$ff=$rw['form'];
		
		$_SESSION['form']=$ff;
		$_SESSION['year']=date("Y");
		$insert="INSERT INTO kcseindex(adm,kcseindex.index,class,year) VALUES('$adm1','$pos','$ff',".date("Y").")";
		
		if($con->query($insert)){
			echo 1;
		}
		
		else{
			
			echo $con->error;
		}
		
		}
?>