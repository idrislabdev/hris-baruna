<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/Ijin.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$ijin = new Ijin();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$ijin->setField("NAMA", $reqNama);
	$ijin->setField("KETERANGAN", $reqKeterangan);
	if($ijin->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$ijin->setField("IJIN_ID", $reqId);
	$ijin->setField("NAMA", $reqNama);
	$ijin->setField("KETERANGAN", $reqKeterangan);
	if($ijin->update())
		echo "Data berhasil disimpan.";
	
}
?>