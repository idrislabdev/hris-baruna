<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutanBd.php");

$reqPeriode = httpFilterGet("reqPeriode");

$kalkulasi_penyusutan = new KalkulasiPenyusutanBd();

$kalkulasi_penyusutan->selectByParamsJurnal(array("PERIODE" => $reqPeriode));
$i = 0;
$jumlahDebet = 0;
while($kalkulasi_penyusutan->nextRow())
{
	$arrPenyusutan[$i]["KD_BUKU_BESAR"]	= $kalkulasi_penyusutan->getField("KD_BUKU_BESAR");
	$arrPenyusutan[$i]["NM_BUKU_BESAR"]	= $kalkulasi_penyusutan->getField("NM_BUKU_BESAR");
	$arrPenyusutan[$i]["KD_SUB_BANTU"]	= $kalkulasi_penyusutan->getField("KD_SUB_BANTU");
	$arrPenyusutan[$i]["KD_BUKU_PUSAT"]	= $kalkulasi_penyusutan->getField("KD_BUKU_PUSAT");
	$arrPenyusutan[$i]["DEBET"]	= $kalkulasi_penyusutan->getField("DEBET");
	$arrPenyusutan[$i]["KREDIT"]	= $kalkulasi_penyusutan->getField("KREDIT");
	$i++;
	$jumlahDebet += $kalkulasi_penyusutan->getField("DEBET");
}

include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();

$reqTanggalTransaksi= httpFilterGet("reqTanggalTransaksi");
$reqId = "";
$reqMode = "insert";
$reqNoBukti = "";
$reqValuta= "IDR";
$reqValutaNama = "IDR";
$reqBuktiPendukung= "TERLAMPIR";
$reqKursValuta= "1";
$reqNoFakturPajak= "";
$reqPerusahaan= "";
$reqKeteranganJurnal= "PENYUSUTAN ASSET BLM PROSES PERIODE ".getNamePeriode($reqPeriode);
$reqAlamat= "";
$reqNoPosting= "";
$reqTanggalPosting= "";
$reqJumlahDebet = $jumlahDebet;
$reqKusto = "";
$reqPerusahaanTemp = "";

if($reqPerusahaan == "")
	$reqPerusahaan = $reqPerusahaanTemp;

$reqTanggal = dateToDB($reqTanggalTransaksi);
$reqTahun= getYear($reqTanggal);
$reqBulan= getMonth($reqTanggal);

if($reqNoBukti == "")	
	$reqNoBukti = $kbbt_jur_bb->getKode("JRR", dateToDBCheck($reqTanggalTransaksi));
else
{	
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d->delete();
	unset($kbbt_jur_bb_d);
	
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb->delete();
	unset($kbbt_jur_bb);

	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->delete();
	unset($kbbt_jur_bb_d_tmp);
	
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->delete();
	unset($kbbt_jur_bb_tmp);



}
$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
$kbbt_jur_bb_d  = new KbbtJurBbD();
$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();


