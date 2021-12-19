<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PangkatPerubahanKode.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$pangkat_perubahan_kode = new PangkatPerubahanKode();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$pangkat_perubahan_kode->setField('KODE', $reqKode);
	$pangkat_perubahan_kode->setField('NAMA', $reqNama);
	$pangkat_perubahan_kode->setField('KETERANGAN', $reqKeterangan);
	$pangkat_perubahan_kode->setField("LAST_CREATE_USER", $userLogin->nama);
	$pangkat_perubahan_kode->setField("LAST_CREATE_DATE", OCI_SYSDATE);
	
	if($pangkat_perubahan_kode->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$pangkat_perubahan_kode->setField('PANGKAT_PERUBAHAN_KODE_ID', $reqId); 
	$pangkat_perubahan_kode->setField('KODE', $reqKode);
	$pangkat_perubahan_kode->setField('NAMA', $reqNama);
	$pangkat_perubahan_kode->setField('KETERANGAN', $reqKeterangan);
	$pangkat_perubahan_kode->setField("LAST_UPDATE_USER", $userLogin->nama);
	$pangkat_perubahan_kode->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($pangkat_perubahan_kode->update())
		echo "Data berhasil disimpan.";
	
}
?>