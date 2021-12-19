<?php

include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/BonusTahunan.php");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$bonus = new BonusTahunan();

$reqProses = httpFilterPost("reqProses");
$reqJenis = httpFilterPost("reqJenis");
$reqPeriode = httpFilterPost("reqPeriode");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqKeyword = httpFilterPost("query");
$reqLimit = httpFilterPost("limit");
$reqPage = httpFilterPost("page");
$reqStart = httpFilterPost("start");
$reqSorting = httpFilterPost("sort");

$where =" AND A.PERIODE = '" . $reqPeriode . "' ";
$order = " ORDER BY A.JENIS_PEGAWAI ASC, A.NAMA ASC ";

/*
if($reqSorting != ''){
	$reqSorting = json_decode($reqSorting);
	$kolOrder =  $reqSorting[0]->property;
	$orderType = $reqSorting[0]->direction;
	if($kolOrder == 'DEPARTEMEN') $kolOrder = 'C.DEPARTEMEN_ID';
	if($kolOrder == 'NAMA') $kolOrder = 'B.NAMA';
	$order = " ORDER BY ". $kolOrder ."  ". $orderType ." ";
}
*/
if($reqDepartemen != 'ALL'){
	$where .= " AND E.DEPARTEMEN_ID = '". $reqDepartemen ."' ";
}
if($reqKeyword != ""){
	$where .= " AND (UPPER(A.NAMA) LIKE UPPER('%". $reqKeyword ."%') OR UPPER(B.NAMA) LIKE UPPER('%". $reqKeyword ."%')) ";
}
if($reqJenis != 'ALL'){
	$where .= " AND A.JENIS_PEGAWAI = ". $reqJenis ." ";
}

$totalRecord = $bonus->getCountByParamsNew(array(), $where);	
$bonus->selectByParamsNew(array(), $reqLimit, $reqStart, $where, $order);     
//echo $bonus->query; exit;	

$kolom = array('NO', 'NAMA','JENIS_PEGAWAI','PEGAWAI_ID', 'NRP', 'NPWP', 'DEPARTEMEN', 'NILAI_PI','NILAI_SKI',
	'NILAI_TOTAL','NILAI_KATEGORI','JUMLAH_BONUS','PPH_PERSEN','PPH_KALI','PPH_NILAI','PERIODE',
	'BANK', 'REKENING_NO', 'REKENING_NAMA', 'JUMLAH_DIBAYAR');
/* Output */
$data = array();
while($bonus->nextRow()){	
	$row = array();
	for ( $i=0 ; $i<count($kolom) ; $i++ ){
		$row[$kolom[$i]] = $bonus->getField($kolom[$i]);
	}
	$data['hasil'][] = $row;
}
echo '({"TOTAL":"'.$totalRecord.'","ISI_DATA":'.json_encode($data['hasil']).'})';
?>
