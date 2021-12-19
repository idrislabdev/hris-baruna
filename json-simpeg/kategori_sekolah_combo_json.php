<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/KategoriseKolah.php");


/* create objects */

$kategori_sekolah = new KategoriseKolah();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$kategori_sekolah->selectByParams(array());
$arr_json = array();
$i = 0;
	
while($kategori_sekolah->nextRow())
{
	$arr_json[$i]['id'] = $kategori_sekolah->getField("KATEGORI_SEKOLAH");
	$arr_json[$i]['text'] = $kategori_sekolah->getField("NAMA");
	$i++;
}

echo json_encode($arr_json);
?>