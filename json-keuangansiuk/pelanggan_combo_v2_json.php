<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");


/* create objects */
$safm_pelanggan = new SafmPelanggan();

// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

$statement = " AND UPPER(MPLG_NAMA) LIKE '%".strtoupper($search_term)."%' ";

$j=0;
$safm_pelanggan->selectByParams(array(), -1, -1, $statement);
while($safm_pelanggan->nextRow())
{
	$arr_parent[$j]['label'] = $safm_pelanggan->getField("MPLG_NAMA");
	$arr_parent[$j]['desc'] = $safm_pelanggan->getField("MPLG_KODE");
	$arr_parent[$j]['MPLG_KODE'] = $safm_pelanggan->getField("MPLG_KODE");	
	$arr_parent[$j]['MPLG_ALAMAT'] = $safm_pelanggan->getField("MPLG_ALAMAT");	
	$arr_parent[$j]['MPLG_BADAN_USAHA'] = $safm_pelanggan->getField("MPLG_BADAN_USAHA");	
	$arr_parent[$j]['MPLG_NPWP'] = $safm_pelanggan->getField("MPLG_NPWP");	
	$j++;
}

echo json_encode($arr_parent);
?>