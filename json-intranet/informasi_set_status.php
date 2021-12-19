<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/Informasi.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$informasi = new Informasi();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

	$informasi->setField("FIELD", "STATUS");
	$informasi->setField("FIELD_VALUE", $reqNilai);
	$informasi->setField("INFORMASI_ID", $reqId);
	$informasi->updateByField();
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>