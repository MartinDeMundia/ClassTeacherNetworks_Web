<style>
.prev.disabled{
visibility:hidden !important;
}
.next.disabled{
visibility:hidden !important;
}

</style>
<style>
.modal-body {
    height: auto !important;
}
.modal-backdrop.fade.in {
    z-index: auto !important;
}
#table_export_length{
    visibility:hidden !important;
    display:none;
}
#table_export_filter{
    visibility:hidden !important;
    display:none;
}
#table_export_info{
    visibility:hidden !important;
    display:none;
}
.dataTables_paginate.paging_bootstrap{
    visibility:hidden !important;
    display:none;
}

</style>
<link href="<?php echo base_url('assets/dmultiselect/docs/css/bootstrap-3.3.2.min.css');?>" rel="stylesheet"> 
<link href="<?php echo base_url('assets/dmultiselect/docs/css/bootstrap-example.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/dmultiselect/docs/css/prettify.min.css');?>" rel="stylesheet">


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/tableExport.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/jquery.base64.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/html2canvas.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/sprintf.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/jspdf.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/base64.js');?>"></script>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    Teachers Lessons
                </div>
            </div>

             <div class="row" style="float:right;width:auto !important;margin-top: 15px;">


              <div class="col-sm-12">


                              <div class="col-sm-6 dropdown">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                     <span class="glyphicon glyphicon-th-list"></span> Print Timetable
                                   
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="#" onclick="generatePDF('teacher');"> <img src="<?php echo base_url('assets/tableexport/images/pdf.png');?>" width="24px"> Teachers time table</a></li>
                                                <li><a href="#" onclick="generatePDF('school');"> <img src="<?php echo base_url('assets/tableexport/images/pdf.png');?>" width="24px"> School time table</a></li>                                                  
                                  </ul>
                              </div>
                              <div class="col-sm-6">
                                    <a href="#" style="margin:1px;" onClick="addlessonTimetable()"
                                    class="btn btn-primary pull-right">
                                    <i class="entypo-plus-circled"></i>
                                     Add lesson on Timetable</a>
                              </div> 

                </div>

