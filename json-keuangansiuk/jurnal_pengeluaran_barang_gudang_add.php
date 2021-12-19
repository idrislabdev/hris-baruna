<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kbbr_tipe_trans_d = new KbbrTipeTransD();


$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti = httpFilterPost("reqNoBukti");
$reqValuta= httpFilterPost("reqValuta");
$reqBuktiPendukung= httpFilterPost("reqBuktiPendukung");
$reqBuktiPendukung2= httpFilterPost("reqBuktiPendukung2");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqNoFakturPajak= httpFilterPost("reqNoFakturPajak");
$reqPerusahaan= httpFilterPost("reqPerusahaan");
$reqKeteranganJurnal= httpFilterPost("reqKeteranganJurnal");
$reqAlamat= httpFilterPost("reqAlamat");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqJumlahDebet = httpFilterPost("reqJumlahDebet");
$reqKusto = httpFilterPost("reqKusto");
$reqNoRefNota = httpFilterPost("reqNoRefNota");
$reqUraian = httpFilterPost("reqUraian");

$reqBukuBesar= $_POST["reqBukuBesar"];
$reqKartu= $_POST["reqKartu"];
$reqBukuPusat= $_POST["reqBukuPusat"];
$reqKeterangan= $_POST["reqKeterangan"];
$reqDebet= $_POST["reqDebet"];
$reqKredit= $_POST["reqKredit"];


if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JPP", dateToDBCheck($reqTanggalTransaksi));
else
{	
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d->delete();
	unset($kbbt_jur_bb_d);

	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->delete();
	unset($kbbt_jur_bb);

	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->delete();
	unset($kbbt_jur_bb_d_tmp);

	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->delete();
	unset($kbbt_jur_bb_tmp);

}
$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();


/* INSERT MAIN */
$kbbt_jur_bb->setField("KD_CABANG", "95");
$kbbt_jur_bb->setField("KD_SUBSIS", "KLG");
$kbbt_jur_bb->setField("TIPE_TRANS", "KLG-JPP-01");
$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
$kbbt_jur_bb->setField("JEN_JURNAL", "JPP");
$kbbt_jur_bb->setField("NO_REF1", $reqBuktiPendukung);
$kbbt_jur_bb->setField("NO_REF2", $reqBuktiPendukung2);
$kbbt_jur_bb->setField("NO_REF3", $reqBuktiPendukung);
$kbbt_jur_bb->setField("JEN_TRANS", "");
$kbbt_jur_bb->setField("KD_SUB_BANTU", $reqKusto);
$kbbt_jur_bb->setField("KD_UNITK", "");
$kbbt_jur_bb->setField("KD_KUSTO", $reqKusto);
$kbbt_jur_bb->setField("KD_KLIENT", "");
$kbbt_jur_bb->setField("KD_ASSET", "");
$kbbt_jur_bb->setField("KD_STOCK", "");
$kbbt_jur_bb->setField("THN_BUKU", $reqTahun);
$kbbt_jur_bb->setField("BLN_BUKU", $reqBulan);
$kbbt_jur_bb->setField("TGL_ENTRY", "TRUNC(SYSDATE)");
$kbbt_jur_bb->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("KD_VALUTA", $reqValutaNama);
$kbbt_jur_bb->setField("TGL_VALUTA", "TRUNC(SYSDATE)");
$kbbt_jur_bb->setField("KURS_VALUTA", dotToNo($reqKursValuta));
$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahDebet));
$kbbt_jur_bb->setField("JML_RP_TRANS", dotToNo($reqJumlahDebet));
$kbbt_jur_bb->setField("KD_BAYAR", "KREDIT");
$kbbt_jur_bb->setField("KD_BANK", "101.01.00");
$kbbt_jur_bb->setField("NOREK_BANK", "101.01.00");
$kbbt_jur_bb->setField("NO_CEK_NOTA", $reqNoFakturPajak);
$kbbt_jur_bb->setField("NO_POSTING", "");
$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeteranganJurnal);
$kbbt_jur_bb->setField("USER_DATA", "");
$kbbt_jur_bb->setField("ID_KASIR", "");
$kbbt_jur_bb->setField("APPROVER", "");
$kbbt_jur_bb->setField("TANDA_TRANS", "+");
$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
$kbbt_jur_bb->setField("LAST_UPDATED_BY", $userLogin->nama);
$kbbt_jur_bb->setField("PROGRAM_NAME", "KLG_ENTRY_JUR_JPP_IMAIS");
$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
$kbbt_jur_bb->setField("NM_AGEN_PERUSH", $reqPerusahaan);
$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", $reqAlamat);
$kbbt_jur_bb->setField("URAIAN", $reqUraian);
$kbbt_jur_bb->setField("TGL_POSTING", "NULL");
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
$kbbt_jur_bb->setField("NO_REF_NOTA", $reqNoRefNota);
if($kbbt_jur_bb->insert())
{
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->callPKbbtJurBbToTmp();
	
	/* INSERT DETIL */
	for($i=0; $i<count($reqBukuBesar); $i++)
	{			   
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbr_tipe_trans_d = new KbbrTipeTransD();
		
		$klas_trans = $kbbr_tipe_trans_d->getKlasTrans(array(), " AND '".$reqBukuBesar[$i]."' BETWEEN  KD_BUKU_BESAR1 AND KD_BUKU_BESAR2 AND KD_SUBSIS = 'KLG' AND KD_JURNAL = 'JPP' ");
		
		$kbbt_jur_bb_d->setField('KD_CABANG', "95");
		$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoBukti);
		$kbbt_jur_bb_d->setField('NO_SEQ', $reqNoSeq[$i]);
		$kbbt_jur_bb_d->setField('NO_SEQ', $i+1);
		$kbbt_jur_bb_d->setField('KD_SUBSIS', "KLG");
		$kbbt_jur_bb_d->setField('KD_JURNAL', "JPP");
		$kbbt_jur_bb_d->setField('TIPE_TRANS', "KLG-JPP-01");
		$kbbt_jur_bb_d->setField('KLAS_TRANS', $klas_trans);
		$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
		$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $reqKartu[$i]);
		$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $reqBukuPusat[$i]);
		$reqKodeValuta="IDR";
		$kbbt_jur_bb_d->setField('KD_VALUTA', $reqKodeValuta);
		$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$reqKursValuta="1";
		$kbbt_jur_bb_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
		
		$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
		$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', dotToNo($reqKredit[$i]));
		$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', floor(dotToNo($reqDebet[$i]) * dotToNo($reqKursValuta)));
		$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', floor(dotToNo($reqKredit[$i]) * dotToNo($reqKursValuta)));
		$kbbt_jur_bb_d->setField('KET_TAMBAH', dotToNo($reqKeterangan[$i]));
		$kbbt_jur_bb_d->setField('TANDA_TRANS', "+");
		$kbbt_jur_bb_d->setField('KD_AKTIF', "");
		$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
		$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', $reqNoBukti);
		$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
		$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
		$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kbbt_jur_bb_d->setField('PROGRAM_NAME', "KBB_ENTRY_JUR_JPP_IMAIS");
		$kbbt_jur_bb_d->insert();
		//echo $kbbt_jur_bb_d->query;
		unset($kbbt_jur_bb_d);
		unset($kbbr_tipe_trans_d);
	}
	
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->callPKbbtJurBbDToTmp();
	echo $reqNoBukti."-Data berhasil disimpan.";	
}
		

?>