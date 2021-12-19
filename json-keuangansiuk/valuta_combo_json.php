<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");


/* create objects */

$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");

if($reqId == ""){}
else
$statement= " AND UPPER(KODE_VALUTA) LIKE '%".strtoupper($reqId)."%'";

$j=0;
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
while($safr_valuta->nextRow())
{
	$arr_parent[$j]['id'] = $safr_valuta->getField("KODE_VALUTA");
	$arr_parent[$j]['text'] = $safr_valuta->getField("KODE_VALUTA");
	$j++;
}

echo json_encode($arr_parent);
?>