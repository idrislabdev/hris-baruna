<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
include_once("../WEB-INF/classes/base-simpeg/CabangP3.php");


/* create objects */

$direktorat_p3 = new DirektoratP3();
$cabang_p3 = new CabangP3();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$cabang_p3->selectByParams(array());
$arr_json = array();
$i = 0;
while($cabang_p3->nextRow())
{
	$arr_json[$i]['id'] = "CAB".$cabang_p3->getField("CABANG_P3_ID");
	$arr_json[$i]['text'] = $cabang_p3->getField("NAMA");

	$j=0;
	$direktorat_p3->selectByParams(array("CABANG_P3_ID" => $cabang_p3->getField("CABANG_P3_ID"), "DIREKTORAT_P3_PARENT_ID" => 0));
	while($direktorat_p3->nextRow())
	{
		$arr_parent[$j]['id'] = $direktorat_p3->getField("DIREKTORAT_P3_ID");
		$arr_parent[$j]['text'] = $direktorat_p3->getField("NAMA");
		$k = 0;
		$child = new DirektoratP3();
		$child->selectByParams(array("DIREKTORAT_P3_PARENT_ID" => $direktorat_p3->getField("DIREKTORAT_P3_ID")));
		while($child->nextRow())
		{
			$arr_child[$k]['id'] = $child->getField("DIREKTORAT_P3_ID");
			$arr_child[$k]['text'] = $child->getField("NAMA");
			
			$l = 0;
			$sub = new DirektoratP3();
			$sub->selectByParams(array("DIREKTORAT_P3_PARENT_ID" => $child->getField("DIREKTORAT_P3_ID")));
			while($sub->nextRow())
			{
				$arr_sub[$l]['id'] = $sub->getField("DIREKTORAT_P3_ID");
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
	unset($direktorat_p3);	
	unset($arr_parent);
	$i++;
}

echo json_encode($arr_json);
?>