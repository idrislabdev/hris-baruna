<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pendidikan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pendidikan = new Pendidikan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$pendidikan->setField('NAMA', $reqNama);
	$pendidikan->setField('KETERANGAN', $reqKeterangan);
	$pendidikan->setField("LAST_CREATE_USER", $userLogin->nama);
	$pendidikan->setField("LAST_CREATE_DATE", OCI_SYSDATE);			
	if($pendidikan->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$pendidikan->setField('PENDIDIKAN_ID', $reqId); 
	$pendidikan->setField('NAMA', $reqNama);
	$pendidikan->setField('KETERANGAN', $reqKeterangan);
	$pendidikan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pendidikan->setField("LAST_UPDATE_DATE", OCI_SYSDATE);			
	if($pendidikan->update())
		echo "Data berhasil disimpan.";
	
}
?>