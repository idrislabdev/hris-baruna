<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PangkatKode.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pangkat_kode = new PangkatKode();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$pangkat_kode->setField('NAMA', $reqNama);
	$pangkat_kode->setField('KETERANGAN', $reqKeterangan);
	$pangkat_kode->setField("LAST_CREATE_USER", $userLogin->nama);
	$pangkat_kode->setField("LAST_CREATE_DATE", OCI_SYSDATE);
		
	if($pangkat_kode->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$pangkat_kode->setField('PANGKAT_KODE_ID', $reqId); 
	$pangkat_kode->setField('NAMA', $reqNama);
	$pangkat_kode->setField('KETERANGAN', $reqKeterangan);
	$pangkat_kode->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pangkat_kode->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	
	if($pangkat_kode->update())
		echo "Data berhasil disimpan.";
	
}
?>