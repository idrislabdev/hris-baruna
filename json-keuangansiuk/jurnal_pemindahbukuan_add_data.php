<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");


$kbbt_jur_bb = new KbbtJurBb();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBuktiSiuk= httpFilterPost("reqNoBuktiSiuk");
//$reqValuta= httpFilterPost("reqValuta");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqBuktiPendukung= httpFilterPost("reqBuktiPendukung");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPerusahaan= httpFilterPost("reqPerusahaan");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqAlamat= httpFilterPost("reqAlamat");

/*$kbbt_jur_bb->setField("", $reqNoBukti);
$kbbt_jur_bb->setField("", $reqValuta);
$kbbt_jur_bb->setField("", $reqValutaNama);
$kbbt_jur_bb->setField("", $reqBuktiPendukung);
$kbbt_jur_bb->setField("", $reqKursValuta);
$kbbt_jur_bb->setField("", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("", $reqKeterangan);
$kbbt_jur_bb->setField("", $reqPerusahaan);
$kbbt_jur_bb->setField("", $reqNoPosting);
$kbbt_jur_bb->setField("", dateToDBCheck($reqTanggalPosting));
$kbbt_jur_bb->setField("", $reqAlamat);*/


if($reqMode == "insert")
{	
	$kbbt_jur_bb->setField("KD_CABANG", "96");
	$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
	$kbbt_jur_bb->setField("TIPE_TRANS", "JKM-KBB-03");
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBuktiSiuk);
	$kbbt_jur_bb->setField("JEN_JURNAL", "JKM");
	$kbbt_jur_bb->setField("NO_REF1", "");
	$kbbt_jur_bb->setField("NO_REF2", "");
	$kbbt_jur_bb->setField("NO_REF3", $reqBuktiPendukung);
	$kbbt_jur_bb->setField("JEN_TRANS", "");
	$kbbt_jur_bb->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb->setField("KD_UNITK", "");
	$kbbt_jur_bb->setField("KD_KUSTO", "");
	$kbbt_jur_bb->setField("KD_KLIENT", "");
	$kbbt_jur_bb->setField("KD_ASSET", "");
	$kbbt_jur_bb->setField("KD_STOCK", "");
	$kbbt_jur_bb->setField("THN_BUKU", $reqTahun);
	$kbbt_jur_bb->setField("BLN_BUKU", $reqBulan);
	$kbbt_jur_bb->setField("TGL_ENTRY", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb->setField("KD_VALUTA", $reqValutaNama);
	$kbbt_jur_bb->setField("TGL_VALUTA", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb->setField("KURS_VALUTA", $reqKursValuta);
	$kbbt_jur_bb->setField("JML_VAL_TRANS", "");
	$kbbt_jur_bb->setField("JML_RP_TRANS", "");
	$kbbt_jur_bb->setField("KD_BAYAR", "");
	$kbbt_jur_bb->setField("KD_BANK", "");
	$kbbt_jur_bb->setField("NOREK_BANK", "");
	$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb->setField("NO_POSTING", $reqNoPosting);
	$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeterangan);
	$kbbt_jur_bb->setField("USER_DATA", "");
	$kbbt_jur_bb->setField("ID_KASIR", "");
	$kbbt_jur_bb->setField("APPROVER", "");
	$kbbt_jur_bb->setField("TANDA_TRANS", "");
	$kbbt_jur_bb->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$kbbt_jur_bb->setField("LAST_UPDATED_BY", $userLogin->nama);
	$kbbt_jur_bb->setField("PROGRAM_NAME", "");
	$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb->setField("NM_AGEN_PERUSH", $reqPerusahaan);
	$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", $reqAlamat);
	$kbbt_jur_bb->setField("URAIAN", "");
	$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
	$kbbt_jur_bb->setField("JML_CETAK", "");
	$kbbt_jur_bb->setField("KD_KAS", "");
	$kbbt_jur_bb->setField("KD_TERMINAL", "");
	$kbbt_jur_bb->setField("NO_SP", "");
	$kbbt_jur_bb->setField("TGL_SP", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_KN_BANK", "");
	$kbbt_jur_bb->setField("TGL_KN_BANK", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_DN", "");
	$kbbt_jur_bb->setField("TGL_DN", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_REG_KASIR", "");
	$kbbt_jur_bb->setField("FLAG_SETOR_PAJAK", "");
	$kbbt_jur_bb->setField("STATUS_PROSES", "");
	$kbbt_jur_bb->setField("VERIFIED", "");
	$kbbt_jur_bb->setField("NO_URUT_UPER", "");
	$kbbt_jur_bb->setField("NO_FAKT_PAJAK", "");
		
	if($kbbt_jur_bb->insert())
	{
		$set= new KbbtJurBb();
		$set->setField("NO_NOTA", $reqNoBuktiSiuk);
		$set->callPKbbtJurBbToTmp();
		echo "Data berhasil disimpan.";
	}
}
else
{	
	$set= new KbbtJurBb();
	$set->setField("NO_NOTA", $reqNoBuktiSiuk);
	$set->delete();
	unset($set);

	$kbbt_jur_bb->setField("KD_CABANG", "96");
	$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
	$kbbt_jur_bb->setField("TIPE_TRANS", "JKM-KBB-03");
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBuktiSiuk);
	$kbbt_jur_bb->setField("JEN_JURNAL", "JKM");
	$kbbt_jur_bb->setField("NO_REF1", "");
	$kbbt_jur_bb->setField("NO_REF2", "");
	$kbbt_jur_bb->setField("NO_REF3", $reqBuktiPendukung);
	$kbbt_jur_bb->setField("JEN_TRANS", "");
	$kbbt_jur_bb->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb->setField("KD_UNITK", "");
	$kbbt_jur_bb->setField("KD_KUSTO", "");
	$kbbt_jur_bb->setField("KD_KLIENT", "");
	$kbbt_jur_bb->setField("KD_ASSET", "");
	$kbbt_jur_bb->setField("KD_STOCK", "");
	$kbbt_jur_bb->setField("THN_BUKU", $reqTahun);
	$kbbt_jur_bb->setField("BLN_BUKU", $reqBulan);
	$kbbt_jur_bb->setField("TGL_ENTRY", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb->setField("KD_VALUTA", $reqValutaNama);
	$kbbt_jur_bb->setField("TGL_VALUTA", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb->setField("KURS_VALUTA", $reqKursValuta);
	$kbbt_jur_bb->setField("JML_VAL_TRANS", "");
	$kbbt_jur_bb->setField("JML_RP_TRANS", "");
	$kbbt_jur_bb->setField("KD_BAYAR", "");
	$kbbt_jur_bb->setField("KD_BANK", "");
	$kbbt_jur_bb->setField("NOREK_BANK", "");
	$kbbt_jur_bb->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb->setField("NO_POSTING", $reqNoPosting);
	$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeterangan);
	$kbbt_jur_bb->setField("USER_DATA", "");
	$kbbt_jur_bb->setField("ID_KASIR", "");
	$kbbt_jur_bb->setField("APPROVER", "");
	$kbbt_jur_bb->setField("TANDA_TRANS", "");
	$kbbt_jur_bb->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$kbbt_jur_bb->setField("LAST_UPDATED_BY", $userLogin->nama);
	$kbbt_jur_bb->setField("PROGRAM_NAME", "");
	$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb->setField("NM_AGEN_PERUSH", $reqPerusahaan);
	$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", $reqAlamat);
	$kbbt_jur_bb->setField("URAIAN", "");
	$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
	$kbbt_jur_bb->setField("JML_CETAK", "");
	$kbbt_jur_bb->setField("KD_KAS", "");
	$kbbt_jur_bb->setField("KD_TERMINAL", "");
	$kbbt_jur_bb->setField("NO_SP", "");
	$kbbt_jur_bb->setField("TGL_SP", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_KN_BANK", "");
	$kbbt_jur_bb->setField("TGL_KN_BANK", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_DN", "");
	$kbbt_jur_bb->setField("TGL_DN", dateToDBCheck(""));
	$kbbt_jur_bb->setField("NO_REG_KASIR", "");
	$kbbt_jur_bb->setField("FLAG_SETOR_PAJAK", "");
	$kbbt_jur_bb->setField("STATUS_PROSES", "");
	$kbbt_jur_bb->setField("VERIFIED", "");
	$kbbt_jur_bb->setField("NO_URUT_UPER", "");
	$kbbt_jur_bb->setField("NO_FAKT_PAJAK", "");
	
	if($kbbt_jur_bb->insert())
	{
		$set= new KbbtJurBb();
		$set->setField("NO_NOTA", $reqNoBuktiSiuk);
		$set->callPKbbtJurBbToTmp();
		unset($set);
		echo "Data berhasil disimpan.";
	}
}
?>