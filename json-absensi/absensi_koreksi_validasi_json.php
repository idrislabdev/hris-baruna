<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$absensi_koreksi = new AbsensiKoreksi();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJamKerja = httpFilterGet("reqJamKerja");

if($reqJamKerja == "")
	$statement = " AND NOT B.JAM_KERJA_JENIS_ID = 4";
else
	$statement = " AND B.JAM_KERJA_JENIS_ID = 4";

$data = $absensi_koreksi->getCountByParamsValidasi(array("PERIODE" => $reqPeriode), $statement);

$absensi_koreksi->firstRow();

$arrFinal = array("DATA" => $data);

echo json_encode($arrFinal);
?>