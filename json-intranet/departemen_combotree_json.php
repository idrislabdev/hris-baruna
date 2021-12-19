<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");


/* create objects */

$departemen = new Departemen();

$reqId = httpFilterGet("reqId");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqDepartemenId = httpFilterGet("reqDepartemenId");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
while($j < 1)
{
	$arr_parent[$j]['id'] = "CAB1";
	$arr_parent[$j]['text'] = "Kantor Pusat PT. PMS";
	if($reqDepartemenId == "CAB1")
		$arr_parent[$j]['checked'] = true;
	$k = 0;
	
	$k = 0;
	$child = new Departemen();
	$child->selectByParamsDepartemenHasilRapat(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => 0), -1, -1, "", $reqId);
	while($child->nextRow())
	{
		$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID");
		$arr_child[$k]['text'] = $child->getField("NAMA");
		if($child->getField("DEPARTEMEN_ID") == $child->getField("DEPARTEMEN_ID_HASIL_RAPAT"))
			$arr_child[$k]['checked'] = true;
		
		$k++;
	}
	$arr_parent[$j]['children'] = $arr_child;
	
	unset($child);
	unset($arr_child);
	
	$j++;
}

echo json_encode($arr_parent);
?>