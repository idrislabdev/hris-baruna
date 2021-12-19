<?php

include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSppD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");

$kptt_nota_spp = new KpttNotaSpp();
$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();
/* LOGIN CHECK */

$reqNoBukti = httpFilterGet("reqNoBukti");





$kptt_nota_spp = new KpttNotaSpp();

/* LOGIN CHECK */

$kptt_nota->setField("NO_NOTA", $reqNoBukti);
$kptt_nota->delete();
unset($kptt_nota);

$kptt_nota_d->setField("NO_NOTA", $reqNoBukti);
$kptt_nota_d->delete();
unset($kptt_nota_d);



$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();


$kptt_nota_spp->selectByParamsSimple(array("NO_POSTING" => $reqNoBukti));
$kptt_nota_spp->firstRow();
$reqTanggal = $kptt_nota_spp->getField("TGL_TRANS_INA");

$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();

$kptt_nota_spp->selectByParamsRekapPostingUlang(array("NO_POSTING" => $reqNoBukti));

$adaData = 0;
while($kptt_nota_spp->nextRow())
{

	$reqMode = httpFilterPost("reqMode");
	$reqTanggalValuta= date("d-m-Y");
	$reqTahun= date("Y");
	$reqBulan= date("m");
	$reqNoBukuBesarKas= "101.02.19.00"; //$kptt_nota_spp->getField("KD_BB_BANK");
	$reqBukuBesarKas= "101.02.19.00"; //$kptt_nota_spp->getField("KD_BB_BANK");
	$reqKodeKasBank= "101.02.19.00"; //$kptt_nota_spp->getField("KD_BB_BANK");
	$reqTanggalTransaksi= date("d-m-Y");
	$reqKeterangan= "REKAP PEMBAYARAN TANGGAL ".$reqTanggal;
	$reqValutaNama= "IDR";
	$reqJumlahTransaksi= $kptt_nota_spp->getField("JML_VAL_TRANS");
	$reqKursValuta= "IDR";
	$reqBadanUsaha = "SISWA";
	$reqTotalBayar = $kptt_nota_spp->getField("JML_VAL_TRANS");
	$reqDepartemenId = "";
	$reqNoRef2 = $kptt_nota_spp->getField("NO_REF2");


	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_d  = new KbbtJurBbD();
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kptt_nota = new KpttNota();

	/* INSERT MAIN */
	$kptt_nota->setField('KD_CABANG', "96");
	$kptt_nota->setField('KD_SUBSIS', "KPT");
	$kptt_nota->setField('JEN_JURNAL', "JKM");
	$kptt_nota->setField('TIPE_TRANS', "JKM-KPT-00");
	$kptt_nota->setField('NO_NOTA', $reqNoBukti);
	$kptt_nota->setField('NO_NOTA_JUAL', "");
	$kptt_nota->setField('JNS_JUAL', "");
	$kptt_nota->setField('NO_REF1', "TERLAMPIR");
	$kptt_nota->setField('NO_REF2', $reqNoRef2);
	$kptt_nota->setField('NO_REF3', "");
	$kptt_nota->setField('KD_KUSTO', "");	
	$kptt_nota->setField('BADAN_USAHA', "SISWA");
	$kptt_nota->setField('KD_BB_KUSTO', "(SELECT DECODE('".$reqValutaNama."', 'IDR', COA1, COA2) FROM KBBR_COA_KUST_KLIEN WHERE KD_KUST_KLIEN = 1 AND BADAN_USAHA = '".$reqBadanUsaha."')");
	$kptt_nota->setField('KD_UNITK', "");
	$kptt_nota->setField('JEN_TRANS', "2");
	$kptt_nota->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
	$kptt_nota->setField('TGL_TRANS', "TRUNC(SYSDATE)");
	$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
	$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi)." + 14");
	$kptt_nota->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
	$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
	$kptt_nota->setField('KURS_VALUTA', "1");	
	$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqTotalBayar));
	$kptt_nota->setField('JML_RP_TRANS', floor(dotToNo($reqTotalBayar) * dotToNo($reqKursValuta)));
	$kptt_nota->setField('TANDA_TRANS', "+");
	$kptt_nota->setField('KD_BB_PAJAK1', "");
	$kptt_nota->setField('PPN1_PERSEN', "0");	
	$kptt_nota->setField('KD_BB_PAJAK2', "");
	$kptt_nota->setField('PPN2_PERSEN', "");
	$kptt_nota->setField('METERAI', "0");
	$kptt_nota->setField('KD_BB_METERAI', "");
	$kptt_nota->setField('PPN_PEM_PERSEN', "");	
	$kptt_nota->setField('BAGIHASIL_PERSEN', "");
	$kptt_nota->setField('JML_VAL_REDUKSI', "");	
	$kptt_nota->setField('JML_VAL_BAYAR', "");	
	$kptt_nota->setField('SISA_VAL_BAYAR', "");
	$kptt_nota->setField('KD_BANK', "");
	$kptt_nota->setField('REK_BANK', "");
	$kptt_nota->setField('KD_BB_BANK', $reqKodeKasBank);	
	$kptt_nota->setField('NO_WD_UPER', "");	
	$kptt_nota->setField('JML_WD_UPPER', "");	
	$kptt_nota->setField('KD_BB_UPER', "");	
	$kptt_nota->setField('KD_BAYAR', "");	
	$kptt_nota->setField('NO_CHEQUE', "");
	$kptt_nota->setField('THN_BUKU', date("Y"));
	$kptt_nota->setField('BLN_BUKU', date("m"));
	$kptt_nota->setField('KET_TAMBAHAN', $reqKeterangan);	
	$kptt_nota->setField('KD_OBYEK', "");		
	$kptt_nota->setField('NO_VOYAGE', "");	
	$kptt_nota->setField('STATUS_PROSES', "1");	
	$kptt_nota->setField('NO_POSTING', "");	
	$kptt_nota->setField('CETAK_NOTA', "0");	
	$kptt_nota->setField('LAST_APPROVE_DATE', "NULL");	
	$kptt_nota->setField('LAST_APPROVE_BY', "");		
	$kptt_nota->setField('PREV_NOTA_UPDATE', "");	
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
	$kptt_nota->setField('JML_VAL_PAJAK', 0);		
	$kptt_nota->setField('JML_RP_PAJAK', "");	
	$kptt_nota->setField('JML_WDANA', 0);	
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
	$kptt_nota->setField('PROGRAM_NAME', "PEMBAYARAN_TUNAI");			
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
	$kptt_nota->setField('FAKTUR_PAJAK', "");		
	$kptt_nota->setField('TGL_FAKTUR_PAJAK', "NULL");
	$kptt_nota->setField('FAKTUR_PAJAK_PREFIX', "");	
	$kptt_nota->setField('DEPARTEMEN_ID', "");	
		
		
	if($kptt_nota->insert())
	{

		$kptt_nota_spp_d = new KpttNotaSppD();
		$kptt_nota_spp_d->selectByParamsJurnal(array("NO_POSTING" => $reqNoBukti));

		while($kptt_nota_spp_d->nextRow())
		{

			$reqJumlahBayar = $kptt_nota_spp_d->getField("JML_VAL_TRANS");
			$reqBukuBesar   = $kptt_nota_spp_d->getField("KD_BUKU_BESAR");
			$reqPrevNoNota  = $kptt_nota_spp_d->getField("NO_REF3");
			$reqKdSubBantu  = $kptt_nota_spp_d->getField("KD_SUB_BANTU");
			$reqNoNotaTrans = $kptt_nota_spp_d->getField("NO_NOTA");


			$kptt_nota_d = new KpttNotaD();
			$kptt_nota_d->setField('KD_CABANG', "96");
			$kptt_nota_d->setField('KD_SUBSIS', "KPT");
			$kptt_nota_d->setField('JEN_JURNAL', "JKM");
			$kptt_nota_d->setField('TIPE_TRANS', "JKM-KPT-00");
			$kptt_nota_d->setField('NO_NOTA', $reqNoBukti);
			$kptt_nota_d->setField('LINE_SEQ', $i+1);
			$kptt_nota_d->setField('KLAS_TRANS', "");
			$kptt_nota_d->setField('KWANTITAS', "");
			$kptt_nota_d->setField('SATUAN', "");
			$kptt_nota_d->setField('HARGA_SATUAN', dotToNo($reqJumlahBayar));
			$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");	
			$kptt_nota_d->setField('KD_VALUTA', "IDR");
			$kptt_nota_d->setField('KURS_VALUTA', "1");
			$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqJumlahBayar));
			$kptt_nota_d->setField('STATUS_KENA_PAJAK', "");
			$kptt_nota_d->setField('JML_VAL_PAJAK', "0");
			$kptt_nota_d->setField('JML_RP_TRANS', dotToNo($reqJumlahBayar));
			$kptt_nota_d->setField('JML_RP_PAJAK', "");
			$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
			$kptt_nota_d->setField('TANDA_TRANS', "+");
			$kptt_nota_d->setField('KD_BUKU_BESAR', $reqBukuBesar);
			$kptt_nota_d->setField('KD_SUB_BANTU', $reqKdSubBantu);	
			$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
			$kptt_nota_d->setField('KD_D_K', "K");
			$kptt_nota_d->setField('PREV_NO_NOTA', $reqPrevNoNota);
			$kptt_nota_d->setField('KET_TAMBAHAN', "PELUNASAN NOTA NO : ".$reqPrevNoNota);
			$kptt_nota_d->setField('STATUS_PROSES', "1");	
			$kptt_nota_d->setField('FLAG_JURNAL', "");
			$kptt_nota_d->setField('NO_REF1', $reqNoRef2);
			$kptt_nota_d->setField('NO_REF2', "");
			$kptt_nota_d->setField('NO_REF3', $reqNoRef3);
			$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
			$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
			$kptt_nota_d->setField('PROGRAM_NAME', "PEMBAYARAN_TUNAI");
			$kptt_nota_d->setField('KD_TERMINAL', "");
			$kptt_nota_d->setField('SISA', 0); //dotToNo($reqSisaBayar[$i]));
			$kptt_nota_d->setField('TAGIHAN', dotToNo($reqJumlahBayar));
			if($kptt_nota_d->insert())
			{

				$kptt_nota_spp_update = new KpttNotaSpp();
				$kptt_nota_spp_update->setField("NO_POSTING", $reqNoBukti);
				$kptt_nota_spp_update->setField("NO_NOTA", $reqNoNotaTrans);
				$kptt_nota_spp_update->updateNoPosting();

			}
			unset($kptt_nota_d);
			
			
			
			/*$kptt_nota_d_update = new KpttNotaD();
			
			$kptt_nota_d_update->setField("NO_REF_PELUNASAN", $reqNoBukti);
			$kptt_nota_d_update->setField("NO_NOTA", $reqPrevNoNota[$i]);
			$kptt_nota_d_update->setField('KD_SUB_BANTU', $reqNoPpkb[$i]);		
			$kptt_nota_d_update->updateRefPelunasan();
			
			unset($kptt_nota_d_update);*/
			
			$kptt_nota_update = new KpttNota();
			
			$kptt_nota_update->setField("PREV_NOTA_UPDATE", $reqNoBukti);
			$kptt_nota_update->setField("NO_NOTA", $reqPrevNoNota);
			$kptt_nota_update->setField("SISA_TAGIHAN", dotToNo($reqJumlahBayar));		
			$kptt_nota_update->updatePrevNotaSisaTagihan();
			
			unset($kptt_nota_update);
			
		}
		
		// KOSONGKAN YANG SUDAH DIKOSONGKAN
		$kptt_nota_d_update = new KpttNotaD();
		
		$kptt_nota_d_update->setField("NO_NOTA", $reqNoBukti);
		$kptt_nota_d_update->updateBatalPelunasan();
		
		unset($kptt_nota_d_update);
		
		//BUAT JURNAL

		$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
		$kbbt_jur_bb->callGenerateJurnalKnDnSpp();
		
		$kptt_nota->setField("NO_NOTA", $reqNoBukti);
		$kptt_nota->callInsertJmlTagihan();
		
		//KONDISI JURNAL TURAH BELUM!!!
		
		
		
	}


	$adaData++;

}




// KOSONGKAN YANG SUDAH DIKOSONGKAN
$kptt_nota_d_update = new KpttNotaD();

$kptt_nota_d_update->setField("NO_NOTA", $reqNoBukti);
$kptt_nota_d_update->updateBatalPelunasan();
unset($kptt_nota_d_update);

//BUAT JURNAL

$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
$kbbt_jur_bb->callGenerateJurnalKnDnSpp();

$kptt_nota->setField("NO_NOTA", $reqNoBukti);
$kptt_nota->callInsertJmlTagihan();

//KONDISI JURNAL TURAH BELUM!!!
echo "Jurnal berhasil diproses ulang.";

?>
