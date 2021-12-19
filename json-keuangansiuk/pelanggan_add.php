<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKartuTambah.php");


$pelanggan = new SafmPelanggan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqAlamat= httpFilterPost("reqAlamat");
$reqKota= httpFilterPost("reqKota");
$reqNoTelepon= httpFilterPost("reqNoTelepon");
$reqEmail= httpFilterPost("reqEmail");
$reqContPerson= httpFilterPost("reqContPerson");
$reqJenisUsaha= httpFilterPost("reqJenisUsaha");
$reqBadanUsaha= httpFilterPost("reqBadanUsaha");
$reqNpwp= httpFilterPost("reqNpwp");
$reqSiup= httpFilterPost("reqSiup");
$reqTanggalSiup= httpFilterPost("reqTanggalSiup");
$reqNoWd= httpFilterPost("reqNoWd");
$reqBankRp= httpFilterPost("reqBankRp");
$reqBankUs= httpFilterPost("reqBankUs");

	
if($reqMode == "insert")
{	
	
	if($reqKode == "")
		$reqKode = $pelanggan->getKodePelanggan();

	$pelanggan->setField("KD_CABANG", "96");	
	$pelanggan->setField("JENIS_TABLE", "M");
	$pelanggan->setField("ID_TABLE", "SAFMPLG");	
    $pelanggan->setField("MPLG_KODE", $reqKode);
	$pelanggan->setField("MPLG_NAMA", $reqNama);
	$pelanggan->setField("MPLG_ALAMAT", $reqAlamat);
	$pelanggan->setField("MPLG_KOTA", $reqKota);
	$pelanggan->setField("MPLG_JENIS_USAHA", $reqJenisUsaha);
	$pelanggan->setField("MPLG_BADAN_USAHA", $reqBadanUsaha);
	$pelanggan->setField("MPLG_CONT_PERSON", $reqContPerson);
	$pelanggan->setField("MPLG_TELEPON", $reqNoTelepon);	
	$pelanggan->setField("MPLG_EMAIL_ADDRESS", $reqEmail);
	$pelanggan->setField("MPLG_FAX", "");	
	$pelanggan->setField("MPLG_NPWP", $reqNpwp);	
	$pelanggan->setField("MPLG_SIUP", $reqSiup);
	$pelanggan->setField("MPLG_TGL_SIUP", dateToDBCheck($reqTanggalSiup));
	$pelanggan->setField("MPLG_STATUS_HUTANG", "");
	$pelanggan->setField("MPLG_SALDO_HUTANG", "");
	$pelanggan->setField("MPLG_SALDO_HUTANG_USD", "");
	$pelanggan->setField("MPLG_SALDO_UPER_IDR", "");	
	$pelanggan->setField("MPLG_SALDO_UPER_USD", "");
	$pelanggan->setField("MPLG_MAKSIMUM_HUTANG", "");
	$pelanggan->setField("MPLG_MIN_WD_SEDIA", "");
	$pelanggan->setField("MPLG_LIMIT_WD", "");	
	$pelanggan->setField("MPLG_PRKT_KLAS_USAHA", "");
	$pelanggan->setField("MPLG_PRKT_NILAI_ASET", "");
	$pelanggan->setField("MPLG_PRKT_NILAI_TRANS", "");
	$pelanggan->setField("MPLG_JML_DENDA", "");
	$pelanggan->setField("LAST_UPDATED_DATE", OCI_SYSDATE);
	$pelanggan->setField("LAST_UPDATED_BY", $userLogin->nama);	
	$pelanggan->setField("PROGRAM_NAME", "KBB_M_SAFM_PELANGGAN_NEW_IMAIS");
	$pelanggan->setField("MPLG_SISA_UPER_IDR", "");
	$pelanggan->setField("MPLG_SISA_UPER_USD", "");
	$pelanggan->setField("MPLG_TITIPAN_LAIN_IDR", "");	
	$pelanggan->setField("MPLG_TITIPAN_LAIN_USD", "");
	$pelanggan->setField("MPLG_JNS_WD", "");
	$pelanggan->setField("MPLG_NO_WD", $reqNoWd);
	$pelanggan->setField("FLAG_KAPAL", "");	
	$pelanggan->setField("FLAG_BARANG", "");
	$pelanggan->setField("FLAG_UST", "");
	$pelanggan->setField("FLAG_PROP", "");	
	$pelanggan->setField("FLAG_PAS", "");
	$pelanggan->setField("FLAG_RUPA", "");
	$pelanggan->setField("FLAG_KSU", "");	
	$pelanggan->setField("FLAG_KEU", "");
	$pelanggan->setField("FLAG_WD_UPER", "");
	$pelanggan->setField("MBANK_KODE_RUPIAH", "");	
	$pelanggan->setField("FLAG_KEU", "");
	$pelanggan->setField("FLAG_WD_UPER", "");
	$pelanggan->setField("MBANK_KODE_RUPIAH", $reqBankRp);
	$pelanggan->setField("MBANK_KODE_VALAS", $reqBankUs);	
	$pelanggan->setField("MPLG_KODE_BARU", "");
	$pelanggan->setField("MBANK_KODE", "");
	$pelanggan->setField("FLAG_GROUP_PIUTANG", "");
		
	if($pelanggan->insert())
	{
		/*
		$kbbr_kartu_tambah = new KbbrKartuTambah();
		$kbbr_kartu_tambah->setField("KD_CABANG", "96");	
		$kbbr_kartu_tambah->setField("ID_JEN_KARTU", "JENISKARTU");	
		$kbbr_kartu_tambah->setField("KD_SUB_BANTU", $reqKode);	
		$kbbr_kartu_tambah->setField("NM_SUB_BANTU", $reqNama);	
		$kbbr_kartu_tambah->setField("REF_MBANTU", $reqBadanUsaha);	
		$kbbr_kartu_tambah->setField("FLAG_PELANGGAN", "Y");	
		$kbbr_kartu_tambah->setField("KD_AKTIF", "A");
		$kbbr_kartu_tambah->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$kbbr_kartu_tambah->setField("LAST_UPDATED_BY", $userLogin->nama);	
		$kbbr_kartu_tambah->setField("PROGRAM_NAME", "KBB_M_SAFM_PELANGGAN_IMAIS");	
		$kbbr_kartu_tambah->insert();
		unset($kbbr_kartu_tambah);
		*/
		
		echo "Data berhasil disimpan.";
		
	}
	
	//echo $pelanggan->query;
}
else
{	
	$pelanggan->setField("KD_CABANG", "96");	
	$pelanggan->setField("JENIS_TABLE", "M");
	$pelanggan->setField("ID_TABLE", "SAFMPLG");	
    $pelanggan->setField("MPLG_KODE", $reqKode);
	$pelanggan->setField("MPLG_NAMA", $reqNama);
	$pelanggan->setField("MPLG_ALAMAT", $reqAlamat);
	$pelanggan->setField("MPLG_KOTA", $reqKota);
	$pelanggan->setField("MPLG_JENIS_USAHA", $reqJenisUsaha);
	$pelanggan->setField("MPLG_BADAN_USAHA", $reqBadanUsaha);
	$pelanggan->setField("MPLG_CONT_PERSON", $reqContPerson);
	$pelanggan->setField("MPLG_TELEPON", $reqNoTelepon);	
	$pelanggan->setField("MPLG_EMAIL_ADDRESS", $reqEmail);
	$pelanggan->setField("MPLG_FAX", "");	
	$pelanggan->setField("MPLG_NPWP", $reqNpwp);	
	$pelanggan->setField("MPLG_SIUP", $reqSiup);
	$pelanggan->setField("MPLG_TGL_SIUP", dateToDBCheck($reqTanggalSiup));
	$pelanggan->setField("MPLG_STATUS_HUTANG", "");
	$pelanggan->setField("MPLG_SALDO_HUTANG", "");
	$pelanggan->setField("MPLG_SALDO_HUTANG_USD", "");
	$pelanggan->setField("MPLG_SALDO_UPER_IDR", "");	
	$pelanggan->setField("MPLG_SALDO_UPER_USD", "");
	$pelanggan->setField("MPLG_MAKSIMUM_HUTANG", "");
	$pelanggan->setField("MPLG_MIN_WD_SEDIA", "");
	$pelanggan->setField("MPLG_LIMIT_WD", "");	
	$pelanggan->setField("MPLG_PRKT_KLAS_USAHA", "");
	$pelanggan->setField("MPLG_PRKT_NILAI_ASET", "");
	$pelanggan->setField("MPLG_PRKT_NILAI_TRANS", "");
	$pelanggan->setField("MPLG_JML_DENDA", "");
	$pelanggan->setField("LAST_UPDATED_DATE", OCI_SYSDATE);
	$pelanggan->setField("LAST_UPDATED_BY", $userLogin->nama);	
	$pelanggan->setField("PROGRAM_NAME", "KBB_M_SAFM_PELANGGAN_NEW_IMAIS");
	$pelanggan->setField("MPLG_SISA_UPER_IDR", "");
	$pelanggan->setField("MPLG_SISA_UPER_USD", "");
	$pelanggan->setField("MPLG_TITIPAN_LAIN_IDR", "");	
	$pelanggan->setField("MPLG_TITIPAN_LAIN_USD", "");
	$pelanggan->setField("MPLG_JNS_WD", "");
	$pelanggan->setField("MPLG_NO_WD", $reqNoWd);
	$pelanggan->setField("FLAG_KAPAL", "");	
	$pelanggan->setField("FLAG_BARANG", "");
	$pelanggan->setField("FLAG_UST", "");
	$pelanggan->setField("FLAG_PROP", "");	
	$pelanggan->setField("FLAG_PAS", "");
	$pelanggan->setField("FLAG_RUPA", "");
	$pelanggan->setField("FLAG_KSU", "");	
	$pelanggan->setField("FLAG_KEU", "");
	$pelanggan->setField("FLAG_WD_UPER", "");
	$pelanggan->setField("MBANK_KODE_RUPIAH", "");	
	$pelanggan->setField("FLAG_KEU", "");
	$pelanggan->setField("FLAG_WD_UPER", "");
	$pelanggan->setField("MBANK_KODE_RUPIAH", $reqBankRp);
	$pelanggan->setField("MBANK_KODE_VALAS", $reqBankUs);	
	$pelanggan->setField("MPLG_KODE_BARU", "");
	$pelanggan->setField("MBANK_KODE", "");
	$pelanggan->setField("FLAG_GROUP_PIUTANG", "");
		
	if($pelanggan->update())
	{
		$kbbr_kartu_tambah = new KbbrKartuTambah();
		$kbbr_kartu_tambah->setField("KD_CABANG", "96");	
		$kbbr_kartu_tambah->setField("ID_JEN_KARTU", "JENISKARTU");	
		$kbbr_kartu_tambah->setField("KD_SUB_BANTU", $reqKode);	
		$kbbr_kartu_tambah->setField("NM_SUB_BANTU", $reqNama);	
		$kbbr_kartu_tambah->setField("REF_MBANTU", $reqBadanUsaha);	
		$kbbr_kartu_tambah->setField("FLAG_PELANGGAN", "Y");	
		$kbbr_kartu_tambah->setField("KD_AKTIF", "A");
		$kbbr_kartu_tambah->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$kbbr_kartu_tambah->setField("LAST_UPDATED_BY", $userLogin->nama);	
		$kbbr_kartu_tambah->setField("PROGRAM_NAME", "KBB_M_SAFM_PELANGGAN_IMAIS");	
		$kbbr_kartu_tambah->update();
		
		unset($kbbr_kartu_tambah);
		
		echo "Data berhasil disimpan.";
	}
}
?>