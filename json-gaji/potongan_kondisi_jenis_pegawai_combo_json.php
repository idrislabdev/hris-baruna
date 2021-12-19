<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Kondisi.php");


/* create objects */

$kondisi = new Kondisi();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0), -1, -1, " AND PERUNTUKAN LIKE '%P%' ");
while($kondisi->nextRow())
{
	$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
	$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
	$k = 0;
	$child = new Kondisi();
	$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%P%' ");
	while($child->nextRow())
	{
		$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
		$arr_child[$k]['text'] = $child->getField("NAMA");
		
		$l = 0;
		$sub = new Kondisi();
		$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")), -1, -1, " AND PERUNTUKAN LIKE '%P%' ");
		while($sub->nextRow())
		{
			$arr_sub[$l]['id'] = $sub->getField("KONDISI_ID");
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

echo json_encode($arr_parent);
?>