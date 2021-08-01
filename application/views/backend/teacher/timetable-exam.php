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
   $class =$this->db->get_where("class", array('class_id'=>(int)$class_id))->row()->name;
   $section =$this->db->get_where("section", array('section_id'=>(int)$section_id))->row()->name;
   $examination=$this->db->get_where("exams", array('id'=>(int)$exam))->row()->Term1; 


  $headersbackground ="#0075C0;"; 
  $headertcolor = "white;font-weight:900;";


  $bheadersbackground ="#D05B31;";
  $bheadertcolor = "white;";
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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


<link rel="stylesheet" href="http://elitebook.coreict.classteacher/assets/js/datatables/responsive/css/datatables.responsive.css">
<script src="http://elitebook.coreict.classteacher/assets/js/jquery.dataTables.min.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/datatables/TableTools.min.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/dataTables.bootstrap.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/datatables/lodash.min.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/datatables/responsive/js/datatables.responsive.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/select2/select2.min.js"></script>
<script src="http://elitebook.coreict.classteacher/assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>


<table cellspacing="0" border="0" class="table table-bordered datatable" id="table_export" style="margin:0px auto;width:50%" align="center">
<tr><td halign="left" colspan="2" ><img style="width:70px;height:70px;" src="<?php  echo $logo; ?>" alt="Italian Trulli">    </td><td></td><td></td></tr>
<tr><td colspan="2" style="font-family:helvetica;font-weight:bold;"><?=$name;?></td><td></td><td></td></tr>
<tr><td colspan="2" style="font-family:helvetica;font-weight:bold;"><?=$class;?></td><td></td><td></td></tr>
<tr><td colspan="2" style="font-family:helvetica;font-weight:bold;"><?=$section;?></td><td></td><td></td></tr>
<tr><td colspan="2" style="font-family:helvetica;font-weight:bold;"><?=$examination;?> ,<?=$term;?> , <?=$year;?></td><td></td><td></td></tr>
<tr><td colspan="2" ><hr></td><td></td><td></td></tr>
</table>



<table border="0.01" class="table table-bordered datatable" id="table_export" style="margin:0px auto;width:100%" align="center">
<thead>
<tr>
<?php $headersize ="24px;"; ?> 
<th style="visibility:hidden;display:none;"><div>#</div></th>
<th style="background-color:<?=$headersbackground ; ?>color:<?=$bheadertcolor ; ?> font-size:<?=$headersize+0.2;?> ; width:90px;"><div>Day</div></th>

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
                                                echo '<th style="background-color:'.  $headersbackground.' color:'. $bheadertcolor.'"><div style="font-size:20px;text-align:center;">'. $period[$j] ."<br>to<br>".date("H:i", strtotime('+30 minutes', strtotime($period[$j]))).'</div></th>';
                                           }

                                       ?> 

</tr>
</thead>
<tbody> 

