<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiPenghasilan.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$pegawai_penghasilan = new PegawaiPenghasilan();

$reqId= httpFilterGet("reqId");
$reqTMT= httpFilterGet("reqTMT");
$reqTMTTemp= httpFilterGet("reqTMTTemp");

if($reqTMTTemp == "")
{
	$pegawai_penghasilan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PENGHASILAN, 'DD-MM-YYYY')"=>$reqTMT));
}
else
{
	$pegawai_penghasilan->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_PENGHASILAN, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_PENGHASILAN, 'DD-MM-YYYY')" => $reqTMTTemp));
}

$pegawai_penghasilan->firstRow();

$arrFinal = array("PEGAWAI_PENGHASILAN_ID" => $pegawai_penghasilan->getField("PEGAWAI_PENGHASILAN_ID"));

echo json_encode($arrFinal);
?>