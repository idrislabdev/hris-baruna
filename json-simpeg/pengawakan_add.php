<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintahPegawai.php");
include_once("../WEB-INF/classes/base-operasional/PegawaiKapal.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$surat_perintah_pegawai = new SuratPerintahPegawai();
$pegawai_kapal = new PegawaiKapal();

$reqMode = httpFilterPost("reqMode");
$reqId = httpFilterPost("reqId");
$reqPersetujuan = httpFilterPost("reqPersetujuan");
$reqPegawaiKapalId = httpFilterPost("reqPegawaiKapalId");
$reqKapalKruId = httpFilterPost("reqKapalKruId");
$reqTanggalMasuk = httpFilterPost("reqTanggalMasuk");
$reqKapalId = httpFilterPost("reqKapalId");
$reqPegawaiId = httpFilterPost("reqPegawaiId");
$reqKapalAsal = httpFilterPost("reqKapalAsal");
$reqKapalIdAsal = httpFilterPost("reqKapalIdAsal");
if($reqPersetujuan == "1")
{	
	/* UPDATE KELUAR DI KAPAL SEBELUMNYA */
	if($reqKapalAsal == "")
	{}
	else
	{
		$pegawai_kapal->setField("KAPAL_ID", $reqKapalIdAsal);
		$pegawai_kapal->setField("PEGAWAI_ID", $reqPegawaiId);
		$pegawai_kapal->setField("TANGGAL_KELUAR", dateToDBCheck($reqTanggalMasuk));
		$pegawai_kapal->updateKeluarByParam();
	}
	
	/* UPDATE KELUAR UNTUK PEGAWAI YANG AKAN DIGANTIKAN */
	$pegawai_kapal->setField("KAPAL_ID", $reqKapalId);
	$pegawai_kapal->setField("KAPAL_KRU_ID", $reqKapalKruId);
	$pegawai_kapal->setField("TANGGAL_KELUAR", dateToDBCheck($reqTanggalMasuk));
	$pegawai_kapal->setField("PEGAWAI_KAPAL_ID", $reqPegawaiKapalId);
	$pegawai_kapal->updateKeluar();
}


/* INSERT KE PEGAWAI_KAPAL DAN HISTORI UNTUK PEGAWAI YANG DISETUJUI*/
$surat_perintah_pegawai->setField("SURAT_PERINTAH_PEGAWAI_ID", $reqId);
$surat_perintah_pegawai->setField("STATUS_VALIDASI", $reqPersetujuan);
$surat_perintah_pegawai->setField("PEGAWAI_KAPAL_ID", $reqPegawaiKapalId);
$surat_perintah_pegawai->updateStatusValidasi(); 



?>