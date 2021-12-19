<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$lain_kondisi = new LainKondisi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");

if($reqMode == "insert")
{
	$lain_kondisi->setField("LAIN_KONDISI_ID", $reqId);
	$lain_kondisi->setField("NAMA", $reqNama);
	if($lain_kondisi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$lain_kondisi->setField("LAIN_KONDISI_ID", $reqId);
	$lain_kondisi->setField("NAMA", $reqNama);
	if($lain_kondisi->update())
		echo "Data berhasil disimpan.";
	
}
?>