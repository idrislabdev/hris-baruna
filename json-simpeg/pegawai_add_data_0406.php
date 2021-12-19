<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
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
$reqTanggalNpwp= httpFilterPost("reqTanggalNpwp");
$reqAlamat= httpFilterPost("reqAlamat");
$reqTelepon== httpFilterPost("reqTelepon");
$reqEmail= httpFilterPost("reqEmail");
$reqGolDarah= httpFilterPost("reqGolDarah");
$reqStatusPernikahan= httpFilterPost("reqStatusPernikahan");
$reqNRP= httpFilterPost("reqNRP");
$reqLinkFile = $_FILES["reqLinkFile"];
$reqFingerId= httpFilterPost("reqFingerId");

$reqStatusPegawai= httpFilterPost("reqStatusPegawai");
$reqStatusKeluarga= httpFilterPost("reqStatusKeluarga");
$reqBankId= httpFilterPost("reqBankId");
$reqRekeningNo= httpFilterPost("reqRekeningNo");
$reqRekeningNama= httpFilterPost("reqRekeningNama");
$reqNPWP= httpFilterPost("reqNPWP");
$reqTglPensiun= httpFilterPost("reqTglPensiun");
$reqTglMutasiKeluar= httpFilterPost("reqTglMutasiKeluar");
$reqTglWafat= httpFilterPost("reqTglWafat");
$reqNoSKMPP= httpFilterPost("reqNoSKMPP");
$reqTMTMPP= httpFilterPost("reqTMTMPP");
$reqHobby= httpFilterPost("reqHobby");
$reqFingerId= httpFilterPost("reqFingerId");

$reqJamsostek = httpFilterPost("reqJamsostek");
$reqJamsostekTanggal = httpFilterPost("reqJamsostekTanggal");

if($reqDepartemen == 0)
	$reqDepartemen = "NULL";
else
	$reqDepartemen = "'".$reqDepartemen."'";

$pegawai->setField('PEGAWAI_ID', $reqId);
$pegawai->setField('DEPARTEMEN_ID', $reqDepartemen);
$pegawai->setField('NRP', $reqNRP);
$pegawai->setField('NIPP', $reqNPP);
$pegawai->setField('NAMA', $reqNama);
$pegawai->setField('AGAMA_ID', $reqAgamaId);
$pegawai->setField('JENIS_KELAMIN', $reqJenisKelamin);
$pegawai->setField('PELABUHAN_ID', $reqAsalPelabuhanId);
$pegawai->setField('TEMPAT_LAHIR', $reqTempat);
$pegawai->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggal));
$pegawai->setField('ALAMAT', $reqAlamat);
$pegawai->setField('TELEPON', $reqTelepon);
$pegawai->setField('EMAIL', $reqEmail);
$pegawai->setField('GOLONGAN_DARAH', $reqGolDarah);
$pegawai->setField('STATUS_KAWIN', $reqStatusPernikahan);
$pegawai->setField('STATUS_PEGAWAI_ID', $reqStatusPegawai);
$pegawai->setField('BANK_ID', $reqBankId);
$pegawai->setField('REKENING_NO', $reqRekeningNo);
$pegawai->setField('REKENING_NAMA', $reqRekeningNama);
$pegawai->setField('NPWP', $reqNPWP);
$pegawai->setField('STATUS_KELUARGA_ID', $reqStatusKeluarga);
$pegawai->setField('JAMSOSTEK_NO', $reqJamsostek);
$pegawai->setField('JAMSOSTEK_TANGGAL', dateToDBCheck($reqJamsostekTanggal));
$pegawai->setField('HOBBY', $reqHobby);
$pegawai->setField('FINGER_ID', $reqFingerId);
$pegawai->setField('TANGGAL_NPWP', dateToDBCheck($reqTanggalNpwp));

		if($reqStatusPegawai == 1)
		{
			$pegawai->setField('TANGGAL_PENSIUN', 'NULL');
			$pegawai->setField('TANGGAL_MUTASI_KELUAR', 'NULL');
			$pegawai->setField('TANGGAL_WAFAT', 'NULL');
			
			$pegawai->setField('NO_MPP', 'NULL');
			$pegawai->setField('TANGGAL_MPP', 'NULL');
		}
		else
		{
			$pegawai->setField('TANGGAL_PENSIUN', dateToDBCheck($reqTglPensiun));
			$pegawai->setField('TANGGAL_MUTASI_KELUAR', dateToDBCheck($reqTglMutasiKeluar));
			$pegawai->setField('TANGGAL_WAFAT', dateToDBCheck($reqTglWafat));
			
			$pegawai->setField('NO_MPP', $reqNoSKMPP);
			$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
		}

//$pegawai->setField("NAMA", $_FILES['reqLinkFile']['name']);
//$pegawai->setField("HASIL_RAPAT_ID", $reqId);
//$pegawai->setField("FILE_NAMA", $_FILES['reqLinkFile']['name']);
//$pegawai->setField("UKURAN", $_FILES['reqLinkFile']['size']);
//$pegawai->setField("FORMAT", $_FILES['reqLinkFile']['type']);
	
if($reqMode == "insert")
{
	$pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	//PEGAWAI_ID, FOTO, 
	if($pegawai->insert()){
		$id = $pegawai->id;
		
		if($reqLinkFile['tmp_name'])
			$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
		
		echo $id."-Data berhasil disimpan.";
	}
	//echo $pegawai->query;
}
else
{

	$pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	if($pegawai->update()){
		$id = $reqId;
		
		if($reqLinkFile['tmp_name'])
			$pegawai->upload("PPI_SIMPEG.PEGAWAI", "FOTO", $reqLinkFile['tmp_name'], "PEGAWAI_ID = ".$id);
		
		
		echo $id."-Data berhasil disimpan.";
	}
}
?>