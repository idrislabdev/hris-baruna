<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/CutiTahunanDetil.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$cuti_tahunan_detil_check = new CutiTahunanDetil();
$cuti_tahunan_detil_cb = new CutiTahunanDetil();
$cuti_tahunan_detil = new CutiTahunanDetil();


$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId = httpFilterPost("reqRowId");

$reqLamaCuti = httpFilterPost("reqLamaCuti");
$reqTanggal = httpFilterPost("reqTanggal");
$reqTanggalAwal = httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir = httpFilterPost("reqTanggalAkhir");
$reqLokasiCuti = httpFilterPost("reqLokasiCuti");
$reqTunda = httpFilterPost("reqTunda");
if($reqTunda == '') $reqTunda = 0;
$reqNDTunda = httpFilterPost("reqNDTunda");
$reqTanggalNDTunda = httpFilterPost("reqTanggalNDTunda");
$reqKeteranganTunda = httpFilterPost("reqKeteranganTunda");

$jumlah_cuti = $cuti_tahunan_detil_check->getCountByParams(array("CUTI_TAHUNAN_ID" => $reqId), " AND NOT STATUS_TUNDA = 1 ");

if($jumlah_cuti == 0)
{
	$reqLamaCuti += $cuti_tahunan_detil_cb->sumCutiBersama();
}

if($reqMode == "realisasi")
{
	$cuti_tahunan_detil->setField("CUTI_TAHUNAN_DETIL_ID", $reqRowId);
	$cuti_tahunan_detil->updateStatusTundaRealisasi();
	$status = 'R';
}

else
	$status = '';


$cuti_tahunan_detil->setField('CUTI_TAHUNAN_ID', $reqId);
$cuti_tahunan_detil->setField('CUTI_TAHUNAN_DETIL_ID', $reqRowId);
$cuti_tahunan_detil->setField('STATUS_TUNDA', $reqTunda);
$cuti_tahunan_detil->setField('LAMA_CUTI', $reqLamaCuti);
$cuti_tahunan_detil->setField('LOKASI_CUTI', $reqLokasiCuti);
$cuti_tahunan_detil->setField('TANGGAL', dateToDBCheck($reqTanggal));
$cuti_tahunan_detil->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
$cuti_tahunan_detil->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
$cuti_tahunan_detil->setField('STATUS_BAYAR_MUTASI', $status);
$cuti_tahunan_detil->setField('NOTA_DINAS_TUNDA', $reqNDTunda);
$cuti_tahunan_detil->setField('TANGGAL_NOTA_DINAS_TUNDA', dateToDBCheck($reqTanggalNDTunda));
$cuti_tahunan_detil->setField('KETERANGAN_TUNDA', $reqKeteranganTunda);

if($reqMode == ''){
	if($cuti_tahunan_detil->insert()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
}
else if($reqMode == 'update'){
	if($cuti_tahunan_detil->update()){
		echo $reqId."-Data berhasil disimpan.-".$reqRowId;
	}
}
?>