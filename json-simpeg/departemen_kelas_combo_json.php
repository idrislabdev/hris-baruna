<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/DepartemenKelas.php");


/* create objects */
$reqDepartemen = httpFilterGet("reqDepartemen");
// echo $reqDepartemen;exit();

$departemen_kelas = new DepartemenKelas();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$departemen_kelas->selectByParams(array("DEPARTEMEN_ID" => $reqDepartemen));
// echo $departemen_kelas->query;exit();
$arr_json = array();
$i = 0;
	
while($departemen_kelas->nextRow())
{
	$arr_json[$i]['id'] = $departemen_kelas->getField("DEPARTEMEN_KELAS_ID");
	$arr_json[$i]['text'] = $departemen_kelas->getField("NAMA");
	$i++;
}

echo json_encode($arr_json);
?>