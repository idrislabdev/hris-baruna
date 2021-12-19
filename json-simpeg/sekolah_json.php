<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/DataSekolah.php");

$sekolah = new DataSekolah();
$reqKeyword = httpFilterPost("query");
$reqLimit = httpFilterPost("limit");
$reqPage = httpFilterPost("page");
$reqStart = httpFilterPost("start");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);
$where ="";
if($reqKeyword != ""){
	$where = " AND (UPPER(NAMA) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(ALAMAT) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(KOTA) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(EMAIL) LIKE UPPER('%". $reqKeyword ."%')) ";
}
$totalRecord = $sekolah->getCountByParams(array(), $where);
$sekolah->selectByParams(array(), $reqLimit, $reqStart, $where, " ORDER BY LAST_CREATE_DATE DESC");     		
$kolom = array('SEKOLAH_ID','NAMA', 'EMAIL', 'WEBSITE', 'TELPON','ALAMAT','FAX','REKOMENDASI_N','REKOMENDASI_T','SERTIFIKAT','TGL_SERTIFIKAT', 'TEXT_TGL_SERTIFIKAT', 'APPROVAL_DESC','KOTA');
/* Output */
$data = array();
while($sekolah->nextRow()){	
	$row = array();
	for ( $i=0 ; $i<count($kolom) ; $i++ ){
		$row[$kolom[$i]] = $sekolah->getField($kolom[$i]);
	}
	$data['hasil'][] = $row;
}
echo '({"TOTAL":"'.$totalRecord.'","ISI_DATA":'.json_encode($data['hasil']).'})';
?>
