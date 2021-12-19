<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/KalkulasiTransport.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");

$kalkulasi_transport = new KalkulasiTransport();

if($reqJenisPegawaiId == "")
	$reqJenisPegawaiId = '1';

$kalkulasi_transport->setField("PERIODE", $reqPeriode);
$kalkulasi_transport->callKalkulasi();	

echo 'Kalkulasi Transport Berhasil Diproses ';
?>