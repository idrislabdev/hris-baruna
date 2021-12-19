<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");


/* create objects */

$jabatan = new Jabatan();

$reqId = httpFilterGet("reqId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$j=0;
$jabatan->selectByParamsJabatanHasilRapat(array(), -1, -1, " AND KELAS IN (5,6,7) ", $reqId);
while($jabatan->nextRow())
{
	$arr_parent[$j]['id'] = $jabatan->getField("JABATAN_ID");
	$arr_parent[$j]['text'] = $jabatan->getField("NAMA");

	if($jabatan->getField("JABATAN_ID") == $jabatan->getField("JABATAN_ID_HASIL_RAPAT"))
		$arr_parent[$j]['checked'] = true;	
	
	
	unset($child);
	unset($arr_child);
	
	$j++;
}

echo json_encode($arr_parent);
?>