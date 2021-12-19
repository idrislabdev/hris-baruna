<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRef.php");

$referensi = new KbbrGeneralRef();

$reqNama= httpFilterGet("reqNama");
$reqNamaTemp= httpFilterGet("reqNamaTemp");

if($reqNamaTemp == "")
{
	$referensi->selectByParams(array('UPPER(ID_REF_FILE)'=>strtoupper($reqNama)));
}
else
{
	$referensi->selectByParams(array('UPPER(ID_REF_FILE)'=>strtoupper($reqNama), "NOT UPPER(ID_REF_FILE)" => strtoupper($reqNamaTemp)));
}

$referensi->firstRow();

$arrFinal = array("NAMA" => $referensi->getField("ID_REF_FILE"));

echo json_encode($arrFinal);
?>