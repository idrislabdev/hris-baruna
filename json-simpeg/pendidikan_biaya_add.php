<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PendidikanBiaya.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pendidikan_biaya = new PendidikanBiaya();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$pendidikan_biaya->setField('NAMA', $reqNama);
	$pendidikan_biaya->setField('KETERANGAN', $reqKeterangan);
	$pendidikan_biaya->setField("LAST_CREATE_USER", $userLogin->nama);
	$pendidikan_biaya->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($pendidikan_biaya->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$pendidikan_biaya->setField('PENDIDIKAN_BIAYA_ID', $reqId); 
	$pendidikan_biaya->setField('NAMA', $reqNama);
	$pendidikan_biaya->setField('KETERANGAN', $reqKeterangan);
	$pendidikan_biaya->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pendidikan_biaya->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($pendidikan_biaya->update())
		echo "Data berhasil disimpan.";
	
}
?>