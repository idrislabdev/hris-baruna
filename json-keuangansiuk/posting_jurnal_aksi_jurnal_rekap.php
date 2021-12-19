<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

$reqId = httpFilterGet("reqId");
$reqKdSubSis = httpFilterGet("reqKdSubSis");

$kbbt_jur_bb = new KbbtJurBb();

$kbbt_jur_bb->setField("NO_NOTA", $reqId);
$kbbt_jur_bb->updatePosting();

$kbbt_jur_bb->setField("NO_NOTA", $reqId);
$kbbt_jur_bb->setField("KD_SUBSIS", $reqKdSubSis);
$no_posting = $kbbt_jur_bb->callPosting();

$kbbt_jur_bb->setField("NO_NOTA", $reqId);
$kbbt_jur_bb->callPostingKartuRekap();

$arrFinal = array("NO_POSTING" => $no_posting);

echo json_encode($arrFinal);
		
?>