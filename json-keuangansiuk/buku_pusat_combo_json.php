<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrBukuPusat.php");


/* create objects */

$kbbr_buku_pusat = new KbbrBukuPusat();

$reqId = httpFilterGet("reqId");
$filterKode = httpFilterGet("filterKode");

$j=0;

if($filterKode != "" && $filterKode == 'anggaran')
	$statement= "AND (SUBSTR(A.KD_BUKU_BESAR, 1, 1) = 6)";

if($reqId == ""){}
else
$statement= " AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%'";

$kbbr_buku_pusat->selectByParams(array(), -1, -1, $statement);

while($kbbr_buku_pusat->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_buku_pusat->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['text'] = $kbbr_buku_pusat->getField("KD_BUKU_BESAR")."-".$kbbr_buku_pusat->getField("NM_BUKU_BESAR");
	$j++;
}

echo json_encode($arr_parent);
?>