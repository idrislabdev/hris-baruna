<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");
/* create objects */

$departemen = new Departemen();
$cabang = new Cabang();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

if($reqId == "")
	$statement .= " AND DEPARTEMEN_PARENT_ID = 0 ";
else
	$statement .= " AND DEPARTEMEN_ID = '".$reqId."' ";

$cabang->selectByParams(array());
$arr_json = array();
$i = 0;
while($cabang->nextRow())
{
	$arr_json[$i]['id'] = "";
	$arr_json[$i]['text'] = $cabang->getField("NAMA");

	$j=0;
	$departemen = new Departemen();
	$departemen->selectByParams(array("STATUS_AKTIF" => 1, "CABANG_ID" => $cabang->getField("CABANG_ID")), -1, -1, $statement);
	while($departemen->nextRow())
	{
		$arr_parent[$j]['id'] = $departemen->getField("PUSPEL");
		$arr_parent[$j]['text'] = $departemen->getField("NAMA")." - ".$departemen->getField("PUSPEL");
		$k = 0;
		$child = new Departemen();
		$child->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $departemen->getField("DEPARTEMEN_ID")));
		while($child->nextRow())
		{
			$arr_child[$k]['id'] = $child->getField("PUSPEL");
			$arr_child[$k]['text'] = $child->getField("NAMA")." - ".$child->getField("PUSPEL");
			
			$l = 0;
			$sub = new Departemen();
			$sub->selectByParams(array("STATUS_AKTIF" => 1, "DEPARTEMEN_PARENT_ID" => $child->getField("DEPARTEMEN_ID")));
			while($sub->nextRow())
			{
				$arr_sub[$l]['id'] = $sub->getField("PUSPEL");
				$arr_sub[$l]['text'] = $sub->getField("NAMA")." - ".$sub->getField("PUSPEL");;	
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
	if($reqId == "")
		unset($arr_parent);
	
	$i++;
}
if($reqId == "")
	echo json_encode($arr_json);
else
	echo json_encode($arr_parent);
?>