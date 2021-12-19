<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$cuti_tahunan = new CutiTahunan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqPegawaiId = httpFilterPost("reqPegawaiId");
$reqJenisPegawaiId = httpFilterPost("reqJenisPegawaiId");
$reqLamaCuti = httpFilterPost("reqLamaCuti");
$reqTanggal = httpFilterPost("reqTanggal");
$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
				   
$cuti_tahunan->setField('PEGAWAI_ID', $reqPegawaiId);
$cuti_tahunan->setField('JENIS_PEGAWAI_ID', $reqJenisPegawaiId);
$cuti_tahunan->setField('PERIODE', date('Y'));
$cuti_tahunan->setField('LAMA_CUTI', $reqLamaCuti);
$cuti_tahunan->setField('TANGGAL', dateToDBCheck($reqTanggal));
$cuti_tahunan->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
$cuti_tahunan->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));

if($cuti_tahunan->insert())
	echo "Data berhasil disimpan.";

?>