/* INSERT MAIN */
$kbbt_jur_bb->setField("KD_CABANG", "96");
$kbbt_jur_bb->setField("KD_SUBSIS", "KBB");
$kbbt_jur_bb->setField("TIPE_TRANS", "JRR-KBB-01");
$kbbt_jur_bb->setField("NO_NOTA", $reqNoBukti);
$kbbt_jur_bb->setField("JEN_JURNAL", "JRR");
$kbbt_jur_bb->setField("NO_REF1", $reqNoBukti);
$kbbt_jur_bb->setField("NO_REF2", "1");
$kbbt_jur_bb->setField("NO_REF3", substr($reqBuktiPendukung, 0, 24));
$kbbt_jur_bb->setField("NO_REF4", $reqBuktiPendukung);
$kbbt_jur_bb->setField("JEN_TRANS", "");
$kbbt_jur_bb->setField("KD_SUB_BANTU", $reqKusto);
$kbbt_jur_bb->setField("KD_UNITK", "");
$kbbt_jur_bb->setField("KD_KUSTO", $reqKusto);
$kbbt_jur_bb->setField("KD_KLIENT", "");
$kbbt_jur_bb->setField("KD_ASSET", "");
$kbbt_jur_bb->setField("KD_STOCK", "");
$kbbt_jur_bb->setField("THN_BUKU", $reqTahun);
$kbbt_jur_bb->setField("BLN_BUKU", $reqBulan);
$kbbt_jur_bb->setField("TGL_ENTRY", "TRUNC(SYSDATE)");
$kbbt_jur_bb->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("KD_VALUTA", $reqValutaNama);
$kbbt_jur_bb->setField("TGL_VALUTA", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("KURS_VALUTA", dotToNo($reqKursValuta));
$kbbt_jur_bb->setField("JML_VAL_TRANS", dotToNo($reqJumlahDebet));
$kbbt_jur_bb->setField("JML_RP_TRANS", floor(dotToNo($reqJumlahDebet) * dotToNo($reqKursValuta)));
$kbbt_jur_bb->setField("KD_BAYAR", "");
$kbbt_jur_bb->setField("KD_BANK", "");
$kbbt_jur_bb->setField("NOREK_BANK", "");
$kbbt_jur_bb->setField("NO_CEK_NOTA", $reqNoFakturPajak);
$kbbt_jur_bb->setField("NO_POSTING", "");
$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeteranganJurnal);
$kbbt_jur_bb->setField("USER_DATA", "");
$kbbt_jur_bb->setField("ID_KASIR", "");
$kbbt_jur_bb->setField("APPROVER", "");
$kbbt_jur_bb->setField("TANDA_TRANS", "");
$kbbt_jur_bb->setField("LAST_UPDATE_DATE", "TRUNC(SYSDATE)");
$kbbt_jur_bb->setField("LAST_UPDATED_BY", $userLogin->nama);
$kbbt_jur_bb->setField("PROGRAM_NAME", "KBB_ENTRY_JUR_JRR_IMAIS");
$kbbt_jur_bb->setField("KD_BUKU_PUSAT", "");
$kbbt_jur_bb->setField("NM_AGEN_PERUSH", substr($reqPerusahaan, 0, 49));
$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", substr($reqAlamat, 0, 59));
$kbbt_jur_bb->setField("URAIAN", "");
$kbbt_jur_bb->setField("TGL_POSTING", "NULL");
$kbbt_jur_bb->setField("JML_CETAK", "");
$kbbt_jur_bb->setField("KD_KAS", "");
$kbbt_jur_bb->setField("KD_TERMINAL", "");
$kbbt_jur_bb->setField("NO_SP", "");
$kbbt_jur_bb->setField("TGL_SP", dateToDBCheck(""));
$kbbt_jur_bb->setField("NO_KN_BANK", "");
$kbbt_jur_bb->setField("TGL_KN_BANK", dateToDBCheck(""));
$kbbt_jur_bb->setField("NO_DN", "");
$kbbt_jur_bb->setField("TGL_DN", dateToDBCheck(""));
$kbbt_jur_bb->setField("NO_REG_KASIR", "");
$kbbt_jur_bb->setField("FLAG_SETOR_PAJAK", "");
$kbbt_jur_bb->setField("STATUS_PROSES", "");
$kbbt_jur_bb->setField("VERIFIED", "");
$kbbt_jur_bb->setField("NO_URUT_UPER", "");
$kbbt_jur_bb->setField("NO_FAKT_PAJAK", "");
$kbbt_jur_bb->setField("NM_AGEN_PERUSH2", $reqPerusahaan);
$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH2", $reqAlamat);
if($kbbt_jur_bb->insert())
{
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_tmp->callPKbbtJurBbToTmp();
	
	/* INSERT DETIL */
	for($i=0; $i<count($arrPenyusutan); $i++)
	{			   
	
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbt_jur_bb_d->setField('KD_CABANG', "96");
		$kbbt_jur_bb_d->setField('NO_NOTA', $reqNoBukti);
		$kbbt_jur_bb_d->setField('NO_SEQ', $i+1);
		$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
		$kbbt_jur_bb_d->setField('KD_JURNAL', "JRR");
		$kbbt_jur_bb_d->setField('TIPE_TRANS', "JRR-KBB-01");
		$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
		$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $arrPenyusutan[$i]["KD_BUKU_BESAR"]);

		if($arrPenyusutan[$i]["KD_SUB_BANTU"] == "")
			$sub_bantu = "00000";
		else
			$sub_bantu = $arrPenyusutan[$i]["KD_SUB_BANTU"];
								
		$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $sub_bantu);
		
		if($arrPenyusutan[$i]["KD_BUKU_PUSAT"] == "")
			$buku_pusat = "000.00.00";
		else
			$buku_pusat = $arrPenyusutan[$i]["KD_BUKU_PUSAT"];
			
		$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $buku_pusat);		
		
		$kbbt_jur_bb_d->setField('KD_VALUTA', $reqValutaNama);
		$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('KURS_VALUTA', dotToNo($reqKursValuta));		
		$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', dotToNo($arrPenyusutan[$i]["DEBET"]));
		$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', dotToNo($arrPenyusutan[$i]["KREDIT"]));
		$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', floor(dotToNo($arrPenyusutan[$i]["DEBET"]) * dotToNo($reqKursValuta)));
		$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', floor(dotToNo($arrPenyusutan[$i]["KREDIT"]) * dotToNo($reqKursValuta)));
		$kbbt_jur_bb_d->setField('KET_TAMBAH', dotToNo($reqKeterangan[$i]));
		$kbbt_jur_bb_d->setField('TANDA_TRANS', "");
		$kbbt_jur_bb_d->setField('KD_AKTIF', "");
		$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
		$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
		$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
		$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
		$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kbbt_jur_bb_d->setField('PROGRAM_NAME', "KBB_ENTRY_JUR_JRR_IMAIS");
		$kbbt_jur_bb_d->setField('FAKTUR_PAJAK', $reqFakturPajak[$i]);
		$kbbt_jur_bb_d->setField('TGL_FAKTUR_PAJAK', dateToDBCheck($reqTanggalFakturPajak[$i]));
		$kbbt_jur_bb_d->insert();
		unset($kbbt_jur_bb_d);
	}
	
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqNoBukti);
	$kbbt_jur_bb_d_tmp->callPKbbtJurBbDToTmp();
	echo "Penyusutan telah dibukukan dengan nomor Jurnal : ".$reqNoBukti.".";	
}
		

?>