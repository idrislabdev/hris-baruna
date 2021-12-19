<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$set= new GajiPeriode();

$reqId = httpFilterPost("reqId");
$reqPeriode = httpFilterPost("reqPeriode");

if($reqPeriode == ""){}
else
{
	$set_detil= new GajiPeriode();
	$statement= " AND PERIODE = '".$reqPeriode."'";
	$set_detil->selectByParams(array(), -1,-1, $statement);
	$set_detil->firstRow();
	$tempPeriode= $set_detil->getField("PERIODE");
	unset($set_detil);
	
	if($tempPeriode == "")
	{
		$set->setField("GAJI_PERIODE_ID", $reqId);
		$set->setField("PERIODE", $reqPeriode);
		if($set->insert())
			echo "Data berhasil disimpan.";
	}
}
?>