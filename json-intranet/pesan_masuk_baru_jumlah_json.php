<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base/Pesan.php");

/* create objects */

$pesan = new Pesan();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$jumlah_pesan = $pesan->getCountByParams(array("USER_LOGIN_ID_PENERIMA" => $userLogin->UID, "STATUS" => 0));
$arr_json = array();
$i=0;

$arr_json[$i]['JUMLAH_PESAN'] = $jumlah_pesan;

echo json_encode($arr_json);
?>