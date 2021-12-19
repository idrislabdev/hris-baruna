<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajakD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttSbppRincian.php");

/* create objects */

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();
$no_faktur_pajak_d = new NoFakturPajakD();
$kptt_sbpp_rincian = new KpttSbppRincian();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqMaterai= httpFilterPost("reqMaterai");
$reqNoPPKB= httpFilterPost("reqNoPPKB");
$reqSegmen= httpFilterPost("reqSegmen");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqNoValuta= httpFilterPost("reqNoValuta");
$reqNoRef= httpFilterPost("reqNoRef");
$reqNoRefLain= httpFilterPost("reqNoRefLain");
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

if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JPJ", dateToDBCheck($reqTanggalTransaksi));
else
{	
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->delete();
	unset($kbbt_jur_bb);

	$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d->delete();
	unset($kbbt_jur_bb_d);

	$kptt_nota->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota->delete();
	unset($kptt_nota);
	
	$kptt_nota_d->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota_d->delete();
	unset($kptt_nota_d);

}

if($reqNoPPKB == "")
{
	$reqTglTransDb = dateToDB($reqTanggalTransaksi);
	$reqNoPPKB = $kptt_nota->getInvoiceNo(getMonth($reqTglTransDb), getYear($reqTglTransDb));
}


$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kptt_nota = new KpttNota();

/* INSERT MAIN */
$kptt_nota->setField('KD_CABANG', "96");
$kptt_nota->setField('KD_SUBSIS', "KPT");
$kptt_nota->setField('JEN_JURNAL', "JPJ");
$kptt_nota->setField('TIPE_TRANS', $reqSegmen);
$kptt_nota->setField('NO_NOTA', $reqNoBukti);
$kptt_nota->setField('NO_NOTA_JUAL', $reqNoPPKB);
$kptt_nota->setField('JNS_JUAL', "");
$kptt_nota->setField('NO_REF1', $reqNoPPKB);
$kptt_nota->setField('NO_REF2', $reqNoRefLain);
$kptt_nota->setField('NO_REF3', $reqNoPPKB);
$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
$kptt_nota->setField('KD_UNITK', "");
$kptt_nota->setField('JEN_TRANS', "0");
$kptt_nota->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqJumlahTrans) + dotToNo($reqJumlahPajak) + $reqMaterai);
if($reqKursPajak == "")
	$reqKursPajakKali = 1;
else
	$reqKursPajakKali = $reqKursPajak;

