<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");

$kptt_nota = new KpttNota();

$reqId = httpFilterGet("reqId");

$arrId = explode(",", $reqId);

for($i=0;$i<count($arrId);$i++)
{
	$kptt_nota = new KpttNota();
	
	$kptt_nota->setField("NO_NOTA", $arrId[$i]);
	$kptt_nota->callProsesCetakNotaPenjualanUlang();
	
	unset($kptt_nota);	
}

$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>