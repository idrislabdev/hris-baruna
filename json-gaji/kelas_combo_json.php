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
$reqKelasId = httpFilterGet("reqKelasId");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

function checkVariabel($text, $search)
{
	if($text == "")
		return false;
	$arrText = explode(",",$text);
	for($i=0;$i<count($arrText);$i++)
	{
		if($arrText[$i] == $search)
			return true;	
	}
	return false;
}

$j=0;
$jabatan->selectByParamsKelas();
while($jabatan->nextRow())
{
	$arr_parent[$j]['id'] = $jabatan->getField("KELAS");
	$arr_parent[$j]['text'] = $jabatan->getField("KELAS");
	if(checkVariabel($reqKelasId,$jabatan->getField("KELAS")))
		$arr_parent[$j]['checked'] = true;
	$j++;
}

echo json_encode($arr_parent);
?>