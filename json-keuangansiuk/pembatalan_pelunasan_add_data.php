<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");


$kptt_nota = new KpttNota();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqNoBuktiDikoreksi= httpFilterPost("reqNoBuktiDikoreksi");
$reqTipeTransaksi= httpFilterPost("reqTipeTransaksi");
$reqKdBukuBesar = httpFilterPost("reqKdBukuBesar");
$reqNmBukuBesar= httpFilterPost("reqNmBukuBesar");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqNoChqBukti= httpFilterPost("reqNoChqBukti");
$reqNoRef= httpFilterPost("reqNoRef");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqNilaiTransaksi= httpFilterPost("reqNilaiTransaksi");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{	
	$kptt_nota->setField('KD_CABANG', "96");
	$kptt_nota->setField('KD_SUBSIS', "KPT");
	$kptt_nota->setField('JEN_JURNAL', "JKK");
	$kptt_nota->setField('TIPE_TRANS', $reqTipeTransaksi);
	$kptt_nota->setField('NO_NOTA', $reqNoBukti);
	$kptt_nota->setField('NO_NOTA_JUAL', "");
	$kptt_nota->setField('JNS_JUAL', "");
	$kptt_nota->setField('NO_REF1',$reqNoRef);
	$kptt_nota->setField('NO_REF2', "");
	$kptt_nota->setField('NO_REF3', "");
	$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
	$kptt_nota->setField('BADAN_USAHA', "");
	$kptt_nota->setField('KD_BB_KUSTO', "");
	$kptt_nota->setField('KD_UNITK', "");
	$kptt_nota->setField('JEN_TRANS', "4");
	$kptt_nota->setField('TGL_ENTRY', OCI_SYSDATE);
	$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
	$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
	$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
	$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
	$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqNilaiTransaksi));
	$kptt_nota->setField('JML_RP_TRANS', dotToNo($reqNilaiTransaksi));
	$kptt_nota->setField('TANDA_TRANS', "+");
	$kptt_nota->setField('KD_BB_PAJAK1', "");
	$kptt_nota->setField('PPN1_PERSEN', $reqPersenPajak);	
	$kptt_nota->setField('KD_BB_PAJAK2', "");
	$kptt_nota->setField('PPN2_PERSEN', "");
	$kptt_nota->setField('METERAI', "");
	$kptt_nota->setField('KD_BB_METERAI', "");
	$kptt_nota->setField('PPN_PEM_PERSEN', "");	
	$kptt_nota->setField('BAGIHASIL_PERSEN', "");
	$kptt_nota->setField('JML_VAL_REDUKSI', "");	
	$kptt_nota->setField('JML_VAL_BAYAR', dotToNo($reqNilaiTransaksi));	
	$kptt_nota->setField('SISA_VAL_BAYAR', "");
	$kptt_nota->setField('KD_BANK', "");
	$kptt_nota->setField('REK_BANK', "");
	$kptt_nota->setField('KD_BB_BANK', $reqKdBukuBesar);	
	$kptt_nota->setField('NO_WD_UPER', "");	
	$kptt_nota->setField('JML_WD_UPPER', "");	
	$kptt_nota->setField('KD_BB_UPER', "");	
	$kptt_nota->setField('KD_BAYAR', "");	
	$kptt_nota->setField('NO_CHEQUE', $reqNoChqBukti);
	$kptt_nota->setField('THN_BUKU', $reqTahun);
	$kptt_nota->setField('BLN_BUKU', $reqBulan);
	$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
	$kptt_nota->setField('KD_OBYEK', "");		
	$kptt_nota->setField('NO_VOYAGE', "");	
	$kptt_nota->setField('STATUS_PROSES', "1");	
	$kptt_nota->setField('NO_POSTING', $reqNoPosting);	
	$kptt_nota->setField('CETAK_NOTA', "");	
	$kptt_nota->setField('LAST_APPROVE_DATE', dateToDBCheck(""));	
	$kptt_nota->setField('LAST_APPROVE_BY', "");		
	$kptt_nota->setField('PREV_NOTA_UPDATE', $reqNoBuktiDikoreksi);	
	$kptt_nota->setField('REF_NOTA_CICILAN', "");	
	$kptt_nota->setField('PERIODE_CICILAN', "");		
	$kptt_nota->setField('JML_KALI_CICILAN', "");			
	$kptt_nota->setField('CICILAN_KE', "");
	$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
	$kptt_nota->setField('ID_KASIR', "");		
	$kptt_nota->setField('AUTO_MANUAL', "M");		
	$kptt_nota->setField('STAT_RKP_KARTU', "");	
	$kptt_nota->setField('TGL_POSTING', dateToDBCheck($reqTanggalPosting));		
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
	$kptt_nota->setField('FLAG_EKSPEDISI', "");			
	$kptt_nota->setField('NO_EKSPEDISI', "");	
	$kptt_nota->setField('TGL_EKSPEDISI', dateToDBCheck(""));
	$kptt_nota->setField('NO_SP', "");
	$kptt_nota->setField('TGL_SP', dateToDBCheck(""));		
	$kptt_nota->setField('NO_KN_BANK', "");
	$kptt_nota->setField('TGL_KN_BANK', dateToDBCheck(""));
	$kptt_nota->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
	$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
	$kptt_nota->setField('PROGRAM_NAME', "KPTT_EKAS_KOREK");			
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
		echo "Data berhasil disimpan.";
}
else
{	
	$kptt_nota->setField('KD_CABANG', "96");
	$kptt_nota->setField('KD_SUBSIS', "KPT");
	$kptt_nota->setField('JEN_JURNAL', "JKK");
	$kptt_nota->setField('TIPE_TRANS', $reqTipeTransaksi);
	$kptt_nota->setField('NO_NOTA', $reqNoBukti);
	$kptt_nota->setField('NO_NOTA_JUAL', "");
	$kptt_nota->setField('JNS_JUAL', "");
	$kptt_nota->setField('NO_REF1',$reqNoRef);
	$kptt_nota->setField('NO_REF2', "");
	$kptt_nota->setField('NO_REF3', "");
	$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
	$kptt_nota->setField('BADAN_USAHA', "");
	$kptt_nota->setField('KD_BB_KUSTO', "");
	$kptt_nota->setField('KD_UNITK', "");
	$kptt_nota->setField('JEN_TRANS', "4");
	$kptt_nota->setField('TGL_ENTRY', OCI_SYSDATE);
	$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
	$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
	$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
	$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
	$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
	$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqNilaiTransaksi));
	$kptt_nota->setField('JML_RP_TRANS', dotToNo($reqNilaiTransaksi));
	$kptt_nota->setField('TANDA_TRANS', "+");
	$kptt_nota->setField('KD_BB_PAJAK1', "");
	$kptt_nota->setField('PPN1_PERSEN', $reqPersenPajak);	
	$kptt_nota->setField('KD_BB_PAJAK2', "");
	$kptt_nota->setField('PPN2_PERSEN', "");
	$kptt_nota->setField('METERAI', "");
	$kptt_nota->setField('KD_BB_METERAI', "");
	$kptt_nota->setField('PPN_PEM_PERSEN', "");	
	$kptt_nota->setField('BAGIHASIL_PERSEN', "");
	$kptt_nota->setField('JML_VAL_REDUKSI', "");	
	$kptt_nota->setField('JML_VAL_BAYAR', dotToNo($reqNilaiTransaksi));	
	$kptt_nota->setField('SISA_VAL_BAYAR', "");
	$kptt_nota->setField('KD_BANK', "");
	$kptt_nota->setField('REK_BANK', "");
	$kptt_nota->setField('KD_BB_BANK', $reqKdBukuBesar);	
	$kptt_nota->setField('NO_WD_UPER', "");	
	$kptt_nota->setField('JML_WD_UPPER', "");	
	$kptt_nota->setField('KD_BB_UPER', "");	
	$kptt_nota->setField('KD_BAYAR', "");	
	$kptt_nota->setField('NO_CHEQUE', $reqNoChqBukti);
	$kptt_nota->setField('THN_BUKU', $reqTahun);
	$kptt_nota->setField('BLN_BUKU', $reqBulan);
	$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
	$kptt_nota->setField('KD_OBYEK', "");		
	$kptt_nota->setField('NO_VOYAGE', "");	
	$kptt_nota->setField('STATUS_PROSES', "1");	
	$kptt_nota->setField('NO_POSTING', $reqNoPosting);	
	$kptt_nota->setField('CETAK_NOTA', "");	
	$kptt_nota->setField('LAST_APPROVE_DATE', dateToDBCheck(""));	
	$kptt_nota->setField('LAST_APPROVE_BY', "");		
	$kptt_nota->setField('PREV_NOTA_UPDATE', $reqNoBuktiDikoreksi);	
	$kptt_nota->setField('REF_NOTA_CICILAN', "");	
	$kptt_nota->setField('PERIODE_CICILAN', "");		
	$kptt_nota->setField('JML_KALI_CICILAN', "");			
	$kptt_nota->setField('CICILAN_KE', "");
	$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
	$kptt_nota->setField('ID_KASIR', "");		
	$kptt_nota->setField('AUTO_MANUAL', "M");		
	$kptt_nota->setField('STAT_RKP_KARTU', "");	
	$kptt_nota->setField('TGL_POSTING', dateToDBCheck($reqTanggalPosting));		
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
	$kptt_nota->setField('FLAG_EKSPEDISI', "");			
	$kptt_nota->setField('NO_EKSPEDISI', "");	
	$kptt_nota->setField('TGL_EKSPEDISI', dateToDBCheck(""));
	$kptt_nota->setField('NO_SP', "");
	$kptt_nota->setField('TGL_SP', dateToDBCheck(""));		
	$kptt_nota->setField('NO_KN_BANK', "");
	$kptt_nota->setField('TGL_KN_BANK', dateToDBCheck(""));
	$kptt_nota->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
	$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
	$kptt_nota->setField('PROGRAM_NAME', "KPTT_EKAS_KOREK");			
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
		echo "Data berhasil disimpan.";
			
}
?>