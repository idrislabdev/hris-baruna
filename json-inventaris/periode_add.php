<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Periode.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$set= new Periode();

$reqId = httpFilterPost("reqId");
$reqPeriode = httpFilterPost("reqPeriode");

if($reqPeriode == ""){}
else
{
	$set_detil= new Periode();
	$statement= " AND PERIODE = '".$reqPeriode."'";
	$set_detil->selectByParams(array(), -1,-1, $statement);
	$set_detil->firstRow();
	$tempPeriode= $set_detil->getField("PERIODE");
	unset($set_detil);
	
	if($tempPeriode == "")
	{
		$set->setField("PERIODE_ID", $reqId);
		$set->setField("PERIODE", $reqPeriode);
		if($set->insert())
			echo "Data berhasil disimpan.";
	}
}
?>