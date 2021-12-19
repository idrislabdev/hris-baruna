<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TppP3.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tpp_p3 = new TppP3();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlah = httpFilterPost("reqJumlah");

if($reqMode == "insert")
{
	$tpp_p3->setField("KELAS", $reqKelas);
	$tpp_p3->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($tpp_p3->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tpp_p3->setField("TPP_P3_ID", $reqId);
	$tpp_p3->setField("KELAS", $reqKelas);
	$tpp_p3->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($tpp_p3->update())
		echo "Data berhasil disimpan.";
	
}
?>