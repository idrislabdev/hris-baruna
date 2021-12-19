<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$pegawai_jenis_pegawai = new PegawaiJenisPegawai();

$reqId= httpFilterGet("reqId");
$reqTMT= httpFilterGet("reqTMT");
$reqTMTTemp= httpFilterGet("reqTMTTemp");

if($reqTMTTemp == "")
{
	$pegawai_jenis_pegawai->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JENIS_PEGAWAI, 'DD-MM-YYYY')"=>$reqTMT));
}
else
{
	$pegawai_jenis_pegawai->selectByParams(array("A.PEGAWAI_ID"=>$reqId,"TO_CHAR(A.TMT_JENIS_PEGAWAI, 'DD-MM-YYYY')"=>$reqTMT, "NOT TO_CHAR(A.TMT_JENIS_PEGAWAI, 'DD-MM-YYYY')" => $reqTMTTemp));
}

$pegawai_jenis_pegawai->firstRow();

$arrFinal = array("PEGAWAI_JENIS_PEGAWAI_ID" => $pegawai_jenis_pegawai->getField("PEGAWAI_JENIS_PEGAWAI_ID"));

echo json_encode($arrFinal);
?>