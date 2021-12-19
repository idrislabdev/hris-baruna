<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/UsersBase.php");

$users = new UsersBase();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPassword= httpFilterPost("reqPassword");

$users->setField("USER_LOGIN_ID", $reqId);
$users->setField("USER_PASS", $reqPassword);

if($users->updatePassword())
		echo "Data berhasil disimpan.";

?>