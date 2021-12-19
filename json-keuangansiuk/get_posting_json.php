<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqTabel= httpFilterGet("reqTabel");

//$reqSafrValutaKursId = 'A.11';
//$reqTahun = 3;

if($reqTabel == "KPTT_NOTA")
{
	$kptt_nota = new KpttNota();
	$kptt_nota->selectByParamsSimple(array("NO_NOTA" => $reqId));
	$kptt_nota->firstRow();
	$arrFinal = array("NO_POSTING" => $kptt_nota->getField("NO_POSTING"), "PREV_NOTA_UPDATE" => $kptt_nota->getField("PREV_NOTA_UPDATE"));
	echo json_encode($arrFinal);
}
else if($reqTabel == "KBBT_JUR_BB")
{
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->selectByParamsSimple(array("NO_NOTA" => $reqId));
	$kbbt_jur_bb->firstRow();
	$arrFinal = array("NO_POSTING" => $kbbt_jur_bb->getField("NO_POSTING"));
	echo json_encode($arrFinal);
}
?>