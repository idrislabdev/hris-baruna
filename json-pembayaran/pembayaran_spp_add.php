<?
error_reporting(0);
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSppD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");


$kbbt_jur_bb = new KbbtJurBb();
$kptt_nota_spp = new KpttNotaSpp();
$kptt_nota_spp_d = new  KpttNotaSppD();

$reqNoRef2 = httpFilterPost("reqNoRef2");

$reqNoRef3 = httpFilterPost("reqNoRef3");
$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoBukti= httpFilterPost("reqNoBukti");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqTahun= httpFilterPost("reqTahun");
$reqBulan= httpFilterPost("reqBulan");
$reqNoPelanggan= httpFilterPost("reqNoPelanggan");
$reqPelanggan= httpFilterPost("reqPelanggan");
$reqNoBukuBesarKas= httpFilterPost("reqNoBukuBesarKas");
$reqBukuBesarKas= httpFilterPost("reqBukuBesarKas");
$reqKodeKasBank= httpFilterPost("reqKodeKasBank");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqJumlahTransaksi= httpFilterPost("reqJumlahTransaksi");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqNoPosting= httpFilterPost("reqNoPosting");
$reqBadanUsaha = httpFilterPost("reqBadanUsaha");
$reqTotalBayar = httpFilterPost("reqTotalBayar");
$reqBank = httpFilterPost("reqBank");

$reqNoPpkb = $_POST["reqNoPpkb"];
$reqPelanggan = $_POST["reqPelanggan"];
$reqTanggalNota = $_POST["reqTanggalNota"];
$reqSisaPiutang = $_POST["reqSisaPiutang"];
$reqJumlahBayar = $_POST["reqJumlahBayar"];
$reqSisaBayar = $_POST["reqSisaBayar"];
$reqUangTitipan = $_POST["reqUangTitipan"];
$reqBukuBesar = $_POST["reqBukuBesar"];
$reqPrevNoNota = $_POST["reqPrevNoNota"];


for($i=0; $i<count($reqNoPpkb); $i++)
{
	$valBayar = dotToNo($reqJumlahBayar[$i]);
	$valSisa  = dotToNo($reqSisaPiutang[$i]);


	if($valBayar > $valSisa)
	{
		$arrResult["id"] = $reqNoBukti;
		$arrResult["message"] = "Jumlah pembayaran lebih besar. Kelebihan bayar silahkan proses uang titipan.";
		$arrResult["status"] = "failed";

		echo json_encode($arrResult);
		exit;
	}
	
}


if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("NINV", dateToDBCheck($reqTanggalTransaksi));
else
{	
	$kptt_nota_spp->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota_spp->delete();
	unset($kptt_nota_spp);
	
	$kptt_nota_spp_d->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota_spp_d->delete();
	unset($kptt_nota_spp_d);

}


$kptt_nota_spp = new KpttNotaSpp();

