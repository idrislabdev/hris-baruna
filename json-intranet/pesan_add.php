<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Pesan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pesan = new Pesan();

$reqKepada = httpFilterPost("reqKepada");
$reqJudul = httpFilterPost("reqJudul");
$reqPesan = httpFilterPost("reqPesan");
$reqParentId = httpFilterPost("reqParentId");

if($reqParentId == "")
{
	$pesan->setField("NAMA", $reqJudul);
	$pesan->setField("USER_LOGIN_ID_PENGIRIM", $userLogin->UID);
	$pesan->setField("USER_LOGIN_ID_PENERIMA", $reqKepada);
	$pesan->setField("KETERANGAN", $reqPesan);
	
	if($pesan->insert())
		echo "Pesan telah terkirim.";
}
else
{
	$pesan->setField("NAMA", $reqJudul);
	$pesan->setField("USER_LOGIN_ID_PENGIRIM", $userLogin->UID);
	$pesan->setField("USER_LOGIN_ID_PENERIMA", $reqKepada);
	$pesan->setField("KETERANGAN", $reqPesan);
	$pesan->setField("PESAN_PARENT_ID", $reqParentId);
	
	if($pesan->insertParentId())
		echo "Pesan telah terkirim.";	
}
?>