<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrBukuPusat.php");

/* create objects */
$kbbr_buku_pusat = new KbbrBukuPusat();

// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

$statement= " AND (UPPER(A.KD_BUKU_BESAR) LIKE '".$search_term."%' OR UPPER(A.NM_BUKU_BESAR) LIKE UPPER('%".$search_term."%')) ";
$kbbr_buku_pusat->selectByParams(array(), -1, -1, $statement);

$j=0;

while($kbbr_buku_pusat->nextRow())
{
	$arr_parent[$j]['label'] = $kbbr_buku_pusat->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['desc'] = $kbbr_buku_pusat->getField("NM_BUKU_BESAR");
	$j++;
}

echo json_encode($arr_parent);
?>