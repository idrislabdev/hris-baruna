<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");


/* create objects */
ini_set("memory_limit","500M");
ini_set("max_execution_time", 520);
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
$pegawai = new Pegawai();
$reqDepartemenId = httpFilterGet("reqDepartemenId");

$j=0;

$pegawai->selectByParams(array(), -1, -1, "AND A.DEPARTEMEN_ID LIKE '". $reqDepartemenId ."%'  AND A.STATUS_PEGAWAI_ID = 1  "); // disini ditambahi where departemen_id oke

while($pegawai->nextRow())
{
	if ( $j == 0 ) {
		$arr_parent[$j]['id'] = 0;
		$arr_parent[$j]['text'] = '';
	}
	$j++;
	$arr_parent[$j]['id'] = $pegawai->getField("PEGAWAI_ID");
	$arr_parent[$j]['text'] = $pegawai->getField("NAMA");
	
}

echo json_encode($arr_parent);
?>