<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");


/* create objects */

$reqDepartemen = httpFilterGet("reqDepartemen");

$departemen_awal = new Departemen();
$cabang = new Cabang();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$departemen_awal->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_ID" => substr($reqDepartemen, 0, 2)));
$arr_json = array();
$i = 0;
while($departemen_awal->nextRow())
{
	$arr_json[$i]['id'] = $departemen_awal->getField("DEPARTEMEN_ID");
	$arr_json[$i]['text'] = $departemen_awal->getField("NAMA");

	$j=0;
	$departemen = new Departemen();
	$departemen->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen_awal->getField("DEPARTEMEN_ID")));
	while($departemen->nextRow())
	{
		$arr_parent[$j]['id'] = $departemen->getField("DEPARTEMEN_ID");
		$arr_parent[$j]['text'] = $departemen->getField("NAMA");
		$k = 0;
		$child = new Departemen();
		$child->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen->getField("DEPARTEMEN_ID")));
		while($child->nextRow())
		{
			$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID");
			$arr_child[$k]['text'] = $child->getField("NAMA");
			
			$l = 0;
			$sub = new Departemen();
			$sub->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $child->getField("DEPARTEMEN_ID")));
			while($sub->nextRow())
			{
				$arr_sub[$l]['id'] = $sub->getField("DEPARTEMEN_ID");
				$arr_sub[$l]['text'] = $sub->getField("NAMA");	
				$l++;
			}
			
			$arr_child[$k]['children'] = $arr_sub;
			unset($sub);
			unset($arr_sub);
			$k++;
		}
		$arr_parent[$j]['children'] = $arr_child;
		
		unset($child);
		unset($arr_child);
		
		$j++;
	}
	
	$arr_json[$i]['children'] = $arr_parent;
	unset($departemen);	
	unset($arr_parent);
	$i++;
}

echo json_encode($arr_json);
?>