<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");

$kbbt_jur_bb = new KbbtJurBb();

$reqPeriode = httpFilterGet("reqPeriode");

//$today = date("Ym");

if ($reqPeriode<>"") {
	$kbbt_jur_bb->callRefreshPiutang($reqPeriode);
	echo "REFRESH PIUTANG PERIODE : " . $reqPeriode . " BERHASIL";
}


?>