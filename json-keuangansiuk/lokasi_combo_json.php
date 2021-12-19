<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();

// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

$lokasi->selectByParamsSimple(array(), -1, -1, " AND upper(NAMA) LIKE '%".strtoupper($search_term)."%' ");

$j=0;
while($lokasi->nextRow())
{
	$arr_parent[$j]['label'] = $lokasi->getField("LOKASI_ID")."-".$lokasi->getField("NAMA");
	$arr_parent[$j]['desc'] = $lokasi->getField("NAMA");
	
	$j++;
}

echo json_encode($arr_parent);
?>