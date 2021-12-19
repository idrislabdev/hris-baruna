<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$jenis_pegawai = new JenisPegawai();

$jenis_pegawai->selectByParams();   
  		
$kolom = array('JENIS_PEGAWAI_ID','NAMA');
/* Output */
$data = array(); 
$totalRecord = 1;

$row = array();
$row['JENIS_PEGAWAI_ID'] = 'ALL';
$row['NAMA'] = 'Semua';
$data['hasil'][] = $row;

while($jenis_pegawai->nextRow()){		
	for ( $i=0 ; $i<count($kolom) ; $i++ ){
		$row[$kolom[$i]] = $jenis_pegawai->getField($kolom[$i]);
	}
	$data['hasil'][] = $row;
	$totalRecord++;
}
echo '({"TOTAL":"'.$totalRecord.'","ISI_DATA":'.json_encode($data['hasil']).'})';
?>
