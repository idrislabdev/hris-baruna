<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGroupRek.php");

$rekening_group = new KbbrGroupRek();

$reqKode= httpFilterGet("reqKode");
$reqKodeTemp= httpFilterGet("reqKodeTemp");

if($reqKodeTemp == "")
{
	$rekening_group->selectByParams(array('UPPER(ID_GROUP)'=>strtoupper($reqKode)));
}
else
{
	$rekening_group->selectByParams(array('UPPER(ID_GROUP)'=>strtoupper($reqKode), "NOT UPPER(ID_GROUP)" => strtoupper($reqKodeTemp)));
}

$rekening_group->firstRow();

$arrFinal = array("IDGROUP" => $rekening_group->getField("ID_GROUP"));

echo json_encode($arrFinal);
?>