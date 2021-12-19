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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajakD.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqKodeKapal= httpFilterPost("reqKodeKapal");
$reqKapal= httpFilterPost("reqKapal");
$reqJenisJasa= httpFilterPost("reqJenisJasa");
$reqMaterai= httpFilterPost("reqMaterai");
$reqJumlahUpper= httpFilterPost("reqJumlahUpper");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqJumlahTagihan= httpFilterPost("reqJumlahTagihan");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqNoRef3= httpFilterPost("reqNoRef3");
$reqNotaUpdate= httpFilterPost("reqNotaUpdate");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqJumlahPajak = httpFilterPost("reqJumlahPajak");
$reqJumlahTrans = httpFilterPost("reqJumlahTrans");
$reqTahun = httpFilterPost("reqTahun");
$reqBulan = httpFilterPost("reqBulan");

$reqKlasTrans = $_POST["reqKlasTrans"];
$reqNilaiPajak = $_POST["reqNilaiPajak"];
$reqJumlah = $_POST["reqJumlah"];

if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JRR", dateToDBCheck($reqTanggalTransaksi));
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
$kptt_nota->setField('JEN_JURNAL', "JRR");
$kptt_nota->setField('TIPE_TRANS', "JRR-KPT-01");
$kptt_nota->setField('NO_NOTA', $reqNoBukti);
$kptt_nota->setField('NO_NOTA_JUAL', "");
$kptt_nota->setField('JNS_JUAL', "");
$kptt_nota->setField('NO_REF1', $reqNoRef3);
$kptt_nota->setField('NO_REF2', "");
$kptt_nota->setField('NO_REF3', $reqNoRef3);
$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
$kptt_nota->setField('KD_UNITK', "");
$kptt_nota->setField('JEN_TRANS', "3");
$kptt_nota->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi)." + 14 ");
$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqJumlahTagihan));
$kptt_nota->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahTagihan) * dotToNo($reqKursValuta)));
$kptt_nota->setField('TANDA_TRANS', "-");
$kptt_nota->setField('KD_BB_PAJAK1', "");
$kptt_nota->setField('PPN1_PERSEN', "");
$kptt_nota->setField('KD_BB_PAJAK2', "");
$kptt_nota->setField('PPN2_PERSEN', "");
$kptt_nota->setField('METERAI', $reqMaterai);
$kptt_nota->setField('KD_BB_METERAI', "");
$kptt_nota->setField('PPN_PEM_PERSEN', "");	
$kptt_nota->setField('BAGIHASIL_PERSEN', "");
$kptt_nota->setField('JML_VAL_REDUKSI', "");	
$kptt_nota->setField('JML_VAL_BAYAR', "");	
$kptt_nota->setField('SISA_VAL_BAYAR', "");	
$kptt_nota->setField('KD_BANK', "");
$kptt_nota->setField('REK_BANK', "");
$kptt_nota->setField('KD_BB_BANK', "");	
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
$kptt_nota->setField('CETAK_NOTA', "0");	
$kptt_nota->setField('LAST_APPROVE_DATE', OCI_SYSDATE);	
$kptt_nota->setField('LAST_APPROVE_BY', "AKUNTANSI_PMS");		
$kptt_nota->setField('PREV_NOTA_UPDATE', $reqNotaUpdate);	
$kptt_nota->setField('REF_NOTA_CICILAN', "");	
$kptt_nota->setField('PERIODE_CICILAN', "");		
$kptt_nota->setField('JML_KALI_CICILAN', "");			
$kptt_nota->setField('CICILAN_KE', "");
$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
$kptt_nota->setField('ID_KASIR', "AKUNTANSI_PMS");		
$kptt_nota->setField('AUTO_MANUAL', "");		
$kptt_nota->setField('STAT_RKP_KARTU', "0");	
$kptt_nota->setField('TGL_POSTING', dateToDBCheck(""));		
$kptt_nota->setField('NO_FAKT_PAJAK', "");	
$kptt_nota->setField('JML_VAL_PAJAK', dotToNo($reqJumlahPajak));	
$kptt_nota->setField('JML_RP_PAJAK', "");		
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
$kptt_nota->setField('PROGRAM_NAME', "KPTT_ENOTA_KOREK_PIUT_NEW_I");			
$kptt_nota->setField('NO_REG', "");	
$kptt_nota->setField('FLAG_TUNAI', "");	
$kptt_nota->setField('TGL_BATAL', dateToDBCheck(""));	
$kptt_nota->setField('NO_NOTA_BTL', "");			
$kptt_nota->setField('NO_DN', "");		
$kptt_nota->setField('TGL_DN', dateToDBCheck(""));
$kptt_nota->setField('FLAG_PUPN', "");		
$kptt_nota->setField('JML_TAGIHAN', dotToNo($reqJumlahTrans));			
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
$kptt_nota->setField('FAKTUR_PAJAK', "");
$kptt_nota->setField('TGL_FAKTUR_PAJAK', dateToDBCheck(""));
$kptt_nota->setField('FAKTUR_PAJAK_PREFIX', "");		
		
