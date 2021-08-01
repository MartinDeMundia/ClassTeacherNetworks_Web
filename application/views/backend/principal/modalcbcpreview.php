<?php 
  $class = $param2;
?>
<!DOCTYPE html>
<script src="http://apps.classteacher.school/assets/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="http://apps.classteacher.school/assets/js/select2/select2-bootstrap.css">
<script src="http://apps.classteacher.school/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="http://apps.classteacher.school/assets/js/bootstrap.js"></script>
<style type="text/css">

table, th, td {
  border: 0.1em solid black; font-size:26px;
}
</style>
<div class="row">
	<div class="col-md-12">	


	</div>
</div>

<?php
       $qryDataMain = "
                SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class." ORDER BY sort ASC                     
        ";                                                       
        $queryDataMain = $this->db->query($qryDataMain)->result_array();
        foreach($queryDataMain as $rowDataMain){ 

                echo '<table id="" style="border: none !important;width:100%;margin: 0px auto;" border="0" >';
                echo '<thead>';
                echo '<tr style="border: none !important;">';
                  echo '<th style="width:100%;text-align:center;border: none !important;" ><div style="font-size:35px;text-decoration: underline;"><b>'.strtoupper($rowDataMain["topic_title"]).'</b></div></th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                    echo '<tr>'; 
                      echo '<td style="text-align:center;border: none !important;">
                      <div style="font-size:0.5em; height:100px;margin-bottom:300px;">&nbsp;</div>
                      <b>KEY:</b>(<b>EX</b> - Exceeding expectations , <b>MT</b> - Meets expectations ,<b>AP</b> - Approaches expectation , <b>BE</b> - Below expectation)</td>';
                    echo '</tr>';
                echo '</tbody>';
                echo '</table>';

?>
              <div style="font-size:4em; height:100px;margin-bottom:300px;">&nbsp;</div>
               <table  class="table table-bordered datatable" id="table_export" style="width:100%;margin-top:100px;" >
                    <thead>
                        <tr style="">
                    	   <th style="width:5%;" ><div></div></th>
                           <th style="width:35%;text-align:left;"><div style='text-align:center;'><b>Tick appropriately under each category to rate learner's ability</b></div></th>
                           <th style="width:8%;text-align:center;"><div><b>EX</b></div></th>
                           <th style="width:8%;text-align:center;"><div><b>MT</b></div></th>
                           <th style="width:8%;text-align:center;"><div><b>AP</b></div></th>
                           <th style="width:8%;text-align:center;"><div><b>BE</b></div></th>
                           <th style="width:28%;text-align:center;"><div><b>COMMENT</b></div></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
               $qryData = "
                        SELECT * FROM cbc_report_design WHERE (parent is NULL || parent = 0 ) AND class = ".$class." ORDER BY sort ASC                     
                ";                                                       
                $queryData = $this->db->query($qryData)->result_array();           
                       $sqlcbchild1 = "
                             SELECT * FROM cbc_report_design WHERE parent = '".$rowDataMain["id"]."' ORDER BY sort ASC
                            ";
                       $queryData1 = $this->db->query($sqlcbchild1)->result_array();
                       foreach ($queryData1 as $key => $dbvalue1){
                                        echo '<tr>';
                                        echo '<td style="text-align:left;width:5%;"><b>'.$dbvalue1["topic_number"].'</b></td>';
                                        echo '<td style="text-align:left;width:35%;"><b>'.$dbvalue1["topic_title"].'</b></td>';
                                        echo '<td style="text-align:left;width:8%;"></td>';
                                        echo '<td style="text-align:left;width:8%;"></td>';
                                        echo '<td style="text-align:left;width:8%;"></td>';
                                        echo '<td style="text-align:left;width:8%;"></td>';
                                        echo '<td style="text-align:left;width:28%;"></td>';
                                        echo '</tr>';
                                        // inner
                                   $sqlcbchild2 = "
                                         SELECT * FROM cbc_report_design WHERE parent = '".$dbvalue1["id"]."' ORDER BY sort ASC
                                        ";
                                       $queryData2 = $this->db->query($sqlcbchild2)->result_array();
                                       foreach ($queryData2 as $key => $dbvalue2){

                                                echo '<tr>';
                                                echo '<td style="text-align:left;width:5%;"><b>'.$dbvalue2["topic_number"].'</b></td>';
                                                echo '<td style="text-align:left;width:35%;">'.$dbvalue2["topic_title"].'</td>';
                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                echo '<td style="text-align:left;width:28%;"></td>';
                                                echo '</tr>';


                                        $sqlcbchild3 = "
                                                       SELECT * FROM cbc_report_design WHERE parent = '".$dbvalue2["id"]."' ORDER BY sort ASC
                                                        ";
                                                       $queryData3 = $this->db->query($sqlcbchild3)->result_array();                                                        
                                                        foreach ($queryData3 as $key => $dbvalue3){
                                                                echo '<tr>';
                                                                echo '<td style="text-align:left;width:5%;"><b>'.$dbvalue3["topic_number"].'</b></td>';
                                                                echo '<td style="text-align:left;width:35%;">'.$dbvalue3["topic_title"].'</td>';
                                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                                echo '<td style="text-align:left;width:8%;"></td>';
                                                                echo '<td style="text-align:left;width:28%;"></td>';
                                                                echo '</tr>';
                                                           }




                                       }


                       }
                
?>
                    </tbody>

                </table>

<?php
echo '<br pagebreak="true"/>';
}
?>

<?php
 $this->load->library('Pdftc');


class MYPDF extends TCPDF {    
    public function Footer() {  
        // Position at 15 mm from bottom
        $this->SetY(-15);     
        $this->SetFont('helvetica', 'I', 8);     
        $uri = $_SERVER['REQUEST_URI'];
        $parr = explode("/",$uri);
        if(count($parr) > 0 ){
            $pgNo = end($parr);
        }else{
            $pgNo = "GE";
        }
        $this->Cell(0, 10, 'Class ['.$pgNo.'] , Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}




	$content = ob_get_contents();  //exit(); 
	$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('CBC REPORT PREVIEW');  
    $pdf->SetHeaderData('CBC REPORT PREVIEW', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(5, '5', 5);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(true);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 7);  
    $pdf->AddPage();
    ob_end_clean();
    $pdf->writeHTML($content);
    ob_clean();
    $filename = "CBC Report Preview.pdf";
    $file = $_SERVER['DOCUMENT_ROOT'] . "/uploads/cbc reports/".$filename;	

    $pdf->Output($file, 'I');		
?>