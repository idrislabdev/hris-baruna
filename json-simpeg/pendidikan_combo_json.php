<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");


/* create objects */

$pendidikan = new Pendidikan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$pendidikan->selectByParams(array());
$arr_json = array();
$i = 0;
	
while($pendidikan->nextRow())
{
	$arr_json[$i]['id'] = $pendidikan->getField("PENDIDIKAN_ID");
	$arr_json[$i]['text'] = $pendidikan->getField("NAMA");
	$i++;
}

echo json_encode($arr_json);
?>