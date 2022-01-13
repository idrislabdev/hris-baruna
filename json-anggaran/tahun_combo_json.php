<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

/* create objects */

$reqAwal= httpFilterGet("reqAwal");
$reqAkhir= httpFilterGet("reqAkhir");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

function setTahunLoop($awal, $akhir)
{
	$index_tahun=0;
	for($i=date("Y")+$awal; $i >= date("Y")-$akhir; $i--)
	{
		$arrTahun[$index_tahun]= $i;
		$index_tahun++;
	}
	return $arrTahun;
}

$arrTahun= setTahunLoop($reqAwal, $reqAkhir);
$arr_json = array();

for($i=0; $i< count($arrTahun); $i++)
{
	$arr_json[$i]['id'] = "id".$arrTahun[$i];
	$arr_json[$i]['text'] = $arrTahun[$i].'-'.$arrTahun[$i]+1;
}

echo json_encode($arr_json);
?>