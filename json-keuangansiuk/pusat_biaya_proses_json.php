<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/LaporanKeuangan.php");

$laporan_keuangan = new LaporanKeuangan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqCabang = httpFilterGet("reqCabang");

$reqBulan = substr($reqPeriode,0, 2);
$reqTahun = substr($reqPeriode,2, 4);

$laporan_keuangan->setField("BULAN", $reqBulan);
$laporan_keuangan->setField("TAHUN", $reqTahun);	
$laporan_keuangan->setField("CABANG", $reqCabang);	
if($reqCabang == "")
	$laporan_keuangan->callWlapLabaRugiPusatPrt2();
else
	$laporan_keuangan->callWlapLabaRugiPusatPrt2Cab();	


$arrFinal = array("STATUS" => 1);

echo json_encode($arrFinal);
?>