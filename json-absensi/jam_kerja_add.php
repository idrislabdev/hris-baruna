<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/JamKerja.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$jam_kerja = new JamKerja();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqJamAwal= httpFilterPost("reqJamAwal");
$reqJamAkhir= httpFilterPost("reqJamAkhir");
$reqTerlambatAwal= httpFilterPost("reqTerlambatAwal");
$reqTerlambatAkhir= httpFilterPost("reqTerlambatAkhir");
$reqJamKerjaJenis= httpFilterPost("reqJamKerjaJenis");

if($reqMode == "insert")
{
	$jam_kerja->setField('JAM_KERJA_JENIS_ID', $reqJamKerjaJenis);
	$jam_kerja->setField('NAMA', $reqNama);
	$jam_kerja->setField('JAM_AWAL', $reqJamAwal);
	$jam_kerja->setField('JAM_AKHIR', $reqJamAkhir);
	$jam_kerja->setField('TERLAMBAT_AWAL', $reqTerlambatAwal);
	$jam_kerja->setField('TERLAMBAT_AKHIR', $reqTerlambatAkhir);
	$jam_kerja->setField('STATUS', 0);
	if($jam_kerja->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$jam_kerja->setField('JAM_KERJA_ID', $reqId); 
	$jam_kerja->setField('JAM_KERJA_JENIS_ID', $reqJamKerjaJenis);
	$jam_kerja->setField('NAMA', $reqNama);
	$jam_kerja->setField('JAM_AWAL', $reqJamAwal);
	$jam_kerja->setField('JAM_AKHIR', $reqJamAkhir);
	$jam_kerja->setField('TERLAMBAT_AWAL', $reqTerlambatAwal);
	$jam_kerja->setField('TERLAMBAT_AKHIR', $reqTerlambatAkhir);
	$jam_kerja->setField('STATUS', 0);
	if($jam_kerja->update())
		echo "Data berhasil disimpan.";
	
}
?>