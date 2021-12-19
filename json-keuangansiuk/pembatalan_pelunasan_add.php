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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqNoBuktiDikoreksi= httpFilterPost("reqNoBuktiDikoreksi");
$reqTipeTransaksi= httpFilterPost("reqTipeTransaksi");
$reqTahun = httpFilterPost("reqTahun");
$reqBulan = httpFilterPost("reqBulan");
$reqKodeBank = httpFilterPost("reqKodeBank");
$reqKdBukuBesar = httpFilterPost("reqKdBukuBesar");
$reqNmBukuBesar= httpFilterPost("reqNmBukuBesar");
$reqNoPelanggan= httpFilterPost("reqPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqBadanUsaha= httpFilterPost("reqBadanUsaha");
$reqKdBbKusto= httpFilterPost("reqKdBbKusto");
$reqNoChqBukti= httpFilterPost("reqNoChqBukti");
$reqNoRef= httpFilterPost("reqNoRef");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqNilaiTransaksi= httpFilterPost("reqNilaiTransaksi");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqJumlahTrans = httpFilterPost("reqJumlahTrans");
$reqTanggalValuta = httpFilterPost("reqTanggalValuta");
$reqBuktiPendukung = httpFilterPost("reqBuktiPendukung");

//MENUNGGU KONFIRMASI
$reqKursValuta = httpFilterPost("reqKursValuta");


$reqNoNota = $_POST["reqNoNota"];
$reqNoRef3 = $_POST["reqNoRef3"];
$reqTanggalTransaksiDetil = $_POST["reqTanggalTransaksiDetil"];
$reqJatuhTempo = $_POST["reqJatuhTempo"];
$reqJumlahUpper = $_POST["reqJumlahUpper"];
$reqJumlahPiutang = $_POST["reqJumlahPiutang"];
$reqJumlahDibayar = $_POST["reqJumlahDibayar"];
$reqPrevNoNota = $_POST["reqPrevNoNota"];

if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JKK", dateToDBCheck($reqTanggalTransaksi));
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

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();


/* INSERT MAIN */
$kptt_nota->setField('KD_CABANG', "96");
$kptt_nota->setField('KD_SUBSIS', "KPT");
$kptt_nota->setField('JEN_JURNAL', "JKK");
$kptt_nota->setField('TIPE_TRANS', "JKK-KPT-01");
$kptt_nota->setField('NO_NOTA', $reqNoBukti);
$kptt_nota->setField('NO_NOTA_JUAL', "");
$kptt_nota->setField('JNS_JUAL', "");
$kptt_nota->setField('NO_REF1', $reqNoRef);
$kptt_nota->setField('NO_REF2', "");
$kptt_nota->setField('NO_REF3', $reqBuktiPendukung);
$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
$kptt_nota->setField('KD_UNITK', "");
$kptt_nota->setField('JEN_TRANS', "4");
$kptt_nota->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck(""));
$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqNilaiTransaksi));
$kptt_nota->setField('JML_RP_TRANS', floor(dotToNo($reqNilaiTransaksi) * dotToNo($reqKursValuta)));
$kptt_nota->setField('TANDA_TRANS', "-");
$kptt_nota->setField('KD_BB_PAJAK1', "");
$kptt_nota->setField('PPN1_PERSEN', "");
$kptt_nota->setField('KD_BB_PAJAK2', "");
$kptt_nota->setField('PPN2_PERSEN', "");
$kptt_nota->setField('METERAI', "");
$kptt_nota->setField('KD_BB_METERAI', "");
$kptt_nota->setField('PPN_PEM_PERSEN', "");	
$kptt_nota->setField('BAGIHASIL_PERSEN', "");
$kptt_nota->setField('JML_VAL_REDUKSI', "");	
$kptt_nota->setField('JML_VAL_BAYAR', "");	
$kptt_nota->setField('SISA_VAL_BAYAR', "");	
$kptt_nota->setField('KD_BANK', $reqKodeBank);
$kptt_nota->setField('REK_BANK', "");
$kptt_nota->setField('KD_BB_BANK', $reqKdBukuBesar);	
$kptt_nota->setField('NO_WD_UPER', "");	
$kptt_nota->setField('JML_WD_UPPER', "");	
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
$kptt_nota->setField('CETAK_NOTA', "");	
$kptt_nota->setField('LAST_APPROVE_DATE', OCI_SYSDATE);	
$kptt_nota->setField('LAST_APPROVE_BY', "AKUNTANSI_PMS");		
$kptt_nota->setField('PREV_NOTA_UPDATE', $reqNoBuktiDikoreksi);	
$kptt_nota->setField('REF_NOTA_CICILAN', "");	
$kptt_nota->setField('PERIODE_CICILAN', "");		
$kptt_nota->setField('JML_KALI_CICILAN', "");			
$kptt_nota->setField('CICILAN_KE', "");
$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
$kptt_nota->setField('ID_KASIR', "AKUNTANSI_PMS");		
$kptt_nota->setField('AUTO_MANUAL', "M");		
$kptt_nota->setField('STAT_RKP_KARTU', "0");	
$kptt_nota->setField('TGL_POSTING', dateToDBCheck(""));		
$kptt_nota->setField('NO_FAKT_PAJAK', "");	
$kptt_nota->setField('JML_VAL_PAJAK', "0");	
$kptt_nota->setField('JML_RP_PAJAK', "0");		
$kptt_nota->setField('JML_WDANA', "0");	
$kptt_nota->setField('BULTAH', $reqTahun.$reqBulan);		
$kptt_nota->setField('CETAK_APBMI', "0");			
$kptt_nota->setField('NO_WDANA', "");
$kptt_nota->setField('FLAG_APBMI', "");
$kptt_nota->setField('TGL_CETAK', dateToDBCheck(""));			
$kptt_nota->setField('KD_TERMINAL', "");
$kptt_nota->setField('LOKASI', "");
$kptt_nota->setField('KD_NOTA', "");		
$kptt_nota->setField('FLAG_EKSPEDISI', "");
$kptt_nota->setField('NO_EKSPEDISI', "");	
$kptt_nota->setField('TGL_EKSPEDISI', dateToDBCheck(""));
$kptt_nota->setField('NO_SP', "");
$kptt_nota->setField('TGL_SP', dateToDBCheck(""));		
$kptt_nota->setField('NO_KN_BANK', "");
$kptt_nota->setField('TGL_KN_BANK', dateToDBCheck(""));
$kptt_nota->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
$kptt_nota->setField('PROGRAM_NAME', "KPTT_EKAS_KOREK_IMAIS");			
$kptt_nota->setField('NO_REG', "");	
$kptt_nota->setField('FLAG_TUNAI', "");	
$kptt_nota->setField('TGL_BATAL', dateToDBCheck(""));	
$kptt_nota->setField('NO_NOTA_BTL', "");			
$kptt_nota->setField('NO_DN', "");		
$kptt_nota->setField('TGL_DN', dateToDBCheck(""));
$kptt_nota->setField('FLAG_PUPN', "");		
$kptt_nota->setField('JML_TAGIHAN', "");			
$kptt_nota->setField('SISA_TAGIHAN', "");	
$kptt_nota->setField('KD_PANGKALAN', "");	
$kptt_nota->setField('FLAG_SETOR_PAJAK', "");		
$kptt_nota->setField('KD_PELAYANAN', "");			
$kptt_nota->setField('VERIFIED', "");	
$kptt_nota->setField('NO_APPROVAL', "");	
$kptt_nota->setField('TGL_APPROVAL', dateToDBCheck(""));
$kptt_nota->setField('TGL_POST_BATAL', dateToDBCheck(""));
$kptt_nota->setField('TGL_VAL_PAJAK', dateToDBCheck(""));	
$kptt_nota->setField('KURS_VAL_PAJAK', "");
$kptt_nota->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak));
$kptt_nota->setField('FAKTUR_PAJAK_PREFIX', $reqFakturPajakPrefix);		
		
