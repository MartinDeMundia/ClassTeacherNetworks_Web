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
td {
    border: 0 !important;
}
</style>
<?php

    $term = urldecode($term );
    $ci =& get_instance();
    $school_id = $ci->session->userdata('school_id'); 


   $school_image = $this->crud_model->get_image_url('school',$school_id);
   $logo =  ($school_image !='')?$school_image:base_url('/uploads/logo.png');
   $logo = file_get_contents($logo);
   $binary = imagecreatefromstring($logo);
   $target_dir = "uploads/logoPNG.png";                 
   ImagePNG($binary, $target_dir);
   $logo = base_url($target_dir); 

   $name=$this->db->get_where("school", array('school_id'=>$school_id))->row()->school_name;
   $class=$this->db->get_where("class", array('class_id'=>(int)$class_id))->row()->name;
   $section=$this->db->get_where("section", array('section_id'=>(int)$section_id))->row()->name;


  $sectioname =  $ci->db->get_where('section', array(
      'section_id' => $section_id
  ))->row()->name;

  $sectioname = substr($sectioname, 0, 1);


   function toNum($data) {
        $data = strtolower($data);
        $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                           'f', 'g', 'h', 'i', 'j',
                           'k', 'l', 'm', 'n', 'o',
                           'p', 'q', 'r', 's', 't',
                           'u', 'v', 'w', 'x', 'y',
                           'z'
                           );
        $alpha_flip = array_flip($alphabet);
        $return_value = -1;
        $length = strlen($data);
        for ($i = 0; $i < $length; $i++) {
            $return_value +=
                ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
        }
        return $return_value;
    }
  function fetchtimetablelesson($year,$term,$class_id,$section_id,$day,$starttime,$endtime){
        ini_set('memory_limit','-1');
       $ci =& get_instance();
       $school_id = $ci->session->userdata('school_id'); //$ci->session->userdata('school_id')
       $bool = 0;


       $dbsettings =  $ci->db->get_where('timetable_settings', array(
            'school_id' => $school_id
        ))->result_array();

        $shortbreak = date('H:i',strtotime($dbsettings[0]["short_break_startime"]));
        $teabreak =   date('H:i',strtotime($dbsettings[0]["tea_break_startime"]));
        $lunchbreak = date('H:i',strtotime($dbsettings[0]["lunch_break_startime"])); 
        $timeslotype = "";
        switch($starttime){
            case $shortbreak : $timeslotype = "Short Break"; break;
            case $teabreak : $timeslotype = "Tea Break"; break;
            case $lunchbreak : $timeslotype = "Lunch Break"; break;
            default: $timeslotype = ""; break;
        }

        $sqlsearch = "
            SELECT 
                t.venue,
                s.subject,
                s.id,
                te.name teacher
            FROM
            timetable t 
            LEFT JOIN class_subjects s ON t.subject = s.id
            LEFT JOIN teacher te ON te.teacher_id = t.teacher
            WHERE tslots = '".$starttime.'-'.$endtime."'
            AND t.class_id =  '".(int)$class_id."'
            AND t.section_id = '".(int)$section_id."' 
            AND t.day = '".$day."' 
            AND t.term ='".urldecode($term)."' 
            AND t.year='".urldecode($year)."'
            AND t.school ='".$school_id."'
        ";

        $queryData = $ci->db->query($sqlsearch)->result_array(); 

            $venue = "";
            $lesson = "";
            $teachersname = "";
            $teachersbox = "";
        if(count($queryData)){
            $venue = $queryData[0]["venue"];
            $lesson = $queryData[0]["subject"];
            $lessoncode = $queryData[0]["id"];
            $lsnarray = explode(" ", $lesson);
            $lesson = $lsnarray[0]; 

            $teachersname = "Tr.".$queryData[0]["teacher"];
            $teachersbox = "<span style='font-size:7px;float:right;display:inline list-item !important; text-align:right;'>".$teachersname."</span>";
             $bool = 1;
        }

        $lesonday =  $day;
        $lessonStart = $starttime;
        $lessonend =  $endtime ;

        $venueboxcolor =  '#' . substr(md5(toNum($lesson)), 0, 6);
        $lessonbox = "<span style='font-size:9px;font-weight:900;'>".substr( $lesson, 0, 4)."".$lessoncode."</span>";
        $displayString = '<div style="width:40px;height:78px;"> <div style="background-color:#E5E8F1;color:brown;font-size:1.4em;">'.$lessonbox.'</div>
        <div stroke="0.5" fill="false" strokecolor="orange" color="orange" style="font-family:helvetica;font-weight:bold;font-size:5em;background-color:'.$venueboxcolor.';text-align:center;">'.$venue.'</div>
        <div style="font-family:helvetica;font-weight:bold;font-size:1.1em;float:right">'.$teachersbox.'</div></div>
        ';

       // $displayString = $sqlsearch; 

        return array("timeslotype"=>$timeslotype,"venue"=>$venue,"lesonday"=>$lesonday,"lessonStart"=>$lessonStart,"lessonend"=>$lessonend,"displayString"=>$displayString,"bool"=>$bool);
        }  






