<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrKartuTambah.php");

$kbbr_kartu_tambah = new KbbrKartuTambah();

// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

$kbbr_kartu_tambah->selectByParams(array(), -1, -1, " AND (KD_SUB_BANTU LIKE '".$search_term."%' OR UPPER(NM_SUB_BANTU) LIKE UPPER('%".$search_term."%')) ");

$j=0;
while($kbbr_kartu_tambah->nextRow())
{
	$arr_parent[$j]['label'] = $kbbr_kartu_tambah->getField("KD_SUB_BANTU");
	$arr_parent[$j]['desc'] = $kbbr_kartu_tambah->getField("NM_SUB_BANTU");
	
	$j++;
}

echo json_encode($arr_parent);
?>