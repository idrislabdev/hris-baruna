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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();
$kptt_nota_d = new  KpttNotaD();
$no_faktur_pajak_d = new NoFakturPajakD();
$no_faktur_pajak = new NoFakturPajak();

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
$reqKursPajak= httpFilterPost("reqKursPajak");
$reqJumlahDiBayar= httpFilterPost("reqJumlahDiBayar");
$reqBadanUsaha = httpFilterPost("reqBadanUsaha");
$reqJumlahPajak = httpFilterPost("reqJumlahPajak");
$reqJumlahTrans = httpFilterPost("reqJumlahTrans");
$reqBukuBesarKasBB = httpFilterPost("reqBukuBesarKasBB");
$reqFakturPajak = httpFilterPost("reqFakturPajak");
$reqTanggalValutaPajak= httpFilterPost("reqTanggalValutaPajak");
$reqTanggalValuta= httpFilterPost("reqTanggalValuta");
$reqTanggalFakturPajak = httpFilterPost("reqTanggalFakturPajak");
$reqFakturPajakPrefix = httpFilterPost("reqFakturPajakPrefix");

if($reqNoBukuBesarKas == "")
	$reqNoBukuBesarKas = "00000";

$reqKlasTrans = $_POST["reqKlasTrans"];
$reqPajak = $_POST["reqPajak"];
$reqLbr = $_POST["reqLbr"];
$reqNilaiJasa = $_POST["reqNilaiJasa"];
$reqNilaiPajak = $_POST["reqNilaiPajak"];
$reqJumlah = $_POST["reqJumlah"];
$reqKdBukuBesar = $_POST["reqKdBukuBesar"];
$reqDK = $_POST["reqDK"];

if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JKM", dateToDBCheck($reqTanggalTransaksi));
else
{	
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->delete();
	unset($kbbt_jur_bb);

	$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d->delete();
	unset($kbbt_jur_bb_d);

	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->delete();
	unset($kbbt_jur_bb_tmp);

	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->delete();
	unset($kbbt_jur_bb_d_tmp);

	$kptt_nota->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota->delete();
	unset($kptt_nota);
	
	$kptt_nota_d->setField("NO_NOTA", $reqNoBukti);
	$kptt_nota_d->delete();
	unset($kptt_nota_d);

}

if($reqNoNota == "")
{
	$reqTglTransDb = dateToDB($reqTanggalTransaksi);
	$reqNoNota = $kptt_nota->getInvoiceNo(getMonth($reqTglTransDb), getYear($reqTglTransDb));
}

$no_faktur_pajak_d_check = new NoFakturPajakD();
$no_faktur_pajak_d_check->selectByParamsAktif(array("NOMOR" => $reqFakturPajak));
$no_faktur_pajak_d_check->firstRow();

if($no_faktur_pajak_d_check->getField("STATUS") == "1")
{
	if($no_faktur_pajak_d_check->getField("NO_NOTA") == $reqNoBukti)
	{}
	else
		$reqFakturPajak = $no_faktur_pajak->getLastFakturPajak("");	
}

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
$kptt_nota = new KpttNota();

