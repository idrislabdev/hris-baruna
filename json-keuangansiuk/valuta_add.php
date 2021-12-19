<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");


$safr_valuta = new SafrValuta();


$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqLabel= httpFilterPost("reqLabel");
$reqNama= httpFilterPost("reqNama");
$reqStatus= httpFilterPost("reqStatus");

if($reqMode == "insert")
{
	$safr_valuta->setField('KODE', $reqKode);
	$safr_valuta->setField('LABEL', $reqLabel);
	$safr_valuta->setField('NAMA', $reqNama);
	$safr_valuta->setField('STATUS', $reqStatus);
	$safr_valuta->setField("LAST_UPDATE_BY", $userLogin->nama);
	$safr_valuta->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($safr_valuta->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$safr_valuta->setField('VALUTA_ID', $reqId); 
	$safr_valuta->setField('KODE', $reqKode);
	$safr_valuta->setField('LABEL', $reqLabel);
	$safr_valuta->setField('NAMA', $reqNama);
	$safr_valuta->setField('STATUS', $reqStatus);
	$safr_valuta->setField("LAST_UPDATE_BY", $userLogin->nama);
	$safr_valuta->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($safr_valuta->update())
		echo "Data berhasil disimpan.";
	
}
?>