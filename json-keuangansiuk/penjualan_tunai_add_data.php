<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kptt_nota = new KpttNota();
$kbbr_key_tabel = new KbbrKeyTabel();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqNoNota= httpFilterPost("reqNoNota");
$reqTipeTrans= "JKM-KPT-03";
$reqNoBuktiLain= httpFilterPost("reqNoBuktiLain");
$reqNoBukuBesarKas= httpFilterPost("reqNoBukuBesarKas");
$reqBukuBesarKas= httpFilterPost("reqBukuBesarKas");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqAlamat= httpFilterPost("reqAlamat");
$reqNPWP= httpFilterPost("reqNPWP");
$reqPersenPajak= httpFilterPost("reqPersenPajak");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqMaterai= httpFilterPost("reqMaterai");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqJumlahDiBayar= httpFilterPost("reqJumlahDiBayar");
$reqBadanUsaha = httpFilterPost("reqBadanUsaha");

if($reqMode == "insert")
{
	$kptt_nota->setField('KD_CABANG', "96");
	$kptt_nota->setField('KD_SUBSIS', "KPT");
	$kptt_nota->setField('JEN_JURNAL', "JKM");
	$kptt_nota->setField('TIPE_TRANS', $reqTipeTrans);
	$kptt_nota->setField('NO_NOTA', $reqNoBukti);
	$kptt_nota->setField('NO_NOTA_JUAL', "");
	$kptt_nota->setField('JNS_JUAL', "");
	$kptt_nota->setField('NO_REF1', $reqNoBuktiLain);
	$kptt_nota->setField('NO_REF2', "");
	$kptt_nota->setField('NO_REF3', $reqNoNota);
	$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
	$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
	$kptt_nota->setField('KD_BB_KUSTO', "");
	$kptt_nota->setField('KD_UNITK', "");
	$kptt_nota->setField('JEN_TRANS', "");
	$kptt_nota->setField('TGL_ENTRY', OCI_SYSDATE);
	$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
	$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
	$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
	$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqJumlahDiBayar));
	$kptt_nota->setField('JML_RP_TRANS', dotToNo($reqJumlahDiBayar));
	$kptt_nota->setField('TANDA_TRANS', "+");
	$kptt_nota->setField('KD_BB_PAJAK1', "");
	$kptt_nota->setField('PPN1_PERSEN', $reqPersenPajak);	
	$kptt_nota->setField('KD_BB_PAJAK2', "");
	$kptt_nota->setField('PPN2_PERSEN', "");
	if($reqMaterai == 1)
	{
		$kbbr_key_tabel->selectByParams(array("KD_SUBSIS" => "METERAI"), -1, -1, " AND ".dotToNo($reqJumlahTagihan)." BETWEEN NM_NUM1 AND NM_NUM2 ");
		$kbbr_key_tabel->firstRow();
		$reqMaterai = $kbbr_key_tabel->getField("NM_NUM3");
	}
	else
		$reqMaterai = 0;
	$kptt_nota->setField('METERAI', $reqMaterai);
	$kptt_nota->setField('KD_BB_METERAI', "");
	$kptt_nota->setField('PPN_PEM_PERSEN', "");	
	$kptt_nota->setField('BAGIHASIL_PERSEN', "");
	$kptt_nota->setField('JML_VAL_REDUKSI', "");	
	$kptt_nota->setField('JML_VAL_BAYAR', dotToNo($reqJumlahDiBayar));	
	$kptt_nota->setField('SISA_VAL_BAYAR', "");
	$kptt_nota->setField('KD_BANK', $reqNoBukuBesarKas);
	$kptt_nota->setField('REK_BANK', "");
	$kptt_nota->setField('KD_BB_BANK', "");	
	$kptt_nota->setField('NO_WD_UPER', "");	
	$kptt_nota->setField('JML_WD_UPPER', "");	
	$kptt_nota->setField('KD_BB_UPER', "");	
	$kptt_nota->setField('KD_BAYAR', "1");	
	$kptt_nota->setField('NO_CHEQUE', "");
	$kptt_nota->setField('THN_BUKU', $reqTahun);
	$kptt_nota->setField('BLN_BUKU', $reqBulan);
	$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
	$kptt_nota->setField('KD_OBYEK', "");		
	$kptt_nota->setField('NO_VOYAGE', "");	
	$kptt_nota->setField('STATUS_PROSES', "1");	
	$kptt_nota->setField('NO_POSTING', "");	
	$kptt_nota->setField('CETAK_NOTA', "0");	
	$kptt_nota->setField('LAST_APPROVE_DATE', dateToDBCheck(""));	
	$kptt_nota->setField('LAST_APPROVE_BY', "");		
	$kptt_nota->setField('PREV_NOTA_UPDATE', "");	
	$kptt_nota->setField('REF_NOTA_CICILAN', "");	
	$kptt_nota->setField('PERIODE_CICILAN', "");		
	$kptt_nota->setField('JML_KALI_CICILAN', "");			
	$kptt_nota->setField('CICILAN_KE', "");
	$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
	$kptt_nota->setField('ID_KASIR', "");		
	$kptt_nota->setField('AUTO_MANUAL', "M");		
	$kptt_nota->setField('STAT_RKP_KARTU', "");	
	$kptt_nota->setField('TGL_POSTING', dateToDBCheck(""));		
	$kptt_nota->setField('NO_FAKT_PAJAK', "");	
	$kptt_nota->setField('JML_VAL_PAJAK', "");		
	$kptt_nota->setField('JML_RP_PAJAK', "");	
	$kptt_nota->setField('JML_WDANA', "");	
	$kptt_nota->setField('BULTAH', $reqTahun.$reqBulan);		
	$kptt_nota->setField('CETAK_APBMI', "0");			
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
	$kptt_nota->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
	$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
	$kptt_nota->setField('PROGRAM_NAME', "IMAIS");			
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
		
	if($kptt_nota->insert())
		echo $reqNoBukti."-Data berhasil disimpan.";
}
else
{	
	$kptt_nota->setField('KD_CABANG', "96");
	$kptt_nota->setField('KD_SUBSIS', "KPT");
	$kptt_nota->setField('JEN_JURNAL', "JKM");	
	$kptt_nota->setField('TIPE_TRANS', $reqTipeTrans);
	$kptt_nota->setField('TIPE_TRANS_ID', $reqTipeTrans);
	$kptt_nota->setField('NO_NOTA', $reqNoBukti);
	$kptt_nota->setField('NO_NOTA_JUAL', "");
	$kptt_nota->setField('JNS_JUAL', "");
	$kptt_nota->setField('NO_REF1', $reqNoBuktiLain);
	$kptt_nota->setField('NO_REF2', "");
	$kptt_nota->setField('NO_REF3', $reqNoNota);
	$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
	$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
	$kptt_nota->setField('KD_BB_KUSTO', "");
	$kptt_nota->setField('KD_UNITK', "");
	$kptt_nota->setField('JEN_TRANS', "");
	$kptt_nota->setField('TGL_ENTRY', OCI_SYSDATE);
	$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
	$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
	$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
	$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqJumlahDiBayar));
	$kptt_nota->setField('JML_RP_TRANS', dotToNo($reqJumlahDiBayar));
	$kptt_nota->setField('TANDA_TRANS', "+");
	$kptt_nota->setField('KD_BB_PAJAK1', "");
	$kptt_nota->setField('PPN1_PERSEN', $reqPersenPajak);	
	$kptt_nota->setField('KD_BB_PAJAK2', "");
	$kptt_nota->setField('PPN2_PERSEN', "");
	if($reqMaterai == 1)
	{
		$kbbr_key_tabel->selectByParams(array("KD_SUBSIS" => "METERAI"), -1, -1, " AND ".dotToNo($reqJumlahTagihan)." BETWEEN NM_NUM1 AND NM_NUM2 ");
		$kbbr_key_tabel->firstRow();
		$reqMaterai = $kbbr_key_tabel->getField("NM_NUM3");
	}
	else
		$reqMaterai = 0;
	$kptt_nota->setField('METERAI', $reqMaterai);
	$kptt_nota->setField('KD_BB_METERAI', "");
	$kptt_nota->setField('PPN_PEM_PERSEN', "");	
	$kptt_nota->setField('BAGIHASIL_PERSEN', "");
	$kptt_nota->setField('JML_VAL_REDUKSI', "");	
	$kptt_nota->setField('JML_VAL_BAYAR', dotToNo($reqJumlahDiBayar));	
	$kptt_nota->setField('SISA_VAL_BAYAR', "");
	$kptt_nota->setField('KD_BANK', $reqNoBukuBesarKas);
	$kptt_nota->setField('REK_BANK', "");
	$kptt_nota->setField('KD_BB_BANK', "");	
	$kptt_nota->setField('NO_WD_UPER', "");	
	$kptt_nota->setField('JML_WD_UPPER', "");	
	$kptt_nota->setField('KD_BB_UPER', "");	
	$kptt_nota->setField('KD_BAYAR', "1");	
	$kptt_nota->setField('NO_CHEQUE', "");
	$kptt_nota->setField('THN_BUKU', $reqTahun);
	$kptt_nota->setField('BLN_BUKU', $reqBulan);
	$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
	$kptt_nota->setField('KD_OBYEK', "");		
	$kptt_nota->setField('NO_VOYAGE', "");	
	$kptt_nota->setField('STATUS_PROSES', "1");	
	$kptt_nota->setField('NO_POSTING', "");	
	$kptt_nota->setField('CETAK_NOTA', "0");	
	$kptt_nota->setField('LAST_APPROVE_DATE', dateToDBCheck(""));	
	$kptt_nota->setField('LAST_APPROVE_BY', "");		
	$kptt_nota->setField('PREV_NOTA_UPDATE', "");	
	$kptt_nota->setField('REF_NOTA_CICILAN', "");	
	$kptt_nota->setField('PERIODE_CICILAN', "");		
	$kptt_nota->setField('JML_KALI_CICILAN', "");			
	$kptt_nota->setField('CICILAN_KE', "");
	$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
	$kptt_nota->setField('ID_KASIR', "");		
	$kptt_nota->setField('AUTO_MANUAL', "M");		
	$kptt_nota->setField('STAT_RKP_KARTU', "");	
	$kptt_nota->setField('TGL_POSTING', dateToDBCheck(""));		
	$kptt_nota->setField('NO_FAKT_PAJAK', "");	
	$kptt_nota->setField('JML_VAL_PAJAK', "");		
	$kptt_nota->setField('JML_RP_PAJAK', "");	
	$kptt_nota->setField('JML_WDANA', "");	
	$kptt_nota->setField('BULTAH', $reqTahun.$reqBulan);		
	$kptt_nota->setField('CETAK_APBMI', "0");			
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
	$kptt_nota->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
	$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
	$kptt_nota->setField('PROGRAM_NAME', "IMAIS");			
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
		
	if($kptt_nota->update())
		echo $reqNoBukti."Data berhasil disimpan.";
			
}
?>