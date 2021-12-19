<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");


/* create objects */

$lokasi = new Lokasi();

/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$i = 0;

$j=0;
$parent = new Lokasi();
$parent->selectByParams(array("LOKASI_PARENT_ID" => 0));
while($parent->nextRow())
{
	$arr_parent[$j]['id'] = $parent->getField("LOKASI_ID");
	$arr_parent[$j]['text'] = $parent->getField("KODE_GL_PUSAT")." ".$parent->getField("NAMA");
	$k = 0;
	$child = new Lokasi();
	$child->selectByParams(array("LOKASI_PARENT_ID" => $parent->getField("LOKASI_ID")));
	while($child->nextRow())
	{
		$arr_child[$k]['id'] = $child->getField("LOKASI_ID");
		$arr_child[$k]['text'] = $child->getField("NAMA");
		
		$l = 0;
		$sub = new Lokasi();
		$sub->selectByParams(array("LOKASI_PARENT_ID" => $child->getField("LOKASI_ID")));
		while($sub->nextRow())
		{
			$arr_sub[$l]['id'] = $sub->getField("LOKASI_ID");
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