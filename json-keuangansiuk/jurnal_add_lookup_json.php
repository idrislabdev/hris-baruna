<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");

$jurnal = new KbbrGeneralRefD();

$reqIdRefData= httpFilterGet("reqIdRefData");
$reqIdRefDataTemp= httpFilterGet("reqIdRefDataTemp");

if($reqIdRefDataTemp == "")
{
	$jurnal->selectByParams(array('UPPER(ID_REF_DATA)'=>strtoupper($reqIdRefData)));
}
else
{
	$jurnal->selectByParams(array('UPPER(ID_REF_DATA)'=>strtoupper($reqIdRefData), "NOT UPPER(ID_REF_DATA)" => strtoupper($reqIdRefDataTemp)));
}

$jurnal->firstRow();

$arrFinal = array("JURNAL" => $jurnal->getField("ID_REF_DATA"));

echo json_encode($arrFinal);
?>