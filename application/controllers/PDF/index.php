<?php
require ("GenerateBackOfficePDF.php");
$sql = "
SELECT now();
       "; 



switch(filter_input(INPUT_GET,"branch")){
    case 1:
       $logo = "./logo_nts_oudenbosch.jpg";
       $address = "NTS Oudenbosch BV";
       $footeraddress1 = "
           NTS Oudenbosch BV
           Telephone
           Mobile
           User
               ";
      $footeraddress2 = "
           Additional
               ";
      $headeraddress1 = "Ambachtenstraat 9";
      $headeraddress2 = "4731 RE  Oudenbosch";
      $headeraddress3 = "the Netherlands";
      
    $footeraddress1 = "
    T. +31 (0)165 319100
    E. verkoop@nts.nl
    W. www.nts.nl

    K.v.K. no : 24238658 te Rotterdam
    BTW/VAT no. : NL 8060.91.277.B01
     ";

    $footeraddress2 = "
    NTS Euro account (ABN Amro)
    ABN AMRO Netherlands: 64.03.01.797
    IBAN: NL61 ABNA 0640301797
    BIC/Swift: ABNANL2A

    NTS USD account (ABN Amro)
    ABN AMRO Netherlands: 97.24.16.935
    IBAN: NL75 ABNA 0972416935
    BIC/Swift: ABNANL2A
    ";

    $footeraddress3 = "
    NTS Euro account (BNP Paribas)
    BNP Paribas Fortis België: 001 4006309 91
    IBAN: E23001400630991
    BIC/Swift: GEBAB EBB18A

    NTS Euro account (Deutsche Bank)
    Deutsche Bank: 1240167-00
    BLZ: 39070024
    IBAN: DE33390700240124016700
    BIC/Swift: DEUTDEDB390
    ";
      
    break;    
    case 6:
       $logo = "./logo.jpg";
       $address = "KENYATTA HIGH SCHOOL (MAHIGA)";
    break;
    case 8:
       $logo = "./logo_asia.jpg";
       $address = "NTS Computers SDN BHD"; 
       
       
       
       /*$footeraddress1 = "
           NTS Oudenbosch BV
           Telephone
           Mobile
           User
               ";
      $footeraddress2 = "
           Additional
               ";*/
      $headeraddress1 = "(reg: 1094764-H)";
      $headeraddress2 = "no 29 Jalan Sungai Besi Indah 5/2";
      $headeraddress3 = "Taman Sungai Besi Indah,Malaysia";
      
        $footeraddress1 = "
        NTS Computers SDN BHD
        (reg: 1094764-H)
        no 29 Jalan Sungai Besi Indah 5/2
        Taman Sungai Besi Indah
        43300 Seri Kembangan
        Malaysia
         ";

        $footeraddress2 = "
        NTS Computers SDN BHD
        Branch: Selangor
        Acc No: 8881009563260
        Swift code: ARBKMYKL
        ";

        $footeraddress3 = "

        ";
       
    break;
    case 11:
       $logo = "./logo_salland.jpg";
       $address = "Salland Computers BV";
    break;
	
	
	
	case 14:
       $logo = "./logo_nts_oudenbosch.jpg";
       $address = "NTS Computers BVBA";
       $footeraddress1 = "
           NTS Computers BVBA
           Telephone
           Mobile
           User
               ";
      $footeraddress2 = "
           Additional
               ";
      $headeraddress1 = "Kortrijksesteenweg 1126 bus A";
      $headeraddress2 = "9051 Gent";
      $headeraddress3 = "België";
      
    $footeraddress1 = "
    T. +32 38 080163
    E. verkoop@nts.nl
    W. www.nts.nl

    COC no : 0713.582.775
    BTW/VAT no. : BE 0713.582.775
     ";

    $footeraddress2 = "
    NTS Euro account (ABN Amro)
    ABN AMRO Netherlands: 64.03.01.797
    IBAN: NL61 ABNA 0640301797
    BIC/Swift: ABNANL2A

    NTS USD account (ABN Amro)
    ABN AMRO Netherlands: 97.24.16.935
    IBAN: NL75 ABNA 0972416935
    BIC/Swift: ABNANL2A
    ";

    $footeraddress3 = "
    NTS Euro account (BNP Paribas)
    BNP Paribas Fortis België: 001 4006309 91
    IBAN: E23001400630991
    BIC/Swift: GEBAB EBB18A

    NTS Euro account (Deutsche Bank)
    Deutsche Bank: 1240167-00
    BLZ: 39070024
    IBAN: DE33390700240124016700
    BIC/Swift: DEUTDEDB390
    ";
      
    break; 
	
	
    default:        
       $logo = "./logo_nts_oudenbosch.jpg";
       $address = "NTS Oudenbosch BV"; 
              $footeraddress1 = "
                  Additional street address on this section
               ";
       $footeraddress2 = "
                 Additional information here
               ";
    break;    
}

$fn = new GenerateBackOfficePDF(filter_input(INPUT_GET,"branch"),$logo,$address,filter_input(INPUT_GET,"id"),$sql,filter_input(INPUT_GET,"lang"),filter_input(INPUT_GET,"process"),$footeraddress1,$footeraddress2,$footeraddress3,$headeraddress1,$headeraddress2,$headeraddress3);
$fn->PDF();