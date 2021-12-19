<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/KataMutiara.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$kata_mutiara = new KataMutiara();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

	$kata_mutiara->setField("FIELD", "STATUS");
	$kata_mutiara->setField("FIELD_VALUE", $reqNilai);
	$kata_mutiara->setField("KATA_MUTIARA_ID", $reqId);
	$kata_mutiara->updateByField();
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>