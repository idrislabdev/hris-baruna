<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuanganSiuk/KbbrKartuTambah.php");


/* create objects */

$kbbr_kartu_tambah = new KbbrKartuTambah();

$reqId = httpFilterGet("reqId");

$j=0;

if($reqId == ""){}
else
$statement= '';//" AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%'";

$kbbr_kartu_tambah->selectByParams();
while($kbbr_kartu_tambah->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_kartu_tambah->getField("KD_SUB_BANTU");
	$arr_parent[$j]['text'] = $kbbr_kartu_tambah->getField("KD_SUB_BANTU")."-".$kbbr_kartu_tambah->getField("NM_SUB_BANTU");
	$j++;
}

echo json_encode($arr_parent);
?>