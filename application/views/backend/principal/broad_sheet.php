
<div class="row " id="">
	 <div class="col-lg-12">
<div class="ibox" id="ibox2">
                    <div class="ibox-title">
                        <h2>BROAD SHEET -   <?php echo strtoupper($class." ". $stream." ".$main_exam. " ($term - ". $year. ")"); ?></h2>
                       
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
                            <table class="table table-responsive table-sm table-bordered dataTables-example"  >
                              <thead class="">
                                <tr>
                                  <th>RNK</th>
								  <th>ADM</th> 
                                  <th>NAME</th>   
								  <th>FORM</th>
								  <th>STREAM</th>
								   <th>POS</th>
								   <th>TOTAL</th>
								  <th>MS</th> 
                                  <th>(%)</th>   
								  <th>MG</th>
								  <th>V/A</th>
								
								  <?php
								  if($exam1 != ''){
									  echo '<th>'.$exam1.'</th>';
								  }
								  ?>
								  
								  <?php
								  if($exam2 != ''){
									  echo '<th>'.$exam2.'</th>';
								  }
								  ?>
								  <?php
								$subjects=$this->db->query("SELECT Abbreviation FROM subjects  WHERE school_id=".$this->session->userdata('school_id')."  ORDER BY CODE ASC")->result_array();
							foreach($subjects as $row):
						  ?><th><?php echo $row['Abbreviation']; ?></th>
						   <?php
						  
						 endforeach;
						  ?>
                              </tr>
                          </thead>
                          <tbody>
						  <?php 
						
						  foreach($exam as $rs):
						    $paint_red="";
						  $grade = $this->db->query("select rgrade(".round($rs['TotalPercent'],2).",".$this->session->userdata('school_id').") AS Grade");
						  $grade1="";
						  $points1=0;
						  $points2=0;
						  foreach ($grade->result_array() as $g):
						  $grade1= $g['Grade'];
						  if($cutoff != ''){
						  $points1 = $this->db->get_where("gradingscale",array("Grade"=>$grade1,"school_id"=>$this->session->userdata('school_id')))->row()->Points;
						  $points2 = $this->db->get_where("gradingscale",array("Grade"=>$cutoff,"school_id"=>$this->session->userdata('school_id')))->row()->Points;
						  }
						  endforeach;
						  if (($points1 < $points2)==1){
							  $paint_red= 'style="font-size:11px; color:red;"';
						  }
						  ?>
						  
						   <tr <?php echo $paint_red; ?>>
                              <th scope="row"><?php echo $rs['PosClass']; ?></th>
							  <td><?php echo $rs['Adm']; ?></td>
                              <td scope="col"><?php echo $this->db->get_where("sudtls",array("Adm"=>$rs['Adm'],"school_id"=>$this->session->userdata('school_id')))->row()->Name; ?></td>
							  <td><?php echo $rs['Form']; ?></td>
                              <td><?php echo $rs['Stream']; ?></td>
							  <td><?php echo $rs['PosStream']; ?></td>
							  
                              <td><?php echo round($rs['TotalMarks'],2); ?></td>
							  <td><?php echo round($rs['TotalScore'],2); ?></td>
                              <td><?php echo round($rs['TotalPercent'],2); ?></td>
							  <td><?php echo $grade1; ?></td>
                              <td><?php  if ($grade !='') {
								  echo($this->db->get_where("gradingscale",array("Grade"=>$grade1,"school_id"=>$this->session->userdata('school_id')))->row()->Points)-($this->db->get_where("sudtls",array("Adm"=>$rs['Adm'],"school_id"=>$this->session->userdata('school_id')))->row()->kcpe)
								  ; }?></td>
								 
								   <?php
								  if($exam1 != ''){
									  $m = $this->db->query("SELECT ".str_replace(" ","",$exam1)." from mean_score where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and exam_type='$exam1' and term='Term 1' and Year = '2019'")->result_array();
								foreach($m as $r):
									 echo ' <td>'.$r[str_replace(" ","",$exam1)].'</td>';
								endforeach;
									 
								  }
								  ?>
								  
								   <?php
								  if($exam2 != ''){
									    $m = $this->db->query("SELECT ".str_replace(" ","",$exam2)." from mean_score where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and exam_type='$exam1' and term='Term 1' and Year = '2019'")->result_array();
								foreach($m as $r):
									 echo ' <td>'.$r[str_replace(" ","",$exam2)].'</td>';
								endforeach;
								  }
								  ?>
								  <?php
						  $subjects=$this->db->query("SELECT Abbreviation,code FROM subjects  WHERE school_id=".$this->session->userdata('school_id')."  ORDER BY CODE ASC")->result_array();
							foreach($subjects as $row):
						  ?><td><?php 
								$mark1=0;
								$mark2=0;
								$mark3=0;
								$m = $this->db->query("SELECT TotalScore from ".str_replace(" ","",$main_exam)." where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and exam_type='$main_exam' and code=".$row['code']." and term='Term 1' and Year = '2019'")->result_array();
								foreach($m as $r):
									$mark1= $r['TotalScore'];
								endforeach;
								if($exam1 != ''){
									$m = $this->db->query("SELECT TotalScore from ".str_replace(" ","",$exam1)." where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."   and code=".$row['code']." and term='Term 1' and Year = '2019'")->result_array();
										foreach($m as $r):
											$mark2= $r['TotalScore'];
										endforeach;
								}
													if($exam2 != ''){
												$m = $this->db->query("SELECT TotalScore from ".str_replace(" ","",$exam2)." where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."   and code=".$row['code']." and term='Term 1' and Year = '2019'")->result_array();
													foreach($m as $r):
														$mark3= $r['TotalScore'];
													endforeach;
								}
						  $total= $mark1+$mark2+$mark3;
						  
						   $grade = $this->db->query("select rgrade(".round($total,2).",1) AS Grade");
						  $grade1="";
						  
						  foreach ($grade->result_array() as $g):
						  $grade1= $g['Grade'];
						  endforeach;
						  if($total>0) { echo $total." ".$grade1 ;}else{ echo '-'; }
						  ?></td>
						   <?php
						 
						 endforeach;
						  
						  
						 
						  endforeach;
						  ?>
						  
						  
						  
						  
						  </tbody>
                  </table>
                        </div>
						</div></div></div>
						<!-- Footer -->

    	</div>
						</div>  
						  
						  
						  
						  
						  
	
<script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'BROAD SHEET -   <?php echo strtoupper($class." ". $stream." ".$main_exam. " ($term - ". $year. ")"); ?>'},
                    {extend: 'pdf', title: 'BROAD SHEET -   <?php echo strtoupper($class." ". $stream." ".$main_exam. " ($term - ". $year. ")"); ?>',pageSize: 'A4',orientation: 'landscape'},

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
						  
						  
						  
						  
						  
						  