?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="<?php echo base_url('assets/dmultiselect/docs/css/bootstrap-3.3.2.min.css');?>" rel="stylesheet"> 
<link href="<?php echo base_url('assets/dmultiselect/docs/css/bootstrap-example.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('assets/dmultiselect/docs/css/prettify.min.css');?>" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/tableExport.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/jquery.base64.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/html2canvas.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/sprintf.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/jspdf.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tableexport/base64.js');?>"></script>
<title>School Timetable</title>


<div style="float:right;"> 
      <button onClick ="downloadTimetable(this);" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                   <span class="glyphicon glyphicon-download"></span> Download
                 
      </button>
</div>
<table cellspacing="0" border="0" class="" id="table_export" style="margin:0px auto;width:100%;border:0px !important;" align="left">
<tr style="border:0 !important"><td halign="left" colspan="2"  ><img style="width:70px;height:70px;" src="<?php  echo $logo; ?>" alt="Italian Trulli">    </td><td></td><td></td></tr>
<tr><td colspan="2" style="font-family:helvetica;font-weight:bold;"><?=$name;?></td><td></td><td></td></tr>
<tr><td colspan="2" style="font-family:helvetica;font-weight:bold;">School Timetable</td><td></td><td></td><hr></tr>
<tr><td colspan="2" ><hr></td><td></td><td width="200"><span style="font-size:2em;"></span></td></tr>
<!-- <tr><td colspan="2" style="font-family:helvetica;font-weight:bold;"><?=$section;?></td><td></td><td></td></tr> -->
<!-- <tr><td colspan="2" ><hr></td><td></td><td width="200"><span style="font-size:2em;"><?=$day;?></span></td></tr> -->
</table>
<?php
  $days = array("Monday","Tuesday","Wednesday","Thursday","Friday");
  $respArray = array();
  $respArrayAll = array();

 $headersize ="0.6em";
 $headerwidth ="15px";
 $firstcolumnwidth = "21px"; 

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
'school_id' => $school_id
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






?>
  



<table border="0.01" class="table table-bordered datatable" id="table_export" style="margin:0px auto;width:100%" align="center">
<thead>
 <tr>
