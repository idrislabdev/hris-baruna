<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/DynamicQuery.php");

$kbbt_jur_bb_d  = new KbbtJurBbD();
$dynamic_query = new DynamicQuery();

$reqId = httpFilterPost("reqId");
$reqBukuBesar= $_POST["reqBukuBesar"];
$reqKartu= $_POST["reqKartu"];
$reqBukuPusat= $_POST["reqBukuPusat"];
$reqDebet= $_POST["reqDebet"];
$reqKredit= $_POST["reqKredit"];
$reqNoSeq= $_POST["reqNoSeq"];

$reqKursValuta = $dynamic_query->getQueryScalar(" SELECT KURS_VALUTA FROM KBBT_JUR_BB WHERE NO_NOTA = '".$reqId."' ", "KURS_VALUTA");

/* INSERT DETIL */
for($i=0; $i<count($reqNoSeq); $i++)
{			   
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField('NO_NOTA', $reqId);
	$kbbt_jur_bb_d->setField('NO_SEQ', $reqNoSeq[$i]);
	$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
	$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $reqKartu[$i]);
	$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $reqBukuPusat[$i]);	
	$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
	$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', dotToNo($reqKredit[$i]));
	$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', floor(dotToNo($reqDebet[$i]) * dotToNo($reqKursValuta)));
	$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', floor(dotToNo($reqKredit[$i]) * dotToNo($reqKursValuta)));
	$kbbt_jur_bb_d->updateJurnal();
	unset($kbbt_jur_bb_d);
}

echo $reqId."-Jurnal berhasil diupdate.";
		

?>