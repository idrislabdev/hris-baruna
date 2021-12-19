<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/LainKondisi.php");


/* create objects */

$lain_kondisi = new LainKondisi();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
$lain_kondisi->selectByParams(array("LAIN_KONDISI_PARENT_ID" => 0));
while($lain_kondisi->nextRow())
{
	$arr_parent[$j]['id'] = $lain_kondisi->getField("LAIN_KONDISI_ID");
	$arr_parent[$j]['text'] = $lain_kondisi->getField("NAMA");
	$k = 0;
	$child = new LainKondisi();
	$child->selectByParams(array("LAIN_KONDISI_PARENT_ID" => $lain_kondisi->getField("LAIN_KONDISI_ID")));
	while($child->nextRow())
	{
		$arr_child[$k]['id'] = $child->getField("LAIN_KONDISI_ID");
		$arr_child[$k]['text'] = $child->getField("NAMA");
		
		$l = 0;
		$sub = new LainKondisi();
		$sub->selectByParams(array("LAIN_KONDISI_PARENT_ID" => $child->getField("LAIN_KONDISI_ID")));
		while($sub->nextRow())
		{
			$arr_sub[$l]['id'] = $sub->getField("LAIN_KONDISI_ID");
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