<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

/* create objects */

$user_login_base = new UserLoginBase();

$reqId = httpFilterGet("reqId");
$reqNilai = httpFilterGet("reqNilai");

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

	$user_login_base->setField("FIELD", "STATUS");
	$user_login_base->setField("FIELD_VALUE", $reqNilai);
	$user_login_base->setField("USER_LOGIN_ID", $reqId);
	$user_login_base->updateByField();
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>