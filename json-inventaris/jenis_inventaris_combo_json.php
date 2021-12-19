<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/JenisInventaris.php");


/* create objects */
$jenis_inventaris = new JenisInventaris();

$reqChild = httpFilterGet("reqChild");

$jenis_inventaris->selectByParams(array("JENIS_INVENTARIS_PARENT_ID" => 0), -1,-1, "", "ORDER BY KODE");
//echo $jenis_inventaris->query;
$arr_json = array();
$i = 0;

function getChild($id)
{
	$jenis_inventaris= new JenisInventaris();
	$jenis_inventaris->selectByParams(array('JENIS_INVENTARIS_PARENT_ID' => $id), -1, -1, "", "ORDER BY KODE");
	
	$arr_json = array();
	$j=0;
	while($jenis_inventaris->nextRow())
	{
		$arr_json[$j]['id'] = $jenis_inventaris->getField("JENIS_INVENTARIS_ID");
		$arr_json[$j]['text'] = $jenis_inventaris->getField("NAMA_KODE");
		
		$set= new JenisInventaris();
		$record= $set->getCountByParams(array('JENIS_INVENTARIS_PARENT_ID' => $jenis_inventaris->getField("JENIS_INVENTARIS_ID")));
		unset($set);
		
		if($record > 0)
			$arr_json[$j]['children'] = getChild($jenis_inventaris->getField("JENIS_INVENTARIS_ID"));
			
		$j++;
	}
	return $arr_json;
}

while($jenis_inventaris->nextRow())
{
	$arr_json[$i]['id'] = $jenis_inventaris->getField("JENIS_INVENTARIS_ID");
	$arr_json[$i]['text'] = $jenis_inventaris->getField("NAMA_KODE");
	
	if($reqChild == "")
	{
		$arr_json[$i]['children'] = getChild($jenis_inventaris->getField("JENIS_INVENTARIS_ID"));
	}
	
	$i++;
}

echo json_encode($arr_json);
?>