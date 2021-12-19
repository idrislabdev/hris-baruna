<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/StatusPegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$status_pegawai = new StatusPegawai();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$status_pegawai->setField('NAMA', $reqNama);
	$status_pegawai->setField('KETERANGAN', $reqKeterangan);
	$status_pegawai->setField("LAST_CREATE_USER", $userLogin->nama);
	$status_pegawai->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	if($status_pegawai->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$status_pegawai->setField('STATUS_PEGAWAI_ID', $reqId); 
	$status_pegawai->setField('NAMA', $reqNama);
	$status_pegawai->setField('KETERANGAN', $reqKeterangan);
	$status_pegawai->setField("LAST_UPDATE_USER", $userLogin->nama);
	$status_pegawai->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
	if($status_pegawai->update())
		echo "Data berhasil disimpan.";
	
}
?>