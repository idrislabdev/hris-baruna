<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/HubunganKeluarga.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$hubungan_keluarga = new HubunganKeluarga();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");
$reqSubmit = httpFilterPost("reqSubmit");


if($reqMode == "insert")
{
	$hubungan_keluarga->setField("NAMA", $reqNama);
	$hubungan_keluarga->setField("KETERANGAN", $reqKeterangan);
	$hubungan_keluarga->setField("LAST_CREATE_USER", $userLogin->nama);
	$hubungan_keluarga->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	if($hubungan_keluarga->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$hubungan_keluarga->setField("NAMA", $reqNama);
	$hubungan_keluarga->setField("KETERANGAN", $reqKeterangan);
	$hubungan_keluarga->setField("HUBUNGAN_KELUARGA_ID", $reqId);
	$hubungan_keluarga->setField("LAST_UPDATE_USER", $userLogin->nama);
	$hubungan_keluarga->setField("LAST_UPDATE_DATE", OCI_SYSDATE);		
	
	if($hubungan_keluarga->update())
		echo "Data berhasil disimpan.";
	
}
?>