<?
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/Pegawai.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqPeriode = httpFilterGet("reqPeriode");

$pegawai = new Pegawai();

if($reqJenisPegawaiId == "")
	$reqJenisPegawaiId = '1';

$pegawai->setField("PERIODE", $reqPeriode);
if($pegawai->sinkronisasi())	
	echo 'Gaji Berhasil Diproses ';
else
	echo 'Gaji Gagal Diproses ';
?>