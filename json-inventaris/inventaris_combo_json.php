<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");


$reqId= httpFilterGet("reqId");

/* create objects */
$inventaris = new Inventaris();

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

if($reqId == ""){}
else
	$statement= " AND A.JENIS_INVENTARIS_ID LIKE '".$reqId."%'";

$inventaris->selectByParams(array(),-1,-1,$statement);
// echo $inventaris->query;exit();
$arr_json = array();
$i = 0;

while($inventaris->nextRow())
{
	$arr_json[$i]['id'] = $inventaris->getField("INVENTARIS_ID");
	$arr_json[$i]['text'] = $inventaris->getField("INVENTARIS")." ".$inventaris->getField("SPESIFIKASI");
	$arr_json[$i]['spesifikasi'] = $inventaris->getField("SPESIFIKASI");
	$arr_json[$i]['jenis_inventaris_id'] = $inventaris->getField("JENIS_INVENTARIS_ID");
	
	$i++;
}

echo json_encode($arr_json);
?>