<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$cuti_tahunan = new CutiTahunan();
$cuti_tahunan_detil = new CutiTahunanDetil();
$pegawai_jabatan = new PegawaiJabatan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqLamaCuti = httpFilterPost("reqLamaCuti");
$reqLamaCutiTerbayar = httpFilterPost("reqLamaCutiTerbayar");
$reqPeriode = httpFilterPost("reqPeriode");
$reqStatus =httpFilterPost("reqStatus");		



$cuti_tahunan_detil->deletePegawai($reqId);
$cuti_tahunan->setField('PEGAWAI_ID', $reqId);
$cuti_tahunan->deletePegawai();

$cuti_tahunan->setField('PEGAWAI_ID', $reqId);
$cuti_tahunan->setField('PERIODE', $reqPeriode);
$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
$cuti_tahunan->setField('TANGGAL', dateToDBCheck(""));
$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck(""));
$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck(""));
$cuti_tahunan->setField('STATUS_BAYAR_MUTASI', "D");
if ($cuti_tahunan->insertPegawai())
{
	$cuti_tahunan_detil->setField('CUTI_TAHUNAN_ID', $cuti_tahunan->id);
	$cuti_tahunan_detil->setField('LAMA_CUTI', $reqLamaCuti);
	$cuti_tahunan_detil->setField('LOKASI_CUTI', "");
	$cuti_tahunan_detil->setField('TANGGAL', dateToDBCheck(""));
	$cuti_tahunan_detil->setField('TANGGAL_AWAL', dateToDBCheck(""));
	$cuti_tahunan_detil->setField('TANGGAL_AKHIR', dateToDBCheck(""));
	$cuti_tahunan_detil->setField('TANGGAL_CETAK', dateToDBCheck(date("01-02-Y")));
	$cuti_tahunan_detil->setField('TANGGAL_APPROVE', dateToDBCheck(date("01-02-Y")));
	$cuti_tahunan_detil->setField('STATUS_BAYAR_MUTASI', "D");
	$cuti_tahunan_detil->setField('LAMA_CUTI_TERBAYAR', $reqLamaCutiTerbayar);
	$cuti_tahunan_detil->insertPegawai();

	echo $reqId."-Data berhasil disimpan.";
}
?>