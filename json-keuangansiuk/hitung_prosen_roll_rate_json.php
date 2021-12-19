<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/TmpRollRate.php");;

$tmp_roll_rate = new TmpRollRate();

$reqTahun = httpFilterGet("reqTahun");
$reqBulan = httpFilterGet("reqBulan");
$reqKdValuta = httpFilterGet("reqKdValuta");
$reqBadanUsaha = httpFilterGet("reqBadanUsaha");

$tmp_roll_rate->setField("PERIODE", $reqTahun.$reqBulan);
$tmp_roll_rate->callRollRate();

$tmp_roll_rate->selectByParamsSummary($reqTahun.$reqBulan, $reqKdValuta, $reqBadanUsaha);
$tmp_roll_rate->firstRow();

$arrFinal = array("SUM_CUR"  => round(($tmp_roll_rate->getField("A")/12), 2),
				  "SUM_130"  => round(($tmp_roll_rate->getField("B")/12), 2),
				  "SUM_3190" => round(($tmp_roll_rate->getField("C")/12), 2),
				  "SUM_181"  => round(($tmp_roll_rate->getField("D")/12), 2),
				  "SUM_371"  => round(($tmp_roll_rate->getField("E")/12), 2),
				  "SUM_365"  => round(($tmp_roll_rate->getField("F")/12), 2),
				  "SUM_A365" => 100);

echo json_encode($arrFinal);
?>