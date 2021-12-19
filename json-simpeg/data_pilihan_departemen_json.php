<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$departemen = new PenilaianPeriode();

$departemen->selectByParamsDepartemen($where, -1, -1, '', "");   
  		
$kolom = array('DEPARTEMEN_ID','NAMA');
/* Output */
$data = array(); 
$totalRecord = 0;
while($departemen->nextRow()){	
	//$departemen->getField('NAMA');
	$row = array();
	for ( $i=0 ; $i<count($kolom) ; $i++ ){
		$row[$kolom[$i]] = $departemen->getField($kolom[$i]);
	}
	$data['hasil'][] = $row;
	$totalRecord++;
}
echo '({"TOTAL":"'.$totalRecord.'","ISI_DATA":'.json_encode($data['hasil']).'})';
?>
