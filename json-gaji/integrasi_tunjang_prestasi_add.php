<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/IntegrasiTunjanganPrestasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$integrasi_tunjangan_prestasi = new IntegrasiTunjanganPrestasi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId = httpFilterPost("reqPegawaiId");
$reqPeriode = httpFilterPost("reqPeriode");
$reqJumlahJamMengajar = httpFilterPost("reqJumlahJamMengajar");
$reqJumlahJamLebih = httpFilterPost("reqJumlahJamLebih");
$reqTarifKelebihan= httpFilterPost("reqTarifKelebihan");
$reqJumlahKelebihan= httpFilterPost("reqJumlahKelebihan");

if($reqMode == "insert")
{
	$integrasi_tunjangan_prestasi->setField('PERIODE', $reqPeriode);
	$integrasi_tunjangan_prestasi->setField('JUMLAH_JAM_MENGAJAR', $reqJumlahJamMengajar);
	$integrasi_tunjangan_prestasi->setField('JUMLAH_JAM_LEBIH', $reqJumlahJamLebih);
	$integrasi_tunjangan_prestasi->setField('TARIF_KELEBIHAN_MENGAJAR', $reqTarifKelebihan);
	$integrasi_tunjangan_prestasi->setField('JUMLAH_KELEBIHAN_MENGAJAR', $reqJumlahKelebihan);
	
	if($integrasi_tunjangan_prestasi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$integrasi_tunjangan_prestasi->setField('PERIODE', $reqPeriode);
	$integrasi_tunjangan_prestasi->setField('JUMLAH_JAM_MENGAJAR', $reqJumlahJamMengajar);
	$integrasi_tunjangan_prestasi->setField('JUMLAH_JAM_LEBIH', $reqJumlahJamLebih);
	$integrasi_tunjangan_prestasi->setField('TARIF_KELEBIHAN_MENGAJAR', $reqTarifKelebihan);
	$integrasi_tunjangan_prestasi->setField('JUMLAH_KELEBIHAN_MENGAJAR', $reqJumlahKelebihan);

	
	if($integrasi_tunjangan_prestasi->update())
		echo "Data berhasil disimpan.";
	
}
?>