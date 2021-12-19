<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

$kbbt_jur_bb = new KbbtJurBb();

$reqId = httpFilterGet("reqId");

$arrId = explode(",", $reqId);

for($i=0;$i<count($arrId);$i++)
{
	$kbbt_jur_bb = new KbbtJurBb();
	
	$kbbt_jur_bb->setField("NO_NOTA", $arrId[$i]);
	$kbbt_jur_bb->updateJmlCetak();
	
	unset($kbbt_jur_bb);	
}

$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>