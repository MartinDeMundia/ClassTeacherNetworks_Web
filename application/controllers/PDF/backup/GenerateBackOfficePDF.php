<?php
include_once('class/tcpdf/tcpdf.php');
include_once("class/PHPJasperXML.inc.php");
include_once ('setting.php');

class GenerateBackOfficePDF{        
        
       public $branchId;
       public $logoPath;
       public $branchAddress;
       public $sql;
       public $id;
        
       function __construct($branchId,$logoPath,$branchAddress,$id,$sql) {
          $this->branchId = $branchId;
          $this->logoPath = $logoPath;
          $this->branchAddress = $branchAddress;
          $this->sql = $sql;
          $this->id = $id;
        }
        
       function PDF(){
            global $server,$user,$pass,$db;
            $phpXMLObject = new PHPJasperXML();            
            $phpXMLObject->arrayParameter=array("branch"=>$this->branchId,"logo"=>$this->logoPath,"address"=>$this->branchAddress,$this->id = $id,"sql"=>$this->sql);                
            $phpXMLObject->load_xml_file("pdf.jrxml");
            $phpXMLObject->transferDBtoArray($server,$user,$pass,$db);
            $phpXMLObject->outpage("I"); 
       }        
        
  }
?>
