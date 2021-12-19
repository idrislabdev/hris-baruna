<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/ProsesPresensiLock.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$proses_presensi_lock = new ProsesPresensiLock();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJamKerja = httpFilterGet("reqJamKerja");

if($reqJamKerja == 4)
	$array = array("JENIS_PROSES" => "KOREKSI_ABSEN_KAPAL", "PERIODE" => $reqPeriode);
else
	$array = array("JENIS_PROSES" => "KOREKSI_ABSEN_DARAT", "PERIODE" => $reqPeriode);

$data = $proses_presensi_lock->getProsesPresensiLock($array);

$arrFinal = array("DATA" => $data);

echo json_encode($arrFinal);
?>