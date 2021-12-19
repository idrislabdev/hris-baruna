<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/BadanUsaha.php");


$badan_usaha = new BadanUsaha();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$badan_usaha->setField('NAMA', $reqNama);
	$badan_usaha->setField('KETERANGAN', $reqKeterangan);
		
	if($badan_usaha->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$badan_usaha->setField('BADAN_USAHA_ID', $reqId); 
	$badan_usaha->setField('NAMA', $reqNama);
	$badan_usaha->setField('KETERANGAN', $reqKeterangan);
		
	if($badan_usaha->update())
		echo "Data berhasil disimpan.";
			
}
?>