<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaNonJurnal.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaNonJurnalD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajakD.php");

/* create objects */
$kptt_nota_non_jurnal = new KpttNotaNonJurnal();
$kptt_nota_non_jurnal_d = new  KpttNotaNonJurnalD();
$no_faktur_pajak_d = new NoFakturPajakD();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqMaterai= httpFilterPost("reqMaterai");
$reqMateraiPilih= httpFilterPost("reqMateraiPilih");

if ($reqMateraiPilih == 0) $reqMaterai=0;

$reqNoPPKB= httpFilterPost("reqNoPPKB");
$reqSegmen= httpFilterPost("reqSegmen");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqNoValuta= httpFilterPost("reqNoValuta");
$reqNoRef= httpFilterPost("reqNoRef");
$reqNoRefLain= httpFilterPost("reqNoRefLain");
if($reqNoRefLain != '') $reqKeterangan2 = 'SUDAH_BAYAR';
else $reqKeterangan2 = '';
$reqKodeKapal= httpFilterPost("reqKodeKapal");
$reqKapal= httpFilterPost("reqKapal");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqKodeBank= httpFilterPost("reqKodeBank");
$reqBank= httpFilterPost("reqBank");
$reqBankBB= httpFilterPost("reqBankBB");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqTanggalValutaPajak= httpFilterPost("reqTanggalValutaPajak");
$reqJumlahTagihan= httpFilterPost("reqJumlahTagihan");
$reqJumlahUpper= httpFilterPost("reqJumlahUpper");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqKursPajak= httpFilterPost("reqKursPajak");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqTipeTrans= httpFilterPost("reqTipeTrans");
$reqNoBukti = httpFilterPost("reqNoBukti");
$reqPersenPajak = httpFilterPost("reqPersenPajak");
$reqJumlahTrans = httpFilterPost("reqJumlahTrans");
$reqJumlahPajak = httpFilterPost("reqJumlahPajak");
$reqFakturPajak = httpFilterPost("reqFakturPajak");
$reqTanggalFakturPajak = httpFilterPost("reqTanggalFakturPajak");
$reqFakturPajakPrefix = httpFilterPost("reqFakturPajakPrefix");

$reqNoUrut = $_POST["reqNoUrut"];
$reqKetTambah = $_POST["reqKetTambah"];
$reqTandaTrans = $_POST["reqTandaTrans"];
$reqJumlah = $_POST["reqJumlah"];

if($reqNoPPKB == "")	
{
	$reqTglTransDb = dateToDB($reqTanggalTransaksi);
	$reqNoPPKB = $kptt_nota_non_jurnal->getInvoiceNo(getMonth($reqTglTransDb), getYear($reqTglTransDb));
}
else
{	
	$kptt_nota_non_jurnal->setField("NO_NOTA", $reqNoPPKB);
	$kptt_nota_non_jurnal->delete();
	unset($kptt_nota_non_jurnal);
	
	$kptt_nota_non_jurnal_d->setField("NO_NOTA", $reqNoPPKB);
	$kptt_nota_non_jurnal_d->delete();
	unset($kptt_nota_non_jurnal_d);

}
$kptt_nota_non_jurnal = new KpttNotaNonJurnal();

/* INSERT MAIN */
$kptt_nota_non_jurnal->setField('KD_CABANG', "96");
$kptt_nota_non_jurnal->setField('KD_SUBSIS', "KPT");
$kptt_nota_non_jurnal->setField('JEN_JURNAL', "JPJ");
$kptt_nota_non_jurnal->setField('TIPE_TRANS', $reqSegmen);
$kptt_nota_non_jurnal->setField('NO_NOTA', $reqNoPPKB);
$kptt_nota_non_jurnal->setField('NO_NOTA_JUAL', $reqNoPPKB);
$kptt_nota_non_jurnal->setField('JNS_JUAL', "");
$kptt_nota_non_jurnal->setField('NO_REF1', $reqNoPPKB);
$kptt_nota_non_jurnal->setField('NO_REF2', $reqNoRefLain);
$kptt_nota_non_jurnal->setField('NO_REF3', $reqNoPPKB);
$kptt_nota_non_jurnal->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota_non_jurnal->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota_non_jurnal->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
$kptt_nota_non_jurnal->setField('KD_UNITK', "");
$kptt_nota_non_jurnal->setField('JEN_TRANS', "0");
$kptt_nota_non_jurnal->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
$kptt_nota_non_jurnal->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota_non_jurnal->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota_non_jurnal->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota_non_jurnal->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota_non_jurnal->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota_non_jurnal->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota_non_jurnal->setField('JML_VAL_TRANS', dotToNo($reqJumlahTrans) + dotToNo($reqJumlahPajak) + $reqMaterai);
if($reqKursPajak == "")
	$reqKursPajakKali = 1;
else
	$reqKursPajakKali = $reqKursPajak;

