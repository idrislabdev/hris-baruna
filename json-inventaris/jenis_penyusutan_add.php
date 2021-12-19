<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/JenisSusut.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$jenis_susut = new JenisSusut();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqNama= httpFilterPost("reqNama");
	
if($reqMode == "insert")
{
	$jenis_susut->setField("NAMA", $reqNama);
	$jenis_susut->setField("KETERANGAN", $reqKeterangan);
	
	if($jenis_susut->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$jenis_susut->setField("JENIS_SUSUT_ID", $reqId);
	$jenis_susut->setField("NAMA", $reqNama);
	$jenis_susut->setField("KETERANGAN", $reqKeterangan);
	
	if($jenis_susut->update())
		echo "Data berhasil disimpan.";
	
}
?>