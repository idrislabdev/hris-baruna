<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pangkat.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pangkat = new Pangkat();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$pangkat->setField('NAMA', $reqNama);
	$pangkat->setField('KETERANGAN', $reqKeterangan);
	$pangkat->setField("LAST_CREATE_USER", $userLogin->nama);
	$pangkat->setField("LAST_CREATE_DATE", OCI_SYSDATE);
		
	if($pangkat->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$pangkat->setField('PANGKAT_ID', $reqId); 
	$pangkat->setField('NAMA', $reqNama);
	$pangkat->setField('KETERANGAN', $reqKeterangan);
	$pangkat->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pangkat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($pangkat->update())
		echo "Data berhasil disimpan.";
	
}
?>