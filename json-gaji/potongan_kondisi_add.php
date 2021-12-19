<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$potongan_kondisi = new PotonganKondisi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqStatusImport = httpFilterPost("reqStatusImport");

if($reqMode == "insert")
{
	$potongan_kondisi->setField("POTONGAN_KONDISI_ID", $reqId);
	$potongan_kondisi->setField("NAMA", $reqNama);
	$potongan_kondisi->setField("STATUS_IMPORT", coalesce($reqStatusImport, '0'));
	if($potongan_kondisi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$potongan_kondisi->setField("POTONGAN_KONDISI_ID", $reqId);
	$potongan_kondisi->setField("NAMA", $reqNama);
	$potongan_kondisi->setField("STATUS_IMPORT", coalesce($reqStatusImport, '0'));
	if($potongan_kondisi->update())
		echo "Data berhasil disimpan.";
	
}
?>