<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$pegawai_jabatan = new PegawaiJabatan();

$reqId= httpFilterGet("reqId");
$reqTMT= httpFilterGet("reqTMT");
$reqTMTTemp= httpFilterGet("reqTMTTemp");

if($reqTMTTemp == "")
{
	$pegawai_jabatan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT));
}
else
{
	$pegawai_jabatan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_JABATAN, 'DD-MM-YYYY')" => $reqTMTTemp));
}

$pegawai_jabatan->firstRow();

$arrFinal = array("PEGAWAI_JABATAN_ID" => $pegawai_jabatan->getField("PEGAWAI_JABATAN_ID"));

echo json_encode($arrFinal);
?>