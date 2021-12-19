<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/Absensi.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");


ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);
/* create objects */

$absensi = new Absensi();

$reqPeriode = httpFilterGet("reqPeriode");
$reqJenisProses = httpFilterGet("reqJenisProses");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$absensi->setField("USER_LOGIN_ID", $userLogin->UID);
$absensi->insertImport();
$absensi->deleteAbsensiImport();

$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>