<?php
error_reporting(0);
ini_set('upload_max_filesize', 2000);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admindebug extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
              $this->load->library('Pdftc');
        $this->load->library('session');
        $this->load->model('Barcode_model');
        $this->load->helper('form');

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        //if ($this->session->userdata('admin_login') != 1) $this->clearsess();
    }

    function createreportimage(){
        $dataUrl  = $this->input->post('dataUrl');
        $studentid  = $this->input->post('studentid');
        $data = explode(',', $dataUrl);
        $content = base64_decode($data[1]);
       $output_file = "assets/graphs/".$studentid.".png";   
       $file = fopen($output_file, "wb")or die("Can't create file");
        if ( !$file ) {
           throw new Exception('File open failed.');
        }
       fwrite($file, $content);
       fclose($file);      
      echo json_encode(array("response"=>"/".$output_file));
    }

    function getcontentHTMLURL(){

    $homepage = file_get_contents('http://apps.classteacher.school/admindebug/creategrapghImage');
    echo $homepage;



    }




    function creategrapghImage(){
          
        print('<link href="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/bootstrap.min.css" rel="stylesheet">');
        print('<link href="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/style.css" rel="stylesheet">');
        print('<link href="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/font-awesome/css/font-awesome.min.css" rel="stylesheet">');
        print('<script src="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/js/jquery-1.12.4.min.js"></script>');
        print('<script src="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/js/bootstrap.min.js"></script>');
        print('<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>');


        print('<div id="chartContainer"></div>');
        print('<img id="chartImage" width="100%" height="360px">');

               $qryData = "
                        SELECT
                        now() as generateddate,  
                        s.student_id,s.name,s.sex,s.date_of_admission,sch.school_id,sch.school_name, sch.logo,s.student_code,
                        sch.website,sch.email,sch.address,sch.telephone,now() as tdate, e.class_id,c.name classname, 
                        epf.subject,mark,(
                        SELECT name FROM grade g WHERE mark >= g.mark_from AND mark <=  g.mark_upto AND g.school_id = sch.school_id
                        ) grade,
                        (
                        SELECT comment FROM grade g WHERE mark >= g.mark_from AND mark <=  g.mark_upto AND g.school_id = sch.school_id
                        ) gradecomment,
                        rank
                        FROM student s 
                        JOIN school sch ON sch.school_id = s.school_id 
                        JOIN enroll e ON e.student_id = s.student_id 
                        JOIN class c ON c. class_id = e.class_id 
                        LEFT JOIN exam_processing_final epf ON epf.student_id = s.student_id  AND epf.exam ='Term 3 Evaluation 1' and epf.year='2019'
                        WHERE s.student_id ='4519'   
                ";                                                       
                $queryData = $this->db->query($qryData)->result_array();

                $dataPoints_1 = array();
                $names = ""; 
                $studentid = 0;
                foreach($queryData as $rowExamsData){   
                   $dataPoints_1 [] = array("y" =>$rowExamsData['mark'], "label" =>$rowExamsData['subject'] , "indexLabel"=>$rowExamsData['grade']);
                   $names = $rowExamsData['name'] ; 
                   $studentid = $rowExamsData['student_id']; 
                }  
        
        print('<script type="text/javascript">');
        print('window.onload = function () {     chart = new CanvasJS.Chart("chartContainer", {animationEnabled: false,theme: "light1", title:{ text: "Performance for '.$names.'"},axisY: {title: "Mean Marks Attained"},data: [{type: "column",showInLegend: true,legendMarkerColor: "grey",legendText: "1 Unit = one mean mark",dataPoints:'.json_encode($dataPoints_1, JSON_NUMERIC_CHECK).'}]});chart.render(); var base64Image = chart.canvas.toDataURL();document.getElementById("chartContainer").style.display = "none";document.getElementById("chartImage").src = base64Image;       '); 
/*     ob_start(); 
       // $dataUrl = print(' eval(document.write( chart.canvas.toDataURL()));');        
        $dataUrl=ob_get_contents(); 
        ob_end_clean();*/
        print(' }</script>');
/*       
var_dump($dataUrl ); //exit();

        $studentid  = 1234;
        $data = explode(',', $dataUrl);
        $content = base64_decode($data[1]);
       $output_file = "assets/graphs/".$studentid.".png";   
       $file = fopen($output_file, "wb")or die("Can't create file");
        if ( !$file ) {
           throw new Exception('File open failed.');
        }
       fwrite($file, $content);
       fclose($file);      

       echo json_encode(array("response"=>"/".$output_file));

        //echo  $var ;*/
        
    }


















    function creategrapghImage1(){
        print('<link href="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/bootstrap.min.css" rel="stylesheet">');
        print('<link href="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/style.css" rel="stylesheet">');
        print('<link href="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/font-awesome/css/font-awesome.min.css" rel="stylesheet">');
        print('<script src="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/js/jquery-1.12.4.min.js"></script>');
        print('<script src="http://'.$_SERVER['SERVER_NAME'].'/assets/canvas/js/bootstrap.min.js"></script>');
        print('<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>');


        print('<div id="chartContainer"></div>');

               $qryData = "
                        SELECT
                        now() as generateddate,  
                        s.student_id,s.name,s.sex,s.date_of_admission,sch.school_id,sch.school_name, sch.logo,s.student_code,
                        sch.website,sch.email,sch.address,sch.telephone,now() as tdate, e.class_id,c.name classname, 
                        epf.subject,mark,(
                        SELECT name FROM grade g WHERE mark >= g.mark_from AND mark <=  g.mark_upto AND g.school_id = sch.school_id
                        ) grade,
                        (
                        SELECT comment FROM grade g WHERE mark >= g.mark_from AND mark <=  g.mark_upto AND g.school_id = sch.school_id
                        ) gradecomment,
                        rank
                        FROM student s 
                        JOIN school sch ON sch.school_id = s.school_id 
                        JOIN enroll e ON e.student_id = s.student_id 
                        JOIN class c ON c. class_id = e.class_id 
                        LEFT JOIN exam_processing_final epf ON epf.student_id = s.student_id  AND epf.exam ='Term 3 Evaluation 1' and epf.year='2019'
                        WHERE s.student_id ='4519'   
                ";                                                       
                $queryData = $this->db->query($qryData)->result_array();

                $dataPoints_1 = array();
                $names = ""; 
                $studentid = 0;
                foreach($queryData as $rowExamsData){   
                   $dataPoints_1 [] = array("y" =>$rowExamsData['mark'], "label" =>$rowExamsData['subject'] , "indexLabel"=>$rowExamsData['grade']);
                   $names = $rowExamsData['name'] ; 
                   $studentid = $rowExamsData['student_id']; 
                }   


        print('<script type="text/javascript">');
        print('window.onload = function () {    var chart = new CanvasJS.Chart("chartContainer", {animationEnabled: false,theme: "light1", title:{ text: "Performance for '.$names.'"},axisY: {title: "Mean Marks Attained"},data: [{type: "column",showInLegend: true,legendMarkerColor: "grey",legendText: "1 Unit = one mean mark",dataPoints:'.json_encode($dataPoints_1, JSON_NUMERIC_CHECK).'}]});chart.render();    postVars={ "studentid":"'.$studentid .'","dataUrl": $("#chartContainer .canvasjs-chart-canvas").get(0).toDataURL() }; $.post("createreportimage",postVars,function(response){ window.location=response.response; },"json");                                     }');
        

        print('</script>');
    }


   function defaultexamexcal($stream = '' , $term = '' , $subject = '' , $exam = ''){
            $this->load->library('PHPExcel');
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->getProperties()->setCreator("Salland")
                                         ->setLastModifiedBy("Salland")
                                         ->setTitle("Office 2007 XLSX  Document")
                                         ->setSubject("Office 2007 XLSX ")
                                         ->setDescription("Export Quotation")
                                         ->setKeywords("office 2007 openxml php")
                                         ->setCategory("Exports");
                                                                      
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);  
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
                //header style
                     $styleArray_header = array(
                            'font' => array(
                                    'bold' => true,
                                    'color' => array(
                                            'rgb' => 'FFFFFF')
                            ),
                            
                            'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array(
                                            'rgb' => '#0000'
                                    )
                            )                  
                            
                    );
               //name style
                     $styleArray = array(
                          'font' => array(
                                    'bold' => true
                            ),
                            
                            'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array(
                                            'rgb' => 'E1E0F7'
                                    )
                            )
                            
                            
                    );
                     
            $num = 1;        
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $num  , 'Student ID');
            $objPHPExcel->getActiveSheet()->getStyle('A'. $num)->applyFromArray($styleArray_header); 
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $num , 'Names');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$num)->applyFromArray($styleArray_header);  
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $num  , 'Term');
            $objPHPExcel->getActiveSheet()->getStyle('C'.$num)->applyFromArray($styleArray_header); 
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $num  , 'Subject');
            $objPHPExcel->getActiveSheet()->getStyle('D'.$num)->applyFromArray($styleArray_header);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $num  , 'Exam');
            $objPHPExcel->getActiveSheet()->getStyle('E'.$num)->applyFromArray($styleArray_header); 
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $num  , 'Out Of');
            $objPHPExcel->getActiveSheet()->getStyle('F'.$num)->applyFromArray($styleArray_header); 
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $num  , 'Marks');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$num)->applyFromArray($styleArray_header);

           $subject_name = $this->db->get_where('subject' , array('subject_id' => $subject))->row()->name;

           $students   = $this->db->query('SELECT * FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.section_id = "'.$stream.'" AND school_id = "'.$this->session->userdata('school_id').'"')->result_array();

            foreach($students as $row){
              $num++; 
              $objPHPExcel->getActiveSheet()->setCellValue('A' .$num  ,$row['student_id']);
              $objPHPExcel->getActiveSheet()->setCellValue('B' .$num  ,$row['name']); 
              $objPHPExcel->getActiveSheet()->setCellValue('C' .$num  ,urldecode($term)); 
              $objPHPExcel->getActiveSheet()->setCellValue('D' .$num  ,$subject_name);
              $objPHPExcel->getActiveSheet()->setCellValue('E' .$num  ,urldecode($exam));
              $objPHPExcel->getActiveSheet()->setCellValue('F' .$num  ,"");
              $objPHPExcel->getActiveSheet()->setCellValue('G' .$num  ,"");
            }

            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
            $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
            $objDrawing->setName('PHPExcel logo');
            $objDrawing->setHeight(36);
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT); 
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $mydt=date('Y-m-d');
            $tabname='Exam Import Empty Excel';
            $objPHPExcel->getActiveSheet()->setTitle($tabname);
            $objPHPExcel->setActiveSheetIndex(0); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $filename = 'assets/examuploads/Exam Import Empty Excel.xls';
            $objWriter->save($filename);
            $Goto = "Location: http://apps.classteacher.school/".$filename;
            header($Goto); 
}
     






    function readUploadedExcel(){   
        $myexcelfile  = "./assets/examuploads/ExamUploadDefault6.xlsx";       
        $this->load->library('PHPExcel');         
    
        $objPHPExcel = PHPExcel_IOFactory::load($myexcelfile);     
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection(); 
        foreach ($cell_collection as $cell) {
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue(); 
            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else {
                $arr_data[$row][$column] = $data_value;
            }
        }   
        $data['header'] = $header;
        $data['values'] = $arr_data;
        foreach ($arr_data as $key => $excldata){

            $dataxams['studentid'] = $excldata["A"];
            $dataxams['examtype'] = $excldata["E"];
            $dataxams['names'] = $excldata["B"];
            $dataxams['subject'] = $excldata["D"];
            $dataxams['term'] = $excldata["C"];
            $dataxams['marks'] = $excldata["G"];
            $dataxams['teacher'] = $this->session->userdata('login_user_id');
            $dataxams['outof'] = $excldata["F"];
            $dataxams['limit'] = 0;
            $dataxams['school'] = $this->session->userdata('school_id');
            $sql = "DELETE FROM student_marks WHERE studentid = '".$excldata["A"]."' AND term = '" . $excldata["C"] . "'  AND subject = '" . $excldata["D"] . "' AND examtype = '" . $excldata["E"] . "'";
            $this->db->query($sql);
            $this->db->insert('student_marks', $dataxams);      
        }

      $resp = "Uploaded !"; 
      return $resp ; 
    }


    function cleanparentsdetails_email( ){  
        $qry = "SELECT * FROM parent WHERE  parent_id IN  (SELECT parent_id FROM student)";
        $columns = $this->db->query($qry)->result_array();
        $cnt =0;
        foreach($columns as $parentdetails){ 
            $arrayEmail = explode("/", $parentdetails['email']);
            
            if(count($arrayEmail)>1){
               //var_dump($arrayEmail); echo "<hr>";
                //email entered incorrectly
                $phone = $parentdetails['email'];
                $address = $parentdetails['phone'];
                //$sqlUpdate1 = "UPDATE parent SET phone = '". $arrayEmail[0]."',phone2 = '". $arrayEmail[1]."' , address='".$address."' WHERE parent_id='".$parentdetails['parent_id']."'";
                //$sqlUpdate1 = "UPDATE parent SET email = '' WHERE parent_id='".$parentdetails['parent_id']."'";
                //$this->db->query($sqlUpdate1);
                print ($sqlUpdate1); echo  "<br>";
             $cnt++;
            }
          
        }
        print("Updated : ".$cnt);
    }


     function splitphonenumbers( ){  
        $qry = "SELECT * FROM parent WHERE  parent_id IN  (SELECT parent_id FROM student)";
        $columns = $this->db->query($qry)->result_array();
        $cnt =0;
        foreach($columns as $parentdetails){ 
            $arrayEmail = explode(";", $parentdetails['phone']);            
            if(count($arrayEmail)>1){
               //var_dump($arrayEmail); echo "<hr>";
                //email entered incorrectly
                $phone1 = $arrayEmail[0];
                $phone2 = $arrayEmail[1];
                $sqlUpdate1 = "UPDATE parent SET phone = '". $phone1."',phone2 = '". $phone2."' WHERE parent_id='".$parentdetails['parent_id']."'";
                //$sqlUpdate1 = "UPDATE parent SET email = '' WHERE parent_id='".$parentdetails['parent_id']."'";
                //$this->db->query($sqlUpdate1);
                print ($sqlUpdate1); echo  "<br>";
             $cnt++;
            }
          
        }
        print("Updated : ".$cnt);
    }

  function autologin( ){  

        $qry = "SELECT * FROM parent WHERE  parent_id IN  (SELECT parent_id FROM student) AND otp <=0 AND phone_verified <= 0";
        $columns = $this->db->query($qry)->result_array();
        $cnt =0;
        foreach($columns as $parentdetails){ 
                $otp = rand(1000, 9999);
                $sqlUpdate1 = "UPDATE parent SET pro2='autogenerated', otp = '". $otp."',phone_verified = 1 WHERE parent_id='".$parentdetails['parent_id']."'";              
                $this->db->query($sqlUpdate1);
                print ($sqlUpdate1); echo  "<br>";
             $cnt++;
        
          
        }
        print("Updated : ".$cnt);
    }







    function add_column_if_not_exist($db, $column, $column_attr = "VARCHAR( 255 ) NULL" ){
        $exists = false;

        $qry = "show columns from $db";
        $columns = $this->db->query($qry)->result_array();
        foreach($columns as $tblcolumns){ 
            if($tblcolumns['Field'] == $column){
                $exists = true;
                break;
            }
        }       
        if(!$exists){          
            $this->db->query("ALTER TABLE `$db` ADD `$column`  $column_attr");
        }
    }


    function getCalcMark($examtype,$percentage,$studentid,$term,$subject,$class_id,$stream_id){         

            $qryStudToAddMark = "
                SELECT
                sm.studentid,sm.term,sm.examtype,e.ID Exam_ID, sm.subject,sm.marks FROM mark m
                    JOIN student_marks sm ON sm.studentid = m.student_id
                    JOIN exams e ON e.Term1 = sm.examtype 
                WHERE sm.examtype = '".$examtype."'
                    AND m.class_id = '".$class_id."' 
                    AND m.section_id = '".$stream_id."'
                    AND sm.term = '".$term."'
                    AND sm.studentid = '".$studentid."' 
                    AND sm.subject ='".$subject."' 
                GROUP BY m.student_id,sm.subject
            ";
            $queryProcMark = $this->db->query($qryStudToAddMark);
            $rowExamProcMark =   $queryProcMark->row();
            if($rowExamProcMark->marks > 0){
                $examprocessingid = ($percentage/100)*$rowExamProcMark->marks;  
            }else{
               $examprocessingid = 0; 
            }

        return  $examprocessingid;
    }

    function process_do_process(){

        $class_id = 145;
        $stream_id = 276;
        $examtype = "OPENER EXAM";
        $year = 2019;
        $term = "Term 1";
        $bool = true;   

       if($class_id == ""){
            $bool = false;
            $response = "Please select the class!";
       }else if ($stream_id == ""){
            $bool = false;
            $response = "Please select the stream!";
       }else if ($examtype == ""){
            $bool = false;
            $response = "Please select the examination!";
       }else if ($term == ""){
             $bool = false;
             $response = "Please select the term!";
       }else{
            $bool = true;
            //do processing here

            $qryProcSettings = "SELECT * FROM exam_processing WHERE class_id = '".$class_id."' AND stream_id='".$stream_id."' AND term='".$term."' AND exam='".$examtype."'";
            $queryProc = $this->db->query($qryProcSettings);
            $rowExamProc =   $queryProc->row(); 
            $examprocessingid = $rowExamProc->id; 
            //get the exams to include
            $qryProcIncludes = "SELECT epi.exam_id,epi.percentage,lower(e.Term1) exam FROM exam_processing_includes epi
            JOIN exams e ON e.ID =  epi.exam_id
            WHERE exam_processing_id = '".$examprocessingid."' AND is_active = 1 ";
            $queryProcIncludes = $this->db->query($qryProcIncludes)->result_array();  

            $arrayActiveExams = array();
            $arrayActiveExamsPerc = array();
            foreach($queryProcIncludes as $rowIncludes){
                $examCol = preg_replace('/\s+/', '', $rowIncludes['exam']);
                $this->add_column_if_not_exist("exam_processing_marks",$examCol, $column_attr = "VARCHAR( 255 ) NULL" );
                $arrayActiveExams[] = $rowIncludes['exam'];
                $arrayActiveExamsPerc[] = $rowIncludes['percentage'];
            }
            //loop through the students
            $qryStudMarks = "
                SELECT
                sm.studentid,sm.term,sm.examtype,e.ID Exam_ID, sm.subject,sm.marks FROM mark m
                    JOIN student_marks sm ON sm.studentid = m.student_id
                    JOIN exams e ON e.Term1 = sm.examtype 
                WHERE sm.examtype = '".$examtype."'
                    AND m.class_id = '".$class_id."' 
                    AND m.section_id = '".$stream_id."'
                    AND sm.term = '".$term."' 
                GROUP BY m.student_id,sm.subject
            ";
            $queryStudMarks = $this->db->query($qryStudMarks)->result_array(); 

            foreach($queryStudMarks as $rowSrudMarks){
                    $this->db->query("
                        DELETE FROM  exam_processing_marks 
                        WHERE class_id = '".$class_id."' 
                        AND section_id = '".$stream_id."' 
                        AND term='".$rowSrudMarks['term']."' 
                        AND subject='".$rowSrudMarks['subject']."' 
                        AND exam='".$rowSrudMarks['examtype']."'
                        AND year='".$year."'
                        AND  student_id = '".$rowSrudMarks['studentid']."'
                        ");

                    $mark['student_id'] = $rowSrudMarks['studentid'];
                    $mark['subject'] = $rowSrudMarks['subject'];
                    $mark['class_id'] = $class_id;
                    $mark['section_id'] = $stream_id;
                    $mark['current_exam_mark'] = $rowSrudMarks['marks'];
                    $mark['exam'] = $rowSrudMarks['examtype'];
                    $mark['term'] = $rowSrudMarks['term'];             
                    $mark['year'] = $year; 
                    $mark['school_id'] = $this->session->userdata('school_id');                
                    $this->db->insert('exam_processing_marks', $mark);
                    $examProcessingid = $this->db->insert_id();
                $totalcumu = 0;
                foreach ($arrayActiveExams as $key => $getmarks){
                    $calcmark = $this->getCalcMark($getmarks,$arrayActiveExamsPerc[$key],$rowSrudMarks['studentid'],$mark['term'],$mark['subject'],$class_id,$stream_id);
                    $totalcumu =  $totalcumu + $calcmark ;  
                    $strsetmarks = "UPDATE exam_processing_marks SET `".preg_replace('/\s+/', '', $getmarks)."`  = '".$calcmark."' ,cumulative_mark='".$totalcumu."' WHERE id = '".$examProcessingid."'";
                    $this->db->query($strsetmarks);                    
                }    
             }

             $this->final_exam_filter($class_id,$stream_id,$examtype,$year,$term,$bool,$rowExamProc->requiredsciences,$rowExamProc->requiredhumanities,$rowExamProc->requiredothers,$rowExamProc->id);

            $response = "Saved";
           }
  
        echo json_encode(array("response"=>$response,"bool"=>$bool ));  
    }


   


    function getSubject($studentid,$class_id,$stream_id,$term,$examtype,$requiredsubjects,$examprocessingid,$year,$category){    
        $qrySciences = "SELECT group_concat(subject_id) sciencesubjects FROM exam_processing_subjects WHERE category = '".$category."' AND is_active = 1 AND exam_processing_id ='".$examprocessingid."'"; 
        $querySciences = $this->db->query($qrySciences);
        $rowScienceProc =   $querySciences->row();       
        $sujcntq =  $querySciences->num_rows();
        $sciencesids = $rowScienceProc->sciencesubjects;
        $sqlStud = "
                SELECT
                eps.student_id,eps.subject,s.subject_id,e.ID exam_id,eps.exam,eps.cumulative_mark  
                FROM exam_processing_marks eps
                JOIN exams e ON e.Term1 = eps.exam
                JOIN subject s ON s.name = eps.subject 
                WHERE exam = '".$examtype."'
                    AND eps.class_id = '".$class_id."' 
                    AND eps.section_id = '".$stream_id."'
                    AND eps.term = '".$term."'
                    AND s.subject_id IN (".$sciencesids.") 
                    AND eps.school_id = '".$this->session->userdata('school_id')."' AND eps.student_id = '".$studentid."' 
                 ORDER BY eps.cumulative_mark DESC    
        ";   
           
      if($sciencesids >0){ 
        $querySciencesMark = $this->db->query($sqlStud)->result_array(); 
        $subjcnt = 1;
        foreach($querySciencesMark as $rowStudSciMarks){ 

        if($requiredsubjects == 0){
              $requiredsubjects = count($querySciencesMark);
        }

        //var_dump("Count=".$subjcnt." SecCount=".$requiredsubjects); echo "<hr>";  

             if($subjcnt <= $requiredsubjects ) {
                    $markSci['student_id'] = $rowStudSciMarks['student_id'];
                    $markSci['subject'] = $rowStudSciMarks['subject'];
                    $markSci['class_id'] = $class_id;
                    $markSci['section_id'] = $stream_id;
                    $markSci['mark'] = $rowStudSciMarks['cumulative_mark'];
                    $markSci['exam'] = $rowStudSciMarks['exam'];
                    $markSci['term'] = $term;             
                    $markSci['year'] = $year; 
                    $markSci['school_id'] = $this->session->userdata('school_id');                
                   $this->db->insert('exam_processing_final', $markSci);  
                   //echo "Insert ".$rowStudSciMarks['student_id']." Mark = ".$rowStudSciMarks['cumulative_mark']." Subject = ".$rowStudSciMarks['subject'];echo "<br>";         
             }
             $subjcnt++; 
            }
        }

    }

    function final_exam_filter($class_id,$stream_id,$examtype,$year,$term,$bool,$requiredsciences=0,$requiredhumanities=0,$requiredothers=0,$examprocessingid){ 
       // var_dump($class_id." - ".$stream_id." - ".$examtype." - ".$year." - ".$term." - ".$bool." - ".$requiredsciences." - ".$requiredhumanities." - ".$requiredothers." - ".$examprocessingid); exit();
            $qryStudCalculatedMarks = "
                SELECT
                eps.student_id
                FROM exam_processing_marks eps
                WHERE eps.exam = '".$examtype."'
                    AND eps.class_id = '".$class_id."' 
                    AND eps.section_id = '".$stream_id."'
                    AND eps.term = '".$term."'
                    AND eps.school_id = '".$this->session->userdata('school_id')."' 
              GROUP BY eps.student_id                
            "; 
            $queryStudCalcMarks = $this->db->query($qryStudCalculatedMarks)->result_array(); 
           $this->db->query("
                        DELETE FROM  exam_processing_final 
                        WHERE class_id = '".$class_id."' 
                        AND section_id = '".$stream_id."' 
                        AND term='".$term."'
                        AND exam='".$examtype."'
                        AND year='".$year."'
                        AND  school_id = '".$this->session->userdata('school_id')."'
                        ");
          $loopcnt = 0;
            foreach($queryStudCalcMarks as $rowStudMarks){
                   if($loopcnt < 500) $this->getSubject($rowStudMarks['student_id'],$class_id,$stream_id,$term,$examtype,$requiredsciences,$examprocessingid,$year,"Sciences");
                   if($loopcnt < 500) $this->getSubject($rowStudMarks['student_id'],$class_id,$stream_id,$term,$examtype,$requiredhumanities,$examprocessingid,$year,"Humanities");
                   if($loopcnt < 500) $this->getSubject($rowStudMarks['student_id'],$class_id,$stream_id,$term,$examtype,$requiredothers,$examprocessingid,$year,"Other");
                 $loopcnt++;
            }
    }




























    function layout($param1 = '',$param2 = 1){
        $classid = $param1;
        $sectionid =  $param2;
        $layout_id = (int) $this->db->get_where('class_layouts' , array('class_id' => $classid, 'section_id' => $sectionid))->row()->id;
        $classarr = $this->db->get_where('class' , array('class_id' => $classid))->result_array();
        $classname = $classarr[0]["name"];
        $teachername = $this->db->get_where('teacher' , array('teacher_id' => $classname[0]['teacher_id']))->row()->name;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->debug = true;
        $report_name = "class_layout";
        $data =  array();
        $data['layout_id'] = $layout_id;
        $data['classname'] = $classname;
        $data['teachername'] = $teachername;
        $template = "backend/principal/layout_pdf_report";
        $content = $this->load->view($template, $data, true);
        $name = $report_name . date('Y_m_d_H_i_s') . '.pdf';
        $stylesheet = file_get_contents('http://apps.classteacher.school/assets/css/pdf_style.css');
        $pdf->WriteHTML($stylesheet,1);
        $pdf->WriteHTML($content,2);
        $pdf->Output($name, 'I');
        exit();
    }

    function getAbsentNoteList()
    {
        $user_id  = $this->input->post('user_id');
        $absentnote = $this->db->query("SELECT *  FROM absentnote");
        foreach($absentnote->result() as $notes) {
            $anotes[] = $notes;
        }
        echo json_encode($anotes);
    }


























    function report($param1 = '',$param2 = 1){
        
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->debug = true;
        $data['term'] = $this->session->userdata('term');
        $data['year'] = $this->session->userdata('year');
        $data['exam_main'] = $this->session->userdata('exam');
        $student_id = $param1;
        $data['adm']=$param1;
        $term       =   $this->input->post('term');
        $year       =   $this->input->post('year');
        $student = $this->db->get_where('sudtls' , array('Adm' => $student_id))->row();
        $data['student_name'] = $student->Name;
        $data['school_image'] = $this->crud_model->get_image_url('school',$student->school_id);
        $student2 = $this->db->get_where('student' , array('student_code' => $student_id))->row();
        $enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
        $class = $student->Form;
        $class_id = $student2->class_id;
        $section_id = $student2->section_id;
        $stream = $student->Stream;
        $data['class_name'] = $this->db->get_where('form' , array('Id' => $class))->row()->Name . ' '.$stream;
        $class_name =  $this->db->get_where('form' , array('Id' => $class))->row()->Name;
        
        $main_exam  =   strtolower($this->input->post('exam'));
        if($stream != ''){
        $data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year,"Adm"=>$student_id))->result_array();
        }else{
            $data['exam']= $this->db->get_where("mean_score", array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year,"stream"=>$stream,"Adm"=>$student_id))->result_array();
        }
        $data['exam1']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year))->row()->exam1;
        
        $data['exam2']= $this->db->get_where("process", array('school_id'=>$this->session->userdata('school_id'),"exam_main"=>$main_exam,"form"=>$class_name,"term"=>$term,"year"=>$year))->row()->exam2;
        
        $teacher_name = $this->db->get_where('teacher' , array('teacher_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->teacher_id))->row()->name;
        
        if($teacher_name == '')
            $teacher_name = $this->db->get_where('principal' , array('principal_id' => $this->db->get_where('section' , array('section_id' => $section_id,'class_id' => $class_id))->row()->principal_id))->row()->name;
        
        $data['class_teacher'] = $teacher_name; 
                
        switch($param2){
        
            case 1:
            
                $report_name = 'health_report';
            
                $last_incident = $this->db->order_by('updated_date', 'DESC')->get_where('health_last_occurence' , array('student_id' => $student_id))->row();
                
                $report = $this->db->order_by('updated_date', 'DESC')->get_where('health_last_occurence' , array('student_id' => $student_id))->result_array();
                
                $data['overall_health'] = ($last_incident->updated_date !='')?'Good':'';
                $data['incident_date'] = ($last_incident->updated_date !='')?date('d M Y',strtotime($last_incident->updated_date)):'';
                $data['incident_action'] = $last_incident->action;
                $data['report'] = $report;
                
                $template = "backend/principal/health_report_pdf";
                
            break;
            case 20:
            
                $report_name = 'behaviour_report';
            
                $last_incident = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->row();
                
                $report = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->result_array();
                
                $data['overall_behaviour'] = ($last_incident->updated_on !='')?'Good':'';
                $data['incident_date'] = ($last_incident->updated_on !='')?date('d M Y',strtotime($last_incident->updated_on)):'';
                $data['incident_action'] = $last_incident->action;
                $data['report'] = $report;
            
            
                $template = "backend/principal/behaviour_pdf_report";
            break;
            case 2:
                //error_reporting(E_ALL);
                //ini_set('display_errors', 'On');
                $server="localhost";
                $db="appsclassteacher";
                $user="appsuserclass";
                $pass=">UKn}6=MK[w^`P5B";
                $version="0.9d";
                $pgport=5432;
                $pchartfolder="./class/pchart2";


                $last_incident = $this->db->order_by('updated_on', 'DESC')->get_where('behaviour_reports' , array('student_id' => $student_id))->row();
                $overall_behaviour = ($last_incident->updated_on !='')?'Good':'';
                $incident_date = ($last_incident->updated_on !='')?date('d M Y',strtotime($last_incident->updated_on)):'';
                $incident_action = $last_incident->action;

                $this->load->library('PHPJasperXML');
                $phpXMLObject = new PHPJasperXML();
                $sql = "
                     SELECT s.student_id,s.name,s.sex,s.date_of_admission,sch.school_id,sch.school_name,
                                                sch.logo,sch.website,sch.email,sch.address,sch.telephone,now() as tdate,
                                                e.class_id,c.name classname,
                    br.action , br.others , br.updated_on ,br.report,
                    bc.content_name
                                    
                                            FROM student s
                                            JOIN school sch ON sch.school_id = s.school_id
                                            JOIN enroll e ON e.student_id = s.student_id
                                            JOIN class c ON c. class_id = e.class_id
                    
                    LEFT JOIN behaviour_reports br On br.student_id = s.student_id
                    LEFT JOIN behaviour_content bc ON bc.id = br.behaviour
                    
                               
                    
                                            WHERE s.student_id = '".$student_id."' 
                                            GROUP BY bc.content_name
                 ";
                $phpXMLObject->arrayParameter=array(
                    "conditions"=>"Test",
                    $this->id = 1,
                    "class_name"=>$class_name,
                    "class_teacher"=>$teacher_name,
                    "overall_behaviour"=>$overall_behaviour,
                    "incident_date"=>$incident_date,
                    "incident_action"=>$incident_action,
                    "sql"=>$sql,
                    "logo"=>"http://apps.classteacher.school//assets//images//pdf_logo//logo.png"
                );
                $phpXMLObject->load_xml_file(dirname(__FILE__)."/PDF/pdf-behaviours.jrxml");
                $phpXMLObject->transferDBtoArray($server,$user,$pass,$db);
                $phpXMLObject->outpage("I");
                exit();
                break;
            case 30:
            
                $report_name = 'fee_report';
            
                $invoice = $this->db->order_by('term_id', 'DSEC')->get_where('invoice' , array('student_id' => $student_id))->row();
                
                $report = $this->db->order_by('term_id', 'ASC')->get_where('invoice' , array('student_id' => $student_id))->result_array();
                                                 
                $payment_date = $this->db->get_where('payment' , array('invoice_id' => $invoice->invoice_id))->row()->paid_date;
                 
                $fee_status = ($invoice->due >0)?'Pending':'Cleared';
                $data['fee_status'] = $fee_status;
                $data['incident_date'] = ($payment_date !='' && $payment_date != 0)?date('d M Y',strtotime($payment_date)):'';
                $data['balance'] = $invoice->due;
                $data['report'] = $report;
                
                $template = "backend/principal/fee_pdf_report";
            break;


            case 3:
                //redo with new fees format
                error_reporting(E_ALL);
                ini_set('display_errors', 'On');
                $server="localhost";
                $db="appsclassteacher";
                $user="appsuserclass";
                $pass=">UKn}6=MK[w^`P5B";
                $version="0.9d";
                $pgport=5432;
                $pchartfolder="./class/pchart2";

                $this->load->library('PHPJasperXML');
                $phpXMLObject = new PHPJasperXML();
                $sql = "
                        SELECT s.student_id,s.name,s.sex,s.date_of_admission,sch.school_id,sch.school_name,
                            sch.logo,sch.website,sch.email,sch.address,sch.telephone,now() as tdate,
                            e.class_id,c.name classname ,
                            i.title,i.description,i.amount , i.amount_paid ,i.due , i.status , i.year, i.invoice_id ,
                             invc.name feesname ,  invc.amount feesamount,
                            p.amount paymentamount,p.payment_type
                        FROM student s
                        JOIN school sch ON sch.school_id = s.school_id
                        JOIN enroll e ON e.student_id = s.student_id
                        JOIN class c ON c. class_id = e.class_id
                        LEFT JOIN invoice i ON i.student_id = s.student_id AND i.school_id =  s.school_id
                        LEFT JOIN  invoice_content invc ON  invc.invoice = i.term_id
                        LEFT JOIN payment p ON p.invoice_id =  i.invoice_id
                        WHERE s.student_id = '".$student_id."'                        
                        ORDER BY i.invoice_id 
                 ";
                $phpXMLObject->arrayParameter=array(
                    "conditions"=>"Test",
                    $this->id = 1,
                    "sql"=>$sql
                );
                $phpXMLObject->load_xml_file(dirname(__FILE__)."/PDF/pdf.jrxml");
                $phpXMLObject->transferDBtoArray($server,$user,$pass,$db);
                $phpXMLObject->outpage("I");
                exit();
                break;

            case 4:
            
                $report_name = 'attendance_report';
                
                $last_incident = $this->db->order_by('date', 'DESC')->get_where('attendance' , array('student_id' => $student_id,'status' => 2))->row();
                
                $report = $this->db->order_by('date', 'ASC')->get_where('attendance' , array('student_id' => $student_id,'status' => 2))->result_array();
                
                $data['overall_attendance'] = ($last_incident->date !='')?'Good':'';
                $data['incident_date'] = ($last_incident->date !='')?date('d M Y',strtotime($last_incident->date)):'';
                $data['incident_reason'] = $last_incident->reason;
                $data['report'] = $report;
                
                $template = "backend/principal/attendance_pdf_report";
            break;
            case 5:
            
                $report_name = 'academic_progress_report';
                
                $last_exam = $this->db->get_where('exam' , array('exam_id' => $this->db->order_by('exam_id', 'DESC')->get_where('mark' , array('student_id' => $student_id))->row()->exam_id))->row();              
                
                
                $report = $this->db->order_by('exam_id', 'ASC')->get_where('mark' , array('student_id' => $student_id))->result_array();
                //echo ("<pre>");
                //print_r ($report); exit;
                //echo ("</pre>");
                $enroll = $this->db->get_where('enroll' , array('student_id' => $student_id))->row();
                
                $class_id = $enroll->class_id;
                
                $section_id = $enroll->section_id;
                
                
                
                $studentCnt = $this->db->get_where('enroll' , array('class_id' => $class_id,'section_id' => $section_id))->num_rows();
                
                $students = $this->db->order_by('student_id', 'ASC')->get_where('mark' , array('class_id' => $class_id,'section_id' => $section_id))->result_array();
                
                $data['studentCnt'] = $studentCnt;
                $data['students'] = $students;
                
                $data['overall_performance'] = ($last_exam->date !='')?'Good':'';
                $data['exam_date'] = ($last_exam->date !='')?date('d M Y',strtotime($last_exam->date)):'';               
                $data['report'] = $report;
                //echo ("<pre>");
                //print_r($report); exit;
                //echo ("</pre>");
                
                $template = "backend/principal/education_pdf_report";
                        
            break;
            default:
            break;  
            
        }

    }


























































}