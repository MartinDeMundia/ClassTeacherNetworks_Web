<?php

include 'conn.php';
$rs = mysql_query('SELECT sudtls.id,sudtls.adm,round(cat1,2) as cat1,cat2,endterm,name FROM form2 LEFT JOIN sudtls ON(sudtls.Adm=FORM2.ADM)');
$result = array();
while($row = mysql_fetch_object($rs)){
	array_push($result, $row);
}

echo json_encode($result);

?>