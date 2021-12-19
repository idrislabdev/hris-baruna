<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base/Pesan.php");

/* create objects */

$pesan = new Pesan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$pesan->selectByParamsMonitoring(array("USER_LOGIN_ID_PENERIMA" => $userLogin->UID), 5, 0);
$arr_json = array();
$i=0;
while($pesan->nextRow())
{
	$arr_json[$i]['NAMA'] = $pesan->getField("NAMA");
	$arr_json[$i]['USER_LOGIN'] = $pesan->getField("USER_LOGIN");
	$arr_json[$i]['TANGGAL'] = getFormattedDateTime($pesan->getField("TANGGAL"));
	$arr_json[$i]['DEPARTEMEN'] = $pesan->getField("DEPARTEMEN");
	$arr_json[$i]['PESAN_ID'] = $pesan->getField("PESAN_ID");	
	$arr_json[$i]['PESAN_PARENT_ID'] = $pesan->getField("PESAN_PARENT_ID");	
	$arr_json[$i]['STATUS'] = $pesan->getField("STATUS");	
	$arr_json[$i]['USER_LOGIN_ID_PENGIRIM'] = $pesan->getField("USER_LOGIN_ID_PENGIRIM");	
	$i++;
}
echo json_encode($arr_json);
?>