$jml_rp_trans = (dotToNo($reqJumlahTrans) * dotToNo($reqKursValuta)) + (dotToNo($reqJumlahPajak) * dotToNo($reqKursPajakKali)) + $reqMaterai;
$kptt_nota->setField('JML_RP_TRANS', floor(dotToNo($jml_rp_trans)));
$kptt_nota->setField('TANDA_TRANS', "+");
$kptt_nota->setField('KD_BB_PAJAK1', "");
$kptt_nota->setField('PPN1_PERSEN', "");//$reqPersenPajak);
$kptt_nota->setField('KD_BB_PAJAK2', "");
$kptt_nota->setField('PPN2_PERSEN', "");
$kptt_nota->setField('METERAI', $reqMaterai);
$kptt_nota->setField('KD_BB_METERAI', "");
$kptt_nota->setField('PPN_PEM_PERSEN', "");	
$kptt_nota->setField('BAGIHASIL_PERSEN', "");
$kptt_nota->setField('JML_VAL_REDUKSI', "");	
$kptt_nota->setField('JML_VAL_BAYAR', 0);//dotToNo($reqJumlahTagihan));	
$kptt_nota->setField('SISA_VAL_BAYAR', 0);	
$kptt_nota->setField('KD_BANK', $reqKodeBank);
$kptt_nota->setField('REK_BANK', "");
$kptt_nota->setField('KD_BB_BANK', $reqBankBB);	
$kptt_nota->setField('NO_WD_UPER', "");	
$kptt_nota->setField('JML_WD_UPPER', dotToNo($reqJumlahUpper));	
$kptt_nota->setField('KD_BB_UPER', "");	
$kptt_nota->setField('KD_BAYAR', "");	
$kptt_nota->setField('NO_CHEQUE', "");
$kptt_nota->setField('THN_BUKU', $reqTahun);
$kptt_nota->setField('BLN_BUKU', $reqBulan);
$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
$kptt_nota->setField('KD_OBYEK', "");		
$kptt_nota->setField('NO_VOYAGE', "");	
$kptt_nota->setField('STATUS_PROSES', "1");	
$kptt_nota->setField('NO_POSTING', "");	
$kptt_nota->setField('CETAK_NOTA', "0");	
$kptt_nota->setField('LAST_APPROVE_DATE', OCI_SYSDATE);	
$kptt_nota->setField('LAST_APPROVE_BY', "AKUNTANSI_PMS");		
$kptt_nota->setField('PREV_NOTA_UPDATE', "");	
$kptt_nota->setField('REF_NOTA_CICILAN', "");	
$kptt_nota->setField('PERIODE_CICILAN', "");		
$kptt_nota->setField('JML_KALI_CICILAN', "");			
$kptt_nota->setField('CICILAN_KE', "");
$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
$kptt_nota->setField('ID_KASIR', "AKUNTANSI_PMS");		
$kptt_nota->setField('AUTO_MANUAL', "M");		
$kptt_nota->setField('STAT_RKP_KARTU', "");	
$kptt_nota->setField('TGL_POSTING', dateToDBCheck(""));		
$kptt_nota->setField('NO_FAKT_PAJAK', "");	
$kptt_nota->setField('JML_VAL_PAJAK', dotToNo($reqJumlahPajak) * dotToNo($reqKursPajak));	
$kptt_nota->setField('JML_RP_PAJAK', dotToNo($reqJumlahPajak));		
$kptt_nota->setField('JML_WDANA', "");	
$kptt_nota->setField('BULTAH', $reqTahun.$reqBulan);		
$kptt_nota->setField('CETAK_APBMI', "");			
$kptt_nota->setField('NO_WDANA', "");
$kptt_nota->setField('FLAG_APBMI', "");
$kptt_nota->setField('TGL_CETAK', dateToDBCheck(""));			
$kptt_nota->setField('KD_TERMINAL', "");
$kptt_nota->setField('LOKASI', "");
$kptt_nota->setField('KD_NOTA', "");		
$kptt_nota->setField('FLAG_EKSPEDISI', "Y");
$kptt_nota->setField('NO_EKSPEDISI', "");	
$kptt_nota->setField('TGL_EKSPEDISI', dateToDBCheck(""));
$kptt_nota->setField('NO_SP', "");
$kptt_nota->setField('TGL_SP', dateToDBCheck(""));		
$kptt_nota->setField('NO_KN_BANK', "");
$kptt_nota->setField('TGL_KN_BANK', dateToDBCheck(""));
$kptt_nota->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
$kptt_nota->setField('PROGRAM_NAME', "KPTT_ENOTA_BARU_IMAIS");			
$kptt_nota->setField('NO_REG', "");	
$kptt_nota->setField('FLAG_TUNAI', "");	
$kptt_nota->setField('TGL_BATAL', dateToDBCheck(""));	
$kptt_nota->setField('NO_NOTA_BTL', "");			
$kptt_nota->setField('NO_DN', "");		
$kptt_nota->setField('TGL_DN', dateToDBCheck(""));
$kptt_nota->setField('FLAG_PUPN', "");		
//$kptt_nota->setField('JML_TAGIHAN', dotToNo($reqJumlahTagihan));			
//$kptt_nota->setField('SISA_TAGIHAN', dotToNo($reqJumlahTagihan));
$kptt_nota->setField('JML_TAGIHAN', dotToNo($reqJumlahTagihan) - $reqMaterai);			
$kptt_nota->setField('SISA_TAGIHAN', dotToNo($reqJumlahTagihan) - $reqMaterai);	
$kptt_nota->setField('KD_PANGKALAN', "");	
$kptt_nota->setField('FLAG_SETOR_PAJAK', "");		
$kptt_nota->setField('KD_PELAYANAN', "");			
$kptt_nota->setField('VERIFIED', "");	
$kptt_nota->setField('NO_APPROVAL', "");	
$kptt_nota->setField('TGL_APPROVAL', dateToDBCheck(""));
$kptt_nota->setField('TGL_POST_BATAL', dateToDBCheck(""));
$kptt_nota->setField('TGL_VAL_PAJAK', dateToDBCheck($reqTanggalValutaPajak));	
$kptt_nota->setField('KURS_VAL_PAJAK', dotToNo($reqKursPajak));
$kptt_nota->setField('FAKTUR_PAJAK', $reqFakturPajak);
$kptt_nota->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak));
$kptt_nota->setField('FAKTUR_PAJAK_PREFIX', $reqFakturPajakPrefix);		