/* INSERT MAIN */
$kptt_nota_spp->setField('KD_CABANG', "96");
$kptt_nota_spp->setField('KD_SUBSIS', "KPT");
$kptt_nota_spp->setField('JEN_JURNAL', "JKM");
$kptt_nota_spp->setField('TIPE_TRANS', "JKM-KPT-99");
$kptt_nota_spp->setField('NO_NOTA', $reqNoBukti);
$kptt_nota_spp->setField('NO_NOTA_JUAL', "");
$kptt_nota_spp->setField('JNS_JUAL', "TX");
$kptt_nota_spp->setField('NO_REF1',$reqNoRef3);
$kptt_nota_spp->setField('NO_REF2', $reqNoRef2);
$kptt_nota_spp->setField('NO_REF3', "");
$kptt_nota_spp->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota_spp->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota_spp->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
$kptt_nota_spp->setField('KD_UNITK', "");
$kptt_nota_spp->setField('JEN_TRANS', "2");
$kptt_nota_spp->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
$kptt_nota_spp->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota_spp->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota_spp->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi)." + 14");
$kptt_nota_spp->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota_spp->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota_spp->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota_spp->setField('JML_VAL_TRANS', dotToNo($reqTotalBayar));
$kptt_nota_spp->setField('JML_RP_TRANS', floor(dotToNo($reqTotalBayar) * dotToNo($reqKursValuta)));
$kptt_nota_spp->setField('TANDA_TRANS', "+");
$kptt_nota_spp->setField('KD_BB_PAJAK1', "");
$kptt_nota_spp->setField('PPN1_PERSEN', $reqPersenPajak);	
$kptt_nota_spp->setField('KD_BB_PAJAK2', "");
$kptt_nota_spp->setField('PPN2_PERSEN', "");
$kptt_nota_spp->setField('METERAI', $reqMaterai);
$kptt_nota_spp->setField('KD_BB_METERAI', "");
$kptt_nota_spp->setField('PPN_PEM_PERSEN', "");	
$kptt_nota_spp->setField('BAGIHASIL_PERSEN', "");
$kptt_nota_spp->setField('JML_VAL_REDUKSI', "");	
$kptt_nota_spp->setField('JML_VAL_BAYAR', dotToNo($reqJumlahDiBayar));	
$kptt_nota_spp->setField('SISA_VAL_BAYAR', "");
$kptt_nota_spp->setField('KD_BANK', $reqNoBukuBesarKas);
$kptt_nota_spp->setField('REK_BANK', $reqBank);
$kptt_nota_spp->setField('KD_BB_BANK', $reqKodeKasBank);	
$kptt_nota_spp->setField('NO_WD_UPER', "");	
$kptt_nota_spp->setField('JML_WD_UPPER', "");	
$kptt_nota_spp->setField('KD_BB_UPER', "");	
$kptt_nota_spp->setField('KD_BAYAR', "");	
$kptt_nota_spp->setField('NO_CHEQUE', "");
$kptt_nota_spp->setField('THN_BUKU', $reqTahun);
$kptt_nota_spp->setField('BLN_BUKU', $reqBulan);
$kptt_nota_spp->setField('KET_TAMBAHAN', $reqKeterangan);	
$kptt_nota_spp->setField('KD_OBYEK', "");		
$kptt_nota_spp->setField('NO_VOYAGE', "");	
$kptt_nota_spp->setField('STATUS_PROSES', "1");	
$kptt_nota_spp->setField('NO_POSTING', "");	
$kptt_nota_spp->setField('CETAK_NOTA', "0");	
$kptt_nota_spp->setField('LAST_APPROVE_DATE', "NULL");	
$kptt_nota_spp->setField('LAST_APPROVE_BY', "");		
$kptt_nota_spp->setField('PREV_NOTA_UPDATE', "");	
$kptt_nota_spp->setField('REF_NOTA_CICILAN', "");	
$kptt_nota_spp->setField('PERIODE_CICILAN', "");		
$kptt_nota_spp->setField('JML_KALI_CICILAN', "");			
$kptt_nota_spp->setField('CICILAN_KE', "");
$kptt_nota_spp->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
$kptt_nota_spp->setField('ID_KASIR', "AKUNTANSI_PMS");		
$kptt_nota_spp->setField('AUTO_MANUAL', "");		
$kptt_nota_spp->setField('STAT_RKP_KARTU', "0");	
$kptt_nota_spp->setField('TGL_POSTING', dateToDBCheck(""));		
$kptt_nota_spp->setField('NO_FAKT_PAJAK', "");	
$kptt_nota_spp->setField('JML_VAL_PAJAK', 0);		
$kptt_nota_spp->setField('JML_RP_PAJAK', "");	
$kptt_nota_spp->setField('JML_WDANA', 0);	
$kptt_nota_spp->setField('BULTAH', $reqTahun.$reqBulan);		
$kptt_nota_spp->setField('CETAK_APBMI', "0");			
$kptt_nota_spp->setField('NO_WDANA', "");
$kptt_nota_spp->setField('FLAG_APBMI', "");
$kptt_nota_spp->setField('TGL_CETAK', dateToDBCheck(""));			
$kptt_nota_spp->setField('KD_TERMINAL', "");
$kptt_nota_spp->setField('LOKASI', "");
$kptt_nota_spp->setField('KD_NOTA', "");		
$kptt_nota_spp->setField('FLAG_EKSPEDISI', "");			
$kptt_nota_spp->setField('NO_EKSPEDISI', "");	
$kptt_nota_spp->setField('TGL_EKSPEDISI', dateToDBCheck(""));
$kptt_nota_spp->setField('NO_SP', "");
$kptt_nota_spp->setField('TGL_SP', dateToDBCheck(""));		
$kptt_nota_spp->setField('NO_KN_BANK', "");
$kptt_nota_spp->setField('TGL_KN_BANK', dateToDBCheck(""));
$kptt_nota_spp->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
$kptt_nota_spp->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
$kptt_nota_spp->setField('PROGRAM_NAME', "KPTT_EKAS_PELUNASAN_NEW_IMAIS");			
$kptt_nota_spp->setField('NO_REG', "");	
$kptt_nota_spp->setField('FLAG_TUNAI', "");	
$kptt_nota_spp->setField('TGL_BATAL', dateToDBCheck(""));	
$kptt_nota_spp->setField('NO_NOTA_BTL', "");			
$kptt_nota_spp->setField('NO_DN', "");		
$kptt_nota_spp->setField('TGL_DN', dateToDBCheck(""));
$kptt_nota_spp->setField('FLAG_PUPN', "");		
$kptt_nota_spp->setField('JML_TAGIHAN', "");			
$kptt_nota_spp->setField('SISA_TAGIHAN', "");	
$kptt_nota_spp->setField('KD_PANGKALAN', "");	
$kptt_nota_spp->setField('FLAG_SETOR_PAJAK', "");		
$kptt_nota_spp->setField('KD_PELAYANAN', "");			
$kptt_nota_spp->setField('VERIFIED', "");	
$kptt_nota_spp->setField('NO_APPROVAL', "");	
$kptt_nota_spp->setField('TGL_APPROVAL', dateToDBCheck(""));
$kptt_nota_spp->setField('TGL_POST_BATAL', dateToDBCheck(""));
$kptt_nota_spp->setField('TGL_VAL_PAJAK', dateToDBCheck(""));	
$kptt_nota_spp->setField('KURS_VAL_PAJAK', "");		
$kptt_nota_spp->setField('FAKTUR_PAJAK', $reqFakturPajak);		
$kptt_nota_spp->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak));
$kptt_nota_spp->setField('FAKTUR_PAJAK_PREFIX', $reqFakturPajakPrefix);		
	
