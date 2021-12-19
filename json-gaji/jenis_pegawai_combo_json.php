<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/JenisPegawai.php");


/* create objects */

$jenis_pegawai = new JenisPegawai();

$reqId = httpFilterGet("reqId");
$reqJenisId = httpFilterGet("reqJenisId");

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
$jenis_pegawai->selectByParams(array(), -1,-1," AND JENIS_PEGAWAI_ID IN (1,2,3,5) ");
while($jenis_pegawai->nextRow())
{
	$arr_parent[$j]['id'] = $jenis_pegawai->getField("JENIS_PEGAWAI_ID");
	$arr_parent[$j]['text'] = $jenis_pegawai->getField("NAMA");
	if(checkVariabel($reqJenisId,$jenis_pegawai->getField("JENIS_PEGAWAI_ID")))
		$arr_parent[$j]['checked'] = true;
	$j++;
}

echo json_encode($arr_parent);
?>