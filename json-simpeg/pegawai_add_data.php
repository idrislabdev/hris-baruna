<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pegawai = new Pegawai();
$user_login = new UserLoginBase();

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
$reqTanggalMasuk= httpFilterPost("reqTanggalMasuk");
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
$reqKtpNo= httpFilterPost("reqKtpNo");
$reqTMTNONAKTIF= httpFilterPost("reqTMTNONAKTIF");

$reqTinggi= httpFilterPost("reqTinggi");
$reqBeratBadan= httpFilterPost("reqBeratBadan");

$reqJamsostek = httpFilterPost("reqJamsostek");
$reqJamsostekTanggal = httpFilterPost("reqJamsostekTanggal");
$reqHomeBase = httpFilterPost("reqHomeBase");

$reqBidang_studi= httpFilterPost("reqBidang_studi");
$reqLineritas= httpFilterPost("reqLineritas");
$reqSpesifikasi_prestasi_karya= httpFilterPost("reqSpesifikasi_prestasi_karya");
$reqTugas_pembimbingan= httpFilterPost("reqTugas_pembimbingan");

if($reqDepartemen == 0)
	$reqDepartemen = "NULL";
else
	$reqDepartemen = "'".$reqDepartemen."'";


$pegawai->setField('LOKASI_ID', $reqHomeBase);
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
$pegawai->setField('TANGGAL_MASUK', dateToDBCheck($reqTanggalMasuk));
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
$pegawai->setField('TINGGI', $reqTinggi);
$pegawai->setField('BERAT_BADAN', $reqBeratBadan);
$pegawai->setField('KTP_NO', $reqKtpNo);
$pegawai->setField('BIDANG_STUDI', $reqBidang_studi);
$pegawai->setField('LINERITAS', $reqLineritas);
$pegawai->setField('SPESIFIKASI_PRESTASI_KARYA', $reqSpesifikasi_prestasi_karya);
$pegawai->setField('TUGAS_PEMBIMBINGAN', $reqTugas_pembimbingan);


		if($reqStatusPegawai == 1)
		{
			$pegawai->setField('TANGGAL_PENSIUN', 'NULL');
			$pegawai->setField('TANGGAL_MUTASI_KELUAR', 'NULL');
			$pegawai->setField('TANGGAL_WAFAT', 'NULL');
			
			$pegawai->setField('NO_MPP', 'NULL');
			$pegawai->setField('TANGGAL_MPP', 'NULL');
			$pegawai->setField('TGL_NON_AKTIF', 'NULL');
		}
		else
		{
			$pegawai->setField('TANGGAL_PENSIUN', dateToDBCheck($reqTglPensiun));
			$pegawai->setField('TANGGAL_MUTASI_KELUAR', dateToDBCheck($reqTglMutasiKeluar));
			$pegawai->setField('TANGGAL_WAFAT', dateToDBCheck($reqTglWafat));
			
			$pegawai->setField('NO_MPP', $reqNoSKMPP);
			$pegawai->setField('TANGGAL_MPP', dateToDBCheck($reqTMTMPP));
			$pegawai->setField('TGL_NON_AKTIF', dateToDBCheck($reqTMTNONAKTIF));
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

		/* CREATE USER_LOGIN */
		$user_login->setField("DEPARTEMEN_ID", $reqDepartemen);
		$user_login->setField("USER_GROUP_ID", 2);
		$user_login->setField("NAMA", $reqNama);
		$user_login->setField("JABATAN", "");
		$user_login->setField("EMAIL", $reqEmail);
		$user_login->setField("TELEPON", $reqTelepon);
		$user_login->setField("USER_LOGIN", substr($reqNRP, -5));
		$user_login->setField("USER_PASS", substr($reqNRP, -5));
		$user_login->setField("STATUS", 1);
		$user_login->setField("LAST_CREATE_USER", $userLogin->UID);
		$user_login->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
		$user_login->setField("PEGAWAI_ID", $id);	
	
		if($user_login->insert())
		{
		}
				
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
		
		/* JIKA NON AKTIF, NON AKTIFKAN JUGA USER LOGIN */
		if($reqStatusPegawai == 6)
		{
			$user_login->setField("STATUS", 0);
			$user_login->setField("PEGAWAI_ID", $reqId);
			$user_login->updateStatusAktif();	
		}
		
		echo $id."-Data berhasil disimpan.";
	}
}
?>