$jml_rp_trans = (dotToNo($reqJumlahTrans) * dotToNo($reqKursValuta)) + (dotToNo($reqJumlahPajak) * dotToNo($reqKursPajakKali)) + $reqMaterai;
$kptt_nota_non_jurnal->setField('JML_RP_TRANS', floor(dotToNo($jml_rp_trans)));
$kptt_nota_non_jurnal->setField('TANDA_TRANS', "+");
$kptt_nota_non_jurnal->setField('KD_BB_PAJAK1', "");
$kptt_nota_non_jurnal->setField('PPN1_PERSEN', "");//$reqPersenPajak);
$kptt_nota_non_jurnal->setField('KD_BB_PAJAK2', "");
$kptt_nota_non_jurnal->setField('PPN2_PERSEN', "");
$kptt_nota_non_jurnal->setField('METERAI', $reqMaterai);
$kptt_nota_non_jurnal->setField('KD_BB_METERAI', "");
$kptt_nota_non_jurnal->setField('PPN_PEM_PERSEN', "");	
$kptt_nota_non_jurnal->setField('BAGIHASIL_PERSEN', "");
$kptt_nota_non_jurnal->setField('JML_VAL_REDUKSI', "");	
$kptt_nota_non_jurnal->setField('JML_VAL_BAYAR', 0);//dotToNo($reqJumlahTagihan));	
$kptt_nota_non_jurnal->setField('SISA_VAL_BAYAR', 0);	
$kptt_nota_non_jurnal->setField('KD_BANK', $reqKodeBank);
$kptt_nota_non_jurnal->setField('REK_BANK', "");
$kptt_nota_non_jurnal->setField('KD_BB_BANK', $reqBankBB);	
$kptt_nota_non_jurnal->setField('NO_WD_UPER', "");	
$kptt_nota_non_jurnal->setField('JML_WD_UPPER', dotToNo($reqJumlahUpper));	
$kptt_nota_non_jurnal->setField('KD_BB_UPER', "");	
$kptt_nota_non_jurnal->setField('KD_BAYAR', "");	
$kptt_nota_non_jurnal->setField('NO_CHEQUE', "");
$kptt_nota_non_jurnal->setField('THN_BUKU', $reqTahun);
$kptt_nota_non_jurnal->setField('BLN_BUKU', $reqBulan);
$kptt_nota_non_jurnal->setField('KET_TAMBAHAN', $reqKeterangan);	
$kptt_nota_non_jurnal->setField('KET_TAMBAHAN2', $reqKeterangan2);	
$kptt_nota_non_jurnal->setField('KD_OBYEK', "");		
$kptt_nota_non_jurnal->setField('NO_VOYAGE', "");	
$kptt_nota_non_jurnal->setField('STATUS_PROSES', "1");	
$kptt_nota_non_jurnal->setField('NO_POSTING', "");	
$kptt_nota_non_jurnal->setField('CETAK_NOTA', "0");	
$kptt_nota_non_jurnal->setField('LAST_APPROVE_DATE', OCI_SYSDATE);	
$kptt_nota_non_jurnal->setField('LAST_APPROVE_BY', "AKUNTANSI_PMS");		
$kptt_nota_non_jurnal->setField('PREV_NOTA_UPDATE', "");	
$kptt_nota_non_jurnal->setField('REF_NOTA_CICILAN', "");	
$kptt_nota_non_jurnal->setField('PERIODE_CICILAN', "");		
$kptt_nota_non_jurnal->setField('JML_KALI_CICILAN', "");			
$kptt_nota_non_jurnal->setField('CICILAN_KE', "");
$kptt_nota_non_jurnal->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
$kptt_nota_non_jurnal->setField('ID_KASIR', "AKUNTANSI_PMS");		
$kptt_nota_non_jurnal->setField('AUTO_MANUAL', "M");		
$kptt_nota_non_jurnal->setField('STAT_RKP_KARTU', "");	
$kptt_nota_non_jurnal->setField('TGL_POSTING', dateToDBCheck(""));		
$kptt_nota_non_jurnal->setField('NO_FAKT_PAJAK', "");	
$kptt_nota_non_jurnal->setField('JML_VAL_PAJAK', dotToNo($reqJumlahPajak) * dotToNo($reqKursPajak));	
$kptt_nota_non_jurnal->setField('JML_RP_PAJAK', dotToNo($reqJumlahPajak));		
$kptt_nota_non_jurnal->setField('JML_WDANA', "");	
$kptt_nota_non_jurnal->setField('BULTAH', $reqTahun.$reqBulan);		
$kptt_nota_non_jurnal->setField('CETAK_APBMI', "");			
$kptt_nota_non_jurnal->setField('NO_WDANA', "");
$kptt_nota_non_jurnal->setField('FLAG_APBMI', "");
$kptt_nota_non_jurnal->setField('TGL_CETAK', dateToDBCheck(""));			
$kptt_nota_non_jurnal->setField('KD_TERMINAL', "");
$kptt_nota_non_jurnal->setField('LOKASI', "");
$kptt_nota_non_jurnal->setField('KD_NOTA', "");		
$kptt_nota_non_jurnal->setField('FLAG_EKSPEDISI', "Y");
$kptt_nota_non_jurnal->setField('NO_EKSPEDISI', "");	
$kptt_nota_non_jurnal->setField('TGL_EKSPEDISI', dateToDBCheck(""));
$kptt_nota_non_jurnal->setField('NO_SP', "");
$kptt_nota_non_jurnal->setField('TGL_SP', dateToDBCheck(""));		
$kptt_nota_non_jurnal->setField('NO_KN_BANK', "");
$kptt_nota_non_jurnal->setField('TGL_KN_BANK', dateToDBCheck(""));
$kptt_nota_non_jurnal->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
$kptt_nota_non_jurnal->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
$kptt_nota_non_jurnal->setField('PROGRAM_NAME', "KPTT_ENOTA_BARU_IMAIS");			
$kptt_nota_non_jurnal->setField('NO_REG', "");	
$kptt_nota_non_jurnal->setField('FLAG_TUNAI', "");	
$kptt_nota_non_jurnal->setField('TGL_BATAL', dateToDBCheck(""));	
$kptt_nota_non_jurnal->setField('NO_NOTA_BTL', "");			
$kptt_nota_non_jurnal->setField('NO_DN', "");		
$kptt_nota_non_jurnal->setField('TGL_DN', dateToDBCheck(""));
$kptt_nota_non_jurnal->setField('FLAG_PUPN', "");		
$kptt_nota_non_jurnal->setField('JML_TAGIHAN', dotToNo($reqJumlahTagihan));			
$kptt_nota_non_jurnal->setField('SISA_TAGIHAN', dotToNo($reqJumlahTagihan));	
$kptt_nota_non_jurnal->setField('KD_PANGKALAN', "");	
$kptt_nota_non_jurnal->setField('FLAG_SETOR_PAJAK', "");		
$kptt_nota_non_jurnal->setField('KD_PELAYANAN', "");			
$kptt_nota_non_jurnal->setField('VERIFIED', "");	
$kptt_nota_non_jurnal->setField('NO_APPROVAL', "");	
$kptt_nota_non_jurnal->setField('TGL_APPROVAL', dateToDBCheck(""));
$kptt_nota_non_jurnal->setField('TGL_POST_BATAL', dateToDBCheck(""));
$kptt_nota_non_jurnal->setField('TGL_VAL_PAJAK', dateToDBCheck($reqTanggalValutaPajak));	
$kptt_nota_non_jurnal->setField('KURS_VAL_PAJAK', dotToNo($reqKursPajak));
$kptt_nota_non_jurnal->setField('FAKTUR_PAJAK', $reqFakturPajak);
$kptt_nota_non_jurnal->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak));
$kptt_nota_non_jurnal->setField('FAKTUR_PAJAK_PREFIX', $reqFakturPajakPrefix);		

