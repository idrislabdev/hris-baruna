<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");


$kbbt_jur_bb_tmp = new KbbtJurBbTmp();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBuktiSiuk= httpFilterPost("reqNoBuktiSiuk");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqBulan= httpFilterPost("reqBulan");
$reqTahun= httpFilterPost("reqTahun");
$reqNoFaktur= httpFilterPost("reqNoFaktur");
$reqBuktiPendukung= httpFilterPost("reqBuktiPendukung");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPerusahaan= httpFilterPost("reqPerusahaan");
$reqNoDokumen= httpFilterPost("reqNoDokumen");
$reqAlamat= httpFilterPost("reqAlamat");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");

/*$kbbt_jur_bb_tmp->setField("", $reqNoBuktiSiuk);
$kbbt_jur_bb_tmp->setField("", $reqNoValuta);
$kbbt_jur_bb_tmp->setField("", dateToDBCheck($reqTanggalValuta));
$kbbt_jur_bb_tmp->setField("", $reqValuta);
$kbbt_jur_bb_tmp->setField("", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb_tmp->setField("", $reqBulan);
$kbbt_jur_bb_tmp->setField("", $reqTahun);
$kbbt_jur_bb_tmp->setField("", $reqNoFaktur);
$kbbt_jur_bb_tmp->setField("", $reqBuktiPendukung);
$kbbt_jur_bb_tmp->setField("", $reqKeterangan);
$kbbt_jur_bb_tmp->setField("", $reqPerusahaan);
$kbbt_jur_bb_tmp->setField("", $reqNoDokumen);
$kbbt_jur_bb_tmp->setField("", $reqAlamat);
$kbbt_jur_bb_tmp->setField("", dateToDBCheck($reqTanggalPosting));*/

