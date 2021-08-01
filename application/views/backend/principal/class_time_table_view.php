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


<!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>

<script type="text/javascript" src="<?php echo base_url('assets/tableexport/tableExport.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/jquery.base64.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/html2canvas.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/sprintf.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/jspdf.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/base64.js');?>"></script>
<!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  -->


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    Class Lessons
                </div>
            </div>

             <div class="row" style="float:right;width:auto !important;margin-top: 15px;">


                              <div class="col-sm-4 dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="float: right !important;margin-right: -19px !important;margin-top: 1px !important;">
                                       <span class="glyphicon glyphicon-th-list"></span> Print Timetable                                     
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                  <li><a href="#" onclick="generatePDF('class');"> <img src="<?php echo base_url('assets/tableexport/images/pdf.png');?>" width="24px"> Class time table</a></li>
 
                                                  <style>
                                                  .dropdown-submenu {
                                                      position: relative;
                                                  }

                                                  .dropdown-submenu .dropdown-menu {
                                                      top: 0;
                                                      left: 100%;
                                                      margin-top: -1px;
                                                  }
                                                  </style>
                                                   <li class="dropdown-submenu">
                                                    <a class="test "  href="#"><img src="<?php echo base_url('assets/tableexport/images/pdf.png');?>" width="24px"> Stream time table<span class="caret"></span></a>
                                                  <ul class="dropdown-menu"  >

                                                   <li><a href="#" onclick="generatePDF('stream','Monday');"><span class="fa fa-calendar"></span>&nbsp;Monday</a></li>
                                                   <li><a href="#" onclick="generatePDF('stream','Tuesday');"><span class="fa fa-calendar"></span>&nbsp;Tuesday</a></li>
                                                   <li><a href="#" onclick="generatePDF('stream','Wednesday');"><span class="fa fa-calendar"></span>&nbsp;Wednesday</a></li>
                                                   <li><a href="#" onclick="generatePDF('stream','Thursday');"><span class="fa fa-calendar"></span>&nbsp;Thursday</a></li>
                                                   <li><a href="#" onclick="generatePDF('stream','Friday');"><span class="fa fa-calendar"></span>&nbsp;Friday</a></li>
                                                   <li><a href="#" onclick="generatePDF('stream','Saturday');"><span class="fa fa-calendar"></span>&nbsp;Saturday</a></li>
                                                  </ul>
                                                  </li>

                                                  <script>
                                                  $(document).ready(function(){
                                                    $('.dropdown-submenu a.test').on("click", function(e){
                                                      $(this).next('ul').toggle();
                                                      e.stopPropagation();
                                                      e.preventDefault();
                                                    });
                                                  });
                                                  </script>
                                                  </li>
                                                  <li><a href="#" onclick="generatePDF('school');"> <img src="<?php echo base_url('assets/tableexport/images/pdf.png');?>" width="24px"> School time table</a></li>                                                  
                                    </ul>
                              </div>
                              <div class="col-sm-4">
                                    <a href="#" style="margin:1px;margin-right:10px !important;" onClick="generateTimeTable()"
                                    class="btn btn-primary pull-right">
                                    <i class="fa fa-gear"></i>
                                     Generate Timetable</a>
                              </div> 
                              <div class="col-sm-4">
                                    <a href="#" style="margin:1px;" onClick="addlessonTimetable()"
                                    class="btn btn-primary pull-right">
                                    <i class="entypo-plus-circled"></i>
                                     Add lesson on Timetable</a>
                              </div>          

            </div>


            <div class="panel-body">


                <form method="POST" enctype="multipart/form-data" class="form-inline" role="form" id="ef">



                        <div class="form-group" style="margin-bottom: 15px;">
                            <select id="class_id" name="class_id" class="form-control" onchange="get_class_section(this.value)">
                                <option value="">Stream</option>
                                <?php
                                $classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
                                foreach($classes as $row):
                                    ?>
                                    <option value="<?php echo $row['class_id'];?>"
                                        <?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>




                        <div class="form-group" style="margin-bottom: 15px;">
                                <select name="section_id" id="section_holder" onchange="" class="form-control">
                                    <?php
                                    $sections = $this->db->get_where('section' , array(
                                        'class_id' => $class_id
                                    ))->result_array();
                                    foreach($sections as $row):
                                        ?>
                                        <option value="<?php echo $row['section_id'];?>"
                                            <?php if($section_id == $row['section_id']) echo 'selected';?>>
                                            <?php echo $row['name'];?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>



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



                    <div class="form-group" style="margin-bottom: 15px;display:none;">

                        <div id="lim">

                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;display:none;">

                        <div class="col "><input placeholder="enter limit..." class="form-control" type="text" id="limit" /></div>
                    </div>

                    <div class="form-group " style="margin-bottom: 15px;display:none;">

                        <div class="col "><input placeholder="enter subject entry..." class="form-control hidden" type="text" id="entry" /></div>
                    </div>


                    <div class="form-group" style="margin-bottom: 15px;display:none;">
                        <input placeholder="enter out of..." class="form-control" type="text" id="outof"/>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">

                    </div>
                </form>
                <div id="alert" class="alert alert-danger" style="display:none;" >Please select  stream , term </div> 





























                <div class="row">
                    <div class="col-md-12">
                      <div class="loading-progress"></div>
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
<script src="<?php echo base_url();?>assets/js/progressbar/jquery.progresstimer.js"></script>
<script>