<?php

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



    function fetchtimetablelesson($year,$term,$class_id,$section_id,$day,$examtime,$exam){
   
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

        $startAbs = date("H:i", strtotime('-30 minutes', strtotime($examtime)));

        $sqlsearch = "
          SELECT
            t.unitcode, 
            t.venue,
            s.subject,
            s.id,
            t.starttime,
            t.endtime,
            t.day
          FROM
          timetable_exam t 
          LEFT JOIN class_subjects s ON t.subject = s.id
      
          WHERE 
          t.class_id =  '".(int)$class_id."' 
          AND t.section_id = '".(int)$section_id."' 
          AND t.day = '".$day."' 
          AND t.term ='".urldecode($term)."' 
          AND t.year='".urldecode($year)."'
          AND t.school ='".$school_id."' AND t.exam = '".$exam."'

          AND t.starttime <= '".$startAbs."' 
        ";

        $queryData = $ci->db->query($sqlsearch)->result_array();

        $venue = "";
        $lesson = "";
        $teachersname = "";
        $teachersbox = "";

        $examStart = "";
        $examEnd = "";
        $examday = "";
        $exam = "";
    

        if(count($queryData)){
            $venue = $queryData[0]["venue"];
            $lesson = $queryData[0]["subject"];
            $lsnarray = explode(" ", $lesson);
            $lesson = $lsnarray[0]; 

            $teachersname = "* Tr.".$queryData[0]["teacher"];
            $teachersbox = "<span style='font-size:7px;float:right;display:inline list-item !important; text-align:right;'>".$teachersname."</span>";
            $bool = 1;
        }

        $lesonday =  $day;
        $lessonStart = $starttime;
        $lessonend =  $endtime ;

        $venueboxcolor =  '#' . substr(md5(toNum($lesson)), 0, 6);
        $lessonbox = "<span style='font-size:8px;'>".$lesson."</span>";

      if(count($queryData)){  

            $absoluteend = date("H:i", strtotime('+30 minutes', strtotime($examEnd)));   
      
         foreach ($queryData as $key => $dbvalue) {     
         
                if( $examtime <=  date("H:i", strtotime('+30 minutes', strtotime($dbvalue["endtime"])))){  

                $examStart = $dbvalue["starttime"];
                $examEnd = $dbvalue["endtime"];
                $exam = $dbvalue["unitcode"];
                $venue = $dbvalue["venue"];

                $lesonday =  $day;
                $lessonStart = $starttime;
                $lessonend =  $endtime ;
                $venueboxcolor =  '#' . substr(md5(toNum($exam)), 0, 6);
                $examStart = date('H:i',strtotime($examStart));
                $examEnd = date('H:i',strtotime($examEnd));

                   $absoluteend = date("H:i", strtotime('+30 minutes', strtotime($examEnd)));
    
                 if(  date("H:i", strtotime('-30 minutes', strtotime($examtime)))  < date("H:i", strtotime('+30 minutes', strtotime($examStart))) ){ 
                     $teachersbox = "<span style='font-size:7px;float:right;display:inline list-item !important; text-align:right;'>START<br><span>".$dbvalue["starttime"]."</span></span>";         
                 }else{
                     $teachersbox = "<span style='font-size:7px;float:right;display:inline !important; text-align:right;'><span>&nbsp;<br>".$examtime."</span></span>";
                 }


                 if($examEnd < date("H:i", strtotime('0 minutes', strtotime($examtime)))){
                  $teachersbox = "<span style='font-size:7px;float:left;display:inline list-item !important; text-align:right;'>END<br><span>".$dbvalue["endtime"]."</span></span>";
                 }

                $lessonbox = "<span style='font-size:8px;'>".$exam."</span>";
                $venuebox  = "<span style='font-size:12px;text-align:center;width:100%;color:white;background:".$venueboxcolor.";display:inline-block;margin:0px;'>".$venue."</span>";
               
                $displayString  = '<div style="height:10px;background-color:#E5E8F1;color:brown;width:100vh;font-size:1.4em;padding-top20px;">'.$lessonbox.'</div>';
                $displayString .= '<div stroke="0.3" fill="false" strokecolor="orange" color="orange" style="font-family:helvetica;font-weight:bold;font-size:3em;background-color:'.$venueboxcolor.';">'.$venuebox.'</div>';
                $displayString .= '<div style="font-family:helvetica;font-weight:bold;font-size:1.1em;float:right">'.$teachersbox.'</div>';


               }
            
         }

      }   
        return array("timeslotype"=>$timeslotype,"venue"=>$venue,"lesonday"=>$lesonday,"lessonStart"=>$lessonStart,"lessonend"=>$lessonend,"displayString"=>$displayString,"bool"=>$bool);
    }  




        $days = array("Monday","Tuesday","Wednesday","Thursday","Friday");
        $respArray = array();
        $respArrayAll = array();
        foreach ($days as $key => $day) {
          echo '<tr>';
            echo '<td style="visibility:hidden;display:none;"></td>';
            echo '<td style="width:90px;height:60px; background-color:'.  $headersbackground.' color:'. $bheadertcolor.'">'.trim($day).'<div stroke="0.5" fill="true" strokecolor="grey" color="#94A3C2" style="font-family:helvetica;font-weight:bold;font-size:3em;">'.substr($day, 0, 1).'</div>

            </td>';

                   foreach ($timeslots as $key => $timeslot) {                      
                         $timeslotArray = fetchtimetablelesson($year,$term,$class_id,$section_id,$day,$timeslot,$exam);
                      
                                if($timeslotArray['bool'] == 1) {
                                    print('<td style="font-size:16px;font-weight: bolder;display:inline-block;text-align:center;">'.$timeslotArray['displayString'].'</td>');
                                }else{
                                    $venueboxcolor ='#000000';
                                    print('<td> </td>');
                                }
                   }

          echo ' </tr>';
        }

?>  

</tbody>
</table>

    