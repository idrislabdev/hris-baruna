<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");

/* create objects */

/* LOGIN CHECK */

$reqJumlah = httpFilterGet("reqJumlah");

$kbbr_key_tabel = new KbbrKeyTabel();
 
$total = $kbbr_key_tabel->getMaterai($reqJumlah);

//echo $total;
$arrFinal = array("MATERAI" => $total);
echo json_encode($arrFinal);
?>