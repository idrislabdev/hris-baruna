<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$surat_perintah = new SuratPerintah();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNomorPenugasan= httpFilterPost("reqNomorPenugasan");
$reqNomor= httpFilterPost("reqNomor");
$reqPekerjaan= httpFilterPost("reqPekerjaan");
$reqTanggal= httpFilterPost("reqTanggal");
$reqLokasi= httpFilterPost("reqLokasi");

if($reqMode == "update")
{
	$surat_perintah->setField('SURAT_PERINTAH_ID', $reqId); 
	$surat_perintah->setField('PEKERJAAN', $reqPekerjaan);
	$surat_perintah->setField('NOMOR', $reqNomor);
	$surat_perintah->setField('NOMOR_PENUGASAN', $reqNomorPenugasan);
	$surat_perintah->setField('LOKASI', $reqLokasi);
	$surat_perintah->setField('TANGGAL', dateToDBCheck($reqTanggal));
	$surat_perintah->setField('STATUS', 'C');
	
	
	if($surat_perintah->updateData())
		echo "Data berhasil disimpan.";
	
}
?>