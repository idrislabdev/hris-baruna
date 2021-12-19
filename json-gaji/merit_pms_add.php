<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/MeritPMS.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$merit_pms = new MeritPMS();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlah = httpFilterPost("reqJumlah");
$reqPendidikanId = httpFilterPost("reqPendidikanId");

if($reqMode == "insert")
{
	$merit_pms->setField("KELAS", $reqKelas);
	$merit_pms->setField("PERIODE", $reqPeriode);
	$merit_pms->setField("JUMLAH", dotToNo($reqJumlah));
	$merit_pms->setField("PENDIDIKAN_ID", $reqPendidikanId);
	
	if($merit_pms->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$merit_pms->setField("MERIT_PMS_ID", $reqId);
	$merit_pms->setField("KELAS", $reqKelas);
	$merit_pms->setField("PERIODE", $reqPeriode);
	$merit_pms->setField("JUMLAH", dotToNo($reqJumlah));
	$merit_pms->setField("PENDIDIKAN_ID", $reqPendidikanId);
	
	if($merit_pms->update())
		echo "Data berhasil disimpan.";
	
}
?>