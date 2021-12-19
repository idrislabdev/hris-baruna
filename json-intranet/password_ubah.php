<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$user_login = new UserLoginBase();

$reqPassword = httpFilterPost("reqPassword");
$reqPassword1 = httpFilterPost("reqPassword1");

$update_pass = false;

if($reqPassword == "")
	echo "Masukkan password.";	
elseif($reqPassword1 == "")
	echo "Masukkan konfirmasi password.";	
elseif($reqPassword == $reqPassword1)
	$update_pass = true;
else
	echo "Password dan Konfirmasi password tidak sama.";
	
if($update_pass == true)
{
	$user_login->setField("FIELD", "USER_PASS");
	$user_login->setField("FIELD_VALUE", md5($reqPassword));
	$user_login->setField("USER_LOGIN_ID", $userLogin->UID);
	
	if($user_login->updateByField())
	{
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
		$AJXP_GLUE_GLOBALS["user"] = array("name" => $userLogin->idUser, "password" => md5($reqPassword."valsix"));
		// NOW call glueCode!
		include($glueCode);
		
		echo "Password berhasil diubah.";
	}
}

?>