<!--                                 <a href="#" style="margin:1px;" onClick="addlessonTimetable()"
                                   class="btn btn-primary pull-right">
                                    <i class="entypo-plus-circled"></i>
                                     Add lesson on Timetable</a>
                                </div> -->
          

            </div>


            <div class="panel-body">


                <form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">


                    <div class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Year..." class="form-control"  id="year" ><option value="">Select Year...</option>
                            <option selected value="2019">2019</option>
                            <?php
                            for ($i=0; $i<=3;$i++){
                                ?>
                                <option value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <select placeholder="Select Term..." class=" form-control"  id="term">
                            <option value="">Select Term...</option>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select> 
                    </div>


                  <div class="form-group" style="margin-bottom: 15px;">
                            <select id="teacher" name="teacher" class="form-control" onchange="">
                                <option value="">Select Teacher</option>
                                <?php

								$qryData = " 
                                       SELECT * FROM teacher WHERE school_id = '".$this->session->userdata('school_id')."'
								";

                                $sTeacher = $this->db->query($qryData)->result_array();
                                foreach($sTeacher as $row):
                                    ?>
                                    <option value="<?php echo $row['teacher_id'];?>"
                                        <?php if($teacher_id == $row['teacher_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                            </select>  
                  </div>


          

                </form>



                <div id="alert" class="alert alert-danger" style="display:none;" >Please select  stream , term </div> 





























                <div class="row">
                    <div class="col-md-12">
                                <table class="table table-bordered datatable" id="table_export">
                                    <thead>
                                    <tr>                                       
                                        <th width="auto" style="visibility:hidden;display:none;"><div>#</div></th>
                                        <th width="auto"><div>Day</div></th>

                                       <?php

                                                $timeslots = array();
                                                $start_date = "08:00:00";   
                                                $end_date = "16:00:00";
                                                $lessonperiod_in_minutes = "40";
                                                $shortbreak = "09:20:00";
                                                $shortbreakduration = "5";
                                                $teabreak = "11:25:00";
                                                $teabreakduration = "20";
                                                $lunchbreak = "13:45:00";
                                                $lunchbreakbreakduration = "55";
                                               $dbsettings =  $this->db->get_where('timetable_settings', array(
                                                    'school_id' => $this->session->userdata('school_id')
                                                ))->result_array(); 

                                               if(count($dbsettings)){
                                                $start_date = date('H:i',strtotime($dbsettings[0]["start_time"]));
                                                $end_date = date('H:i',strtotime($dbsettings[0]["end_time"]));  
                                                $lessonperiod_in_minutes = $dbsettings[0]["period_duration"];
                                                $shortbreak = date('H:i',strtotime($dbsettings[0]["short_break_startime"]));
                                                $shortbreakduration = $dbsettings[0]["short_break_duration"];
                                                $teabreak =   date('H:i',strtotime($dbsettings[0]["tea_break_startime"]));
                                                $teabreakduration = $dbsettings[0]["tea_break_duration"];
                                                $lunchbreak = date('H:i',strtotime($dbsettings[0]["lunch_break_startime"])); 
                                                $lunchbreakbreakduration = $dbsettings[0]["lunch_break_duration"];
                                               }
                                               $hashortbreak = 0;
                                                $begin = new DateTime( $start_date );
                                                $end = new DateTime(date("H:i",strtotime("+1 minutes", strtotime($end_date))));
                                                while($begin < $end) {
                                                    $period[] = $begin->format('H:i');
                                                    $begin->modify('+1 minutes');
                                                }

                                            $lsbegin = date_create($period[0])->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                            $lesnend =  $lsbegin->format('H:i');  

                                            $timeslots[] =   array($period[0],$lesnend);
                                            echo '<th width="auto"><div style="font-size:9px">'. $period[0] .'-'.$lesnend.'</div></th>';

                                             $i = 1;
                                                for ($j = 0 ;$j <= count($period)-1 ; $j++){ 

                                                    $sTime = $period[$j];

                                                    if($i == 1){ 

                                                         $lend = date_create($sTime)->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                                         $lsnend =  $lend->format('H:i'); 
                                                    }


                                                    if($shortbreak  == $sTime ){
                                                              $sBreak = date_create($sTime)->add(date_interval_create_from_date_string($shortbreakduration.' minutes')); 
                                                              $shortbreakend =  $sBreak->format('H:i');
                                                              $timeslots[] =   array($shortbreak,$shortbreakend);
                                                              echo '<th width="auto"><div style="font-size:9px"> <span style="font-size:9px">Short Break</span><br>'. $shortbreak .'-'.$shortbreakend.'</div></th>';

                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($shortbreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $shortbreakend ;
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }


                                                    if($teabreak  == $sTime ){
                                                              $sTBreak = date_create($sTime)->add(date_interval_create_from_date_string($teabreakduration.' minutes')); 
                                                              $teabreakend =  $sTBreak->format('H:i');
                                                              $timeslots[] =   array($teabreak,$teabreakend);
                                                              echo '<th width="auto"><div style="font-size:9px"><span style="font-size:9px">Tea Break</span><br>'. $teabreak .'-'.$teabreakend.'</div></th>';

                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($teabreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $teabreakend ;
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }

                                                    if($lunchbreak  == $sTime ){
                                                              $sTBreak = date_create($sTime)->add(date_interval_create_from_date_string($lunchbreakbreakduration.' minutes')); 
                                                              $lunchbreakend =  $sTBreak->format('H:i'); 
                                                              $timeslots[] =   array($lunchbreak,$lunchbreakend);
                                                              echo '<th width="auto"><div style="font-size:9px"><span style="font-size:9px">Lunch Break</span><br>'. $lunchbreak .'-'.$lunchbreakend.'</div></th>';

                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($lunchbreakbreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $lunchbreakend ; 
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }


                                                    if($sTime == $lsnend ){
                                                            $lsbegin = date_create($lsnend)->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                                            $lesnend =  $lsbegin->format('H:i');
                                                            $timeslots[] =   array($lsnend,$lesnend); 
                                                      echo '<th width="auto"><div style="font-size:9px">'. $lsnend .'-'.$lesnend.'</div></th>';
                                                      $i=0;
                                                      $sTime = $period[$j + 1] = $lsnend;
                                                     }        

                                                   if( $sTime == date('H:i',strtotime($end_date))){
                                                    break;
                                                   }    

                                                 $i ++;

                                                }

                                       ?>  
                                    </tr>
                                    </thead>
                                    <tbody>                                 
                                 
                                        <tr> 
                                            <td style="visibility:hidden;display:none;"></td>                                          
                                            <td><img src="" class="img-circle" width="30" /></td>                                           
                                      <?php                                    
                                            for ($k = 0 ;$k <= count($timeslots)-1 ; $k++){
                                                echo '<td></td>';
                                                 
                                            }
                                        ?>
                                        </tr>
                               
                                    </tbody>
                                </table>

                    </div>
                </div>
            </div>
        </div></div></div>


<script src="<?php echo base_url();?>js/plugins/dropzone/dropzone.js"></script>
<script>



    function addlessonTimetable(){
        var yr = $('#year').val();  
        var term = $("#term").val();
        var tr = $('#teacher').val(); 

            if( term =="" || yr =="" || tr ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");
                showAjaxModal('<?php echo base_url();?>modal/popupcustom/modal_add_timetable_teachers/'+tr+'/'+term+'/'+null+'/'+yr);
            }  
    }


    function loadTimeTable(){

        var yr = $('#year').val();  
        var term = $("#term").val();
        var tr = $('#teacher').val(); 

       var tmstring = <?php echo json_encode($timeslots , JSON_FORCE_OBJECT ) ?>; 

        dataTable =  $('#table_export').DataTable();
        dataTable.fnSetColumnVis( 0, false );
        dataTable.fnClearTable();
        dataTable.fnDraw();
        if(term == "") term = "Term 1";
        if(tr == "") tr =0;
        $.ajax({
            type: 'POST',
            url: "fetchtimetable_teacher/"+yr+"/"+term+"/"+tr,
            data: JSON.stringify({ "datas": tmstring }),
            cache:false,
            processData:false,
            contentType:false,

            success: function(res){
               var respData = JSON.parse(res);
                $.each(respData.content, function(i, item) { 

                        dataN = [
                            '<td style="">'+item.index+'</td>',
                            '<td>'+item.day+'</td>' 
                        ];

                        $.each(item.subject, function(j, lessonitem) { 
                            if(item.subject[j].timeslotype != ""){ 
                              lsnData  = '<td class="breakcolumn"><span style="padding-top:15%;border-radius:10%;background:#c86814;color:white;font-size: 12px;font-weight: bolder;width:100%;height:60px;display:inline-block;text-align:center;">'+item.subject[j].timeslotype+'</span></td>';
                            }else{
                              lsnData  = '<td>'+item.subject[j].displayString+'</td>';  
                            }
                                                         
                                
                         dataN.push(lsnData);

                        });
                   dataTable.fnAddData(dataN);

                 });
                
            }
            
        });
    }





    function generatePDF(pdftype){

        var term = $("#term").val();
        var tr = $('#teacher').val();  
        var yr = $('#year').val();                

            if( term =="" || tr=="" || yr ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");

                    url = "t_pdf/"+tr+"/null/"+yr+"/"+term+"/"+pdftype+"/Timetable";

                    switch(pdftype){
                      case "teacher":
                       var win = window.open(url, '_blank');
                       win.focus();
                      break;
                      case "school":
                       var win = window.open(url, '_blank');
                       win.focus();
                      break;
                    }              

            }  
          
    }


  $(document).ready(function (){  
        $('select').on('change', function(){
              loadTimeTable();             
        });
       loadTimeTable(); 
  });  
</script>




