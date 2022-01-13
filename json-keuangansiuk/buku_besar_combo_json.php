<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrBukuBesar.php");


/* create objects */

$kbbr_buku_besar = new KbbrBukuBesar();

$reqId = httpFilterGet("reqId");
$filterKode = httpFilterGet("filterKode");


$j=0;

if($filterKode != "" && $filterKode == 'anggaran')
	$statement= "AND (SUBSTR(KD_BUKU_BESAR, 1, 1) = 5 OR SUBSTR(KD_BUKU_BESAR, 1, 1) = 4)";

// if($reqId == ""){}
// else
// $statement= " AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%' ";
// $kbbr_buku_pusat->selectByParams(array(), -1, -1, $statement);

$kbbr_buku_besar->selectByParams(array(), -1, -1, "  ", "$statement ORDER BY A.KD_BUKU_BESAR ASC ");
// echo $kbbr_buku_besar->query;
while($kbbr_buku_besar->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_buku_besar->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['text'] = $kbbr_buku_besar->getField("KD_BUKU_BESAR")."-".$kbbr_buku_besar->getField("NM_BUKU_BESAR");
	$arr_parent[$j]['POLA_ENTRY_ID'] = $kbbr_buku_besar->getField("POLA_ENTRY_ID");	
	$j++;
}

echo json_encode($arr_parent);
?>