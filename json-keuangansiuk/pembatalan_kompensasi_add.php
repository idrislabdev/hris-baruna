<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrCoaKustKlien.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");


$kptt_nota = new KpttNota();
$kptt_nota_d = new KpttNotaD();
$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_d = new KbbtJurBbD();
$kbbr_coa_kust_klien = new KbbrCoaKustKlien();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqNoBukuBesarKas= httpFilterPost("reqNoBukuBesarKas");
$reqBank= httpFilterPost("reqBank");
$reqKodeKasBank= httpFilterPost("reqKodeKasBank");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqJumlahTransaksi= httpFilterPost("reqJumlahTransaksi");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqRekKompen= httpFilterPost("reqRekKompen");
$reqBadanUsaha = httpFilterPost("reqBadanUsaha");

$reqNoNota = $_POST["reqNoNota"];
$reqNoPelangganDetil = $_POST["reqNoPelangganDetil"];
$reqTanggalNota = $_POST["reqTanggalNota"];
$reqJumlahBayar = $_POST["reqJumlahBayar"];
$reqJumlahDikembalikan = $_POST["reqJumlahDikembalikan"];
$reqSisa = $_POST["reqSisa"];
$reqPrevNoNota = $_POST["reqPrevNoNota"];

if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JRR", dateToDBCheck($reqTanggalTransaksi));
else
{	

	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->delete();

	$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d->delete();
	
	$kptt_nota->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota->delete();
	
	$kptt_nota_d->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota_d->delete();

}

$kptt_nota->setField('KD_CABANG', "96");
$kptt_nota->setField('KD_SUBSIS', "KPT");
$kptt_nota->setField('JEN_JURNAL', "JRR");
$kptt_nota->setField('TIPE_TRANS', "JRR-KPT-05");
$kptt_nota->setField('NO_NOTA', $reqNoBukti);
$kptt_nota->setField('NO_NOTA_JUAL', "");
$kptt_nota->setField('JNS_JUAL', "");
$kptt_nota->setField('NO_REF1', "");
$kptt_nota->setField('NO_REF2', "");
$kptt_nota->setField('NO_REF3', "");
$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
$kptt_nota->setField('KD_UNITK', "");
$kptt_nota->setField('JEN_TRANS', "2");
$kptt_nota->setField('TGL_ENTRY', OCI_SYSDATE);
$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi)." + 14 ");
$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqJumlahTransaksi));
$kptt_nota->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahTransaksi) * dotToNo($reqKursValuta)));
$kptt_nota->setField('TANDA_TRANS', "+");
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
$kptt_nota->setField('KD_BANK', $reqNoBukuBesarKas);
$kptt_nota->setField('REK_BANK', "");
$kptt_nota->setField('KD_BB_BANK', $reqKodeKasBank);	
$kptt_nota->setField('NO_WD_UPER', "");	
$kptt_nota->setField('JML_WD_UPPER', dotToNo(""));	
$kptt_nota->setField('KD_BB_UPER', "");	
$kptt_nota->setField('KD_BAYAR', "");	
$kptt_nota->setField('NO_CHEQUE', "");
$kptt_nota->setField('THN_BUKU', $reqTahun);
$kptt_nota->setField('BLN_BUKU', $reqBulan);
$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
$kptt_nota->setField('KD_OBYEK', "");		
$kptt_nota->setField('NO_VOYAGE', "");	
$kptt_nota->setField('STATUS_PROSES', "1");	
$kptt_nota->setField('NO_POSTING', $reqNoPosting);	
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
$kptt_nota->setField('TGL_POSTING', dateToDBCheck($reqTanggalPosting));		
$kptt_nota->setField('NO_FAKT_PAJAK', "");	
$kptt_nota->setField('JML_VAL_PAJAK', "");		
$kptt_nota->setField('JML_RP_PAJAK', "");	
$kptt_nota->setField('JML_WDANA', "");	
$kptt_nota->setField('BULTAH', $reqTahun.$reqBulan);		
$kptt_nota->setField('CETAK_APBMI', "");			
$kptt_nota->setField('NO_WDANA', "");
$kptt_nota->setField('FLAG_APBMI', "");
$kptt_nota->setField('TGL_CETAK', dateToDBCheck(""));			
$kptt_nota->setField('KD_TERMINAL', "");
$kptt_nota->setField('LOKASI', "");
$kptt_nota->setField('KD_NOTA', "");		
$kptt_nota->setField('FLAG_EKSPEDISI', $reqMaterai);
$kptt_nota->setField('NO_EKSPEDISI', "");	
$kptt_nota->setField('TGL_EKSPEDISI', dateToDBCheck(""));
$kptt_nota->setField('NO_SP', "");
$kptt_nota->setField('TGL_SP', dateToDBCheck(""));		
$kptt_nota->setField('NO_KN_BANK', "");
$kptt_nota->setField('TGL_KN_BANK', dateToDBCheck(""));
$kptt_nota->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
$kptt_nota->setField('PROGRAM_NAME', "KPTT_EKAS_KOREK_JRR_IMAIS");			
$kptt_nota->setField('NO_REG', "");	
$kptt_nota->setField('FLAG_TUNAI', "");	
$kptt_nota->setField('TGL_BATAL', dateToDBCheck(""));	
$kptt_nota->setField('NO_NOTA_BTL', "");			
$kptt_nota->setField('NO_DN', "");		
$kptt_nota->setField('TGL_DN', dateToDBCheck(""));
$kptt_nota->setField('FLAG_PUPN', "");		
$kptt_nota->setField('JML_TAGIHAN', dotToNo(""));			
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
$kptt_nota->setField('FAKTUR_PAJAK', $reqFakturPajak);
$kptt_nota->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak));
$kptt_nota->setField('FAKTUR_PAJAK_PREFIX', $reqFakturPajakPrefix);		

