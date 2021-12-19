<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganPerbantuanA.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tunjangan_perbantuan_a = new TunjanganPerbantuanA();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelas = httpFilterPost("reqKelas");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlah = httpFilterPost("reqJumlah");

if($reqMode == "insert")
{
	$tunjangan_perbantuan_a->setField("KELAS", $reqKelas);
	$tunjangan_perbantuan_a->setField("PERIODE", $reqPeriode);
	$tunjangan_perbantuan_a->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($tunjangan_perbantuan_a->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tunjangan_perbantuan_a->setField("TUNJANGAN_PERBANTUAN_A_ID", $reqId);
	$tunjangan_perbantuan_a->setField("KELAS", $reqKelas);
	$tunjangan_perbantuan_a->setField("PERIODE", $reqPeriode);
	$tunjangan_perbantuan_a->setField("JUMLAH", dotToNo($reqJumlah));
	
	if($tunjangan_perbantuan_a->update())
		echo "Data berhasil disimpan.";
	
}
?>