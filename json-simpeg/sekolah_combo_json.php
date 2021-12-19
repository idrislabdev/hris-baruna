<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/DepartemenKelas.php");
include_once("../WEB-INF/classes/base-simpeg/Cabang.php");


/* create objects */

$departemen = new Departemen();
$departemen_kelas = new DepartemenKelas();
$cabang = new Cabang();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$cabang->selectByParams(array(), -1, -1, " AND CABANG_ID > 1 ");
$arr_json = array();
$i = 0;

	
while($cabang->nextRow())
{
	$arr_json[$i]['id'] = "CAB".$cabang->getField("CABANG_ID");
	$arr_json[$i]['text'] = $cabang->getField("NAMA");
	$arr_json[$i]['departemen_id'] = "CAB".$cabang->getField("CABANG_ID");
	$arr_json[$i]['kelas_id'] = "";
	$arr_json[$i]['state'] = "closed";

	$j=0;
	$departemen = new Departemen();
	$departemen->selectByParams(array("STATUS_AKTIF" => 1, "CABANG_ID" => $cabang->getField("CABANG_ID"), "DEPARTEMEN_PARENT_ID" => 0));
	while($departemen->nextRow())
	{
		$arr_parent[$j]['id'] = $departemen->getField("DEPARTEMEN_ID");
		$arr_parent[$j]['departemen_id'] = $departemen->getField("DEPARTEMEN_ID");
		$arr_parent[$j]['kelas_id'] = "";
		$arr_parent[$j]['text'] = $departemen->getField("NAMA");
		$k = 0;
		$child = new DepartemenKelas();
		$child->selectByParams(array("DEPARTEMEN_ID" => $departemen->getField("DEPARTEMEN_ID")));
		while($child->nextRow())
		{
			$arr_child[$k]['id'] = $child->getField("DEPARTEMEN_ID")."-".$child->getField("DEPARTEMEN_KELAS_ID");
			$arr_child[$k]['departemen_id'] = $child->getField("DEPARTEMEN_ID");
			$arr_child[$k]['kelas_id'] = $child->getField("DEPARTEMEN_KELAS_ID");
			$arr_child[$k]['text'] = $child->getField("NAMA");	
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