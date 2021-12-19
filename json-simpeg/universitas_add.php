<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Universitas.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$universitas = new Universitas();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$universitas->setField('KODE', $reqKode);
	$universitas->setField('NAMA', $reqNama);
	$universitas->setField('KETERANGAN', $reqKeterangan);
	$universitas->setField("LAST_CREATE_USER", $userLogin->nama);
	$universitas->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($universitas->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$universitas->setField('UNIVERSITAS_ID', $reqId); 
	$universitas->setField('KODE', $reqKode);
	$universitas->setField('NAMA', $reqNama);
	$universitas->setField('KETERANGAN', $reqKeterangan);
	$universitas->setField("LAST_UPDATE_USER", $userLogin->nama);
	$universitas->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($universitas->update())
		echo "Data berhasil disimpan.";
	
}
?>