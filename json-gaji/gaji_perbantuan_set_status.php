<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");

/* create objects */
$gaji_awal_bulan = new GajiAwalBulan();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");
$reqPeriode = httpFilterGet("reqPeriode");

	$gaji_awal_bulan->setField("FIELD", "STATUS_BAYAR");
	$gaji_awal_bulan->setField("FIELD_VALUE", $reqNilai);
	$gaji_awal_bulan->setField("PEGAWAI_ID", $reqId);
	$gaji_awal_bulan->setField("BULANTAHUN", $reqPeriode);
	$gaji_awal_bulan->updateByField();

$met = array();
$i=0;

$met[0]['STATUS_BAYAR'] = 1;
echo json_encode($met);
?>