// echo "adfdaf";exit();
/* INSERT MAIN */
$kptt_nota->setField('KD_CABANG', "96");
$kptt_nota->setField('KD_SUBSIS', "KPT");
$kptt_nota->setField('JEN_JURNAL', "JKM");
$kptt_nota->setField('TIPE_TRANS', $reqTipeTrans);
$kptt_nota->setField('NO_NOTA', $reqNoBukti);
$kptt_nota->setField('NO_NOTA_JUAL', "");
$kptt_nota->setField('JNS_JUAL', "");
$kptt_nota->setField('NO_REF1', $reqNoNota);
$kptt_nota->setField('NO_REF2', "");
$kptt_nota->setField('NO_REF3', $reqNoNota);
$kptt_nota->setField('KD_KUSTO', $reqNoPelanggan);	
$kptt_nota->setField('BADAN_USAHA', $reqBadanUsaha);
$kptt_nota->setField('KD_BB_KUSTO', "NULL");
$kptt_nota->setField('KD_UNITK', "");
$kptt_nota->setField('JEN_TRANS', "");
$kptt_nota->setField('TGL_ENTRY', "TRUNC(SYSDATE)");
$kptt_nota->setField('TGL_TRANS', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_NOTA_DITERIMA', dateToDBCheck(""));
$kptt_nota->setField('TGL_JT_TEMPO', dateToDBCheck($reqTanggalTransaksi));
$kptt_nota->setField('TGL_VALUTA', dateToDBCheck($reqTanggalValuta));
$kptt_nota->setField('KD_VALUTA', $reqValutaNama);
$kptt_nota->setField('KURS_VALUTA', dotToNo($reqKursValuta));	
$kptt_nota->setField('JML_VAL_TRANS', dotToNo($reqJumlahDiBayar));
if($reqKursPajak == "")
	$reqKursPajakKali = 1;
else
	$reqKursPajakKali = $reqKursPajak;

$jml_rp_trans = (dotToNo($reqJumlahTrans) * dotToNo($reqKursValuta)) + (dotToNo($reqJumlahPajak) * dotToNo($reqKursPajakKali)) + $reqMaterai;
$kptt_nota->setField('JML_RP_TRANS', floor($jml_rp_trans));
$kptt_nota->setField('TANDA_TRANS', "+");
$kptt_nota->setField('KD_BB_PAJAK1', "");
$kptt_nota->setField('PPN1_PERSEN', $reqPersenPajak);	
$kptt_nota->setField('KD_BB_PAJAK2', "");
$kptt_nota->setField('PPN2_PERSEN', "");
$kptt_nota->setField('METERAI', $reqMaterai);
$kptt_nota->setField('KD_BB_METERAI', "");
$kptt_nota->setField('PPN_PEM_PERSEN', "");	
$kptt_nota->setField('BAGIHASIL_PERSEN', "");
$kptt_nota->setField('JML_VAL_REDUKSI', "");	
$kptt_nota->setField('JML_VAL_BAYAR', "");	
$kptt_nota->setField('SISA_VAL_BAYAR', "");
$kptt_nota->setField('KD_BANK', $reqNoBukuBesarKas);
$kptt_nota->setField('REK_BANK', "");
$kptt_nota->setField('KD_BB_BANK', $reqBukuBesarKasBB);	
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
$kptt_nota->setField('CETAK_NOTA', "");	
$kptt_nota->setField('LAST_APPROVE_DATE', OCI_SYSDATE);	
$kptt_nota->setField('LAST_APPROVE_BY', "KASIR");		
$kptt_nota->setField('PREV_NOTA_UPDATE', "");	
$kptt_nota->setField('REF_NOTA_CICILAN', "");	
$kptt_nota->setField('PERIODE_CICILAN', "");		
$kptt_nota->setField('JML_KALI_CICILAN', "");			
$kptt_nota->setField('CICILAN_KE', "");
$kptt_nota->setField('JT_TEMPO_CICILAN', dateToDBCheck(""));			
$kptt_nota->setField('ID_KASIR', "");		
$kptt_nota->setField('AUTO_MANUAL', "M");		
$kptt_nota->setField('STAT_RKP_KARTU', "0");	
$kptt_nota->setField('TGL_POSTING', dateToDBCheck(""));		
$kptt_nota->setField('NO_FAKT_PAJAK', "");	
$kptt_nota->setField('JML_VAL_PAJAK', dotToNo($reqJumlahPajak));		
$kptt_nota->setField('JML_RP_PAJAK', dotToNo($reqJumlahPajak) * dotToNo($reqKursPajak));	
$kptt_nota->setField('JML_WDANA', 0);	
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
$kptt_nota->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
$kptt_nota->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));		
$kptt_nota->setField('PROGRAM_NAME', "KPTT_ENOTA_TUNAI_IMAIS");			
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
$kptt_nota->setField('TGL_VAL_PAJAK', dateToDBCheck($reqTanggalValutaPajak));	
$kptt_nota->setField('KURS_VAL_PAJAK', dotToNo($reqKursPajak));		
$kptt_nota->setField('FAKTUR_PAJAK', $reqFakturPajak);		
$kptt_nota->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak));
$kptt_nota->setField('FAKTUR_PAJAK_PREFIX', $reqFakturPajakPrefix);		

