<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");


/* create objects */
$kbbr_tipe_trans= new KbbrTipeTrans();

$reqId = httpFilterGet("reqId");

$j=0;

if($reqId == ""){}
else
$statement= "";//" AND UPPER(A.KD_BUKU_BESAR) LIKE '%".strtoupper($reqId)."%'";

$kbbr_tipe_trans->selectByParams(array("A.KD_JURNAL"=>"JPJ", "A.KD_SUBSIS"=>"KPT", "AUTO_MANUAL"=>"M", "KD_AKTIF"=>"A"),-1,-1,"", "ORDER BY TIPE_TRANS ASC");
while($kbbr_tipe_trans->nextRow())
{
	$arr_parent[$j]['id'] = $kbbr_tipe_trans->getField("TIPE_TRANS");
	$arr_parent[$j]['text'] = $kbbr_tipe_trans->getField("AKRONIM_DESC");
	$j++;
}

echo json_encode($arr_parent);
?>