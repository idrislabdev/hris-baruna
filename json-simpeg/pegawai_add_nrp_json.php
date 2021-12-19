<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$pegawai = new Pegawai();

$reqNRP= httpFilterGet("reqNRP");
$reqNRPTemp= httpFilterGet("reqNRPTemp");

if($reqNRPTemp == "")
{
	$pegawai->selectByParams(array('A.NRP'=>$reqNRP));
}
else
{
	$pegawai->selectByParams(array('A.NRP'=>$reqNRP, "NOT A.NRP" => $reqNRPTemp));
}

$pegawai->firstRow();

$arrFinal = array("NRP" => $pegawai->getField("NRP"));

echo json_encode($arrFinal);
?>