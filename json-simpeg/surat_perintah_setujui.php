<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/PegawaiKapalHistori.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintahPegawai.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintah.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai_kapal_histori = new PegawaiKapalHistori();

$reqSuratPerintahPegawaiId = $_POST["reqSuratPerintahPegawaiId"];
$reqPegawaiKapalHistoriIdOff = $_POST["reqPegawaiKapalHistoriIdOff"];
$reqOffHire  = $_POST["reqOffHire"];
$reqPegawaiKapalHistoriIdOn = $_POST["reqPegawaiKapalHistoriIdOn"];
$reqOnHire   = $_POST["reqOnHire"];
$reqId = httpFilterPost("reqId");


for($i=0;$i<count($reqSuratPerintahPegawaiId);$i++)
{
	if($reqPegawaiKapalHistoriIdOff[$i] == "")
	{}
	else
	{
		$pegawai_kapal_histori_off = new PegawaiKapalHistori();
		$pegawai_kapal_histori_off->setField("PEGAWAI_KAPAL_HISTORI_ID", $reqPegawaiKapalHistoriIdOff[$i]);
		$pegawai_kapal_histori_off->setField("TANGGAL_KELUAR_SEBELUM", dateToDBCheck($reqOffHire[$i]));
		$pegawai_kapal_histori_off->updateOffHireLastValidasi();
		unset($pegawai_kapal_histori_off);		
	}
	
	if($reqPegawaiKapalHistoriIdOn[$i] == "")
	{}
	else
	{
		$pegawai_kapal_histori_on = new PegawaiKapalHistori();
		$pegawai_kapal_histori_on->setField("PEGAWAI_KAPAL_HISTORI_ID", $reqPegawaiKapalHistoriIdOn[$i]);
		$pegawai_kapal_histori_on->setField("TANGGAL_MASUK", dateToDBCheck($reqOnHire[$i]));
		$pegawai_kapal_histori_on->updateOnHireValidasi();
		unset($pegawai_kapal_histori_on);		
	}
	
	$surat_perintah_pegawai = new SuratPerintahPegawai();
	$surat_perintah_pegawai->setField("STATUS_VALIDASI", 1);
	$surat_perintah_pegawai->setField("SURAT_PERINTAH_PEGAWAI_ID", $reqSuratPerintahPegawaiId[$i]);
	$surat_perintah_pegawai->updateStatusValidasi();
	
}

$surat_perintah = new SuratPerintah();
$surat_perintah->setField("SURAT_PERINTAH_ID", $reqId);
$surat_perintah->setField("STATUS", "S");
$surat_perintah->updateStatus();

echo "Data berhasil disimpan.";

?>