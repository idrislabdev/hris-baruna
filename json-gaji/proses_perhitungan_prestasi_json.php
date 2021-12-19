<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/PerhitunganPrestasi.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");

$perhitungan_prestasi = new PerhitunganPrestasi();

$perhitungan_prestasi->setField("PERIODE", $reqPeriode);
$perhitungan_prestasi->callSinkronisasiPrestasi();	

echo 'Gaji Berhasil Diproses ';
?>