if($reqMode == "insert")
{	
	$kbbt_jur_bb_tmp->setField("KD_CABANG", "96");
	$kbbt_jur_bb_tmp->setField("KD_SUBSIS", "KBB");
	$kbbt_jur_bb_tmp->setField("TIPE_TRANS", "JRR-KBB-01");
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBuktiSiuk);
	$kbbt_jur_bb_tmp->setField("JEN_JURNAL", "JRR");
	$kbbt_jur_bb_tmp->setField("NO_REF1", "");
	$kbbt_jur_bb_tmp->setField("NO_REF2", "");
	$kbbt_jur_bb_tmp->setField("NO_REF3", $reqBuktiPendukung);
	$kbbt_jur_bb_tmp->setField("JEN_TRANS", "");
	$kbbt_jur_bb_tmp->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb_tmp->setField("KD_UNITK", "");
	$kbbt_jur_bb_tmp->setField("KD_KUSTO", "");
	$kbbt_jur_bb_tmp->setField("KD_KLIENT", "");
	$kbbt_jur_bb_tmp->setField("KD_ASSET", "");
	$kbbt_jur_bb_tmp->setField("KD_STOCK", "");
	$kbbt_jur_bb_tmp->setField("THN_BUKU", $reqTahun);
	$kbbt_jur_bb_tmp->setField("BLN_BUKU", $reqBulan);
	$kbbt_jur_bb_tmp->setField("TGL_ENTRY", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb_tmp->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb_tmp->setField("KD_VALUTA", $reqValutaNama);
	$kbbt_jur_bb_tmp->setField("TGL_VALUTA", dateToDBCheck($reqTanggalValuta));
	$kbbt_jur_bb_tmp->setField("KURS_VALUTA", $reqKursValuta);
	$kbbt_jur_bb_tmp->setField("JML_VAL_TRANS", "");
	$kbbt_jur_bb_tmp->setField("JML_RP_TRANS", "");
	$kbbt_jur_bb_tmp->setField("KD_BAYAR", "");
	$kbbt_jur_bb_tmp->setField("KD_BANK", "");
	$kbbt_jur_bb_tmp->setField("NOREK_BANK", $reqNoFaktur);
	$kbbt_jur_bb_tmp->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb_tmp->setField("NO_POSTING", "");
	$kbbt_jur_bb_tmp->setField("KET_TAMBAH", $reqKeterangan);
	$kbbt_jur_bb_tmp->setField("USER_DATA", "");
	$kbbt_jur_bb_tmp->setField("ID_KASIR", "");
	$kbbt_jur_bb_tmp->setField("APPROVER", "");
	$kbbt_jur_bb_tmp->setField("TANDA_TRANS", "");
	$kbbt_jur_bb_tmp->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$kbbt_jur_bb_tmp->setField("LAST_UPDATED_BY", $userLogin->nama);
	$kbbt_jur_bb_tmp->setField("PROGRAM_NAME", "");
	$kbbt_jur_bb_tmp->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb_tmp->setField("NM_AGEN_PERUSH", $reqPerusahaan);
	$kbbt_jur_bb_tmp->setField("ALMT_AGEN_PERUSH", $reqAlamat);
	$kbbt_jur_bb_tmp->setField("URAIAN", "");
	$kbbt_jur_bb_tmp->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
	$kbbt_jur_bb_tmp->setField("JML_CETAK", "");
	$kbbt_jur_bb_tmp->setField("KD_KAS", "");
	$kbbt_jur_bb_tmp->setField("KD_TERMINAL", "");
	$kbbt_jur_bb_tmp->setField("NO_SP", "");
	$kbbt_jur_bb_tmp->setField("TGL_SP", dateToDBCheck(""));
	$kbbt_jur_bb_tmp->setField("NO_KN_BANK", "");
	$kbbt_jur_bb_tmp->setField("TGL_KN_BANK", dateToDBCheck(""));
	$kbbt_jur_bb_tmp->setField("NO_DN", "");
	$kbbt_jur_bb_tmp->setField("TGL_DN", dateToDBCheck(""));
	$kbbt_jur_bb_tmp->setField("NO_REG_KASIR", "");
	$kbbt_jur_bb_tmp->setField("FLAG_SETOR_PAJAK", "");
	$kbbt_jur_bb_tmp->setField("STATUS_PROSES", "");
	$kbbt_jur_bb_tmp->setField("VERIFIED", "");
	$kbbt_jur_bb_tmp->setField("NO_URUT_UPER", "");
	$kbbt_jur_bb_tmp->setField("NO_FAKT_PAJAK", "");	
		
	if($kbbt_jur_bb_tmp->insert())
		echo "Data berhasil disimpan.";
}
else
{	
	$kbbt_jur_bb_tmp->setField("KD_CABANG", "96");
	$kbbt_jur_bb_tmp->setField("KD_SUBSIS", "KBB");
	//$kbbt_jur_bb_tmp->setField("TIPE_TRANS", "JRR-KBB-01");
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBuktiSiuk);
	$kbbt_jur_bb_tmp->setField("JEN_JURNAL", "JRR");
	$kbbt_jur_bb_tmp->setField("NO_REF1", "");
	$kbbt_jur_bb_tmp->setField("NO_REF2", "");
	$kbbt_jur_bb_tmp->setField("NO_REF3", $reqBuktiPendukung);
	$kbbt_jur_bb_tmp->setField("JEN_TRANS", "");
	$kbbt_jur_bb_tmp->setField("KD_SUB_BANTU", "");
	$kbbt_jur_bb_tmp->setField("KD_UNITK", "");
	$kbbt_jur_bb_tmp->setField("KD_KUSTO", "");
	$kbbt_jur_bb_tmp->setField("KD_KLIENT", "");
	$kbbt_jur_bb_tmp->setField("KD_ASSET", "");
	$kbbt_jur_bb_tmp->setField("KD_STOCK", "");
	$kbbt_jur_bb_tmp->setField("THN_BUKU", $reqTahun);
	$kbbt_jur_bb_tmp->setField("BLN_BUKU", $reqBulan);
	$kbbt_jur_bb_tmp->setField("TGL_ENTRY", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb_tmp->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
	$kbbt_jur_bb_tmp->setField("KD_VALUTA", $reqValutaNama);
	$kbbt_jur_bb_tmp->setField("TGL_VALUTA", dateToDBCheck($reqTanggalValuta));
	$kbbt_jur_bb_tmp->setField("KURS_VALUTA", $reqKursValuta);
	$kbbt_jur_bb_tmp->setField("JML_VAL_TRANS", "");
	$kbbt_jur_bb_tmp->setField("JML_RP_TRANS", "");
	$kbbt_jur_bb_tmp->setField("KD_BAYAR", "");
	$kbbt_jur_bb_tmp->setField("KD_BANK", "");
	$kbbt_jur_bb_tmp->setField("NOREK_BANK", $reqNoFaktur);
	$kbbt_jur_bb_tmp->setField("NO_CEK_NOTA", "");
	$kbbt_jur_bb_tmp->setField("NO_POSTING", "");
	$kbbt_jur_bb_tmp->setField("KET_TAMBAH", $reqKeterangan);
	$kbbt_jur_bb_tmp->setField("USER_DATA", "");
	$kbbt_jur_bb_tmp->setField("ID_KASIR", "");
	$kbbt_jur_bb_tmp->setField("APPROVER", "");
	$kbbt_jur_bb_tmp->setField("TANDA_TRANS", "");
	$kbbt_jur_bb_tmp->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$kbbt_jur_bb_tmp->setField("LAST_UPDATED_BY", $userLogin->nama);
	$kbbt_jur_bb_tmp->setField("PROGRAM_NAME", "");
	$kbbt_jur_bb_tmp->setField("KD_BUKU_PUSAT", "");
	$kbbt_jur_bb_tmp->setField("NM_AGEN_PERUSH", $reqPerusahaan);
	$kbbt_jur_bb_tmp->setField("ALMT_AGEN_PERUSH", $reqAlamat);
	$kbbt_jur_bb_tmp->setField("URAIAN", "");
	$kbbt_jur_bb_tmp->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
	$kbbt_jur_bb_tmp->setField("JML_CETAK", "");
	$kbbt_jur_bb_tmp->setField("KD_KAS", "");
	$kbbt_jur_bb_tmp->setField("KD_TERMINAL", "");
	$kbbt_jur_bb_tmp->setField("NO_SP", "");
	$kbbt_jur_bb_tmp->setField("TGL_SP", dateToDBCheck(""));
	$kbbt_jur_bb_tmp->setField("NO_KN_BANK", "");
	$kbbt_jur_bb_tmp->setField("TGL_KN_BANK", dateToDBCheck(""));
	$kbbt_jur_bb_tmp->setField("NO_DN", "");
	$kbbt_jur_bb_tmp->setField("TGL_DN", dateToDBCheck(""));
	$kbbt_jur_bb_tmp->setField("NO_REG_KASIR", "");
	$kbbt_jur_bb_tmp->setField("FLAG_SETOR_PAJAK", "");
	$kbbt_jur_bb_tmp->setField("STATUS_PROSES", "");
	$kbbt_jur_bb_tmp->setField("VERIFIED", "");
	$kbbt_jur_bb_tmp->setField("NO_URUT_UPER", "");
	$kbbt_jur_bb_tmp->setField("NO_FAKT_PAJAK", "");		
		
	if($kbbt_jur_bb_tmp->update())
		echo "Data berhasil disimpan.";
			
}
?>