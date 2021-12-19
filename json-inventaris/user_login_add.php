<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/UsersBase.php");

$users = new UsersBase();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqUsername= httpFilterPost("reqUsername");
$reqPassword= httpFilterPost("reqPassword");
$reqNama = httpFilterPost("reqNama");
$reqAlamat= httpFilterPost("reqAlamat");
$reqTelp= httpFilterPost("reqTelp");
$reqEmail= httpFilterPost("reqEmail");
$reqUserGroup= httpFilterPost("reqUserGroup");

$users->setField("USER_LOGIN_ID", $reqId);
$users->setField("USER_NAME", $reqUsername);
$users->setField("NAMA", $reqNama);
$users->setField("ALAMAT", $reqAlamat);
$users->setField("EMAIL", $reqEmail);
$users->setField("TELP", $reqTelp);
$users->setField("USER_PASS", $reqPassword);
$users->setField("STATUS_USER", '1');
$users->setField("USER_GROUP_ID", $reqUserGroup);

if($reqMode == "insert")
{
	if($users->insert())
		echo "Data berhasil disimpan.";
}
else
{	
	if($users->update())
		echo "Data berhasil disimpan.";
}
?>