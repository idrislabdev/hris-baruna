<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/HasilRapat.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$hasil_rapat = new HasilRapat();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

	$hasil_rapat->setField("FIELD", "STATUS");
	$hasil_rapat->setField("FIELD_VALUE", $reqNilai);
	$hasil_rapat->setField("HASIL_RAPAT_ID", $reqId);
	$hasil_rapat->updateByField();
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>