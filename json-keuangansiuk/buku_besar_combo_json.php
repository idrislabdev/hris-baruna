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

$j=0;

if($reqId == ""){}
else
$statement= " AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%' ";

$kbbr_buku_besar->selectByParams(array(), -1, -1, "  ", " ORDER BY A.KD_BUKU_BESAR ASC ");
while($kbbr_buku_besar->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_buku_besar->getField("KD_BUKU_BESAR");
	$arr_parent[$j]['text'] = $kbbr_buku_besar->getField("KD_BUKU_BESAR")."-".$kbbr_buku_besar->getField("NM_BUKU_BESAR");
	$arr_parent[$j]['POLA_ENTRY_ID'] = $kbbr_buku_besar->getField("POLA_ENTRY_ID");	
	$j++;
}

echo json_encode($arr_parent);
?>