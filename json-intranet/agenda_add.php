<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Agenda.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$agenda = new Agenda();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqDepartemen = httpFilterPost("reqDepartemen");
$reqTanggal = httpFilterPost("reqTanggal");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqSubmit = httpFilterPost("reqSubmit");

$reqDepartemen = "'".$reqDepartemen."'";

if($reqMode == "insert")
{
	$agenda->setField("DEPARTEMEN_ID", $reqDepartemen);
	$agenda->setField("NAMA", $reqNama);
	$agenda->setField("KETERANGAN", $reqKeterangan);
	$agenda->setField("TANGGAL", dateTimeToDBCheck($reqTanggal));
	$agenda->setField("USER_LOGIN_ID", $userLogin->UID);
	$agenda->setField("STATUS", 1);
	$agenda->setField("LAST_CREATE_USER", $userLogin->nama);
	$agenda->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($agenda->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$agenda->setField("AGENDA_ID", $reqId);
	$agenda->setField("DEPARTEMEN_ID", $reqDepartemen);
	$agenda->setField("NAMA", $reqNama);
	$agenda->setField("TANGGAL", dateTimeToDBCheck($reqTanggal));
	$agenda->setField("KETERANGAN", $reqKeterangan);
	$agenda->setField("USER_LOGIN_ID", $userLogin->UID);
	$agenda->setField("STATUS", 1);
	$agenda->setField("LAST_UPDATE_USER", $userLogin->nama);
	$agenda->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	
	if($agenda->update())
		echo "Data berhasil disimpan.";
	
}
?>