if($kptt_nota->insert())
{
	for($i=0; $i<count($reqNoBukti); $i++)
	{
		$kptt_nota_d = new KpttNotaD();
		
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_d->setField('JEN_JURNAL', "JRR");
		$kptt_nota_d->setField('TIPE_TRANS', "JRR-KPT-05");
		$kptt_nota_d->setField('NO_NOTA', $reqNoBukti);
		$kptt_nota_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_d->setField('KLAS_TRANS', "");
		$kptt_nota_d->setField('KWANTITAS', "");
		$kptt_nota_d->setField('SATUAN', "");
		$kptt_nota_d->setField('HARGA_SATUAN', "");
		$kptt_nota_d->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));	
		$kptt_nota_d->setField('KD_VALUTA', $reqValutaNama);
		$kptt_nota_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
		$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqJumlahDikembalikan[$i]));
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', "");
		$kptt_nota_d->setField('JML_VAL_PAJAK', "");
		$kptt_nota_d->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahDikembalikan[$i]) * dotToNo($reqKursValuta)));
		$kptt_nota_d->setField('JML_RP_PAJAK', "");
		$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_d->setField('TANDA_TRANS', "+");
		$kptt_nota_d->setField('KD_BUKU_BESAR', $kbbr_coa_kust_klien->getKdBbKusto($reqValutaNama, $reqBadanUsaha));
		$kptt_nota_d->setField('KD_SUB_BANTU', $reqNoPelanggan);	
		$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
		$kptt_nota_d->setField('KD_D_K', "K");
		$kptt_nota_d->setField('PREV_NO_NOTA', $reqPrevNoNota[$i]);
		$kptt_nota_d->setField('KET_TAMBAHAN', "PELUNASAN NOTA NO : ".$reqPrevNoNota[$i]);
		$kptt_nota_d->setField('STATUS_PROSES', "1");	
		$kptt_nota_d->setField('FLAG_JURNAL', "");
		$kptt_nota_d->setField('NO_REF1', $reqNoNota[$i]);
		$kptt_nota_d->setField('NO_REF2', "");
		$kptt_nota_d->setField('NO_REF3', $reqNoNota[$i]);
		$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "KPTT_EKAS_KOREK_JRR_IMAIS");
		$kptt_nota_d->setField('KD_TERMINAL', "");
		$kptt_nota_d->setField('NL_TARIF', "");
		$kptt_nota_d->insert();
		unset($kptt_nota_d);
		
		$kptt_nota_update = new KpttNota();
		
		$kptt_nota_update->setField("PREV_NOTA_UPDATE", $reqNoBukti);
		$kptt_nota_update->setField("NO_NOTA", $reqPrevNoNota[$i]);
		$kptt_nota_update->updatePrevNota();
		
		unset($kptt_nota_update);		
		
/*
		$kptt_nota_update = new KpttNota();
		$kptt_nota_update->setField("PREV_NOTA_UPDATE", $reqPrevNoNota[$i]);
		$kptt_nota_update->setField("NO_NOTA", $reqNoBukti);
		$kptt_nota_update->updatePrevNota();
		
		unset($kptt_nota_update);			*/

		$kptt_nota_update = new KpttNota();
		$kptt_nota_update->setField("NO_NOTA", $reqPrevNoNota[$i]);			
		$kptt_nota_update->updatePembatalanPelunasan();

		unset($kptt_nota_update);			
		
	}

	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->callGenerateJurnalKompensasi();
	
	
	echo $reqNoBukti."-Data berhasil disimpan.";
	
}
?>