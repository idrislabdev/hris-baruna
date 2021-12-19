<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNoSeq= $_POST["reqNoSeq"];
$reqBukuBesar= $_POST["reqBukuBesar"];
$reqKartu= $_POST["reqKartu"];
$reqBukuPusat= $_POST["reqBukuPusat"];
$reqKeterangan= $_POST["reqKeterangan"];
$reqDebet= $_POST["reqDebet"];
$reqKredit= $_POST["reqKredit"];


if($reqMode == "insert")
{
	for($i=0; $i<count($reqBukuBesar); $i++)
	{			   
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbt_jur_bb_d->setField('KD_CABANG', "96");
		$kbbt_jur_bb_d->setField('NO_NOTA', $reqId);
		$kbbt_jur_bb_d->setField('NO_SEQ', $reqNoSeq[$i]);
		$kbbt_jur_bb_d->setField('NO_SEQ', $i+1);
		$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
		$kbbt_jur_bb_d->setField('KD_JURNAL', "JKM");
		$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKM-KBB-01");
		$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
		$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
		$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $reqKartu[$i]);
		$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $reqBukuPusat[$i]);
		$reqKodeValuta="IDR";
		$kbbt_jur_bb_d->setField('KD_VALUTA', $reqKodeValuta);
		$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$reqKursValuta="1";
		$kbbt_jur_bb_d->setField('KURS_VALUTA', $reqKursValuta);
		
		$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
		$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', dotToNo($reqKredit[$i]));
		$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', dotToNo($reqDebet[$i]));
		$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', dotToNo($reqKredit[$i]));
		$kbbt_jur_bb_d->setField('KET_TAMBAH', dotToNo($reqKeterangan[$i]));
		$kbbt_jur_bb_d->setField('TANDA_TRANS', "+");
		$kbbt_jur_bb_d->setField('KD_AKTIF', "");
		$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
		$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
		$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
		$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
		$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kbbt_jur_bb_d->setField('PROGRAM_NAME', "IMAIS");
		$kbbt_jur_bb_d->insert();
		unset($kbbt_jur_bb_d);
	}
	
	$set= new KbbtJurBbD();
	$set->setField("NO_NOTA", $reqId);
	$set->callPKbbtJurBbDToTmp();
	//echo $reqId."-Data berhasil disimpan.";
	echo "-Data berhasil disimpan.";
}
else
{		
	$set= new KbbtJurBbD();
	$set->setField("NO_NOTA", $reqId);
	$set->delete();
	unset($set);
	
	for($i=0; $i<count($reqBukuBesar); $i++)
	{			   
		$kbbt_jur_bb_d = new KbbtJurBbD();
		$kbbt_jur_bb_d->setField('KD_CABANG', "96");
		$kbbt_jur_bb_d->setField('NO_NOTA', $reqId);
		$kbbt_jur_bb_d->setField('NO_SEQ', $reqNoSeq[$i]);
		$kbbt_jur_bb_d->setField('NO_SEQ', $i+1);
		$kbbt_jur_bb_d->setField('KD_SUBSIS', "KBB");
		$kbbt_jur_bb_d->setField('KD_JURNAL', "JKM");
		$kbbt_jur_bb_d->setField('TIPE_TRANS', "JKM-KBB-01");
		$kbbt_jur_bb_d->setField('KLAS_TRANS', "");
		$kbbt_jur_bb_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
		$kbbt_jur_bb_d->setField('KD_SUB_BANTU', $reqKartu[$i]);
		$kbbt_jur_bb_d->setField('KD_BUKU_PUSAT', $reqBukuPusat[$i]);
		$reqKodeValuta="IDR";
		$kbbt_jur_bb_d->setField('KD_VALUTA', $reqKodeValuta);
		$kbbt_jur_bb_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$reqKursValuta="1";
		$kbbt_jur_bb_d->setField('KURS_VALUTA', $reqKursValuta);
		
		$kbbt_jur_bb_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
		$kbbt_jur_bb_d->setField('SALDO_VAL_KREDIT', dotToNo($reqKredit[$i]));
		$kbbt_jur_bb_d->setField('SALDO_RP_DEBET', dotToNo($reqDebet[$i]));
		$kbbt_jur_bb_d->setField('SALDO_RP_KREDIT', dotToNo($reqKredit[$i]));
		$kbbt_jur_bb_d->setField('KET_TAMBAH', dotToNo($reqKeterangan[$i]));
		$kbbt_jur_bb_d->setField('TANDA_TRANS', "+");
		$kbbt_jur_bb_d->setField('KD_AKTIF', "");
		$kbbt_jur_bb_d->setField('PREV_NO_NOTA', "");
		$kbbt_jur_bb_d->setField('REF_NOTA_JUAL_BELI', "");
		$kbbt_jur_bb_d->setField('BAYAR_VIA', "");
		$kbbt_jur_bb_d->setField('STATUS_KENA_PAJAK', "");
		$kbbt_jur_bb_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kbbt_jur_bb_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kbbt_jur_bb_d->setField('PROGRAM_NAME', "IMAIS");
		$kbbt_jur_bb_d->insert();
		unset($kbbt_jur_bb_d);
	}
	
	$set= new KbbtJurBbD();
	$set->setField("NO_NOTA", $reqId);
	$set->callPKbbtJurBbDToTmp();
	echo $reqId."-Data berhasil disimpan.";
}
?>