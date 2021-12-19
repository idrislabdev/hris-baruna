<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");


/* create objects */

$kbbr_tipe_trans_d = new KbbrTipeTransD();

$reqId = httpFilterGet("reqId");

$j=0;

if($reqId == ""){}
else
$statement= "";//" AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%'";

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => "JKM-KPT-03", "KD_AKTIF" => "A"));
while($kbbr_tipe_trans_d->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arr_parent[$j]['text'] = $kbbr_tipe_trans_d->getField("KETK_TRANS");
	$j++;
}

echo json_encode($arr_parent);
?>