<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$user_login = new UserLoginBase();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqUserGroup = httpFilterPost("reqUserGroup");
$reqNama = httpFilterPost("reqNama");
$reqJabatan = httpFilterPost("reqJabatan");
$reqEmail = httpFilterPost("reqEmail");
$reqTelepon = httpFilterPost("reqTelepon");
$reqUserLogin = httpFilterPost("reqUserLogin");
$reqUserPassword = httpFilterPost("reqUserPassword");
$reqSubmit = httpFilterPost("reqSubmit");
$reqPegawaiId = httpFilterPost("reqPegawaiId");

if($reqDepartemen == 0)
	$reqDepartemen = "NULL";
else
	$reqDepartemen = "'".$reqDepartemen."'";

if($reqMode == "insert")
{
	if($reqPegawaiId == "")
	{
		echo "Data gagal disimpan. Silahkan pilih pegawai terlebih dahulu.|0";
	}
	else
	{
		$user_login->setField("DEPARTEMEN_ID", $reqDepartemen);
		$user_login->setField("USER_GROUP_ID", $reqUserGroup);
		$user_login->setField("NAMA", $reqNama);
		$user_login->setField("JABATAN", $reqJabatan);
		$user_login->setField("EMAIL", $reqEmail);
		$user_login->setField("TELEPON", $reqTelepon);
		$user_login->setField("USER_LOGIN", $reqUserLogin);
		$user_login->setField("USER_PASS", $reqUserPassword);
		$user_login->setField("STATUS", 1);
		$user_login->setField("LAST_CREATE_USER", $userLogin->UID);
		$user_login->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
		$user_login->setField("PEGAWAI_ID", $reqPegawaiId);	
	
		if($user_login->insert())
		{
			echo "Data berhasil disimpan|" . $user_login->getField('USER_LOGIN_ID'); 
			// define("AJXP_EXEC", true);
			// $glueCode = "../filemanager/plugins/auth.remote/glueCode.php";
			// $secret = "myprivatesecret";
		
			// // Initialize the "parameters holder"
			// global $AJXP_GLUE_GLOBALS;
			// $AJXP_GLUE_GLOBALS = array();
			// $AJXP_GLUE_GLOBALS["secret"] = $secret;
			// $AJXP_GLUE_GLOBALS["plugInAction"] = "addUser";
			// $AJXP_GLUE_GLOBALS["autoCreate"] = true;
		
			// // NOTE THE md5() call on the password field.
			// $AJXP_GLUE_GLOBALS["user"] = array("name" => $reqUserLogin, "password" => md5($reqUserPassword."valsix"));
			// // NOW call glueCode!
			// include($glueCode);
		}
	}
	//echo $user_login->query;
}
else if($reqMode == "updateIdWeb"){
	$user_login->setField("USER_LOGIN_ID", $reqId);
	$user_login->setField("USER_LOGIN_ID_WEBSITE", $reqIdWebsite);
	if($user_login->updateIdWeb()){
		echo "Data berhasil disimpan."; 
	}
}
else
{
	$user_login->setField("USER_LOGIN_ID", $reqId);
	$user_login->setField("DEPARTEMEN_ID", $reqDepartemen);
	$user_login->setField("USER_GROUP_ID", $reqUserGroup);
	$user_login->setField("NAMA", $reqNama);
	$user_login->setField("JABATAN", $reqJabatan);
	$user_login->setField("EMAIL", $reqEmail);
	$user_login->setField("TELEPON", $reqTelepon);
	$user_login->setField("LAST_UPDATE_USER", $userLogin->UID);
	$user_login->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	$user_login->setField("PEGAWAI_ID", $reqPegawaiId);	
	
	if($user_login->update())
		echo "Data berhasil disimpan|" . $reqId; 
	
}
?>