if($kptt_nota->insert())
{
	$kptt_sbpp_rincian->setField("NO_NOTA", $reqNoBukti);
	$kptt_sbpp_rincian->delete();
	
	for($i=0;$i<count($reqNoUrut);$i++)
	{
		$kptt_sbpp_rincian = new KpttSbppRincian();
		$kptt_sbpp_rincian->setField("NO_NOTA", $reqNoBukti);
		$kptt_sbpp_rincian->setField("LINE_SEQ", $reqNoUrut[$i]);
		$kptt_sbpp_rincian->setField("KET_TAMBAH", $reqKetTambah[$i]);
		$kptt_sbpp_rincian->setField("TANDA_TRANS", $reqTandaTrans[$i]);
		$kptt_sbpp_rincian->setField("JML_VAL_TRANS", dotToNo($reqJumlah[$i]));
		$kptt_sbpp_rincian->insert();
		unset($kptt_sbpp_rincian);			
	}
	

	
	/* UPDATE FAKTUR PAJAK START */
	$no_faktur_pajak_d->setField("NOMOR", $reqFakturPajak);
	$no_faktur_pajak_d->setField("NO_NOTA", $reqNoBukti);
	$no_faktur_pajak_d->updateStatus();
	/* UPDATE FAKTUR PAJAK END */


	$kbbr_tipe_trans_d = new KbbrTipeTransD();
	$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS"=>$reqSegmen, "KLAS_TRANS" => "TUNDAKSO"), -1, -1, " AND (KD_AKTIF = 'A' OR KD_AKTIF IS NULL)");
	$kbbr_tipe_trans_d->firstRow();
	
	$reqKdBukuBesar = $kbbr_tipe_trans_d->getField("KD_BUKU_BESAR1");
	$reqDK = $kbbr_tipe_trans_d->getField("KD_DK");

	$reqPajakId = 0;					
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField('KD_CABANG', "96");
	$kptt_nota_d->setField('KD_SUBSIS', "KPT");
	$kptt_nota_d->setField('JEN_JURNAL', "JPJ");
	$kptt_nota_d->setField('TIPE_TRANS', $reqSegmen);
	$kptt_nota_d->setField('NO_NOTA', $reqNoBukti);
	$kptt_nota_d->setField('LINE_SEQ', 1);
	$kptt_nota_d->setField('KLAS_TRANS', "TUNDAKSO");
	$kptt_nota_d->setField('KWANTITAS', "");
	$kptt_nota_d->setField('SATUAN', "");
	$kptt_nota_d->setField('HARGA_SATUAN', "");
	$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");	
	$kptt_nota_d->setField('KD_VALUTA', $reqValutaNama);
	$kptt_nota_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
	$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqJumlahTrans));
	$kptt_nota_d->setField('STATUS_KENA_PAJAK', $reqPajakId);
	$kptt_nota_d->setField('JML_VAL_PAJAK', dotToNo(0));
	$kptt_nota_d->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahTrans)*dotToNo($reqKursValuta)));
	$kptt_nota_d->setField('JML_RP_PAJAK', floor(dotToNo(0)*dotToNo($reqKursPajak)));
	$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
	$kptt_nota_d->setField('TANDA_TRANS', "+");
	$kptt_nota_d->setField('KD_BUKU_BESAR', $reqKdBukuBesar);
	$kptt_nota_d->setField('KD_SUB_BANTU', $reqNoPelanggan);	
	$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
	$kptt_nota_d->setField('KD_D_K', $reqDK);
	$kptt_nota_d->setField('PREV_NO_NOTA', "");
	$kptt_nota_d->setField('KET_TAMBAHAN', "");
	$kptt_nota_d->setField('STATUS_PROSES', "1");	
	$kptt_nota_d->setField('FLAG_JURNAL', "");
	$kptt_nota_d->setField('NO_REF1', $reqNoPPKB);
	$kptt_nota_d->setField('NO_REF2', "");
	$kptt_nota_d->setField('NO_REF3', $reqNoPPKB);
	$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
	$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
	$kptt_nota_d->setField('PROGRAM_NAME', "KPTT_ENOTA_BARU_IMAIS");
	$kptt_nota_d->setField('KD_TERMINAL', "");
	$kptt_nota_d->setField('NL_TARIF', "");
	$kptt_nota_d->insert();
	//BUAT JURNAL

	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->callGenerateJurnal();
	
	/*$kptt_nota->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota->callInsertJmlTagihan();	

	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->callBlcJurBb();*/
			
			
	if($reqValutaNama == "USD")
	{
	
		$kptt_nota->setField("NO_NOTA", $reqNoBukti);
		$kptt_nota->callAddCekJurVals();		
	
			
	}		
			
	echo $reqNoBukti."-Data berhasil disimpan.";
	
}

?>