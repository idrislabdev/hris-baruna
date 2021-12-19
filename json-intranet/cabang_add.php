<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$cabang = new Cabang();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$cabang->setField('KODE', $reqKode);
	$cabang->setField('NAMA', $reqNama);
	$cabang->setField('KETERANGAN', $reqKeterangan);
	if($cabang->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$cabang->setField('CABANG_ID', $reqId); 
	$cabang->setField('KODE', $reqKode);
	$cabang->setField('NAMA', $reqNama);
	$cabang->setField('KETERANGAN', $reqKeterangan);
	if($cabang->update())
		echo "Data berhasil disimpan.";
	
}
?>