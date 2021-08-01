
<hr />  
<?php $running_year = 2019; ?>
<div class="row">



             <form role="form" class="form-inline" >
             
             <div class="form-group hidden" style="margin-bottom: 35px;">
                                    
                                    <select class="form-control " tabindex="1" id="fr" ><option value="">Select Class...</option>
                                <?php
                                 include_once("dbconn.php");
                                   $q="SELECT * from form";
                                  $r=mysqli_query($con,$q);
                                  while($row=mysqli_fetch_assoc($r)){
                                     ?>
                                    <option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
                                  }
                                  ?>
                                </select>
                                </div>
                                <div class="form-group hidden" style="margin-bottom: 35px;">
                                    
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="Streams" ><option value="">Select Stream...</option>
                                <?php
                                   $q="SELECT * from streams";
                                  $r=mysqli_query($con,$q);
                                  while($row=mysqli_fetch_assoc($r)){
                                     ?>
                                    <option  value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
                                  }
                                  ?><option  value="">ALL</option>
                                </select>
                                </div>
                                 <div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select>
                                </div>


                                 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control " tabindex="1" id="year"><option  value="">Select Year...</option>
                                    <option selected value="2019">2019</option>
                                  <?php
                                  for ($i=0; $i<=3;$i++){
                                      ?>
                                      <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
                                      <?php
                                  }
                                  ?>
                                    
                                </select>
                            </div>

                             <div class="form-group" style="margin-bottom: 35px;">                           
                                            <select name="exam_id" id="examtype" class="form-control" required>
                                            <?php if($exam)?><option value="<?php echo urldecode($exam); ?>" selected=""><?php echo urldecode($exam); ?></option>
                                                <?php                   
                                                    $exams = $this->db->get_where('exams' , array('school_id' =>$this->session->userdata('school_id')))->result_array();
                                                    foreach($exams as $row):
                                                ?>
                                                <option value="<?php echo $row['Term1'];?>"
                                                    <?php if($exam_id == $row['ID']) echo 'selected';?>><?php echo $row['Term1'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                    </div>
                                
<!--                                   <div class="form-group" style="margin-bottom: 35px;">
                                    <select data-placeholder="Choose exam..." class="form-control " tabindex="1" id="examtype"><option selected value="">Select Exam...</option>
                                  <?php
                                  
                                 
                                  $q="SELECT term1 FROM exams WHERE school_id='".$this->session->userdata('school_id')."'";
                                  $r=mysqli_query($con,$q);
                                  while($row=mysqli_fetch_assoc($r)){
                                     ?>
                                 
                                  
                                      <option   value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
                                      <?php
                                      
                                  }
                                  
                                  ?>
                                   </option>
                                      
                                </select> </div> -->

                            </form>
                <div id="alert" class="alert alert-danger" style="display:none;" >Please select all term, year and exam</div> 













    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                </a>
            </li>
        <?php
         $this->db->order_by("name","ASC");
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <li>
                <a href="#<?php echo $row['section_id'];?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('class');?> <?php echo $row['name'];?> </span>
                </a>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">
           

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>                
                            <th><div><?php echo get_phrase('stream');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                              /*  $students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();*/

                               $students   = $this->db->query('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.section_id = "'.$class_id.'"')->result_array();

                                foreach($students as $row):?>
                        <tr>
                            
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                            
                            <td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?></td>
                            <td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
                             <td>
                                <?php
                                 $this->db->order_by("name","ASC");
                                    echo $this->db->get_where('section' , array(
                                        'section_id' => $row['section_id']
                                    ))->row()->name;
                                ?>
                            </td>                            
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">                                      
                                        <li>

                                          <?php  if ($report == 7){

                                          ?>

                                          <li>
                                          <a class="report" target="_blank" href="<?php echo site_url('teacher/s_report/edit/'.$row['student_id']);?>">
                                          <i class="entypo-user"></i>
                                          <?php echo get_phrase('Edit Report');?>
                                          </a>
                                          </li>

                                          <li>
                                          <a class="report" target="_blank" href="<?php echo site_url('teacher/s_report/view/'.$row['student_id']);?>">
                                          <i class="entypo-user"></i>
                                          <?php echo get_phrase('report');?>
                                          </a>
                                          </li>

                                          <?php 

                                          }
                                          else{
                                          ?>
                                          <a class="report" target="_blank" onClick="openReportNewTab('<?php echo $row['student_id']; ?>')" href="javascript:void();">
                                                  <i class="entypo-user"></i>
                                                      <?php echo get_phrase('report');?>
                                          </a> 
                                          <?php 

                                          }

                                          ?>                                           
                                  
                                        </li>
                                         
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php
            $this->db->order_by("name","ASC");
            $query = $this->db->get_where('section' , array('class_id' => $class_id));



            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):                       

          ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>                
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                               /* $students   =   $this->db->get_where('enroll' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                                ))->result_array();*/

                        $students   = $this->db->query('SELECT * FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.class_id = "'.$row['class_id'].'" AND e.section_id  ="'.$row['section_id'].'"   ')->result_array();


                        foreach($students as $row):?>
                        <tr>
                            
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php
                               /* echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;*/
                               echo $row['student_code'];
                            ?></td>
                            <td>
                                <?php
                                echo $row['name'];
                                   /* echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;*/
                                ?>
                            </td>
                            
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
  


                                        <?php  if ($report == 7){

                                        ?>

                                        <li>
                                        <a class="report" target="_blank" href="<?php echo site_url('teacher/s_report/edit/'.$row['student_id']);?>">
                                        <i class="entypo-user"></i>
                                        <?php echo get_phrase('Edit Report');?>
                                        </a>
                                        </li>

                                        <li>
                                        <a class="report" target="_blank" href="<?php echo site_url('teacher/s_report/view/'.$row['student_id']);?>">
                                        <i class="entypo-user"></i>
                                        <?php echo get_phrase('report');?>
                                        </a>
                                        </li>

                                        <?php 

                                        }
                                        else{
                                        ?>
                                        <a class="report" target="_blank" onClick="openReportNewTab('<?php echo $row['student_id']; ?>')" href="javascript:void();">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('report');?>
                                        </a> 
                                        <?php 

                                        }

                                        ?>








                                    
                                        
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php endforeach;?>
        <?php endif;?>

        </div>


    </div>
