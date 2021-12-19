<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/HariLibur.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$hari_libur = new HariLibur();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPilih= httpFilterPost("reqPilih");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");
$reqHari= httpFilterPost("reqHari");
$reqBulan= httpFilterPost("reqBulan");
$reqTanggalFix=get_null_10($reqHari).get_null_10($reqBulan);
$reqStatusCutiBersama = httpFilterPost("reqStatusCutiBersama");

if($reqMode == "insert")
{
	$hari_libur->setField('NAMA', $reqNama);
	$hari_libur->setField('KETERANGAN', $reqKeterangan);
	$hari_libur->setField('STATUS_CUTI_BERSAMA', $reqStatusCutiBersama);
		if ($reqPilih == "Statis"){
			$hari_libur->setField('TANGGAL_AWAL', "NULL");
			$hari_libur->setField('TANGGAL_AKHIR', "NULL");
		}elseif ($reqPilih == "Dinamis" && $reqTanggalAkhir == ""){
			$hari_libur->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$hari_libur->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAwal));
		}else{
			$hari_libur->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
			$hari_libur->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			}
	$hari_libur->setField('TANGGAL_FIX', $reqTanggalFix);
	if($hari_libur->insert())
		echo "Data berhasil disimpan.";
		
	
}
else
{
	$hari_libur->setField('HARI_LIBUR_ID', $reqId);
	$hari_libur->setField('NAMA', $reqNama);
	$hari_libur->setField('KETERANGAN', $reqKeterangan);
	$hari_libur->setField('TANGGAL_AWAL', dateToDBCheck($reqTanggalAwal));
	$hari_libur->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
	$hari_libur->setField('STATUS_CUTI_BERSAMA', $reqStatusCutiBersama);

	$hari_libur->setField('TANGGAL_FIX', $reqTanggalFix);
	if($hari_libur->update())
		echo "Data berhasil disimpan.";
}
?>