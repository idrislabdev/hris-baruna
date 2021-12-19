<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$gaji_kondisi = new GajiKondisi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");

if($reqMode == "insert")
{
	$gaji_kondisi->setField("GAJI_KONDISI_ID", $reqId);
	$gaji_kondisi->setField("NAMA", $reqNama);
	if($gaji_kondisi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$gaji_kondisi->setField("GAJI_KONDISI_ID", $reqId);
	$gaji_kondisi->setField("NAMA", $reqNama);
	if($gaji_kondisi->update())
		echo "Data berhasil disimpan.";
	
}
?>