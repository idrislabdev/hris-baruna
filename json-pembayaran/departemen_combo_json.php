<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");


/* create objects */

$kptt_nota_spp = new KpttNotaSpp();


$kptt_nota_spp->selectByParamsDepartemen(array());
$arr_json = array();
$i = 0;

$arr_json[$i]['id'] = "";
$arr_json[$i]['text'] = "Semua";
$i++;
	
while($kptt_nota_spp->nextRow())
{
	$arr_json[$i]['id']   = $kptt_nota_spp->getField("DEPARTEMEN_ID");
	$arr_json[$i]['text'] = $kptt_nota_spp->getField("NAMA");
	$i++;
}

echo json_encode($arr_json);
?>