<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Asuransi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$asuransi = new Asuransi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqNama= httpFilterPost("reqNama");
	
if($reqMode == "insert")
{
	$asuransi->setField("NAMA", $reqNama);
	$asuransi->setField("KETERANGAN", $reqKeterangan);
	
	if($asuransi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$asuransi->setField("ASURANSI_ID", $reqId);
	$asuransi->setField("NAMA", $reqNama);
	$asuransi->setField("KETERANGAN", $reqKeterangan);
	
	if($asuransi->update())
		echo "Data berhasil disimpan.";
	
}
?>