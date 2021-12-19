<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqId = httpFilterGet("reqId");
$reqRow = httpFilterGet("reqRow");
$reqKey = httpFilterGet("reqKey");

$gaji_periode = new GajiPeriodeCapegPKWT();

$periode = $gaji_periode->getPeriodeAkhir();
$bulan = (int)substr($periode,0,2);
$tahun = substr($periode,2,4);

$arrBulanId[] = $periode;
$arrBulanNama[] =  getNamePeriode($periode);
for($i=1; $i<=5;$i++)
{
	$bulan += 1;
	
	if($bulan == 13)
	{
		$bulan = 1;
		$tahun += 1;	
	}
	$arrBulanId[] = generateZero($bulan,2).$tahun;
	$arrBulanNama[] =  getNamePeriode(generateZero($bulan,2).$tahun);
}

	$arrFinal = array("BULAN_ID" => $arrBulanId, 
					  "BULAN_NAMA" => $arrBulanNama);
	echo json_encode($arrFinal);
?>