<style>
.prev.disabled{
visibility:hidden !important;
}
.next.disabled{
visibility:hidden !important;
}
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
                    Examinations
                </div>
            </div>

             <div class="row" style="float:right;width:auto !important;margin-top: 15px;">


              <div class="col-sm-12">


                            <div class="col-sm-6 dropdown">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                     <span class="glyphicon glyphicon-th-list"></span> Print Timetable
                                   
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="#" onclick="generatePDF('exam');"><img src="<?php echo base_url('assets/tableexport/images/pdf.png');?>" width="24px"> Exams time table</a></li>
                                                 
                                  </ul>
                              </div>
                              <div class="col-sm-6">
                                    <a href="#" style="margin:1px;" onClick="addlessonTimetable()"
                                    class="btn btn-primary pull-right">
                                    <i class="entypo-plus-circled"></i>
                                     Add an Examination on Timetable</a>
                              </div>


<!--                                 <a href="#" style="margin:1px;" onClick="addlessonTimetable()"
                                   class="btn btn-primary pull-right">
                                    <i class="entypo-plus-circled"></i>
                                     Add an exam on Timetable</a> -->





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



                    <div class="form-group  " style="margin-bottom: 15px;">
                        <select placeholder="Select exam..." class="form-control"  id="examtype" ><option value="">Select Exam...</option>
                            <?php
                            $q="SELECT id,term1 FROM exams WHERE school_id='".$this->session->userdata('school_id')."'";
                            $r=$this->db->query($q)->result_array();;
                            foreach ($r as $row) :
                            ?>
                            <option id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>"><?php echo $row['term1']; ?>
                                <?php
                                endforeach;

                                ?>
                            </option>

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
                                <table class="table table-bordered datatable" id="table_export">
                                    <thead>
                                    <tr>                                       
                                        <th width="auto" style="visibility:hidden;display:none;"><div>#</div></th>
                                        <th width="auto"><div>Day</div></th>

                                       <?php

                                                 $timeslots = array();
											     $start_date = "08:00";   
											     $end_date = "16:00";
											       $dbsettings =  $this->db->get_where('timetable_settings', array(
											            'school_id' => $this->session->userdata('school_id')
											        ))->result_array(); 

											       if(count($dbsettings)){
											        $start_date = date('H:i',strtotime($dbsettings[0]["start_time"]));
											        $end_date = date('H:i',strtotime($dbsettings[0]["end_time"])); 
											       }       
											       $hashortbreak = 0;
											        $begin = new DateTime( $start_date );
											        $end = new DateTime(date("H:i",strtotime("+1 minutes", strtotime($end_date))));
											        while($begin < $end) {
											            $period[] = $begin->format('H:i');
											            $begin->modify('+30 minutes');
											        }
											        for ($j = 0 ;$j <= count($period)-1 ; $j++){ 											        
											            $timeslots[] = date("H:i", strtotime('+30 minutes', strtotime($period[$j])));// $period[$j]; 
											            echo '<th width="auto"><div style="font-size:9px;text-align:center;">'. $period[$j] ."-".date("H:i", strtotime('+30 minutes', strtotime($period[$j]))).'</div></th>';
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

        var term = $("#term").val();
        var st= $("#section_holder").val();
        var fr = $('#class_id').val(); 
        var yr = $('#year').val();
        var exm =  $('#examtype').val(); 

       // var tmstring = <?php echo json_encode($timeslots , JSON_FORCE_OBJECT ) ?>;
       // tslots = JSON.stringify({ "datas": tmstring });                  

            if( term =="" || fr=="" || st ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");
                showAjaxModal('<?php echo base_url();?>modal/popupcustom/modal_add_exam_timetable/'+st+'/'+term+'/'+fr+'/'+yr+"/"+exm);
            }  
    }



    function loadTimeTable(){

        var term = $("#term").val();
        var st= $("#section_holder").val();
        var fr = $('#class_id').val(); 
        var yr = $('#year').val(); 
        var exm =  $('#examtype').val();

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
        if(exm == "") exm =0;


        $.ajax({
            type: 'POST',
            url: "fetchexamtimetable/"+yr+"/"+term+"/"+fr+"/"+st+"/"+exm,
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
                           /* if(item.subject[j].timeslotype != ""){ 
                              lsnData  = '<td class="breakcolumn"><span style="padding-top:15%;border-radius:10%;background:#c86814;color:white;font-size: 12px;font-weight: bolder;width:100%;height:60px;display:inline-block;text-align:center;">'+item.subject[j].timeslotype+'</span></td>';
                            }else{
                              lsnData  = '<td>'+item.subject[j].displayString+'</td>';  
                            }*/

                                lsnData  = '<td>'+item.subject[j].displayString+'</td>'; 
                                                         
                                
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



    function generatePDF(pdftype){

            var term = $("#term").val();
            var st= $("#section_holder").val();
            var fr = $('#class_id').val(); 
            var yr = $('#year').val(); 
            var exm =  $('#examtype').val();

            if( term =="" || st=="" || fr =="" || yr =="" || exm ==""){
                $("#alert").slideDown("slow");                    
            } else{
                $("#alert").slideUp("slow");

                    //url = "t_pdf/"+tr+"/null/"+yr+"/"+term+"/"+pdftype;

                     url = "t_pdf/"+fr+"/"+st+"/"+yr+"/"+term+"/"+pdftype+"/"+exm;

                    switch(pdftype){
                      case "exam":
                       var win = window.open(url, '_blank');
                       win.focus();
                      break;
                    }              

            }  
          
    }


    $(document).ready(function() {

    });

</script>





