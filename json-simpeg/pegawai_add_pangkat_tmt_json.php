<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPangkat.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$pegawai_pangkat = new PegawaiPangkat();

$reqId= httpFilterGet("reqId");
$reqTMT= httpFilterGet("reqTMT");
$reqTMTTemp= httpFilterGet("reqTMTTemp");

if($reqTMTTemp == "")
{
	$pegawai_pangkat->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PANGKAT, 'DD-MM-YYYY')"=>$reqTMT));
}
else
{
	$pegawai_pangkat->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PANGKAT, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_PANGKAT, 'DD-MM-YYYY')" => $reqTMTTemp));
}

$pegawai_pangkat->firstRow();

$arrFinal = array("PEGAWAI_PANGKAT_ID" => $pegawai_pangkat->getField("PEGAWAI_PANGKAT_ID"));

echo json_encode($arrFinal);
?>