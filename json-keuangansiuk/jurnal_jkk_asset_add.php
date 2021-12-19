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

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti = httpFilterPost("reqNoBukti");
$tempNoRef2 = httpFilterPost("tempNoRef2");
$reqValuta= httpFilterPost("reqValuta");
$reqValutaNama = httpFilterPost("reqValutaNama");
$reqBuktiPendukung= httpFilterPost("reqBuktiPendukung");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqNoFakturPajak= httpFilterPost("reqNoFakturPajak");
$reqPerusahaan= httpFilterPost("reqPerusahaan");
$reqKeteranganJurnal= httpFilterPost("reqKeteranganJurnal");
$reqAlamat= httpFilterPost("reqAlamat");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqJumlahDebet = httpFilterPost("reqJumlahDebet");
$reqBiayaKomersil= httpFilterPost("reqBiayaKomersil");
$reqKusto = httpFilterPost("reqKusto");
$reqPerusahaanTemp = httpFilterPost("reqPerusahaanTemp");

if($reqPerusahaan == "")
	$reqPerusahaan = $reqPerusahaanTemp;


$reqTanggal = dateToDB($reqTanggalTransaksi);
$reqTahun= getYear($reqTanggal);
$reqBulan= getMonth($reqTanggal);

$reqBukuBesar= $_POST["reqBukuBesar"];
$reqLokasi= $_POST["reqLokasi"];
$reqKartu= $_POST["reqKartu"];
$reqBukuPusat= $_POST["reqBukuPusat"];
$reqKeterangan= $_POST["reqKeterangan"];
$reqDebet= $_POST["reqDebet"];
$reqKredit= $_POST["reqKredit"];
$reqFakturPajak= $_POST["reqFakturPajak"];
$reqTanggalFakturPajak= $_POST["reqTanggalFakturPajak"];


if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JKK", dateToDBCheck($reqTanggalTransaksi));
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
$kbbt_jur_bb->setField("KD_CABANG", "96");
$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
$kbbt_jur_bb->setField("TIPE_TRANS", "JKK-KBB-01");
$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
$kbbt_jur_bb->setField("JEN_JURNAL", "JKK");
$kbbt_jur_bb->setField("NO_REF1", $reqNoBukti);
$kbbt_jur_bb->setField("NO_REF2", $tempNoRef2);
$kbbt_jur_bb->setField("NO_REF3", substr($reqBuktiPendukung, 0, 24));
$kbbt_jur_bb->setField("NO_REF4", $reqBuktiPendukung);
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
$kbbt_jur_bb->setField("TGL_VALUTA", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("KURS_VALUTA", dotToNo($reqKursValuta));
$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahDebet));
$kbbt_jur_bb->setField("JML_RP_TRANS", floor(dotToNo($reqJumlahDebet) * dotToNo($reqKursValuta)));
$kbbt_jur_bb->setField("KD_BAYAR", "");
$kbbt_jur_bb->setField("KD_BANK", "");
$kbbt_jur_bb->setField("NOREK_BANK", "");
$kbbt_jur_bb->setField("NO_CEK_NOTA", $reqNoFakturPajak);
$kbbt_jur_bb->setField("NO_POSTING", "");
$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeteranganJurnal);
$kbbt_jur_bb->setField("USER_DATA", "");
$kbbt_jur_bb->setField("ID_KASIR", "");
$kbbt_jur_bb->setField("APPROVER", "");
$kbbt_jur_bb->setField("TANDA_TRANS", "");
$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
$kbbt_jur_bb->setField("LAST_UPDATED_BY", $userLogin->nama);
$kbbt_jur_bb->setField("PROGRAM_NAME", "KBB_ENTRY_JUR_JKK_IMAIS");
$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
$kbbt_jur_bb->setField("NM_AGEN_PERUSH", substr($reqPerusahaan, 0, 49));
$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", substr($reqAlamat, 0, 59));
$kbbt_jur_bb->setField("URAIAN", "");
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
$kbbt_jur_bb->setField("FLAG_SETOR_PAJAK", $reqBiayaKomersil);
$kbbt_jur_bb->setField("STATUS_PROSES", "");
$kbbt_jur_bb->setField("VERIFIED", "");
$kbbt_jur_bb->setField("NO_URUT_UPER", "");
$kbbt_jur_bb->setField("NO_FAKT_PAJAK", "");
$kbbt_jur_bb->setField("NM_AGEN_PERUSH2", $reqPerusahaan);
$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH2", $reqAlamat);
if($kbbt_jur_bb->insert())
{
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->callPKbbtJurBbToTmp();
	
	/* INSERT DETIL */
	for($i=0; $i<count($reqBukuBesar); $i++)
	{			   
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbt_jur_bb_d->setField('KD_CABANG', "96");
		$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoBukti);
		$kbbt_jur_bb_d->setField('NO_SEQ', $reqNoSeq[$i]);
		$kbbt_jur_bb_d->setField('NO_SEQ', $i+1);
		$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
		$kbbt_jur_bb_d->setField('KD_JURNAL', "JKK");
		$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKK-KBB-01");
		$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
		$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
		$kbbt_jur_bb_d->setField('LOKASI_AKTIVA', $reqLokasi[$i]);

		if($reqKartu[$i] == "")
			$sub_bantu = "00000";
		else
			$sub_bantu = $reqKartu[$i];
								
		$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $sub_bantu);
		
		if($reqBukuPusat[$i] == "")
			$buku_pusat = "000.00.00";
		else
			$buku_pusat = $reqBukuPusat[$i];
			
		$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $buku_pusat);
		
		$kbbt_jur_bb_d->setField('KD_VALUTA', $reqValutaNama);
		$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));		
		$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
		$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', dotToNo($reqKredit[$i]));
		$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', floor(dotToNo($reqDebet[$i]) * dotToNo($reqKursValuta)));
		$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', floor(dotToNo($reqKredit[$i]) * dotToNo($reqKursValuta)));
		$kbbt_jur_bb_d->setField('KET_TAMBAH', ($reqKeterangan[$i]));
		$kbbt_jur_bb_d->setField('TANDA_TRANS', "");
		$kbbt_jur_bb_d->setField('KD_AKTIF', "");
		$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
		$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
		$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
		$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
		$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kbbt_jur_bb_d->setField('PROGRAM_NAME', "KBB_ENTRY_JUR_JKK_IMAIS");
		$kbbt_jur_bb_d->setField('FAKTUR_PAJAK', $reqFakturPajak[$i]);
		$kbbt_jur_bb_d->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak[$i]));
		$kbbt_jur_bb_d->insert();
		unset($kbbt_jur_bb_d);
	}
	
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->callPKbbtJurBbDToTmp();
	echo $reqNoBukti."-Data berhasil disimpan.";	
}
		

?>