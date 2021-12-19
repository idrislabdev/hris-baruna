<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai = new Pegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");

$reqNPP= httpFilterPost("reqNPP");
$reqNama= httpFilterPost("reqNama");
$reqAgamaId= httpFilterPost("reqAgamaId");
$reqJenisKelamin= httpFilterPost("reqJenisKelamin");
$reqAsalPelabuhanId= httpFilterPost("reqAsalPelabuhanId");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqTempat= httpFilterPost("reqTempat");
$reqTanggal= httpFilterPost("reqTanggal");
$reqAlamat= httpFilterPost("reqAlamat");
$reqTelepon== httpFilterPost("reqTelepon");
$reqEmail= httpFilterPost("reqEmail");
$reqNIS= httpFilterPost("reqNIS");
$reqTMTJenisPegawai= httpFilterPost("reqTMTJenisPegawai");
$reqLinkFile = $_FILES["reqLinkFile"];
if ($reqDepartemen == '16') 
{
	$reqDepartemenKelasId = '70';
}
$reqStatusPegawai= httpFilterPost("reqStatusPegawai");

if ($reqTMTJenisPegawai =='') 
{
	$reqTMTJenisPegawai = 'NULL';
}
else
	$reqTMTJenisPegawai = $reqTMTJenisPegawai;

$reqKelasSekolah= httpFilterPost("reqKelasSekolah");
$reqAsalSekolah= httpFilterPost("reqAsalSekolah");
$reqJurusanSekolah= httpFilterPost("reqJurusanSekolah");
$reqTanggalAwal= httpFilterPost("reqTanggalAwal");
$reqTanggalAkhir= httpFilterPost("reqTanggalAkhir");
$reqJenisMagang = httpFilterPost("reqJenisMagang");
if($reqDepartemen == 0)
	$reqDepartemen = "NULL";
else
	$reqDepartemen = "'".$reqDepartemen."'";

$pegawai->setField("DEPARTEMEN_ID", $reqDepartemen);
$pegawai->setField("NIS", $reqNIS);
$pegawai->setField("NAMA", $reqNama);
$pegawai->setField("AGAMA_ID", $reqAgamaId);
$pegawai->setField("JENIS_KELAMIN", $reqJenisKelamin);
$pegawai->setField("TEMPAT_LAHIR", $reqTempat);
$pegawai->setField("TANGGAL_LAHIR", dateToDBCheck($reqTanggal));
$pegawai->setField("ALAMAT", $reqAlamat);
$pegawai->setField("TELEPON", $reqTelepon);
$pegawai->setField("EMAIL", $reqEmail);
$pegawai->setField("STATUS_PEGAWAI_ID", "1");
$pegawai->setField("MAGANG_TIPE", $reqJenisMagang);
		
if($reqMode == "insert")
{
	$pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	

	if($pegawai->insertKadet())
	{
		$id = $pegawai->id;
		
		if($reqLinkFile['tmp_name'])
			$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
		
		$pegawai_jenis_pegawai= new PegawaiJenisPegawai();
		$pegawai_jenis_pegawai->setField("KELAS_SEKOLAH",$reqKelasSekolah);
		$pegawai_jenis_pegawai->setField("ASAL_SEKOLAH",$reqAsalSekolah);
		$pegawai_jenis_pegawai->setField("DEPARTEMEN_KELAS_ID",$reqDepartemenKelasId);
		$pegawai_jenis_pegawai->setField("TMT_JENIS_PEGAWAI",$reqTMTJenisPegawai);
		$pegawai_jenis_pegawai->setField("JURUSAN",$reqJurusanSekolah);
		$pegawai_jenis_pegawai->setField("PEGAWAI_ID",$id);
		$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID",'8');
		$pegawai_jenis_pegawai->setField("TANGGAL_KONTRAK_AWAL", dateToDBCheck($reqTanggalAwal));
		$pegawai_jenis_pegawai->setField("TANGGAL_KONTRAK_AKHIR", dateToDBCheck($reqTanggalAkhir));
		$pegawai_jenis_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
		$pegawai_jenis_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
		if($pegawai_jenis_pegawai->insertKadet()){}
		
		echo $id."-Data berhasil disimpan.";
	}
}
else
{
	$pegawai->setField("PEGAWAI_ID", $reqId);
	$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	if($pegawai->updateKadet())
	{
		$id = $reqId;
		
		if($reqLinkFile['tmp_name'])
			$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
		
		
		echo $id."-Data berhasil disimpan.";
	}
}
?>