if($kptt_nota->insert())
{
	/* UPDATE FAKTUR PAJAK START */
	$no_faktur_pajak_d->setField("NOMOR", $reqFakturPajak);
	$no_faktur_pajak_d->setField("NO_NOTA", $reqNoBukti);
	$no_faktur_pajak_d->updateStatus();
	/* UPDATE FAKTUR PAJAK END */
	
	for($i=0; $i<count($reqKlasTrans); $i++)
	{
		if($reqPajak[$i] == "Y")
			$reqPajakId = 1;
		else
			$reqPajakId = 0;
					
		$kptt_nota_d = new KpttNotaD();
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_d->setField('JEN_JURNAL', "JKM");
		$kptt_nota_d->setField('TIPE_TRANS', "JKM-KPT-03");
		$kptt_nota_d->setField('NO_NOTA', $reqNoBukti);
		$kptt_nota_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_d->setField('KLAS_TRANS', $reqKlasTrans[$i]);
		$kptt_nota_d->setField('KWANTITAS', $reqLbr[$i]);
		$kptt_nota_d->setField('SATUAN', "");
		$kptt_nota_d->setField('HARGA_SATUAN', dotToNo($reqJumlah[$i]));
		$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");	
		$kptt_nota_d->setField('KD_VALUTA', $reqValutaNama);
		$kptt_nota_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));
		$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqNilaiJasa[$i]));
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', $reqPajakId);
		$kptt_nota_d->setField('JML_VAL_PAJAK', dotToNo($reqNilaiPajak[$i]));
		$kptt_nota_d->setField('JML_RP_TRANS', floor(dotToNo($reqNilaiJasa[$i])* dotToNo($reqKursValuta)));
		$kptt_nota_d->setField('JML_RP_PAJAK', floor(dotToNo($reqNilaiPajak[$i])*dotToNo($reqKursPajak)));
		$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_d->setField('TANDA_TRANS', "+");
		$kptt_nota_d->setField('KD_BUKU_BESAR', $reqKdBukuBesar[$i]);
		$kptt_nota_d->setField('KD_SUB_BANTU', $reqNoPelanggan);	
		$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
		$kptt_nota_d->setField('KD_D_K', $reqDK[$i]);
		$kptt_nota_d->setField('PREV_NO_NOTA', "");
		$kptt_nota_d->setField('KET_TAMBAHAN', "");
		$kptt_nota_d->setField('STATUS_PROSES', "1");	
		$kptt_nota_d->setField('FLAG_JURNAL', "");
		$kptt_nota_d->setField('NO_REF1', "");
		$kptt_nota_d->setField('NO_REF2', "");
		$kptt_nota_d->setField('NO_REF3', "");
		$kptt_nota_d->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "KPTT_ENOTA_TUNAI_IMAIS");
		$kptt_nota_d->setField('KD_TERMINAL', "");
		$kptt_nota_d->setField('NL_TARIF', "");
		$kptt_nota_d->insert();
		unset($kptt_nota_d);
	}
	//BUAT JURNAL

	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->callGenerateJurnalPenjualanTunai();
	
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->callKopiJurnalBB();
	
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->callKopiJurnalBBD();
		
	echo $reqNoBukti."-Data berhasil disimpan.";
	
}

?>