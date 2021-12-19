<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/LaporanKeuangan.php");

$laporan_keuangan = new LaporanKeuangan();

$reqPeriode = httpFilterGet("reqPeriode");

$reqBulan = substr($reqPeriode,0, 2);
$reqTahun = substr($reqPeriode,2, 4);

$laporan_keuangan->setField("TAHUN", $reqTahun);	
$laporan_keuangan->callSummaryNeracaSaldo();

$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>