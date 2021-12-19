<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/Absensi.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$absensi = new Absensi();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK 
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
*/

	$absensi->setField("FIELD", "VALIDASI");
	$absensi->setField("FIELD_VALUE", $reqNilai);
	$absensi->setField("FIELD_VALIDATOR", "VALIDATOR");
	$absensi->setField("FIELD_VALUE_VALIDATOR", $userLogin->nama);
	$absensi->setField("ABSENSI_ID", $reqId);
	$absensi->updateByField();
	
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>