<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Pegawai.php");


$reqId= httpFilterGet("reqId");

/* create objects */
$pegawai = new Pegawai();

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$pegawai->selectByParams(array(), -1, -1, " AND A.STATUS_PEGAWAI_ID IN (1,5) ");
$arr_json = array();
$i = 0;

while($pegawai->nextRow())
{
	$arr_json[$i]['id'] = $pegawai->getField("PEGAWAI_ID");
	$arr_json[$i]['text'] = $pegawai->getField("NAMA")." (NRP : ".$pegawai->getField("NRP").")";
	
	
	$i++;
}

echo json_encode($arr_json);
?>