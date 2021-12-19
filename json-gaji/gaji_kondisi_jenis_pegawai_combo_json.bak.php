<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiKondisi.php");


/* create objects */

$gaji_kondisi = new GajiKondisi();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
$gaji_kondisi->selectByParams(array("GAJI_KONDISI_PARENT_ID" => 0));
while($gaji_kondisi->nextRow())
{
	$arr_parent[$j]['id'] = $gaji_kondisi->getField("GAJI_KONDISI_ID");
	$arr_parent[$j]['text'] = $gaji_kondisi->getField("NAMA");
	if($reqId == $gaji_kondisi->getField("GAJI_KONDISI_ID"))
		$arr_parent[$j]['checked'] = true;
	$k = 0;
	$child = new GajiKondisi();
	$child->selectByParams(array("GAJI_KONDISI_PARENT_ID" => $gaji_kondisi->getField("GAJI_KONDISI_ID")));
	while($child->nextRow())
	{
		$arr_child[$k]['id'] = $child->getField("GAJI_KONDISI_ID");
		$arr_child[$k]['text'] = $child->getField("NAMA");
		if($reqId == $child->getField("GAJI_KONDISI_ID"))
			$arr_child[$k]['checked'] = true;
		
		$l = 0;
		$sub = new GajiKondisi();
		$sub->selectByParams(array("GAJI_KONDISI_PARENT_ID" => $child->getField("GAJI_KONDISI_ID")));
		while($sub->nextRow())
		{
			$arr_sub[$l]['id'] = $sub->getField("GAJI_KONDISI_ID");
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