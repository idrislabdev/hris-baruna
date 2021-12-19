<?
/* INCLUDE FILE */
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-gaji/GajiPokok.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqPangkat= httpFilterGet("reqPangkat");
$reqMasaKerja= httpFilterGet("reqMasaKerja");

$gaji_pokok = new GajiPokok();
$jumlah = $gaji_pokok->getGajiPokok($reqPangkat, $reqMasaKerja);
$arrFinal = array("JUMLAH" => $jumlah);
echo json_encode($arrFinal);
?>