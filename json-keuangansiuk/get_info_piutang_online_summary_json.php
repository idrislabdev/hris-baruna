<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaLap.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");

$kptt_nota_lap = new KpttNotaLap();
$kptt_nota_lap->selectByParamsSummary($reqId);
$kptt_nota_lap->firstRow();

$arrFinal = array("IDR" => numberToIna($kptt_nota_lap->getField("IDR")), "USD" => numberToIna($kptt_nota_lap->getField("USD")));
echo json_encode($arrFinal);
?>