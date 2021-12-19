<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/SinkronisasiPegawaiLock.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");

$sinkronisasi_pegawai_lock = new SinkronisasiPegawaiLock();

$sudahPosting = $sinkronisasi_pegawai_lock->getCountByParams(array("PERIODE" => $reqPeriode));

echo $sudahPosting;
?>