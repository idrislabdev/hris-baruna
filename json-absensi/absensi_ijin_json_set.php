<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$absensi_ijin = new AbsensiIjin();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK 
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
*/

	$absensi_ijin->setField("FIELD", "VALIDASI");
	$absensi_ijin->setField("FIELD_VALUE", $reqNilai);
	$absensi_ijin->setField("FIELD_VALIDATOR", "VALIDATOR");
	$absensi_ijin->setField("FIELD_VALUE_VALIDATOR", $userLogin->nama);
	$absensi_ijin->setField("ABSENSI_IJIN_ID", $reqId);
	$absensi_ijin->updateByField();
	
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>