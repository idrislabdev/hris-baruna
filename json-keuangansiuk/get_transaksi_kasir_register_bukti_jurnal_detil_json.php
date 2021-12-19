<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");

$kbbt_jur_bb_d = new KbbtJurBbD();
$kbbt_jur_bb_d->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");

while($kbbt_jur_bb_d->nextRow())
{
	$arrFinal[] =array("NO_SEQ" => $kbbt_jur_bb_d->getField("NO_SEQ"),
				   "KD_BUKU_BESAR" => $kbbt_jur_bb_d->getField("KD_BUKU_BESAR"),
				   "KD_SUB_BANTU" => $kbbt_jur_bb_d->getField("KD_SUB_BANTU"),
				   "KD_BUKU_PUSAT" => $kbbt_jur_bb_d->getField("KD_BUKU_PUSAT"),
				   "KET_TAMBAH" => $kbbt_jur_bb_d->getField("KET_TAMBAH"),
				   "SALDO_VAL_DEBET" => numberToIna($kbbt_jur_bb_d->getField("SALDO_VAL_DEBET")),
				   "SALDO_VAL_KREDIT" => numberToIna($kbbt_jur_bb_d->getField("SALDO_VAL_KREDIT")));
				   
}

echo json_encode($arrFinal);
?>