if($kptt_nota->insert())
{
	for($i=0; $i<count($reqNoRef3); $i++)
	{
		if($reqPajak[$i] == "Y")
			$reqPajakId = 1;
		else
			$reqPajakId = 0;
					
		$kptt_nota_d = new KpttNotaD();
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_d->setField('JEN_JURNAL', "JKK");
		$kptt_nota_d->setField('TIPE_TRANS', "JKK-KPT-01");
		$kptt_nota_d->setField('NO_NOTA', $reqNoBukti);
		$kptt_nota_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_d->setField('KLAS_TRANS', "");
		$kptt_nota_d->setField('KWANTITAS', "");
		$kptt_nota_d->setField('SATUAN', "");
		$kptt_nota_d->setField('HARGA_SATUAN', "");
		$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");	
		$kptt_nota_d->setField('KD_VALUTA', $reqValutaNama);
		$kptt_nota_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
		$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqJumlahDibayar[$i]));
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', "");
		$kptt_nota_d->setField('JML_VAL_PAJAK', "");
		$kptt_nota_d->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahDibayar[$i]) * dotToNo($reqKursValuta)));
		$kptt_nota_d->setField('JML_RP_PAJAK', "");
		$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_d->setField('TANDA_TRANS', "-");
		$kptt_nota_d->setField('KD_BUKU_BESAR', $reqKdBbKusto);
		$kptt_nota_d->setField('KD_SUB_BANTU', $reqNoPelanggan);	
		$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
		$kptt_nota_d->setField('KD_D_K', "D");
		$kptt_nota_d->setField('PREV_NO_NOTA', $reqPrevNoNota[$i]);
		$kptt_nota_d->setField('KET_TAMBAHAN', "KOREKSI JKM PELUNASAN");
		$kptt_nota_d->setField('STATUS_PROSES', "1");	
		$kptt_nota_d->setField('FLAG_JURNAL', "");
		$kptt_nota_d->setField('NO_REF1', "");
		$kptt_nota_d->setField('NO_REF2', "");
		$kptt_nota_d->setField('NO_REF3', $reqNoRef3[$i]);
		$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "KPTT_EKAS_KOREK_IMAIS");
		$kptt_nota_d->setField('KD_TERMINAL', "");
		$kptt_nota_d->setField('NL_TARIF', "");
		$kptt_nota_d->insert();
		unset($kptt_nota_d);
	}

	//BUAT JURNAL


	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->setField("PREV_NOTA", $reqNoBuktiDikoreksi);
	$kbbt_jur_bb->callGenerateJurnalPembatalanNotaTagih();

	/*  UPDATE STATUS_PROSES = 2 */
	$kptt_nota_update = new KpttNota();
	$kptt_nota_update->setField("NO_NOTA", $reqNoBuktiDikoreksi);			
	$kptt_nota_update->updatePembatalanPelunasan();

/*
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->callKopiJurnalBB();
	
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->callKopiJurnalBBD();
*/
		
	echo $reqNoBukti."-Data berhasil disimpan.";
	
}

?>