if($kptt_nota_non_jurnal->insert())
{
	/* UPDATE FAKTUR PAJAK START */
	$no_faktur_pajak_d->setField("NOMOR", $reqFakturPajak);
	$no_faktur_pajak_d->setField("NO_NOTA", $reqNoPPKB);
	$no_faktur_pajak_d->updateStatus();
	/* UPDATE FAKTUR PAJAK END */
	
	for($i=0;$i<count($reqNoUrut);$i++)
	{
		$kptt_nota_non_jurnal_d = new KpttNotaNonJurnalD();
		$kptt_nota_non_jurnal_d->setField("NO_NOTA", $reqNoPPKB);
		$kptt_nota_non_jurnal_d->setField("LINE_SEQ", $reqNoUrut[$i]);
		$kptt_nota_non_jurnal_d->setField("KET_TAMBAHAN", $reqKetTambah[$i]);
		$kptt_nota_non_jurnal_d->setField("TANDA_TRANS", $reqTandaTrans[$i]);
		$kptt_nota_non_jurnal_d->setField("STATUS_KENA_PAJAK", ($reqPajak[$i] == "Y" ? 1 : 0));
		$kptt_nota_non_jurnal_d->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
		$kptt_nota_non_jurnal_d->setField("JML_VAL_TRANS", dotToNo($reqJumlah[$i]));
		$kptt_nota_non_jurnal_d->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahTrans)*dotToNo($reqKursValuta)));
		$kptt_nota_non_jurnal_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
		$kptt_nota_non_jurnal_d->insert();
		//echo $kptt_nota_non_jurnal_d->query;
		unset($kptt_nota_non_jurnal_d);			
	}
			
	echo $reqNoPPKB."@Data berhasil disimpan.";
	
}

?>