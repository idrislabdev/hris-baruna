<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/SettingAplikasi.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$setting_aplikasi = new SettingAplikasi();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKode= httpFilterPost("reqKode");
$reqNilai= httpFilterPost("reqNilai");
$reqKeterangan= httpFilterPost("reqKeterangan");


if($reqMode == "insert")
{
	$setting_aplikasi->setField('NILAI', $reqNilai);
	$setting_aplikasi->setField('KETERANGAN', $reqKeterangan);
	if($setting_aplikasi->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$setting_aplikasi->setField('KODE_ID', $reqId); 
	$setting_aplikasi->setField('NILAI', $reqNilai);
	$setting_aplikasi->setField('KETERANGAN', $reqKeterangan);
	
	if($setting_aplikasi->update())
		echo "Data berhasil disimpan.";
	
}
?>