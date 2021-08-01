<?php
session_start();
require('dbconn.php');


?>


<table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div>Teacher Name</div></th>
							 <?php
								  
								  $qs="SELECT concat(UPPER(Abbreviation),' (',code,')') AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			$i+=1;
						  ?><div><th scope="col"><?php echo "Subject ".$i; ?></div></th>
						   <?php
						  
						  }
						  ?>
                    		
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($class as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['Names'];?></td>
							<?php
								  
								  $qs="SELECT concat(UPPER(Abbreviation),' (',code,')') AS subs, Code FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  ?>
							<td>
							 
						   
                            <select data-placeholder="Choose a Term..." class="" tabindex="1" id="fr" >
							<option>none</option>
								<?php
                                   $q="SELECT * from subjects";
								  $r=mysqli_query($con,$q);
								  while($rowq=mysqli_fetch_assoc($r)){
									  
									 ?>
									 
                                    <option <?php if ($sr['Code']==$this->crud_model->get_subject($row['Empno'],$rowq['Code'],$form,$stream)) echo 'selected' ?> value="<?php echo $rowq['Code']; ?>"><?php echo $rowq['Abbreviation']?></option>
                                   <?php
								  }
								  ?>
                                </select>
								
        					</td>
							<?php
						  
						  }
						  ?>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>