<?php 
        print('<th style="width:20px;font-size:0.6em;">Class</th>');
           foreach ($days as $key => $day) {
        print('<th style="font-size:1.3em;text-align:center;background:#12449A;color:white;font-weight:900;">'.$day.'');
?>



                    <table border="0.01" class="table table-bordered datatable" id="table_export" style="margin:0px auto;width:100%" align="center"> 
                    <thead>
                    <?php

                                             $timeslots = array();

                                             $lsbegin = date_create($period[0])->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                             $lesnend =  $lsbegin->format('H:i'); 

                                             $timeslots[] =   array($period[0],$lesnend);
                                             echo '<th style="width:'.$headerwidth.';background:#C6DCED;color:black;"><div style="font-size:'.$headersize.'">'. $period[0] .'<br>'.$lesnend.'</div></th>';
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

                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($shortbreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $shortbreakend ;
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }
                                                    if($teabreak  == $sTime ){
                                                              $sTBreak = date_create($sTime)->add(date_interval_create_from_date_string($teabreakduration.' minutes')); 
                                                              $teabreakend =  $sTBreak->format('H:i');  
                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($teabreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $teabreakend ;
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }

                                                    if($lunchbreak  == $sTime ){
                                                              $sTBreak = date_create($sTime)->add(date_interval_create_from_date_string($lunchbreakbreakduration.' minutes')); 
                                                              $lunchbreakend =  $sTBreak->format('H:i'); 
                                                              $lend = date_create($lsnend)->add(date_interval_create_from_date_string($lunchbreakbreakduration.' minutes')); 
                                                              $lsnend =  $lend->format('H:i');
                                                              $lsnend = $lunchbreakend ; 
                                                              $sTime = $period[$j + 1] = $lsnend;
                                                    }

                                                    if($sTime == $lsnend ){
                                                            $lsbegin = date_create($lsnend)->add(date_interval_create_from_date_string($lessonperiod_in_minutes.' minutes')); 
                                                            $lesnend =  $lsbegin->format('H:i');
                                                            $timeslots[] =   array($lsnend,$lesnend);
                                                      echo '<th style="width:'.$headerwidth.';background:#C6DCED;color:black;"><div style="font-size:'.$headersize.'">'. $lsnend .'<br>'.$lesnend.'</div></th>';
                                                      $i=0;
                                                      $sTime = $period[$j + 1] = $lsnend;
                                                     }        

                                                   if( $sTime == date('H:i',strtotime($end_date))){
                                                    break;
                                                   }   

                                                 $i ++;
                                                }

                     ?>
                    </thead> 

                    <tbody>                   
                    </tbody>
                    </table>


<?php



        print('</th>');
   }
?>
</tr>
</thead>
<tbody>

<?php
  $sqlstream = "
  SELECT 
  * FROM section s 
  WHERE s.class_id 
  IN (SELECT class_id FROM class WHERE school_id = '".$school_id."') 
  AND s.name 
  ORDER BY s.name ASC;
  ";

 $firstcolumnwidth ="15px;";
  $queryDataStream = $ci->db->query($sqlstream)->result_array();
     foreach ($queryDataStream as $key => $streamName) {
  ?>
  <tr>
    <?php 
 
      echo '<td style="width:'.$firstcolumnwidth.';height:auto;background:#12449A;color:white;font-size:0.25em;"><span style="font-size:5.2pt !important;">'.trim($streamName['nick_name']).'</span><div stroke="0.1" fill="true" strokecolor="green" color="#94A3C2" style="font-family:helvetica;font-weight:bold;font-size:4.0em;">'.$streamName['name'].'</div></td>';
      foreach ($days as $key => $day) {
        print('<td>');
        ?>


                    <table border="0.01" class="table table-bordered datatable" id="table_export" style="margin:0px auto;width:100%" align="center"> 
                    <thead>
                   
                    </thead>  

                    <tbody>
                      <tr> 
                            <?php

                                   foreach ($timeslots  as $key => $timeslot) { 
                                          $responseArray = fetchtimetablelesson($year,$term,$streamName['class_id'],$streamName['section_id'],$day,$timeslot[0],$timeslot[1]);
                                          $dispStr =  $responseArray['displayString'];
                                          print('<td style="font-size:0.3em;border: solid 0.06pt !important;border-color: #084df0 !important;">'.$dispStr.'</td>');
                                   }
                              
                            ?>
                    </tr>
                    </tbody>
                    </table>

     <?php
       print('</td>');
      }
      ?>
  </tr>

  <?php
   }
  ?>
</tbody>
</table>

<script>

 function downloadTimetable(obj){
  $( obj ).hide();
 var container = document.body; // full page 
 html2canvas(container).then(function(canvas) {
                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "School time table.png";
                link.href = canvas.toDataURL("image/png");
                link.target = '_blank';
                link.click();
                $( obj ).show();
            });
 } 
$(window).load(function(){

/*
 var container = document.body; // full page 
 html2canvas(container).then(function(canvas) {
                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "html_image.png";
                link.href = canvas.toDataURL("image/png");
                link.target = '_blank';
                link.click();
            });



*/


//$('#table_export').tableExport({type:'png',escape:'true'});
});


  </script>





<?php
exit();
?>
