<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$set= new GajiPeriodeCapegPKWT();

$reqId = httpFilterPost("reqId");
$reqPeriode = httpFilterPost("reqPeriode");

if($reqPeriode == ""){}
else
{
	$set_detil= new GajiPeriodeCapegPKWT();
	$statement= " AND PERIODE = '".$reqPeriode."'";
	$set_detil->selectByParams(array(), -1,-1, $statement);
	$set_detil->firstRow();
	$tempPeriode= $set_detil->getField("PERIODE");
	unset($set_detil);
	
	if($tempPeriode == "")
	{
		$set->setField("GAJI_PERIODE_CAPEG_PKWT_ID", $reqId);
		$set->setField("PERIODE", $reqPeriode);
		if($set->insert())
			echo "Data berhasil disimpan.";
	}
}
?>