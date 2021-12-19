<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/MeritP3.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$merit_p3 = new MeritP3();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlah = httpFilterPost("reqJumlah");

if($reqMode == "insert")
{
	$merit_p3->setField("KELAS", $reqKelas);
	$merit_p3->setField("PERIODE", $reqPeriode);
	$merit_p3->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($merit_p3->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$merit_p3->setField("MERIT_P3_ID", $reqId);
	$merit_p3->setField("KELAS", $reqKelas);
	$merit_p3->setField("PERIODE", $reqPeriode);
	$merit_p3->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($merit_p3->update())
		echo "Data berhasil disimpan.";
	
}
?>