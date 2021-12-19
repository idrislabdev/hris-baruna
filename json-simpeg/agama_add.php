<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Agama.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$agama = new Agama();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$agama->setField('NAMA', $reqNama);
	$agama->setField('KETERANGAN', $reqKeterangan);
	$agama->setField("LAST_CREATE_USER", $userLogin->nama);
	$agama->setField("LAST_CREATE_DATE", OCI_SYSDATE);
		
	if($agama->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$agama->setField('AGAMA_ID', $reqId); 
	$agama->setField('NAMA', $reqNama);
	$agama->setField('KETERANGAN', $reqKeterangan);
	$agama->setField("LAST_UPDATE_USER", $userLogin->nama);
	$agama->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($agama->update())
		echo "Data berhasil disimpan.";
	
}
?>