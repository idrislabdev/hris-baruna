<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);
$mode = httpFilterPost("mode");
$reqTgl = httpFilterPost("tgl");
$reqPegawai = httpFilterPost("pegawai");
$reqKelompok = httpFilterPost("kelompok");
$reqKapal = httpFilterPost("kapal");
$reqPosisi = httpFilterPost("posisi");
$reqTotal = httpFilterPost("total");

if($reqTotal == '') $reqTotal = 0;

$absensi_rekap = new AbsensiRekap();
$absensi_rekap->setField('TGL_ABSEN', "TO_DATE('". $reqTgl ."', 'DD-MM-YYYY')");
$absensi_rekap->setField('PEGAWAI_ID', $reqPegawai);
$absensi_rekap->setField('KELOMPOK', $reqKelompok);
$absensi_rekap->setField('KAPAL_ID', $reqKapal);
$absensi_rekap->setField('LOKASI', $reqPosisi);
$absensi_rekap->setField('TOTAL', $reqTotal);

if($mode == 'update') {
	$absensi_rekap->updateRekapan();
}
else {
	$absensi_rekap->insertRekapan();
}
echo json_encode("Data berhasil disimpan");
?>