</div>

<script>

function openReportNewTab(studid){
myurl = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
myurl = myurl.replace('#', '');
if(myurl == 5){
        var year=$("#year").val();
        var term=$("#term").val();
        var exam=$("#examtype").val();
         if(term=="" || year=="" || exam==""){
                    $("#alert").slideDown("slow");                
                } else{
                    $("#alert").slideUp("slow"); 

                     //create the graph
                  /*   var dataString = '&studid=' + studid + '&term=' + term + '&exam=' + exam ;
                      $.ajax({
                        type:'POST',
                        url: '<?php echo base_url(); ?>index.php/admin/creategrapghImage/'+studid+"/6/"+term+"/"+year+"/"+exam,
                        data:dataString,
                        cache:false,
                        success:function(result){
                            // window.open("/admin/report/"+studid+"/6/"+term+"/"+year+"/"+exam,'_blank');return false;
                          }, 
                          complete: function(){
                            
                          }
                          
                        
                        });
*/

                    window.open("/admin/classteacher/"+studid+"/6/"+term+"/"+year+"/"+exam,'_blank');return false;
           }

    }else{
              $('#alert').css({'visibility':'hidden'});
              $('#alert').css({'display':'none'});
                window.open("/admin/report/"+studid+"/"+myurl+"/Report",'_blank');return false;               
    }
    return false;  
}


$(document).ready(function(){  
myurl = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
myurl = myurl.replace('#', '');
if(myurl == 5){
        $(".report").click(function(){        
            var url= $(this).attr('href');
            var year=$("#year").val();
            var term=$("#term").val();
            var exam=$("#examtype").val();
           

            if(term=="" || year=="" || exam==""){
                $("#alert").slideDown("slow");
                    
            } else{
                $("#alert").slideUp("slow");

           // $(".report").attr("href", href="<?php echo site_url('admin/report/'.$row['student_id'].'/6' );?>/"+term+"/"+year+"/"+exam);


            var dataString = '&year=' + year + '&term=' + term + '&exam=' + exam ;
                    $.ajax({
            type:'POST',
            url: '<?php echo base_url(); ?>index.php/admin/report_data',
            data:dataString,
            cache:false,
            success:function(result){
                
            }, 
                        complete: function(){
                           // location.replace(url);
                        }
            
            
            });
            }    


        return false;
        });
    }
  
        if(myurl != 5){
            $("#year").hide();
            $("#term").hide();
            $("#examtype").hide();
            $("#alert").hide(); 
            $("#alert").slideUp("slow");
            $('#alert').css({'visibility':'hidden'});
        }else{
            $("#year").show();
            $("#term").show();
            $("#examtype").show();
            $("#alert").show();
            $('#alert').css({'visibility':'visible'}); 
        }

});
</script>




























































