if($kptt_nota_spp->insert())
{
	for($i=0; $i<count($reqNoPpkb); $i++)
	{
		$kptt_nota_spp_d = new KpttNotaSppD();
		$kptt_nota_spp_d->setField('KD_CABANG', "96");
		$kptt_nota_spp_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_spp_d->setField('JEN_JURNAL', "JKM");
		$kptt_nota_spp_d->setField('TIPE_TRANS', "JKM-KPT-99");
		$kptt_nota_spp_d->setField('NO_NOTA', $reqNoBukti);
		$kptt_nota_spp_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_spp_d->setField('KLAS_TRANS', "");
		$kptt_nota_spp_d->setField('KWANTITAS', "");
		$kptt_nota_spp_d->setField('SATUAN', "");
		$kptt_nota_spp_d->setField('HARGA_SATUAN', dotToNo($reqJumlah[$i]));
		$kptt_nota_spp_d->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));	
		$kptt_nota_spp_d->setField('KD_VALUTA', $reqValutaNama);
		$kptt_nota_spp_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
		$kptt_nota_spp_d->setField('JML_VAL_TRANS', dotToNo($reqJumlahBayar[$i]));
		$kptt_nota_spp_d->setField('STATUS_KENA_PAJAK', "");
		$kptt_nota_spp_d->setField('JML_VAL_PAJAK', "");
		$kptt_nota_spp_d->setField('JML_RP_TRANS', floor(dotToNo($reqJumlahBayar[$i]) * dotToNo($reqKursValuta)));
		$kptt_nota_spp_d->setField('JML_RP_PAJAK', "");
		$kptt_nota_spp_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_spp_d->setField('TANDA_TRANS', "+");
		$kptt_nota_spp_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
		$kptt_nota_spp_d->setField('KD_SUB_BANTU', $reqNoPelanggan);	
		$kptt_nota_spp_d->setField('KD_BUKU_PUSAT', "000.00.00");
		$kptt_nota_spp_d->setField('KD_D_K', "K");
		$kptt_nota_spp_d->setField('PREV_NO_NOTA', $reqNoPpkb[$i]);
		$kptt_nota_spp_d->setField('KET_TAMBAHAN', "PELUNASAN NOTA NO : ".$reqNoPpkb[$i]);
		$kptt_nota_spp_d->setField('STATUS_PROSES', "1");	
		$kptt_nota_spp_d->setField('FLAG_JURNAL', "");
		$kptt_nota_spp_d->setField('NO_REF1', $reqNoPpkb[$i]);
		$kptt_nota_spp_d->setField('NO_REF2', "");
		$kptt_nota_spp_d->setField('NO_REF3', $reqNoPpkb[$i]);
		$kptt_nota_spp_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kptt_nota_spp_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_spp_d->setField('PROGRAM_NAME', "KPTT_EKAS_PELUNASAN_NEW_IMAIS");
		$kptt_nota_spp_d->setField('KD_TERMINAL', "");
		$kptt_nota_spp_d->setField('NL_TARIF', "");
		$kptt_nota_spp_d->insert();

		$kptt_nota_spp_d->updatePelunasan();
		
		unset($kptt_nota_spp_d);
		
	}
	//BUAT JURNAL

	$arrResult["id"] = $reqNoBukti;
	$arrResult["message"] = "Data berhasil disimpan.";
	$arrResult["status"] = "success";

	echo json_encode($arrResult);	
	
}

?>