if($kptt_nota->insert())
{
	for($i=0; $i<count($reqKlasTrans); $i++)
	{
		if($reqPajak[$i] == "Y")
			$reqPajakId = 1;
		else
			$reqPajakId = 0;
					
		$kptt_nota_d = new KpttNotaD();
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_d->setField('JEN_JURNAL', "JRR");
		$kptt_nota_d->setField('TIPE_TRANS', "JRR-KPT-01");
		$kptt_nota_d->setField('NO_NOTA', $reqNoBukti);
		$kptt_nota_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_d->setField('KLAS_TRANS', $reqKlasTrans[$i]);
		$kptt_nota_d->setField('KWANTITAS', "");
		$kptt_nota_d->setField('SATUAN', "");
		$kptt_nota_d->setField('HARGA_SATUAN', "");
		$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");	
		$kptt_nota_d->setField('KD_VALUTA', $reqValutaNama);
		$kptt_nota_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
		$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqJumlah[$i]));
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', "");
		$kptt_nota_d->setField('JML_VAL_PAJAK', dotToNo($reqNilaiPajak[$i]));
		$kptt_nota_d->setField('JML_RP_TRANS', floor(dotToNo($reqJumlah[$i]) * dotToNo($reqKursValuta)));
		$kptt_nota_d->setField('JML_RP_PAJAK', dotToNo($reqNilaiPajak[$i]));
		$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_d->setField('TANDA_TRANS', "-");
		$kptt_nota_d->setField('KD_BUKU_BESAR', "");
		$kptt_nota_d->setField('KD_SUB_BANTU', $reqNoPelanggan);	
		$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
		$kptt_nota_d->setField('KD_D_K', "K");
		$kptt_nota_d->setField('PREV_NO_NOTA', $reqNotaUpdate);
		$kptt_nota_d->setField('KET_TAMBAHAN', "");
		$kptt_nota_d->setField('STATUS_PROSES', "1");	
		$kptt_nota_d->setField('FLAG_JURNAL', "");
		$kptt_nota_d->setField('NO_REF1', "");
		$kptt_nota_d->setField('NO_REF2', "");
		$kptt_nota_d->setField('NO_REF3', "");
		$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "KPTT_ENOTA_KOREK_PIUT_NEW_I");
		$kptt_nota_d->setField('KD_TERMINAL', "");
		$kptt_nota_d->setField('NL_TARIF', "");
		$kptt_nota_d->insert();
		unset($kptt_nota_d);
	}
	//BUAT JURNAL

	$kptt_nota->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota->callGenerateJrrNota();

	$kptt_nota_update = new KpttNota();
	$kptt_nota_update->setField("TGL_BATAL", dateToDBCheck($reqTanggalTransaksi));			
	$kptt_nota_update->setField("PREV_NOTA_UPDATE", $reqNoBukti);			
	$kptt_nota_update->setField("NO_NOTA", $reqNotaUpdate);			
	$kptt_nota_update->updatePembatalanSudahCetakNota();
	
	$kptt_nota_d_update = new KpttNotaD();
	$kptt_nota_d_update->setField("NO_NOTA", $reqNotaUpdate);			
	$kptt_nota_d_update->updatePembatalanSudahCetakNota();

	$kbbt_jur_bb_d_update = new KbbtJurBbD();
	$kbbt_jur_bb_d_update->setField("PREV_NO_NOTA", $reqNotaUpdate);			
	$kbbt_jur_bb_d_update->setField("NO_NOTA", $reqNoBukti);							
	$kbbt_jur_bb_d_update->updatePembatalanSudahCetakNota();

	/*
	MELALUI PROSES DI FORM FAKTUR PAJAK SAJA!! JANGAN OTOMATIS
	$no_faktur_pajak_d = new NoFakturPajakD();
	$no_faktur_pajak_d->setField("NO_NOTA", $reqNotaUpdate);
	$no_faktur_pajak_d->updateBatal();
	*/
			
	// COMMAND 	
	/*$kptt_nota_posting = new KpttNota();
	$kptt_nota_posting->setField("KD_SUBSIS", "KPT");		
	$kptt_nota_posting->setField("NO_NOTA", $reqNoBukti);		
	$kptt_nota_posting->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));		
	$kptt_nota_posting->setField("PREV_NOTA", $reqNotaUpdate);		
	$kptt_nota_posting->callAutoPostingPembatalanNota();*/


	$kptt_nota_surcharge = new KpttNota();
	$kptt_nota_surcharge->selectByParamsSurcharge($reqNoRef3, $reqNoPelanggan);
	$kptt_nota_surcharge->firstRow();
	if($kptt_nota_surcharge->getField("NO_NOTA") == "")
	{
		$pesan = "Data berhasil disimpan.";	
	}
	else
	{
		if($kptt_nota_surcharge->getField("NO_POSTING") == "")
		{
			$kptt_nota_surcharge->setField("NO_NOTA", $kptt_nota_surcharge->getField("NO_NOTA"));
			$kptt_nota_surcharge->delete();
			
			$kptt_nota_d_surcharge = new KpttNotaD();
			$kptt_nota_d_surcharge->setField("NO_NOTA", $kptt_nota_surcharge->getField("NO_NOTA"));
			$kptt_nota_d_surcharge->delete();

			$kptt_nota_surcharge->setField("NO_NOTA", $kptt_nota_surcharge->getField("NO_NOTA"));
			$kptt_nota_surcharge->callUpdStsNotaUsaha();			
			
			$pesan = "Data berhasil disimpan.";	
		}
		else
		{
			
			$pesan = "Ada Surcharge pada nota tsb, silahkan lanjutkan pembatalan nota surcharge nomor ".$kptt_nota_surcharge->getField("NO_REF3").".";	
		}
	}

		
	echo $reqNoBukti."-".$pesan;
	
}

?>