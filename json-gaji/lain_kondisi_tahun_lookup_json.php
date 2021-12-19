<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqId = httpFilterGet("reqId");
$reqRow = httpFilterGet("reqRow");
$reqKey = httpFilterGet("reqKey");

$tahun_for = date("Y");
$j=0;
for($i=$tahun_for; $i<=$tahun_for + 1; $i++)
{
	$arrCompanyID[$j]=$arrCompanyName[$j]=$i;
	$j++;
}

	$arrFinal = array("TAHUN_ID" => $arrCompanyID, 
					  "TAHUN_NAMA" => $arrCompanyName);
	echo json_encode($arrFinal);
?>