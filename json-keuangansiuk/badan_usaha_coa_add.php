<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrCoaKustKlien.php");


$kbbr_coa_kust_klien = new KbbrCoaKustKlien();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqBadanUsahaId= httpFilterPost("reqBadanUsahaId");
$reqBadanUsaha= httpFilterPost("reqBadanUsaha");
$reqKodeKustomerClient = httpFilterPost("reqKodeKustomerClient");
$reqCoa1 = httpFilterPost("reqCoa1");
$reqCoa2 = httpFilterPost("reqCoa2");
$reqCoa3 = httpFilterPost("reqCoa3");
$reqCoa4 = httpFilterPost("reqCoa4");
$reqCoa5 = httpFilterPost("reqCoa5");
$reqCoa6 = httpFilterPost("reqCoa6");
$reqCoa7 = httpFilterPost("reqCoa7");
$reqCoa8 = httpFilterPost("reqCoa8");
$reqCoa9 = httpFilterPost("reqCoa9");
$reqCoa10 = httpFilterPost("reqCoa10");
$reqStatus = httpFilterPost("reqStatus");

if($reqMode == "insert")
{				   
	$kbbr_coa_kust_klien->setField('KD_CABANG', "11");
	$kbbr_coa_kust_klien->setField('ID_REF_BD_USAHA', "BADAN USAHA");
	$kbbr_coa_kust_klien->setField('BADAN_USAHA', strtoupper($reqBadanUsaha));
	$kbbr_coa_kust_klien->setField('KD_KUST_KLIEN', $reqKodeKustomerClient);
	$kbbr_coa_kust_klien->setField('COA1', $reqCoa1);
	$kbbr_coa_kust_klien->setField('COA2', $reqCoa2);
	$kbbr_coa_kust_klien->setField('COA3', $reqCoa3);
	$kbbr_coa_kust_klien->setField('COA4', $reqCoa4);
	$kbbr_coa_kust_klien->setField('COA5', $reqCoa5);
	$kbbr_coa_kust_klien->setField('COA6', $reqCoa6);
	$kbbr_coa_kust_klien->setField('COA7', $reqCoa7);
	$kbbr_coa_kust_klien->setField('COA8', $reqCoa8);
	$kbbr_coa_kust_klien->setField('COA9', $reqCoa9);
	$kbbr_coa_kust_klien->setField('COA10', $reqCoa10);
	$kbbr_coa_kust_klien->setField('KD_AKTIF', $reqStatus);
	$kbbr_coa_kust_klien->setField("LAST_UPDATE_BY", $userLogin->nama);
	$kbbr_coa_kust_klien->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$kbbr_coa_kust_klien->setField("PROGRAM_NAME", "KBB_R_COA_KUSTOM_IMAIS");
		
	if($kbbr_coa_kust_klien->insert())
		echo "-Data berhasil disimpan.";
		//echo $kbbr_coa_kust_klien->query;
}
else
{
	$kbbr_coa_kust_klien->setField('KD_CABANG', "11");
	$kbbr_coa_kust_klien->setField('ID_REF_BD_USAHA', "BADAN USAHA");
	$kbbr_coa_kust_klien->setField('BADAN_USAHA', strtoupper($reqBadanUsaha));
	$kbbr_coa_kust_klien->setField('KD_KUST_KLIEN', $reqKodeKustomerClient);
	$kbbr_coa_kust_klien->setField('COA1', $reqCoa1);
	$kbbr_coa_kust_klien->setField('COA2', $reqCoa2);
	$kbbr_coa_kust_klien->setField('COA3', $reqCoa3);
	$kbbr_coa_kust_klien->setField('COA4', $reqCoa4);
	$kbbr_coa_kust_klien->setField('COA5', $reqCoa5);
	$kbbr_coa_kust_klien->setField('COA6', $reqCoa6);
	$kbbr_coa_kust_klien->setField('COA7', $reqCoa7);
	$kbbr_coa_kust_klien->setField('COA8', $reqCoa8);
	$kbbr_coa_kust_klien->setField('COA9', $reqCoa9);
	$kbbr_coa_kust_klien->setField('COA10', $reqCoa10);
	$kbbr_coa_kust_klien->setField('KD_AKTIF', $reqStatus);
	$kbbr_coa_kust_klien->setField("PROGRAM_NAME", "KBB_R_COA_KUSTOM_IMAIS");
	$kbbr_coa_kust_klien->setField("LAST_UPDATED_BY", $userLogin->nama);
	$kbbr_coa_kust_klien->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	
	/*$kbbr_coa_kust_klien->setField('BADAN_USAHA_COA_ID', $reqId);
	$kbbr_coa_kust_klien->setField('BADAN_USAHA_ID', $reqBadanUsahaId);
	$kbbr_coa_kust_klien->setField('BADAN_USAHA', $reqBadanUsaha);
	$kbbr_coa_kust_klien->setField('KODE_KUSTOMER_CLIENT', $reqKodeKustomerClient);
	$kbbr_coa_kust_klien->setField('COA1', $reqCoa1);
	$kbbr_coa_kust_klien->setField('COA2', $reqCoa2);
	$kbbr_coa_kust_klien->setField('COA3', $reqCoa3);
	$kbbr_coa_kust_klien->setField('COA4', $reqCoa4);
	$kbbr_coa_kust_klien->setField('COA5', $reqCoa5);
	$kbbr_coa_kust_klien->setField('COA6', $reqCoa6);
	$kbbr_coa_kust_klien->setField('COA7', $reqCoa7);
	$kbbr_coa_kust_klien->setField('COA8', $reqCoa8);
	$kbbr_coa_kust_klien->setField('COA9', $reqCoa9);
	$kbbr_coa_kust_klien->setField('COA10', $reqCoa10);
	$kbbr_coa_kust_klien->setField('STATUS', $reqStatus);
	$kbbr_coa_kust_klien->setField("LAST_UPDATE_BY", $userLogin->nama);
	$kbbr_coa_kust_klien->setField("LAST_UPDATE_DATE", OCI_SYSDATE);*/
		
	if($kbbr_coa_kust_klien->update())
		echo "-Data berhasil disimpan.";
	//echo $kbbr_coa_kust_klien->query;
}
?>