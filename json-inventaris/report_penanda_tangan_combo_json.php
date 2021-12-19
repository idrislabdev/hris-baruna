<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Pegawai.php");

/* create objects */
$pegawai = new Pegawai();



$reqId = httpFilterGet("reqId");
/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/

$pegawai->selectByParamsPegawaiJabatan();
$i=0;
while($pegawai->nextRow())
{
	$arr_json[$i]['id'] = $pegawai->getField("NAMA");
	$arr_json[$i]['text'] = $pegawai->getField("NAMA");
	$i++;
}


echo json_encode($arr_json);
?>