function generateTimeTable(){

        var term = $("#term").val();
        var st= $("#section_holder").val();
        var fr = $('#class_id').val(); 
        var yr = $('#year').val(); 

            if( term ==""){
                $("#alert").text("Please select school term to generate!");
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");

               var tmstring = <?php echo json_encode($timeslots , JSON_FORCE_OBJECT ) ?>;

               var progress = $(".loading-progress").progressTimer({                 
                    completeStyle: 'progress-bar-success',
                    showHtmlSpan: true,
                    onFinish: function () {
                   
                  }
                  });  

                $.ajax({
                  type: 'POST',
                  url: "generatetimetable/"+yr+"/"+term+"/"+fr+"/"+st,
                  data: JSON.stringify({ "datas": tmstring }),
                  cache:false,
                  processData:false,
                  contentType:false,
                  success: function(res){
                     progress.progressTimer('complete');
                     loadTimeTable();                       
                  }
                  
              });

            }  

   }

    function addlessonTimetable(){

        var term = $("#term").val();
        var st= $("#section_holder").val();
        var fr = $('#class_id').val(); 
        var yr = $('#year').val();
        var tmstring = <?php echo json_encode($timeslots , JSON_FORCE_OBJECT ) ?>;
        tslots = JSON.stringify({ "datas": tmstring });                  

            if( term =="" || fr=="" || st ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");
                showAjaxModal('<?php echo base_url();?>modal/popupcustom/modal_add_timetable/'+st+'/'+term+'/'+fr+'/'+yr,tslots);
            }  
    }



    function loadTimeTable(){

        var term = $("#term").val();
        var st= $("#section_holder").val();
        var fr = $('#class_id').val(); 
        var yr = $('#year').val(); 

       var tmstring = <?php echo json_encode($timeslots , JSON_FORCE_OBJECT ) ?>; 

        dataTable =  $('#table_export').DataTable();
            dataTable.fnSetColumnVis( 0, false );
            dataTable.fnClearTable();
            dataTable.fnDraw();
            postVrs = {
                "term":term, 
                "fr":fr,
                "st":st,
                "year":year,
                "data":tmstring
            }

        if(term == "") term = "Term 1";
        if(yr == "") yr = 2019;
        if(fr == "") fr = 0;
        if(st == "") st =0;

        $.ajax({
            type: 'POST',
            url: "fetchtimetable/"+yr+"/"+term+"/"+fr+"/"+st,
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





  $(document).ready(function (){  
        $('select').on('change', function(){
              loadTimeTable();             
        });
loadTimeTable();
  });






  
</script>
<script src="<?php echo base_url('assets/dropzone/dropzone.js');?>"></script>
<script>  

    function get_class_section(class_id) {
        jQuery('#subject_holder').html("<option value=''>select section first</option>");
        if (class_id !== '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
                success: function(response)
                {
                    jQuery('#section_holder').html(response);
                }
            });
        }
        else{
            $('#submit').attr('disabled', 'disabled');
        }
    }



    function generatePDF(pdftype,Opt=0){

        var term = $("#term").val();
        var st= $("#section_holder").val();
        var fr = $('#class_id').val(); 
        var yr = $('#year').val();                

            if( term =="" || fr=="" || st ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");

                    url = "t_pdf/"+fr+"/"+st+"/"+yr+"/"+term+"/"+pdftype+"/"+Opt;
                    var win = window.open(url, '_blank');
                    win.focus();             

            }  
          
    }

    $(document).ready(function() {

    });

</script>





