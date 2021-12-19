<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganPerbantuanB.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tunjangan_perbantuan_b = new TunjanganPerbantuanB();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlah = httpFilterPost("reqJumlah");

if($reqMode == "insert")
{
	$tunjangan_perbantuan_b->setField("KELAS", $reqKelas);
	$tunjangan_perbantuan_b->setField("PERIODE", $reqPeriode);
	$tunjangan_perbantuan_b->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($tunjangan_perbantuan_b->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tunjangan_perbantuan_b->setField("TUNJANGAN_PERBANTUAN_B_ID", $reqId);
	$tunjangan_perbantuan_b->setField("KELAS", $reqKelas);
	$tunjangan_perbantuan_b->setField("PERIODE", $reqPeriode);
	$tunjangan_perbantuan_b->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($tunjangan_perbantuan_b->update())
		echo "Data berhasil disimpan.";
	
}
?>