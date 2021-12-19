<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/KataMutiara.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kata_mutiara = new KataMutiara();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$kata_mutiara->setField("NAMA", $reqNama);
	$kata_mutiara->setField("KETERANGAN", $reqKeterangan);
	$kata_mutiara->setField("STATUS", 1);
	$kata_mutiara->setField("USER_LOGIN_ID", $userLogin->UID);
	
	if($kata_mutiara->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$kata_mutiara->setField("KATA_MUTIARA_ID", $reqId);
	$kata_mutiara->setField("NAMA", $reqNama);
	$kata_mutiara->setField("KETERANGAN", $reqKeterangan);
	$kata_mutiara->setField("USER_LOGIN_ID", $userLogin->UID);
	
	if($kata_mutiara->update())
		echo "Data berhasil disimpan.";
	
}
?>