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

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

define("AJXP_EXEC", true);
$glueCode = "../filemanager/plugins/auth.remote/glueCode.php";
$secret = "myprivatesecret";

// Initialize the "parameters holder"
global $AJXP_GLUE_GLOBALS;
$AJXP_GLUE_GLOBALS = array();
$AJXP_GLUE_GLOBALS["secret"] = $secret;
$AJXP_GLUE_GLOBALS["plugInAction"] = "updateUser";
$AJXP_GLUE_GLOBALS["autoCreate"] = false;

// NOTE THE md5() call on the password field.
$AJXP_GLUE_GLOBALS["user"] = array("name" => $userLogin->idUser, "password" => md5($userLogin->idUser."valsix"));
// NOW call glueCode!
include($glueCode);

$user_login_base->setField("FIELD", "USER_PASS");
$user_login_base->setField("FIELD_VALUE", "MD5(USER_LOGIN)");
$user_login_base->setField("USER_LOGIN_ID", $reqId);
$user_login_base->updateByFieldTanpaPetik();
$met = array();
$i=0;

$met[0]['STATUS'] = 1;
echo json_encode($met);
?>