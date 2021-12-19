<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrBukuBesar.php");

$reqNotId = httpFilterGet("reqNotId");
// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

$kbbr_buku_besar = new KbbrBukuBesar();

if($reqNotId == "")
{}
else
	$statement = " AND NOT KD_BUKU_BESAR LIKE '".$reqNotId."%' ";

$kbbr_buku_besar->selectByParamsSimple(array(), -1, -1, $statement."  AND (KD_BUKU_BESAR LIKE '".$search_term."%' OR UPPER(NM_BUKU_BESAR) LIKE UPPER('%".$search_term."%')) ", " ORDER BY A.KD_BUKU_BESAR ASC ");
$j=0;
while($kbbr_buku_besar->nextRow())
{
	$arr_parent[$j]['label'] = $kbbr_buku_besar->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['desc'] = $kbbr_buku_besar->getField("NM_BUKU_BESAR");
	$arr_parent[$j]['POLA_ENTRY_ID'] = $kbbr_buku_besar->getField("POLA_ENTRY_ID");
	$j++;
}

echo json_encode($arr_parent);
?>