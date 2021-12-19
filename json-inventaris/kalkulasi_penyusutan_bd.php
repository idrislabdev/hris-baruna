<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutanBd.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kalkulasi_penyusutan = new KalkulasiPenyusutanBd();

$reqPeriode= httpFilterGet("reqPeriode");

$kalkulasi_penyusutan->setField("PERIODE", $reqPeriode);
if($kalkulasi_penyusutan->kalkulasi())
{
	echo "Data berhasil dikalkulasi.";	
}
?>