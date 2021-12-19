<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$lain_kondisi = new LainKondisi();

$reqId = httpFilterGet("reqId");
$reqRow = httpFilterGet("reqRow");
$reqKey = httpFilterGet("reqKey");

//$lain_kondisi->selectByParams(array(), -1, -1, " AND B.LAIN_KONDISI_PEGAWAI_ID IS NULL", $reqId);
$lain_kondisi->selectByParamsSimple(array(), -1, -1, " ");

$i = 0;
while($lain_kondisi->nextRow())
{
	$arrCompanyID[$i] =  $lain_kondisi->getField("LAIN_KONDISI_ID");
	$arrCompanyName[$i] =  $lain_kondisi->getField("NAMA");
	$i += 1;
}
	$arrFinal = array("LAIN_KONDISI_ID" => $arrCompanyID, 
					  "LAIN_KONDISI_NAMA" => $arrCompanyName);
	echo json_encode($arrFinal);
?>