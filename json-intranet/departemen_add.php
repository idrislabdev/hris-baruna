<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/DepartemenKelas.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$departemen = new Departemen();

$reqId = httpFilterPost("reqId");
$reqCabangId = httpFilterPost("reqCabangId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqPuspel = httpFilterPost("reqPuspel");
$reqStatus= httpFilterPost("reqStatus");
$reqTmtAktif= httpFilterPost("reqTmtAktif");
$reqTmtNonAktif= httpFilterPost("reqTmtNonAktif");
$reqKodeSubBantu = httpFilterPost("reqKodeSubBantu");
$reqKodeBBPangkal = httpFilterPost("reqKodeBBPangkal");
$reqKodeBBSPP = httpFilterPost("reqKodeBBSPP");
$reqKodeBBKegiatan = httpFilterPost("reqKodeBBKegiatan");
$reqKodeBPPangkal = httpFilterPost("reqKodeBPPangkal");
$reqKodeBPSPP = httpFilterPost("reqKodeBPSPP");
$reqKodeBPKegiatan = httpFilterPost("reqKodeBPKegiatan");
$reqKategoriSekolah = httpFilterPost("reqKategoriSekolah");

//$reqNamaKelas = httpFilterPost("reqNamaKelas");
//$reqKeteranganKelas = httpFilterPost("reqKeteranganKelas");
$reqNamaKelas = $_POST["reqNamaKelas"];
$reqKeteranganKelas = $_POST["reqKeteranganKelas"];
$reqDepartemenKelasId = $_POST["reqDepartemenKelasId"];

if($reqMode == "insert")
{
	$departemen->setField("DEPARTEMEN_ID", $reqId);
	$departemen->setField("CABANG_ID", 1);
	$departemen->setField("NAMA", $reqNama);
	$departemen->setField("KETERANGAN", $reqKeterangan);
	$departemen->setField("PUSPEL", $reqPuspel);
	$departemen->setField("STATUS_AKTIF", $reqStatus);
	$departemen->setField("TMT_AKTIF", dateToDBCheck($reqTmtAktif));
	$departemen->setField("TMT_NON_AKTIF", dateToDBCheck($reqTmtNonAktif));
	$departemen->setField("KODE_SUB_BANTU", $reqKodeSubBantu);
	$departemen->setField("KODE_BB_PANGKAL", $reqKodeBBPangkal);
	$departemen->setField("KODE_BB_SPP", $reqKodeBBSPP);
	$departemen->setField("KODE_BB_KEGIATAN", $reqKodeBBKegiatan);
	$departemen->setField("KODE_BP_PANGKAL", $reqKodeBPPangkal);
	$departemen->setField("KODE_BP_SPP", $reqKodeBPSPP);
	$departemen->setField("KODE_BP_KEGIATAN", $reqKodeBPKegiatan);
	$departemen->setField("KATEGORI_SEKOLAH", $reqKategoriSekolah);
	if($departemen->insert())
	{
		echo "Data berhasil disimpan.";
	}
}
else
{
	$departemen->setField("DEPARTEMEN_ID", $reqId);
	$departemen->setField("NAMA", $reqNama);
	$departemen->setField("KETERANGAN", $reqKeterangan);
	$departemen->setField("PUSPEL", $reqPuspel);
	$departemen->setField("STATUS_AKTIF", $reqStatus);
	$departemen->setField("TMT_AKTIF", dateToDBCheck($reqTmtAktif));
	$departemen->setField("TMT_NON_AKTIF", dateToDBCheck($reqTmtNonAktif));
	$departemen->setField("KODE_SUB_BANTU", $reqKodeSubBantu);		
	$departemen->setField("KODE_BB_PANGKAL", $reqKodeBBPangkal);
	$departemen->setField("KODE_BB_SPP", $reqKodeBBSPP);
	$departemen->setField("KODE_BB_KEGIATAN", $reqKodeBBKegiatan);
	$departemen->setField("KODE_BP_PANGKAL", $reqKodeBPPangkal);
	$departemen->setField("KODE_BP_SPP", $reqKodeBPSPP);
	$departemen->setField("KODE_BP_KEGIATAN", $reqKodeBPKegiatan);
	$departemen->setField("KATEGORI_SEKOLAH", $reqKategoriSekolah);
	if($departemen->update())
	{
		for($i=0;$i<count($reqNamaKelas);$i++)
		{
			$departemen_kelas = new DepartemenKelas();
			$departemen_kelas->setField("DEPARTEMEN_ID", $reqId);
			$departemen_kelas->setField("DEPARTEMEN_KELAS_ID", $reqDepartemenKelasId[$i]);	
			$departemen_kelas->setField("NAMA", $reqNamaKelas[$i]);	
			$departemen_kelas->setField("KETERANGAN",  $reqKeteranganKelas[$i]);
			$departemen_kelas->setField("LAST_CREATE_USER",  "");
			$departemen_kelas->setField("LAST_CREATE_DATE",  "SYSDATE");
			if($reqDepartemenKelasId[$i] == "")
				$departemen_kelas->insert();
			else
				$departemen_kelas->update();				
			//echo $departemen_kelas->query;exit;
		}
		echo "Data berhasil disimpan.";
	}
	
}
?>