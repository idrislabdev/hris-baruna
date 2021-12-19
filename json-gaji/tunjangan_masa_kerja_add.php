<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/TunjanganMasaKerja.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$tunjangan_masa_kerja = new TunjanganMasaKerja();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqAwal = httpFilterPost("reqAwal");
$reqAkhir = httpFilterPost("reqAkhir");
$reqNilai = httpFilterPost("reqNilai");
$reqPendidikanId = httpFilterPost("reqPendidikanId");

if($reqMode == "insert")
{
	$tunjangan_masa_kerja->setField("AWAL", $reqAwal);
	$tunjangan_masa_kerja->setField("AKHIR", $reqAkhir);
	$tunjangan_masa_kerja->setField("NILAI", $reqNilai);
	
	if($tunjangan_masa_kerja->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$tunjangan_masa_kerja->setField("TUNJANGAN_MASA_KERJA_ID", $reqId);
	$tunjangan_masa_kerja->setField("AWAL", $reqAwal);
	$tunjangan_masa_kerja->setField("AKHIR", $reqAkhir);
	$tunjangan_masa_kerja->setField("NILAI", $reqNilai);
	
	if($tunjangan_masa_kerja->update())
		echo "Data berhasil disimpan.";
	
}
?>