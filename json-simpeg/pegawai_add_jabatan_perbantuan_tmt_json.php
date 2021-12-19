<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatanP3.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$pegawai_jabatan_p3 = new PegawaiJabatanP3();

$reqId= httpFilterGet("reqId");
$reqTMT= httpFilterGet("reqTMT");
$reqTMTTemp= httpFilterGet("reqTMTTemp");

if($reqTMTTemp == "")
{
	$pegawai_jabatan_p3->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT));
}
else
{
	$pegawai_jabatan_p3->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')" => $reqTMTTemp));
}

$pegawai_jabatan_p3->firstRow();

$arrFinal = array("PEGAWAI_JABATAN_P3_ID" => $pegawai_jabatan_p3->getField("PEGAWAI_JABATAN_P3_ID"));

echo json_encode($arrFinal);
?>