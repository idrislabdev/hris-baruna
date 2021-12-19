<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/UnitLink.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$unit_link = new UnitLink();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJumlah = httpFilterPost("reqJumlah");
$reqKelas= httpFilterPost("reqKelas");
	
if($reqMode == "insert")
{
	$unit_link->setField("KELAS", $reqKelas);
	$unit_link->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($unit_link->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$unit_link->setField("UNIT_LINK_ID", $reqId);
	$unit_link->setField("KELAS", $reqKelas);
	$unit_link->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($unit_link->update())
		echo "Data berhasil disimpan.";
	
}
?>