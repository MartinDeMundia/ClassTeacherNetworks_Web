<?php
require_once('class/tcpdf/tcpdf.php');
require_once("class/PHPJasperXML.inc.php");
require_once ('setting.php');

class GenerateBackOfficePDF{        
        
       public $branchId;
       public $logoPath;
       public $branchAddress;
       public $sql;
       public $id;
       public $lang;
       public $process;
       public $footeraddress1;
       public $footeraddress2;
       public $footeraddress3;
       public $headeraddress1;
       public $headeraddress2;
       public $headeraddress3;
       
        
       function __construct($branchId,$logoPath,$branchAddress,$id,$sql,$lang,$process,$footeraddress1,$footeraddress2,$footeraddress3,$headeraddress1,$headeraddress2,$headeraddress3) {
          $this->branchId = $branchId;
          $this->logoPath = $logoPath;
          $this->branchAddress = $branchAddress;
          $this->sql = $sql;
          $this->id = $id;
          $this->lang = $lang;
          $this->process = $process;
          $this->footeraddress1 = $footeraddress1;
          $this->footeraddress2 = $footeraddress2;
          $this->footeraddress3 = $footeraddress3;
          $this->headeraddress1 = $headeraddress1;
          $this->headeraddress2 = $headeraddress2;
          $this->headeraddress3 = $headeraddress3;
        }
        
       function PDF(){
            global $server,$user,$pass,$db;
            $phpXMLObject = new PHPJasperXML();            
                           
              switch($this->process){
               case 1 : 
                   $filename = "PurchaseOrder";
                   $processname = "Purchase Order";
               break;
               case 2 : 
                   $filename = "Receiving";
                   $processname =  "Receiving";
               break;
               case 8 : 
                   $filename = "Order";
                   $processname =  "Order";
               break;
               case 12 : 
                   $filename = "Invoice"; 
                   $processname =  "Invoice";
               break;
               case 9 : 
                   $filename = "PackingList";
                   $processname =  "Packing List";
               break;
               case 5 : 
                   $filename = "Quotation";
                   $processname =  "Quotation";
               break;
              }  
            switch($this->lang){
                case 1 : 
                    $language = "English";
                break;
                case 4 : 
                    $language = "Dutch";
                break;
                case 6 : 
                    $language = "French";
                break;
                case 7 : 
                    $language = "Germany";
                break;
            }  
            
            $phpXMLObject->arrayParameter=array("footeraddress1"=>$this->footeraddress1,
                "footeraddress2"=>$this->footeraddress2,
                "footeraddress3"=>$this->footeraddress3, 
                "processname"=>$processname,
                "branch"=>$this->branchId,
                "logo"=>$this->logoPath,
                "address"=>$this->branchAddress,
                $this->id = $id,
                "sql"=>$this->sql,
                "headeraddress1"=>$this->headeraddress1,
                "headeraddress2"=>$this->headeraddress2,
                "headeraddress3"=>$this->headeraddress3
                 ); 
            //$phpXMLObject->load_xml_file("http://intranet.nts.nl/programs/Translation/view/js/".$language."/".$filename.".jrxml");
            $phpXMLObject->load_xml_file("pdf.jrxml");
            $phpXMLObject->transferDBtoArray($server,$user,$pass,$db);
            $phpXMLObject->outpage("I"); 
       }        
        
  }
?>
