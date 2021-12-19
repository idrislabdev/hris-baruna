<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();

// get the search term
$reqJenis = httpFilterGet("reqJenis");
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

$lokasi->selectByParamsAsset(array(), -1, -1, " AND upper(A.NAMA) LIKE '%".strtoupper($search_term)."%' ");

$j=0;
while($lokasi->nextRow())
{
	$arr_parent[$j]['label'] = $lokasi->getField("INVENTARIS_ID")."-".$lokasi->getField("NAMA");
	$arr_parent[$j]['desc'] = $lokasi->getField("NAMA");
	
	$j++;
}

echo json_encode($arr_parent);
?>