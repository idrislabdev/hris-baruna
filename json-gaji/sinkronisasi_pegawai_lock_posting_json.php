<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/SinkronisasiPegawaiLock.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");

$sinkronisasi_pegawai_lock = new SinkronisasiPegawaiLock();

if($reqJenisPegawaiId == "")
	$reqJenisPegawaiId = '1';

$sinkronisasi_pegawai_lock->setField("PERIODE", $reqPeriode);
$sinkronisasi_pegawai_lock->setField("LOCK_DATE", "SYSDATE");
$sinkronisasi_pegawai_lock->insert();	

echo 'Gaji Berhasil Diproses ';
?>