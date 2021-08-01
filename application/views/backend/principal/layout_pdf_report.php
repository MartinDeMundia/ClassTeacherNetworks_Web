<?php $querylayout = $this->db->get_where('class_layout_places', array('layout_id' =>  $layout_id))->result_array(); //->order_by('student_id', 'DESC')?>
<title><?php echo  $classname ;?></title>
<div class="table-responsive">
    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10">
        <tr width="100%">
            <!--<td width="25%" style='background-color:#073350 !important'><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100px"/></td>	-->
            <td width="25%" style='background:none !important;'><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" width="100px"/></td>
            <td align="right"><img class="health_logo_1" src="<?php echo base_url('/assets/images/pdf_logo/layout.png');?>" />
        </tr>
    </table>
    <br>
    <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>

    <div style="float:left;width:48%;padding-right:10px;">
        <table width="100%" class="table table-hover tablesorter" cellspacing="2" cellpadding="5">
            <tr width="100%">
                <td width="100%">
                    <table class="name_details_health" width="100%" border="1" cellpadding="2" cellspacing="5" style="border-collapse:collapse;">
                        <tr   width="100%">
                            <td width="" align="left" class="left_side">Class</td> <td width="100%"><?php echo  $classname ;?></td>
                        </tr>
                        <tr  width="100%">
                            <td width="" align="left" class="left_side">Class Teacher </td> <td width="100%"><?php echo $teachername;?>	</td>
                        </tr>
                        <tr   width="100%">
                            <td width="" align="left" class="left_side">Class Number</td> <td width="100%"><?php echo count($querylayout );?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div style="float:left;width:50%;">
    </div>
    <br>
    <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>


    <div style="float:left;width:100%;clear:both;"></div>

    <?php

    $htmltable = "<table border='2' width=\"100%\" class=\"table table-hover tablesorter\">";
    $tdcnt = 1;
    $classColumns = 4;
    foreach($querylayout as $layout) {
        if(($tdcnt == 1)){
            $htmltable .= "<tr style='border:20px;'>";
        }
        if ($tdcnt <= $classColumns) {
            if($layout['student_id'] > 0){
                $student = $this->db->get_where('student' , array('student_id' =>$layout['student_id']))->row();
                $img = '<img class="health_logo" style="width:20px;height:20px;" src=" '.base_url('/assets/images/personblack.png').'" >('.$student->name .')</image>';
            }else{
                $img = '<img class="health_logo" style="width:20px;height:20px;" src=" '.base_url('/assets/images/personwhite.png').'" ></image>';;
            }
            $htmltable .= "<td>" . $img  . "</td>";
        }
        if(($tdcnt == $classColumns)){
            $htmltable .= "</tr>";
            $tdcnt = 0;
        }
        $tdcnt++;
    }
    $htmltable .= "</table>";
    print($htmltable);
     ?>
</div>

<footer>


    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10" style="border-top:1px solid #14a79d;">

        <tr width="100%">

            <td><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>
            <td align="right"><span> <?php echo date('d M Y');?></span>
        </tr>
    </table>
</footer>


<style type="text/css">

</style>