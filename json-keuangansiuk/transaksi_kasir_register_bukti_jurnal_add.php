<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb_d = new KbbtJurBbD();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqNoDokumen= httpFilterPost("reqNoDokumen");
$reqKodeJurnal= httpFilterPost("reqKodeJurnal");
$reqNoNota= httpFilterPost("reqNoNota");
$reqKursValuta= httpFilterPost("reqKursValuta");
$reqTanggalTransaksi= httpFilterPost("reqTanggalTransaksi");
$reqTanggalPosting= httpFilterPost("reqTanggalPosting");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqPerusahaan= httpFilterPost("reqPerusahaan");
$reqAlamat= httpFilterPost("reqAlamat");
$reqKdSubsis = httpFilterPost("reqKdSubsis");

$reqNoUrut = $_POST["reqNoUrut"];
$reqBukuBesar = $_POST["reqBukuBesar"];
$reqKartu = $_POST["reqKartu"];
$reqBukuPusat = $_POST["reqBukuPusat"];
$reqDebet = $_POST["reqDebet"];
$reqKredit = $_POST["reqKredit"];


if($reqValutaNama == "USD")
{
	$arrTanggalPosting = explode("-", $reqTanggalPosting);
	
	/* CHECK KURS */
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoNota);
	$kbbt_jur_bb->setField("PERIODE", $arrTanggalPosting[1].$arrTanggalPosting[2]);
	
	$kbbt_jur_bb->callPreTransRegKasirUsd();
	
	/* CHECK SELISIH NOTA */
	$kbbt_jur_bb->setField("NO_NOTA", $reqNoNota);
	$kbbt_jur_bb->callSelisihRp();
	
}

$no_reg_kasir = generateZero($kbbt_jur_bb->getNoRegKasir($reqKodeJurnal), 4)."/".$reqKodeJurnal."/".date('m')."/".date('y');

/* UPDATE KBBT_JUR_BB */
$kbbt_jur_bb->setField("NO_NOTA", $reqNoNota);
$kbbt_jur_bb->setField("NO_REG_KASIR", $no_reg_kasir);
$kbbt_jur_bb->setField("TGL_POSTING", dateToDBCheck($reqTanggalPosting));
$kbbt_jur_bb->setField("TGL_TRANS", dateToDBCheck($reqTanggalTransaksi));
$kbbt_jur_bb->setField("NM_AGEN_PERUSH", $reqPerusahaan);
$kbbt_jur_bb->setField("ALMT_AGEN_PERUSH", $reqAlamat);
$kbbt_jur_bb->setField("KD_VALUTA", $reqValutaNama);
$kbbt_jur_bb->setField("KET_TAMBAH", $reqKeterangan);
$kbbt_jur_bb->updateRegisterKasir();

/* UPDATE KBBT_JUR_BB_D */
for($i=0;$i<count($reqNoUrut);$i++)
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("KD_BUKU_BESAR", $reqBukuBesar[$i]);					   
	$kbbt_jur_bb_d->setField("KD_SUB_BANTU", $reqKartu[$i]);					   
	$kbbt_jur_bb_d->setField("KD_BUKU_PUSAT", $reqBukuPusat[$i]);					   
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqNoNota);					   
	$kbbt_jur_bb_d->setField("NO_SEQ", $reqNoUrut[$i]);					   
	$kbbt_jur_bb_d->updateJurnalRegisterKasir();
	unset($kbbt_jur_bb_d);	
}


$kbbt_jur_bb_posting = new KbbtJurBb();
$kbbt_jur_bb_posting->setField("KD_SUBSIS", $reqKdSubsis);
$kbbt_jur_bb_posting->setField("NO_NOTA", $reqNoNota);
$no_posting = $kbbt_jur_bb_posting->callPosting();


if($no_posting == "")
{
	echo "Data gagal diposting, hubungi administrator. Pesan Error : ".$kbbt_jur_bb_posting->errorMsg;	
}
else
{
	$kbbt_jur_bb_posting->setField("NO_NOTA", $reqNoNota);
	$kbbt_jur_bb_posting->callInsertJurKasir();	
	echo "Data berhasil diposting.";	
}

?>