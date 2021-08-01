<?php
require ("GenerateBackOfficePDF.php");
$sql = "
        SELECT CURDATE();
       ";
$fn = new GenerateBackOfficePDF(filter_input(INPUT_GET,"branch"),filter_input(INPUT_GET,"logo"),filter_input(INPUT_GET,"address"),filter_input(INPUT_GET,"id"),$sql);
$fn->PDF();